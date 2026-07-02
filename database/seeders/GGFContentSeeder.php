<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Counter;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GGFContentSeeder extends Seeder
{
    public function run(): void
    {
        // ── Images ───────────────────────────────────────────────────────────
        $images = [
            'logo'           => $this->seedImage('logos/guru-logo1.png',          'ggf/branding/logo.png'),
            'favicon'        => $this->seedImage('guru-fav-logo.png',              'ggf/branding/favicon.png'),
            'slider_gorkha'  => $this->seedImage('gorkha-wide-large.jpg',         'ggf/sliders/gorkha.jpg'),
            'slider_guru'    => $this->seedImage('guru-gorakh-slider.jpg',         'ggf/sliders/guru-goraksanatha.jpg'),
            'about_guru'     => $this->seedImage('abt-guru-goraksanatha.jpg',      'ggf/pages/about-guru.jpg'),
            'about_gorkha'   => $this->seedImage('abt-gorkha.jpg',                'ggf/pages/about-gorkha.jpg'),
            'yogi'           => $this->seedImage('yogi-narharinath.jpg',           'ggf/pages/naraharinath.jpg'),
            'gorkha_1975'    => $this->seedImage('gorkha-1975.png',               'ggf/pages/gorkha-1975.png'),
            'gorkha_2025'    => $this->seedImage('gorkha-2025.png',               'ggf/pages/gorkha-2025.png'),
            'gorakh'         => $this->seedImage('gorakh.png',                    'ggf/pages/gorakh.png'),
            'hd_wide'        => $this->seedImage('hd-41.png',                     'ggf/pages/header.png'),
            'qr_code'        => $this->seedImage('qr-code.jpg',                   'ggf/donation/qr-code.jpg'),
            'team_subhendu'  => $this->seedImage('shubendhu-gupta.jpg',           'ggf/team/subhendu-gupta.jpg'),
            'team_tilak'     => $this->seedImage('tika-adhikari.jpg',             'ggf/team/tilak-adhikari.jpg'),
            'team_dinesh'    => $this->seedImage('dinesh-khanal.jpg',             'ggf/team/dinesh-khanal.jpg'),
            'team_raju'      => $this->seedImage('raju-bhandari.jpg',             'ggf/team/raju-bhandari.jpg'),
            'team_kiran'     => $this->seedImage('kiran-khanal.jpg',              'ggf/team/kiran-khanal.jpg'),
            'program_1'      => $this->seedImage('image-14.jpg',                  'ggf/programs/program-1.jpg'),
            'program_2'      => $this->seedImage('image-3.jpg',                   'ggf/programs/program-2.jpg'),
            'program_3'      => $this->seedImage('image-9.jpg',                   'ggf/programs/program-3.jpg'),
            'program_4'      => $this->seedImage('image-8.jpg',                   'ggf/programs/program-4.jpg'),
            'user_1'         => $this->seedImage('user-1.jpg',                    'ggf/users/user-1.jpg'),
            'user_2'         => $this->seedImage('user-5.jpg',                    'ggf/users/user-2.jpg'),
            'user_3'         => $this->seedImage('user-3.jpg',                    'ggf/users/user-3.jpg'),
            'user_4'         => $this->seedImage('user-4.jpg',                    'ggf/users/user-4.jpg'),
        ];

        // ── Settings ─────────────────────────────────────────────────────────
        $settings = [
            // General
            ['group' => 'ggf', 'key' => 'ggf_site_name',        'label' => 'GGF Site Name',        'value' => 'Guru Goraksanatha Foundation', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_site_tagline',     'label' => 'GGF Site Tagline',     'value' => 'A non-profit spiritual and cultural organization dedicated to preserving the divine legacy of Guru Goraksanatha.', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_site_logo',        'label' => 'GGF Logo',             'value' => $images['logo'],    'type' => 'image'],
            ['group' => 'ggf', 'key' => 'ggf_favicon',          'label' => 'GGF Favicon',          'value' => $images['favicon'], 'type' => 'image'],
            // SEO
            ['group' => 'ggf', 'key' => 'ggf_meta_description', 'label' => 'GGF Meta Description', 'value' => 'Guru Goraksanatha Foundation preserves the divine legacy of Guru Goraksanatha, the Nath tradition, and the sacred heritage of Devbhumi Gorkha, Nepal.', 'type' => 'textarea'],
            // Contact
            ['group' => 'ggf', 'key' => 'ggf_contact_address',  'label' => 'GGF Address',          'value' => 'Tripureshwor, Kathmandu | Gorkha, Nepal', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_address_line1',    'label' => 'GGF Address Line 1',   'value' => '(HO) Gorkha, Nepal', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_address_line2',    'label' => 'GGF Address Line 2',   'value' => 'Kathmandu, Nepal',  'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_contact_phone',    'label' => 'GGF Phone',            'value' => '+977-9851362653', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_contact_email',    'label' => 'GGF Email',            'value' => 'gurugoraksanathafoundation@gmail.com', 'type' => 'email'],
            ['group' => 'ggf', 'key' => 'ggf_contact_web',      'label' => 'GGF Website',          'value' => 'www.ggf.org.np', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_contact_hours',    'label' => 'GGF Office Hours',     'value' => '10 AM – 5 PM, Sun–Fri', 'type' => 'text'],
            // Social
            ['group' => 'ggf', 'key' => 'ggf_social_facebook',  'label' => 'GGF Facebook',         'value' => 'https://www.facebook.com/share/1Bj9TwrQvr/', 'type' => 'url'],
            ['group' => 'ggf', 'key' => 'ggf_social_youtube',   'label' => 'GGF YouTube',          'value' => 'https://www.youtube.com/@GorakshadhamGorkha-GGF', 'type' => 'url'],
            ['group' => 'ggf', 'key' => 'ggf_social_instagram', 'label' => 'GGF Instagram',        'value' => '#', 'type' => 'url'],
            ['group' => 'ggf', 'key' => 'ggf_social_linkedin',  'label' => 'GGF LinkedIn',         'value' => '#', 'type' => 'url'],
            // Footer
            ['group' => 'ggf', 'key' => 'ggf_footer_tagline',       'label' => 'GGF Footer Tagline',          'value' => 'Guru Goraksanatha Foundation is a non-profit spiritual and cultural organization', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_footer_links_title',   'label' => 'GGF Footer Links Title',      'value' => 'Quick Links',              'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_footer_link1_label',   'label' => 'GGF Footer Link 1 Label',     'value' => 'About the Foundation',     'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_footer_link2_label',   'label' => 'GGF Footer Link 2 Label',     'value' => 'Programs & Initiatives',   'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_footer_link3_label',   'label' => 'GGF Footer Link 3 Label',     'value' => 'Volunteer & Support',      'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_footer_link4_label',   'label' => 'GGF Footer Link 4 Label',     'value' => 'Contact Us',               'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_footer_address_label', 'label' => 'GGF Footer Address Label',    'value' => 'Address',                  'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_footer_email_label',   'label' => 'GGF Footer Email Label',      'value' => 'Email',                    'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_footer_phone_label',   'label' => 'GGF Footer Phone Label',      'value' => 'Phone',                    'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_footer_youtube_label', 'label' => 'GGF Footer YouTube Label',    'value' => 'YouTube',                  'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_footer_powered_text',  'label' => 'GGF Footer Powered By Text',  'value' => 'Global Studio',            'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_footer_powered_url',   'label' => 'GGF Footer Powered By URL',   'value' => 'https://www.globalstudio.com.np', 'type' => 'url'],
            ['group' => 'ggf', 'key' => 'ggf_footer_privacy_label', 'label' => 'GGF Footer Privacy Label',    'value' => 'Privacy Policy',           'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_footer_privacy_url',   'label' => 'GGF Footer Privacy URL',      'value' => '#',                        'type' => 'url'],
            // Map
            ['group' => 'ggf', 'key' => 'ggf_map_embed',        'label' => 'GGF Map Embed URL',    'value' => 'https://www.google.com/maps?q=28.0044263,83.4093251&z=15&output=embed', 'type' => 'url'],
            // Home page sections
            ['group' => 'ggf', 'key' => 'ggf_about_title',      'label' => 'GGF Home About Title', 'value' => 'Who We Are', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_about_subtitle',   'label' => 'GGF Home About Subtitle', 'value' => 'About the Foundation', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_about_description','label' => 'GGF Home About Description', 'value' => 'Guru Goraksanatha Foundation is a non-profit spiritual and cultural organization dedicated to preserving and promoting the divine legacy of Guru Goraksanatha, the Nath tradition, and the sacred heritage of Devbhumi Gorkha, Nepal.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_about_description2','label' => 'GGF Home About Description 2', 'value' => 'Our mission is rooted in the belief that the teachings of Guru Goraksanatha—yoga, discipline, devotion, self-realization, and service—are timeless sources of spiritual strength and global harmony.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_about_short',      'label' => 'GGF Short About',     'value' => 'Guru Goraksanatha Foundation is a non-profit spiritual and cultural organization dedicated to preserving and promoting the divine legacy of Guru Goraksanatha, the Nath tradition, and the sacred heritage of Devbhumi Gorkha, Nepal.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_cta_title',        'label' => 'GGF CTA Title',       'value' => 'Join us to create a compassionate and resilient community', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_cta_description',  'label' => 'GGF CTA Description', 'value' => 'We are committed to honoring Guru Goraksanath\'s divine legacy by transforming Gorkha into a global spiritual destination. We invite devotees, scholars, institutions, and well-wishers from Nepal, India, and worldwide to join hands in this sacred mission.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_projects_title',   'label' => 'GGF Projects Title',  'value' => 'Current Major Projects', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_projects_subtitle','label' => 'GGF Projects Subtitle','value' => 'What We Do', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_why_title',        'label' => 'GGF Why Title',       'value' => 'Why partner with us', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_why_subtitle',     'label' => 'GGF Why Subtitle',    'value' => 'Trusted, transparent, impact-driven', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_why_description',  'label' => 'GGF Why Description', 'value' => 'We operate with community-rooted approaches, transparent finances, and measurable outcomes. Projects are designed with local partners and monitored for real results.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_team_title',            'label' => 'GGF Team Title (Home)',        'value' => 'Our Dedicated Team',                                         'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_team_subtitle',         'label' => 'GGF Team Subtitle (Home)',     'value' => 'Spiritual leaders, social volunteers, and community mobilizers', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_team_description',      'label' => 'GGF Team Description (Home)', 'value' => 'The Guru Goraksanatha Foundation is led by a dedicated team of spiritual leaders, social volunteers, cultural researchers, and community mobilizers who collectively work to preserve and promote the timeless legacy of Guru Goraksanatha.', 'type' => 'textarea'],
            // Team page
            ['group' => 'ggf', 'key' => 'ggf_team_page_title',       'label' => 'GGF Team Page Title',         'value' => 'Our Team',                                                   'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_team_meta_description',  'label' => 'GGF Team Meta Description',   'value' => 'Meet the dedicated team behind Guru Goraksanatha Foundation.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_team_header_image',      'label' => 'GGF Team Header Image',       'value' => 'hd-1.jpg',                                                   'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_team_header_title',      'label' => 'GGF Team Header Title',       'value' => 'Our team',                                                   'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_team_header_subtitle',   'label' => 'GGF Team Header Subtitle',    'value' => 'Our big family',                                             'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_team_intro_text',        'label' => 'GGF Team Intro Text',         'value' => 'The Guru Goraksanatha Foundation is led by a dedicated team of spiritual leaders, social volunteers, cultural researchers, and community mobilizers who collectively work to preserve and promote the timeless legacy of Guru Goraksanatha. Our team brings together individuals with deep faith, professional expertise, and a strong commitment to service. Guided by the principles of discipline, compassion, and divine knowledge inherited from the Nath tradition, the foundation\'s members oversee religious activities, community welfare programs, heritage conservation efforts, and the development of Gorakshaham Gorkha. Each member contributes through their specialized roles—administration, research, outreach, event coordination, documentation, and project management—ensuring that every initiative is carried out with integrity, transparency, and devotion. United by a shared spiritual purpose, the Guru Goraksanatha Foundation team strives to uplift society, strengthen Nepal–India cultural ties, and carry forward the profound teachings of Guru Goraksanatha for future generations.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_team_section_title',     'label' => 'GGF Team Section Title',      'value' => 'Our team of experts',                                        'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_team_section_subtitle',  'label' => 'GGF Team Section Subtitle',   'value' => 'Team members',                                               'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_team_box1_icon',         'label' => 'GGF Team Box 1 Icon',         'value' => 'im-air-balloon',                                             'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_team_box1_title',        'label' => 'GGF Team Box 1 Title',        'value' => 'The best job',                                               'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_team_box1_text',         'label' => 'GGF Team Box 1 Text',         'value' => 'All day immerse into the nature and amazing views.',          'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_team_box2_icon',         'label' => 'GGF Team Box 2 Icon',         'value' => 'im-bar-chart2',                                              'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_team_box2_title',        'label' => 'GGF Team Box 2 Title',        'value' => 'Career opportunities',                                       'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_team_box2_text',         'label' => 'GGF Team Box 2 Text',         'value' => 'Grow with us is possible thanks to our levels structure.',   'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_team_box3_icon',         'label' => 'GGF Team Box 3 Icon',         'value' => 'im-bee',                                                     'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_team_box3_title',        'label' => 'GGF Team Box 3 Title',        'value' => 'Meet amazing people',                                        'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_team_box3_text',         'label' => 'GGF Team Box 3 Text',         'value' => 'We\'re the best team ever! Funny and friendly with each other.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_team_join_title',        'label' => 'GGF Team Join Title',         'value' => 'Join our team',                                              'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_team_join_text',         'label' => 'GGF Team Join Text',          'value' => 'We welcome devoted individuals who wish to contribute to the preservation of Nath heritage, community upliftment, and the sacred mission of Guru Goraksanatha Foundation.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_team_join_button',       'label' => 'GGF Team Join Button Text',   'value' => 'Contact us',                                                 'type' => 'text'],
            // Services page
            ['group' => 'ggf', 'key' => 'ggf_services_page_title',       'label' => 'GGF Services Page Title',         'value' => 'Services',                                                   'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_meta_description',  'label' => 'GGF Services Meta Description',   'value' => 'Our community programs and services - Education, Health, Welfare, and Cultural Preservation.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_services_header_image',      'label' => 'GGF Services Header Image',       'value' => 'hd-4.jpg',                                                   'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_header_title',      'label' => 'GGF Services Header Title',       'value' => 'Services',                                                   'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_header_subtitle',   'label' => 'GGF Services Header Subtitle',    'value' => 'Services',                                                   'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_section_title',     'label' => 'GGF Services Section Title',      'value' => 'Our Services',                                               'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_description',       'label' => 'GGF Services Description',        'value' => 'Guru Goraksanatha Foundation is committed to uplifting communities through meaningful social work, empowerment, and development programs. Our services are designed to support children, youth, women, senior citizens, and marginalized groups by providing education, health care, training, and emergency support.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_services_how_title',         'label' => 'GGF Services How We Work Title',  'value' => 'How We Work',                                                'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_step1_title',       'label' => 'GGF Services Step 1 Title',       'value' => 'Community Outreach',                                         'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_step1_text',        'label' => 'GGF Services Step 1 Text',        'value' => 'Our team visits communities, identifies real needs, and listens to the voices of people who require support. This helps us design meaningful and practical programs.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_services_step2_title',       'label' => 'GGF Services Step 2 Title',       'value' => 'Program Planning',                                           'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_step2_text',        'label' => 'GGF Services Step 2 Text',        'value' => 'After identifying challenges, we create structured plans for education support, health camps, skill training, relief distribution, and welfare activities.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_services_step3_title',       'label' => 'GGF Services Step 3 Title',       'value' => 'Program Execution',                                          'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_step3_text',        'label' => 'GGF Services Step 3 Text',        'value' => 'Each project is executed through volunteers, social workers, trainers, doctors, and local community leaders to ensure maximum impact.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_services_impact_title',      'label' => 'GGF Services Impact Title',       'value' => 'Impact Overview',                                            'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_progress1_label',   'label' => 'GGF Services Progress 1 Label',   'value' => 'Communities Reached',                                        'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_progress1_value',   'label' => 'GGF Services Progress 1 Value %', 'value' => '70',                                                         'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_progress2_label',   'label' => 'GGF Services Progress 2 Label',   'value' => 'Program Success Rate',                                       'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_progress2_value',   'label' => 'GGF Services Progress 2 Value %', 'value' => '95',                                                         'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_progress3_label',   'label' => 'GGF Services Progress 3 Label',   'value' => 'Beneficiaries Supported',                                    'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_progress3_value',   'label' => 'GGF Services Progress 3 Value %', 'value' => '85',                                                         'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_circle_label',      'label' => 'GGF Services Circle Label',       'value' => 'Community Engagement',                                       'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_circle_value',      'label' => 'GGF Services Circle Progress %',  'value' => '60',                                                         'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_circle_counter',    'label' => 'GGF Services Circle Counter %',   'value' => '35',                                                         'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_title',          'label' => 'GGF Services Provide Title',          'value' => 'What We Provide',                                                                                                                                                                      'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_text',           'label' => 'GGF Services Provide Text',           'value' => 'Through our initiatives, we ensure that individuals and communities receive meaningful support in the form of education materials, medical checkups, emergency relief, trainings, and long-term development opportunities.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_item1_icon',     'label' => 'GGF Services Provide Item 1 Icon',    'value' => 'im-pen',                                    'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_item1_title',    'label' => 'GGF Services Provide Item 1 Title',   'value' => 'Educational Aid',                           'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_item1_text',     'label' => 'GGF Services Provide Item 1 Text',    'value' => 'Books, scholarships, and school materials', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_item2_icon',     'label' => 'GGF Services Provide Item 2 Icon',    'value' => 'im-security-camera',                        'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_item2_title',    'label' => 'GGF Services Provide Item 2 Title',   'value' => 'Health Support',                            'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_item2_text',     'label' => 'GGF Services Provide Item 2 Text',    'value' => 'Free health checkups & medical camps',      'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_item3_icon',     'label' => 'GGF Services Provide Item 3 Icon',    'value' => 'im-gears',                                  'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_item3_title',    'label' => 'GGF Services Provide Item 3 Title',   'value' => 'Skill Development',                         'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_item3_text',     'label' => 'GGF Services Provide Item 3 Text',    'value' => 'Training for youth & women',                'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_item4_icon',     'label' => 'GGF Services Provide Item 4 Icon',    'value' => 'im-data-refresh',                           'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_item4_title',    'label' => 'GGF Services Provide Item 4 Title',   'value' => 'Relief Assistance',                         'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_item4_text',     'label' => 'GGF Services Provide Item 4 Text',    'value' => 'Emergency food, clothes & shelter',         'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_item5_icon',     'label' => 'GGF Services Provide Item 5 Icon',    'value' => 'im-support',                                'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_item5_title',    'label' => 'GGF Services Provide Item 5 Title',   'value' => 'Counselling',                               'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_item5_text',     'label' => 'GGF Services Provide Item 5 Text',    'value' => 'Social & psychological support',            'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_item6_icon',     'label' => 'GGF Services Provide Item 6 Icon',    'value' => 'im-coins',                                  'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_item6_title',    'label' => 'GGF Services Provide Item 6 Title',   'value' => 'Fundraising',                               'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_services_provide_item6_text',     'label' => 'GGF Services Provide Item 6 Text',    'value' => 'Support for community projects',            'type' => 'text'],
            // About page
            ['group' => 'ggf', 'key' => 'ggf_about_page_title',       'label' => 'GGF About Page Title',         'value' => 'About Us',                           'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_about_meta_description',  'label' => 'GGF About Meta Description',   'value' => 'About Guru Goraksanatha Foundation - Our history, vision, and mission.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_about_header_image',      'label' => 'GGF About Header Image',       'value' => 'hd-1.jpg',                           'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_about_header_title',      'label' => 'GGF About Header Title',       'value' => 'About us',                           'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_about_header_subtitle',   'label' => 'GGF About Header Subtitle',    'value' => 'Our core values',                    'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_about_text_1',            'label' => 'GGF About Text 1',             'value' => 'Guru Goraksanatha Foundation is a non-profit spiritual and cultural organization dedicated to preserving and promoting the divine legacy of Guru Goraksanatha, the Nath tradition, and the sacred heritage of Devbhumi Gorkha, Nepal.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_about_text_2',            'label' => 'GGF About Text 2',             'value' => 'Our mission is rooted in the belief that the teachings of Guru Goraksanatha—yoga, discipline, devotion, self-realization, and service—are timeless sources of spiritual strength and global harmony.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_about_text_3',            'label' => 'GGF About Text 3',             'value' => 'The Foundation works to safeguard the Nath yogic heritage, uplift communities, and promote spiritual awareness that has flourished in the Himalayan region for centuries. Our efforts ensure that future generations can connect with this timeless wisdom.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_about_history_title',     'label' => 'GGF About History Section Title',    'value' => 'History of Guru Goraksanatha Foundation', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_about_history_subtitle',  'label' => 'GGF About History Section Subtitle', 'value' => 'Our Journey',                        'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_about_history_text',      'label' => 'GGF About History Text',       'value' => "Guru Goraksanatha Foundation was established with the sacred vision of preserving, reviving, and promoting the profound spiritual legacy of Guru Goraksanatha and the Nath Yogic tradition rooted in Gorkha, Nepal. Gorkha is historically known as the divine tapobhoomi (meditation ground) of Guru Goraksanatha, where centuries of yogic practice, spiritual culture, and Himalayan wisdom flourished.\n\nRecognizing the cultural, religious, and historical significance of this sacred land, a group of devoted practitioners, community leaders, and spiritual seekers formally registered the Foundation with the purpose of revitalizing the ancient heritage and transforming Gorkha into a global center of spiritual learning.\n\nSince its inception, the Foundation has worked to protect the traditional Nath practices, promote yoga and meditation, conserve sacred sites, and foster Nepal–India spiritual friendship rooted in the teachings of Guru Goraksanatha. The Foundation has also undertaken activities such as community service, supporting local priests, and conducting religious ceremonies including daily Roth offerings, and various cultural events.\n\nIn recent months, the Foundation initiated the ambitious Gorakshadham Gorkha Project, a long-term vision to develop a spiritual and cultural destination incorporating temples, gurukul, meditation centers, cultural hubs, vedic museums, ashram, dharmashala, gaushala and eco-friendly infrastructure that reflects the Himalayan Nath tradition. This project aims to promote religious tourism, support local livelihoods, and create a global platform for yogic knowledge.\n\nThe Foundation has also embarked on creating a full-length international documentary titled \"Gorakshadham Gorkha – The Sacred Seat of Guru Goraksaanatha\" to showcase the spiritual importance of Gorkha and its deep connection with Gorakhpur, the historical seat of the Nath Sampradaya.\n\nGuided by its mission of dharma, sewa, sanskriti, and paropkar, the Foundation continues to expand its initiatives in spiritual promotion, cultural preservation, and community upliftment. With growing support from devotees, institutions, and well-wishers worldwide, Guru Goraksanatha Foundation is steadily moving towards realizing its vision of establishing Gorkha as an international center of Nath heritage, peace, and spiritual awakening.", 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_about_slider_1',           'label' => 'GGF About Slider Image 1',     'value' => 'gorkha-1975.png',                    'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_about_slider_1_alt',       'label' => 'GGF About Slider 1 Alt Text',  'value' => 'Gorkha 1975',                        'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_about_slider_2',           'label' => 'GGF About Slider Image 2',     'value' => 'gorkha-2025.png',                    'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_about_slider_2_alt',       'label' => 'GGF About Slider 2 Alt Text',  'value' => 'Gorkha 2025',                        'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_about_slider_3',           'label' => 'GGF About Slider Image 3',     'value' => 'gorakh.png',                         'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_about_slider_3_alt',       'label' => 'GGF About Slider 3 Alt Text',  'value' => 'Gorakh',                             'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_about_vision_title',      'label' => 'GGF About Vision Title',       'value' => 'Our Vision',                         'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_about_vision_intro',      'label' => 'GGF About Vision Intro',       'value' => 'To establish Gorakshadham Gorkha as an international center for:', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_about_vision_items',      'label' => 'GGF About Vision Items',       'value' => "• Spiritual learning\n• Yoga & meditation\n• Nath culture & heritage\n• Religious tourism\n• Cultural and academic research", 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_about_purpose_title',     'label' => 'GGF About Purpose Title',      'value' => 'Our Core Purpose',                   'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_about_purpose_items',     'label' => 'GGF About Purpose Items',      'value' => "• Revive and strengthen Nepal–India's shared spiritual heritage\n• Restore and conserve ancient Nath sites\n• Promote cultural tourism for Gorkha and Gorakhpur\n• Produce documentaries, books, and digital archives\n• Build a global spiritual hub in Gorkha", 'type' => 'textarea'],
            // History page
            ['group' => 'ggf', 'key' => 'ggf_history_page_title',         'label' => 'GGF History Page Title',        'value' => 'History',                            'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_history_meta_description',   'label' => 'GGF History Meta Description',  'value' => 'The history and journey of Guru Goraksanatha Foundation.',  'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_history_header_image',       'label' => 'GGF History Header Image',      'value' => 'hd-4.jpg',                           'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_history_header_title',       'label' => 'GGF History Header Title',      'value' => 'Our history',                        'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_history_header_subtitle',    'label' => 'GGF History Header Subtitle',   'value' => 'How we came here',                   'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_history_timeline_1_year',    'label' => 'GGF History Timeline 1 Year',   'value' => '2015',                               'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_history_timeline_1_label',   'label' => 'GGF History Timeline 1 Label',  'value' => 'Foundation',                         'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_history_timeline_1_title',   'label' => 'GGF History Timeline 1 Title',  'value' => 'Establishment of the Foundation',    'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_history_timeline_1_text',    'label' => 'GGF History Timeline 1 Text',   'value' => 'Guru Goraksanatha Foundation was established with the sacred vision of preserving, reviving, and promoting the profound spiritual legacy of Guru Goraksanatha and the Nath Yogic tradition rooted in Gorkha, Nepal — historically known as the divine tapobhoomi (meditation ground) of Guru Goraksanatha.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_history_timeline_2_year',    'label' => 'GGF History Timeline 2 Year',   'value' => '2018',                               'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_history_timeline_2_label',   'label' => 'GGF History Timeline 2 Label',  'value' => 'Registration',                       'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_history_timeline_2_title',   'label' => 'GGF History Timeline 2 Title',  'value' => 'Formal Registration & Community Outreach', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_history_timeline_2_text',    'label' => 'GGF History Timeline 2 Text',   'value' => 'A group of devoted practitioners, community leaders, and spiritual seekers formally registered the Foundation with the purpose of revitalizing the ancient heritage and transforming Gorkha into a global center of spiritual learning.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_history_timeline_3_year',    'label' => 'GGF History Timeline 3 Year',   'value' => '2021',                               'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_history_timeline_3_label',   'label' => 'GGF History Timeline 3 Label',  'value' => 'Collaboration',                      'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_history_timeline_3_title',   'label' => 'GGF History Timeline 3 Title',  'value' => 'Nepal–India Spiritual Collaboration', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_history_timeline_3_text',    'label' => 'GGF History Timeline 3 Text',   'value' => 'The Foundation fostered Nepal–India spiritual friendship rooted in the teachings of Guru Goraksanatha, protecting traditional Nath practices, promoting yoga and meditation, and conserving sacred sites across the Himalayan region.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_history_timeline_4_year',    'label' => 'GGF History Timeline 4 Year',   'value' => '2024',                               'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_history_timeline_4_label',   'label' => 'GGF History Timeline 4 Label',  'value' => 'Gorakshadham',                       'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_history_timeline_4_title',   'label' => 'GGF History Timeline 4 Title',  'value' => 'Gorakshadham Gorkha Project Launched', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_history_timeline_4_text',    'label' => 'GGF History Timeline 4 Text',   'value' => 'The Foundation initiated the ambitious Gorakshadham Gorkha Project — a long-term vision to develop a spiritual and cultural destination incorporating temples, gurukul, meditation centers, cultural hubs, vedic museums, ashram, dharmashala, gaushala, and eco-friendly infrastructure.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_history_contact_title',      'label' => 'GGF History Contact Box Title', 'value' => 'Need more information?',             'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_history_contact_text',       'label' => 'GGF History Contact Box Text',  'value' => 'Reach out to us — we are happy to share more about the Foundation and our mission.', 'type' => 'textarea'],
            // Donation page
            ['group' => 'ggf', 'key' => 'ggf_donation_page_title',          'label' => 'GGF Donation Page Title',            'value' => 'Donation',                                'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_meta_description',    'label' => 'GGF Donation Meta Description',      'value' => 'Support the sacred mission of Guru Goraksanatha Foundation through your generous donation.',                                          'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_donation_header_image',        'label' => 'GGF Donation Header Image',          'value' => 'hd-41.png',                               'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_header_title',        'label' => 'GGF Donation Header Title',          'value' => 'Donations',                               'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_header_subtitle',     'label' => 'GGF Donation Header Subtitle',       'value' => 'Every contribution strengthens',          'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_intro',               'label' => 'GGF Donation Intro',                 'value' => 'Guru Goraksanatha Foundation is dedicated to preserving and promoting the ancient Goraksanatha tradition, uplifting spiritual heritage, and contributing to religious, cultural, social, and humanitarian development.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_donation_support_text',        'label' => 'GGF Donation Support Text',          'value' => 'Your generous support helps us continue this noble mission and serve thousands of devotees and visitors every year.',                  'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_donation_why_title',           'label' => 'GGF Donation Why Title',             'value' => 'Why Your Donation Matters',               'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_section1_title',      'label' => 'GGF Donation Section 1 Title',       'value' => '1. Gorakshadham Gorkha Project',          'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_section1_items',      'label' => 'GGF Donation Section 1 Items',       'value' => "Temple restoration & construction\nMeditation centers\nSacred trails & pilgrimage paths\nMuseum, research center & Gurukul\nReligious tourism promotion", 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_donation_section2_title',      'label' => 'GGF Donation Section 2 Title',       'value' => '2. Daily Worship & Ritual Support',       'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_section2_items',      'label' => 'GGF Donation Section 2 Items',       'value' => "Daily Roth preparation\nNitya Puja, Hom, Yagya & spiritual services\nTemple maintenance & preservation", 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_donation_section3_title',      'label' => 'GGF Donation Section 3 Title',       'value' => '3. Culture, Heritage & Youth Programs',  'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_section3_items',      'label' => 'GGF Donation Section 3 Items',       'value' => "Yoga, meditation & spiritual training\nCultural preservation activities\nYouth leadership & volunteer programs", 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_donation_section4_title',      'label' => 'GGF Donation Section 4 Title',       'value' => '4. Documentary & Knowledge Promotion',   'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_section4_items',      'label' => 'GGF Donation Section 4 Items',       'value' => "Promotion of Guru Goraksanatha's teachings\nNepal–India spiritual connection\nReligious tourism in Gorkha, Gorakhkali, Manakamana", 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_donation_section5_title',      'label' => 'GGF Donation Section 5 Title',       'value' => '5. Community Service & Social Welfare',  'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_section5_items',      'label' => 'GGF Donation Section 5 Items',       'value' => "Food distribution\nEmergency relief\nSupport for pilgrims and devotees\nEnvironmental & cleanliness campaigns", 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_donation_helps_title',         'label' => 'GGF Donation Helps Title',           'value' => 'How Your Support Helps',                  'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_helps_items',         'label' => 'GGF Donation Helps Items',           'value' => "Preserving ancient wisdom\nBuilding spiritual infrastructure\nEmpowering future generations\nExpanding global recognition of Guru Goraksanatha's legacy", 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_donation_sewa_text',           'label' => 'GGF Donation Sewa Text',             'value' => 'Each rupee you give becomes a part of sewa.', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_contribution_title',  'label' => 'GGF Donation Contribution Title',    'value' => 'Make a Contribution',                     'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_contribution_items',  'label' => 'GGF Donation Contribution Items',    'value' => "Monthly / Yearly\nOne-time\nProject sponsorship (Temple, Documentary, Roth, Gurukul)\nIn-kind contribution (materials, services)", 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_donation_transparency_text',   'label' => 'GGF Donation Transparency Text',     'value' => 'All donations are utilized with full transparency and accountability.', 'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_gratitude_title',     'label' => 'GGF Donation Gratitude Title',       'value' => 'Gratitude',                               'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_gratitude',           'label' => 'GGF Donation Gratitude',             'value' => 'Your generosity is not only a financial contribution—it is a spiritual offering. May Guru Goraksanatha bless you and your family with health, peace, and prosperity.', 'type' => 'textarea'],
            ['group' => 'ggf', 'key' => 'ggf_donation_qr_title',            'label' => 'GGF Donation QR Title',              'value' => 'Scan to Donate',                          'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_qr_code',             'label' => 'GGF QR Code Image',                  'value' => $images['qr_code'],                        'type' => 'image'],
            ['group' => 'ggf', 'key' => 'ggf_donation_bank_title',          'label' => 'GGF Donation Bank Title',            'value' => 'Bank Details',                            'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_bank_foundation',              'label' => 'GGF Bank Foundation Name',           'value' => 'Guru Goraksanatha Foundation',            'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_bank_name',                    'label' => 'GGF Bank Name',                      'value' => 'Rastriya Banijya Bank Limited',           'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_bank_account',                 'label' => 'GGF Bank Account No',                'value' => '1130100004700001',                        'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_bank_branch',                  'label' => 'GGF Bank Branch',                    'value' => 'Kathmandu',                               'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_form_title',          'label' => 'GGF Donation Form Title',            'value' => 'Upload Donation Slip',                    'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_form_name_label',     'label' => 'GGF Donation Form Name Label',       'value' => 'Your Name',                               'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_form_phone_label',    'label' => 'GGF Donation Form Phone Label',      'value' => 'Phone',                                   'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_form_amount_label',   'label' => 'GGF Donation Form Amount Label',     'value' => 'Amount Donated',                          'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_form_screenshot_label','label' => 'GGF Donation Form Screenshot Label','value' => 'Upload Screenshot (Image / PDF)',         'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_form_submit_label',   'label' => 'GGF Donation Form Submit Label',     'value' => 'Submit Donation',                         'type' => 'text'],
            ['group' => 'ggf', 'key' => 'ggf_donation_success_message',     'label' => 'GGF Donation Success Message',       'value' => 'Thank you! Your donation details were submitted successfully.',  'type' => 'textarea'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], array_merge($setting, ['order' => 1]));
        }

        // ── Sliders ──────────────────────────────────────────────────────────
        Slider::whereIn('title', ['Gorkha', 'Guru Goraksanatha'])->delete();

        Slider::updateOrCreate(['title' => 'Gorkha'], [
            'subtitle'    => 'Sacred Land of Nepal',
            'description' => 'Gorkha is one of Nepal\'s most historically significant and culturally rich regions. Located in the western hills of Nepal, Gorkha is revered as the birthplace of modern Nepal and a sacred land.',
            'image'       => $images['slider_gorkha'],
            'button1_text'=> 'Learn More',
            'button1_url' => '/about-gorkha',
            'is_active'   => true,
            'order'       => 100,
        ]);

        Slider::updateOrCreate(['title' => 'Guru Goraksanatha'], [
            'subtitle'    => 'The Great Yogic Master',
            'description' => 'Guru Goraksanatha (also known as Guru Gorakhnath Baba) is one of the greatest yogic masters and Siddha saints of the Nath Sampradaya.',
            'image'       => $images['slider_guru'],
            'button1_text'=> 'About Guru',
            'button1_url' => '/about-guru-goraksanatha',
            'is_active'   => true,
            'order'       => 101,
        ]);

        // ── Service Categories ───────────────────────────────────────────────
        $ggfServiceCategories = ['Spiritual Programs', 'Community Welfare', 'Education', 'Cultural Preservation'];
        $ggfServiceCategoryModels = [];
        foreach ($ggfServiceCategories as $i => $name) {
            $ggfServiceCategoryModels[$name] = Category::updateOrCreate(
                ['type' => 'service', 'slug' => Str::slug('ggf-' . $name)],
                ['name' => $name, 'type' => 'service', 'is_active' => true, 'order' => 100 + $i]
            );
        }

        // ── Services ─────────────────────────────────────────────────────────
        $ggfServices = [
            ['title' => 'Education & Awareness',     'category' => 'Education',           'icon' => 'im-monitor-phone', 'excerpt' => 'Promoting traditional knowledge, modern education, and holistic learning for all communities.'],
            ['title' => 'Community Welfare',          'category' => 'Community Welfare',   'icon' => 'im-bar-chart2',   'excerpt' => 'Health camps, food relief, youth development, and empowerment programs across Nepal.'],
            ['title' => 'Cultural Preservation',      'category' => 'Cultural Preservation','icon' => 'im-medal',       'excerpt' => 'Preserving the teachings of Guru Gorakhnath, Nath traditions, and Nepali heritage.'],
            ['title' => 'Humanitarian Support',       'category' => 'Community Welfare',   'icon' => 'im-business-man', 'excerpt' => 'Extending help to children, elderly, and vulnerable communities across Nepal.'],
            ['title' => 'Health & Medical Camps',     'category' => 'Community Welfare',   'icon' => 'im-support',      'excerpt' => 'Organizing free medical checkups and vaccination camps for underserved communities.'],
            ['title' => 'Women Empowerment',          'category' => 'Community Welfare',   'icon' => 'im-gears',        'excerpt' => 'Supporting women through skill training, leadership workshops, and small business guidance.'],
            ['title' => 'Youth Development',          'category' => 'Education',           'icon' => 'im-charger',      'excerpt' => 'Engaging youth in community development through training, mentorship, and social initiatives.'],
            ['title' => 'Skill Training',             'category' => 'Education',           'icon' => 'im-pen',          'excerpt' => 'Providing skill-based vocational training to help youth gain employable skills and self-reliance.'],
            ['title' => 'Disaster Relief',            'category' => 'Community Welfare',   'icon' => 'im-data-refresh', 'excerpt' => 'Providing emergency food, shelter, and essential support during natural disasters.'],
            ['title' => 'Environmental Initiatives',  'category' => 'Cultural Preservation','icon' => 'im-globe',       'excerpt' => 'Tree plantation, clean-up campaigns, and environmental awareness for a sustainable future.'],
            ['title' => 'Spiritual Programs',         'category' => 'Spiritual Programs',  'icon' => 'im-star',         'excerpt' => 'Organizing Yagyas, spiritual events, and festivals honoring the Nath tradition.'],
            ['title' => 'Counselling & Guidance',     'category' => 'Community Welfare',   'icon' => 'im-support',      'excerpt' => 'Offering social and psychological support to individuals and families in need.'],
        ];

        foreach ($ggfServices as $i => $data) {
            Service::updateOrCreate(['slug' => Str::slug($data['title'])], [
                'category_id' => $ggfServiceCategoryModels[$data['category']]->id ?? null,
                'title'       => $data['title'],
                'icon'        => $data['icon'],
                'excerpt'     => $data['excerpt'],
                'content'     => '<p>' . $data['excerpt'] . '</p><p>The Guru Goraksanatha Foundation implements this program through community partnerships, volunteer engagement, and transparent resource allocation to ensure maximum impact for every rupee donated.</p>',
                'features'    => [['text' => 'Community-first design'], ['text' => 'Volunteer-driven execution'], ['text' => 'Measurable outcomes']],
                'is_active'   => true,
                'is_featured' => $i < 4,
                'order'       => 100 + $i,
            ]);
        }

        // ── Project Categories ───────────────────────────────────────────────
        $ggfProjectCategories = ['Temple & Heritage', 'Documentary', 'Social Programs', 'Spiritual Events'];
        $ggfProjectCategoryModels = [];
        foreach ($ggfProjectCategories as $i => $name) {
            $ggfProjectCategoryModels[$name] = Category::updateOrCreate(
                ['type' => 'project', 'slug' => Str::slug('ggf-' . $name)],
                ['name' => $name, 'type' => 'project', 'is_active' => true, 'order' => 100 + $i]
            );
        }

        // ── Projects ─────────────────────────────────────────────────────────
        $ggfProjects = [
            [
                'slug'     => 'gorakshadham-gorkha',
                'title'    => 'Gorakshadham Gorkha',
                'category' => 'Temple & Heritage',
                'client'   => '',
                'location' => 'Gorkha, Nepal',
                'year'     => '2024',
                'image'    => $images['gorkha_1975'],
                'excerpt'  => '"<b>गोरखा नै गुरु गोरखनाथको मूल तपोभूमि</b>" Goraksadham Gorkha is the heart of our efforts—a multi-phase spiritual and cultural development project.',
                'highlights' => [
                    ['label' => 'Focus',      'value' => 'Temple Complex'],
                    ['label' => 'Centers',    'value' => 'Gurukul & Yoga'],
                    ['label' => 'Facilities', 'value' => 'Cultural Museums'],
                ],
            ],
            [
                'slug'     => 'documentary-film-goraksadham-gorkha',
                'title'    => 'Documentary Film',
                'category' => 'Documentary',
                'client'   => '',
                'location' => 'Nepal & India',
                'year'     => '2025',
                'image'    => $images['gorkha_2025'],
                'excerpt'  => '"Goraksadham Gorkha – The Sacred Seat of Guru Goraksanatha" — A full-length international documentary.',
                'highlights' => [
                    ['label' => 'Focus',   'value' => 'Historic Connection'],
                    ['label' => 'Promote', 'value' => 'Cultural Tourism'],
                    ['label' => 'Gorkha',  'value' => 'Heritage Destination'],
                ],
            ],
            [
                'slug'     => 'religious-social-programs',
                'title'    => 'Religious & Social Programs',
                'category' => 'Spiritual Events',
                'client'   => 'On Going',
                'location' => 'Nepal',
                'year'     => '2025',
                'image'    => $images['gorakh'],
                'excerpt'  => 'Organizing spiritual events, Yagyas, and festivals, Rohth Management Program.',
                'highlights' => [
                    ['label' => 'Focus',      'value' => 'Heritage preservation'],
                    ['label' => 'Coordinate', 'value' => 'Nepal–India religious'],
                    ['label' => 'Area',       'value' => 'Temple Support'],
                ],
            ],
        ];

        foreach ($ggfProjects as $i => $data) {
            $slug = $data['slug'] ?? Str::slug($data['title']);
            Project::updateOrCreate(['slug' => $slug], [
                'slug'           => $slug,
                'category_id'    => $ggfProjectCategoryModels[$data['category']]->id ?? null,
                'title'          => $data['title'],
                'excerpt'        => $data['excerpt'],
                'content'        => '<p>' . $data['excerpt'] . '</p>',
                'client'         => $data['client'],
                'location'       => $data['location'],
                'year'           => $data['year'],
                'image'          => $data['image'],
                'featured_image' => $data['image'],
                'gallery'        => [$data['image']],
                'highlights'     => $data['highlights'],
                'is_active'      => true,
                'is_featured'    => true,
                'order'          => 100 + $i,
            ]);
        }

        // ── Team Members ─────────────────────────────────────────────────────
        $ggfTeam = [
            [
                'name'       => 'Dr. Subhendu Gupta',
                'position'   => 'Chairperson',
                'department' => 'Leadership',
                'image'      => $images['team_subhendu'],
                'bio'        => 'Strategic lead and founder with a vision to combine spiritual heritage and social development.',
                'full_bio'   => '<p>Dr. Subhendu Gupta is the founding Chairperson of Guru Goraksanatha Foundation. With deep knowledge of Nath spiritual traditions and a commitment to social development, he leads the Foundation\'s strategic vision to establish Gorkha as a global spiritual destination.</p>',
            ],
            [
                'name'       => 'Tilak Bahadur Adhikari',
                'position'   => 'General Secretary',
                'department' => 'Operations',
                'image'      => $images['team_tilak'],
                'bio'        => 'Oversees program delivery, partnerships, and organizational operations.',
                'full_bio'   => '<p>Tilak Bahadur Adhikari serves as General Secretary, overseeing daily operations, partnerships with government and NGOs, and ensuring that every program is delivered with maximum impact.</p>',
            ],
            [
                'name'       => 'Dinesh Khanal',
                'position'   => 'Treasurer / Managing Director',
                'department' => 'Finance',
                'image'      => $images['team_dinesh'],
                'bio'        => 'Designs and supervises education and youth development programs across districts.',
                'full_bio'   => '<p>Dinesh Khanal manages the Foundation\'s financial operations and oversees education and youth development initiatives. His expertise ensures transparent and impactful use of all donor contributions.</p>',
            ],
            [
                'name'       => 'Raju Bhandari',
                'position'   => 'Member',
                'department' => 'Community Relations',
                'image'      => $images['team_raju'],
                'bio'        => 'Active member contributing to community outreach and foundation activities.',
                'full_bio'   => '<p>Raju Bhandari is a dedicated member of the Guru Goraksanatha Foundation, contributing actively to community relations, outreach programs, and cultural events organised by the Foundation.</p>',
            ],
            [
                'name'       => 'Kiran Khanal',
                'position'   => 'Member',
                'department' => 'Community Relations',
                'image'      => $images['team_kiran'],
                'bio'        => 'Active member contributing to community outreach and foundation activities.',
                'full_bio'   => '<p>Kiran Khanal is a dedicated member of the Guru Goraksanatha Foundation, contributing actively to community relations, outreach programs, and cultural events organised by the Foundation.</p>',
            ],
        ];

        foreach ($ggfTeam as $i => $member) {
            TeamMember::updateOrCreate(['slug' => Str::slug($member['name'])], [
                ...$member,
                'skills'      => ['Community Development', 'Spiritual Heritage', $member['department']],
                'is_active'   => true,
                'is_featured' => true,
                'order'       => 100 + $i,
            ]);
        }

        // ── Testimonials ─────────────────────────────────────────────────────
        $ggfTestimonials = [
            ['name' => 'Sita Gurung',        'position' => 'Beneficiary',       'company' => 'Gorkha',           'content' => 'The education scholarship changed my daughter\'s life. She now dreams of becoming a teacher.',    'image' => $images['user_1'], 'rating' => 5],
            ['name' => 'Ramesh Thapa',        'position' => 'Volunteer',         'company' => 'Kavrepalanchok',   'content' => 'Volunteer training gave me skills to lead youth activities in my village.',                    'image' => $images['user_2'], 'rating' => 5],
            ['name' => 'Kamala Bhandari',     'position' => 'Community Leader',  'company' => 'Sindhupalchok',    'content' => 'We received timely medical support during the flood — the team were lifesavers.',               'image' => $images['user_3'], 'rating' => 5],
            ['name' => 'Dr. Hari Subedi',     'position' => 'Researcher',        'company' => '',                 'content' => 'The cultural documentation project helped preserve songs and stories of our elders.',            'image' => $images['user_4'], 'rating' => 5],
        ];

        foreach ($ggfTestimonials as $i => $t) {
            Testimonial::updateOrCreate(['name' => $t['name']], [
                ...$t,
                'is_active'   => true,
                'is_featured' => true,
                'order'       => 100 + $i,
            ]);
        }

        // ── Counters ─────────────────────────────────────────────────────────
        Counter::whereIn('label', [
            'Communities Reached', 'Children Supported', 'Projects Completed', 'Volunteers',
            'Families Supported', 'Active Volunteers',
        ])->delete();

        $ggfCounters = [
            ['label' => 'Communities Reached', 'value' => '47+',  'numeric_value' => 47,  'suffix' => '+', 'icon' => 'im-globe',        'order' => 101],
            ['label' => 'Families Supported',  'value' => '110+', 'numeric_value' => 110, 'suffix' => '+', 'icon' => 'im-business-man', 'order' => 102],
            ['label' => 'Projects Completed',  'value' => '250+', 'numeric_value' => 250, 'suffix' => '+', 'icon' => 'im-charger',      'order' => 103],
            ['label' => 'Active Volunteers',   'value' => '30+',  'numeric_value' => 30,  'suffix' => '+', 'icon' => 'im-support',      'order' => 104],
        ];

        foreach ($ggfCounters as $counter) {
            Counter::create([...$counter, 'is_active' => true]);
        }

        // ── Post Categories (for Programs/Events tabs) ────────────────────────
        $ggfPostCategories = [
            'Education Programs',
            'Health & Medical Camps',
            'Community Development',
            'Environmental Initiatives',
        ];
        $ggfPostCategoryModels = [];
        foreach ($ggfPostCategories as $i => $name) {
            $ggfPostCategoryModels[$name] = Category::updateOrCreate(
                ['type' => 'post', 'slug' => Str::slug('ggf-' . $name)],
                ['name' => $name, 'type' => 'post', 'is_active' => true, 'order' => 100 + $i]
            );
        }

        // ── Program Posts ────────────────────────────────────────────────────
        $ggfPrograms = [
            // Education
            ['title' => 'Scholarships for Students',        'category' => 'Education Programs',       'location' => 'Nepal',             'image' => $images['program_1'], 'excerpt' => 'Providing financial aid and scholarships to underprivileged students to continue their education.'],
            ['title' => 'School Supplies Distribution',      'category' => 'Education Programs',       'location' => 'Local Schools',     'image' => $images['program_2'], 'excerpt' => 'Distributing books, stationery, and learning materials to children in rural and underserved communities.'],
            ['title' => 'Adult Literacy Programs',           'category' => 'Education Programs',       'location' => 'Community Centers', 'image' => $images['program_3'], 'excerpt' => 'Offering literacy classes for adults to empower them with reading, writing, and basic education skills.'],
            ['title' => 'Vocational Training',               'category' => 'Education Programs',       'location' => 'Youth Development', 'image' => $images['program_4'], 'excerpt' => 'Providing skill-based training and workshops to help youth gain employable skills.'],
            // Health
            ['title' => 'Free Health Checkups',              'category' => 'Health & Medical Camps',   'location' => 'Local Clinics',     'image' => $images['program_1'], 'excerpt' => 'Organizing free medical checkups for communities with limited access to healthcare services.'],
            ['title' => 'Vaccination Drives',                'category' => 'Health & Medical Camps',   'location' => 'Rural Areas',       'image' => $images['program_2'], 'excerpt' => 'Conducting vaccination camps to protect children and adults from preventable diseases.'],
            ['title' => 'Health Awareness Workshops',        'category' => 'Health & Medical Camps',   'location' => 'Community Centers', 'image' => $images['program_3'], 'excerpt' => 'Educating communities about hygiene, nutrition, and preventive health measures.'],
            ['title' => 'Emergency Medical Aid',             'category' => 'Health & Medical Camps',   'location' => 'Disaster Response', 'image' => $images['program_4'], 'excerpt' => 'Providing immediate medical assistance during natural disasters and emergencies.'],
            // Community
            ['title' => 'Women Empowerment Programs',        'category' => 'Community Development',    'location' => 'Nepal Communities', 'image' => $images['program_1'], 'excerpt' => 'Supporting women through skill training, leadership workshops, and small business guidance.'],
            ['title' => 'Youth Leadership Workshops',        'category' => 'Community Development',    'location' => 'Rural & Urban Areas','image' => $images['program_2'], 'excerpt' => 'Engaging youth in community development through training, mentorship, and social initiatives.'],
            ['title' => 'Disaster Relief Programs',          'category' => 'Community Development',    'location' => 'Affected Regions',  'image' => $images['program_3'], 'excerpt' => 'Providing food, shelter, and essential support to communities affected by floods and earthquakes.'],
            ['title' => 'Community Awareness Campaigns',     'category' => 'Community Development',    'location' => 'Local Villages',    'image' => $images['program_4'], 'excerpt' => 'Conducting campaigns to educate communities about health, education, environment, and social welfare.'],
            // Environment
            ['title' => 'Tree Plantation Drives',            'category' => 'Environmental Initiatives','location' => 'Local Communities', 'image' => $images['program_1'], 'excerpt' => 'Organizing tree planting events to improve the environment and promote sustainability.'],
            ['title' => 'Clean-up Campaigns',                'category' => 'Environmental Initiatives','location' => 'Rivers & Public Areas','image' => $images['program_2'], 'excerpt' => 'Conducting clean-up activities to maintain public spaces and preserve natural resources.'],
            ['title' => 'Environmental Awareness Workshops', 'category' => 'Environmental Initiatives','location' => 'Schools & Communities','image' => $images['program_3'], 'excerpt' => 'Educating citizens about sustainable practices, waste management, and conservation.'],
        ];

        foreach ($ggfPrograms as $i => $data) {
            Post::updateOrCreate(['slug' => Str::slug($data['title'])], [
                'category_id'    => $ggfPostCategoryModels[$data['category']]->id ?? null,
                'title'          => $data['title'],
                'excerpt'        => $data['excerpt'],
                'content'        => '<p>' . $data['excerpt'] . '</p><p>Guru Goraksanatha Foundation implements this program through dedicated volunteers and community partnerships, ensuring maximum positive impact for beneficiaries across Nepal.</p>',
                'featured_image' => $data['image'],
                'status'         => 'published',
                'published_at'   => now()->subDays($i + 1),
                'is_featured'    => $i < 4,
                'allow_comments' => false,
                'read_time'      => '2 min read',
            ]);
        }

        // ── Static Pages ─────────────────────────────────────────────────────
        $ggfPages = [
            [
                'slug'     => 'ggf-about',
                'title'    => 'About Guru Goraksanatha Foundation',
                'template' => 'about',
                'featured_image' => $images['about_guru'],
                'content'  => null,
            ],
            [
                'slug'     => 'ggf-history',
                'title'    => 'History of the Foundation',
                'template' => 'page',
                'featured_image' => $images['gorkha_1975'],
                'content'  => null,
            ],
            [
                'slug'          => 'ggf-about-guru-goraksanatha',
                'title'         => 'About Guru Goraksanatha',
                'template'      => 'page',
                'featured_image' => $images['about_guru'],
                'meta_description' => 'Learn about Guru Goraksanatha, the great yogic master and Siddha saint of the Nath Sampradaya.',
                'content'  => '<div class="row row-fit-lg">
<div class="col-lg-8">
<div class="title"><h2>Guru Goraksanatha</h2><p>The Great Yogic Master</p></div>
<p style="text-align:justify;">Guru Goraksanatha (also known as Guru Gorakhnath Baba) is one of the greatest yogic masters and Siddha saints of the Nath Sampradaya, a sacred Shaiva–yogic tradition rooted in Sanatan Dharma. Revered across Nepal, India, and beyond, Guru Goraksanatha is worshipped as a divine incarnation who mastered yoga, meditation, and spiritual science.</p>
<p style="text-align:justify;">He is the patron saint of Gorkha district of Nepal, where the Gorakhnath temple at the top of the Gorkha Durbar complex stands as a symbol of his divine presence. The Gorkha kingdom, from which Nepal was unified, derives its name from Guru Goraksanatha.</p>
<p style="text-align:justify;">His teachings emphasize yoga, self-realization, renunciation, and service to humanity. The Nath Sampradaya, which he shaped, continues to inspire millions of spiritual seekers across the world.</p>
</div>
<div class="col-lg-4">
<img src="' . asset('ggf/media/abt-guru-goraksanatha.jpg') . '" alt="Guru Goraksanatha" style="width:100%;" />
</div>
</div>',
            ],
            [
                'slug'          => 'ggf-about-gorkha',
                'title'         => 'About Gorkha',
                'template'      => 'page',
                'featured_image' => $images['about_gorkha'],
                'meta_description' => 'Gorkha is one of Nepal\'s most historically significant and culturally rich regions.',
                'content'  => '<div class="row row-fit-lg">
<div class="col-lg-8">
<div class="title"><h2>About Gorkha</h2><p>The Sacred Land</p></div>
<p style="text-align:justify;">Gorkha is one of Nepal\'s most historically significant and culturally rich regions. Located in the western hills of Nepal, Gorkha is revered as the birthplace of modern Nepal and a sacred land deeply rooted in spiritual and historical traditions.</p>
<p style="text-align:justify;">The district is historically known as the divine tapobhoomi (meditation ground) of Guru Goraksanatha. The Gorakhnath temple, situated at the top of the Gorkha Durbar complex, stands as a powerful symbol of the region\'s deep spiritual heritage.</p>
<p style="text-align:justify;">King Prithvi Narayan Shah, who unified Nepal, was inspired by the blessings of Guru Goraksanatha and launched his campaign from Gorkha. Today, Gorkha remains a center of devotion, pilgrimage, and cultural pride for Nepalis worldwide.</p>
</div>
<div class="col-lg-4">
<ul class="slider light" data-options="arrows:false,nav:true">
<li><img src="' . asset('ggf/media/abt-gorkha.jpg') . '" alt="Gorkha" /></li>
<li><img src="' . asset('ggf/media/gorkha-1975.png') . '" alt="Gorkha 1975" /></li>
<li><img src="' . asset('ggf/media/gorkha-2025.png') . '" alt="Gorkha 2025" /></li>
</ul>
</div>
</div>',
            ],
            [
                'slug'          => 'ggf-about-naraharinath',
                'title'         => 'Who is Yogi Naraharinath?',
                'template'      => 'page',
                'featured_image' => $images['yogi'],
                'meta_description' => 'Learn about Yogi Naraharinath, a great scholar of Nath tradition.',
                'content'  => '<div class="row row-fit-lg">
<div class="col-lg-8">
<div class="title"><h2>Yogi Naraharinath</h2><p>Scholar of the Nath Tradition</p></div>
<p style="text-align:justify;">Balbir Singh Thapa, born on Falgun 17, Bikram Sambat 1971 (1915 CE) in Kalikot to father Shri Lalit Singh Thapa and mother Smt. Gauradevi, was later initiated into the Nath tradition and became Yogi Naraharinath.</p>
<p style="text-align:justify;">Yogi Naraharinath was one of the most prolific and dedicated scholars and researchers of the Nath Sampradaya in the 20th century. He authored and edited numerous texts on Nath philosophy, history, and culture, making invaluable contributions to the preservation of Nepal\'s spiritual heritage.</p>
<p style="text-align:justify;">His tireless efforts to document and preserve ancient manuscripts, temple histories, and yogic traditions serve as a foundation for the work of Guru Goraksanatha Foundation today.</p>
</div>
<div class="col-lg-4">
<img src="' . asset('ggf/media/yogi-narharinath.jpg') . '" alt="Yogi Naraharinath" style="width:100%;" />
</div>
</div>',
            ],
        ];

        foreach ($ggfPages as $pageData) {
            $content = $pageData['content'] ?? null;
            unset($pageData['content']);
            Page::updateOrCreate(['slug' => $pageData['slug']], array_merge($pageData, [
                'status'       => 'published',
                'order'        => 100,
                'content'      => $content,
                'show_in_sitemap' => false,
            ]));
        }

        $this->command->info('GGF content seeded successfully!');
    }

    private function seedImage(string $filename, string $destination): string
    {
        $sourcePath      = public_path('ggf/media/' . $filename);
        $destination     = 'seeded/' . ltrim($destination, '/');
        $destinationPath = storage_path('app/public/' . $destination);

        if (file_exists($sourcePath)) {
            if (!is_dir(dirname($destinationPath))) {
                mkdir(dirname($destinationPath), 0755, true);
            }
            copy($sourcePath, $destinationPath);
        }

        return $destination;
    }
}
