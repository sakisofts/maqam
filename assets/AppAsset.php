<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/web';
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',
        'css/icons.css',
        'css/custom.css',
        'css/site.css',
        'css/linker.css',
    ];
    public $js = [
        'js/popper.js',
//        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js',h
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_END,
        'async' => false,
        'defer' => false
    ];
    public $cssOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];

    public function init()
    {
        parent::init();
        $this->publishOptions = [
            'forceCopy' => false,
//            'forceCopy' => YII_DEBUG,
            'appendTimestamp' => true
        ];
    }
}
