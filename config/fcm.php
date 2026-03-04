<?php

return [
    'project_id' => env('FIREBASE_PROJECT_ID'),
    'private_key' => env('FIREBASE_PRIVATE_KEY'),
    'client_email' => env('FIREBASE_CLIENT_EMAIL'),

    // for dashboard notifications
    'api_key' => env('FB_API_KEY'),
    'auth_domain' => env('FB_AUTH_DOMAIN'),
    'storage_bucket' => env('FB_STORAGE_BUCKET'),
    'messaging_sender_id' => env('FB_MESSAGING_SENDER_ID'),
    'app_id' => env('FB_APP_ID'),
    'measurement_id' => env('FB_MEASUREMENT_ID'),
    'vapid_key' => env('FB_VAPID_KEY'),
];
