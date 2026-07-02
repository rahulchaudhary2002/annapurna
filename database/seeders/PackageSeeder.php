<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Package;
use App\Models\PackageInquiry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        PackageInquiry::truncate();
        Package::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $packages = [

            // ─── Meet Nepal Treks ────────────────────────────────────────────────────
            [
                'business_slug'  => 'meet-nepal-treks',
                'name'           => 'Annapurna Base Camp Trek – 13 Days',
                'slug'           => 'abc-trek-13-days-meet-nepal',
                'price'          => 45000,
                'duration'       => '13 Days / 12 Nights',
                'duration_days'  => 13,
                'listing_type'   => 'paid',
                'paid_from'      => now(),
                'paid_until'     => now()->addDays(30),
                'daily_rate'     => 50,
                'is_active'      => true,
                'order'          => 1,
                'photos'         => [$this->seedImage('annapurna/img/destination/annapurna-base-camp-trek.png')],
                'highlights'     => [
                    'Reach Annapurna Base Camp at 4,130 m',
                    'Poon Hill sunrise panorama over Annapurna & Dhaulagiri',
                    'Soak in the natural hot springs at Jhinu Danda',
                    'Walk through lush rhododendron forests',
                    'Visit traditional Gurung villages of Chhomrong',
                    'Close-up view of Machapuchhre (Fishtail Peak)',
                ],
                'itinerary'      => [
                    ['day' => 1, 'title' => 'Arrival in Pokhara',                              'description' => 'Transfer to hotel, trek briefing, evening free to explore Lakeside.'],
                    ['day' => 2, 'title' => 'Drive to Nayapul – Trek to Tikhedhunga (1,540 m)', 'description' => 'Short drive to Nayapul (1.5 hrs), gentle warm-up trek through terraced farmlands.'],
                    ['day' => 3, 'title' => 'Tikhedhunga to Ghorepani (2,850 m)',               'description' => 'Steady climb through dense rhododendron and oak forests with open Himalayan views.'],
                    ['day' => 4, 'title' => 'Poon Hill Sunrise & Trek to Tadapani (2,630 m)',   'description' => 'Early 4 AM ascent to Poon Hill (3,210 m) for sunrise, then descend through forests to Tadapani.'],
                    ['day' => 5, 'title' => 'Tadapani to Chhomrong (2,170 m)',                  'description' => 'Trail crosses Kimrong Khola, arrives at the stone-paved Gurung village of Chhomrong.'],
                    ['day' => 6, 'title' => 'Chhomrong to Himalaya (2,900 m)',                  'description' => 'Descend to Chhomrong Khola and ascend through bamboo and oak forest into the Sanctuary.'],
                    ['day' => 7, 'title' => 'Himalaya to Machapuchhre Base Camp (3,700 m)',     'description' => 'Trail climbs through Deurali, entering the Annapurna Sanctuary with dramatic peak views.'],
                    ['day' => 8, 'title' => 'MBC to Annapurna Base Camp (4,130 m)',             'description' => 'Final push across alpine meadows and moraine — arrive at the amphitheatre of peaks. Afternoon free.'],
                    ['day' => 9, 'title' => 'ABC to Bamboo (2,310 m)',                          'description' => 'Long descend retracing your steps through changing forest zones.'],
                    ['day' => 10, 'title' => 'Bamboo to Jhinu Danda (1,780 m)',                 'description' => 'Descend to the famous natural hot springs — relax tired muscles by the Modi Khola river.'],
                    ['day' => 11, 'title' => 'Jhinu Danda to Nayapul – Drive to Pokhara',       'description' => 'Last trekking day through riverside villages, then drive back to Pokhara.'],
                    ['day' => 12, 'title' => 'Pokhara Sightseeing & Rest',                      'description' => 'Relaxed day: Phewa Lake boat ride, Davis Falls, World Peace Pagoda — optional paragliding.'],
                    ['day' => 13, 'title' => 'Departure',                                       'description' => 'Transfer to airport or bus park for your onward journey.'],
                ],
                'faqs'           => [
                    ['question' => 'What is the best season?',            'answer' => 'March–May (spring) and September–November (autumn) offer the clearest skies and most stable weather.'],
                    ['question' => 'Do I need a guide?',                  'answer' => 'A licensed guide is included in this package. Guides are mandatory in the Annapurna Conservation Area.'],
                    ['question' => 'Are permits included?',               'answer' => 'Yes — ACAP (Annapurna Conservation Area Permit) and TIMS card are included in the package price.'],
                    ['question' => 'What fitness level is required?',     'answer' => 'Moderate fitness is sufficient. You should be comfortable walking 5–7 hours per day over hilly terrain.'],
                    ['question' => 'Is altitude sickness a risk?',        'answer' => 'The maximum altitude is 4,130 m. Proper acclimatization is built into the itinerary. Carry Diamox if advised by your doctor.'],
                    ['question' => 'What is included in the price?',      'answer' => 'Guide, porter (if requested), ACAP + TIMS permits, all accommodation (teahouse), and three meals a day on trek.'],
                ],
                'map_embed'      => '<iframe src="https://maps.google.com/maps?q=Annapurna+Base+Camp,+Nepal&output=embed" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
                'meta_title'     => 'Annapurna Base Camp Trek 13 Days | Meet Nepal Treks',
                'meta_description' => 'Book the iconic Annapurna Base Camp Trek (13 days) with Meet Nepal Treks. Includes guide, permits, and teahouse accommodation from Rs. 45,000.',
            ],

            [
                'business_slug'  => 'meet-nepal-treks',
                'name'           => 'Poon Hill Sunrise Trek – 5 Days',
                'slug'           => 'poon-hill-trek-5-days-meet-nepal',
                'price'          => 18000,
                'duration'       => '5 Days / 4 Nights',
                'duration_days'  => 5,
                'listing_type'   => 'free',
                'is_active'      => true,
                'order'          => 2,
                'photos'         => [$this->seedImage('annapurna/img/tours/poon-hill.jpg')],
                'highlights'     => [
                    'Poon Hill (3,210 m) sunrise — top Himalayan panorama in Nepal',
                    'Views of Annapurna I, Annapurna South, Dhaulagiri, and Machapuchhre',
                    'Dense rhododendron forests in bloom (March–April)',
                    'Traditional Gurung villages of Ghorepani and Ulleri',
                    'Short, accessible trek — ideal for beginners and families',
                ],
                'itinerary'      => [
                    ['day' => 1, 'title' => 'Pokhara to Nayapul – Trek to Tikhedhunga (1,540 m)', 'description' => 'Drive 1.5 hrs to Nayapul, begin trekking through traditional villages along the Modi Khola river.'],
                    ['day' => 2, 'title' => 'Tikhedhunga to Ghorepani (2,850 m)',                  'description' => 'Climb the famous stone staircase of Ulleri, then through oak and rhododendron forest to Ghorepani.'],
                    ['day' => 3, 'title' => 'Poon Hill Sunrise – Trek to Tadapani',                'description' => 'Rise at 4 AM for the iconic Poon Hill sunrise over 8,000 m peaks. Descend via Banthanti to Tadapani.'],
                    ['day' => 4, 'title' => 'Tadapani to Nayapul – Drive to Pokhara',              'description' => 'Descent through Kimche and Birethanti back to Nayapul, then drive back to Pokhara.'],
                    ['day' => 5, 'title' => 'Departure from Pokhara',                              'description' => 'Transfer to airport or bus station for onward travel.'],
                ],
                'faqs'           => [
                    ['question' => 'Is this suitable for first-time trekkers?', 'answer' => 'Absolutely. The Poon Hill trek is rated Easy–Moderate and is Nepal\'s most popular short trek for beginners.'],
                    ['question' => 'What months are best?',                     'answer' => 'March–May for rhododendron blooms. October–November for clear mountain views. December–January is cold but clear.'],
                    ['question' => 'How many hours per day is the walking?',    'answer' => 'Between 4 and 6 hours per day on well-marked trails with teahouse stops along the way.'],
                    ['question' => 'Is accommodation included?',                'answer' => 'Yes, teahouse accommodation and 3 meals per day are included throughout the trek.'],
                ],
                'meta_title'     => 'Poon Hill Sunrise Trek 5 Days | Meet Nepal Treks',
                'meta_description' => 'Easy 5-day Poon Hill trek with sunrise panorama over Annapurna & Dhaulagiri. Perfect for beginners. Starts from Rs. 18,000.',
            ],

            // ─── Adventure Treks Nepal ───────────────────────────────────────────────
            [
                'business_slug'  => 'adventure-treks-nepal',
                'name'           => 'Annapurna Circuit Trek – 14 Days',
                'slug'           => 'annapurna-circuit-14-days-adventure-treks',
                'price'          => 55000,
                'duration'       => '14 Days / 13 Nights',
                'duration_days'  => 14,
                'listing_type'   => 'paid',
                'paid_from'      => now(),
                'paid_until'     => now()->addDays(45),
                'daily_rate'     => 50,
                'is_active'      => true,
                'order'          => 1,
                'photos'         => [$this->seedImage('annapurna/img/tours/adventure-treks-nepal-annapurna-region.jpg')],
                'highlights'     => [
                    'Cross the legendary Thorong La Pass (5,416 m)',
                    'Sacred Muktinath Temple — revered by both Hindus and Buddhists',
                    'Kali Gandaki Gorge — deepest gorge in the world',
                    'Manang valley and Tibetan-influenced high-altitude culture',
                    'Marpha village — famous for apple orchards and brandy',
                    'Diverse landscapes: subtropical to high-altitude alpine desert',
                    'Optional side trip to Tilicho Lake (4,919 m)',
                ],
                'itinerary'      => [
                    ['day' => 1,  'title' => 'Arrival in Besisahar – drive to Chame (2,670 m)',         'description' => 'Drive from Kathmandu or Pokhara to Besisahar, continue by jeep to Chame through the deep Marsyangdi valley.'],
                    ['day' => 2,  'title' => 'Chame to Pisang (3,300 m)',                               'description' => 'Trek past dramatic rocky cliffs and the Paungda Danda rock face to Upper Pisang with first views of Annapurna II.'],
                    ['day' => 3,  'title' => 'Pisang to Manang (3,519 m)',                              'description' => 'Enter the wide Manang valley with stunning mountain panoramas. Visit Bhraka and Ghyaru for altitude views.'],
                    ['day' => 4,  'title' => 'Manang – Acclimatization Day',                            'description' => 'Rest day in Manang. Hike to Gangapurna Lake or Ice Lake for acclimatization. Altitude medicine briefing.'],
                    ['day' => 5,  'title' => 'Manang to Yak Kharka (4,018 m)',                          'description' => 'Short but important altitude gain. Pass through yak pastures with Annapurna III views.'],
                    ['day' => 6,  'title' => 'Yak Kharka to Thorong Phedi (4,525 m)',                   'description' => 'Arrive at the base camp for tomorrow\'s crucial pass crossing. Rest and prepare.'],
                    ['day' => 7,  'title' => 'Thorong La Pass (5,416 m) – Muktinath (3,800 m)',         'description' => 'Start at 4–5 AM. Summit the highest point of the circuit. Descend to the sacred Muktinath Temple.'],
                    ['day' => 8,  'title' => 'Muktinath to Marpha (2,670 m)',                           'description' => 'Walk along the Kali Gandaki valley, stopping in Jomsom. Arrive in Marpha, famous for its apple products.'],
                    ['day' => 9,  'title' => 'Marpha to Tatopani (1,190 m)',                            'description' => 'Long descent through Ghasa and Rupse waterfall to the hot spring town of Tatopani.'],
                    ['day' => 10, 'title' => 'Tatopani to Ghorepani (2,850 m)',                         'description' => 'Climb through Shikha and rhododendron forests to Ghorepani, the gateway to Poon Hill.'],
                    ['day' => 11, 'title' => 'Poon Hill Sunrise – Trek to Nayapul – Drive to Pokhara', 'description' => 'Early sunrise hike to Poon Hill (3,210 m), then descend via Birethanti to Nayapul and drive to Pokhara.'],
                    ['day' => 12, 'title' => 'Pokhara Sightseeing',                                     'description' => 'Explore Pokhara\'s highlights: Phewa Lake, Davis Falls, Gupteshwor Cave, World Peace Pagoda.'],
                    ['day' => 13, 'title' => 'Free Day in Pokhara',                                     'description' => 'Optional activities: paragliding, kayaking, mountain biking, or visit the International Mountain Museum.'],
                    ['day' => 14, 'title' => 'Departure',                                               'description' => 'Transfer to Pokhara airport or bus park for onward journey.'],
                ],
                'faqs'           => [
                    ['question' => 'How difficult is Thorong La Pass?',        'answer' => 'The pass at 5,416 m requires stamina. Start by 4–5 AM to avoid afternoon winds. Proper acclimatization in Manang is essential.'],
                    ['question' => 'Is the route affected by road construction?', 'answer' => 'Road construction in the lower Marsyangdi valley means most trekkers now start from Chame by jeep. We manage logistics accordingly.'],
                    ['question' => 'Do you provide altitude sickness support?', 'answer' => 'Our guides carry a pulse oximeter and first aid. We include a mandatory acclimatization day in Manang.'],
                    ['question' => 'What permits are required?',               'answer' => 'ACAP (Annapurna Conservation Area Permit) and TIMS card are included. Restricted area permits (if applicable) are extra.'],
                    ['question' => 'Can the trek be shortened?',               'answer' => 'Yes — flights from Jomsom to Pokhara (weather permitting) can shorten the circuit to 10–11 days.'],
                ],
                'map_embed'      => '<iframe src="https://maps.google.com/maps?q=Thorong+La+Pass,+Nepal&output=embed" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
                'meta_title'     => 'Annapurna Circuit Trek 14 Days | Adventure Treks Nepal',
                'meta_description' => 'Complete the legendary Annapurna Circuit (14 days) including Thorong La Pass, Muktinath, and Poon Hill. From Rs. 55,000 with Adventure Treks Nepal.',
            ],

            [
                'business_slug'  => 'adventure-treks-nepal',
                'name'           => 'Pokhara City Day Tour',
                'slug'           => 'pokhara-city-day-tour-adventure-treks',
                'price'          => 3500,
                'duration'       => '1 Day',
                'duration_days'  => 1,
                'listing_type'   => 'free',
                'is_active'      => true,
                'order'          => 2,
                'photos'         => [$this->seedImage('annapurna/img/tours/aca.jpg')],
                'highlights'     => [
                    'Phewa Lake boating and Tal Barahi Temple',
                    'Davis Falls (Patale Chhango) — dramatic underground waterfall',
                    'Gupteshwor Mahadev Cave — sacred cave shrine',
                    'World Peace Pagoda — hilltop Buddhist stupa',
                    'Seti River Gorge — narrow canyon in the city',
                    'Bindhyabasini Temple — Pokhara\'s main Hindu temple',
                ],
                'itinerary'      => [
                    ['day' => 1, 'title' => 'Full-Day Pokhara Sightseeing Tour', 'description' => 'Morning pickup from hotel. Visit Bindhyabasini Temple, Seti River Gorge, International Mountain Museum, Davis Falls, Gupteshwor Cave, Devi\'s Falls, and the World Peace Pagoda. Afternoon boat ride on Phewa Lake to Tal Barahi Temple. Return to hotel by 5 PM.'],
                ],
                'faqs'           => [
                    ['question' => 'What is included in the day tour?',          'answer' => 'Comfortable car/van with driver, English-speaking guide, museum entrance fees, and Phewa Lake boat ride.'],
                    ['question' => 'How many sites are visited?',                'answer' => 'Approximately 6–8 sites in a full day, at a relaxed pace with photo stops.'],
                    ['question' => 'Is the tour suitable for elderly travelers?', 'answer' => 'Yes — all sites are accessible and the pace is comfortable for all age groups.'],
                    ['question' => 'What time does the tour start?',             'answer' => 'Hotel pickup between 9:00–9:30 AM. Tour ends around 5:00 PM.'],
                ],
                'meta_title'     => 'Pokhara City Day Tour | Adventure Treks Nepal',
                'meta_description' => 'Explore Pokhara\'s must-see highlights in one full day — lakes, waterfalls, caves, temples, and mountain views. From Rs. 3,500.',
            ],

            // ─── Nepal Hiking Team ────────────────────────────────────────────────────
            [
                'business_slug'  => 'nepal-hiking-team',
                'name'           => 'Mardi Himal Trek – 7 Days',
                'slug'           => 'mardi-himal-trek-7-days-nepal-hiking-team',
                'price'          => 28000,
                'duration'       => '7 Days / 6 Nights',
                'duration_days'  => 7,
                'listing_type'   => 'paid',
                'paid_from'      => now()->addDays(5),
                'paid_until'     => now()->addDays(35),
                'daily_rate'     => 50,
                'is_active'      => true,
                'order'          => 1,
                'photos'         => [$this->seedImage('annapurna/img/tours/nepal-hiking-team.jpg')],
                'highlights'     => [
                    'Mardi Himal High Camp at 4,500 m with close-up Machapuchhre views',
                    'Less crowded — peaceful alternative to the ABC trek',
                    'Panoramic views of Annapurna South, Hiunchuli, and Mardi Himal',
                    'Dense bamboo and rhododendron forest zones',
                    'Traditional Gurung village of Siding',
                    'Return via the Sanctuary region',
                ],
                'itinerary'      => [
                    ['day' => 1, 'title' => 'Pokhara to Kande – Trek to Australian Camp (2,060 m)', 'description' => 'Short drive to Kande, then gentle walk through forests to Australian Camp with Annapurna views.'],
                    ['day' => 2, 'title' => 'Australian Camp to Forest Camp (2,520 m)',              'description' => 'Trail enters dense rhododendron and bamboo forests. Gradually gaining altitude through moss-covered paths.'],
                    ['day' => 3, 'title' => 'Forest Camp to Low Camp (3,060 m)',                    'description' => 'Steeper terrain above the treeline with expanding Himalayan panoramas.'],
                    ['day' => 4, 'title' => 'Low Camp to High Camp (4,500 m)',                      'description' => 'Above the clouds — dramatic views of Machapuchhre dominate. Arrive at High Camp.'],
                    ['day' => 5, 'title' => 'High Camp to Siding Village (1,700 m)',                'description' => 'Optional early morning viewpoint hike, then descend through forests to the Gurung village of Siding.'],
                    ['day' => 6, 'title' => 'Siding to Lumre – Drive to Pokhara',                   'description' => 'Short final descent to Lumre on the Pokhara–Baglung highway, then drive back to Pokhara.'],
                    ['day' => 7, 'title' => 'Departure',                                             'description' => 'Transfer to airport or bus park.'],
                ],
                'faqs'           => [
                    ['question' => 'How does Mardi Himal compare to ABC?',        'answer' => 'Mardi Himal is shorter, less crowded, and offers equally stunning Machapuchhre views — ideal for those with limited time.'],
                    ['question' => 'Is a guide compulsory on this route?',        'answer' => 'A guide is recommended as the route is less marked than ABC. Our guide service is included.'],
                    ['question' => 'What are accommodation facilities like?',     'answer' => 'Tea houses are basic but comfortable at lower elevations. High Camp accommodation is simpler — sleeping bags advised.'],
                    ['question' => 'Can we do this trek solo without a porter?',  'answer' => 'Yes. The trail is manageable with a daypack and guide. Porter service is optional (add-on).'],
                ],
                'meta_title'     => 'Mardi Himal Trek 7 Days | Nepal Hiking Team',
                'meta_description' => 'Discover the hidden Mardi Himal trek — 7 days to 4,500 m with Machapuchhre views and peaceful forest trails. From Rs. 28,000.',
            ],

            // ─── Explore Himalaya ────────────────────────────────────────────────────
            [
                'business_slug'  => 'explore-himalaya',
                'name'           => 'Ghorepani–ABC Combo Trek – 16 Days',
                'slug'           => 'ghorepani-abc-combo-16-days-explore-himalaya',
                'price'          => 62000,
                'duration'       => '16 Days / 15 Nights',
                'duration_days'  => 16,
                'listing_type'   => 'free',
                'is_active'      => true,
                'order'          => 1,
                'photos'         => [$this->seedImage('annapurna/img/tours/explore-himalaya-annapurna-region.jpg')],
                'highlights'     => [
                    'Best of both worlds — Poon Hill sunrise AND Annapurna Base Camp',
                    'Thorough cultural immersion across Gurung and Magar villages',
                    'Rhododendron forests, subtropical valleys, and alpine glacier views',
                    'Hot springs at Jhinu Danda on the way back',
                    'Machapuchhre Base Camp views at 3,700 m',
                    'Ideal for trekkers wanting a full Annapurna region experience',
                ],
                'itinerary'      => [
                    ['day' => 1,  'title' => 'Arrive Pokhara — Trek briefing',                           'description' => 'Hotel transfer, gear check, permit collection, briefing with guide.'],
                    ['day' => 2,  'title' => 'Drive to Nayapul – Trek to Tikhedhunga (1,540 m)',          'description' => 'Start the trek through terraced farmland and riverside villages.'],
                    ['day' => 3,  'title' => 'Tikhedhunga to Ghorepani (2,850 m)',                        'description' => 'Ascend the Ulleri staircase through rhododendron forest.'],
                    ['day' => 4,  'title' => 'Poon Hill Sunrise – Trek to Tadapani (2,630 m)',            'description' => 'Pre-dawn Poon Hill hike, then descend through Banthanti to Tadapani.'],
                    ['day' => 5,  'title' => 'Tadapani to Chhomrong (2,170 m)',                           'description' => 'Cross Kimrong Khola, enter the traditional Gurung village of Chhomrong.'],
                    ['day' => 6,  'title' => 'Chhomrong to Himalaya (2,900 m)',                           'description' => 'Through the lower Annapurna Sanctuary gate, bamboo and oak forest.'],
                    ['day' => 7,  'title' => 'Himalaya to Deurali (3,230 m)',                             'description' => 'Climb steadily through changing alpine zones with peak views appearing.'],
                    ['day' => 8,  'title' => 'Deurali to Machapuchhre Base Camp (3,700 m)',               'description' => 'Enter the upper sanctuary; Fishtail Peak towers directly ahead.'],
                    ['day' => 9,  'title' => 'MBC to Annapurna Base Camp (4,130 m)',                      'description' => 'Final ascent to the 360° mountain amphitheatre. Afternoon exploration.'],
                    ['day' => 10, 'title' => 'ABC – acclimatization and exploration',                     'description' => 'Extra day to fully experience ABC — sunrise, glacier walks, photography.'],
                    ['day' => 11, 'title' => 'ABC to Dovan (2,600 m)',                                    'description' => 'Begin long descent back through the sanctuary.'],
                    ['day' => 12, 'title' => 'Dovan to Jhinu Danda (1,780 m)',                            'description' => 'Descend to the hot springs. Evening soak after 11 days of trekking.'],
                    ['day' => 13, 'title' => 'Jhinu Danda to Nayapul — Drive to Pokhara',                'description' => 'Final trekking day through riverside villages, then drive to Pokhara.'],
                    ['day' => 14, 'title' => 'Pokhara — rest, Phewa Lake, optional paragliding',          'description' => 'Day at leisure to recover and enjoy the lakeside.'],
                    ['day' => 15, 'title' => 'Sarangkot sunrise — free afternoon',                       'description' => 'Early drive to Sarangkot viewpoint for Himalayan sunrise, afternoon shopping.'],
                    ['day' => 16, 'title' => 'Departure',                                                 'description' => 'Transfer to Pokhara airport or bus park.'],
                ],
                'faqs'           => [
                    ['question' => 'Why do the Ghorepani and ABC routes together?',  'answer' => 'Combining both routes lets you experience the Poon Hill panorama AND the ABC sanctuary without backtracking — the most rewarding full Annapurna itinerary.'],
                    ['question' => 'Can the itinerary be shortened?',               'answer' => 'Yes — the Poon Hill section can be skipped to reduce by 3 days, or the extra ABC day removed.'],
                    ['question' => 'Is this good for photography?',                  'answer' => 'Exceptional. You capture Poon Hill sunrise, rhododendron forest, Machapuchhre up close, and the ABC panorama — the full range of Annapurna landscapes.'],
                    ['question' => 'What is the maximum group size?',               'answer' => 'Groups are kept to a maximum of 12 trekkers for a quality experience. Private groups available on request.'],
                ],
                'meta_title'     => 'Ghorepani + Annapurna Base Camp Combo Trek 16 Days | Explore Himalaya',
                'meta_description' => 'The ultimate Annapurna region trek: Poon Hill sunrise + ABC in 16 days. From Rs. 62,000 with Explore Himalaya.',
            ],

            // ─── Aim Way Tours & Travels ──────────────────────────────────────────────
            [
                'business_slug'  => 'aim-way-tours-travels',
                'name'           => 'Annapurna Panorama Trek – 6 Days',
                'slug'           => 'annapurna-panorama-trek-6-days-aim-way',
                'price'          => 22000,
                'duration'       => '6 Days / 5 Nights',
                'duration_days'  => 6,
                'listing_type'   => 'paid',
                'paid_from'      => now()->addDays(2),
                'paid_until'     => now()->addDays(32),
                'daily_rate'     => 50,
                'is_active'      => true,
                'order'          => 1,
                'photos'         => [$this->seedImage('annapurna/img/tours/aim-way-annapurna-region.jpg')],
                'highlights'     => [
                    'Panoramic views of Annapurna, Dhaulagiri, Manaslu, and Machhapuchhre',
                    'Short and rewarding trek — perfect for time-limited travellers',
                    'Poon Hill (3,210 m) — one of Nepal\'s finest viewpoints',
                    'Authentic Gurung and Magar village homestay experience',
                    'Guided with licensed, experienced local trekking guide',
                ],
                'itinerary'      => [
                    ['day' => 1, 'title' => 'Pokhara to Nayapul – Trek to Hile (1,430 m)',  'description' => 'Drive to Nayapul, short trek to Hile through Modi Khola gorge.'],
                    ['day' => 2, 'title' => 'Hile to Ghorepani (2,850 m)',                   'description' => 'Ascend through Ulleri, dense rhododendron forest to the hilltop village of Ghorepani.'],
                    ['day' => 3, 'title' => 'Poon Hill Sunrise – Trek to Tadapani',          'description' => 'Sunrise over the Annapurna and Dhaulagiri ranges from Poon Hill, then trek to Tadapani.'],
                    ['day' => 4, 'title' => 'Tadapani to Ghandruk (1,940 m)',               'description' => 'Descend to the large Gurung village of Ghandruk with cultural museum and panoramic views.'],
                    ['day' => 5, 'title' => 'Ghandruk to Nayapul – Drive to Pokhara',       'description' => 'Final descent to Birethanti and Nayapul, then drive back to Pokhara.'],
                    ['day' => 6, 'title' => 'Departure from Pokhara',                        'description' => 'Transfer to airport or bus station.'],
                ],
                'faqs'           => [
                    ['question' => 'Is this the same as the Poon Hill trek?',         'answer' => 'Similar but with a different return route via Ghandruk — offering more village cultural experience.'],
                    ['question' => 'What is included?',                               'answer' => 'Licensed guide, ACAP permit, TIMS card, teahouse accommodation, and 3 meals per day on trek.'],
                    ['question' => 'Can I extend this trek to Annapurna Base Camp?', 'answer' => 'Yes — this route connects directly to the ABC trail from Chhomrong. Let us know and we\'ll create a custom itinerary.'],
                ],
                'meta_title'     => 'Annapurna Panorama Trek 6 Days | Aim Way Tours',
                'meta_description' => '6-day Annapurna Panorama trek from Pokhara including Poon Hill sunrise and Ghandruk village. From Rs. 22,000.',
            ],

        ];

        foreach ($packages as $data) {
            $business = Business::where('slug', $data['business_slug'])->first();

            if (!$business) {
                $this->command->warn("Business not found: {$data['business_slug']} — skipping package \"{$data['name']}\"");
                continue;
            }

            unset($data['business_slug']);
            $data['business_id'] = $business->id;

            Package::create($data);
            $this->command->line("  <fg=green>✓</> {$data['name']} → {$business->name}");
        }

        $this->command->info('Packages seeded! (' . count($packages) . ' packages)');
    }

    /**
     * Copy a public theme image into storage so it's accessible via asset('storage/...').
     * Source: public/{publicPath}
     * Dest:   storage/app/public/seeded/{publicPath}
     */
    private function seedImage(string $publicPath): ?string
    {
        $sourcePath = public_path($publicPath);
        $relative   = 'seeded/' . ltrim($publicPath, '/');
        $destPath   = storage_path('app/public/' . $relative);

        if (file_exists($sourcePath)) {
            $dir = dirname($destPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            copy($sourcePath, $destPath);
            return $relative;
        }

        return null;
    }
}
