<?php

use App\Models\PublicSettings\SiteSetting;
use App\Services\Core\CacheService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

function seo($key)
{
    return Seo::where('key', $key)->first();
}

function appInformations()
{
    $result = SiteSetting::pluck('value', 'key');
    return $result;
}


function convert2english($string)
{
    $newNumbers = range(0, 9);
    $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $string = str_replace($arabic, $newNumbers, $string);
    return $string;
}

function fixPhone($string = null)
{
    if (!$string) {
        return null;
    }

    $result = convert2english($string);
    $result = ltrim($result, '00');
    $result = ltrim($result, '0');
    $result = ltrim($result, '+');
    return $result;
}

function getYoutubeVideoId($youtubeUrl)
{
    preg_match(
        "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/",
        $youtubeUrl,
        $videoId
    );
    return $youtubeVideoId = isset($videoId[1]) ? $videoId[1] : "";
}

function lang()
{
    return App()->getLocale();
}

function generateRandomCode()
{
    return '1234';
    return rand(1111, 4444);
}

if (!function_exists('languages')) {
    function languages()
    {
        return ['ar', 'en'];
    }
}

if (!function_exists('defaultLang')) {
    function defaultLang()
    {
        return 'ar';
    }
}

if (!function_exists('calculateDistance')) {
    function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2): array
    {
        if ($latitude1 == $latitude2 && $longitude1 == $longitude2) {
            return ['value' => '0 ', 'text' => '0 m', 'duration' => '0 min', 'start_address' => ''];
        }
        $distance = Http::get('https://maps.googleapis.com/maps/api/directions/json?origin=' .
            $latitude1 . ',' . $longitude1 . '&destination=' . $latitude2 . ',' . $longitude2 . '&key=' .
            config('app.google_api_key'));
        if ($distance->object()->routes != []) {
            return [
                'value'         => $distance->object()->routes[0]->legs[0]->distance->text,
                'text'          => $distance->object()->routes[0]->legs[0]->distance->text,
                'duration'      => $distance->object()->routes[0]->legs[0]->duration->text,
                'start_address' => explode(',', $distance->object()->routes[0]->legs[0]->start_address)[0]
            ];
        }
        return ['value' => '0 ', 'text' => '0 m', 'duration' => '0 min', 'start_address' => ''];
    }
}

if (!function_exists('getDeliveryPrice')) {

    function getDeliveryPrice($user_lat, $user_lng, $provider_lat, $provider_lng): array
    {
        $distance = floatval(preg_replace('/[^0-9.]/', '', calculateDistance($user_lat, $user_lng, $provider_lat, $provider_lng)['value']));
        return ['price' => $distance * SiteSetting::where('key', 'price_per_kilometer')->first()->value];
    }
}

if (!function_exists('newNumberFormat')) {
    function newNumberFormat($number)
    {
        $formatter = new NumberFormatter('en', NumberFormatter::DECIMAL_SEPARATOR_SYMBOL);
        $formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 2);
        $formattedNumber = $formatter->format($number);
        return $formattedNumber;
    }
}

if (!function_exists('responseJson')) {
    function responseJson($msg, $code, $error, $errors = [], $key = 'fail')
    {
        return response()->json([
            'key'             => $key,
            'msg'             => $msg ?? __('apis.data_retrieved_successfully'),
            'code'            => $code,
            'response_status' => [
                'error'             => $error,
                'validation_errors' => $errors
            ],
            'data'            => null,
        ], $code);
    }
}

if (!function_exists('settingsImage')) {
    function settingsImage($key, $defaultReturn = '')
    {
        $settings = Cache::get('settings');
        return array_key_exists($key, $settings) ?
           $settings[$key] : $defaultReturn;
    }
}

if (!function_exists('settings')) {
    function settings($key, $local = false, $defaultReturn = '')
    {
        $settings = Cache::get('settings');
        if ($local) {
            return array_key_exists($key . '_' . lang(), $settings) ? $settings[$key . '_' . lang()] : '';
        }
        return array_key_exists($key, $settings) ? $settings[$key] : $defaultReturn;
    }
}

if (!function_exists('log_error')) {
    function log_error($exception = null)
    {
        delete_log_file();
        $trace = debug_backtrace();
        $class = $trace[1]['class'] ?? 'N/A';
        $function = $trace[1]['function'] ?? 'N/A';

        info('Error at class: ' . $class . ', function: ' . $function, [
            'message' => $exception?->getMessage(),
            'file' => [
                'file' => $exception?->getFile(),
                'line' => $exception?->getLine(),
            ],
        ]);

        return response()->json([
            'key' => 'fail',
            'msg' => __('apis.server_error'),
        ]);
    }
}

if (!function_exists('delete_log_file')) {
    function delete_log_file($max_size = 10)
    {
        $logFilePath = storage_path('logs/laravel.log');

        if (file_exists($logFilePath)) {
            $fileSize = filesize($logFilePath);
            $base = log($fileSize, 1024);
            $size = round(pow(1024, $base - floor($base)), 2);

            if ($size > $max_size) {
                unlink($logFilePath);
            }
        }
    }
}
