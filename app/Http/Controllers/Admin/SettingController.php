<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings', [
            // Branding
            'siteName'           => Setting::getValue('site_name', config('app.name')),
            'siteSlogan'         => Setting::getValue('site_slogan', ''),
            'siteTagline'        => Setting::getValue('site_tagline', ''),
            'siteDescription'    => Setting::getValue('site_description', ''),
            'metaDescription'    => Setting::getValue('meta_description', ''),
            // Contact
            'contactEmail'       => Setting::getValue('contact_email', ''),
            'contactPhone'       => Setting::getValue('contact_phone', ''),
            'contactAddress'     => Setting::getValue('contact_address', ''),
            // Social
            'socialFacebook'     => Setting::getValue('social_facebook', ''),
            'socialInstagram'    => Setting::getValue('social_instagram', ''),
            'socialLinkedin'     => Setting::getValue('social_linkedin', ''),
            'socialTiktok'       => Setting::getValue('social_tiktok', ''),
            'socialYoutube'      => Setting::getValue('social_youtube', ''),
            'socialWhatsapp'     => Setting::getValue('social_whatsapp', ''),
            // Theme & Colors
            'themePrimaryColor'  => Setting::getValue('theme_primary_color', '#15803d'),
            'themeSecondaryColor'=> Setting::getValue('theme_secondary_color', '#d97706'),
            'btnPrimaryBg'       => Setting::getValue('btn_primary_bg', '#15803d'),
            'btnPrimaryText'     => Setting::getValue('btn_primary_text', '#ffffff'),
            'btnSecondaryBg'     => Setting::getValue('btn_secondary_bg', '#d97706'),
            'btnSecondaryText'   => Setting::getValue('btn_secondary_text', '#ffffff'),
            'themeFontFamily'    => Setting::getValue('theme_font_family', 'Plus Jakarta Sans'),
            'adminSidebarBg'     => Setting::getValue('admin_sidebar_bg', '#052e16'),
            'adminDashboardTitle'=> Setting::getValue('admin_dashboard_title', 'Herbal Care Control'),
            // Homepage
            'fashionHeading'     => Setting::getValue('fashion_heading', 'Pure Organic Remedies'),
            'fashionSubtitle'    => Setting::getValue('fashion_subtitle', 'Handcrafted organic skincare, botanical teas, and certified herbal remedies.'),
            'fashionBtnText'     => Setting::getValue('fashion_btn_text', 'Explore Remedies'),
            'fashionBtnBg'       => Setting::getValue('fashion_btn_bg', '#d97706'),
            'trendingTag'        => Setting::getValue('trending_tag', 'Natural Wellness'),
            'trendingHeading'    => Setting::getValue('trending_heading', 'Herbal Care Categories'),
            'techHeading'        => Setting::getValue('tech_heading', 'Essential Oils & Extracts'),
            'techSubtitle'       => Setting::getValue('tech_subtitle', '100% pure cold-pressed oils, aroma extracts, and therapeutic solutions.'),
            'techBtnText'        => Setting::getValue('tech_btn_text', 'Explore Oils'),
            'techBtnBg'          => Setting::getValue('tech_btn_bg', '#15803d'),
            'enterpriseTag'      => Setting::getValue('enterprise_tag', 'Bulk & Wholesale Herbal Care'),
            'enterpriseHeading'  => Setting::getValue('enterprise_heading', 'Raw Herbs & Wholesale Supplies'),
            'enterpriseSubtitle' => Setting::getValue('enterprise_subtitle', 'Direct farm-sourced organic herbs, bulk essential oils, and herbal formulations.'),
            'newsletterHeading'  => Setting::getValue('newsletter_heading', 'JOIN OUR HERBAL WELLNESS CIRCLE'),
            'newsletterSubtitle' => Setting::getValue('newsletter_subtitle', 'Subscribe for herbal care tips, exclusive organic drops, and natural wellness discounts.'),
            // Services Page
            'servicesPageTag'    => Setting::getValue('services_page_tag', 'Strategic Asset Portfolio v4.0.0'),
            'servicesPageHeading'=> Setting::getValue('services_page_heading', 'Asset Portfolio'),
            'servicesPageSubtitle'=> Setting::getValue('services_page_subtitle', "Curating Pakistan's most sophisticated network of premium vendors and logistical architects for high-stakes execution."),
            // Contact Page
            'contactPageHeading' => Setting::getValue('contact_page_heading', 'Get In Touch'),
            'contactPageSubtitle'=> Setting::getValue('contact_page_subtitle', 'Dedicated service desks and expert teams ready to assist you with any inquiry, anytime, anywhere.'),
            'contactPageBadge'   => Setting::getValue('contact_page_badge', '24/7 Support Available'),
            // Featured Spotlight Section Settings
            'featuredSectionTag'      => Setting::getValue('featured_section_tag', '🌟 Featured Product Spotlight'),
            'featuredSectionHeading'  => Setting::getValue('featured_section_heading', 'Experience Pure Herbal Excellence'),
            'featuredSectionSubtitle' => Setting::getValue('featured_section_subtitle', 'Hand-extracted, lab-certified organic formula designed for maximum potency and natural vitality.'),
            'featuredProductTitle'    => Setting::getValue('featured_product_title', 'HABIBI HERBAL TONIC'),
            'featuredProductDesc'     => Setting::getValue('featured_product_desc', 'Formulated with Ginger, Garlic, Lemon, Honey, and Apple Cider Vinegar for daily vitality.'),
            'featuredPrice'           => Setting::getValue('featured_price', '1200'),
            'featuredOldPrice'        => Setting::getValue('featured_old_price', '1500'),
            'featuredDiscountTag'     => Setting::getValue('featured_discount_tag', 'SAVE 20% OFF'),
            'featuredVideo1'          => Setting::getValue('featured_video_1', 'uploads/videos/habibi-tonic-preview.mp4'),
            'featuredVideo1Label'     => Setting::getValue('featured_video_1_label', 'Habibi Herbal Tonic'),
            'featuredVideo2'          => Setting::getValue('featured_video_2', 'uploads/videos/1788705048_v2_Generating_branding_video_for_honey_202609061930.mp4'),
            'featuredVideo2Label'     => Setting::getValue('featured_video_2_label', 'Habibi Natural Honey'),
            'featuredBadge1'          => Setting::getValue('featured_badge_1', '100% Pure'),
            'featuredBadge2'          => Setting::getValue('featured_badge_2', 'Lab Tested'),
            'featuredBadge3'          => Setting::getValue('featured_badge_3', 'Fast Acting'),
            'featuredBadge4'          => Setting::getValue('featured_badge_4', 'Zero Chemicals'),
            
            // Video 2 details
            'featuredProductTitle2'   => Setting::getValue('featured_product_title_2', 'HABIBI NATURAL HONEY'),
            'featuredProductDesc2'    => Setting::getValue('featured_product_desc_2', '100% Natural, hand-harvested, and unprocessed golden honey rich in antioxidants.'),
            'featuredPrice2'          => Setting::getValue('featured_price_2', '1200'),
            'featuredOldPrice2'       => Setting::getValue('featured_old_price_2', '1500'),
            'featuredDiscountTag2'    => Setting::getValue('featured_discount_tag_2', 'SAVE 20% OFF'),
            'featuredBadge1_2'        => Setting::getValue('featured_badge_1_2', '100% Pure'),
            'featuredBadge2_2'        => Setting::getValue('featured_badge_2_2', 'Lab Tested'),
            'featuredBadge3_2'        => Setting::getValue('featured_badge_3_2', 'Fast Acting'),
            'featuredBadge4_2'        => Setting::getValue('featured_badge_4_2', 'Zero Chemicals'),

            'featuredBtnLink'         => Setting::getValue('featured_btn_link', '/services/2'),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name'                => 'required|string|max:255',
            'site_slogan'              => 'nullable|string|max:255',
            'site_tagline'             => 'nullable|string|max:500',
            'site_description'         => 'nullable|string|max:1000',
            'meta_description'         => 'nullable|string|max:500',
            'contact_email'            => 'nullable|string|max:255',
            'contact_phone'            => 'nullable|string|max:50',
            'contact_address'          => 'nullable|string|max:500',
            'social_facebook'          => 'nullable|string|max:255',
            'social_instagram'         => 'nullable|string|max:255',
            'social_linkedin'          => 'nullable|string|max:255',
            'social_tiktok'            => 'nullable|string|max:255',
            'social_youtube'           => 'nullable|string|max:255',
            'social_whatsapp'          => 'nullable|string|max:50',
            'theme_primary_color'      => 'nullable|string|max:20',
            'theme_secondary_color'    => 'nullable|string|max:20',
            'theme_font_family'        => 'nullable|string|max:100',
            'admin_sidebar_bg'         => 'nullable|string|max:20',
            'admin_dashboard_title'    => 'nullable|string|max:255',
            'fashion_heading'          => 'nullable|string|max:255',
            'fashion_subtitle'         => 'nullable|string|max:500',
            'fashion_btn_text'         => 'nullable|string|max:100',
            'tech_heading'             => 'nullable|string|max:255',
            'tech_subtitle'            => 'nullable|string|max:500',
            'tech_btn_text'            => 'nullable|string|max:100',
            'enterprise_tag'           => 'nullable|string|max:255',
            'enterprise_heading'       => 'nullable|string|max:255',
            'enterprise_subtitle'      => 'nullable|string|max:500',
            'newsletter_heading'       => 'nullable|string|max:255',
            'newsletter_subtitle'      => 'nullable|string|max:500',
            'services_page_tag'        => 'nullable|string|max:255',
            'services_page_heading'    => 'nullable|string|max:255',
            'services_page_subtitle'   => 'nullable|string|max:500',
            'contact_page_heading'     => 'nullable|string|max:255',
            'contact_page_subtitle'    => 'nullable|string|max:500',
            'contact_page_badge'       => 'nullable|string|max:100',
            'logo'                     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon'                  => 'nullable|mimes:ico,png,jpg|max:512',
            'hero_banner'              => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'services_banner'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'contact_banner'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'featured_video_1_file'    => 'nullable|mimetypes:video/mp4,video/webm,video/ogg,video/quicktime|max:51200',
            'featured_video_2_file'    => 'nullable|mimetypes:video/mp4,video/webm,video/ogg,video/quicktime|max:51200',
        ]);

        $formatUrl = function ($url) {
            if (empty($url) || $url === '#') return $url;
            if (!preg_match("~^(?:f|ht)tps?://~i", $url)) return "https://" . $url;
            return $url;
        };

        // Branding
        Setting::setValue('site_name',        $request->site_name);
        Setting::setValue('site_slogan',      $request->site_slogan ?? '');
        Setting::setValue('site_tagline',     $request->site_tagline ?? '');
        Setting::setValue('site_description', $request->site_description ?? '');
        Setting::setValue('meta_description', $request->meta_description ?? '');
        // Contact
        Setting::setValue('contact_email',   $request->contact_email ?? '');
        Setting::setValue('contact_phone',   $request->contact_phone ?? '');
        Setting::setValue('contact_address', $request->contact_address ?? '');
        // Social
        Setting::setValue('social_facebook',  $formatUrl($request->social_facebook ?? ''));
        Setting::setValue('social_instagram', $formatUrl($request->social_instagram ?? ''));
        Setting::setValue('social_linkedin',  $formatUrl($request->social_linkedin ?? ''));
        Setting::setValue('social_tiktok',    $formatUrl($request->social_tiktok ?? ''));
        Setting::setValue('social_youtube',   $formatUrl($request->social_youtube ?? ''));
        Setting::setValue('social_whatsapp',  $request->social_whatsapp ?? '');
        // Theme & Button Colors
        Setting::setValue('theme_primary_color',   $request->theme_primary_color ?? '#1d4ed8');
        Setting::setValue('theme_secondary_color', $request->theme_secondary_color ?? '#dc2626');
        Setting::setValue('btn_primary_bg',        $request->btn_primary_bg ?? '#1d4ed8');
        Setting::setValue('btn_primary_text',      $request->btn_primary_text ?? '#ffffff');
        Setting::setValue('btn_secondary_bg',      $request->btn_secondary_bg ?? '#dc2626');
        Setting::setValue('btn_secondary_text',    $request->btn_secondary_text ?? '#ffffff');
        Setting::setValue('theme_font_family',     $request->theme_font_family ?? 'Plus Jakarta Sans');
        Setting::setValue('admin_sidebar_bg',      $request->admin_sidebar_bg ?? '#172554');
        Setting::setValue('admin_dashboard_title', $request->admin_dashboard_title ?? 'Nexus Control');
        // Homepage Sections
        Setting::setValue('trending_tag',        $request->trending_tag ?? '');
        Setting::setValue('trending_heading',    $request->trending_heading ?? '');
        Setting::setValue('fashion_heading',     $request->fashion_heading ?? '');
        Setting::setValue('fashion_subtitle',    $request->fashion_subtitle ?? '');
        Setting::setValue('fashion_btn_text',    $request->fashion_btn_text ?? '');
        Setting::setValue('fashion_btn_bg',      $request->fashion_btn_bg ?? '#dc2626');
        Setting::setValue('tech_heading',        $request->tech_heading ?? '');
        Setting::setValue('tech_subtitle',       $request->tech_subtitle ?? '');
        Setting::setValue('tech_btn_text',       $request->tech_btn_text ?? '');
        Setting::setValue('tech_btn_bg',         $request->tech_btn_bg ?? '#172554');
        Setting::setValue('enterprise_tag',      $request->enterprise_tag ?? '');
        Setting::setValue('enterprise_heading',  $request->enterprise_heading ?? '');
        Setting::setValue('enterprise_subtitle', $request->enterprise_subtitle ?? '');
        Setting::setValue('newsletter_heading',  $request->newsletter_heading ?? '');
        Setting::setValue('newsletter_subtitle', $request->newsletter_subtitle ?? '');
        // Services Page
        Setting::setValue('services_page_tag',      $request->services_page_tag ?? '');
        Setting::setValue('services_page_heading',  $request->services_page_heading ?? '');
        Setting::setValue('services_page_subtitle', $request->services_page_subtitle ?? '');
        // Contact Page
        Setting::setValue('contact_page_heading',  $request->contact_page_heading ?? '');
        Setting::setValue('contact_page_subtitle', $request->contact_page_subtitle ?? '');
        Setting::setValue('contact_page_badge',    $request->contact_page_badge ?? '');

        // Featured Spotlight Section Settings
        Setting::setValue('featured_section_tag',      $request->featured_section_tag ?? '');
        Setting::setValue('featured_section_heading',  $request->featured_section_heading ?? '');
        Setting::setValue('featured_section_subtitle', $request->featured_section_subtitle ?? '');
        Setting::setValue('featured_product_title',    $request->featured_product_title ?? '');
        Setting::setValue('featured_product_desc',     $request->featured_product_desc ?? '');
        Setting::setValue('featured_price',           $request->featured_price ?? '');
        Setting::setValue('featured_old_price',       $request->featured_old_price ?? '');
        Setting::setValue('featured_discount_tag',     $request->featured_discount_tag ?? '');
        Setting::setValue('featured_video_1_label',     $request->featured_video_1_label ?? '');
        Setting::setValue('featured_video_2_label',     $request->featured_video_2_label ?? '');
        Setting::setValue('featured_badge_1',          $request->featured_badge_1 ?? '');
        Setting::setValue('featured_badge_2',          $request->featured_badge_2 ?? '');
        Setting::setValue('featured_badge_3',          $request->featured_badge_3 ?? '');
        Setting::setValue('featured_badge_4',          $request->featured_badge_4 ?? '');
        
        Setting::setValue('featured_product_title_2',  $request->featured_product_title_2 ?? '');
        Setting::setValue('featured_product_desc_2',   $request->featured_product_desc_2 ?? '');
        Setting::setValue('featured_price_2',          $request->featured_price_2 ?? '');
        Setting::setValue('featured_old_price_2',      $request->featured_old_price_2 ?? '');
        Setting::setValue('featured_discount_tag_2',   $request->featured_discount_tag_2 ?? '');
        Setting::setValue('featured_badge_1_2',        $request->featured_badge_1_2 ?? '');
        Setting::setValue('featured_badge_2_2',        $request->featured_badge_2_2 ?? '');
        Setting::setValue('featured_badge_3_2',        $request->featured_badge_3_2 ?? '');
        Setting::setValue('featured_badge_4_2',        $request->featured_badge_4_2 ?? '');

        Setting::setValue('featured_btn_link',         $request->featured_btn_link ?? '');

        if ($request->filled('featured_video_1')) {
            Setting::setValue('featured_video_1', $request->featured_video_1);
        }
        if ($request->filled('featured_video_2')) {
            Setting::setValue('featured_video_2', $request->featured_video_2);
        }

        // Upload Video Files if provided
        if ($request->hasFile('featured_video_1_file')) {
            $file = $request->file('featured_video_1_file');
            $filename = time() . '_v1_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/videos'), $filename);
            Setting::setValue('featured_video_1', '/uploads/videos/' . $filename);
        }
        if ($request->hasFile('featured_video_2_file')) {
            $file = $request->file('featured_video_2_file');
            $filename = time() . '_v2_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/videos'), $filename);
            Setting::setValue('featured_video_2', '/uploads/videos/' . $filename);
        }

        // Logo
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_logo_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/settings'), $filename);
            Setting::setValue('site_logo', '/uploads/settings/' . $filename);
        }
        // Favicon
        if ($request->hasFile('favicon')) {
            $file = $request->file('favicon');
            $filename = time() . '_favicon_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/settings'), $filename);
            Setting::setValue('site_favicon', '/uploads/settings/' . $filename);
        }
        // Hero Banner
        if ($request->hasFile('hero_banner')) {
            $file = $request->file('hero_banner');
            $filename = time() . '_hero_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/settings'), $filename);
            Setting::setValue('hero_banner_image', '/uploads/settings/' . $filename);
        }
        // Services Page Banner
        if ($request->hasFile('services_banner')) {
            $file = $request->file('services_banner');
            $filename = time() . '_services_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/settings'), $filename);
            Setting::setValue('services_banner_image', '/uploads/settings/' . $filename);
        }
        // Contact Page Banner
        if ($request->hasFile('contact_banner')) {
            $file = $request->file('contact_banner');
            $filename = time() . '_contact_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/settings'), $filename);
            Setting::setValue('contact_banner_image', '/uploads/settings/' . $filename);
        }

        return redirect()->back()->with('success', 'All website settings updated successfully.');
    }
}
