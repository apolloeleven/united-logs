<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use common\assets\Html5shiv;
use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Frontend application asset
 */
class FrontendAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@frontend/web/bundle';
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    /**
     * @var array
     */
    public $css = [
        'css/lobiadmin-with-plugins.css',
        'css/style.css',
        'css/bootstrap-tour.min.css',
    ];

    /**
     * @var array
     */
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

    /**
     * @var array
     */
    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        Html5shiv::class,
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'common\assets\FontAwesome',
    ];
}
