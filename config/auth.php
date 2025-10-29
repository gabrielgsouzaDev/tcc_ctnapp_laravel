<?php

return [

   'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'api' => [
        'driver' => 'sanctum',
        'provider' => 'users',
    ],
    'admin' => [
        'driver' => 'sanctum',
        'provider' => 'admins',
    ],
    'escola' => [
        'driver' => 'sanctum',
        'provider' => 'escolas',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\Usuario::class,
    ],
    'admins' => [
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class,
    ],
    'escolas' => [
        'driver' => 'eloquent',
        'model' => App\Models\Escola::class,
    ],
],

];
