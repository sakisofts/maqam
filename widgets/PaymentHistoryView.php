<?php

namespace app\widgets;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


class PaymentHistoryView extends Widget
{
    /**
     * @var array Account information to display in the header
     */
    public $accountInfo = [];

    /**
     * @var array Payment records to display in the table
     */
    public $payments = [];

    /**
     * @var array Fields to display for account information
     */
    public $accountFields = ['name', 'reference', 'issued_by', 'target', 'balance'];

    /**
     * @var array Labels for account information fields
     */
    public $accountLabels = [];

    /**
     * @var array Fields to display for payment records
     */
    public $paymentFields = ['paid', 'mode', 'created', 'target', 'balance', 'issued_by', 'actions'];

    /**
     * @var array Labels for payment fields
     */
    public $paymentLabels = [];

    /**
     * @var string Navigation menu items for account section
     */
    public $navItems = [
        'account' => 'Account',
        'applicant' => 'Applicant Details',
        'bio' => 'Bio Data',
    ];

    /**
     * @var string Active navigation item
     */
    public $activeNavItem = 'account';

    /**
     * @var callable Custom field formatter for account info
     */
    public $accountFieldFormatter;

    /**
     * @var callable Custom field formatter for payment records
     */
    public $paymentFieldFormatter;

    /**
     * @var array Available statuses for booking status dropdown
     */
    public $bookingStatuses = ['Pending', 'Completed', 'Cancelled'];

    /**
     * @var string Selected booking status
     */
    public $selectedBookingStatus = 'Pending';

    /**
     * @var array Available statuses for payment status dropdown
     */
    public $paymentStatuses = ['On going', 'Completed', 'Failed'];

    /**
     * @var string Selected payment status
     */
    public $selectedPaymentStatus = 'On going';

    /**
     * @var array Custom actions for payment records
     */
    public $paymentActions = [];

    /**
     * @var string URL for Add Payment button action
     */
    public $addPaymentUrl = ['payment/create'];

    /**
     * @var string URL for Update button action
     */
    public $updateAccountUrl = ['account/update'];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // Set default account labels if not provided
        if (empty($this->accountLabels)) {
            $this->accountLabels = [
                'name' => 'Name',
                'reference' => 'Reference',
                'issued_by' => 'Issued by',
                'target' => 'Target',
                'balance' => 'Balance',
            ];
        }

        // Set default payment labels if not provided
        if (empty($this->paymentLabels)) {
            $this->paymentLabels = [
                'paid' => 'Paid (UGX)',
                'mode' => 'Mode',
                'created' => 'Created',
                'target' => 'Target',
                'balance' => 'Balance (UGX)',
                'issued_by' => 'Issued by',
                'actions' => 'Actions',
            ];
        }

        // Set default payment actions if not provided
        if (empty($this->paymentActions)) {
            $this->paymentActions = [
                'approve' => function($payment) {
                    return Html::tag('span', '', [
                        'class' => 'payment-action approve-action',
                        'title' => 'Approve',
                        'data-id' => $payment['id'] ?? '',
                        'style' => 'background-color: #f44336; border-radius: 50%; width: 24px; height: 24px; display: inline-block; text-align: center; margin-right: 5px;',
                    ]);
                },
                'print' => function($payment) {
                    return Html::tag('span', '', [
                        'class' => 'payment-action print-action',
                        'title' => 'Print',
                        'data-id' => $payment['id'] ?? '',
                        'style' => 'background-color: #2196F3; border-radius: 50%; width: 24px; height: 24px; display: inline-block; text-align: center;',
                    ]);
                },
            ];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->renderAccountInfo() . $this->renderPaymentHistory();
    }

    /**
     * Renders the account information section
     *
     * @return string HTML content
     */
    protected function renderAccountInfo()
    {
        $html = Html::beginTag('div', ['class' => 'account-info-container', 'style' => 'background-color: #f5f5f5; border-radius: 5px; padding: 20px; margin-bottom: 20px;']);

        // Navigation tabs
        $html .= Html::beginTag('div', ['class' => 'nav-tabs', 'style' => 'margin-bottom: 20px;']);

        foreach ($this->navItems as $id => $label) {
            $isActive = ($id === $this->activeNavItem);
            $btnClass = $isActive ? 'btn-primary' : 'btn-default';
            $style = 'margin-right: 5px; border-radius: 5px;';

            $html .= Html::a($label, 'javascript:void(0);', [
                'class' => "btn $btnClass",
                'style' => $style,
                'data-toggle' => 'tab',
                'data-target' => "#$id",
            ]);
        }

        $html .= Html::endTag('div');

        // Account info table
        $html .= Html::beginTag('div', ['class' => 'account-details', 'style' => 'display: grid; grid-template-columns: 120px 1fr; gap: 10px;']);

        foreach ($this->accountFields as $field) {
            if (isset($this->accountInfo[$field]) || array_key_exists($field, $this->accountInfo)) {
                $label = ArrayHelper::getValue($this->accountLabels, $field, $this->formatLabel($field));
                $value = $this->formatAccountFieldValue($field, $this->accountInfo[$field] ?? null);

                $html .= Html::tag('div', $label, ['style' => 'font-weight: bold;']);
                $html .= Html::tag('div', $value);
            }
        }

        $html .= Html::endTag('div');

        // Update button
        $html .= Html::beginTag('div', ['style' => 'margin-top: 15px;']);
        $html .= Html::a('Update', $this->updateAccountUrl, [
            'class' => 'btn btn-primary',
            'style' => 'border-radius: 5px; padding: 5px 15px;'
        ]);
        $html .= Html::endTag('div');

        $html .= Html::endTag('div');

        return $html;
    }

    /**
     * Renders the payment history section
     *
     * @return string HTML content
     */
    protected function renderPaymentHistory()
    {
        $html = Html::beginTag('div', ['class' => 'payment-history-container', 'style' => 'background-color: #f5f5f5; border-radius: 5px; padding: 20px;']);

        // Section title
        $html .= Html::tag('h2', 'Payment History', ['style' => 'margin-top: 0; margin-bottom: 20px; font-size: 24px;']);

        // Filter controls
        $html .= Html::beginTag('div', ['class' => 'filter-controls', 'style' => 'display: flex; justify-content: space-between; margin-bottom: 15px; align-items: center;']);

        // Status filters
        $html .= Html::beginTag('div', ['class' => 'status-filters', 'style' => 'display: flex; gap: 15px;']);

        // Booking Status dropdown
        $html .= Html::beginTag('div', ['style' => 'display: flex; align-items: center;']);
        $html .= Html::label('Booking Status', null, ['style' => 'margin-right: 10px;']);
        $html .= Html::dropDownList('booking_status', $this->selectedBookingStatus, array_combine($this->bookingStatuses, $this->bookingStatuses), [
            'class' => 'form-control',
            'style' => 'border-radius: 5px;'
        ]);
        $html .= Html::endTag('div');

        // Payment Status dropdown
        $html .= Html::beginTag('div', ['style' => 'display: flex; align-items: center;']);
        $html .= Html::label('Payment Status', null, ['style' => 'margin-right: 10px;']);
        $html .= Html::dropDownList('payment_status', $this->selectedPaymentStatus, array_combine($this->paymentStatuses, $this->paymentStatuses), [
            'class' => 'form-control',
            'style' => 'border-radius: 5px;'
        ]);
        $html .= Html::endTag('div');

        $html .= Html::endTag('div');

        // Add Payment button
        $html .= Html::a('Add Payment', $this->addPaymentUrl, [
            'class' => 'btn btn-danger',
            'style' => 'background-color: #f44336; border-color: #f44336; border-radius: 5px; padding: 6px 15px;'
        ]);

        $html .= Html::endTag('div');

        // Payment table
        $html .= Html::beginTag('table', ['class' => 'table payment-table', 'style' => 'width: 100%; border-collapse: collapse;']);

        // Table header
        $html .= Html::beginTag('thead');
        $html .= Html::beginTag('tr', ['style' => 'background-color: #f0f0f0;']);

        foreach ($this->paymentFields as $field) {
            $label = ArrayHelper::getValue($this->paymentLabels, $field, $this->formatLabel($field));
            $html .= Html::tag('th', $label, ['style' => 'padding: 10px; text-align: left;']);
        }

        $html .= Html::endTag('tr');
        $html .= Html::endTag('thead');

        // Table body
        $html .= Html::beginTag('tbody');

        if (empty($this->payments)) {
            $colCount = count($this->paymentFields);
            $html .= Html::beginTag('tr');
            $html .= Html::tag('td', 'No payment records found.', ['colspan' => $colCount, 'style' => 'padding: 10px; text-align: center;']);
            $html .= Html::endTag('tr');
        } else {
            $rowIndex = 0;
            foreach ($this->payments as $payment) {
                $bgColor = ($rowIndex % 2 === 0) ? '#ffffff' : '#f9f9f9';
                $html .= Html::beginTag('tr', ['style' => "background-color: $bgColor;"]);

                foreach ($this->paymentFields as $field) {
                    if ($field === 'actions') {
                        $actionsContent = '';
                        foreach ($this->paymentActions as $actionCallback) {
                            if ($actionCallback instanceof \Closure) {
                                $actionsContent .= call_user_func($actionCallback, $payment);
                            }
                        }
                        $html .= Html::tag('td', $actionsContent, ['style' => 'padding: 10px;']);
                    } else {
                        $value = $this->formatPaymentFieldValue($field, $payment[$field] ?? null, $payment);
                        $html .= Html::tag('td', $value, ['style' => 'padding: 10px;']);
                    }
                }

                $html .= Html::endTag('tr');
                $rowIndex++;
            }
        }

        $html .= Html::endTag('tbody');
        $html .= Html::endTag('table');
        $html .= Html::endTag('div');

        return $html;
    }

    /**
     * Formats field label by converting snake_case or camelCase to readable text
     *
     * @param string $field The field name
     * @return string The formatted label
     */
    protected function formatLabel($field)
    {
        // Convert camelCase to spaces
        $label = preg_replace('/(?<!^)[A-Z]/', ' $0', $field);

        // Convert underscores to spaces
        $label = str_replace('_', ' ', $label);

        return ucfirst($label);
    }

    /**
     * Formats account field value with custom formatter if available
     *
     * @param string $field The field name
     * @param mixed $value The field value
     * @return string The formatted value
     */
    protected function formatAccountFieldValue($field, $value)
    {
        if ($this->accountFieldFormatter instanceof \Closure) {
            return call_user_func($this->accountFieldFormatter, $field, $value, $this->accountInfo);
        }

        if ($value === null) {
            return '<span class="not-set">(not set)</span>';
        }

        if ($field === 'balance') {
            return number_format($value) . ' UGX';
        }

        return Html::encode($value);
    }

    /**
     * Formats payment field value with custom formatter if available
     *
     * @param string $field The field name
     * @param mixed $value The field value
     * @param array $payment The payment record
     * @return string The formatted value
     */
    protected function formatPaymentFieldValue($field, $value, $payment = [])
    {
        if ($this->paymentFieldFormatter instanceof \Closure) {
            return call_user_func($this->paymentFieldFormatter, $field, $value, $payment);
        }

        if ($value === null) {
            return '<span class="not-set">(not set)</span>';
        }

        if ($field === 'paid' || $field === 'balance') {
            return number_format($value);
        }

        return Html::encode($value);
    }
}

/**
 * PaymentHistoryView displays account information and payment history table
 * similar to the provided design.
 *
 * Usage:
 * <?= PaymentHistoryView::widget([
 *     'accountInfo' => $accountInfo,
 *     'payments' => $payments,
 *     'accountFields' => ['name', 'reference', 'issued_by', 'target', 'balance'],
 *     'accountLabels' => [
 *         'name' => 'Name',
 *         'reference' => 'Reference',
 *         'issued_by' => 'Issued by',
 *         'target' => 'Target',
 *         'balance' => 'Balance',
 *     ],
 *     'paymentFields' => ['paid', 'mode', 'created', 'target', 'balance', 'issued_by', 'actions'],
 *     'paymentLabels' => [
 *         'paid' => 'Paid (UGX)',
 *         'mode' => 'Mode',
 *         'created' => 'Created',
 *         'target' => 'Target',
 *         'balance' => 'Balance (UGX)',
 *         'issued_by' => 'Issued by',
 *         'actions' => 'Actions',
 *     ],
 * ]) ?>
 *
 *
 * sample two
 *
 * <?= \app\components\PaymentHistoryView::widget([
 * 'accountInfo' => [
 * 'name' => 'Mafo Shafik',
 * 'reference' => 'SM/UO/001',
 * 'issued_by' => 'Shamim',
 * 'target' => 'Umrah Others - 8,400,000',
 * 'balance' => '450000',
 * ],
 * 'payments' => [
 * [
 * 'id' => 1,
 * 'paid' => 200000,
 * 'mode' => 'MTN Merchant',
 * 'created' => '11/06/2024 23:19',
 * 'target' => 'Other Umrah - 8,400,000',
 * 'balance' => 200000,
 * 'issued_by' => 'Shamim',
 * 'status' => 'approved',
 * ],
 * [
 * 'id' => 2,
 * 'paid' => 250000,
 * 'mode' => 'Cash',
 * 'created' => '23/06/2024 3:47',
 * 'target' => 'Other Umrah - 8,400,000',
 * 'balance' => 450000,
 * 'issued_by' => 'Nasif',
 * 'status' => 'approved',
 * ],
 * [
 * 'id' => 3,
 * 'paid' => 200000,
 * 'mode' => 'MTN Merchant',
 * 'created' => '04/08/2024 20:19',
 * 'target' => 'Other Umrah - 8,400,000',
 * 'balance' => 450000,
 * 'issued_by' => 'Shamim',
 * 'status' => 'rejected',
 * ],
 * ],
 * 'activeNavItem' => 'account',
 * 'selectedBookingStatus' => 'Pending',
 * 'selectedPaymentStatus' => 'On going',
 * 'paymentActions' => [
 * 'approve' => function($payment) {
 * $icon = ($payment['status'] == 'approved') ?
 * '<i class="fa fa-check" style="color: white; line-height: 24px;"></i>' :
 * '<i class="fa fa-times" style="color: white; line-height: 24px;"></i>';
 * $bgColor = ($payment['status'] == 'approved') ? '#4caf50' : '#f44336';
 *
 * return Html::tag('span', $icon, [
 * 'class' => 'payment-action approve-action',
 * 'title' => ($payment['status'] == 'approved') ? 'Approved' : 'Rejected',
 * 'data-id' => $payment['id'],
 * 'style' => "background-color: $bgColor; border-radius: 50%; width: 24px; height: 24px; display: inline-block; text-align: center; margin-right: 5px;",
 * ]);
 * },
 * 'print' => function($payment) {
 * return Html::tag('span', '<i class="fa fa-print" style="color: white; line-height: 24px;"></i>', [
 * 'class' => 'payment-action print-action',
 * 'title' => 'Print',
 * 'data-id' => $payment['id'],
 * 'style' => 'background-color: #2196F3; border-radius: 50%; width: 24px; height: 24px; display: inline-block; text-align: center;',
 * ]);
 * },
 * ],
 * ]) ?>
 *
 *
 */
