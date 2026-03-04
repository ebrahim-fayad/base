<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait FirebaseTrait
{
    use NotificationMessageTrait;

    public function sendFcmNotification($tokens, $data = [], $lang = 'ar')
    {
        return false;//TODO: remove this after testing
        $apiurl = 'https://fcm.googleapis.com/v1/projects/' . config('app.project_id') . '/messages:send';

        $headers = [
            'Authorization' => 'Bearer ' . $this->getToken(),
            'Content-Type'  => 'application/json',
        ];

        $notification = [
            'title' => $this->getTitle($data['type'] ?? '', $lang),
            'body'  => $this->getBody($data, $lang),
        ];

        $preparedData = $this->prepareData($data);
        $iosTokens = clone $tokens;

        $this->sendAndroidFcmNotifications(
            $tokens->where('device_type', 'android')->get(),
            $preparedData,
            $apiurl,
            $headers,
            $notification,
            $lang
        );

        $this->sendIosFcmNotifications(
            $iosTokens->whereIn('device_type', ['ios', 'web'])->pluck('device_id')->toArray(),
            array_merge($preparedData, $notification),
            $apiurl,
            $headers,
            $notification
        );
    }

    private function prepareData($data)
    {
        foreach ($data as $key => $value) {
            if (is_int($value) || is_bool($value)) {
                $data[$key] = strval($value);
            } elseif (is_array($value)) {
                $data[$key] = json_encode($value);
            }
        }
        return $data;
    }

    private function sendAndroidFcmNotifications($tokens, $data, $url, $headers, $notification, $lang)
    {
        foreach ($tokens as $token) {
            $message = $this->getAndroidMessageFormat($token->device_id, $data, $notification, $token->lang ?? $lang);
            try {
                $response = Http::withHeaders($headers)->post($url, $message);
                Log::info('Android FCM response:', [
                    'token'    => $token->device_id,
                    'message'  => $message,
                    'response' => $response->body(),
                ]);
            } catch (\Throwable $e) {
                Log::error('Android FCM send failed: ' . $e->getMessage());
            }
        }
    }

    private function sendIosFcmNotifications($tokens, $data, $url, $headers, $notification)
    {
        foreach ($tokens as $token) {
            $message = $this->getIosMessageFormat($token, $data, $notification);

            try {
                $response = Http::withHeaders($headers)->post($url, $message);

                Log::info('iOS FCM response:', [
                    'token'    => $token,
                    'message'  => $message,
                    'response' => $response->body(),
                ]);
            } catch (\Throwable $e) {
                Log::error('iOS FCM send failed: ' . $e->getMessage());
            }
        }
    }

    private function getAndroidMessageFormat($token, $data, $notification, $lang)
    {
        $lang = $lang ?? $data['lang'] ?? 'ar';

        return [
            'message' => [
                'token' => $token,
                'data'  => [
                    'title'      => $this->getTitle($data['type'], $lang),
                    'message'    => $this->getBody($data, $lang),
                    'type'       => $data['type'],
                    'order_id'   => $data['order_id'] ?? null,
                    'order_type' => $data['order_type'] ?? null,
                ],
            ],
        ];
    }

    private function getIosMessageFormat($token, $data, $notification)
    {
        return [
            'message' => [
                'token'        => $token,
                'notification' => $notification,
                'data'         => $data,
                'apns'         => [
                    'headers' => [
                        'apns-priority'  => '10',
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

    private function getToken()
    {
        $secret = \openssl_get_privatekey(config('app.private_key'));

        $header = json_encode(['typ' => 'JWT', 'alg' => 'RS256']);
        $time = time();
        $payload = json_encode([
            'iss'   => config('app.client_email'),
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud'   => 'https://oauth2.googleapis.com/token',
            'exp'   => $time + 3600,
            'iat'   => $time,
        ]);

        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode($payload);

        \openssl_sign($base64UrlHeader . "." . $base64UrlPayload, $signature, $secret, OPENSSL_ALGO_SHA256);
        $base64UrlSignature = $this->base64UrlEncode($signature);
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion'  => $jwt,
        ]);

        $responseBody = $response->json();

        if (!isset($responseBody['access_token'])) {
            throw new \Exception("Failed to get access token: " . json_encode($responseBody));
        }

        return $responseBody['access_token'];
    }

    private function base64UrlEncode($text)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
    }
}
