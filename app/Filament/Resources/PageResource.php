<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Page Editor')->tabs([

                Forms\Components\Tabs\Tab::make('Content')->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(
                            fn(Forms\Set $set, ?string $state) =>
                            $set('slug', \Str::slug($state ?? ''))
                        )
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->prefix('/')
                        ->columnSpanFull(),
                    Forms\Components\Select::make('template')
                        ->options([
                            'default'           => 'Default',
                            'home'              => 'Home',
                            'about'             => 'About',
                            'annapurna-region'  => 'Annapurna Region',
                            'contact'           => 'Contact',
                            'services'          => 'Services',
                            'projects'          => 'Projects / Portfolio',
                            'blog'              => 'Blog / News',
                            'gallery'           => 'Gallery',
                            'faq'               => 'FAQ',
                            'pricing'           => 'Pricing',
                            'team'              => 'Team',
                            'blank'             => 'Blank (no layout)',
                        ])
                        ->default('default')
                        ->required()
                        ->columnSpanFull(),
                    MediaPicker::make('featured_image')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('content')
                        ->columnSpanFull()
                        ->toolbarButtons([
                            'bold',
                            'italic',
                            'underline',
                            'strike',
                            'h2',
                            'h3',
                            'bulletList',
                            'orderedList',
                            'blockquote',
                            'link',
                            'attachFiles',
                            'table',
                            'codeBlock',
                            'undo',
                            'redo',
                        ]),
                ]),

                Forms\Components\Tabs\Tab::make('Page Sections')
                    ->schema([
                        Forms\Components\Repeater::make('sections')
                            ->schema([

                                // ── Type + Visible ──────────────────────────────────────
                                Forms\Components\Grid::make(4)->schema([
                                    Forms\Components\Select::make('type')
                                        ->options([
                                            'Hero'         => ['hero'       => 'Hero Banner'],
                                            'Content'      => [
                                                'about'      => 'About Section',
                                                'text_block' => 'Text Block',
                                                'image_text' => 'Image + Text',
                                                'cta'        => 'Call to Action',
                                                'custom_html'=> 'Custom HTML',
                                            ],
                                            'Layout'       => [
                                                'columns'    => 'Columns / Flexible Layout',
                                            ],
                                            'Media'        => [
                                                'gallery'    => 'Gallery',
                                                'video'      => 'Video',
                                            ],
                                            'Data Sections' => [
                                                'services'     => 'Services',
                                                'projects'     => 'Projects / Portfolio',
                                                'team'         => 'Team',
                                                'testimonials' => 'Testimonials',
                                                'stats'        => 'Stats / Counters',
                                                'partners'     => 'Partners / Clients',
                                                'pricing'      => 'Pricing',
                                                'blog'         => 'Blog Preview',
                                                'faq'          => 'FAQ',
                                                'contact'      => 'Contact',
                                            ],
                                        ])
                                        ->required()
                                        ->live()
                                        ->columnSpan(3),
                                    Forms\Components\Toggle::make('visible')
                                        ->label('Visible')
                                        ->default(true)
                                        ->inline(false)
                                        ->columnSpan(1),
                                ]),

                                // ── Common: Title & Subtitle ─────────────────────────────
                                Forms\Components\TextInput::make('title')
                                    ->visible(fn(Forms\Get $get) => $get('type') !== 'custom_html')
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('subtitle')
                                    ->rows(2)
                                    ->visible(fn(Forms\Get $get) => !in_array($get('type'), ['custom_html', 'text_block', 'columns']))
                                    ->columnSpanFull(),

                                // ── HERO ─────────────────────────────────────────────────
                                Forms\Components\Group::make([
                                    Forms\Components\RichEditor::make('content')
                                        ->label('Description')
                                        ->toolbarButtons(['bold', 'italic', 'underline', 'bulletList', 'orderedList', 'link'])
                                        ->columnSpanFull(),
                                    MediaPicker::make('background_image')
                                        ->label('Background Image')
                                        ->columnSpanFull(),
                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\TextInput::make('button_text')->label('Primary Button'),
                                        Forms\Components\TextInput::make('button_url')->label('Primary URL')->url(),
                                        Forms\Components\TextInput::make('button_secondary_text')->label('Secondary Button'),
                                        Forms\Components\TextInput::make('button_secondary_url')->label('Secondary URL')->url(),
                                    ]),
                                ])
                                ->visible(fn(Forms\Get $get) => $get('type') === 'hero')
                                ->columnSpanFull(),

                                // ── ABOUT / IMAGE+TEXT / TEXT BLOCK ──────────────────────
                                Forms\Components\Group::make([
                                    Forms\Components\RichEditor::make('content')
                                        ->toolbarButtons(['bold', 'italic', 'underline', 'strike', 'h2', 'h3', 'bulletList', 'orderedList', 'blockquote', 'link'])
                                        ->columnSpanFull(),
                                    MediaPicker::make('image')
                                        ->visible(fn(Forms\Get $get) => in_array($get('type'), ['about', 'image_text']))
                                        ->columnSpanFull(),
                                    Forms\Components\Select::make('image_position')
                                        ->options(['left' => 'Image on Left', 'right' => 'Image on Right'])
                                        ->default('left')
                                        ->visible(fn(Forms\Get $get) => $get('type') === 'image_text'),
                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\TextInput::make('button_text'),
                                        Forms\Components\TextInput::make('button_url')->url(),
                                    ])
                                    ->visible(fn(Forms\Get $get) => in_array($get('type'), ['about', 'image_text'])),
                                ])
                                ->visible(fn(Forms\Get $get) => in_array($get('type'), ['about', 'image_text', 'text_block']))
                                ->columnSpanFull(),

                                // ── CTA ──────────────────────────────────────────────────
                                Forms\Components\Group::make([
                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\TextInput::make('button_text')->label('Primary Button'),
                                        Forms\Components\TextInput::make('button_url')->label('Primary URL')->url(),
                                        Forms\Components\TextInput::make('button_secondary_text')->label('Secondary Button'),
                                        Forms\Components\TextInput::make('button_secondary_url')->label('Secondary URL')->url(),
                                    ]),
                                ])
                                ->visible(fn(Forms\Get $get) => $get('type') === 'cta')
                                ->columnSpanFull(),

                                // ── DATA SECTIONS (services/projects/team/testimonials/etc.)
                                Forms\Components\Group::make([
                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\TextInput::make('display_count')
                                            ->label('Items to Display')
                                            ->numeric()
                                            ->default(6)
                                            ->minValue(1)
                                            ->placeholder('All'),
                                        Forms\Components\Select::make('layout')
                                            ->options(['grid' => 'Grid', 'list' => 'List', 'slider' => 'Slider'])
                                            ->default('grid'),
                                    ]),
                                ])
                                ->visible(fn(Forms\Get $get) => in_array($get('type'), [
                                    'services', 'projects', 'team', 'testimonials', 'partners', 'pricing', 'stats',
                                ]))
                                ->columnSpanFull(),

                                // ── GALLERY ──────────────────────────────────────────────
                                Forms\Components\Group::make([
                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\Select::make('album_id')
                                            ->label('Album')
                                            ->options(\App\Models\GalleryAlbum::orderBy('name')->pluck('name', 'id'))
                                            ->placeholder('All Albums')
                                            ->searchable(),
                                        Forms\Components\TextInput::make('display_count')
                                            ->label('Images to Display')
                                            ->numeric()
                                            ->default(12)
                                            ->minValue(1),
                                    ]),
                                ])
                                ->visible(fn(Forms\Get $get) => $get('type') === 'gallery')
                                ->columnSpanFull(),

                                // ── FAQ ───────────────────────────────────────────────────
                                Forms\Components\Group::make([
                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\Select::make('faq_category_id')
                                            ->label('FAQ Category')
                                            ->options(\App\Models\FaqCategory::orderBy('name')->pluck('name', 'id'))
                                            ->placeholder('All Categories')
                                            ->searchable(),
                                        Forms\Components\TextInput::make('display_count')
                                            ->label('Questions to Display')
                                            ->numeric()
                                            ->placeholder('All'),
                                    ]),
                                ])
                                ->visible(fn(Forms\Get $get) => $get('type') === 'faq')
                                ->columnSpanFull(),

                                // ── BLOG ──────────────────────────────────────────────────
                                Forms\Components\Group::make([
                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\Select::make('category_id')
                                            ->label('Category Filter')
                                            ->options(\App\Models\Category::orderBy('name')->pluck('name', 'id'))
                                            ->placeholder('All Categories')
                                            ->searchable(),
                                        Forms\Components\TextInput::make('display_count')
                                            ->label('Posts to Display')
                                            ->numeric()
                                            ->default(3)
                                            ->minValue(1),
                                    ]),
                                ])
                                ->visible(fn(Forms\Get $get) => $get('type') === 'blog')
                                ->columnSpanFull(),

                                // ── CONTACT ───────────────────────────────────────────────
                                Forms\Components\Group::make([
                                    Forms\Components\Grid::make(3)->schema([
                                        Forms\Components\Toggle::make('show_form')
                                            ->label('Contact Form')
                                            ->default(true)
                                            ->inline(false),
                                        Forms\Components\Toggle::make('show_map')
                                            ->label('Map')
                                            ->default(false)
                                            ->inline(false),
                                        Forms\Components\Toggle::make('show_details')
                                            ->label('Contact Details')
                                            ->default(true)
                                            ->inline(false),
                                    ]),
                                ])
                                ->visible(fn(Forms\Get $get) => $get('type') === 'contact')
                                ->columnSpanFull(),

                                // ── VIDEO (with live preview) ─────────────────────────────
                                Forms\Components\Group::make([
                                    Forms\Components\TextInput::make('video_url')
                                        ->label('YouTube or Vimeo URL')
                                        ->url()
                                        ->live(onBlur: true)
                                        ->placeholder('https://www.youtube.com/watch?v=...')
                                        ->columnSpanFull(),
                                    Forms\Components\Placeholder::make('video_preview')
                                        ->label('Preview')
                                        ->content(function (Forms\Get $get): \Illuminate\Support\HtmlString {
                                            $url = $get('video_url');
                                            if (!$url) {
                                                return new \Illuminate\Support\HtmlString(
                                                    '<div style="background:#f9fafb;border:2px dashed #e5e7eb;border-radius:10px;padding:32px;text-align:center;color:#9ca3af;font-size:13px;">' .
                                                    '🎬 Enter a YouTube or Vimeo URL above to see a preview' .
                                                    '</div>'
                                                );
                                            }
                                            if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $m)) {
                                                return new \Illuminate\Support\HtmlString(
                                                    '<div style="position:relative;padding-bottom:56.25%;height:0;border-radius:10px;overflow:hidden;background:#000;">' .
                                                    '<iframe src="https://www.youtube.com/embed/' . e($m[1]) . '" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen></iframe>' .
                                                    '</div>'
                                                );
                                            }
                                            if (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $url, $m)) {
                                                return new \Illuminate\Support\HtmlString(
                                                    '<div style="position:relative;padding-bottom:56.25%;height:0;border-radius:10px;overflow:hidden;background:#000;">' .
                                                    '<iframe src="https://player.vimeo.com/video/' . e($m[1]) . '" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay;fullscreen;picture-in-picture" allowfullscreen></iframe>' .
                                                    '</div>'
                                                );
                                            }
                                            return new \Illuminate\Support\HtmlString(
                                                '<p style="color:#ef4444;font-size:13px;padding:4px 0;">⚠️ URL not recognized — paste a YouTube or Vimeo link.</p>'
                                            );
                                        })
                                        ->columnSpanFull(),
                                    Forms\Components\Grid::make(2)->schema([
                                        MediaPicker::make('thumbnail')->label('Fallback Thumbnail'),
                                        Forms\Components\Toggle::make('autoplay')
                                            ->label('Autoplay')
                                            ->default(false)
                                            ->inline(false),
                                    ]),
                                ])
                                ->visible(fn(Forms\Get $get) => $get('type') === 'video')
                                ->columnSpanFull(),

                                // ── CUSTOM HTML ───────────────────────────────────────────
                                Forms\Components\Textarea::make('custom_html')
                                    ->label('HTML Content')
                                    ->rows(8)
                                    ->visible(fn(Forms\Get $get) => $get('type') === 'custom_html')
                                    ->columnSpanFull(),

                                // ── COLUMNS / FLEXIBLE LAYOUT ─────────────────────────────
                                Forms\Components\Group::make([
                                    Forms\Components\Select::make('columns_layout')
                                        ->label('Column Layout')
                                        ->options([
                                            '1'   => '1 Column — Full Width',
                                            '2'   => '2 Columns — 50 / 50',
                                            '2-1' => '2 Columns — 66 / 33 (Wide Left)',
                                            '1-2' => '2 Columns — 33 / 66 (Wide Right)',
                                            '3'   => '3 Columns — Equal',
                                            '4'   => '4 Columns — Equal',
                                        ])
                                        ->default('2')
                                        ->required()
                                        ->live()
                                        ->columnSpanFull(),

                                    Forms\Components\Repeater::make('columns')
                                        ->label('Column Blocks')
                                        ->schema([
                                            Forms\Components\Select::make('block_type')
                                                ->label('Block Type')
                                                ->options([
                                                    'Content' => [
                                                        'text'       => 'Rich Text',
                                                        'image'      => 'Image',
                                                        'image_text' => 'Image + Text',
                                                        'icon_card'  => 'Icon Card',
                                                        'button'     => 'Button',
                                                        'html'       => 'Custom HTML',
                                                    ],
                                                    'Widgets' => [
                                                        'stat_counter'    => 'Stat Counter',
                                                        'testimonial_card'=> 'Testimonial Card',
                                                        'service_card'    => 'Service Card',
                                                        'team_card'       => 'Team Member Card',
                                                        'pricing_card'    => 'Pricing Plan Card',
                                                        'quote'           => 'Blockquote',
                                                        'alert'           => 'Alert / Notice Box',
                                                        'accordion'       => 'Accordion (FAQ)',
                                                        'icon_list'       => 'Icon List',
                                                    ],
                                                    'Layout' => [
                                                        'divider' => 'Divider',
                                                        'spacer'  => 'Spacer',
                                                    ],
                                                ])
                                                ->required()
                                                ->live()
                                                ->columnSpanFull(),

                                            // ── Rich Text ────────────────────────────────
                                            Forms\Components\RichEditor::make('content')
                                                ->label('Content')
                                                ->toolbarButtons(['bold', 'italic', 'underline', 'strike', 'h2', 'h3', 'bulletList', 'orderedList', 'blockquote', 'link'])
                                                ->visible(fn(Forms\Get $get) => $get('block_type') === 'text')
                                                ->columnSpanFull(),

                                            // ── Image ────────────────────────────────────
                                            Forms\Components\Group::make([
                                                MediaPicker::make('image')->columnSpanFull(),
                                                Forms\Components\Grid::make(2)->schema([
                                                    Forms\Components\TextInput::make('caption')->label('Caption'),
                                                    Forms\Components\TextInput::make('link_url')->label('Link URL')->url(),
                                                ]),
                                                Forms\Components\Select::make('image_fit')
                                                    ->label('Image Fit')
                                                    ->options(['contain' => 'Contain', 'cover' => 'Cover', 'fill' => 'Fill'])
                                                    ->default('contain'),
                                            ])
                                            ->visible(fn(Forms\Get $get) => $get('block_type') === 'image')
                                            ->columnSpanFull(),

                                            // ── Image + Text ─────────────────────────────
                                            Forms\Components\Group::make([
                                                MediaPicker::make('image')->columnSpanFull(),
                                                Forms\Components\Select::make('image_position')
                                                    ->label('Image Position')
                                                    ->options(['top' => 'Above Text', 'bottom' => 'Below Text'])
                                                    ->default('top'),
                                                Forms\Components\RichEditor::make('content')
                                                    ->toolbarButtons(['bold', 'italic', 'link', 'bulletList'])
                                                    ->columnSpanFull(),
                                                Forms\Components\Grid::make(2)->schema([
                                                    Forms\Components\TextInput::make('button_text')->label('Button Label'),
                                                    Forms\Components\TextInput::make('button_url')->label('Button URL')->url(),
                                                ]),
                                            ])
                                            ->visible(fn(Forms\Get $get) => $get('block_type') === 'image_text')
                                            ->columnSpanFull(),

                                            // ── Icon Card ────────────────────────────────
                                            Forms\Components\Group::make([
                                                Forms\Components\Grid::make(2)->schema([
                                                    Forms\Components\TextInput::make('icon')
                                                        ->label('Icon Name')
                                                        ->placeholder('e.g. bolt, star, check-circle')
                                                        ->helperText('Any Heroicon name — heroicons.com'),
                                                    Forms\Components\TextInput::make('heading')->label('Card Title'),
                                                ]),
                                                Forms\Components\Textarea::make('description')
                                                    ->rows(3)
                                                    ->columnSpanFull(),
                                                Forms\Components\Grid::make(2)->schema([
                                                    Forms\Components\TextInput::make('button_text')->label('Button Label'),
                                                    Forms\Components\TextInput::make('button_url')->label('Button URL')->url(),
                                                ]),
                                            ])
                                            ->visible(fn(Forms\Get $get) => $get('block_type') === 'icon_card')
                                            ->columnSpanFull(),

                                            // ── Button ───────────────────────────────────
                                            Forms\Components\Group::make([
                                                Forms\Components\Grid::make(2)->schema([
                                                    Forms\Components\TextInput::make('button_text')->label('Label'),
                                                    Forms\Components\TextInput::make('button_url')->label('URL')->url(),
                                                ]),
                                                Forms\Components\Grid::make(2)->schema([
                                                    Forms\Components\Select::make('button_style')
                                                        ->label('Style')
                                                        ->options(['primary' => 'Primary', 'secondary' => 'Secondary', 'outline' => 'Outline', 'ghost' => 'Ghost / Link'])
                                                        ->default('primary'),
                                                    Forms\Components\Select::make('button_align')
                                                        ->label('Alignment')
                                                        ->options(['left' => 'Left', 'center' => 'Center', 'right' => 'Right'])
                                                        ->default('left'),
                                                ]),
                                            ])
                                            ->visible(fn(Forms\Get $get) => $get('block_type') === 'button')
                                            ->columnSpanFull(),

                                            // ── Custom HTML ──────────────────────────────
                                            Forms\Components\Textarea::make('html')
                                                ->label('HTML')
                                                ->rows(6)
                                                ->visible(fn(Forms\Get $get) => $get('block_type') === 'html')
                                                ->columnSpanFull(),

                                            // ═══ WIDGETS ═════════════════════════════════

                                            // ── Stat Counter ─────────────────────────────
                                            Forms\Components\Group::make([
                                                Forms\Components\Select::make('counter_source')
                                                    ->label('Source')
                                                    ->options(['db' => 'From Counter Records', 'custom' => 'Custom Values'])
                                                    ->default('db')
                                                    ->live(),
                                                Forms\Components\Select::make('counter_id')
                                                    ->label('Counter')
                                                    ->options(\App\Models\Counter::orderBy('label')->pluck('label', 'id'))
                                                    ->searchable()
                                                    ->visible(fn(Forms\Get $get) => $get('counter_source') !== 'custom'),
                                                Forms\Components\Group::make([
                                                    Forms\Components\Grid::make(2)->schema([
                                                        Forms\Components\TextInput::make('counter_value')
                                                            ->label('Value')
                                                            ->placeholder('e.g. 250'),
                                                        Forms\Components\TextInput::make('counter_suffix')
                                                            ->label('Suffix')
                                                            ->placeholder('e.g. + or %'),
                                                    ]),
                                                    Forms\Components\Grid::make(2)->schema([
                                                        Forms\Components\TextInput::make('counter_label')
                                                            ->label('Label')
                                                            ->placeholder('e.g. Projects Completed'),
                                                        Forms\Components\TextInput::make('counter_icon')
                                                            ->label('Icon')
                                                            ->placeholder('e.g. chart-bar'),
                                                    ]),
                                                ])
                                                ->visible(fn(Forms\Get $get) => $get('counter_source') === 'custom'),
                                            ])
                                            ->visible(fn(Forms\Get $get) => $get('block_type') === 'stat_counter')
                                            ->columnSpanFull(),

                                            // ── Testimonial Card ─────────────────────────
                                            Forms\Components\Group::make([
                                                Forms\Components\Select::make('testimonial_id')
                                                    ->label('Testimonial')
                                                    ->options(\App\Models\Testimonial::orderBy('name')->pluck('name', 'id'))
                                                    ->searchable()
                                                    ->placeholder('Pick one — or leave blank for random'),
                                                Forms\Components\Select::make('card_style')
                                                    ->label('Card Style')
                                                    ->options(['default' => 'Default', 'minimal' => 'Minimal', 'bordered' => 'Bordered'])
                                                    ->default('default'),
                                            ])
                                            ->visible(fn(Forms\Get $get) => $get('block_type') === 'testimonial_card')
                                            ->columnSpanFull(),

                                            // ── Service Card ─────────────────────────────
                                            Forms\Components\Group::make([
                                                Forms\Components\Select::make('service_id')
                                                    ->label('Service')
                                                    ->options(\App\Models\Service::orderBy('title')->pluck('title', 'id'))
                                                    ->searchable()
                                                    ->required(),
                                                Forms\Components\Select::make('card_style')
                                                    ->label('Card Style')
                                                    ->options(['default' => 'Default', 'minimal' => 'Minimal', 'icon' => 'Icon Focus'])
                                                    ->default('default'),
                                            ])
                                            ->visible(fn(Forms\Get $get) => $get('block_type') === 'service_card')
                                            ->columnSpanFull(),

                                            // ── Team Member Card ─────────────────────────
                                            Forms\Components\Group::make([
                                                Forms\Components\Select::make('team_member_id')
                                                    ->label('Team Member')
                                                    ->options(\App\Models\TeamMember::orderBy('name')->pluck('name', 'id'))
                                                    ->searchable()
                                                    ->required(),
                                                Forms\Components\Select::make('card_style')
                                                    ->label('Card Style')
                                                    ->options(['default' => 'Default', 'minimal' => 'Minimal', 'social' => 'With Social Links'])
                                                    ->default('default'),
                                            ])
                                            ->visible(fn(Forms\Get $get) => $get('block_type') === 'team_card')
                                            ->columnSpanFull(),

                                            // ── Pricing Plan Card ────────────────────────
                                            Forms\Components\Group::make([
                                                Forms\Components\Select::make('pricing_plan_id')
                                                    ->label('Pricing Plan')
                                                    ->options(\App\Models\PricingPlan::orderBy('name')->pluck('name', 'id'))
                                                    ->searchable()
                                                    ->required(),
                                                Forms\Components\Toggle::make('highlight')
                                                    ->label('Highlight as Featured')
                                                    ->default(false)
                                                    ->inline(false),
                                            ])
                                            ->visible(fn(Forms\Get $get) => $get('block_type') === 'pricing_card')
                                            ->columnSpanFull(),

                                            // ── Blockquote ───────────────────────────────
                                            Forms\Components\Group::make([
                                                Forms\Components\Textarea::make('quote_text')
                                                    ->label('Quote')
                                                    ->rows(3)
                                                    ->required()
                                                    ->columnSpanFull(),
                                                Forms\Components\Grid::make(2)->schema([
                                                    Forms\Components\TextInput::make('quote_author')->label('Attribution / Author'),
                                                    Forms\Components\Select::make('quote_style')
                                                        ->label('Style')
                                                        ->options(['default' => 'Default', 'large' => 'Large Pull Quote', 'minimal' => 'Minimal'])
                                                        ->default('default'),
                                                ]),
                                            ])
                                            ->visible(fn(Forms\Get $get) => $get('block_type') === 'quote')
                                            ->columnSpanFull(),

                                            // ── Alert / Notice Box ───────────────────────
                                            Forms\Components\Group::make([
                                                Forms\Components\Grid::make(2)->schema([
                                                    Forms\Components\Select::make('alert_type')
                                                        ->label('Type')
                                                        ->options(['info' => 'Info', 'success' => 'Success', 'warning' => 'Warning', 'error' => 'Error'])
                                                        ->default('info')
                                                        ->required(),
                                                    Forms\Components\TextInput::make('alert_title')->label('Title (optional)'),
                                                ]),
                                                Forms\Components\Textarea::make('alert_message')
                                                    ->label('Message')
                                                    ->rows(3)
                                                    ->required()
                                                    ->columnSpanFull(),
                                                Forms\Components\Toggle::make('dismissible')
                                                    ->label('Dismissible')
                                                    ->default(false)
                                                    ->inline(false),
                                            ])
                                            ->visible(fn(Forms\Get $get) => $get('block_type') === 'alert')
                                            ->columnSpanFull(),

                                            // ── Accordion (FAQ) ──────────────────────────
                                            Forms\Components\Group::make([
                                                Forms\Components\Select::make('accordion_style')
                                                    ->label('Style')
                                                    ->options(['default' => 'Default', 'flush' => 'Flush / Borderless', 'boxed' => 'Boxed'])
                                                    ->default('default'),
                                                Forms\Components\Repeater::make('accordion_items')
                                                    ->label('Items')
                                                    ->schema([
                                                        Forms\Components\TextInput::make('question')
                                                            ->label('Question / Heading')
                                                            ->required()
                                                            ->columnSpanFull(),
                                                        Forms\Components\Textarea::make('answer')
                                                            ->label('Answer / Content')
                                                            ->rows(3)
                                                            ->required()
                                                            ->columnSpanFull(),
                                                        Forms\Components\Toggle::make('open_by_default')
                                                            ->label('Open by default')
                                                            ->default(false)
                                                            ->inline(false),
                                                    ])
                                                    ->columns(2)
                                                    ->addActionLabel('+ Add Item')
                                                    ->reorderable()
                                                    ->collapsible()
                                                    ->itemLabel(fn(array $state): ?string => $state['question'] ?? null)
                                                    ->defaultItems(1)
                                                    ->columnSpanFull(),
                                            ])
                                            ->visible(fn(Forms\Get $get) => $get('block_type') === 'accordion')
                                            ->columnSpanFull(),

                                            // ── Icon List ────────────────────────────────
                                            Forms\Components\Group::make([
                                                Forms\Components\Grid::make(2)->schema([
                                                    Forms\Components\Select::make('icon_list_style')
                                                        ->label('List Style')
                                                        ->options(['check' => 'Checkmarks', 'bullet' => 'Colored Dots', 'custom' => 'Custom Icons'])
                                                        ->default('check')
                                                        ->live(),
                                                    Forms\Components\Select::make('icon_list_columns')
                                                        ->label('Columns')
                                                        ->options(['1' => '1 Column', '2' => '2 Columns'])
                                                        ->default('1'),
                                                ]),
                                                Forms\Components\Repeater::make('list_items')
                                                    ->label('Items')
                                                    ->schema([
                                                        Forms\Components\TextInput::make('text')
                                                            ->label('Text')
                                                            ->required()
                                                            ->columnSpan(2),
                                                        Forms\Components\TextInput::make('icon')
                                                            ->label('Icon (override)')
                                                            ->placeholder('e.g. check, x-mark')
                                                            ->visible(fn(Forms\Get $get) => $get('../../icon_list_style') === 'custom')
                                                            ->columnSpan(1),
                                                        Forms\Components\TextInput::make('sub_text')
                                                            ->label('Sub-text')
                                                            ->placeholder('Optional smaller text below')
                                                            ->columnSpan(1),
                                                    ])
                                                    ->columns(3)
                                                    ->addActionLabel('+ Add Item')
                                                    ->reorderable()
                                                    ->itemLabel(fn(array $state): ?string => $state['text'] ?? null)
                                                    ->defaultItems(3)
                                                    ->columnSpanFull(),
                                            ])
                                            ->visible(fn(Forms\Get $get) => $get('block_type') === 'icon_list')
                                            ->columnSpanFull(),

                                            // ═══ LAYOUT ══════════════════════════════════

                                            // ── Divider ──────────────────────────────────
                                            Forms\Components\Group::make([
                                                Forms\Components\Grid::make(3)->schema([
                                                    Forms\Components\Select::make('divider_style')
                                                        ->label('Style')
                                                        ->options(['solid' => 'Solid', 'dashed' => 'Dashed', 'dotted' => 'Dotted', 'double' => 'Double'])
                                                        ->default('solid'),
                                                    Forms\Components\Select::make('divider_weight')
                                                        ->label('Thickness')
                                                        ->options(['1' => '1px', '2' => '2px', '4' => '4px'])
                                                        ->default('1'),
                                                    Forms\Components\TextInput::make('divider_color')
                                                        ->label('Color')
                                                        ->placeholder('#e5e7eb'),
                                                ]),
                                                Forms\Components\TextInput::make('divider_label')
                                                    ->label('Label (optional centre text)')
                                                    ->placeholder('or'),
                                            ])
                                            ->visible(fn(Forms\Get $get) => $get('block_type') === 'divider')
                                            ->columnSpanFull(),

                                            // ── Spacer ───────────────────────────────────
                                            Forms\Components\Select::make('spacer_size')
                                                ->label('Height')
                                                ->options(['xs' => 'Extra Small — 8px', 'sm' => 'Small — 16px', 'md' => 'Medium — 32px', 'lg' => 'Large — 64px', 'xl' => 'Extra Large — 96px'])
                                                ->default('md')
                                                ->visible(fn(Forms\Get $get) => $get('block_type') === 'spacer')
                                                ->columnSpanFull(),
                                        ])
                                        ->columns(2)
                                        ->reorderable()
                                        ->collapsible()
                                        ->addActionLabel('+ Add Block')
                                        ->defaultItems(1)
                                        ->itemLabel(fn(array $state): string =>
                                            collect([
                                                'text'             => 'Rich Text',
                                                'image'            => 'Image',
                                                'image_text'       => 'Image + Text',
                                                'icon_card'        => 'Icon Card',
                                                'button'           => 'Button',
                                                'html'             => 'HTML',
                                                'stat_counter'     => 'Stat Counter',
                                                'testimonial_card' => 'Testimonial Card',
                                                'service_card'     => 'Service Card',
                                                'team_card'        => 'Team Card',
                                                'pricing_card'     => 'Pricing Card',
                                                'quote'            => 'Blockquote',
                                                'alert'            => 'Alert Box',
                                                'accordion'        => 'Accordion',
                                                'icon_list'        => 'Icon List',
                                                'divider'          => 'Divider',
                                                'spacer'           => 'Spacer',
                                            ])->get($state['block_type'] ?? '', 'Block')
                                            . match ($state['block_type'] ?? '') {
                                                'button'           => isset($state['button_text']) ? ' — ' . $state['button_text'] : '',
                                                'icon_card'        => isset($state['heading'])     ? ' — ' . $state['heading']     : '',
                                                'quote'            => isset($state['quote_author'])? ' — ' . $state['quote_author']: '',
                                                'alert'            => isset($state['alert_type'])  ? ' (' . $state['alert_type'] . ')' : '',
                                                default            => '',
                                            }
                                        )
                                        ->columnSpanFull(),
                                ])
                                ->visible(fn(Forms\Get $get) => $get('type') === 'columns')
                                ->columnSpanFull(),

                            ])
                            ->itemLabel(fn(array $state): string =>
                                collect([
                                    'hero'        => 'Hero Banner',
                                    'about'       => 'About',
                                    'services'    => 'Services',
                                    'projects'    => 'Projects',
                                    'team'        => 'Team',
                                    'testimonials'=> 'Testimonials',
                                    'stats'       => 'Stats / Counters',
                                    'cta'         => 'Call to Action',
                                    'gallery'     => 'Gallery',
                                    'faq'         => 'FAQ',
                                    'partners'    => 'Partners',
                                    'pricing'     => 'Pricing',
                                    'blog'        => 'Blog Preview',
                                    'contact'     => 'Contact',
                                    'image_text'  => 'Image + Text',
                                    'text_block'  => 'Text Block',
                                    'video'       => 'Video',
                                    'custom_html' => 'Custom HTML',
                                    'columns'     => 'Columns Layout',
                                ])->get($state['type'] ?? '', 'New Section')
                                . (isset($state['title']) && $state['title'] ? ' — ' . $state['title'] : '')
                                . (($state['type'] ?? '') === 'columns' && isset($state['columns_layout'])
                                    ? ' (' . ($state['columns_layout'] ?? '') . ')'
                                    : '')
                            )
                            ->columns(2)
                            ->reorderable()
                            ->collapsible()
                            ->collapsed()
                            ->addActionLabel('+ Add Section')
                            ->defaultItems(0),
                    ]),

                Forms\Components\Tabs\Tab::make('Publishing')->schema([
                    Forms\Components\Select::make('status')
                        ->options(['draft' => 'Draft', 'published' => 'Published', 'scheduled' => 'Scheduled'])
                        ->default('draft')
                        ->live()
                        ->required(),
                    Forms\Components\DateTimePicker::make('published_at')
                        ->visible(fn(Forms\Get $get) => $get('status') === 'scheduled'),
                    Forms\Components\Select::make('parent_id')
                        ->label('Parent Page')
                        ->relationship('parent', 'title')
                        ->searchable()
                        ->preload(),
                    Forms\Components\TextInput::make('order')->numeric()->default(0),
                    Forms\Components\Toggle::make('show_in_sitemap')->default(true),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('SEO')->schema([
                    Forms\Components\TextInput::make('meta_title')
                        ->helperText('Leave blank to use page title'),
                    Forms\Components\Textarea::make('meta_description')
                        ->rows(3)
                        ->maxLength(160)
                        ->helperText('Max 160 characters'),
                    Forms\Components\TextInput::make('meta_keywords'),
                    MediaPicker::make('og_image')
                        ->helperText('Open Graph image (1200x630px recommended)'),
                    Forms\Components\Select::make('og_type')
                        ->options(['website' => 'Website', 'article' => 'Article'])
                        ->default('website'),
                    Forms\Components\Toggle::make('no_index')
                        ->label('No Index (hide from search engines)')
                        ->default(false),
                ])->columns(2),

            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->badge()->copyable(),
                Tables\Columns\TextColumn::make('template')->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->colors([
                        'success' => 'published',
                        'warning' => 'draft',
                        'info' => 'scheduled',
                    ]),
                Tables\Columns\TextColumn::make('order')->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->since()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['draft' => 'Draft', 'published' => 'Published', 'scheduled' => 'Scheduled']),
                Tables\Filters\SelectFilter::make('template'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(fn(Page $record) => url($record->slug === 'home' ? '/' : '/' . $record->slug))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-eye'),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ])])
            ->defaultSort('order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
