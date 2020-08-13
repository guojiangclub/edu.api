<?php

/*
 * This file is part of ibrand/laravel-sms.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    'route' => [
        'prefix' => 'api/sms',
        'middleware' => ['api', 'cors'],
    ],

    'easy_sms' => [
        'timeout' => 5.0,

        // 默认发送配置
        'default' => [
            // 网关调用策略，默认：顺序调用
            'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

            // 默认可用的发送网关
            'gateways' => [
                'aliyun',
            ],
        ],

        // 可用的网关配置
        'gateways' => [
            'errorlog' => [
                'file' => storage_path('logs/laravel-sms.log'),
            ],

            'yunpian' => [
                'api_key' => '824f0ff2f71cab52936axxxxxxxxxx',
            ],

            'aliyun' => [
                'access_key_id' => env('ALIYUN_SMS_ACCESS_KEY_ID', 'dMu7iuvvVY1XRQHo'),
                'access_key_secret' => env('ALIYUN_SMS_ACCESS_KEY_SECRET', 'itsBfWv0cox1Mw8KFSrdTa2i1zFlGw'),
                'sign_name' => env('ALIYUN_SMS_SIGN_NAME', '果酱社区'),
                'code_template_id' => env('ALIYUN_SMS_CODE_TEMPLATE_ID', 'SMS_14930623'),
            ],

            'alidayu' => [
                //...
            ],
        ],
    ],

    'code' => [
        'length' => 5,
        'validMinutes' => 5,
        'maxAttempts' => 0,
    ],

    'data' => [
        'product' => env('SMS_DATA_PRODUCT', '果酱社区'),
    ],

    'dblog' => false,

    'content' => '【your app signature】亲爱的用户，您的验证码是%s。有效期为%s分钟，请尽快验证。',

    'storage' => \iBrand\Sms\Storage\CacheStorage::class,
];
