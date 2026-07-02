<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleRedirects
{
    public function handle(Request $request, Closure $next): Response
    {
        $path = '/' . ltrim($request->getPathInfo(), '/');

        $redirect = Redirect::active()->where('from_url', $path)->first();

        if ($redirect) {
            $redirect->increment('hit_count');
            return redirect($redirect->to_url, $redirect->type);
        }

        return $next($request);
    }
}
