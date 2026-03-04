<?php
namespace Database\Seeders\public_settings;

use Illuminate\Database\Seeder;
use App\Services\Core\SettingService;
use Illuminate\Support\Facades\Cache;
use App\Models\PublicSettings\SiteSetting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cache::forget('settings');

        $data = [
            ['key' => 'is_production', 'value' => 0],
            ['key' => 'name_ar', 'value' => 'اسم الشركة'],
            ['key' => 'name_en', 'value' => config('app.name')],
            ['key' => 'email', 'value' => 'admin@admin.com'],
            ['key' => 'phone', 'value' => '+966123456789'],
            ['key' => 'whatsapp', 'value' => '+966123456789'],
            ['key' => 'logo', 'value' => 'logo.png'],
            ['key' => 'fav_icon', 'value' => 'fav_icon.png'],
            ['key' => 'login_background', 'value' => 'login_background.png'],
            ['key' => 'no_data_icon', 'value' => 'no_data.png'],
            ['key' => 'default_user', 'value' => 'default.png'],
            ['key' => 'intro_email', 'value' => 'admin@admin.com'],
            ['key' => 'intro_phone', 'value' => '+966123456789'],
            ['key' => 'intro_address', 'value' => 'الرياض - السعودية'],
            ['key' => 'intro_logo', 'value' => 'intro_logo.png'],
            ['key' => 'intro_loader', 'value' => 'intro_loader.png'],
            ['key' => 'about_image_1', 'value' => 'about_image_1.png'],
            ['key' => 'about_image_2', 'value' => 'about_image_2.png'],
            ['key' => 'intro_name_ar', 'value' => 'اسم التطبيق'],
            ['key' => 'intro_name_en', 'value' => config('app.name')],
            ['key' => 'intro_meta_description', 'value' => 'وصف مختصر للتطبيق'],
            ['key' => 'intro_meta_keywords', 'value' => 'كلمات مفتاحية'],
            ['key' => 'intro_about_ar', 'value' => 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساح'],
            ['key' => 'intro_about_en', 'value' => 'This text is an example of text that can be replaced in the same space. This text was generated from the Arabic text generator, where you can generate such text or many other texts. This text is an example of text that can be replaced in the same space. This text is an example of text It can be replaced in the same space. This text was generated from the Arabic text generator, where you can generate such text or many other texts. This text is an example of a text that can be replaced in the same space.'],
            ['key' => 'services_text_ar', 'value' => 'وصف الخدمات'],
            ['key' => 'services_text_en', 'value' => 'Services description'],
            ['key' => 'how_work_text_ar', 'value' => 'كيف يعمل التطبيق'],
            ['key' => 'how_work_text_en', 'value' => 'How it works'],
            ['key' => 'fqs_text_ar', 'value' => 'الأسئلة الشائعة'],
            ['key' => 'fqs_text_en', 'value' => 'FAQs'],
            ['key' => 'parteners_text_ar', 'value' => 'شركاء النجاح'],
            ['key' => 'parteners_text_en', 'value' => 'Partners'],
            ['key' => 'contact_text_ar', 'value' => 'تواصل معنا'],
            ['key' => 'contact_text_en', 'value' => 'Contact us'],
            ['key' => 'color', 'value' => '#10163a'],
            ['key' => 'buttons_color', 'value' => '#7367F0'],
            ['key' => 'hover_color', 'value' => '#262c49'],

            ['key' => 'smtp_user_name', 'value' => 'smtp_user_name'],
            ['key' => 'smtp_password', 'value' => 'smtp_password'],
            ['key' => 'smtp_mail_from', 'value' => 'smtp_mail_from'],
            ['key' => 'smtp_sender_name', 'value' => 'smtp_sender_name'],
            ['key' => 'smtp_port', 'value' => '587'],
            ['key' => 'smtp_host', 'value' => 'smtp.mailtrap.io'],
            ['key' => 'smtp_encryption', 'value' => 'tls'],

            ['key' => 'google_places', 'value' => ''],
            ['key' => 'google_analytics', 'value' => ''],
            ['key' => 'live_chat', 'value' => ''],
            ['key' => 'banner_image', 'value' => 'banner_image.png'],
            ['key' => 'match_cancellation_time', 'value' => 24],
            ['key' => 'nearest_stadiums_radius', 'value' => 10],
            ['key' => 'contact_numbers', 'value' => json_encode(['+966123456789'])],
            ['key' => 'privacy_ar', 'value' => 'سياسة الخصوصية'],
            ['key' => 'privacy_en', 'value' => 'Privacy Policy'],
            ['key' => 'notification_sound', 'value' => 'in.mp3'],
            ['key' =>  'vat_ratio', 'value' => 15],
            ['key' =>  'commission_from_providers', 'value' => 10],
            ['key' =>  'online_payment_fee', 'value' => 5],
        ];

        foreach ($data as $item) {
            SiteSetting::updateOrCreate(['key' => $item['key']], ['value' => $item['value']]);
        }

        Cache::rememberForever('settings', function () {
            return SettingService::appInformations(SiteSetting::pluck('value', 'key'));
        });
    }
}
