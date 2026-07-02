<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Counter;
use App\Models\FaqCategory;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Project;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Tag;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            'logo' => $this->seedImage('assets/img/logo/black-logo.svg', 'branding/logo.svg'),
            'logo_white' => $this->seedImage('assets/img/logo/white-logo.svg', 'branding/logo-white.svg'),
            'favicon' => $this->seedImage('assets/img/idea-gen-fav.png', 'branding/favicon.png'),
            'breadcrumb' => $this->seedImage('assets/img/breadcrumb.jpg', 'pages/breadcrumb.jpg'),
            'about' => $this->seedImage('assets/img/home-5/about-1.jpg', 'pages/about.jpg'),
            'services' => $this->seedImage('assets/img/home-5/security.jpg', 'pages/services.jpg'),
            'projects' => $this->seedImage('assets/img/home-5/project/01.jpg', 'pages/projects.jpg'),
            'team' => $this->seedImage('assets/img/home-3/team/team-01.jpg', 'pages/team.jpg'),
            'blog' => $this->seedImage('assets/img/home-5/news-1.jpg', 'pages/blog.jpg'),
            'contact' => $this->seedImage('assets/img/inner-page/contact-1.jpg', 'pages/contact.jpg'),
            'service_web' => $this->seedImage('assets/img/inner-page/service-details/details-1.jpg', 'services/web-development.jpg'),
            'service_marketing' => $this->seedImage('assets/img/inner-page/service-details/details-2.jpg', 'services/digital-marketing.jpg'),
            'service_design' => $this->seedImage('assets/img/inner-page/service-details/details-3.jpg', 'services/brand-design.jpg'),
            'service_seo' => $this->seedImage('assets/img/inner-page/service-details/details-4.jpg', 'services/seo-analytics.jpg'),
            'project_1' => $this->seedImage('assets/img/home-5/project/01.jpg', 'projects/business-website.jpg'),
            'project_2' => $this->seedImage('assets/img/home-5/project/02.jpg', 'projects/growth-campaign.jpg'),
            'project_3' => $this->seedImage('assets/img/home-5/project/03.jpg', 'projects/brand-refresh.jpg'),
            'project_4' => $this->seedImage('assets/img/home-5/project/04.jpg', 'projects/content-production.jpg'),
            'team_1' => $this->seedImage('assets/img/home-3/team/team-01.jpg', 'team/dipendra-acharya.jpg'),
            'team_2' => $this->seedImage('assets/img/home-3/team/team-02.jpg', 'team/anuj-kumar-joshi.jpg'),
            'team_3' => $this->seedImage('assets/img/home-3/team/team-03.jpg', 'team/yagya-raj-bhatta.jpg'),
            'team_4' => $this->seedImage('assets/img/home-3/team/team-04.jpg', 'team/amit-maharjan.jpg'),
            'blog_1' => $this->seedImage('assets/img/home-5/news-1.jpg', 'blog/website-growth.jpg'),
            'blog_2' => $this->seedImage('assets/img/home-5/news-2.jpg', 'blog/digital-goals.jpg'),
            'blog_3' => $this->seedImage('assets/img/home-8/news/01.jpg', 'blog/creative-content.jpg'),
            'home_hero' => $this->seedImage('assets/img/home-3/hero/hero-image.png', 'home/hero-image.png'),
            'home_hero_line_shape' => $this->seedImage('assets/img/home-3/hero/line-shape.png', 'home/hero-line-shape.png'),
            'home_hero_rating' => $this->seedImage('assets/img/home-3/hero/ratting.png', 'home/hero-rating.png'),
            'home_hero_text_circle' => $this->seedImage('assets/img/home-3/hero/text-circle.png', 'home/hero-text-circle.png'),
            'home_hero_client_1' => $this->seedImage('assets/img/home-1/hero/client-1.png', 'home/hero-client-1.png'),
            'home_hero_client_2' => $this->seedImage('assets/img/home-1/hero/client-2.png', 'home/hero-client-2.png'),
            'home_hero_client_3' => $this->seedImage('assets/img/home-1/hero/client-3.png', 'home/hero-client-3.png'),
            'home_about' => $this->seedImage('assets/img/home-3/about-image.jpg', 'home/about-image.jpg'),
            'home_about_info' => $this->seedImage('assets/img/home-3/about-info.png', 'home/about-info.png'),
            'home_chooseus' => $this->seedImage('assets/img/home-3/choose-us-image.jpg', 'home/choose-us-image.jpg'),
            'home_chooseus_graph' => $this->seedImage('assets/img/home-3/grap.png', 'home/choose-us-graph.png'),
            'home_chooseus_icon_1' => $this->seedImage('assets/img/home-3/icon/icon-6.svg', 'home/choose-us-icon-1.svg'),
            'home_chooseus_icon_2' => $this->seedImage('assets/img/home-3/icon/icon-7.svg', 'home/choose-us-icon-2.svg'),
            'home_chooseus_icon_3' => $this->seedImage('assets/img/home-3/icon/icon-8.svg', 'home/choose-us-icon-3.svg'),
            'home_section_setting_icon' => $this->seedImage('assets/img/home-5/setting.png', 'home/section-setting-icon.png'),
            'home_faq_setting_icon' => $this->seedImage('assets/img/home-1/hero/setting.png', 'home/faq-setting-icon.png'),
            'home_marquee_star' => $this->seedImage('assets/img/home-2/star.png', 'home/marquee-star.png'),
            'home_projects_line_shape' => $this->seedImage('assets/img/home-3/project/line-shape.png', 'home/projects-line-shape.png'),
            'home_team_line_shape' => $this->seedImage('assets/img/home-3/team/line-shape.png', 'home/team-line-shape.png'),
            'partner_1' => $this->seedImage('assets/img/home-1/brand/brand-1.png', 'partners/brand-1.png'),
            'partner_2' => $this->seedImage('assets/img/home-1/brand/brand-2.png', 'partners/brand-2.png'),
            'partner_3' => $this->seedImage('assets/img/home-1/brand/brand-3.png', 'partners/brand-3.png'),
            'partner_4' => $this->seedImage('assets/img/home-1/brand/brand-4.png', 'partners/brand-4.png'),
            'partner_5' => $this->seedImage('assets/img/home-1/brand/brand-5.png', 'partners/brand-5.png'),
            'partner_6' => $this->seedImage('assets/img/home-1/brand/brand-6.png', 'partners/brand-6.png'),
        ];

        $settings = [
            ['group' => 'general', 'key' => 'site_name', 'label' => 'Site Name', 'value' => 'Idea Gen', 'type' => 'text', 'order' => 1],
            ['group' => 'general', 'key' => 'site_tagline', 'label' => 'Tagline', 'value' => 'Digital marketing and IT solutions for growing businesses.', 'type' => 'text', 'order' => 2],
            ['group' => 'general', 'key' => 'site_logo', 'label' => 'Logo', 'value' => $images['logo'], 'type' => 'image', 'order' => 3],
            ['group' => 'general', 'key' => 'site_favicon', 'label' => 'Favicon', 'value' => $images['favicon'], 'type' => 'image', 'order' => 4],
            ['group' => 'seo', 'key' => 'meta_title', 'label' => 'Default Meta Title', 'value' => 'Idea Gen - Digital Marketing & IT Solutions', 'type' => 'text', 'order' => 1],
            ['group' => 'seo', 'key' => 'meta_description', 'label' => 'Default Meta Description', 'value' => 'Idea Gen helps businesses grow with websites, digital marketing, branding, content, SEO, and IT solutions.', 'type' => 'textarea', 'order' => 2],
            ['group' => 'contact', 'key' => 'contact_address', 'label' => 'Address', 'value' => 'Putalisadak-28, Kathmandu, Nepal', 'type' => 'text', 'order' => 1],
            ['group' => 'contact', 'key' => 'contact_phone', 'label' => 'Phone', 'value' => '+977-01-4168335', 'type' => 'text', 'order' => 2],
            ['group' => 'contact', 'key' => 'contact_email', 'label' => 'Email', 'value' => 'info@ideagen.com.np', 'type' => 'email', 'order' => 3],
            ['group' => 'contact', 'key' => 'contact_hours', 'label' => 'Working Hours', 'value' => 'Sun-Fri, 09am - 6pm', 'type' => 'text', 'order' => 4],
            ['group' => 'general', 'key' => 'home_meta_title', 'label' => 'Home Meta Title', 'value' => 'Idea Gen - Digital Marketing & IT Solutions', 'type' => 'text', 'order' => 10],
            ['group' => 'general', 'key' => 'home_meta_description', 'label' => 'Home Meta Description', 'value' => 'Idea Gen provides website development, digital marketing, SEO, branding, video production, and IT solutions in Kathmandu, Nepal.', 'type' => 'textarea', 'order' => 11],
            ['group' => 'general', 'key' => 'home_hero_title', 'label' => 'Home Hero Title', 'value' => 'Empowering Businesses With Innovative Digital.', 'type' => 'text', 'order' => 12],
            ['group' => 'general', 'key' => 'home_hero_description', 'label' => 'Home Hero Description', 'value' => 'We provide data-driven digital marketing and IT solutions to help companies identify opportunities, reduce risk, and achieve long-term growth. Based in Kathmandu, serving global clients.', 'type' => 'textarea', 'order' => 13],
            ['group' => 'general', 'key' => 'home_hero_btn1_text', 'label' => 'Home Hero Button Text', 'value' => 'Get started', 'type' => 'text', 'order' => 14],
            ['group' => 'general', 'key' => 'home_hero_btn1_url', 'label' => 'Home Hero Button Url', 'value' => '/contact', 'type' => 'url', 'order' => 15],
            ['group' => 'general', 'key' => 'home_hero_video_url', 'label' => 'Home Hero Video Url', 'value' => 'https://www.youtube.com/watch?v=Cn4G2lZ_g2I', 'type' => 'url', 'order' => 16],
            ['group' => 'general', 'key' => 'home_hero_client_count', 'label' => 'Home Hero Client Count', 'value' => '100+', 'type' => 'text', 'order' => 17],
            ['group' => 'general', 'key' => 'home_hero_line_shape_image', 'label' => 'Home Hero Line Shape Image', 'value' => $images['home_hero_line_shape'], 'type' => 'image', 'order' => 18],
            ['group' => 'general', 'key' => 'home_hero_rating_image', 'label' => 'Home Hero Rating Image', 'value' => $images['home_hero_rating'], 'type' => 'image', 'order' => 18],
            ['group' => 'general', 'key' => 'home_hero_text_circle_image', 'label' => 'Home Hero Text Circle Image', 'value' => $images['home_hero_text_circle'], 'type' => 'image', 'order' => 19],
            ['group' => 'general', 'key' => 'home_hero_client_image_1', 'label' => 'Home Hero Client Image 1', 'value' => $images['home_hero_client_1'], 'type' => 'image', 'order' => 20],
            ['group' => 'general', 'key' => 'home_hero_client_image_2', 'label' => 'Home Hero Client Image 2', 'value' => $images['home_hero_client_2'], 'type' => 'image', 'order' => 21],
            ['group' => 'general', 'key' => 'home_hero_client_image_3', 'label' => 'Home Hero Client Image 3', 'value' => $images['home_hero_client_3'], 'type' => 'image', 'order' => 22],
            ['group' => 'general', 'key' => 'home_about_count', 'label' => 'Home About Count', 'value' => '150', 'type' => 'text', 'order' => 23],
            ['group' => 'general', 'key' => 'home_about_count_suffix', 'label' => 'Home About Count Suffix', 'value' => '+', 'type' => 'text', 'order' => 24],
            ['group' => 'general', 'key' => 'home_about_stat_title', 'label' => 'Home About Stat Title', 'value' => 'Projects completed globally.', 'type' => 'text', 'order' => 25],
            ['group' => 'general', 'key' => 'home_about_stat_desc', 'label' => 'Home About Stat Description', 'value' => '3+ years of excellence, 100+ happy clients, 99.99% success rate.', 'type' => 'textarea', 'order' => 26],
            ['group' => 'general', 'key' => 'home_about_title', 'label' => 'Home About Title', 'value' => 'Empowering businesses with innovative digital marketing & IT strategies to drive growth.', 'type' => 'textarea', 'order' => 27],
            ['group' => 'general', 'key' => 'home_about_description', 'label' => 'Home About Description', 'value' => 'Idea Gen Pvt. Ltd., based in Putalisadak, Kathmandu, is a trusted digital partner. We blend technology and creativity to help businesses build brand presence, improve online visibility, and achieve measurable success. Led by Er. Shailesh Shankhi, our team brings 4-8 years of experience per member.', 'type' => 'textarea', 'order' => 28],
            ['group' => 'general', 'key' => 'home_about_btn_text', 'label' => 'Home About Button Text', 'value' => 'About More Us', 'type' => 'text', 'order' => 29],
            ['group' => 'general', 'key' => 'home_about_btn_url', 'label' => 'Home About Button Url', 'value' => '/about', 'type' => 'url', 'order' => 30],
            ['group' => 'general', 'key' => 'home_about_image', 'label' => 'Home About Image', 'value' => $images['home_about'], 'type' => 'image', 'order' => 31],
            ['group' => 'general', 'key' => 'home_about_info_image', 'label' => 'Home About Info Image', 'value' => $images['home_about_info'], 'type' => 'image', 'order' => 32],
            ['group' => 'general', 'key' => 'home_about_review_count', 'label' => 'Home About Review Count', 'value' => '100+', 'type' => 'text', 'order' => 33],
            ['group' => 'general', 'key' => 'home_services_subtitle', 'label' => 'Home Services Subtitle', 'value' => 'EXPLORE OUR SERVICES', 'type' => 'text', 'order' => 34],
            ['group' => 'general', 'key' => 'home_services_title', 'label' => 'Home Services Title', 'value' => 'Results-Driven Digital <br> Marketing & IT Solutions.', 'type' => 'richtext', 'order' => 35],
            ['group' => 'general', 'key' => 'home_section_setting_icon', 'label' => 'Home Section Setting Icon', 'value' => $images['home_section_setting_icon'], 'type' => 'image', 'order' => 35],
            ['group' => 'general', 'key' => 'home_chooseus_image', 'label' => 'Home Choose Us Image', 'value' => $images['home_chooseus'], 'type' => 'image', 'order' => 36],
            ['group' => 'general', 'key' => 'home_chooseus_graph_image', 'label' => 'Home Choose Us Graph Image', 'value' => $images['home_chooseus_graph'], 'type' => 'image', 'order' => 37],
            ['group' => 'general', 'key' => 'home_chooseus_subtitle', 'label' => 'Home Choose Us Subtitle', 'value' => 'REASONS TO CHOOSE US', 'type' => 'text', 'order' => 38],
            ['group' => 'general', 'key' => 'home_chooseus_title', 'label' => 'Home Choose Us Title', 'value' => 'Trusted solutions for your Digital & IT needs.', 'type' => 'textarea', 'order' => 39],
            ['group' => 'general', 'key' => 'home_chooseus_item1_icon', 'label' => 'Home Choose Us Item 1 Icon', 'value' => $images['home_chooseus_icon_1'], 'type' => 'image', 'order' => 40],
            ['group' => 'general', 'key' => 'home_chooseus_item1_title', 'label' => 'Home Choose Us Item 1 Title', 'value' => 'Innovative solutions', 'type' => 'text', 'order' => 40],
            ['group' => 'general', 'key' => 'home_chooseus_item1_desc', 'label' => 'Home Choose Us Item 1 Description', 'value' => 'We combine modern tech with creative marketing to deliver unique, effective results.', 'type' => 'textarea', 'order' => 41],
            ['group' => 'general', 'key' => 'home_chooseus_item2_icon', 'label' => 'Home Choose Us Item 2 Icon', 'value' => $images['home_chooseus_icon_2'], 'type' => 'image', 'order' => 42],
            ['group' => 'general', 'key' => 'home_chooseus_item2_title', 'label' => 'Home Choose Us Item 2 Title', 'value' => 'Winning expertise', 'type' => 'text', 'order' => 42],
            ['group' => 'general', 'key' => 'home_chooseus_item2_desc', 'label' => 'Home Choose Us Item 2 Description', 'value' => 'Team members have 4-8 years of professional experience across IT and marketing.', 'type' => 'textarea', 'order' => 43],
            ['group' => 'general', 'key' => 'home_chooseus_item3_icon', 'label' => 'Home Choose Us Item 3 Icon', 'value' => $images['home_chooseus_icon_3'], 'type' => 'image', 'order' => 44],
            ['group' => 'general', 'key' => 'home_chooseus_item3_title', 'label' => 'Home Choose Us Item 3 Title', 'value' => 'Dedicated support', 'type' => 'text', 'order' => 44],
            ['group' => 'general', 'key' => 'home_chooseus_item3_desc', 'label' => 'Home Choose Us Item 3 Description', 'value' => 'We provide quick, effective support to keep your business running smoothly.', 'type' => 'textarea', 'order' => 45],
            ['group' => 'general', 'key' => 'home_marquee_items', 'label' => 'Home Marquee Items', 'value' => 'Digital, Marketing, IT Solutions, Branding, Web Dev, SEO, Video', 'type' => 'text', 'order' => 46],
            ['group' => 'general', 'key' => 'home_marquee_star_image', 'label' => 'Home Marquee Star Image', 'value' => $images['home_marquee_star'], 'type' => 'image', 'order' => 47],
            ['group' => 'general', 'key' => 'home_projects_subtitle', 'label' => 'Home Projects Subtitle', 'value' => 'EXPLORE PORTFOLIO', 'type' => 'text', 'order' => 47],
            ['group' => 'general', 'key' => 'home_projects_title', 'label' => 'Home Projects Title', 'value' => 'Work examples across industries.', 'type' => 'text', 'order' => 48],
            ['group' => 'general', 'key' => 'home_projects_description', 'label' => 'Home Projects Description', 'value' => 'We have partnered with brands across industries to deliver impactful digital solutions.', 'type' => 'textarea', 'order' => 49],
            ['group' => 'general', 'key' => 'home_projects_btn_text', 'label' => 'Home Projects Button Text', 'value' => 'Explore more', 'type' => 'text', 'order' => 50],
            ['group' => 'general', 'key' => 'home_projects_line_shape_image', 'label' => 'Home Projects Line Shape Image', 'value' => $images['home_projects_line_shape'], 'type' => 'image', 'order' => 51],
            ['group' => 'general', 'key' => 'home_testimonials_subtitle', 'label' => 'Home Testimonials Subtitle', 'value' => 'CLIENT TESTIMONIALS', 'type' => 'text', 'order' => 51],
            ['group' => 'general', 'key' => 'home_testimonials_title', 'label' => 'Home Testimonials Title', 'value' => 'Experiences that build <br>business trust.', 'type' => 'richtext', 'order' => 52],
            ['group' => 'general', 'key' => 'home_team_subtitle', 'label' => 'Home Team Subtitle', 'value' => 'OUR EXPERT TEAM', 'type' => 'text', 'order' => 53],
            ['group' => 'general', 'key' => 'home_team_title', 'label' => 'Home Team Title', 'value' => 'Dedicated professionals behind the work.', 'type' => 'text', 'order' => 54],
            ['group' => 'general', 'key' => 'home_team_description', 'label' => 'Home Team Description', 'value' => 'Meet the leaders and creators driving digital success.', 'type' => 'textarea', 'order' => 55],
            ['group' => 'general', 'key' => 'home_team_btn_text', 'label' => 'Home Team Button Text', 'value' => 'More members', 'type' => 'text', 'order' => 56],
            ['group' => 'general', 'key' => 'home_team_line_shape_image', 'label' => 'Home Team Line Shape Image', 'value' => $images['home_team_line_shape'], 'type' => 'image', 'order' => 57],
            ['group' => 'general', 'key' => 'home_faq_subtitle', 'label' => 'Home FAQ Subtitle', 'value' => 'FAQ', 'type' => 'text', 'order' => 57],
            ['group' => 'general', 'key' => 'home_faq_title', 'label' => 'Home FAQ Title', 'value' => 'Frequently asked questions', 'type' => 'text', 'order' => 58],
            ['group' => 'general', 'key' => 'home_faq_description', 'label' => 'Home FAQ Description', 'value' => 'We are a results-driven digital & IT consulting team helping businesses unlock efficiency.', 'type' => 'textarea', 'order' => 59],
            ['group' => 'general', 'key' => 'home_faq_setting_icon', 'label' => 'Home FAQ Setting Icon', 'value' => $images['home_faq_setting_icon'], 'type' => 'image', 'order' => 60],
            ['group' => 'general', 'key' => 'home_faq_cta_text', 'label' => 'Home FAQ CTA Text', 'value' => 'Contact us', 'type' => 'text', 'order' => 61],
            ['group' => 'general', 'key' => 'home_faq_cta_url', 'label' => 'Home FAQ CTA Url', 'value' => '/contact', 'type' => 'url', 'order' => 62],
            ['group' => 'pages', 'key' => 'services_breadcrumb_image', 'label' => 'Services Breadcrumb Image', 'value' => $images['services'], 'type' => 'image', 'order' => 1],
            ['group' => 'pages', 'key' => 'services_page_subtitle', 'label' => 'Services Subtitle', 'value' => 'What We Do', 'type' => 'text', 'order' => 2],
            ['group' => 'pages', 'key' => 'services_page_title', 'label' => 'Services Title', 'value' => 'Digital Services Built Around Growth', 'type' => 'text', 'order' => 3],
            ['group' => 'pages', 'key' => 'services_page_description', 'label' => 'Services Description', 'value' => 'From websites and SEO to brand content and campaigns, every service is structured to support clear business goals.', 'type' => 'textarea', 'order' => 4],
            ['group' => 'pages', 'key' => 'projects_breadcrumb_image', 'label' => 'Projects Breadcrumb Image', 'value' => $images['projects'], 'type' => 'image', 'order' => 5],
            ['group' => 'pages', 'key' => 'projects_page_subtitle', 'label' => 'Projects Subtitle', 'value' => 'Selected Work', 'type' => 'text', 'order' => 6],
            ['group' => 'pages', 'key' => 'projects_page_title', 'label' => 'Projects Title', 'value' => 'Projects That Turn Ideas Into Results', 'type' => 'text', 'order' => 7],
            ['group' => 'pages', 'key' => 'projects_page_description', 'label' => 'Projects Description', 'value' => 'Explore sample work across websites, campaigns, branding, content, and digital strategy.', 'type' => 'textarea', 'order' => 8],
            ['group' => 'pages', 'key' => 'team_breadcrumb_image', 'label' => 'Team Breadcrumb Image', 'value' => $images['team'], 'type' => 'image', 'order' => 9],
            ['group' => 'pages', 'key' => 'team_page_subtitle', 'label' => 'Team Subtitle', 'value' => 'Our Team', 'type' => 'text', 'order' => 10],
            ['group' => 'pages', 'key' => 'team_page_title', 'label' => 'Team Title', 'value' => 'People Behind The Work', 'type' => 'text', 'order' => 11],
            ['group' => 'pages', 'key' => 'team_page_description', 'label' => 'Team Description', 'value' => 'Strategy, design, development, marketing, and operations working together from idea to launch.', 'type' => 'textarea', 'order' => 12],
            ['group' => 'pages', 'key' => 'blog_breadcrumb_image', 'label' => 'Blog Breadcrumb Image', 'value' => $images['blog'], 'type' => 'image', 'order' => 13],
            ['group' => 'pages', 'key' => 'blog_page_subtitle', 'label' => 'Blog Subtitle', 'value' => 'Insights', 'type' => 'text', 'order' => 14],
            ['group' => 'pages', 'key' => 'blog_page_title', 'label' => 'Blog Title', 'value' => 'Digital Growth Notes', 'type' => 'text', 'order' => 15],
            ['group' => 'pages', 'key' => 'blog_page_description', 'label' => 'Blog Description', 'value' => 'Practical notes on websites, marketing, branding, content, and technology decisions.', 'type' => 'textarea', 'order' => 16],
            ['group' => 'pages', 'key' => 'contact_breadcrumb_image', 'label' => 'Contact Breadcrumb Image', 'value' => $images['contact'], 'type' => 'image', 'order' => 17],
            ['group' => 'pages', 'key' => 'contact_page_image', 'label' => 'Contact Page Image', 'value' => $images['contact'], 'type' => 'image', 'order' => 18],
            ['group' => 'pages', 'key' => 'contact_page_subtitle', 'label' => 'Contact Subtitle', 'value' => 'Contact', 'type' => 'text', 'order' => 19],
            ['group' => 'pages', 'key' => 'contact_page_title', 'label' => 'Contact Title', 'value' => 'Start A Conversation', 'type' => 'text', 'order' => 20],
            ['group' => 'pages', 'key' => 'contact_page_description', 'label' => 'Contact Description', 'value' => 'Tell us what you are building, improving, or trying to solve. We will help you shape the next practical step.', 'type' => 'textarea', 'order' => 21],
            ['group' => 'pages', 'key' => 'contact_form_title', 'label' => 'Contact Form Title', 'value' => 'Send Us a Message', 'type' => 'text', 'order' => 22],
            ['group' => 'pages', 'key' => 'about_team_subtitle', 'label' => 'About Team Subtitle', 'value' => 'Our Team', 'type' => 'text', 'order' => 23],
            ['group' => 'pages', 'key' => 'about_team_title', 'label' => 'About Team Title', 'value' => 'The People Behind Idea Gen', 'type' => 'text', 'order' => 24],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        Service::whereIn('slug', [
            'web-development',
            'uiux-design',
            'ui-ux-design',
            'seo-optimization',
            'mobile-development',
            'cloud-solutions',
        ])->delete();

        TeamMember::whereIn('slug', [
            'john-smith',
            'sarah-johnson',
            'mike-davis',
            'emily-brown',
        ])->delete();

        Testimonial::whereIn('name', [
            'Alice Williams',
            'Bob Anderson',
            'Carol Martinez',
        ])->delete();

        // Sliders
        Slider::query()->delete();
        Slider::updateOrCreate(['title' => 'Empowering Businesses With Innovative Digital.'], [
            'subtitle'      => 'Digital Solutions That Drive Results',
            'description'   => 'We provide data-driven digital marketing and IT solutions to help companies identify opportunities, reduce risk, and achieve long-term growth. Based in Kathmandu, serving global clients.',
            'image'         => $images['home_hero'],
            'mobile_image'  => $images['home_hero'],
            'badge_text'    => 'Idea Gen',
            'button1_text'  => 'Get started',
            'button1_url'   => '/contact',
            'video_url'     => 'https://www.youtube.com/watch?v=Cn4G2lZ_g2I',
            'button2_text'  => 'Get A Quote',
            'button2_url'   => '/contact',
            'button2_style' => 'outline',
            'is_active'     => true,
            'order'         => 1,
        ]);

        // Home page
        Page::updateOrCreate(['slug' => 'home'], [
            'title'    => 'Home',
            'template' => 'home',
            'status'   => 'published',
            'featured_image' => $images['home_hero'],
            'meta_title' => 'Idea Gen - Digital Marketing & IT Solutions',
            'meta_description' => 'Idea Gen provides website development, digital marketing, SEO, branding, video production, and IT solutions in Kathmandu, Nepal.',
            'order'    => 0,
        ]);

        // About page
        Page::updateOrCreate(['slug' => 'about'], [
            'title'       => 'About Us',
            'template'    => 'about',
            'status'      => 'published',
            'featured_image' => $images['about'],
            'content'     => '<h2>We help businesses move from idea to digital impact.</h2><p>Idea Gen is a Kathmandu-based digital marketing and IT solutions company. We plan, design, build, and promote digital experiences that help businesses improve visibility, earn trust, and grow with confidence.</p><p>Our work brings together website development, SEO, social media, branding, video production, campaign strategy, and IT training so clients can get practical support from one connected team.</p>',
            'meta_description' => 'Learn about Idea Gen, a digital marketing and IT solutions company in Kathmandu, Nepal.',
            'order'       => 1,
        ]);

        // Service categories
        $serviceCategories = ['Web Development', 'Digital Marketing', 'Design', 'IT Solutions'];
        $serviceCategoryModels = [];
        foreach ($serviceCategories as $i => $name) {
            $serviceCategoryModels[$name] = Category::updateOrCreate(
                ['type' => 'service', 'slug' => \Str::slug($name)],
                ['name' => $name, 'type' => 'service', 'is_active' => true, 'order' => $i, 'image' => $images['services']]
            );
        }

        // Services
        $services = [
            ['title' => 'Website Development', 'category' => 'Web Development', 'icon' => 'fas fa-code', 'image' => $images['service_web'], 'excerpt' => 'Responsive websites and web applications built for clarity, speed, and conversion.', 'features' => ['Responsive layouts', 'CMS-ready structure', 'Performance-focused build']],
            ['title' => 'Digital Marketing', 'category' => 'Digital Marketing', 'icon' => 'fas fa-chart-line', 'image' => $images['service_marketing'], 'excerpt' => 'Campaign planning, content, social media, and reporting that keep growth measurable.', 'features' => ['Campaign strategy', 'Social media management', 'Monthly reporting']],
            ['title' => 'Graphic Design & Branding', 'category' => 'Design', 'icon' => 'fas fa-paint-brush', 'image' => $images['service_design'], 'excerpt' => 'Brand visuals, campaign creatives, and design systems that make your message easier to remember.', 'features' => ['Logo and identity', 'Creative direction', 'Print and digital assets']],
            ['title' => 'SEO & Analytics', 'category' => 'Digital Marketing', 'icon' => 'fas fa-search', 'image' => $images['service_seo'], 'excerpt' => 'Search visibility, analytics setup, and practical insight for smarter marketing decisions.', 'features' => ['Technical SEO', 'Keyword planning', 'Analytics dashboards']],
            ['title' => 'Video Production', 'category' => 'Design', 'icon' => 'fas fa-video', 'image' => $images['blog_3'], 'excerpt' => 'Short-form and campaign video content for brand awareness, launches, and social engagement.', 'features' => ['Storyboarding', 'Motion graphics', 'Social-ready edits']],
            ['title' => 'IT Training', 'category' => 'IT Solutions', 'icon' => 'fas fa-laptop-code', 'image' => $images['services'], 'excerpt' => 'Practical technology training for teams and individuals who want stronger digital capability.', 'features' => ['Web development basics', 'Digital tools', 'Team workshops']],
        ];

        foreach ($services as $i => $data) {
            Service::updateOrCreate(['slug' => \Str::slug($data['title'])], [
                'category_id' => $serviceCategoryModels[$data['category']]->id ?? null,
                'title' => $data['title'],
                'icon' => $data['icon'],
                'excerpt' => $data['excerpt'],
                'image' => $data['image'],
                'featured_image' => $data['image'],
                'features' => array_map(fn ($text) => ['text' => $text], $data['features']),
                'gallery' => [$data['image'], $images['service_web'], $images['service_marketing']],
                'content'     => '<p>' . $data['excerpt'] . '</p><p>We keep the process clear from planning to delivery, with practical communication, measurable goals, and assets your team can continue using after launch.</p>',
                'is_active'   => true,
                'is_featured' => $i < 4,
                'order'       => $i,
                'meta_description' => $data['excerpt'],
            ]);
        }

        // Project categories and projects
        $projectCategories = ['Website', 'Marketing', 'Branding', 'Content'];
        $projectCategoryModels = [];
        foreach ($projectCategories as $i => $name) {
            $projectCategoryModels[$name] = Category::updateOrCreate(
                ['type' => 'project', 'slug' => \Str::slug($name)],
                ['name' => $name, 'type' => 'project', 'is_active' => true, 'order' => $i, 'image' => $images['projects']]
            );
        }

        $projects = [
            ['title' => 'Business Website Launch', 'category' => 'Website', 'client' => 'Growing Local Business', 'image' => $images['project_1'], 'excerpt' => 'A responsive company website structured around services, trust signals, and simple inquiry paths.'],
            ['title' => 'Digital Growth Campaign', 'category' => 'Marketing', 'client' => 'Service Brand', 'image' => $images['project_2'], 'excerpt' => 'A measurable campaign system combining SEO, social media, creative assets, and monthly reporting.'],
            ['title' => 'Brand Content Refresh', 'category' => 'Branding', 'client' => 'Hospitality Group', 'image' => $images['project_3'], 'excerpt' => 'A refreshed brand content direction for stronger recall across web, print, video, and social channels.'],
            ['title' => 'Video Content Production', 'category' => 'Content', 'client' => 'Education Consultant', 'image' => $images['project_4'], 'excerpt' => 'A practical production plan for social videos, launch creatives, and evergreen brand storytelling.'],
        ];

        foreach ($projects as $i => $data) {
            Project::updateOrCreate(['slug' => \Str::slug($data['title'])], [
                'category_id' => $projectCategoryModels[$data['category']]->id ?? null,
                'title' => $data['title'],
                'excerpt' => $data['excerpt'],
                'content' => '<p>' . $data['excerpt'] . '</p><p>The project focused on clear planning, polished execution, and handover materials the client team could use with confidence.</p>',
                'client' => $data['client'],
                'location' => 'Kathmandu, Nepal',
                'year' => '2026',
                'duration' => '4 weeks',
                'image' => $data['image'],
                'featured_image' => $data['image'],
                'gallery' => [$data['image'], $images['project_1'], $images['project_2']],
                'highlights' => [
                    ['text' => 'Clear digital strategy and content plan'],
                    ['text' => 'Responsive visual assets for multiple channels'],
                    ['text' => 'Measurable delivery and reporting structure'],
                ],
                'is_active' => true,
                'is_featured' => true,
                'order' => $i,
                'meta_description' => $data['excerpt'],
            ]);
        }

        $partners = [
            ['name' => 'Brand One', 'logo' => $images['partner_1']],
            ['name' => 'Brand Two', 'logo' => $images['partner_2']],
            ['name' => 'Brand Three', 'logo' => $images['partner_3']],
            ['name' => 'Brand Four', 'logo' => $images['partner_4']],
            ['name' => 'Brand Five', 'logo' => $images['partner_5']],
            ['name' => 'Brand Six', 'logo' => $images['partner_6']],
        ];

        foreach ($partners as $i => $partner) {
            Partner::updateOrCreate(['name' => $partner['name']], [
                'logo' => $partner['logo'],
                'url' => null,
                'is_active' => true,
                'order' => $i + 1,
            ]);
        }

        // Team Members
        $team = [
            ['name' => 'Dipendra Acharya', 'position' => 'Managing Director', 'department' => 'Leadership', 'image' => $images['team_1']],
            ['name' => 'Anuj Kumar Joshi', 'position' => 'Operations Director', 'department' => 'Operations', 'image' => $images['team_2']],
            ['name' => 'Yagya Raj Bhatta', 'position' => 'Chief Marketing Officer', 'department' => 'Marketing', 'image' => $images['team_3']],
            ['name' => 'Amit Maharjan', 'position' => 'Sr. Motion Designer', 'department' => 'Creative', 'image' => $images['team_4']],
        ];

        foreach ($team as $i => $member) {
            TeamMember::updateOrCreate(['slug' => \Str::slug($member['name'])], [
                ...$member,
                'bio'         => 'Experienced professional helping Idea Gen deliver practical, polished digital work.',
                'full_bio'    => '<p>' . $member['name'] . ' brings focused experience in ' . strtolower($member['department']) . ' and supports clients from strategy through execution.</p>',
                'skills'      => ['Strategy', 'Digital Delivery', $member['department']],
                'is_active'   => true,
                'is_featured' => true,
                'order'       => $i,
            ]);
        }

        // Blog categories, tags, and posts
        $postCategory = Category::updateOrCreate(
            ['type' => 'post', 'slug' => 'digital-growth'],
            ['name' => 'Digital Growth', 'type' => 'post', 'is_active' => true, 'order' => 1, 'image' => $images['blog']]
        );

        $postTags = collect(['Websites', 'SEO', 'Branding', 'Content'])->mapWithKeys(fn ($name) => [
            $name => Tag::updateOrCreate(
                ['type' => 'post', 'slug' => \Str::slug($name)],
                ['name' => $name, 'type' => 'post']
            ),
        ]);

        $posts = [
            ['title' => 'How a strong website supports business growth', 'image' => $images['blog_1'], 'excerpt' => 'A good website gives customers the answers they need and gives every campaign a reliable destination.', 'tags' => ['Websites', 'SEO']],
            ['title' => 'Why digital marketing needs clear goals', 'image' => $images['blog_2'], 'excerpt' => 'Campaigns become easier to improve when every channel is connected to specific business outcomes.', 'tags' => ['SEO', 'Content']],
            ['title' => 'Creative content that earns attention', 'image' => $images['blog_3'], 'excerpt' => 'Useful content, strong design, and consistent publishing help brands stay visible without feeling noisy.', 'tags' => ['Branding', 'Content']],
        ];

        foreach ($posts as $i => $data) {
            $post = Post::updateOrCreate(['slug' => \Str::slug($data['title'])], [
                'category_id' => $postCategory->id,
                'title' => $data['title'],
                'excerpt' => $data['excerpt'],
                'content' => '<p>' . $data['excerpt'] . '</p><p>This placeholder article gives the blog section realistic content while the final editorial copy is being prepared.</p>',
                'featured_image' => $data['image'],
                'status' => 'published',
                'published_at' => now()->subDays($i + 1),
                'is_featured' => $i < 2,
                'allow_comments' => true,
                'read_time' => '4 min read',
                'meta_description' => $data['excerpt'],
                'og_image' => $data['image'],
            ]);

            $post->tags()->sync($postTags->only($data['tags'])->pluck('id')->all());
        }

        // Testimonials
        $testimonials = [
            ['name' => 'Ramesh Shrestha', 'position' => 'MD', 'company' => "Vaby's Restaurant", 'content' => 'Idea Gen revamped our website and SEO strategy. Traffic increased by 200% in six months. Highly professional.', 'rating' => 4, 'image' => $images['team_1'], 'order' => 1],
            ['name' => 'Dr. Anup Pradhan', 'position' => 'Director', 'company' => 'DI Dental Hospital', 'content' => 'Their video production and branding work for our hospital was outstanding. They understood our vision perfectly.', 'rating' => 4, 'image' => $images['team_2'], 'order' => 2],
            ['name' => 'Sunita Ghimire', 'position' => 'HR Manager', 'company' => 'Safal International', 'content' => 'Idea Gen’s IT training program upskilled our staff in cloud computing. Excellent content and delivery.', 'rating' => 4, 'image' => $images['team_3'], 'order' => 3],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['name' => $t['name']], [
                ...$t,
                'is_active' => true,
                'is_featured' => true,
            ]);
        }

        // Counters
        $counters = [
            ['label' => 'Projects Completed', 'value' => '150+', 'numeric_value' => 150, 'suffix' => '+', 'icon' => 'fas fa-briefcase', 'order' => 1],
            ['label' => 'Happy Clients', 'value' => '100+', 'numeric_value' => 100, 'suffix' => '+', 'icon' => 'fas fa-users', 'order' => 2],
            ['label' => 'Success Rate', 'value' => '99.99%', 'numeric_value' => 99, 'suffix' => '%', 'icon' => 'fas fa-award', 'order' => 3],
            ['label' => 'Years Of Excellence', 'value' => '3+', 'numeric_value' => 3, 'suffix' => '+', 'icon' => 'fas fa-clock', 'order' => 4],
        ];

        foreach ($counters as $counter) {
            Counter::updateOrCreate(['label' => $counter['label']], [
                ...$counter,
                'is_active' => true,
            ]);
        }

        // FAQ Categories & FAQs
        $faqCat = FaqCategory::updateOrCreate(['slug' => 'general'], [
            'name' => 'General', 'is_active' => true, 'order' => 1,
        ]);

        $faqs = [
            ['question' => 'What services does Idea Gen provide?', 'answer' => '<p>We offer website development, digital marketing, SEO, graphic design & branding, video production, event management, IT training, SMS marketing, hoarding advertising, and more.</p>'],
            ['question' => 'Why does my business need digital marketing?', 'answer' => '<p>Digital marketing helps you reach your target audience, build brand awareness, and drive measurable growth. We create data-driven strategies tailored to your goals.</p>'],
            ['question' => 'How can Idea Gen improve my business productivity?', 'answer' => '<p>Through efficient IT solutions, automation, and strategic digital tools, we streamline your operations and enhance online presence, freeing you to focus on core business.</p>'],
            ['question' => 'Do you provide IT training?', 'answer' => '<p>Yes, we offer training in web development, programming, AI, cloud computing and more to upskill individuals and teams.</p>'],
            ['question' => 'How can I contact Idea Gen?', 'answer' => '<p>Call us at +977-01-4168335, email info@ideagen.com.np, or visit our office in Putalisadak, Kathmandu.</p>'],
        ];

        foreach ($faqs as $i => $faq) {
            Faq::updateOrCreate(['question' => $faq['question']], [
                ...$faq,
                'category_id' => $faqCat->id,
                'is_active'   => true,
                'is_featured' => true,
                'order'       => $i,
            ]);
        }

        // Pricing Plans
        $plans = [
            ['name' => 'Starter',     'price_monthly' => 49,  'price_yearly' => 470,  'is_featured' => false, 'features' => [
                ['text' => '5 Pages',        'included' => true],
                ['text' => 'Basic SEO',      'included' => true],
                ['text' => 'Mobile Responsive', 'included' => true],
                ['text' => 'E-Commerce',     'included' => false],
                ['text' => 'Priority Support','included' => false],
            ]],
            ['name' => 'Professional', 'price_monthly' => 99,  'price_yearly' => 950,  'is_featured' => true,  'badge' => 'Most Popular', 'features' => [
                ['text' => '20 Pages',       'included' => true],
                ['text' => 'Advanced SEO',   'included' => true],
                ['text' => 'Mobile Responsive', 'included' => true],
                ['text' => 'E-Commerce',     'included' => true],
                ['text' => 'Priority Support','included' => false],
            ]],
            ['name' => 'Enterprise',   'price_monthly' => 199, 'price_yearly' => 1910, 'is_featured' => false, 'features' => [
                ['text' => 'Unlimited Pages','included' => true],
                ['text' => 'Advanced SEO',   'included' => true],
                ['text' => 'Mobile Responsive', 'included' => true],
                ['text' => 'E-Commerce',     'included' => true],
                ['text' => 'Priority Support','included' => true],
            ]],
        ];

        foreach ($plans as $i => $plan) {
            PricingPlan::updateOrCreate(['slug' => \Str::slug($plan['name'])], [
                ...$plan,
                'currency'        => 'USD',
                'currency_symbol' => '$',
                'button_text'     => 'Get Started',
                'button_url'      => '/contact',
                'is_active'       => true,
                'order'           => $i,
            ]);
        }

        $this->command->info('Demo content seeded!');
    }

    private function seedImage(string $source, string $destination): string
    {
        $sourcePath = public_path($source);
        $destination = 'seeded/' . ltrim($destination, '/');
        $destinationPath = storage_path('app/public/' . $destination);

        if (File::exists($sourcePath)) {
            File::ensureDirectoryExists(dirname($destinationPath));
            File::copy($sourcePath, $destinationPath);
        }

        return $destination;
    }
}
