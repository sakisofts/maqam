<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Dashboard';

/*
  * Install Chart.js extension for Yii2:
  * composer require 2amigos/yii2-chartjs-widget
 * @var $chartData array
  */

/**
 * @var $this yii\web\View
 * @var $chartData array
 * @var $user array
 * @var $bookingData array
 *
 */

use dosamigos\chartjs\ChartJs;

?>

<div class="dashboard-container py-4">
    <!-- Header -->
    <div class="container-fluid mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0 text-primary fw-bold">Dashboard</h1>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-primary hover-shadow">
                        <i class="fas fa-sync-alt me-1"></i> Refresh
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle hover-shadow" type="button"
                                id="reportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-download me-1"></i> Export
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="reportDropdown">
                            <li><a class="dropdown-item" href="#"><i class="far fa-file-pdf me-2"></i>PDF Report</a>
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="far fa-file-excel me-2"></i>Excel Export</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Print Dashboard</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Stats Cards -->
    <div class="container-fluid mb-4">
        <div class="row g-4">
            <!-- Users Card -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-circle bg-primary-subtle text-primary me-3 pulse">
                                <i class="fas fa-users"></i>
                            </div>
                            <h6 class="card-title mb-0 text-uppercase fw-bold text-secondary">Users</h6>
                            <span class="ms-auto badge bg-primary-subtle text-primary">Today</span>
                        </div>
                        <h2 class="display-6 fw-bold mb-0 counter" title="Total Users"><?=$user['total_users']?></h2>
                        <div class="d-flex align-items-center mt-3">
                            <span class="text-success"><i class="fas fa-arrow-up me-1"></i> <?=$user['percent_change'] > 0 ? $user['percent_change'] .'%': $user['percent_change'] ?></span>
                            <span class="text-muted ms-2">from yesterday</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bookings Card -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-circle bg-success-subtle text-success me-3 pulse">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <h6 class="card-title mb-0 text-uppercase fw-bold text-secondary">Bookings</h6>
                            <span class="ms-auto badge bg-success-subtle text-success">Today</span>
                        </div>
                        <h2 class="display-6 fw-bold mb-0 counter">84</h2>
                        <div class="d-flex align-items-center mt-3">
                            <span class="text-success"><i class="fas fa-arrow-up me-1"></i> 8%</span>
                            <span class="text-muted ms-2">from yesterday</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Adverts Card -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-circle bg-info-subtle text-info me-3 pulse">
                                <i class="fas fa-ad"></i>
                            </div>
                            <h6 class="card-title mb-0 text-uppercase fw-bold text-secondary">Adverts</h6>
                            <span class="ms-auto badge bg-info-subtle text-info">Today</span>
                        </div>
                        <h2 class="display-6 fw-bold mb-0 counter">2</h2>
                        <div class="d-flex align-items-center mt-3">
                            <span class="text-danger"><i class="fas fa-arrow-down me-1"></i> 5%</span>
                            <span class="text-muted ms-2">from yesterday</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Packages Card -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-circle bg-warning-subtle text-warning me-3 pulse">
                                <i class="fas fa-box"></i>
                            </div>
                            <h6 class="card-title mb-0 text-uppercase fw-bold text-secondary">Packages</h6>
                            <span class="ms-auto badge bg-warning-subtle text-warning">Today</span>
                        </div>
                        <h2 class="display-6 fw-bold mb-0 counter">3</h2>
                        <div class="d-flex align-items-center mt-3">
                            <span class="text-success"><i class="fas fa-arrow-up me-1"></i> 2%</span>
                            <span class="text-muted ms-2">from yesterday</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics and Additional Info -->
    <div class="container-fluid">
        <div class="row g-4">
            <!-- Booking Analytics -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm hover-lift" style="height: 520px;">
                    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Booking Analytics</h5>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-primary active hover-shadow"
                                    data-period="weekly">Weekly
                            </button>
                            <button type="button" class="btn btn-outline-primary hover-shadow" data-period="monthly">
                                Monthly
                            </button>
                            <button type="button" class="btn btn-outline-primary hover-shadow" data-period="yearly">
                                Yearly
                            </button>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div style="flex: 1; min-height: 0;">
                            <?php echo ChartJs::widget([
                                'type' => 'line',
                                'options' => [
                                    'responsive' => true,
                                    'maintainAspectRatio' => false,
                                    'height' => '100%'
                                ],
                                'clientOptions' => [
                                    'title' => [
                                        'display' => true,
                                        'text' => 'Booking Analytics'
                                    ],
                                    'tooltips' => [
                                        'mode' => 'index',
                                        'intersect' => false,
                                    ],
                                    'hover' => [
                                        'mode' => 'nearest',
                                        'intersect' => true
                                    ],
                                    'scales' => [
                                        'xAxes' => [[
                                            'display' => true,
                                            'scaleLabel' => [
                                                'display' => true,
                                            ],
                                            'gridLines' => [
                                                'drawBorder' => false,
                                            ],
                                        ]],
                                        'yAxes' => [[
                                            'display' => true,
                                            'scaleLabel' => [
                                                'display' => true,
                                            ],
                                            'ticks' => [
                                                'beginAtZero' => true,
                                            ],
                                            'gridLines' => [
                                                'drawBorder' => false,
                                            ],
                                        ]],
                                    ],
                                ],
                                'data' => [
                                    'labels' => $labels,
                                    'datasets' => [
                                        [
                                            'label' => 'Bookings',
                                            'backgroundColor' => 'rgba(75, 87, 255, 0.3)',
                                            'borderColor' => 'rgba(75, 87, 255, 1)',
                                            'pointBackgroundColor' => 'rgba(75, 87, 255, 1)',
                                            'pointBorderColor' => '#fff',
                                            'pointHoverBackgroundColor' => '#fff',
                                            'pointHoverBorderColor' => 'rgba(75, 87, 255, 1)',
                                            'data' => $bookingsData,
                                            'fill' => true,
                                            'lineTension' => 0.4, // This gives you the smooth curve effect
                                        ],
                                    ]
                                ],
                            ]) ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Maqam Experience -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4 hover-lift">
                    <div class="card-header bg-transparent border-0">
                        <h5 class="mb-0 fw-bold">Maqam Experiences</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-danger-subtle text-danger me-3 pulse">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Active Experiences</h6>
                                    <small class="text-muted">Today</small>
                                </div>
                            </div>
                            <h3 class="mb-0 counter">2</h3>
                        </div>
                        <div class="progress mb-4" style="height: 8px; border-radius: 4px;">
                            <div class="progress-bar bg-danger progress-bar-animated" role="progressbar"
                                 style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-sm btn-outline-primary hover-shadow">
                                <i class="fas fa-plus me-1"></i> Add Experience
                            </button>
                            <a href="<?= Url::to(['/experience/index']) ?>" class="text-decoration-none hover-primary">View
                                All</a>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="card border-0 shadow-sm hover-lift">
                    <div class="card-header bg-transparent border-0">
                        <h5 class="mb-0 fw-bold">Recent Activities</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item border-0 px-3 py-3 hover-bg-light">
                                <div class="d-flex">
                                    <div class="activity-icon bg-primary-subtle text-primary me-3 pulse">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-medium">New user registered</p>
                                        <small class="text-muted">5 minutes ago</small>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-3 py-3 hover-bg-light">
                                <div class="d-flex">
                                    <div class="activity-icon bg-success-subtle text-success me-3 pulse">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-medium">New booking confirmed</p>
                                        <small class="text-muted">15 minutes ago</small>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-3 py-3 hover-bg-light">
                                <div class="d-flex">
                                    <div class="activity-icon bg-warning-subtle text-warning me-3 pulse">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-medium">Package update needed</p>
                                        <small class="text-muted">1 hour ago</small>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="text-center py-3 text-muted">
                    <small>© Copyright <?= date('Y') ?> <span class="fw-bold">MAQAM TRAVELS</span>. All Rights Reserved</small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa;
    }

    .icon-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .activity-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .bg-primary-subtle {
        background-color: rgba(13, 110, 253, 0.15);
    }

    .bg-success-subtle {
        background-color: rgba(25, 135, 84, 0.15);
    }

    .bg-info-subtle {
        background-color: rgba(13, 202, 240, 0.15);
    }

    .bg-warning-subtle {
        background-color: rgba(255, 193, 7, 0.15);
    }

    .bg-danger-subtle {
        background-color: rgba(220, 53, 69, 0.15);
    }

    .hover-lift {
        transition: transform 0.2s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
    }

    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .hover-bg-light:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .hover-primary:hover {
        color: #0d6efd !important;
    }

    .pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
        }
    }

    .counter {
        opacity: 0;
        animation: countUp 1s ease forwards;
    }

    @keyframes countUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .progress-bar-animated {
        animation: progress 1s ease-in-out;
    }

    @keyframes progress {
        from {
            width: 0;
        }
    }
</style>

<?php
$this->registerJs("
        document.querySelectorAll('[data-period]').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('[data-period]').forEach(btn => {
                    btn.classList.remove('active');
                });
                // Add active class to clicked button
                this.classList.add('active');

                // Here you can add AJAX call to fetch data for different periods
                // and update the chart accordingly
            });
        });
    ");
?>


