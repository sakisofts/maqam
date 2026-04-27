<?php

namespace app\widgets;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\View;


class ThermalReceiptView extends Widget
{
    /**
     * @var array Business details to display in the receipt header
     */
    public $businessDetails = [
        'name' => '',
        'address' => '',
        'phone' => '',
        'email' => '',
        'taxId' => '',
        'logo' => false, // Path to logo file or false to disable
    ];

    /**
     * @var array Receipt information
     */
    public $receiptInfo = [
        'receiptNumber' => '',
        'date' => '',
        'servedBy' => '',
        'customer' => '',
    ];

    /**
     * @var array Items purchased or services rendered
     */
    public $items = [];

    /**
     * @var array Receipt totals
     */
    public $totals = [
        'subtotal' => 0,
        'tax' => 0,
        'discount' => 0,
        'total' => 0,
    ];

    /**
     * @var bool Whether to show tax information
     */
    public $showTax = true;

    /**
     * @var string Custom tax information text
     */
    public $taxInfo = '';

    /**
     * @var string Footer text
     */
    public $footerText = 'Thank you for your business!';

    /**
     * @var string|bool Credit for who designed the receipt
     */
    public $designedBy = false;

    /**
     * @var bool Whether to automatically trigger printing
     */
    public $autoPrint = false;

    /**
     * @var string Currency symbol
     */
    public $currencySymbol = '';

    /**
     * @var string Date format
     */
    public $dateFormat = 'Y-m-d H:i';

    /**
     * @var bool Whether to show item prices
     */
    public $showPrices = true;

    /**
     * @var bool Whether to show receipt copy text
     */
    public $isCopy = false;

    /**
     * @var string Width of the receipt in mm (80mm standard)
     */
    public $paperWidth = 80;

    /**
     * @var string Template ID for printing functionality
     */
    public $printTemplateId = 'thermal-receipt';

    /**
     * @var string Button label for print trigger
     */
    public $printButtonLabel = 'Print Receipt';

    /**
     * @var string Additional CSS classes for the receipt container
     */
    public $cssClass = '';

    /**
     * @var array Options for number formatting
     */
    public $numberFormat = [
        'decimal_places' => 2,
        'decimal_separator' => '.',
        'thousand_separator' => ',',
    ];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // Set current date if not provided
        if (empty($this->receiptInfo['date'])) {
            $this->receiptInfo['date'] = date($this->dateFormat);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->registerAssets();
        return $this->renderReceipt();
    }

    /**
     * Registers required assets
     */
    protected function registerAssets()
    {
        $view = $this->getView();

        // Register the print CSS
        $css = $this->getReceiptCss();
        $view->registerCss($css);

        // Register the print JavaScript
        if ($this->autoPrint) {
            $js = "window.onload = function() { printThermalReceipt('{$this->printTemplateId}'); };";
            $view->registerJs($js, View::POS_END);
        }

        // Register the print function
        $printJs = <<<JS
function printThermalReceipt(elementId) {
    var printContent = document.getElementById(elementId);
    var printWindow = window.open('', '_blank', 'height=600,width=800');
    
    printWindow.document.write('<html><head><title>Print Receipt</title>');
    printWindow.document.write('<style>');
    printWindow.document.write(`
        body { 
            font-family: 'Courier New', monospace; 
            font-size: 12px;
            width: {$this->paperWidth}mm;
            margin: 0;
            padding: 0;
        }
        .receipt-container {
            width: 100%;
            padding: 0;
        }
        .receipt-header, .receipt-footer {
            text-align: center;
            margin-bottom: 5px;
        }
        .receipt-title {
            font-size: 14px;
            font-weight: bold;
            margin: 5px 0;
        }
        .receipt-info {
            margin: 5px 0;
        }
        .receipt-info div {
            margin: 2px 0;
        }
        .receipt-table {
            width: 100%;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            margin: 5px 0;
            padding: 5px 0;
        }
        .receipt-table th {
            text-align: left;
        }
        .receipt-table td.amount {
            text-align: right;
        }
        .receipt-total {
            margin: 5px 0;
            text-align: right;
        }
        .receipt-total div {
            margin: 2px 0;
        }
        .receipt-footer {
            margin-top: 10px;
            font-size: 11px;
        }
        .copy-text {
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            margin: 5px 0;
        }
        .designed-by {
            font-size: 10px;
            text-align: center;
            margin-top: 10px;
        }
        @media print {
            body { 
                width: {$this->paperWidth}mm;
            }
            .no-print {
                display: none;
            }
        }
    `);
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write(printContent.innerHTML);
    printWindow.document.write('</body></html>');
    
    printWindow.document.close();
    printWindow.focus();
    
    // Slight delay to ensure content is loaded
    setTimeout(function() {
        printWindow.print();
        printWindow.close();
    }, 250);
}
JS;
        $view->registerJs($printJs, View::POS_END);
    }

    /**
     * Get receipt-specific CSS
     *
     * @return string CSS styles
     */
    protected function getReceiptCss()
    {
        return <<<CSS
        .thermal-receipt {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            width: {$this->paperWidth}mm;
            margin: 0 auto;
            padding: 5px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .receipt-container {
            width: 100%;
            padding: 0;
        }
        .receipt-header, .receipt-footer {
            text-align: center;
            margin-bottom: 5px;
        }
        .receipt-title {
            font-size: 14px;
            font-weight: bold;
            margin: 5px 0;
        }
        .receipt-info {
            margin: 5px 0;
        }
        .receipt-info div {
            margin: 2px 0;
        }
        .receipt-table {
            width: 100%;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            margin: 5px 0;
            padding: 5px 0;
        }
        .receipt-table th {
            text-align: left;
        }
        .receipt-table td.amount {
            text-align: right;
        }
        .receipt-total {
            margin: 5px 0;
            text-align: right;
        }
        .receipt-total div {
            margin: 2px 0;
        }
        .receipt-footer {
            margin-top: 10px;
            font-size: 11px;
        }
        .copy-text {
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            margin: 5px 0;
        }
        .designed-by {
            font-size: 10px;
            text-align: center;
            margin-top: 10px;
        }
        .thermal-print-button {
            display: block;
            width: 100%;
            max-width: {$this->paperWidth}mm;
            margin: 10px auto;
            padding: 10px;
            background: #4CAF50;
            color: white;
            text-align: center;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        @media print {
            .thermal-print-button, .no-print {
                display: none !important;
            }
            .thermal-receipt {
                box-shadow: none;
                width: 100%;
            }
        }
CSS;
    }

    /**
     * Renders the complete receipt
     *
     * @return string HTML content
     */
    protected function renderReceipt()
    {
        $html = Html::beginTag('div', ['class' => 'thermal-receipt ' . $this->cssClass]);

        // Print button
        $html .= Html::button($this->printButtonLabel, [
            'class' => 'thermal-print-button no-print',
            'onclick' => "printThermalReceipt('{$this->printTemplateId}')",
        ]);

        $html .= Html::beginTag('div', ['id' => $this->printTemplateId, 'class' => 'receipt-container']);

        // Receipt header with business details
        $html .= $this->renderBusinessHeader();

        // Copy indicator if needed
        if ($this->isCopy) {
            $html .= Html::tag('div', 'COPY', ['class' => 'copy-text']);
        }

        // Receipt info
        $html .= $this->renderReceiptInfo();

        // Items table
        $html .= $this->renderItemsTable();

        // Totals
        $html .= $this->renderTotals();

        // Footer
        $html .= $this->renderFooter();

        $html .= Html::endTag('div'); // close receipt-container
        $html .= Html::endTag('div'); // close thermal-receipt

        return $html;
    }

    /**
     * Renders the business header section
     *
     * @return string HTML content
     */
    protected function renderBusinessHeader()
    {
        $html = Html::beginTag('div', ['class' => 'receipt-header']);

        // Business logo
        if ($this->businessDetails['logo']) {
            $html .= Html::img($this->businessDetails['logo'], [
                'alt' => $this->businessDetails['name'],
                'class' => 'receipt-logo',
                'style' => 'max-width: 100%; max-height: 50px; margin-bottom: 5px;',
            ]);
        }

        // Business name
        if (!empty($this->businessDetails['name'])) {
            $html .= Html::tag('div', Html::encode($this->businessDetails['name']), ['class' => 'receipt-title']);
        }

        // Business address
        if (!empty($this->businessDetails['address'])) {
            $html .= Html::tag('div', Html::encode($this->businessDetails['address']));
        }

        // Business phone
        if (!empty($this->businessDetails['phone'])) {
            $html .= Html::tag('div', 'Tel: ' . Html::encode($this->businessDetails['phone']));
        }

        // Business email
        if (!empty($this->businessDetails['email'])) {
            $html .= Html::tag('div', 'Email: ' . Html::encode($this->businessDetails['email']));
        }

        // Tax ID if provided
        if (!empty($this->businessDetails['taxId'])) {
            $html .= Html::tag('div', 'Tax ID: ' . Html::encode($this->businessDetails['taxId']));
        }

        $html .= Html::endTag('div'); // close receipt-header

        return $html;
    }

    /**
     * Renders receipt information section
     *
     * @return string HTML content
     */
    protected function renderReceiptInfo()
    {
        $html = Html::beginTag('div', ['class' => 'receipt-info']);

        // Receipt number
        if (!empty($this->receiptInfo['receiptNumber'])) {
            $html .= Html::tag('div', 'Receipt #: ' . Html::encode($this->receiptInfo['receiptNumber']));
        }

        // Date and time
        if (!empty($this->receiptInfo['date'])) {
            if (is_numeric($this->receiptInfo['date']) || strtotime($this->receiptInfo['date'])) {
                $date = is_numeric($this->receiptInfo['date'])
                    ? date($this->dateFormat, $this->receiptInfo['date'])
                    : date($this->dateFormat, strtotime($this->receiptInfo['date']));
                $html .= Html::tag('div', 'Date: ' . $date);
            } else {
                $html .= Html::tag('div', 'Date: ' . Html::encode($this->receiptInfo['date']));
            }
        }

        // Served by
        if (!empty($this->receiptInfo['servedBy'])) {
            $html .= Html::tag('div', 'Served by: ' . Html::encode($this->receiptInfo['servedBy']));
        }

        // Customer
        if (!empty($this->receiptInfo['customer'])) {
            $html .= Html::tag('div', 'Customer: ' . Html::encode($this->receiptInfo['customer']));
        }

        $html .= Html::endTag('div'); // close receipt-info

        return $html;
    }

    /**
     * Renders the items table
     *
     * @return string HTML content
     */
    protected function renderItemsTable()
    {
        if (empty($this->items)) {
            return '';
        }

        $html = Html::beginTag('div', ['class' => 'receipt-table']);
        $html .= Html::beginTag('table', ['style' => 'width: 100%; border-collapse: collapse;']);

        // Table header
        $html .= Html::beginTag('thead');
        $html .= Html::beginTag('tr');
        $html .= Html::tag('th', 'Item', ['style' => 'text-align: left;']);
        $html .= Html::tag('th', 'Qty', ['style' => 'text-align: center;']);

        if ($this->showPrices) {
            $html .= Html::tag('th', 'Price', ['style' => 'text-align: right;']);
            $html .= Html::tag('th', 'Total', ['style' => 'text-align: right;']);
        }

        $html .= Html::endTag('tr');
        $html .= Html::endTag('thead');

        // Table body
        $html .= Html::beginTag('tbody');

        foreach ($this->items as $item) {
            $html .= Html::beginTag('tr');

            // Item name
            $html .= Html::tag('td', Html::encode($item['name']), ['style' => 'text-align: left;']);

            // Quantity
            $html .= Html::tag('td', Html::encode($item['qty']), ['style' => 'text-align: center;']);

            if ($this->showPrices) {
                // Price
                $price = $this->formatCurrency($item['price']);
                $html .= Html::tag('td', $price, ['class' => 'amount']);

                // Total
                $total = $this->formatCurrency($item['total']);
                $html .= Html::tag('td', $total, ['class' => 'amount']);
            }

            $html .= Html::endTag('tr');
        }

        $html .= Html::endTag('tbody');
        $html .= Html::endTag('table');
        $html .= Html::endTag('div'); // close receipt-table

        return $html;
    }

    /**
     * Renders the totals section
     *
     * @return string HTML content
     */
    protected function renderTotals()
    {
        $html = Html::beginTag('div', ['class' => 'receipt-total']);

        // Subtotal
        if (isset($this->totals['subtotal'])) {
            $subtotal = $this->formatCurrency($this->totals['subtotal']);
            $html .= Html::tag('div', 'Subtotal: ' . $subtotal);
        }

        // Discount if any
        if (isset($this->totals['discount']) && $this->totals['discount'] > 0) {
            $discount = $this->formatCurrency($this->totals['discount']);
            $html .= Html::tag('div', 'Discount: ' . $discount);
        }

        // Tax information if enabled
        if ($this->showTax && isset($this->totals['tax']) && $this->totals['tax'] > 0) {
            if (!empty($this->taxInfo)) {
                $html .= Html::tag('div', $this->taxInfo);
            } else {
                $tax = $this->formatCurrency($this->totals['tax']);
                $html .= Html::tag('div', 'Tax: ' . $tax);
            }
        }

        // Total
        if (isset($this->totals['total'])) {
            $total = $this->formatCurrency($this->totals['total']);
            $html .= Html::tag('div', Html::tag('strong', 'Total: ' . $total));
        }

        $html .= Html::endTag('div'); // close receipt-total

        return $html;
    }

    /**
     * Renders the footer section
     *
     * @return string HTML content
     */
    protected function renderFooter()
    {
        $html = Html::beginTag('div', ['class' => 'receipt-footer']);

        // Footer text
        if (!empty($this->footerText)) {
            $html .= Html::tag('div', Html::encode($this->footerText));
        }

        // Designed by credit if enabled
        if ($this->designedBy) {
            $html .= Html::tag('div', 'Designed by: ' . Html::encode($this->designedBy), ['class' => 'designed-by']);
        }

        $html .= Html::endTag('div'); // close receipt-footer

        return $html;
    }

    /**
     * Formats currency values
     *
     * @param mixed $amount Amount to format
     * @return string Formatted currency amount
     */
    protected function formatCurrency($amount)
    {
        $formattedAmount = number_format(
            $amount,
            $this->numberFormat['decimal_places'],
            $this->numberFormat['decimal_separator'],
            $this->numberFormat['thousand_separator']
        );

        return $this->currencySymbol . $formattedAmount;
    }
}

/**
 * ThermalReceiptView generates a printable receipt for thermal printers (80mm)
 * with configurable options for business details, items, tax, etc.
 *
 * Usage:
 * <?= ThermalReceiptView::widget([
 *     'businessDetails' => [
 *         'name' => 'My Business',
 *         'address' => '123 Main St, City',
 *         'phone' => '+123 456 7890',
 *         'email' => 'info@business.com',
 *         'taxId' => 'TAX-123456',
 *     ],
 *     'receiptInfo' => [
 *         'receiptNumber' => 'INV-001',
 *         'date' => '2025-04-19 14:30',
 *         'servedBy' => 'John Doe',
 *         'customer' => 'Jane Smith',
 *     ],
 *     'items' => [
 *         [
 *             'name' => 'Product 1',
 *             'qty' => 2,
 *             'price' => 1500,
 *             'total' => 3000,
 *         ],
 *         [
 *             'name' => 'Service Fee',
 *             'qty' => 1,
 *             'price' => 500,
 *             'total' => 500,
 *         ],
 *     ],
 *     'totals' => [
 *         'subtotal' => 3500,
 *         'tax' => 350,
 *         'total' => 3850,
 *     ],
 *     'showTax' => true,
 *     'taxInfo' => 'Tax (10%): 350',
 *     'footerText' => 'Thank you for your business!',
 *     'designedBy' => 'XYZ Solutions',
 *     'autoPrint' => true,
 * ]) ?>
 *
 *
 * controller setting
 * public function actionReceipt($id)
 * {
 * $order = Order::findOne($id);
 * $items = [];
 *
 * foreach ($order->items as $item) {
 * $items[] = [
 * 'name' => $item->product->name,
 * 'qty' => $item->quantity,
 * 'price' => $item->unit_price,
 * 'total' => $item->total_price,
 * ];
 * }
 *
 * return $this->render('receipt', [
 * 'order' => $order,
 * 'items' => $items,
 * ]);
 * }
 *
 *
 * view
 * <?= \app\components\ThermalReceiptView::widget([
 * 'businessDetails' => [
 * 'name' => Yii::$app->params['businessName'],
 * 'address' => Yii::$app->params['businessAddress'],
 * 'phone' => Yii::$app->params['businessPhone'],
 * 'taxId' => Yii::$app->params['businessTaxId'],
 * ],
 * 'receiptInfo' => [
 * 'receiptNumber' => $order->reference,
 * 'date' => $order->created_at,
 * 'servedBy' => $order->staff->name,
 * 'customer' => $order->customer->name,
 * ],
 * 'items' => $items,
 * 'totals' => [
 * 'subtotal' => $order->subtotal,
 * 'tax' => $order->tax_amount,
 * 'total' => $order->total_amount,
 * ],
 * ]) ?>
 *
 *
 *
 */
