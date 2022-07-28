<?php

$name = !app()->runningInConsole() && request()->root() === env('AM_URL') ? 'Ananda Marga' : 'MSP';
$dir = !app()->runningInConsole() && request()->root() === env('AM_URL') ? 'am' : 'msp';

return [
    'name' => $name,
    'manifest' => [
        'name' => $name,
        'short_name' => $name,
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#ffffff',
        'display' => 'standalone',
        'orientation'=> 'any',
        'status_bar'=> 'black',
        'icons' => [

            '72x72' => [
                'path' => "/favicons/{$dir}/icon-72x72.png",
                'purpose' => 'any'
            ],

            '128x128' => [
                'path' => "/favicons/{$dir}/icon-128x128.png",
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => "/favicons/{$dir}/icon-144x144.png",
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => "/favicons/{$dir}/icon-152x152.png",
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => "/favicons/{$dir}/icon-192x192.png",
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            /*'640x1136' => '/images/icons/splash-640x1136.png',
            '750x1334' => '/images/icons/splash-750x1334.png',
            '828x1792' => '/images/icons/splash-828x1792.png',
            '1125x2436' => '/images/icons/splash-1125x2436.png',
            '1242x2208' => '/images/icons/splash-1242x2208.png',
            '1242x2688' => '/images/icons/splash-1242x2688.png',
            '1536x2048' => '/images/icons/splash-1536x2048.png',
            '1668x2224' => '/images/icons/splash-1668x2224.png',
            '1668x2388' => '/images/icons/splash-1668x2388.png',
            '2048x2732' => '/images/icons/splash-2048x2732.png',*/
            '2322x2322' => "/favicons/{$dir}/icon-2322x2322.png",
        ],
        'shortcuts' => [
            /*[
                'name' => $name . "1",
                'description' => 'Shortcut Link 1 Description',
                'url' => '/shortcutlink1',
                'icons' => [
                    "src" => "/favicons/{$dir}/apple-touch-icon-96x96.png",
                    "purpose" => "any"
                ]
            ],
            [
                'name' => $name . "2",
                'description' => 'Shortcut Link 2 Description',
                'url' => '/shortcutlink2'
            ]*/
        ],
        'custom' => []
    ]
];
