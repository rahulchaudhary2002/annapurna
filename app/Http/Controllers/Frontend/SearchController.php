<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Destination;
use App\Models\TrekRoute;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(): View
    {
        $type     = request('type', 'trekking');
        $search   = request('search', '');
        $budgetMax = request('budget_max');
        $stars    = (array) request('star', []);
        $cats     = (array) request('category', []);

        $results  = collect();
        $total    = 0;

        switch ($type) {
            case 'hotel':
            case 'hotels':
                $q = Business::active()->ofType('hotel')
                    ->withMin('packages as min_price', 'price')
                    ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%"))
                    ->when($budgetMax, fn ($q) => $q->whereHas('packages', fn ($p) => $p->where('price', '<=', $budgetMax))
                        ->orWhereDoesntHave('packages'));
                $paginated = $q->paginate(12)->withQueryString();
                $total = $paginated->total();
                $results = $paginated;
                $resultType = 'business';
                $cardType   = 'HOTEL';
                break;

            case 'restaurant':
            case 'restaurants':
                $q = Business::active()->ofType('restaurant')
                    ->withMin('packages as min_price', 'price')
                    ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%"));
                $paginated = $q->paginate(12)->withQueryString();
                $total = $paginated->total();
                $results = $paginated;
                $resultType = 'business';
                $cardType   = 'RESTAURANT';
                break;

            case 'travel':
            case 'travel-agency':
            case 'vehicle':
                $q = Business::active()->ofType('travel_agency')
                    ->withMin('packages as min_price', 'price')
                    ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%"));
                $paginated = $q->paginate(12)->withQueryString();
                $total = $paginated->total();
                $results = $paginated;
                $resultType = 'business';
                $cardType   = 'AGENCY';
                break;

            case 'destinations':
                $q = Destination::active()
                    ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%")
                        ->orWhere('excerpt', 'like', "%{$search}%")
                        ->orWhere('region', 'like', "%{$search}%"));
                $paginated = $q->paginate(12)->withQueryString();
                $total = $paginated->total();
                $results = $paginated;
                $resultType = 'destination';
                $cardType   = 'DESTINATION';
                break;

            default: // trekking
                $q = TrekRoute::active()
                    ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%")
                        ->orWhere('excerpt', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%"));
                $paginated = $q->paginate(12)->withQueryString();
                $total = $paginated->total();
                $results = $paginated;
                $resultType = 'trek';
                $cardType   = 'TREK';
                break;
        }

        return view('frontend.search.index', compact(
            'results', 'total', 'type', 'search',
            'budgetMax', 'stars', 'cats', 'resultType', 'cardType'
        ));
    }
}
