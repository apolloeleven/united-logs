<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Frontend application asset
 */
class FrontendAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $basePath = '@webroot';
    public $baseUrl = '@web';


    public $css = [
        'css/lobiadmin-with-plugins.css',
        'css/style.css',
        'css/bootstrap-tour.min.css',

    ];
    public $js = [
        'js/lobiplugins/lobibox.js',
        'js/highlight.pack.js',
        'js/config.js',
        'js/lobiadmin.js',
        'js/lobiadmin-app.js',
        'js/mark.js',
        'js/app.js',
        'js/bootstrap-tour.min.js',
        'js/jstree.min.js',

    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'common\assets\FontAwesome',
        'common\assets\Html5shiv'
    ];
}
