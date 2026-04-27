<?php
Yii::$container->set('yii\bootstrap5\BootstrapAsset', [
    'css' => [],  // Override Bootstrap CSS with empty array
]);

// Configure specific widgets to use your theme classes
Yii::$container->set('yii\bootstrap5\Button', [
    'options' => ['class' => 'btn'],
    'buttonType' => 'button',
]);

Yii::$container->set('yii\grid\GridView', [
    'tableOptions' => ['class' => 'table table-striped table-bordered'],
    'options' => ['class' => 'grid-view'],
    'layout' => "{summary}\n{items}\n{pager}",
    'pager' => [
        'options' => ['class' => 'pagination justify-content-center'],
        'linkContainerOptions' => ['class' => 'page-item'],
        'linkOptions' => ['class' => 'page-link'],
        'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
    ],
]);
