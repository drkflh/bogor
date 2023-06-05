<?php
return [
    'appList' => [
        [
            'name' => "SMS",
            'url' => "sms/dashboard",
            'icon' => '<i data-feather="message-square" class="icon-lg"></i>',
            'ns'=>'sms/*',
            'nav'=>'sms/nav'
        ],
        [
            'name' => "FAS",
            'url' => "fas/dashboard",
            'icon' => '<i data-feather="dollar-sign" class="icon-lg"></i>',
            'ns'=>'fas/*',
            'nav'=>'fas/nav'
        ],
        [
            'name' => "WP",
            'url' => "wp/dashboard",
            'icon' => '<i data-feather="home" class="icon-lg"></i>',
            'ns'=>'wp/*',
            'nav'=>'wp/nav'
        ],
        [
            'name' => "Central",
            'url' => "central/dashboard",
            'icon' => '<i data-feather="command" class="icon-lg"></i>',
            'ns'=>'central/*',
            'nav'=>'central/nav'
        ],
    ],

];
