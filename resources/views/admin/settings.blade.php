<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                Full Website & Admin Settings
            </h2>
            <p class="text-gray-500 text-sm">Customize colors, fonts, headings, images, and admin dashboard controls</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-50 border border-green-400 text-green-800 px-5 py-4 rounded-xl flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- ============================================================ --}}
                {{-- SECTION 1: Theme & Color Customization --}}
                {{-- ============================================================ --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-violet-600 via-purple-600 to-indigo-700 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                            <i class="fa-solid fa-palette text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-base">Theme, Colors & Admin Dashboard Controls</h3>
                            <p class="text-white/70 text-xs">Customize primary/secondary brand colors, typography, and admin theme</p>
                        </div>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">

                        {{-- Primary Color --}}
                        <div>
                            <label for="theme_primary_color" class="block text-xs font-bold text-gray-700 mb-1">Primary Brand Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="theme_primary_color" id="theme_primary_color"
                                    value="{{ old('theme_primary_color', $themePrimaryColor) }}"
                                    class="w-12 h-10 rounded-xl border border-gray-200 cursor-pointer p-1">
                                <input type="text" value="{{ old('theme_primary_color', $themePrimaryColor) }}"
                                    oninput="document.getElementById('theme_primary_color').value = this.value"
                                    class="w-full rounded-xl border-gray-200 text-xs px-3 py-2 uppercase font-mono">
                            </div>
                            <p class="mt-1 text-[11px] text-gray-400">Main site buttons, badges & links</p>
                        </div>

                        {{-- Secondary Color --}}
                        <div>
                            <label for="theme_secondary_color" class="block text-xs font-bold text-gray-700 mb-1">Secondary Accent Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="theme_secondary_color" id="theme_secondary_color"
                                    value="{{ old('theme_secondary_color', $themeSecondaryColor) }}"
                                    class="w-12 h-10 rounded-xl border border-gray-200 cursor-pointer p-1">
                                <input type="text" value="{{ old('theme_secondary_color', $themeSecondaryColor) }}"
                                    oninput="document.getElementById('theme_secondary_color').value = this.value"
                                    class="w-full rounded-xl border-gray-200 text-xs px-3 py-2 uppercase font-mono">
                            </div>
                            <p class="mt-1 text-[11px] text-gray-400">Highlights, sale tags & CTA buttons</p>
                        </div>

                        {{-- Admin Sidebar Background Color --}}
                        <div>
                            <label for="admin_sidebar_bg" class="block text-xs font-bold text-gray-700 mb-1">Admin Sidebar Background</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="admin_sidebar_bg" id="admin_sidebar_bg"
                                    value="{{ old('admin_sidebar_bg', $adminSidebarBg) }}"
                                    class="w-12 h-10 rounded-xl border border-gray-200 cursor-pointer p-1">
                                <input type="text" value="{{ old('admin_sidebar_bg', $adminSidebarBg) }}"
                                    oninput="document.getElementById('admin_sidebar_bg').value = this.value"
                                    class="w-full rounded-xl border-gray-200 text-xs px-3 py-2 uppercase font-mono">
                            </div>
                            <p class="mt-1 text-[11px] text-gray-400">Admin sidebar menu background color</p>
                        </div>

                        {{-- Button Primary Color --}}
                        <div>
                            <label for="btn_primary_bg" class="block text-xs font-bold text-gray-700 mb-1">Primary Button Background</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="btn_primary_bg" id="btn_primary_bg"
                                    value="{{ old('btn_primary_bg', $btnPrimaryBg) }}"
                                    class="w-12 h-10 rounded-xl border border-gray-200 cursor-pointer p-1">
                                <input type="text" value="{{ old('btn_primary_bg', $btnPrimaryBg) }}"
                                    oninput="document.getElementById('btn_primary_bg').value = this.value"
                                    class="w-full rounded-xl border-gray-200 text-xs px-3 py-2 uppercase font-mono">
                            </div>
                            <p class="mt-1 text-[11px] text-gray-400">Primary action buttons background</p>
                        </div>

                        {{-- Button Primary Text Color --}}
                        <div>
                            <label for="btn_primary_text" class="block text-xs font-bold text-gray-700 mb-1">Primary Button Text Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="btn_primary_text" id="btn_primary_text"
                                    value="{{ old('btn_primary_text', $btnPrimaryText) }}"
                                    class="w-12 h-10 rounded-xl border border-gray-200 cursor-pointer p-1">
                                <input type="text" value="{{ old('btn_primary_text', $btnPrimaryText) }}"
                                    oninput="document.getElementById('btn_primary_text').value = this.value"
                                    class="w-full rounded-xl border-gray-200 text-xs px-3 py-2 uppercase font-mono">
                            </div>
                            <p class="mt-1 text-[11px] text-gray-400">Primary action buttons text color</p>
                        </div>

                        {{-- Typography Font Family --}}
                        <div>
                            <label for="theme_font_family" class="block text-xs font-bold text-gray-700 mb-1">Website Font Family</label>
                            <select name="theme_font_family" id="theme_font_family" class="w-full rounded-xl border-gray-200 text-xs px-3 py-2.5">
                                <option value="Plus Jakarta Sans" {{ old('theme_font_family', $themeFontFamily) === 'Plus Jakarta Sans' ? 'selected' : '' }}>Plus Jakarta Sans (Default)</option>
                                <option value="Inter" {{ old('theme_font_family', $themeFontFamily) === 'Inter' ? 'selected' : '' }}>Inter</option>
                                <option value="Roboto" {{ old('theme_font_family', $themeFontFamily) === 'Roboto' ? 'selected' : '' }}>Roboto</option>
                                <option value="Outfit" {{ old('theme_font_family', $themeFontFamily) === 'Outfit' ? 'selected' : '' }}>Outfit</option>
                                <option value="Poppins" {{ old('theme_font_family', $themeFontFamily) === 'Poppins' ? 'selected' : '' }}>Poppins</option>
                                <option value="Montserrat" {{ old('theme_font_family', $themeFontFamily) === 'Montserrat' ? 'selected' : '' }}>Montserrat</option>
                            </select>
                        </div>

                        {{-- Admin Dashboard Heading --}}
                        <div class="md:col-span-2">
                            <label for="admin_dashboard_title" class="block text-xs font-bold text-gray-700 mb-1">Admin Control Center Subtitle</label>
                            <input type="text" name="admin_dashboard_title" id="admin_dashboard_title"
                                value="{{ old('admin_dashboard_title', $adminDashboardTitle) }}"
                                class="w-full rounded-xl border-gray-200 text-xs px-3 py-2.5"
                                placeholder="Management Control Center">
                        </div>

                    </div>
                </div>

                {{-- ============================================================ --}}
                {{-- SECTION 2: Branding --}}
                {{-- ============================================================ --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-primary-600 to-primary-700 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        </div>
                        <h3 class="text-white font-semibold text-base">Branding & Identity</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Site Name --}}
                        <div class="md:col-span-2">
                            <label for="site_name" class="block text-sm font-semibold text-gray-700 mb-1">Website Name <span class="text-red-500">*</span></label>
                            <input type="text" name="site_name" id="site_name"
                                value="{{ old('site_name', $siteName) }}"
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:ring-primary-500 focus:border-primary-500 text-sm px-4 py-2.5"
                                placeholder="e.g. Gohar Mart">
                            @error('site_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Slogan --}}
                        <div>
                            <label for="site_slogan" class="block text-sm font-semibold text-gray-700 mb-1">Site Slogan / Hero Tag</label>
                            <input type="text" name="site_slogan" id="site_slogan"
                                value="{{ old('site_slogan', $siteSlogan) }}"
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:ring-primary-500 focus:border-primary-500 text-sm px-4 py-2.5"
                                placeholder="e.g. Premium Quality, Delivered Fast">
                        </div>

                        {{-- Tagline --}}
                        <div>
                            <label for="site_tagline" class="block text-sm font-semibold text-gray-700 mb-1">Site Hero Subtitle</label>
                            <input type="text" name="site_tagline" id="site_tagline"
                                value="{{ old('site_tagline', $siteTagline) }}"
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:ring-primary-500 focus:border-primary-500 text-sm px-4 py-2.5"
                                placeholder="e.g. Your premium destination for elite electronics and fashion">
                        </div>

                        {{-- Footer Description --}}
                        <div class="md:col-span-2">
                            <label for="site_description" class="block text-sm font-semibold text-gray-700 mb-1">Footer Description</label>
                            <textarea name="site_description" id="site_description" rows="2"
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:ring-primary-500 focus:border-primary-500 text-sm px-4 py-2.5"
                                placeholder="Short description shown in the website footer...">{{ old('site_description', $siteDescription) }}</textarea>
                        </div>

                        {{-- Meta Description --}}
                        <div class="md:col-span-2">
                            <label for="meta_description" class="block text-sm font-semibold text-gray-700 mb-1">SEO Meta Description</label>
                            <textarea name="meta_description" id="meta_description" rows="2"
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:ring-primary-500 focus:border-primary-500 text-sm px-4 py-2.5"
                                placeholder="Shown in Google search results (max 160 chars)">{{ old('meta_description', $metaDescription) }}</textarea>
                        </div>

                    </div>
                </div>

                {{-- ============================================================ --}}
                {{-- SECTION 3: Homepage Banners & Section Headings --}}
                {{-- ============================================================ --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                            <i class="fa-solid fa-layer-group text-white text-sm"></i>
                        </div>
                        <h3 class="text-white font-semibold text-base">Homepage Sections & Banners Headings</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Hero Banner Image Upload --}}
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 md:col-span-2 space-y-3">
                            <h4 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                                <i class="fa-solid fa-image text-blue-600"></i> Hero Banner Custom Background Image
                            </h4>
                            @php $heroBg = \App\Models\Setting::getValue('hero_banner_image') @endphp
                            @if($heroBg)
                                <div class="p-3 bg-white border border-gray-200 rounded-xl inline-flex items-center gap-3">
                                    <img src="{{ $heroBg }}" alt="Hero Banner" class="h-16 w-36 object-cover rounded-lg">
                                    <span class="text-xs text-green-600 font-medium bg-green-50 px-2 py-1 rounded-lg">Current Hero Image</span>
                                </div>
                            @endif
                            <input type="file" name="hero_banner" accept="image/*"
                                class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                            <p class="text-[11px] text-gray-400">Leave blank to use default dark gradient theme background</p>
                        </div>

                        {{-- Trending Categories Section --}}
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 md:col-span-2 space-y-3">
                            <h4 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                                <i class="fa-solid fa-grid-2 text-indigo-600"></i> Trending Categories Section
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="trending_tag" class="block text-xs font-semibold text-gray-700 mb-1">Tag Text</label>
                                    <input type="text" name="trending_tag" id="trending_tag" value="{{ old('trending_tag', $trendingTag) }}"
                                        class="w-full rounded-xl border-gray-200 text-sm px-3 py-2" placeholder="Explore Collections">
                                </div>
                                <div>
                                    <label for="trending_heading" class="block text-xs font-semibold text-gray-700 mb-1">Section Heading</label>
                                    <input type="text" name="trending_heading" id="trending_heading" value="{{ old('trending_heading', $trendingHeading) }}"
                                        class="w-full rounded-xl border-gray-200 text-sm px-3 py-2" placeholder="Trending Categories">
                                </div>
                            </div>
                        </div>

                        {{-- Tech Section --}}
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 space-y-3">
                            <h4 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                                <i class="fa-solid fa-laptop text-primary-600"></i> Electronics / Tech Section
                            </h4>
                            <div>
                                <label for="tech_heading" class="block text-xs font-semibold text-gray-700 mb-1">Section Heading</label>
                                <input type="text" name="tech_heading" id="tech_heading" value="{{ old('tech_heading', $techHeading) }}"
                                    class="w-full rounded-xl border-gray-200 text-sm px-3 py-2">
                            </div>
                            <div>
                                <label for="tech_subtitle" class="block text-xs font-semibold text-gray-700 mb-1">Subtitle / Quote</label>
                                <input type="text" name="tech_subtitle" id="tech_subtitle" value="{{ old('tech_subtitle', $techSubtitle) }}"
                                    class="w-full rounded-xl border-gray-200 text-sm px-3 py-2">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label for="tech_btn_text" class="block text-xs font-semibold text-gray-700 mb-1">Button Text</label>
                                    <input type="text" name="tech_btn_text" id="tech_btn_text" value="{{ old('tech_btn_text', $techBtnText) }}"
                                        class="w-full rounded-xl border-gray-200 text-sm px-3 py-2">
                                </div>
                                <div>
                                    <label for="tech_btn_bg" class="block text-xs font-semibold text-gray-700 mb-1">Button Color</label>
                                    <div class="flex items-center gap-2">
                                        <input type="color" name="tech_btn_bg" id="tech_btn_bg" value="{{ old('tech_btn_bg', $techBtnBg) }}"
                                            class="w-10 h-9 rounded-lg border border-gray-200 cursor-pointer p-0.5">
                                        <input type="text" value="{{ old('tech_btn_bg', $techBtnBg) }}"
                                            oninput="document.getElementById('tech_btn_bg').value = this.value"
                                            class="w-full rounded-xl border-gray-200 text-xs px-2 py-2 uppercase font-mono">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Fashion Section --}}
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 space-y-3">
                            <h4 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                                <i class="fa-solid fa-shirt text-secondary-600"></i> Fashion Section
                            </h4>
                            <div>
                                <label for="fashion_heading" class="block text-xs font-semibold text-gray-700 mb-1">Section Heading</label>
                                <input type="text" name="fashion_heading" id="fashion_heading" value="{{ old('fashion_heading', $fashionHeading) }}"
                                    class="w-full rounded-xl border-gray-200 text-sm px-3 py-2">
                            </div>
                            <div>
                                <label for="fashion_subtitle" class="block text-xs font-semibold text-gray-700 mb-1">Subtitle / Quote</label>
                                <input type="text" name="fashion_subtitle" id="fashion_subtitle" value="{{ old('fashion_subtitle', $fashionSubtitle) }}"
                                    class="w-full rounded-xl border-gray-200 text-sm px-3 py-2">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label for="fashion_btn_text" class="block text-xs font-semibold text-gray-700 mb-1">Button Text</label>
                                    <input type="text" name="fashion_btn_text" id="fashion_btn_text" value="{{ old('fashion_btn_text', $fashionBtnText) }}"
                                        class="w-full rounded-xl border-gray-200 text-sm px-3 py-2">
                                </div>
                                <div>
                                    <label for="fashion_btn_bg" class="block text-xs font-semibold text-gray-700 mb-1">Button Color</label>
                                    <div class="flex items-center gap-2">
                                        <input type="color" name="fashion_btn_bg" id="fashion_btn_bg" value="{{ old('fashion_btn_bg', $fashionBtnBg) }}"
                                            class="w-10 h-9 rounded-lg border border-gray-200 cursor-pointer p-0.5">
                                        <input type="text" value="{{ old('fashion_btn_bg', $fashionBtnBg) }}"
                                            oninput="document.getElementById('fashion_btn_bg').value = this.value"
                                            class="w-full rounded-xl border-gray-200 text-xs px-2 py-2 uppercase font-mono">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Wholesale / Enterprise Section --}}
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 space-y-3 md:col-span-2">
                            <h4 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                                <i class="fa-solid fa-briefcase text-emerald-600"></i> Wholesale & Bulk Enterprise Section
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="enterprise_tag" class="block text-xs font-semibold text-gray-700 mb-1">Pill Tag Text</label>
                                    <input type="text" name="enterprise_tag" id="enterprise_tag" value="{{ old('enterprise_tag', $enterpriseTag) }}"
                                        class="w-full rounded-xl border-gray-200 text-sm px-3 py-2">
                                </div>
                                <div>
                                    <label for="enterprise_heading" class="block text-xs font-semibold text-gray-700 mb-1">Heading</label>
                                    <input type="text" name="enterprise_heading" id="enterprise_heading" value="{{ old('enterprise_heading', $enterpriseHeading) }}"
                                        class="w-full rounded-xl border-gray-200 text-sm px-3 py-2">
                                </div>
                                <div>
                                    <label for="enterprise_subtitle" class="block text-xs font-semibold text-gray-700 mb-1">Subtitle</label>
                                    <input type="text" name="enterprise_subtitle" id="enterprise_subtitle" value="{{ old('enterprise_subtitle', $enterpriseSubtitle) }}"
                                        class="w-full rounded-xl border-gray-200 text-sm px-3 py-2">
                                </div>
                            </div>
                        </div>

                        {{-- Flash Sale / Newsletter Banner --}}
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 space-y-3 md:col-span-2">
                            <h4 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                                <i class="fa-solid fa-envelope-open-text text-pink-600"></i> Flash Sale & Newsletter Banner
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="newsletter_heading" class="block text-xs font-semibold text-gray-700 mb-1">Banner Heading</label>
                                    <input type="text" name="newsletter_heading" id="newsletter_heading" value="{{ old('newsletter_heading', $newsletterHeading) }}"
                                        class="w-full rounded-xl border-gray-200 text-sm px-3 py-2">
                                </div>
                                <div>
                                    <label for="newsletter_subtitle" class="block text-xs font-semibold text-gray-700 mb-1">Banner Description</label>
                                    <input type="text" name="newsletter_subtitle" id="newsletter_subtitle" value="{{ old('newsletter_subtitle', $newsletterSubtitle) }}"
                                        class="w-full rounded-xl border-gray-200 text-sm px-3 py-2">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ============================================================ --}}
                {{-- SECTION 3b: Services Page Controls --}}
                {{-- ============================================================ --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                            <i class="fa-solid fa-boxes-stacked text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold text-base">Services / Products Page</h3>
                            <p class="text-white/70 text-xs">Customize the hero heading, subtitle, badge tag & background image</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label for="services_page_tag" class="block text-xs font-semibold text-gray-700 mb-1">Hero Badge Tag</label>
                                <input type="text" name="services_page_tag" id="services_page_tag" value="{{ old('services_page_tag', $servicesPageTag) }}"
                                    class="w-full rounded-xl border-gray-200 text-sm px-3 py-2" placeholder="e.g. Strategic Asset Portfolio">
                            </div>
                            <div>
                                <label for="services_page_heading" class="block text-xs font-semibold text-gray-700 mb-1">Hero Main Heading</label>
                                <input type="text" name="services_page_heading" id="services_page_heading" value="{{ old('services_page_heading', $servicesPageHeading) }}"
                                    class="w-full rounded-xl border-gray-200 text-sm px-3 py-2" placeholder="e.g. Asset Portfolio">
                            </div>
                            <div>
                                <label for="services_page_subtitle" class="block text-xs font-semibold text-gray-700 mb-1">Hero Subtitle</label>
                                <input type="text" name="services_page_subtitle" id="services_page_subtitle" value="{{ old('services_page_subtitle', $servicesPageSubtitle) }}"
                                    class="w-full rounded-xl border-gray-200 text-sm px-3 py-2" placeholder="e.g. Curating Pakistan's most...">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Services Hero Background Image</label>
                            @php $svcBanner = \App\Models\Setting::getValue('services_banner_image') @endphp
                            @if($svcBanner)
                                <div class="mb-2 inline-flex items-center gap-3 p-2 bg-gray-50 border border-gray-200 rounded-xl">
                                    <img src="{{ $svcBanner }}" alt="Services Banner" class="h-12 w-28 object-cover rounded-lg">
                                    <span class="text-xs text-green-600 font-medium bg-green-50 px-2 py-1 rounded-lg">Current</span>
                                </div>
                            @endif
                            <input type="file" name="services_banner" accept="image/*"
                                class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                        </div>
                    </div>
                </div>

                {{-- ============================================================ --}}
                {{-- SECTION 3c: Contact Page Controls --}}
                {{-- ============================================================ --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-sky-500 to-cyan-600 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                            <i class="fa-solid fa-phone text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold text-base">Contact Page</h3>
                            <p class="text-white/70 text-xs">Customize the contact page hero heading, badge, subtitle & background image</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label for="contact_page_badge" class="block text-xs font-semibold text-gray-700 mb-1">Hero Badge Text</label>
                                <input type="text" name="contact_page_badge" id="contact_page_badge" value="{{ old('contact_page_badge', $contactPageBadge) }}"
                                    class="w-full rounded-xl border-gray-200 text-sm px-3 py-2" placeholder="e.g. 24/7 Support Available">
                            </div>
                            <div>
                                <label for="contact_page_heading" class="block text-xs font-semibold text-gray-700 mb-1">Hero Heading</label>
                                <input type="text" name="contact_page_heading" id="contact_page_heading" value="{{ old('contact_page_heading', $contactPageHeading) }}"
                                    class="w-full rounded-xl border-gray-200 text-sm px-3 py-2" placeholder="e.g. Get In Touch">
                            </div>
                            <div>
                                <label for="contact_page_subtitle" class="block text-xs font-semibold text-gray-700 mb-1">Hero Subtitle</label>
                                <input type="text" name="contact_page_subtitle" id="contact_page_subtitle" value="{{ old('contact_page_subtitle', $contactPageSubtitle) }}"
                                    class="w-full rounded-xl border-gray-200 text-sm px-3 py-2" placeholder="e.g. Dedicated service desks ready...">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Contact Hero Background Image</label>
                            @php $ctBanner = \App\Models\Setting::getValue('contact_banner_image') @endphp
                            @if($ctBanner)
                                <div class="mb-2 inline-flex items-center gap-3 p-2 bg-gray-50 border border-gray-200 rounded-xl">
                                    <img src="{{ $ctBanner }}" alt="Contact Banner" class="h-12 w-28 object-cover rounded-lg">
                                    <span class="text-xs text-green-600 font-medium bg-green-50 px-2 py-1 rounded-lg">Current</span>
                                </div>
                            @endif
                            <input type="file" name="contact_banner" accept="image/*"
                                class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                        </div>
                    </div>
                </div>

                {{-- ============================================================ --}}
                {{-- SECTION 4: Logo & Favicon --}}
                {{-- ============================================================ --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-violet-600 to-purple-700 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-white font-semibold text-base">Logo & Favicon</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Logo --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Website Logo</label>
                            @php $currentLogo = \App\Models\Setting::getValue('site_logo') @endphp
                            @if($currentLogo)
                                <div class="mb-3 p-4 bg-gray-50 border border-gray-200 rounded-xl inline-flex items-center gap-3">
                                    <img src="{{ mediaUrl($currentLogo) }}" alt="Current Logo" class="h-12 object-contain max-w-[160px]">
                                    <span class="text-xs text-green-600 font-medium bg-green-50 px-2 py-1 rounded-lg">Current</span>
                                </div>
                            @else
                                <div class="mb-3 p-4 bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl text-center text-xs text-gray-400">No logo set</div>
                            @endif
                            <input type="file" name="logo" id="logo" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 cursor-pointer">
                            @error('logo') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            <p class="mt-1.5 text-xs text-gray-400">PNG, JPG, SVG, WEBP — Recommended: 200×50px — Max 2MB</p>
                        </div>

                        {{-- Favicon --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Website Favicon</label>
                            @php $currentFavicon = \App\Models\Setting::getValue('site_favicon') @endphp
                            @if($currentFavicon)
                                <div class="mb-3 p-4 bg-gray-50 border border-gray-200 rounded-xl inline-flex items-center gap-3">
                                    <img src="{{ mediaUrl($currentFavicon) }}" alt="Current Favicon" class="h-10 w-10 object-contain">
                                    <span class="text-xs text-green-600 font-medium bg-green-50 px-2 py-1 rounded-lg">Current</span>
                                </div>
                            @else
                                <div class="mb-3 p-4 bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl text-center text-xs text-gray-400">No favicon set</div>
                            @endif
                            <input type="file" name="favicon" id="favicon" accept=".ico,.png,.jpg"
                                class="block w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 cursor-pointer">
                            @error('favicon') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            <p class="mt-1.5 text-xs text-gray-400">ICO, PNG — Square image (32×32 or 64×64) — Max 512KB</p>
                        </div>

                    </div>
                </div>

                {{-- ============================================================ --}}
                {{-- SECTION 5: Contact Info --}}
                {{-- ============================================================ --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-emerald-600 to-teal-700 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-white font-semibold text-base">Contact Information</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Email --}}
                        <div>
                            <label for="contact_email" class="block text-sm font-semibold text-gray-700 mb-1">Contact Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                                </span>
                                <input type="text" name="contact_email" id="contact_email"
                                    value="{{ old('contact_email', $contactEmail) }}"
                                    class="w-full pl-10 rounded-xl border-gray-200 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm py-2.5"
                                    placeholder="info@yoursite.com">
                            </div>
                            @error('contact_email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label for="contact_phone" class="block text-sm font-semibold text-gray-700 mb-1">Contact Phone</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </span>
                                <input type="text" name="contact_phone" id="contact_phone"
                                    value="{{ old('contact_phone', $contactPhone) }}"
                                    class="w-full pl-10 rounded-xl border-gray-200 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm py-2.5"
                                    placeholder="+92 300 1234567">
                            </div>
                            @error('contact_phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Address --}}
                        <div class="md:col-span-2">
                            <label for="contact_address" class="block text-sm font-semibold text-gray-700 mb-1">Business Address</label>
                            <textarea name="contact_address" id="contact_address" rows="2"
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm px-4 py-2.5"
                                placeholder="123 Main Street, Lahore, Pakistan">{{ old('contact_address', $contactAddress) }}</textarea>
                        </div>

                    </div>
                </div>

                {{-- ============================================================ --}}
                {{-- SECTION 6: Social Media --}}
                {{-- ============================================================ --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-pink-500 to-rose-600 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                        </div>
                        <h3 class="text-white font-semibold text-base">Social Media Links</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                        @php
                            $socials = [
                                ['key' => 'social_facebook',  'label' => 'Facebook',  'var' => $socialFacebook,  'icon' => 'fab fa-facebook-f',   'placeholder' => 'https://facebook.com/yourpage',   'color' => 'text-blue-600'],
                                ['key' => 'social_instagram', 'label' => 'Instagram', 'var' => $socialInstagram, 'icon' => 'fab fa-instagram',     'placeholder' => 'https://instagram.com/yourpage',  'color' => 'text-pink-500'],
                                ['key' => 'social_linkedin',  'label' => 'LinkedIn',  'var' => $socialLinkedin,  'icon' => 'fab fa-linkedin-in',   'placeholder' => 'https://linkedin.com/in/yourpage', 'color' => 'text-blue-700'],
                                ['key' => 'social_tiktok',   'label' => 'TikTok',    'var' => $socialTiktok,    'icon' => 'fab fa-tiktok',        'placeholder' => 'https://tiktok.com/@yourpage',    'color' => 'text-gray-800'],
                                ['key' => 'social_youtube',  'label' => 'YouTube',   'var' => $socialYoutube,   'icon' => 'fab fa-youtube',       'placeholder' => 'https://youtube.com/@yourchannel', 'color' => 'text-red-600'],
                                ['key' => 'social_whatsapp', 'label' => 'WhatsApp Number', 'var' => $socialWhatsapp,  'icon' => 'fab fa-whatsapp', 'placeholder' => '+923001234567 (no spaces)',   'color' => 'text-green-600'],
                            ];
                        @endphp

                        @foreach($socials as $s)
                        <div>
                            <label for="{{ $s['key'] }}" class="block text-sm font-semibold text-gray-700 mb-1">{{ $s['label'] }}</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center {{ $s['color'] }}">
                                    <i class="{{ $s['icon'] }} text-sm"></i>
                                </span>
                                <input type="text" name="{{ $s['key'] }}" id="{{ $s['key'] }}"
                                    value="{{ old($s['key'], $s['var']) }}"
                                    class="w-full pl-10 rounded-xl border-gray-200 shadow-sm focus:ring-pink-400 focus:border-pink-400 text-sm py-2.5"
                                    placeholder="{{ $s['placeholder'] }}">
                            </div>
                        </div>
                        @endforeach

                </div>

                {{-- ============================================================ --}}
                {{-- SECTION 7: Featured Product Spotlight (Video & Showcase) --}}
                {{-- ============================================================ --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-emerald-800 via-green-800 to-teal-900 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                            <i class="fa-solid fa-star text-amber-300 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-base">Featured Product Spotlight (Video & Media Control)</h3>
                            <p class="text-emerald-200 text-xs">Customize the main page featured product video, titles, prices, and video links</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-6">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Section Tag Badge</label>
                                <input type="text" name="featured_section_tag" value="{{ old('featured_section_tag', $featuredSectionTag) }}"
                                    class="w-full rounded-xl border-gray-200 text-xs px-3 py-2.5" placeholder="🌟 Featured Product Spotlight">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Section Main Heading</label>
                                <input type="text" name="featured_section_heading" value="{{ old('featured_section_heading', $featuredSectionHeading) }}"
                                    class="w-full rounded-xl border-gray-200 text-xs px-3 py-2.5" placeholder="Experience Pure Herbal Excellence">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Section Subtitle / Description</label>
                            <input type="text" name="featured_section_subtitle" value="{{ old('featured_section_subtitle', $featuredSectionSubtitle) }}"
                                class="w-full rounded-xl border-gray-200 text-xs px-3 py-2.5" placeholder="Hand-extracted, lab-certified organic formula...">
                        </div>

                        <hr class="border-gray-100">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Product Title</label>
                                <input type="text" name="featured_product_title" value="{{ old('featured_product_title', $featuredProductTitle) }}"
                                    class="w-full rounded-xl border-gray-200 text-xs px-3 py-2.5">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Product CTA / Buy Link</label>
                                <input type="text" name="featured_btn_link" value="{{ old('featured_btn_link', $featuredBtnLink) }}"
                                    class="w-full rounded-xl border-gray-200 text-xs px-3 py-2.5" placeholder="/services/17">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Product Short Description</label>
                            <textarea name="featured_product_desc" rows="3" class="w-full rounded-xl border-gray-200 text-xs p-3">{{ old('featured_product_desc', $featuredProductDesc) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Special Price</label>
                                <input type="text" name="featured_price" value="{{ old('featured_price', $featuredPrice) }}"
                                    class="w-full rounded-xl border-gray-200 text-xs px-3 py-2.5" placeholder="Rs. 3,499">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Original Price (Strikethrough)</label>
                                <input type="text" name="featured_old_price" value="{{ old('featured_old_price', $featuredOldPrice) }}"
                                    class="w-full rounded-xl border-gray-200 text-xs px-3 py-2.5" placeholder="Rs. 4,999">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Discount Badge Tag</label>
                                <input type="text" name="featured_discount_tag" value="{{ old('featured_discount_tag', $featuredDiscountTag) }}"
                                    class="w-full rounded-xl border-gray-200 text-xs px-3 py-2.5" placeholder="Save 30% OFF">
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="p-4 bg-emerald-50/50 rounded-2xl border border-emerald-100 space-y-3">
                                <h4 class="font-bold text-xs text-emerald-900 uppercase">Studio Video 1 Control</h4>
                                <div>
                                    <label class="block text-[11px] font-semibold text-gray-700 mb-1">Video 1 Button Label</label>
                                    <input type="text" name="featured_video_1_label" value="{{ old('featured_video_1_label', $featuredVideo1Label) }}"
                                        class="w-full rounded-xl border-gray-200 text-xs px-3 py-2" placeholder="Marble Showcase">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-gray-700 mb-1">Video 1 Path / URL</label>
                                    <input type="text" name="featured_video_1" value="{{ old('featured_video_1', $featuredVideo1) }}"
                                        class="w-full rounded-xl border-gray-200 text-xs px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-gray-700 mb-1">Or Upload New Video 1 (mp4)</label>
                                    <input type="file" name="featured_video_1_file" accept="video/mp4,video/webm"
                                        class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-800 file:text-white hover:file:bg-emerald-900">
                                </div>
                            </div>

                            <div class="p-4 bg-amber-50/50 rounded-2xl border border-amber-100 space-y-3">
                                <h4 class="font-bold text-xs text-amber-900 uppercase">Studio Video 2 Control</h4>
                                <div>
                                    <label class="block text-[11px] font-semibold text-gray-700 mb-1">Video 2 Button Label</label>
                                    <input type="text" name="featured_video_2_label" value="{{ old('featured_video_2_label', $featuredVideo2Label) }}"
                                        class="w-full rounded-xl border-gray-200 text-xs px-3 py-2" placeholder="Gold & Black Edition">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-gray-700 mb-1">Video 2 Path / URL</label>
                                    <input type="text" name="featured_video_2" value="{{ old('featured_video_2', $featuredVideo2) }}"
                                        class="w-full rounded-xl border-gray-200 text-xs px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-gray-700 mb-1">Or Upload New Video 2 (mp4)</label>
                                    <input type="file" name="featured_video_2_file" accept="video/mp4,video/webm"
                                        class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-amber-700 file:text-white hover:file:bg-amber-800">
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        <h4 class="font-bold text-xs text-gray-800 uppercase">4 Feature Badges</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-semibold text-gray-700 mb-1">Badge 1</label>
                                <input type="text" name="featured_badge_1" value="{{ old('featured_badge_1', $featuredBadge1) }}"
                                    class="w-full rounded-xl border-gray-200 text-xs px-3 py-2" placeholder="100% Pure - Organic Sourced">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-gray-700 mb-1">Badge 2</label>
                                <input type="text" name="featured_badge_2" value="{{ old('featured_badge_2', $featuredBadge2) }}"
                                    class="w-full rounded-xl border-gray-200 text-xs px-3 py-2" placeholder="Lab Tested - Certified Quality">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-gray-700 mb-1">Badge 3</label>
                                <input type="text" name="featured_badge_3" value="{{ old('featured_badge_3', $featuredBadge3) }}"
                                    class="w-full rounded-xl border-gray-200 text-xs px-3 py-2" placeholder="Fast Acting - Max Absorption">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-gray-700 mb-1">Badge 4</label>
                                <input type="text" name="featured_badge_4" value="{{ old('featured_badge_4', $featuredBadge4) }}"
                                    class="w-full rounded-xl border-gray-200 text-xs px-3 py-2" placeholder="Zero Chemicals - No Preservatives">
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        {{-- VIDEO 2 PRODUCT DETAILS --}}
                        <div class="p-5 bg-amber-50/60 rounded-2xl border border-amber-200 space-y-4">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-amber-500/20 flex items-center justify-center text-amber-600">
                                    <i class="fa-solid fa-2 text-xs font-bold"></i>
                                </div>
                                <h4 class="font-bold text-sm text-amber-900 uppercase tracking-wide">Video 2 — Product Details</h4>
                                <span class="text-[10px] text-amber-600 bg-amber-100 px-2 py-0.5 rounded-full font-bold">Shown when Video 2 is clicked</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-[11px] font-semibold text-gray-700 mb-1">Product Title (Video 2)</label>
                                    <input type="text" name="featured_product_title_2" value="{{ old('featured_product_title_2', $featuredProductTitle2) }}"
                                        class="w-full rounded-xl border-amber-200 bg-white text-xs px-3 py-2.5" placeholder="e.g. HABIBI HERBAL TONIC">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-[11px] font-semibold text-gray-700 mb-1">Product Description (Video 2)</label>
                                    <textarea name="featured_product_desc_2" rows="2"
                                        class="w-full rounded-xl border-amber-200 bg-white text-xs px-3 py-2.5" placeholder="Short product description...">{{ old('featured_product_desc_2', $featuredProductDesc2) }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-gray-700 mb-1">Current Price (Video 2)</label>
                                    <input type="text" name="featured_price_2" value="{{ old('featured_price_2', $featuredPrice2) }}"
                                        class="w-full rounded-xl border-amber-200 bg-white text-xs px-3 py-2.5" placeholder="1200">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-gray-700 mb-1">Old Price (Video 2)</label>
                                    <input type="text" name="featured_old_price_2" value="{{ old('featured_old_price_2', $featuredOldPrice2) }}"
                                        class="w-full rounded-xl border-amber-200 bg-white text-xs px-3 py-2.5" placeholder="1500">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-[11px] font-semibold text-gray-700 mb-1">Discount Badge (Video 2)</label>
                                    <input type="text" name="featured_discount_tag_2" value="{{ old('featured_discount_tag_2', $featuredDiscountTag2) }}"
                                        class="w-full rounded-xl border-amber-200 bg-white text-xs px-3 py-2.5" placeholder="SAVE 20% OFF">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-gray-700 mb-1">Badge 1 (V2)</label>
                                    <input type="text" name="featured_badge_1_2" value="{{ old('featured_badge_1_2', $featuredBadge1_2) }}"
                                        class="w-full rounded-xl border-amber-200 bg-white text-xs px-3 py-2" placeholder="100% Pure - Organic Sourced">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-gray-700 mb-1">Badge 2 (V2)</label>
                                    <input type="text" name="featured_badge_2_2" value="{{ old('featured_badge_2_2', $featuredBadge2_2) }}"
                                        class="w-full rounded-xl border-amber-200 bg-white text-xs px-3 py-2" placeholder="Lab Tested - Certified Quality">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-gray-700 mb-1">Badge 3 (V2)</label>
                                    <input type="text" name="featured_badge_3_2" value="{{ old('featured_badge_3_2', $featuredBadge3_2) }}"
                                        class="w-full rounded-xl border-amber-200 bg-white text-xs px-3 py-2" placeholder="Fast Acting - Max Absorption">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-gray-700 mb-1">Badge 4 (V2)</label>
                                    <input type="text" name="featured_badge_4_2" value="{{ old('featured_badge_4_2', $featuredBadge4_2) }}"
                                        class="w-full rounded-xl border-amber-200 bg-white text-xs px-3 py-2" placeholder="Zero Chemicals - No Preservatives">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ============================================================ --}}
                {{-- SAVE BUTTON --}}
                {{-- ============================================================ --}}
                <div class="flex justify-end pb-4">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold text-sm rounded-xl shadow-lg hover:from-primary-700 hover:to-primary-800 hover:shadow-xl active:scale-95 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Save All Settings
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
