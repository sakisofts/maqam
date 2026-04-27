<?php
use app\components\Generics\FlashAlertWidget;
use app\components\Generics\TableGenerator;
use app\widgets\PageHeaderWidget;
use yii\bootstrap5\Html;
use yii\bootstrap5\LinkPager;

$this->title = "Users";

/**
 * @var $search \app\models\UserSearch
 * @var $model \app\models\User
 * @var $provider \yii\data\ActiveDataProvider
 * @var $export \app\models\User
 * @var $searchFields \app\models\UserSearch
 * @var $title string
 */

?>
<div class="contain-fluid bg-white p-4">
    <?= FlashAlertWidget::widget([
        'duration' => 5000,
        'position' => 'top-right',
        'showCloseButton' => true
    ]) ?>
    <?= PageHeaderWidget::widget([
        'page' => $title,
        'export_model' => $export,
        'searchFields' => $searchFields,
        'model' => $search,
        'additional_buttons' => [
            [    'url' => 'create-user',
                'label' => 'Add User',
                'icon' => 'fas fa-plus ',
                'options' => [
                    'class' => 'btn btn-primary',
                    'id' => 'import-btn'
                ]
            ]
        ]
    ]) ?>
    <div class="row">
        <div class="col-12">
            <?=TableGenerator::table($search, $model, $provider); ?>
        </div>
    </div>
</div>
