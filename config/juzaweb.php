<?php

use Juzaweb\CMS\Facades\Facades;

return [
    /**
     * Admin url prefix
     *
     * Default: admin-cp
     */
    'admin_prefix' => env('ADMIN_PREFIX', 'admin-cp'),


    'adminbar' => [
        /**
         * Show admin-bar in frontend
         *
         * Default: true
         */
        'enable' => (bool) env('ADMINBAR_ENDABLE', true),
    ],

    /**
     * Cache prefix
     *
     * Default: juzaweb_
     */
    'cache_prefix' => 'juzaweb_',

    /**
     * Show logs in admin page
     */
    'logs_viewer' => true,

    'translation' => [
        /**
         * Enable translation CMS/Plugins/Themes
         */
        'enable' => true
    ],

    'email' => [
        /**
         * Method send email
         *
         * Support: sync, queue, cron
         * Default: sync
         */
        'method' => env('EMAIL_METHOD', 'sync'),

        'default' => [
            'driver' => env('MAIL_MAILER'),
            'host' => env('MAIL_HOST'),
            'port' => env('MAIL_HOST'),
            'from_address' => env('MAIL_FROM_ADDRESS'),
            'from_name' => env('MAIL_FROM_NAME'),
            'encryption' => env('MAIL_ENCRYPTION'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
        ],
    ],

    'notification' => [
        /**
         * Method send notification
         *
         * Support: sync, queue, cron
         * Default: sync
         */
        'method' => 'sync',

        /**
         * Send mail via
         *
         * Support: database, mail
         */
        'via' => [
            'database' => [
                'enable' => true,
            ],
            'mail' => [
                'enable' => true,
                'connection' => 'default',
            ]
        ]
    ],

    'theme' => [
        /**
         * Enable upload themes
         *
         * Default: true
         */
        'enable_upload' => true,

        /**
         * Themes path
         *
         * This path used for save the generated theme. This path also will added
         * automatically to list of scanned folders.
         */
        'path' => JW_THEME_PATH,
    ],

    'plugin' => [
        /**
         * Enable upload plugins
         *
         * Default: true
         */
        'enable_upload' => true,

        /**
         * Path plugins folder
         *
         * Default: plugins
         */
        'path' => JW_PLUGIN_PATH,

        /**
         * Plugins assets path
         *
         * Path for assets when it was published
         * Default: plugins
         */
        'assets' => public_path('plugins'),
    ],

    'performance' => [
        /**
         * Minify views when compile
         *
         * Default: true
         */
        'minify_views' => true,

        /**
         * Deny iframe to website
         *
         * Default: true
         */
        'deny_iframe' => true,

        'query_cache' => [
            'enable' => true,
            'driver' => env('QUERY_CACHE_DRIVER', 'file'),
        ]
    ],

    /**
     * File management setting
     */
    'filemanager' => [
        /**
         * FileSystem disk
         */
        'disk' => 'public',
        /**
         * Optimizer image after upload
         *
         * @see https://juzaweb.com/documentation/start/image-optimizer
         */
        'image-optimizer' => (bool) env('IMAGE_OPTIMIZER', false),

        'svg_mimetypes' => [
            ...Facades::defaultSVGMimetypes(),
            //
        ],

        /**
         * File type
         *
         * Default: file, image
         */
        'types' => [
            'file' => [
                'max_size' => 50, // size in MB
                'valid_mime' => [
                    ...Facades::defaultFileMimetypes(),
                    //
                ],
                'extensions' => [
                    ...Facades::defaultFileExtensions(),
                    //
                ],
            ],
            'image' => [
                'max_size' => 5, // size in MB
                'valid_mime' => [
                    ...Facades::defaultImageMimetypes(),
                    //
                ],
                'extensions' => [
                    ...Facades::defaultImageExtensions(),
                    //
                ],
            ],
        ],
    ],

    'api' => [
        'enable' => env('JW_ALLOW_API', false)
    ],

    /**
     * Default database config
     */
    'config' => [
        ...Facades::defaultConfigs(),
        //
    ]
];