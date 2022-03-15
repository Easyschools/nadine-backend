<?php

namespace App\ThirdParty;

use Illuminate\Support\Facades\Http;

class Pixel
{
    protected static $url         = 'https://graph.facebook.com/v13.0/327860485711760/events';
    protected static $accessToken = 'EAAE56BDTxZAwBAGLAzy4ri9WsNLeHT0VpkcpTQ7DSWsUpB7FCwRcG3rcFG3I4OjzDavqPV8n4rmJaV9ahKoIEG76uMb3D5FMOvKw1XZCnkPGeTegOEkbnJllB0ZAvkFYOjAyeNZAxaVDzb9WTJ4ScSQl2kIjnJNlBXbGZALPfQWBgowZC15UXD';

    public static function viewContent()
    {
        $data = [
            'access_token' => self::$accessToken,
            'data'         => [
                [
                    "event_name"    => "ViewContent",
                    "event_time"    => now()->timestamp,
                    "action_source" => "website",
                    "user_data"     => [
                        'em' => [null],
                        'ph' => [null],
                    ],
                ],
            ],
        ];

        $response = Http::post(self::$url, $data);

        return $response->body();
    }

    public static function addToCart()
    {
        $data = [
            'access_token' => self::$accessToken,
            'data'         => [
                [
                    "event_name"    => "AddToCart",
                    "event_time"    => now()->timestamp,
                    "action_source" => "website",
                    "user_data"     => [
                        'em' => [null],
                        'ph' => [null],
                    ],
                ],
            ],
        ];

        $response = Http::post(self::$url, $data);

        return $response->body();
    }

    public static function purchase($value = 0)
    {
        $data = [
            'access_token' => self::$accessToken,
            'data'         => [
                [
                    "event_name"    => "Purchase",
                    "event_time"    => now()->timestamp,
                    "action_source" => "website",
                    "user_data"     => [
                        'em' => [null],
                        'ph' => [null],
                    ],
                    "custom_data"   => [
                        'currency' => 'EGP',
                        'value'    => $value,
                    ],
                ],
            ],
        ];

        $response = Http::post(self::$url, $data);

        return $response->body();
    }
}
