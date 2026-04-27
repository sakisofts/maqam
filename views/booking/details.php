<?php
/**
 * Reservation View Page
 *
 * @var $this yii\web\View
 * @var $model app\models\Reservation
 * @var $searchModel app\models\PaymentSearch
 * @var $search app\models\PaymentSearch
 * @var $provider yii\data\ActiveDataProvider
 */

use app\components\Generics\TableGenerator;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Reservation: ' . $model->reservation_number;
?>

<div class="reservation-view container-fluid py-4">
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="fs-3"><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="bg-white p-4 shadow-sm rounded">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h3 class="fs-5 text-primary mb-3">Reservation Information</h3>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th class="w-25">Reservation No:</th>
                                        <td><?= Html::encode($model->reservation_number) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Client:</th>
                                        <td><?= Html::encode($model->user()->name ?? 'N/A') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Package:</th>
                                        <td><?= Html::encode($model->package()->package_name ?? 'N/A') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Number of Pilgrims:</th>
                                        <td><?= Html::encode($model->number_of_pilgrims) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h3 class="fs-5 text-primary mb-3">Payment Details</h3>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th class="w-25">Total Amount:</th>
                                        <td><?= ($model->total_amount) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Amount Paid:</th>
                                        <td><?= ($model->amount_paid) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Balance Due:</th>
                                        <td class="<?= $model->balance_due > 0 ? 'text-danger fw-bold' : '' ?>">
                                            <?= ($model->balance_due) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Payment Deadline:</th>
                                        <td><?= ($model->payment_deadline) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($model->special_requests)): ?>
                    <div class="row mt-2">
                        <div class="col-12">
                            <h3 class="fs-5 text-primary mb-2">Special Requests</h3>
                            <div class="p-3 border rounded bg-light">
                                <?= Html::encode($model->special_requests) ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($model->pilgrimDetails) && !empty($model->pilgrimDetails)): ?>
                    <div class="row mt-4">
                        <div class="col-12">
                            <h3 class="fs-5 text-primary mb-3">Pilgrim Details</h3>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Passport No</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($model->pilgrimDetails as $i => $pilgrim): ?>
                                        <tr>
                                            <td><?= $i + 1 ?></td>
                                            <td><?= Html::encode($pilgrim->name) ?></td>
                                            <td><?= Html::encode($pilgrim->passport_no) ?></td>
                                            <td><?= Html::encode($pilgrim->gender) ?></td>
                                            <td><?= Html::encode($pilgrim->age) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <?= Html::a('Back', ['reserve'], ['class' => 'btn btn-secondary']) ?>
                            <?php if ($model->balance_due > 0): ?>
                                <?= Html::a('Proceed to Payment', ['pay-now', 'id' => $model->id,'type'=>'rsv'], [
                                    'class' => 'btn btn-success',
                                    'data' => [
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-4 bg-white px-4">
    <div class="row">
        <div class="col-12">
            <?=TableGenerator::table($search, $searchModel, $provider); ?>
        </div>
    </div>
</div>
