<?php

return [
    [
        'text' => 'menu.home',
        'icon' => 'fa fa-dashboard',
        'route' => 'home.index',
    ],
    [
        'text' => 'Users',
        'icon' => 'fa fa-users',
        'children' => [
            [
                'text' => 'List Users',
                'route' => 'user.index',
                'icon' => 'fa fa-users',
//                'permissions' => ['list users'],
            ],
            [
                'text' => 'Create User',
                'route' => 'user.create',
                'icon' => 'fa fa-users',
//                'permissions' => ['list users'],
            ],
        ],
    ],
    // Thêm các mục menu khác tương tự
];
