<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],

        'innova' => [
            'driver' => 'local',
            'root' => storage_path('app/public/innova'),
            'url' => env('APP_URL').'/storage/innova',
            'visibility' => 'public',
            'permissions' => [
                'file' => [
                    'public' => 0664,
                    'private' => 0600,
                ],
                'dir' => [
                    'public' => 0775,
                    'private' => 0700,
                ],
            ],
        ],

        'doblevela' => [
            'driver' => 'local',
            'root' => storage_path('app/public/doblevela'),
            'url' => env('APP_URL').'/storage/doblevela',
            'visibility' => 'public',
            'permissions' => [
                'file' => [
                    'public' => 0664,
                    'private' => 0600,
                ],
                'dir' => [
                    'public' => 0775,
                    'private' => 0700,
                ],
            ],
        ],

        'doblevela_img' => [
            'driver' => 'local',
            'root' => storage_path('app/public/doblevela/images'),
            'url' => env('APP_URL').'/storage/doblevela/images',
            'visibility' => 'public',
            'permissions' => [
                'file' => [
                    'public' => 0664,
                    'private' => 0600,
                ],
                'dir' => [
                    'public' => 0775,
                    'private' => 0700,
                ],
            ],
        ],

        'forpromotional' => [
            'driver' => 'local',
            'root' => storage_path('app/public/forpromotional'),
            'url' => env('APP_URL').'/storage/forpromotional',
            'visibility' => 'public',
            'permissions' => [
                'file' => [
                    'public' => 0664,
                    'private' => 0600,
                ],
                'dir' => [
                    'public' => 0775,
                    'private' => 0700,
                ],
            ],
        ],

        'promoopcion' => [
            'driver' => 'local',
            'root' => storage_path('app/public/promoopcion'),
            'url' => env('APP_URL').'/storage/promoopcion',
            'visibility' => 'public',
            'permissions' => [
                'file' => [
                    'public' => 0664,
                    'private' => 0600,
                ],
                'dir' => [
                    'public' => 0775,
                    'private' => 0700,
                ],
            ],
        ],

        'cotizacion' => [
            'driver' => 'local',
            'root' => storage_path('app/public/cotizaciones_imgs'),
            'url' => env('APP_URL').'/storage/cotizaciones_imgs',
            'visibility' => 'public',
            'permissions' => [
                'file' => [
                    'public' => 0664,
                    'private' => 0600,
                ],
                'dir' => [
                    'public' => 0775,
                    'private' => 0700,
                ],
            ],
        ],

        'custom_product' => [
            'driver' => 'local',
            'root' => storage_path('app/public/custom_product'),
            'url' => env('APP_URL').'/storage/custom_product',
            'visibility' => 'public',
            'permissions' => [
                'file' => [
                    'public' => 0664,
                    'private' => 0600,
                ],
                'dir' => [
                    'public' => 0775,
                    'private' => 0700,
                ],
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
        public_path('cotizacion') => storage_path('app/public/cotizaciones_img'),
        public_path('custom_product') => storage_path('app/public/custom_product'),
        public_path('innova') => storage_path('app/public/innova'),
        public_path('doblevela') => storage_path('app/public/doblevela'),
        public_path('forpromotional') => storage_path('app/public/forpromotional'),
        public_path('promoopcion') => storage_path('app/public/promoopcion'),
        public_path('innova_images') => storage_path('app/public/innova/images'),
        public_path('doblevela_images') => storage_path('app/public/doblevela/images'),
        public_path('forpromotional_images') => storage_path('app/public/forpromotional/images'),
        public_path('promoopcion_images') => storage_path('app/public/promoopcion/images'),
        public_path('images') => storage_path('app/images'),
    ],

];
