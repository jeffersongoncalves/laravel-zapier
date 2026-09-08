<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Zapier API Key
    |--------------------------------------------------------------------------
    |
    | Personal API key used to talk to the Zapier REST API (Zap listing,
    | turning Zaps on/off, task history, profile). Not required if you only
    | push payloads to catch hooks.
    |
    */
    'api_key' => env('ZAPIER_API_KEY'),

    'base_url' => env('ZAPIER_BASE_URL', 'https://api.zapier.com/v1'),

    'timeout' => (int) env('ZAPIER_TIMEOUT', 10),

    /*
    |--------------------------------------------------------------------------
    | Named Catch Hooks
    |--------------------------------------------------------------------------
    |
    | Map a name to a Zapier "Catch Hook" webhook URL so application code can
    | call Zapier::send('new-lead', [...]) instead of hardcoding URLs.
    |
    */
    'hooks' => [
        // 'new-lead' => env('ZAPIER_HOOK_NEW_LEAD'),
    ],
];
