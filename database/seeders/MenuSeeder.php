<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Main Navigation ──────────────────────────────────────────────────────
        $mainNav = Menu::updateOrCreate(
            ['slug' => 'main'],
            ['name' => 'Main Navigation', 'is_active' => true]
        );

        MenuItem::where('menu_id', $mainNav->id)->delete();

        $mainItems = [
            [
                'title' => 'Home',
                'url'   => '/',
                'order' => 1,
            ],
            [
                'title'    => 'Annapurna Treks & Tours',
                'url'      => '#',
                'order'    => 2,
                'children' => [
                    ['title' => 'Annapurna Circuit Trek',   'url' => '/trek-routes/annapurna-circuit-trek',   'order' => 1],
                    ['title' => 'Annapurna Base Camp Trek', 'url' => '/trek-routes/annapurna-base-camp-trek', 'order' => 2],
                    ['title' => 'Pokhara City Tours',       'url' => '/trek-routes/pokhara-city-tours',       'order' => 3],
                ],
            ],
            [
                'title' => 'Travel Agencies',
                'url'   => '/travel-agencies',
                'order' => 3,
            ],
            [
                'title' => 'Destinations',
                'url'   => '/destinations',
                'order' => 4,
            ],
            [
                'title'    => 'Hotels & Restaurants',
                'url'      => '#',
                'order'    => 5,
                'children' => [
                    ['title' => 'Hotels',      'url' => '/hotels',      'order' => 1],
                    ['title' => 'Restaurants', 'url' => '/restaurants', 'order' => 2],
                ],
            ],
            [
                'title' => 'Contact',
                'url'   => '/contact',
                'order' => 6,
            ],
        ];

        foreach ($mainItems as $item) {
            $children = $item['children'] ?? [];
            unset($item['children']);

            $menuItem = MenuItem::create([
                ...$item,
                'menu_id'   => $mainNav->id,
                'is_active' => true,
            ]);

            foreach ($children as $child) {
                MenuItem::create([
                    ...$child,
                    'menu_id'   => $mainNav->id,
                    'parent_id' => $menuItem->id,
                    'is_active' => true,
                ]);
            }
        }

        // ─── Footer Quick Links ───────────────────────────────────────────────────
        $footer1 = Menu::updateOrCreate(
            ['slug' => 'footer-links-1'],
            ['name' => 'Quick Links', 'is_active' => true]
        );

        MenuItem::where('menu_id', $footer1->id)->delete();

        foreach ([
            ['title' => 'Home',            'url' => '/',               'order' => 1],
            ['title' => 'Trek Routes',     'url' => '/trek-routes',    'order' => 2],
            ['title' => 'Destinations',    'url' => '/destinations',   'order' => 3],
            ['title' => 'Travel Agencies', 'url' => '/travel-agencies','order' => 4],
            ['title' => 'Blog',            'url' => '/blog',           'order' => 5],
            ['title' => 'Contact',         'url' => '/contact',        'order' => 6],
        ] as $item) {
            MenuItem::create([...$item, 'menu_id' => $footer1->id, 'is_active' => true]);
        }

        // ─── Footer Explore Links ─────────────────────────────────────────────────
        $footer2 = Menu::updateOrCreate(
            ['slug' => 'footer-links-2'],
            ['name' => 'Explore', 'is_active' => true]
        );

        MenuItem::where('menu_id', $footer2->id)->delete();

        foreach ([
            ['title' => 'Hotels',       'url' => '/hotels',       'order' => 1],
            ['title' => 'Restaurants',  'url' => '/restaurants',  'order' => 2],
            ['title' => 'Gallery',      'url' => '/gallery',      'order' => 3],
            ['title' => 'FAQ',          'url' => '/faq',          'order' => 4],
        ] as $item) {
            MenuItem::create([...$item, 'menu_id' => $footer2->id, 'is_active' => true]);
        }

        // ─── Footer Bottom ────────────────────────────────────────────────────────
        $footerBottom = Menu::updateOrCreate(
            ['slug' => 'footer-bottom'],
            ['name' => 'Footer Bottom', 'is_active' => true]
        );

        MenuItem::where('menu_id', $footerBottom->id)->delete();

        foreach ([
            ['title' => 'Privacy Policy', 'url' => '/privacy', 'order' => 1],
            ['title' => 'Terms of Use',   'url' => '/terms',   'order' => 2],
        ] as $item) {
            MenuItem::create([...$item, 'menu_id' => $footerBottom->id, 'is_active' => true]);
        }

        $this->command->info('Menus seeded!');
    }
}
