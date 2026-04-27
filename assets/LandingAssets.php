<?php

namespace app\assets;
use yii\web\AssetBundle;

class LandingAssets extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/web/front/';

    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        'vendors/themify-icons/css/themify-icons.css',
        'css/creative-studio.css'
    ];
    public $js = [
        'vendors/jquery/jquery-3.4.1.js',
        'vendors/bootstrap/bootstrap.bundle.js',
        'vendors/bootstrap/bootstrap.affix.js',
        'js/creative-studio.js'
    ];
}
