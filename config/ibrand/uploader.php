<?php

return [
    'default'      => [
        'disk' => env('DEFAULT_UPLOAD_DISK', 'public'),
    ],
    'disks'        => [
        'qiniu' => [
            'driver'     => 'qiniu',
            //七牛云access_key
            'access_key' => env('QINIU_ACCESS_KEY', ''),
            //七牛云secret_key
            'secret_key' => env('QINIU_SECRET_KEY', ''),
            //七牛云文件上传空间
            'bucket'     => env('QINIU_BUCKET', ''),
            //七牛云cdn域名
            'domain'     => env('QINIU_DOMAIN', ''),
            //与cdn域名保持一致
            'url'        => env('QINIU_DOMAIN', ''),
        ],
    ],
    'upload_image' => [
        //允许上传的文件类型
        'supportedExtensions' => ['png', 'jpg', 'jpeg', 'gif'],
        'supportedMimeTypes'  => ['image/jpeg', 'image/gif', 'image/png'],
        //单位：M
        'allowMaxSize'        => 2,
    ],
    'upload_voice' => [
        'supportedExtensions' => ['mp3', 'wav'],
        'supportedMimeTypes'  => ['audio/mpeg', 'audio/x-wav'],
        'allowMaxSize'        => 5,
    ],
    'upload_video' => [
        'supportedExtensions' => ['webm', 'mov', 'mp4'],
        'supportedMimeTypes'  => ['video/webm', 'video/mpeg', 'video/mp4', 'video/quicktime'],
        'allowMaxSize'        => 30,
    ],
];