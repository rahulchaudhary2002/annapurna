<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // ── General ───────────────────────────────────────────────────────────
            ['group' => 'general', 'key' => 'site_name',    'label' => 'Site Name', 'value' => 'Annapurna Region',                                   'type' => 'text',  'order' => 1],
            ['group' => 'general', 'key' => 'site_tagline', 'label' => 'Tagline',   'value' => 'All About Trekking, Tour and Travel at Annapurna Region', 'type' => 'text', 'order' => 2],
            ['group' => 'general', 'key' => 'site_logo',    'label' => 'Logo',      'value' => null,                                                   'type' => 'image', 'order' => 3],
            ['group' => 'general', 'key' => 'site_favicon', 'label' => 'Favicon',   'value' => null,                                                   'type' => 'image', 'order' => 4],

            // ── Contact ───────────────────────────────────────────────────────────
            ['group' => 'contact', 'key' => 'contact_address', 'label' => 'Address',              'value' => 'Anamnagar, Kathmandu, Nepal',   'type' => 'text',  'order' => 1],
            ['group' => 'contact', 'key' => 'contact_phone',   'label' => 'Phone',                'value' => '+977-9828012457',               'type' => 'text',  'order' => 2],
            ['group' => 'contact', 'key' => 'contact_email',   'label' => 'Email',                'value' => 'info@annapurnaregion.com',      'type' => 'email', 'order' => 3],
            ['group' => 'contact', 'key' => 'contact_hours',   'label' => 'Working Hours',        'value' => 'Sun-Fri, 10am - 5pm',          'type' => 'text',  'order' => 4],
            ['group' => 'contact', 'key' => 'contact_map_url', 'label' => 'Google Maps Embed URL','value' => null,                           'type' => 'url',   'order' => 5],

            // ── Social ────────────────────────────────────────────────────────────
            ['group' => 'contact', 'key' => 'social_facebook',  'label' => 'Facebook URL',  'value' => null, 'type' => 'url', 'order' => 10],
            ['group' => 'contact', 'key' => 'social_twitter',   'label' => 'Twitter URL',   'value' => null, 'type' => 'url', 'order' => 11],
            ['group' => 'contact', 'key' => 'social_instagram', 'label' => 'Instagram URL', 'value' => null, 'type' => 'url', 'order' => 12],
            ['group' => 'contact', 'key' => 'social_linkedin',  'label' => 'LinkedIn URL',  'value' => null, 'type' => 'url', 'order' => 13],
            ['group' => 'contact', 'key' => 'social_youtube',   'label' => 'YouTube URL',   'value' => null, 'type' => 'url', 'order' => 14],

            // ── SEO ───────────────────────────────────────────────────────────────
            ['group' => 'seo', 'key' => 'meta_title',       'label' => 'Default Meta Title',       'value' => 'Annapurna Region | All about trekking, tour and travel at Annapurna Region', 'type' => 'text',     'order' => 1],
            ['group' => 'seo', 'key' => 'meta_description', 'label' => 'Default Meta Description', 'value' => 'Discover trekking, tours, and travel experiences in the Annapurna region. Plan your adventure with complete guides and travel insights.',                                'type' => 'textarea', 'order' => 2],
            ['group' => 'seo', 'key' => 'google_analytics', 'label' => 'Google Analytics ID',      'value' => 'G-BBQ0E4NBZ6',                                                                                                                                                          'type' => 'text',     'order' => 3],

            // ── Home – Hero ───────────────────────────────────────────────────────
            ['group' => 'home', 'key' => 'home_hero_subtitle', 'label' => 'Hero – Subtitle',    'value' => 'Trekking Paradise, Cultural Diversity | Panoramic View', 'type' => 'text', 'order' => 10],
            ['group' => 'home', 'key' => 'home_hero_title',    'label' => 'Hero – Title',       'value' => 'Explore Life at',                                        'type' => 'text', 'order' => 11],
            ['group' => 'home', 'key' => 'home_hero_span',     'label' => 'Hero – Title Span',  'value' => 'Annapurna',                                              'type' => 'text', 'order' => 12],

            // ── Home – About ──────────────────────────────────────────────────────
            ['group' => 'home', 'key' => 'home_about_subtitle',     'label' => 'About – Subtitle',     'value' => 'Annapurna Region – A Lifetime Experience', 'type' => 'text',     'order' => 20],
            ['group' => 'home', 'key' => 'home_about_title',        'label' => 'About – Title',        'value' => 'Discover',                                 'type' => 'text',     'order' => 21],
            ['group' => 'home', 'key' => 'home_about_span',         'label' => 'About – Title Span',   'value' => 'Annapurna',                                'type' => 'text',     'order' => 22],
            ['group' => 'home', 'key' => 'home_about_circle_text',  'label' => 'About – Circle Text',  'value' => '. Annapurna Region . Annapurna Circuit',   'type' => 'text',     'order' => 23],
            ['group' => 'home', 'key' => 'home_about_body', 'label' => 'About – Body HTML', 'type' => 'textarea', 'order' => 24,
                'value' => '<p style="text-align:justify">The <b>Annapurna Region</b> in central Nepal is one of the world\'s most renowned destinations for trekking, known for its panoramic mountain views, living cultures, and diverse adventure experiences.</p>'
                    . '<p style="text-align:justify">Anchored by <a href="/trek-routes/pokhara-city-tours"><b>Pokhara</b></a>, the main gateway to Annapurna—travelers are welcomed by the calm waters of Phewa Lake, where clear mornings often reflect the Annapurna range and Machapuchare (Fishtail), creating one of Nepal\'s most iconic Himalayan landscapes.</p>'
                    . '<p style="text-align:justify">The region is home to Tilicho Lake, among the highest lakes in the world, offering a truly memorable experience for high-altitude trekkers. Classic routes such as the <a href="/trek-routes/annapurna-circuit-trek">Annapurna Circuit Trek</a> and <a href="/trek-routes/annapurna-base-camp-trek">Annapurna Base Camp (ABC) Trek</a> are internationally recognized for their variety of terrain, passing through subtropical forests, terraced farmlands, alpine meadows, and high mountain deserts. These trails provide close-up views of Annapurna I, Dhaulagiri, and the sacred peak Machapuchare.</p>'
                    . '<p style="text-align:justify">Beyond trekking, the Annapurna Region offers rich cultural and natural diversity. From traditional village walks in Ghandruk and Manang, where Gurung and Magar cultures are still practiced, to adventure activities like paragliding in Pokhara and sunrise viewpoints at Sarangkot, the region balances both adventure and tranquility. As part of the Annapurna Conservation Area, it also supports remarkable biodiversity, including rare flora and wildlife found across different altitude zones.</p>',
            ],

            // ── Home – Popular Destinations ───────────────────────────────────────
            ['group' => 'home', 'key' => 'home_destinations_subtitle',  'label' => 'Destinations – Subtitle',    'value' => 'Choose your place', 'type' => 'text', 'order' => 30],
            ['group' => 'home', 'key' => 'home_destinations_title',     'label' => 'Destinations – Title',       'value' => 'Popular',           'type' => 'text', 'order' => 31],
            ['group' => 'home', 'key' => 'home_destinations_span',      'label' => 'Destinations – Title Span',  'value' => 'Destinations',      'type' => 'text', 'order' => 32],
            ['group' => 'home', 'key' => 'home_featured_reviews',       'label' => 'Destinations – Review Text', 'value' => '0 Reviews',         'type' => 'text', 'order' => 33],

            // ── Home – Numbers / Stats ────────────────────────────────────────────
            ['group' => 'home', 'key' => 'home_stats_bg', 'label' => 'Stats – Background Image', 'value' => null, 'type' => 'image', 'order' => 40],

            // ── Home – Activities (Most Popular) ──────────────────────────────────
            ['group' => 'home', 'key' => 'home_activities_subtitle', 'label' => 'Activities – Subtitle',    'value' => 'Most Popular Activities', 'type' => 'text', 'order' => 50],
            ['group' => 'home', 'key' => 'home_activities_span',     'label' => 'Activities – Title Span',  'value' => 'Annapurna',               'type' => 'text', 'order' => 51],
            ['group' => 'home', 'key' => 'home_activities_title',    'label' => 'Activities – Title',       'value' => 'Region',                  'type' => 'text', 'order' => 52],

            // ── Home – Trekking ───────────────────────────────────────────────────
            ['group' => 'home', 'key' => 'home_trekking_title', 'label' => 'Trekking – Section Title', 'value' => 'Trekking in Nepal', 'type' => 'text', 'order' => 60],
            ['group' => 'home', 'key' => 'home_trekking_btn',   'label' => 'Trekking – Button Text',   'value' => 'All Treks',         'type' => 'text', 'order' => 61],
            ['group' => 'home', 'key' => 'home_trekking_intro', 'label' => 'Trekking – Intro HTML', 'type' => 'textarea', 'order' => 62,
                'value' => '<p><b>The Annapurna Region heaven for trekker\'s.</b></p>'
                    . '<p>It has some of Nepal\'s most iconic trails from the magnificent peaks of <b>Annapurna</b> and <b>Machapuchare</b> to the beautiful landscapes that vary from lush forests to arid deserts and breathtaking beauty with cultural immersion.</p>'
                    . '<p><b>Beginners to expert</b>, every trekkers have something in the Annapurna Region, some popular treks are listed below.</p>',
            ],

            // ── Home – Mountaineering ─────────────────────────────────────────────
            ['group' => 'home', 'key' => 'home_mountaineering_title', 'label' => 'Mountaineering – Section Title', 'value' => 'Mountaineering and Expedition in Nepal', 'type' => 'text', 'order' => 70],
            ['group' => 'home', 'key' => 'home_mountaineering_btn',   'label' => 'Mountaineering – Button Text',   'value' => 'All Mountaineering / Expedition',        'type' => 'text', 'order' => 71],
            ['group' => 'home', 'key' => 'home_mountaineering_intro', 'label' => 'Mountaineering – Intro HTML', 'type' => 'textarea', 'order' => 72,
                'value' => '<p>The Annapurna Region is a best for mountaineering enthusiasts.</p>'
                    . '<p><b>Annapurna I (8,091 m), is respected in the world as the first 8,000-meter peak ever climbed.</b> This region posses some of the most challenging and rewarding peaks with expedition friendly peaks like Tent Peak and Singhu Chuli for technical challenges.</p>'
                    . '<p>Variety in technical climbs and accessible peaks alike makes the <b>Annapurna Region a haven for mountaineers</b>.</p>',
            ],
            ['group' => 'home', 'key' => 'home_mountaineering_list_left',  'label' => 'Mountaineering – Left List (pipe-separated)',  'value' => 'Annapurna I|Machapuchare (6,993 m)|Tent Peak (5,695 m)',         'type' => 'textarea', 'order' => 73],
            ['group' => 'home', 'key' => 'home_mountaineering_list_right', 'label' => 'Mountaineering – Right List (pipe-separated)', 'value' => 'Singu Chuli (6,501 m)|Pisang Peak (6,091 m)|Annapurna South (7,219 m)', 'type' => 'textarea', 'order' => 74],

            // Mountaineering carousel items
            ['group' => 'home', 'key' => 'home_expedition1_name',     'label' => 'Expedition Carousel 1 – Name',     'value' => 'Machapuchare Trek',  'type' => 'text', 'order' => 75],
            ['group' => 'home', 'key' => 'home_expedition1_price',    'label' => 'Expedition Carousel 1 – Price',    'value' => '$1,250 - $2,500',    'type' => 'text', 'order' => 76],
            ['group' => 'home', 'key' => 'home_expedition1_duration', 'label' => 'Expedition Carousel 1 – Duration', 'value' => '7 - 14 Days',        'type' => 'text', 'order' => 77],
            ['group' => 'home', 'key' => 'home_expedition1_group',    'label' => 'Expedition Carousel 1 – Group',    'value' => '12+',                'type' => 'text', 'order' => 78],
            ['group' => 'home', 'key' => 'home_expedition2_name',     'label' => 'Expedition Carousel 2 – Name',     'value' => 'Pisang Peak Trek',   'type' => 'text', 'order' => 79],
            ['group' => 'home', 'key' => 'home_expedition2_price',    'label' => 'Expedition Carousel 2 – Price',    'value' => '$1,500 - $2,500',    'type' => 'text', 'order' => 80],
            ['group' => 'home', 'key' => 'home_expedition2_duration', 'label' => 'Expedition Carousel 2 – Duration', 'value' => '4 - 7 Days',         'type' => 'text', 'order' => 81],
            ['group' => 'home', 'key' => 'home_expedition2_group',    'label' => 'Expedition Carousel 2 – Group',    'value' => '6+',                 'type' => 'text', 'order' => 82],

            // ── Home – Video Banner ───────────────────────────────────────────────
            ['group' => 'home', 'key' => 'home_video_title',    'label' => 'Video Banner – Title',    'value' => 'Annapurna Base Camp Trek', 'type' => 'text',  'order' => 90],
            ['group' => 'home', 'key' => 'home_video_location', 'label' => 'Video Banner – Location', 'value' => 'Annapurna Region',         'type' => 'text',  'order' => 91],
            ['group' => 'home', 'key' => 'home_video_duration', 'label' => 'Video Banner – Duration', 'value' => '4 Days - 10 Days',         'type' => 'text',  'order' => 92],
            ['group' => 'home', 'key' => 'home_video_url',      'label' => 'Video Banner – YouTube URL', 'value' => 'https://www.youtube.com/watch?v=f9Qad6hWHK8', 'type' => 'url', 'order' => 93],
            ['group' => 'home', 'key' => 'home_video_btn',      'label' => 'Video Banner – Button Text', 'value' => 'Watch Video',           'type' => 'text',  'order' => 94],
            ['group' => 'home', 'key' => 'home_video_bg',       'label' => 'Video Banner – Background Image', 'value' => null,              'type' => 'image', 'order' => 95],

            // ── Home – Sightseeing in Pokhara ─────────────────────────────────────
            ['group' => 'home', 'key' => 'home_sightseeing_title', 'label' => 'Sightseeing – Section Title', 'value' => 'Sightseeing in Pokhara', 'type' => 'text', 'order' => 100],
            ['group' => 'home', 'key' => 'home_sightseeing_btn',   'label' => 'Sightseeing – Button Text',   'value' => 'All Activities',         'type' => 'text', 'order' => 101],
            ['group' => 'home', 'key' => 'home_sightseeing_intro', 'label' => 'Sightseeing – Intro HTML', 'type' => 'textarea', 'order' => 102,
                'value' => '<p><b>Pokhara is the vibrant gateway to the Annapurna Region.</b></p>'
                    . '<p>Marvelous place where nature and culture go along with each other. Surrounded by <b>serene lakes</b> and <b>the majestic Annapurna range</b>, you have breathtaking mountain views and tranquil experiences.</p>'
                    . '<p>The key attractions include <b>Phewa Lake</b>, <b>World Peace Pagoda</b>, <b>Sarangkot</b>, and <b>Devi\'s Falls</b>, which are ideal for both relaxation and adventure. From <b>paragliding</b> to <b>boating</b> and <b>hiking</b>, <a href="/trek-routes/pokhara-city-tours"><b>Pokhara</b></a> never lets any kind of traveler be bored.</p>',
            ],
            ['group' => 'home', 'key' => 'home_sightseeing_list_left',  'label' => 'Sightseeing – Left List (pipe-separated)',  'value' => 'Boating on Phewa Lake|Paragliding|Sarangkot',              'type' => 'textarea', 'order' => 103],
            ['group' => 'home', 'key' => 'home_sightseeing_list_right', 'label' => 'Sightseeing – Right List (pipe-separated)', 'value' => "World Peace Pagoda|Int'l Mountain Museum|Devi's Falls",   'type' => 'textarea', 'order' => 104],

            // Sightseeing carousel items
            ['group' => 'home', 'key' => 'home_pokhara_sightseeing_name', 'label' => 'Sightseeing Carousel 1 – Name',     'value' => 'Pokhara Sightseeing', 'type' => 'text', 'order' => 105],
            ['group' => 'home', 'key' => 'home_paragliding_name',         'label' => 'Sightseeing Carousel 2 – Name',     'value' => 'Paragliding',         'type' => 'text', 'order' => 106],
            ['group' => 'home', 'key' => 'home_paragliding_price',        'label' => 'Sightseeing Carousel 2 – Price',    'value' => '$1,300 - $1,500',     'type' => 'text', 'order' => 107],
            ['group' => 'home', 'key' => 'home_paragliding_duration',     'label' => 'Sightseeing Carousel 2 – Duration', 'value' => '1 - 4 Days',          'type' => 'text', 'order' => 108],
            ['group' => 'home', 'key' => 'home_paragliding_group',        'label' => 'Sightseeing Carousel 2 – Group',    'value' => '8+',                  'type' => 'text', 'order' => 109],

            // ── Home – Wildlife & Nature ───────────────────────────────────────────
            ['group' => 'home', 'key' => 'home_wildlife_title', 'label' => 'Wildlife – Section Title', 'value' => 'Wildlife and Nature Exploration', 'type' => 'text', 'order' => 110],
            ['group' => 'home', 'key' => 'home_wildlife_btn',   'label' => 'Wildlife – Button Text',   'value' => 'All Mountaineering / Expedition', 'type' => 'text', 'order' => 111],
            ['group' => 'home', 'key' => 'home_wildlife_intro', 'label' => 'Wildlife – Intro HTML', 'type' => 'textarea', 'order' => 112,
                'value' => '<p>The Annapurna Region has Nepal\'s largest protected area with pristine landscapes and diverse wildlife.</p>'
                    . '<p>You can see the rare species Himalayan Tahr, Snow Leopard, and Danphe (national bird of Nepal) while trekking through the ACA. Its lush rhododendron forests and cascading waterfalls provide an unforgettable backdrop for exploration. <b>The place is ideal for people seeking tranquility amidst nature while observing the incredible biodiversity of this place.</b></p>',
            ],
            ['group' => 'home', 'key' => 'home_wildlife_list_left',  'label' => 'Wildlife – Left List (pipe-separated)',  'value' => 'Annapurna Conservation Area|Ghorepani Rhododendron ..',  'type' => 'textarea', 'order' => 113],
            ['group' => 'home', 'key' => 'home_wildlife_list_right', 'label' => 'Wildlife – Right List (pipe-separated)', 'value' => 'Tilicho Lake|Wildlife & Birds Watching:',                'type' => 'textarea', 'order' => 114],

            // Wildlife carousel items
            ['group' => 'home', 'key' => 'home_wildlife1_name',     'label' => 'Wildlife Carousel 1 – Name',     'value' => 'Ghorepani Rhododendron Forest', 'type' => 'text', 'order' => 115],
            ['group' => 'home', 'key' => 'home_wildlife1_price',    'label' => 'Wildlife Carousel 1 – Price',    'value' => '$1,250',                        'type' => 'text', 'order' => 116],
            ['group' => 'home', 'key' => 'home_wildlife1_duration', 'label' => 'Wildlife Carousel 1 – Duration', 'value' => '4 - 7 Days',                    'type' => 'text', 'order' => 117],
            ['group' => 'home', 'key' => 'home_wildlife1_group',    'label' => 'Wildlife Carousel 1 – Group',    'value' => '12+',                           'type' => 'text', 'order' => 118],
            ['group' => 'home', 'key' => 'home_wildlife2_name',     'label' => 'Wildlife Carousel 2 – Name',     'value' => 'Tilicho Lake',                  'type' => 'text', 'order' => 119],
            ['group' => 'home', 'key' => 'home_wildlife2_price',    'label' => 'Wildlife Carousel 2 – Price',    'value' => '$1,300 - $1,500',               'type' => 'text', 'order' => 120],
            ['group' => 'home', 'key' => 'home_wildlife2_duration', 'label' => 'Wildlife Carousel 2 – Duration', 'value' => '7 - 14 Days',                   'type' => 'text', 'order' => 121],
            ['group' => 'home', 'key' => 'home_wildlife2_group',    'label' => 'Wildlife Carousel 2 – Group',    'value' => '6+',                            'type' => 'text', 'order' => 122],

            // ── Home – Testimonials ───────────────────────────────────────────────
            ['group' => 'home', 'key' => 'home_testimonials_heading', 'label' => 'Testimonials – Heading', 'value' => 'Reflections on the Majesty of Annapurna from Legends and Explorers', 'type' => 'text', 'order' => 130],
            ['group' => 'home', 'key' => 'home_call_label',           'label' => 'Testimonials – Call Label',    'value' => 'Call Now',                    'type' => 'text', 'order' => 131],
            ['group' => 'home', 'key' => 'home_listing_cta',          'label' => 'Testimonials – Listing CTA',  'value' => 'Contact us, to list your business and packages / itineraries.', 'type' => 'text', 'order' => 132],
            ['group' => 'home', 'key' => 'home_contact_btn',          'label' => 'Testimonials – Contact Btn',  'value' => 'Get In Touch',                 'type' => 'text', 'order' => 133],
            ['group' => 'home', 'key' => 'home_testimonials_label',   'label' => 'Testimonials – Box Label',    'value' => 'Testimonials',                 'type' => 'text', 'order' => 134],
            ['group' => 'home', 'key' => 'home_testimonials_title',   'label' => 'Testimonials – Box Title',    'value' => 'Travelers Reviews',            'type' => 'text', 'order' => 135],

            // Testimonial fallback quotes (shown when DB has no testimonials)
            ['group' => 'home', 'key' => 'home_testimonial1_quote', 'label' => 'Testimonial 1 – Quote', 'type' => 'textarea', 'order' => 136,
                'value' => "It's not about conquering mountains, but about the journey and the experiences along the way",
            ],
            ['group' => 'home', 'key' => 'home_testimonial1_name', 'label' => 'Testimonial 1 – Name', 'value' => 'Jimmy Chin',                    'type' => 'text', 'order' => 137],
            ['group' => 'home', 'key' => 'home_testimonial1_role', 'label' => 'Testimonial 1 – Role', 'value' => 'Renowned climber and filmmaker', 'type' => 'text', 'order' => 138],

            ['group' => 'home', 'key' => 'home_testimonial2_quote', 'label' => 'Testimonial 2 – Quote', 'type' => 'textarea', 'order' => 139,
                'value' => 'Annapurna, to which we had gone empty-handed, was a treasure on which we should live the rest of our days. With this realization, we turn the page: a new life begins. There are other Annapurnas in the lives of men.',
            ],
            ['group' => 'home', 'key' => 'home_testimonial2_name', 'label' => 'Testimonial 2 – Name', 'value' => 'Maurice Herzog', 'type' => 'text', 'order' => 140],
            ['group' => 'home', 'key' => 'home_testimonial2_role', 'label' => 'Testimonial 2 – Role', 'value' => 'From Book',       'type' => 'text', 'order' => 141],

            ['group' => 'home', 'key' => 'home_testimonial3_quote', 'label' => 'Testimonial 3 – Quote', 'type' => 'textarea', 'order' => 142,
                'value' => 'Mountains seem to answer an increasing imaginative need in the West. More and more people are discovering a desire for them, and an attraction to their promise of freedom.',
            ],
            ['group' => 'home', 'key' => 'home_testimonial3_name', 'label' => 'Testimonial 3 – Name', 'value' => 'Robert Macfarlane',              'type' => 'text', 'order' => 143],
            ['group' => 'home', 'key' => 'home_testimonial3_role', 'label' => 'Testimonial 3 – Role', 'value' => 'Author of Mountains of the Mind', 'type' => 'text', 'order' => 144],

            // ── Home – Travel Agencies ────────────────────────────────────────────
            ['group' => 'home', 'key' => 'home_agencies_subtitle', 'label' => 'Agencies – Subtitle',   'value' => 'Your Travel Partners', 'type' => 'text', 'order' => 150],
            ['group' => 'home', 'key' => 'home_agencies_title',    'label' => 'Agencies – Title',      'value' => 'Featured',             'type' => 'text', 'order' => 151],
            ['group' => 'home', 'key' => 'home_agencies_span',     'label' => 'Agencies – Title Span', 'value' => 'Travel Agencies',      'type' => 'text', 'order' => 152],
            ['group' => 'home', 'key' => 'home_agencies_badge',    'label' => 'Agencies – Card Badge', 'value' => 'Travel Agency',        'type' => 'text', 'order' => 153],
            ['group' => 'home', 'key' => 'home_agencies_btn',      'label' => 'Agencies – Button',     'value' => 'View All Travel Agencies', 'type' => 'text', 'order' => 154],

            // ── Home – FAQ ────────────────────────────────────────────────────────
            ['group' => 'home', 'key' => 'home_faq_subtitle', 'label' => 'FAQ – Subtitle',   'value' => 'Common Questions',      'type' => 'text', 'order' => 160],
            ['group' => 'home', 'key' => 'home_faq_title',    'label' => 'FAQ – Title',      'value' => 'Frequently Asked',      'type' => 'text', 'order' => 161],
            ['group' => 'home', 'key' => 'home_faq_span',     'label' => 'FAQ – Title Span', 'value' => 'Questions',             'type' => 'text', 'order' => 162],
            ['group' => 'home', 'key' => 'home_faq_btn',      'label' => 'FAQ – Button',     'value' => 'View All FAQs',         'type' => 'text', 'order' => 163],

            // ── Home – Blog ───────────────────────────────────────────────────────
            ['group' => 'home', 'key' => 'home_blog_subtitle', 'label' => 'Blog – Subtitle',   'value' => 'Travel Insights', 'type' => 'text', 'order' => 170],
            ['group' => 'home', 'key' => 'home_blog_title',    'label' => 'Blog – Title',      'value' => 'Latest from',     'type' => 'text', 'order' => 171],
            ['group' => 'home', 'key' => 'home_blog_span',     'label' => 'Blog – Title Span', 'value' => 'Our Blog',        'type' => 'text', 'order' => 172],
            ['group' => 'home', 'key' => 'home_blog_btn',      'label' => 'Blog – Button',     'value' => 'View All Posts',  'type' => 'text', 'order' => 173],

            // ── Footer ────────────────────────────────────────────────────────────
            ['group' => 'general', 'key' => 'footer_tagline', 'label' => 'Footer Tagline', 'value' => 'The Annapurna Region in central Nepal is an one of the most famous destinations, globally for its panoramic views, culture, and exciting adventure.', 'type' => 'textarea', 'order' => 200],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        $this->command->info('Settings seeded!');
    }
}
