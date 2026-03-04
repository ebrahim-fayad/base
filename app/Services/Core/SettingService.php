<?php

namespace App\Services\Core;


use App\Models\Core\Page;
use App\Models\PublicSettings\SiteSetting;
use App\Traits\UploadTrait;
use App\Traits\ReportTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;

class SettingService
{

    use UploadTrait;

    public static function appInformations($app_info)
    {
        $data = [
            'is_production' => $app_info['is_production'],
            'name_ar'       => $app_info['name_ar'],
            'name_en'       => $app_info['name_en'],
            'email'         => $app_info['email'],
            'phone'         => $app_info['phone'],
            'whatsapp'      => $app_info['whatsapp'],

            'logo'             => ('/storage/images/settings/' . $app_info['logo']),
            'fav_icon'         => ('/storage/images/settings/' . $app_info['fav_icon']),
            'default_user'     => ('/storage/images/users/' . $app_info['default_user']),
            'login_background' => ('/storage/images/settings/' . $app_info['login_background']),
            'intro_logo'       => ('/storage/images/settings/' . $app_info['intro_logo']),
            'intro_loader'     => ('/storage/images/settings/' . $app_info['intro_loader']),

            'intro_name'    => $app_info['intro_name_' . lang()],
            'intro_name_ar' => $app_info['intro_name_ar'],
            'intro_name_en' => $app_info['intro_name_en'],

            'intro_about'    => $app_info['intro_about_' . lang()],
            'intro_about_ar' => $app_info['intro_about_ar'],
            'intro_about_en' => $app_info['intro_about_en'],

            'about_image_2'          => ('/storage/images/settings/' . $app_info['about_image_2']),
            'about_image_1'          => ('/storage/images/settings/' . $app_info['about_image_1']),
            'services_text_ar'       => $app_info['services_text_ar'],
            'services_text_en'       => $app_info['services_text_en'],
            'services_text'          => $app_info['services_text_' . lang()],
            'how_work_text_ar'       => $app_info['how_work_text_ar'],
            'how_work_text_en'       => $app_info['how_work_text_en'],
            'how_work_text'          => $app_info['how_work_text_' . lang()],
            'fqs_text_ar'            => $app_info['fqs_text_ar'],
            'fqs_text_en'            => $app_info['fqs_text_en'],
            'fqs_text'               => $app_info['fqs_text_' . lang()],
            'parteners_text_ar'      => $app_info['parteners_text_ar'],
            'parteners_text_en'      => $app_info['parteners_text_en'],
            'parteners_text'         => $app_info['parteners_text_' . lang()],
            'contact_text_ar'        => $app_info['contact_text_ar'],
            'contact_text_en'        => $app_info['contact_text_en'],
            'contact_text'           => $app_info['contact_text_' . lang()],
            'intro_email'            => $app_info['intro_email'],
            'intro_phone'            => $app_info['intro_phone'],
            'intro_address'          => $app_info['intro_address'],
            'color'                  => $app_info['color'],
            'buttons_color'          => $app_info['buttons_color'],
            'hover_color'            => $app_info['hover_color'],
            'intro_meta_description' => $app_info['intro_meta_description'],
            'intro_meta_keywords'    => $app_info['intro_meta_keywords'],
            'vat_ratio'            => $app_info['vat_ratio'],
            'commission_from_providers' => $app_info['commission_from_providers'],
            'online_payment_fee' => $app_info['online_payment_fee'],
            'smtp_user_name'   => $app_info['smtp_user_name'],
            'smtp_password'    => $app_info['smtp_password'],
            'smtp_mail_from'   => $app_info['smtp_mail_from'],
            'smtp_sender_name' => $app_info['smtp_sender_name'],
            'smtp_port'        => $app_info['smtp_port'],
            'smtp_host'        => $app_info['smtp_host'],
            'smtp_encryption'  => $app_info['smtp_encryption'],


            'google_places'    => $app_info['google_places'],
            'google_analytics' => $app_info['google_analytics'],
            'live_chat'        => $app_info['live_chat'],
            'no_data_icon'     => ('/storage/images/' . $app_info['no_data_icon']),
            'banner_image'     => ('/storage/images/settings/' . $app_info['banner_image']),
            'match_cancellation_time' => $app_info['match_cancellation_time'],
            'nearest_stadiums_radius' => $app_info['nearest_stadiums_radius'],
            'contact_numbers' => json_decode($app_info['contact_numbers'] ?? '[]', true),
            'notification_sound' => self::buildNotificationSoundPath($app_info['notification_sound'] ?? null),
            // 'privacy_ar' => $app_info['privacy_ar'],
            // 'privacy_en' => $app_info['privacy_en'],
        ];
        return $data;
    }

    public function get(): array
    {
        return Cache::rememberForever('settings', function () {
            return self::appInformations(SiteSetting::pluck('value', 'key'));
        });
    }

    public function edit($request): array
    {
        // Validate contact_numbers if exists
        if ($request->has('contact_numbers') && is_array($request->contact_numbers)) {
            foreach ($request->contact_numbers as $number) {
                if (!empty($number)) {
                    // Remove any non-digit characters for validation
                    $cleanNumber = preg_replace('/\D/', '', $number);
                    $length = strlen($cleanNumber);

                    if ($length < 9 || $length > 15) {
                        return [
                            'key' => 'danger',
                            'msg' => __('admin.contact_number_length_error', ['min' => 9, 'max' => 15])
                        ];
                    }
                }
            }
        }

        Cache::forget('settings');

        foreach ($request->all() as $key => $val) {
            if ($key === 'notification_sound' && $request->hasFile('notification_sound')) {
                $file = $request->file('notification_sound');
                $fileName = $this->uploadAllTypes($file, 'sounds');

                if (!$fileName) {
                    return ['key' => 'danger', 'msg' => __('admin.not_valid_image')];
                }

                SiteSetting::where('key', 'notification_sound')->update(['value' => $fileName]);
                continue;
            }

            if (!is_array($val) && is_file($val)) {

                if (str_contains($val->getClientmimeType(), 'image')) {
                    $manager = ImageManager::gd(autoOrientation: false);
                    $img = $manager->read($val);
                    if ($key == 'default_user') {
                        $dir = 'storage/images/users';
                        $this->createDirIfNotExist($dir);
                        $name = 'default.webp';
                        $thumbsPath = $dir . '/default.webp';
                    } else if ($key == 'no_data_icon' ) {
                        $dir = 'storage/images';
                        $this->createDirIfNotExist($dir);
                        $name = 'no_data.png';
                        $thumbsPath = $dir . '/no_data.png';
                    } else {
                        $img->orient();
                        $name = time() . rand(1000000, 9999999) . '.webp';
                        $dir = 'storage/images/settings';
                        $this->createDirIfNotExist($dir);
                        $thumbsPath = $dir . '/' . $name;
                    }
                    SiteSetting::where('key', $key)->update(['value' => $name]);
                    $img->save($thumbsPath, 90, 'webp');
                } else {
                    return ['key' => 'danger', 'msg' => __('admin.not_valid_image')];
                }
            } else if ($val) {
                if ($key == 'contact_numbers' && is_array($val)) {
                    SiteSetting::where('key', $key)->update(['value' => json_encode(array_filter($val))]);
                } else {
                    SiteSetting::where('key', $key)->update(['value' => $val]);
                }
            }
        }
        if ($request->is_production) {
            SiteSetting::where('key', 'is_production')->update(['value' => 1]);
        } else {
            SiteSetting::where('key', 'is_production')->update(['value' => 0]);
        }

        Cache::rememberForever('settings', function () {
            return self::appInformations(SiteSetting::pluck('value', 'key'));
        });

        ReportTrait::addToLog('تعديل الاعدادت');

        return ['key' => 'success', 'msg' => __('admin.saved_successfully')];
    }

    protected function createDirIfNotExist($path)
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
    }

    public function getFixedPage($slug): array
    {
        $content = Page::whereSlug($slug)->first()?->content;
        return ['key' => 'success', 'content' => $content, 'msg' => __('apis.success')];
    }

    public function getAppMenu($model): array
    {
        $rows = $model::latest()->get();
        return ['key' => 'success', 'rows' => $rows, 'msg' => __('apis.success')];
    }

    public function switchLang($request, $user): array
    {
        if ($user) {
            $user->update(['lang' => $request->lang]);
            if ($request->device_id) {
                $user->devices()
                    ->where('device_id', $request->device_id)
                    ->update(['lang' => $request->lang]);
            }
        }

        App::setLocale($request->lang);
        return ['key' => 'success', 'msg' => __('apis.updated')];
    }

    public function getValueFromSetting($key): array
    {
        $value = SiteSetting::where('key', $key)->first()->value;
        return ['key' => 'success', 'data' => $value, 'msg' => __('apis.success')];
    }

    protected static function buildNotificationSoundPath(?string $name): ?string
    {
        if (!$name) {
            return null;
        }

        $storageRelative = 'storage/images/sounds/' . $name;
        if (file_exists(public_path($storageRelative))) {
            return $storageRelative;
        }

        $publicRelative = 'public/sounds/' . $name;
        if (file_exists(public_path($publicRelative))) {
            return $publicRelative;
        }

        return $storageRelative;
    }
}
