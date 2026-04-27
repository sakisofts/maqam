<?php

namespace app\assets;
use yii\web\AssetBundle;

class ReceiptAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/web';

    public $css = [
        'css/receipt.css',
    ];

    public $js = [
        'js/receipt.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // Publish the CSS and JS files
        $this->publishOptions = [
            'forceCopy' => YII_DEBUG,
        ];
    }
}
