<?php
// Example data for the receipt
use app\widgets\Receipt;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var $address array
 * @var $receiptData array
 * @var $type String
 */

// Register CSS using Yii's asset manager
$this->registerCss("
    .min-vh-80 {
        min-height: 88vh;
        max-height: 88vh;
        overflow: hidden;
        overflow-y: auto;
    }

    .site-receipt {
        display: flex;
        flex-direction: column;
    }

    .site-receipt .row {
        flex: 1;
    }

    .receipt-preview-container {
        border: 1px solid #dee2e6;
        display: flex;
        flex-direction: column;
    }

    .receipt-preview-body {
        background-color: #f8f9fa;
        overflow-y: auto;
        flex: 1;
    }

    .card-body {
        display: flex;
        flex-direction: column;
    }

    @media print {
        .col-md-4 {
            display: none;
        }

        .receipt-preview-container {
            border: none;
        }

        .card-header {
            display: none;
        }
    }
");

// Register JS code properly with Yii's registerJs method
$js = <<<JS
    // Update paper size display badge when selection changes
    document.getElementById('paperSizeSelector').addEventListener('change', function () {
        var selectedSize = this.value;
        document.getElementById('paperSizeDisplay').textContent = selectedSize;
    });
    
    // Print receipt button functionality
    document.getElementById('printReceiptBtn').addEventListener('click', function () {
        const printContent = document.getElementById('receipt-preview-body').innerHTML;
        const originalContent = document.body.innerHTML;
        
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
    });
    
    // Logo visibility toggle
    document.getElementById('includeLogoCheckbox').addEventListener('change', function() {
        // Add your logo toggle functionality here
        // This is a placeholder for the actual implementation
    });
    
    // Tagline visibility toggle
    document.getElementById('includeTaglineCheckbox').addEventListener('change', function() {
        // Add your tagline toggle functionality here
        // This is a placeholder for the actual implementation
    });
    
    var paperSizeSelectors = document.querySelectorAll('.paper-size-selector');
    if (paperSizeSelectors.length) {
        paperSizeSelectors.forEach(function(selector) {
            selector.addEventListener('change', function(e) {
                var receiptId = this.getAttribute('data-receipt-id');
                var receipt = document.getElementById(receiptId);
                // Remove existing paper size classes
                receipt.classList.remove('paper-80mm', 'paper-a4', 'paper-letter');
                // Add new paper size class
                receipt.classList.add('paper-' + this.value);
            });
        });
    }
    
JS;
$this->registerJs($js, View::POS_READY);
?>

<div class="site-receipt min-vh-80">
    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

    <div class="row h-100">
        <div class="col-md-4">
            <!-- Receipt Options Panel -->
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Receipt Options</h4>
                </div>
                <div class="card-body">
                    <!-- Paper Size Selection -->
                    <div class="mb-3">
                        <label for="paperSizeSelector" class="form-label fw-bold">Paper Size</label>
                        <select id="paperSizeSelector" data-receipt-id="receiptId"
                                class="form-select paper-size-selector">
                            <option value="a4">A4</option>
                            <option value="80mm">80mm Thermal</option>
                            <option value="letter">Letter</option>
                        </select>
                    </div>

                    <!-- Additional Options -->
                    <div class="mb-3">
                        <label for="includeLogoCheckbox" class="form-label fw-bold">Display Options</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="includeLogoCheckbox" checked>
                            <label class="form-check-label" for="includeLogoCheckbox">
                                Include Logo
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="includeTaglineCheckbox"
                                   checked>
                            <label class="form-check-label" for="includeTaglineCheckbox">
                                Show Tagline
                            </label>
                        </div>
                    </div>
                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 mt-auto">
                        <button id="printReceiptBtn" class="btn btn-success">
                            <i class="bi bi-printer"></i> Print Receipt
                        </button>
                        <a id="downloadReceiptBtn" href="<?=Url::to(['booking/index'])?>" class="btn btn-secondary">
                            <i class="bi bi-download"></i> Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Receipt Preview Panel -->
            <div class="card shadow receipt-preview-container h-100">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Receipt Preview</h4>
                        <span class="badge bg-primary paperSizeSelector" id="paperSizeDisplay">A4</span>
                    </div>
                </div>
                <div class="card-body receipt-preview-body" id="receipt-preview-body">
                    <?= Receipt::widget([
                        'logo' => Url::to(['web/images/receipt.png']),
                        'companyName' => 'Maqam Travels',
//                        'brandName' => $type,
                        'tagline' => 'Travel with Confidence',
                        'brandTagline' => $type == 'SONDA MPOLA' ? 'Save for a Sacred journey' : null,
                        'address' => $address,
                        'receiptTitle' => $type.' RECEIPT',
                        'receiptData' => $receiptData,
                        'paperSize' => 'A4', // Options: '80mm', 'A4', 'Letter', etc.
                        'showPrintButton' => false, // Hide the built-in print button
                        'id' => 'receiptId',
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
