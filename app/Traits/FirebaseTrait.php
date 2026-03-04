<?php

namespace App\Traits;

use App\Models\PublicSettings\Device;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

trait FirebaseTrait
{
    use NotificationMessageTrait;

    public function sendFcmNotification($tokens, $data = [], $lang = 'ar')
    {
        if ($tokens instanceof \Illuminate\Database\Eloquent\Relations\Relation) {
            $tokens = $tokens->get();
        }
        if ($tokens === null || $tokens->isEmpty()) {
            return;
        }

        $tokens
            ->groupBy('device_type')
            ->each(
                fn($devices, $type) =>
                $this->sendByType($devices, $type, $data, $lang)
            );
    }

    private function sendByType($devices, $type, $data, $lang)
    {
        $responses = Http::pool(function ($pool) use ($devices, $type, $data, $lang) {

            return $devices->mapWithKeys(function ($device) use ($pool, $type, $data, $lang) {

                $message = $this->buildMessage($type, $device, $data, $lang);

                if (!$message) {
                    return [];
                }

                return [
                    $device->device_id =>
                        $pool
                            ->withHeaders($this->fcmHeaders())
                            ->post($this->fcmUrl(), $message)
                ];
            })->toArray();
        });

        collect($responses)->each(
            fn($response, $token) =>
            $this->handleFcmResponse($response, $token)
        );
    }

    private function buildMessage($type, $device, $data, $lang)
    {
        $deviceLang = $device->lang ?? $lang;

        return match ($type) {
            'android' => $this->getAndroidMessageFormat($device->device_id, $data, $deviceLang),
            'ios' => $this->getIosMessageFormat($device->device_id, $data, $deviceLang),
            'web' => $this->getWebMessageFormat($device->device_id, $data, $deviceLang),
            default => null,
        };
    }

    private function fcmUrl()
    {
        return 'https://fcm.googleapis.com/v1/projects/' .
            config('app.project_id') .
            '/messages:send';
    }

    private function fcmHeaders()
    {
        return [
            'Authorization' => 'Bearer ' . $this->getToken(),
            'Content-Type' => 'application/json',
        ];
    }

    private function prepareData($data)
    {
        return collect($data)
            ->filter(fn($v) => !is_null($v))
            ->map(function ($v) {
                return is_array($v)
                    ? json_encode($v, JSON_UNESCAPED_UNICODE)
                    : (string) $v;
            })
            ->toArray();
    }

    private function getAndroidMessageFormat($token, $data, $lang)
    {
        $prepared = $this->prepareData($data);

        $prepared['lang'] = (string) $lang;
        $prepared['title'] = $this->getTitle($data['type'] ?? '', $lang);
        $prepared['message'] = $this->getBody($data, $lang);

        return [
            'message' => [
                'token' => $token,
                'data' => $prepared,
            ],
        ];
    }

    private function getIosMessageFormat($token, $data, $lang)
    {
        $notification = [
            'title' => $this->getTitle($data['type'] ?? '', $lang),
            'body' => $this->getBody($data, $lang),
            'image' => settingsImage('logo'),
        ];

        return [
            'message' => [
                'token' => $token,
                'notification' => $notification,
                'data' => $this->prepareData($data + ['lang' => $lang]),
                'apns' => [
                    'headers' => [
                        'apns-priority' => '10',
                        'apns-push-type' => 'alert',
                    ],
                    'payload' => [
                        'aps' => [
                            'alert' => $notification,
                            'sound' => 'default',
                        ],
                    ],
                ],
            ],
        ];
    }

    private function getWebMessageFormat($token, $data, $lang)
    {
        $notification = [
            'title' => $this->getTitle($data['type'] ?? '', $lang),
            'body' => $this->getBody($data, $lang),
            'image' => settingsImage('logo'),
        ];

        return [
            'message' => [
                'token' => $token,
                'data' => $this->prepareData($data + ['lang' => $lang]),
                'webpush' => [
                    'notification' => $notification,
                    'fcm_options' => [
                        'link' => $data['url'] ?? url('/admin/show-notifications'),
                    ],
                ],
            ],
        ];
    }

    private function getToken()
    {
        return Cache::remember('fcm_access_token', 3500, function () {

            $secret = openssl_get_privatekey(config('app.private_key'));

            $header = $this->base64UrlEncode(json_encode([
                'typ' => 'JWT',
                'alg' => 'RS256',
            ]));

            $time = time();

            $payload = $this->base64UrlEncode(json_encode([
                'iss' => config('app.client_email'),
                'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
                'aud' => 'https://oauth2.googleapis.com/token',
                'exp' => $time + 3600,
                'iat' => $time,
            ]));

            openssl_sign("$header.$payload", $signature, $secret, OPENSSL_ALGO_SHA256);

            $jwt = "$header.$payload." . $this->base64UrlEncode($signature);

            $response = Http::asForm()->post(
                'https://oauth2.googleapis.com/token',
                [
                    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                    'assertion' => $jwt,
                ]
            );

            $body = $response->json();

            if (!isset($body['access_token'])) {
                throw new \Exception('FCM token error: ' . json_encode($body));
            }

            return $body['access_token'];
        });
    }

    private function base64UrlEncode($text)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
    }

    private function handleFcmResponse($response, $token)
    {
        if (!$response->successful()) {

            $body = $response->json();

            if (
                isset($body['error']['details'][0]['errorCode']) &&
                $body['error']['details'][0]['errorCode'] === 'UNREGISTERED'
            ) {
                Device::where('device_id', $token)->delete();

                Log::warning('FCM token removed (UNREGISTERED)', [
                    'token' => $token,
                ]);
            }
        }
    }
}
