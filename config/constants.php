<?php
return [
    'provider' => [
        'direct' => 'direct',
        'facebook' => 'facebook',
        'google' => 'google',
    ],
    'roles' => [
        'superadmin' => [
            'name' => 'Super Admin',
            'description' => '',
            'code' => 'superadmin',
        ], 
        'client' => [
            'name' => 'Client',
            'description' => '',
            'code' => 'client',
        ], 
        'visitor' => [
            'name' => 'Visitor',
            'description' => '',
            'code' => 'visitor', 
        ]
    ],
];