<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        $pages = [
            [
                'title'            => 'About Us',
                'slug'             => 'about-us',
                'template'         => 'about',
                'status'           => 'published',
                'show_in_sitemap'  => true,
                'order'            => 1,
                'content'          => '<p>Annapurna Region is your trusted guide to exploring the magnificent Annapurna Himalayan region of Nepal. We connect travellers with the best trekking routes, destinations, hotels, restaurants, and travel agencies in the region.</p><p>Our mission is to make the Annapurna region accessible, enjoyable, and sustainable for all visitors while supporting local communities and businesses.</p>',
                'meta_title'       => 'About Us - Annapurna Region',
                'meta_description' => 'Learn about Annapurna Region — your trusted guide to exploring the magnificent Annapurna Himalayan region of Nepal.',
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'title'            => 'Annapurna Region',
                'slug'             => 'annapurna-region',
                'template'         => 'annapurna-region',
                'status'           => 'published',
                'show_in_sitemap'  => true,
                'order'            => 2,
                'content'          => '<p>The Annapurna Region is one of Nepal\'s most iconic and diverse trekking destinations, offering everything from sub-tropical forests to high-altitude glaciers. Located in north-central Nepal, it encompasses a vast area of spectacular mountain scenery, charming villages, and rich cultural heritage.</p>',
                'meta_title'       => 'Annapurna Region - Nepal\'s Premier Trekking Destination',
                'meta_description' => 'Discover the Annapurna Region of Nepal — home to iconic trek routes, diverse landscapes, rich culture, and warm hospitality.',
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'title'            => 'Terms & Conditions',
                'slug'             => 'terms-and-conditions',
                'template'         => 'default',
                'status'           => 'published',
                'show_in_sitemap'  => false,
                'order'            => 10,
                'content'          => '<h2>Terms &amp; Conditions</h2><p>By accessing and using the Annapurna Region website, you accept and agree to be bound by the terms and provision of this agreement.</p><h3>Use of Content</h3><p>All content on this website is for informational purposes only. We make no guarantees regarding the accuracy of information provided.</p><h3>Third-Party Links</h3><p>This website may contain links to third-party websites. We are not responsible for the content or practices of those sites.</p><h3>Contact</h3><p>For questions regarding these terms, please contact us through our <a href="/contact">contact page</a>.</p>',
                'meta_title'       => 'Terms & Conditions - Annapurna Region',
                'meta_description' => 'Terms and conditions for using the Annapurna Region website.',
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'title'            => 'Privacy Policy',
                'slug'             => 'privacy-policy',
                'template'         => 'default',
                'status'           => 'published',
                'show_in_sitemap'  => false,
                'order'            => 11,
                'content'          => '<h2>Privacy Policy</h2><p>This privacy policy explains how Annapurna Region collects, uses, and protects your personal information.</p><h3>Information We Collect</h3><p>We collect information you provide directly to us, such as when you submit an enquiry, register an account, or contact us.</p><h3>How We Use Your Information</h3><p>We use the information we collect to respond to your enquiries, improve our services, and send relevant communications (with your consent).</p><h3>Data Security</h3><p>We implement appropriate technical and organisational measures to protect your personal information.</p><h3>Contact</h3><p>If you have questions about our privacy practices, please <a href="/contact">contact us</a>.</p>',
                'meta_title'       => 'Privacy Policy - Annapurna Region',
                'meta_description' => 'Privacy policy for the Annapurna Region website — how we collect, use, and protect your information.',
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
        ];

        foreach ($pages as $page) {
            DB::table('pages')->updateOrInsert(['slug' => $page['slug']], $page);
        }
    }

    public function down(): void
    {
        DB::table('pages')->whereIn('slug', [
            'about-us', 'annapurna-region', 'terms-and-conditions', 'privacy-policy',
        ])->delete();
    }
};
