<?php
/* @var $this yii\web\View */
/* @var $transaction app\models\Transaction */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Transaction Status';
$this->params['breadcrumbs'][] = ['label' => 'Transactions', 'url' => ['transactions']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="transaction-status">
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?= Html::encode($transaction->type == $transaction::TYPE_COLLECTION ? 'Payment' : 'Disbursement') ?>
                    Details
                </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-striped">
                            <tr>
                                <th>Transaction ID</th>
                                <td><?= Html::encode($transaction->transaction_id) ?></td>
                            </tr>
                            <tr>
                                <th>Reference</th>
                                <td><?= Html::encode($transaction->reference) ?></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><?= Html::encode($transaction->phone) ?></td>
                            </tr>
                            <tr>
                                <th>Amount</th>
                                <td><?= Html::encode($transaction->amount) ?> <?= Html::encode($transaction->currency) ?></td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td><?= $transaction->getTypeLabel() ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-striped">
                            <tr>
                                <th>Status</th>
                                <td><?= $transaction->getStatusLabel() ?></td>
                            </tr>
                            <tr>
                                <th>Payment Status</th>
                                <td><?= Html::encode($transaction->payment_status ?: 'N/A') ?></td>
                            </tr>
                            <tr>
                                <th>Message</th>
                                <td><?= Html::encode($transaction->message ?: 'N/A') ?></td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td><?= Yii::$app->formatter->asDatetime($transaction->created_at) ?></td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td><?= Yii::$app->formatter->asDatetime($transaction->updated_at) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <?php if ($transaction->description): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Description</h4>
                            <div class="well">
                                <?= Html::encode($transaction->description) ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($transaction->callback_data): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Callback Data</h4>
                            <div class="well">
                                <pre><?= Html::encode($transaction->callback_data) ?></pre>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group">
                            <?php if ($transaction->status == $transaction::STATUS_PENDING): ?>
                                <?= Html::a('Check Status', ['check-status', 'id' => $transaction->transaction_id, 'type' => $transaction->type], [
                                    'class' => 'btn btn-primary',
                                    'data-method' => 'get',
                                    'id' => 'check-status-btn'
                                ]) ?>
                            <?php endif; ?>
                            <?= Html::a('Back to Transactions', ['transactions'], ['class' => 'btn btn-default']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php if ($transaction->status == $transaction::STATUS_PENDING): ?>
    <script>
        $(document).ready(function() {
            // Auto-refresh status every 30 seconds for pending transactions
            var refreshInterval = setInterval(function() {
                $.ajax({
                    url: '<?= Url::to(['check-status', 'id' => $transaction->transaction_id, 'type' => $transaction->type]) ?>',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            if (response.data.status && (response.data.status.toLowerCase() === 'successful' ||
                                response.data.status.toLowerCase() === 'failed')) {
                                // Reload page to show updated status
                                location.reload();
                                // Clear interval to stop refreshing
                                clearInterval(refreshInterval);
                            }
                        }
                    }
                });
            }, 30000); // Check every 30 seconds

            // Handle manual check status button
            $('#check-status-btn').on('click', function(e) {
                e.preventDefault();

                var btn = $(this);
                btn.prop('disabled', true).text('Checking...');

                $.ajax({
                    url: btn.attr('href'),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Reload page to show updated status
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                            btn.prop('disabled', false).text('Check Status');
                        }
                    },
                    error: function() {
                        alert('An error occurred while checking status');
                        btn.prop('disabled', false).text('Check Status');
                    }
                });
            });
        });
    </script>
<?php endif; ?>
