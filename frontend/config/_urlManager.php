<?php

use Sitemaped\Sitemap;

return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        // Pages
        ['pattern' => 'page/<slug>', 'route' => 'page/view'],

        // Articles
        ['pattern' => 'article/index', 'route' => 'article/index'],
        ['pattern' => 'article/attachment-download', 'route' => 'article/attachment-download'],
        ['pattern' => 'article/<slug>', 'route' => 'article/view'],

        // Sitemap
        ['pattern' => 'sitemap.xml', 'route' => 'site/sitemap', 'defaults' => ['format' => Sitemap::FORMAT_XML]],
        ['pattern' => 'sitemap.txt', 'route' => 'site/sitemap', 'defaults' => ['format' => Sitemap::FORMAT_TXT]],
        ['pattern' => 'sitemap.xml.gz', 'route' => 'site/sitemap', 'defaults' => ['format' => Sitemap::FORMAT_XML, 'gzip' => true]],

        // Api
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/article', 'only' => ['index', 'view', 'options']],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/user', 'only' => ['index', 'view', 'options']],

        [
            'class' => 'yii\rest\UrlRule',
            'pluralize' => false,
            'controller' => [
                'api/v1/log',
            ],
            'extraPatterns' => [
                'OPTIONS <action>' => 'options'
            ]
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'pluralize' => false,
            'controller' => [
                'api/v1/log',
            ],
            'extraPatterns' => [
                '<level:\w+>' => 'save-log'
            ]
        ]
    ]
];
