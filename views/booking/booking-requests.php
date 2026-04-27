<?php

use app\components\Generics\CurrencyHelper;
use yii\helpers\Url;

/**
 * @var $data array
 */

$bookings = $data['bookings'];
$payments = $data['payments'];
$client = $data['client'];
$this->title = 'Booking Details - '.Yii::$app->name;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <!-- Bootstrap 5 CSS -->
    <!-- Font Awesome -->
<!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">-->

    <style>
        .payment-status-received {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-weight: 500;
        }

        .payment-status-pending {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-weight: 500;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<div class="container-fluid py-4">
    <!-- Booking Details Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-secondary text-primary d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0">Booking #<?= $bookings['id'] ?></h5>
            <a class="btn btn-light btn-sm"  href="<?=Url::to(['/payments/pay','ref'=>uniqid('PMQB')])?>">
                <i class="fas fa-plus-circle me-1"></i> Add Payment
            </a>
<!--            <a class="btn btn-light btn-sm"  href="--><?php //=Url::to(['booking/add-payment','id'=>$bookings['id']])?><!--">-->
<!--                <i class="fas fa-plus-circle me-1"></i> Add Payment-->
<!--            </a>-->
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs mb-4" id="bookingDetailsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="client-tab" data-bs-toggle="tab" data-bs-target="#client-info" type="button" role="tab" aria-selected="true">
                        Client Information
                    </button>
                </li>
            </ul>
            <!-- Tab content -->
            <div class="tab-content">
                <!-- Client Information Tab -->
                <div class="tab-pane fade show active" id="client-info" role="tabpanel" aria-labelledby="client-tab">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class=" h-100">
                                <div class="">
                                    <h6 class="card-subtitle mb-3 text-muted">Personal Information</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Full Name:</div>
                                        <div class="col-md-8 fw-medium"><?= $client['name'] ?? '(not set)' ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Mobile:</div>
                                        <div class="col-md-8"><?= $client['phone'] !=='NUll' ? $client['phone'] : '(not set)' ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Email:</div>
                                        <div class="col-md-8"><?= $client['email'] !=='NULL' ? $client['email'] :  '(not set)' ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Gender:</div>
                                        <div class="col-md-8"><?= $client['gender']  !=='NULL' ? $client['gender'] : '(not set)' ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Nationality:</div>
                                        <div class="col-md-8"><?= $client['nationality'] !=='NULL' ?$client['nationality']: '(not set)' ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Residence:</div>
                                        <div class="col-md-8"><?= $client['residence']  !=='NULL' ? $client['residence'] : '(not set)' ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">NIN / Passport:</div>
                                        <div class="col-md-8"><?= $client['NIN_or_Passport'] !=='NULL' ? $client['NIN_or_Passport'] : '(not set)' ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Payment History Section (Moved out of tabs) -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Payment History</h5>
            <div>
                <button class="btn btn-sm btn-outline-secondary me-2">
                    <i class="fas fa-file-excel me-1"></i> Export
                </button>
                <button class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-print me-1"></i> Print
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-4">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Paid</th>
                        <th>Currency</th>
                        <th>Rate</th>
                        <th>Actual (USD)</th>
                        <th>Mode</th>
                        <th>Date</th>
                        <th>Amount Due</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($payments as $key=>$payment): ?>
                        <tr>
                            <td><?= $key+1 ?></td>
                            <td><?= number_format($payment['amount']) ?></td>
                            <td><?= $payment['currency'] ? $payment['currency'] : 'UGX' ?></td>
                            <td><?= CurrencyHelper::getExchangeRate('UGX','USD') ?></td>
                            <td>$<?= CurrencyHelper::convert($payment['amount'],'UGX','USD') ?></td>
                            <td><?= $payment['paymentOption'] ? $payment['paymentOption'] : ($bookings['paymentOption'] ? $bookings['paymentOption'] : 'Cash') ?></td>
                            <td><?= date('M j, Y', strtotime($payment['created_at'])) ?></td>
                            <td>$<?= CurrencyHelper::convert($payment['actual_amount'],'UGX','USD') ?></td>
                            <td>$<?= $payment['actual_amount'] > 0 ? CurrencyHelper::convert($payment['actual_amount'] - $payment['amount'],'UGX','USD') : 0 ?></td>

                            <td>
                                <?php if ($payment['payment_status'] == 'Received'): ?>
                                    <span class="payment-status-received">Received</span>
                                <?php else: ?>
                                    <span class="payment-status-pending">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <?php if (!$payment['payment_status']): ?>
                                        <button class="btn btn-success btn-sm action-btn" title="Approve Payment">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    <?php endif; ?>
                                    <button class="btn btn-primary btn-sm action-btn" title="View Receipt">
                                        <i class="fas fa-receipt"></i>
                                    </button>
                                    <a href="<?=Url::to(['export/receipt','id'=>$payment['id']])?>" class="btn btn-secondary btn-sm action-btn" title="Print Receipt">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>

<!-- Add Payment Modal -->
<div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPaymentModalLabel">Add New Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="paymentAmount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="paymentAmount" required>
                    </div>
                    <div class="mb-3">
                        <label for="paymentCurrency" class="form-label">Currency</label>
                        <select class="form-select" id="paymentCurrency">
                            <option value="UGX" selected>UGX</option>
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Payment Method</label>
                        <select class="form-select" id="paymentMethod">
                            <option value="CASH" selected>Cash</option>
                            <option value="BANK_TRANSFER">Bank Transfer</option>
                            <option value="MOBILE_MONEY">Mobile Money</option>
                            <option value="CREDIT_CARD">Credit Card</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="paymentNotes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" id="paymentNotes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Save Payment</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
