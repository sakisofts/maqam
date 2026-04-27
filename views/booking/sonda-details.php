<?php
$bookings = $data['bookings'];
$payments = $data['payments'];
$client = $data['client'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <!-- Bootstrap 5 CSS -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0">Booking #<?= $bookings['id'] ?></h5>
            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                <i class="fas fa-plus-circle me-1"></i> Add Payment
            </button>
        </div>

        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs mb-4" id="bookingDetailsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="client-tab" data-bs-toggle="tab" data-bs-target="#client-info" type="button" role="tab" aria-selected="true">
                        Client Information
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="booking-tab" data-bs-toggle="tab" data-bs-target="#booking-info" type="button" role="tab" aria-selected="false">
                        Booking Details
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="biodata-tab" data-bs-toggle="tab" data-bs-target="#biodata-info" type="button" role="tab" aria-selected="false">
                        Bio Data
                    </button>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content">
                <!-- Client Information Tab -->
                <div class="tab-pane fade show active" id="client-info" role="tabpanel" aria-labelledby="client-tab">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-3 text-muted">Personal Information</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Client ID:</div>
                                        <div class="col-md-8 fw-medium"><?= $client['id'] ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Full Name:</div>
                                        <div class="col-md-8 fw-medium"><?= $client['name'] ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Email:</div>
                                        <div class="col-md-8"><?= $client['email'] ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Phone:</div>
                                        <div class="col-md-8"><?= $client['phone'] ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Gender:</div>
                                        <div class="col-md-8"><?= $client['gender'] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-3 text-muted">Additional Information</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Date of Birth:</div>
                                        <div class="col-md-8"><?= $client['dob'] != 'NULL' ? $client['dob'] : '<span class="text-muted">Not provided</span>' ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Nationality:</div>
                                        <div class="col-md-8"><?= $client['nationality'] != 'NULL' ? $client['nationality'] : '<span class="text-muted">Not provided</span>' ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Residence:</div>
                                        <div class="col-md-8"><?= $client['residence'] != 'NULL' ? $client['residence'] : '<span class="text-muted">Not provided</span>' ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">NIN/Passport:</div>
                                        <div class="col-md-8"><?= $client['NIN_or_Passport'] != 'NULL' ? $client['NIN_or_Passport'] : '<span class="text-muted">Not provided</span>' ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Registered On:</div>
                                        <div class="col-md-8"><?= date('F j, Y', strtotime($client['created_at'])) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Details Tab -->
                <div class="tab-pane fade" id="booking-info" role="tabpanel" aria-labelledby="booking-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-4 col-lg-3">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h6 class="card-subtitle mb-2 text-muted">Booking ID</h6>
                                                    <p class="card-text fw-bold fs-5">#<?= $bookings['id'] ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-lg-3">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h6 class="card-subtitle mb-2 text-muted">Package ID</h6>
                                                    <p class="card-text fw-bold fs-5">#<?= $bookings['packageId'] ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-lg-3">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h6 class="card-subtitle mb-2 text-muted">Payment Option</h6>
                                                    <p class="card-text fw-bold fs-5"><?= $bookings['paymentOption'] ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-lg-3">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h6 class="card-subtitle mb-2 text-muted">Booking Type</h6>
                                                    <p class="card-text fw-bold fs-5"><?= $bookings['bookingType'] ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-lg-3">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h6 class="card-subtitle mb-2 text-muted">Created Date</h6>
                                                    <p class="card-text"><?= date('F j, Y', strtotime($bookings['created_at'])) ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-lg-3">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h6 class="card-subtitle mb-2 text-muted">Last Updated</h6>
                                                    <p class="card-text"><?= date('F j, Y', strtotime($bookings['updated_at'])) ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-lg-3">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h6 class="card-subtitle mb-2 text-muted">Travel Document</h6>
                                                    <p class="card-text"><?= $bookings['travelDocument'] ? $bookings['travelDocument'] : '<span class="text-muted">Not provided</span>' ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-lg-3">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h6 class="card-subtitle mb-2 text-muted">User ID</h6>
                                                    <p class="card-text">#<?= $bookings['userId'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bio Data Tab (New tab replacing Payment History) -->
                <div class="tab-pane fade" id="biodata-info" role="tabpanel" aria-labelledby="biodata-tab">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-3 text-muted"><i class="fas fa-user-circle me-2"></i>Personal Bio</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Full Name:</div>
                                        <div class="col-md-8 fw-medium"><?= $client['name'] ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Age:</div>
                                        <div class="col-md-8">
                                            <?php
                                            if ($client['dob'] != 'NULL') {
                                                $birthDate = new DateTime($client['dob']);
                                                $currentDate = new DateTime();
                                                $age = $currentDate->diff($birthDate)->y;
                                                echo $age . ' years';
                                            } else {
                                                echo '<span class="text-muted">Not available</span>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Occupation:</div>
                                        <div class="col-md-8"><span class="text-muted">Not provided</span></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Blood Type:</div>
                                        <div class="col-md-8"><span class="text-muted">Not provided</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-3 text-muted"><i class="fas fa-briefcase-medical me-2"></i>Medical Information</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Medical Conditions:</div>
                                        <div class="col-md-8"><span class="text-muted">Not provided</span></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Allergies:</div>
                                        <div class="col-md-8"><span class="text-muted">Not provided</span></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Medications:</div>
                                        <div class="col-md-8"><span class="text-muted">Not provided</span></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Emergency Contact:</div>
                                        <div class="col-md-8"><span class="text-muted">Not provided</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-3 text-muted"><i class="fas fa-passport me-2"></i>Travel Information</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Passport Number:</div>
                                        <div class="col-md-8"><?= $client['NIN_or_Passport'] != 'NULL' ? $client['NIN_or_Passport'] : '<span class="text-muted">Not provided</span>' ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Issue Date:</div>
                                        <div class="col-md-8"><span class="text-muted">Not provided</span></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Expiry Date:</div>
                                        <div class="col-md-8"><span class="text-muted">Not provided</span></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Previous Travels:</div>
                                        <div class="col-md-8"><span class="text-muted">Not provided</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-3 text-muted"><i class="fas fa-info-circle me-2"></i>Additional Information</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Special Requirements:</div>
                                        <div class="col-md-8"><span class="text-muted">Not provided</span></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Dietary Preferences:</div>
                                        <div class="col-md-8"><span class="text-muted">Not provided</span></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Language:</div>
                                        <div class="col-md-8"><span class="text-muted">Not provided</span></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Notes:</div>
                                        <div class="col-md-8"><span class="text-muted">Not provided</span></div>
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
                        <th>ID</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Currency</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($payments as $payment): ?>
                        <tr>
                            <td>#<?= $payment['id'] ?></td>
                            <td><?= date('M j, Y', strtotime($payment['created_at'])) ?></td>
                            <td><?= number_format($payment['amount']) ?></td>
                            <td><?= $payment['currency'] ? $payment['currency'] : 'UGX' ?></td>
                            <td><?= $payment['paymentOption'] ? $payment['paymentOption'] : ($bookings['paymentOption'] ? $bookings['paymentOption'] : 'Cash') ?></td>
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
                                    <button class="btn btn-secondary btn-sm action-btn" title="Print Receipt">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Payment Summary -->
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted"><i class="fas fa-calculator me-2"></i>Total Payments</h6>
                            <h2 class="card-title"><?= count($payments) ?></h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted"><i class="fas fa-coins me-2"></i>Total Amount</h6>
                            <h2 class="card-title text-success">
                                <?php
                                $totalAmount = 0;
                                foreach ($payments as $payment) {
                                    $totalAmount += (int)$payment['amount'];
                                }
                                echo number_format($totalAmount);
                                ?>
                                <small class="fs-6 fw-normal"><?= $payments[0]['currency'] ? $payments[0]['currency'] : 'UGX' ?></small>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted"><i class="fas fa-check-circle me-2"></i>Approved</h6>
                            <h2 class="card-title">
                                <?php
                                $approvedCount = 0;
                                foreach ($payments as $payment) {
                                    if ($payment['payment_status'] == 'Received') {
                                        $approvedCount++;
                                    }
                                }
                                echo $approvedCount;
                                ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted"><i class="fas fa-clock me-2"></i>Pending</h6>
                            <h2 class="card-title text-warning">
                                <?php
                                $pendingCount = 0;
                                foreach ($payments as $payment) {
                                    if ($payment['payment_status'] != 'Received') {
                                        $pendingCount++;
                                    }
                                }
                                echo $pendingCount;
                                ?>
                            </h2>
                        </div>
                    </div>
                </div>
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

<!-- Bootstrap 5 JS with Popper -->
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>-->
</body>
</html>
