<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
       // 'css/site.css',
       'css/font-awesome.min.css',
       'css/animate.min.css',
       'css/prettyPhoto.css',
       'css/main.css',
       'css/responsive.css',
       'css/myStyle.css',
    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/jquery.prettyPhoto.js',
        'js/jquery.isotope.min.js',
        'js/main.js',
        'js/wow.min.js',
        'js/myScript.js',
    ];
    public $font = [
        'font/fontawesome-webfont.eot?v=4.0.3',
        'font/fontawesome-webfont.eot?#iefix&v=4.0.3',
        'font/fontawesome-webfont.woff?v=4.0.3',
        'font/fontawesome-webfont.ttf?v=4.0.3',
        'font/fontawesome-webfont.svg?v=4.0.3#fontawesomeregular',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
