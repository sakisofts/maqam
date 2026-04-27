<?php

namespace app\widgets;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class RecordDetailView extends Widget
{
    /**
     * @var array The records to be displayed
     */
    public $records = [];

    /**
     * @var string The title for the records section
     */
    public $title = 'Records';

    /**
     * @var array The fields to display for each record
     */
    public $displayFields = [];

    /**
     * @var array Custom labels for fields
     */
    public $fieldLabels = [];

    /**
     * @var string CSS class for each record item
     */
    public $itemCssClass = 'record-card';

    /**
     * @var bool Whether to show field labels
     */
    public $showLabels = true;

    /**
     * @var string CSS class for the container
     */
    public $containerCssClass = 'record-detail-view';

    /**
     * @var string Layout type: 'cards', 'panels', or 'list'
     */
    public $layout = 'cards';

    /**
     * @var int Number of columns for card layout (1-4)
     */
    public $columns = 3;

    /**
     * @var callable Custom field formatter
     * Example: function($field, $value, $record) { return $formatted; }
     */
    public $fieldFormatter;

    /**
     * @var array Custom actions for each record
     * Example: [
     *    'view' => function($record) { return Html::a('View', ['view', 'id' => $record->id]); },
     *    'edit' => function($record) { return Html::a('Edit', ['update', 'id' => $record->id]); }
     * ]
     */
    public $actions = [];

    /**
     * @var string|bool The key field used for record identification or false to disable
     */
    public $keyField = 'id';

    /**
     * @var bool Whether to show print button
     */
    public $showPrintButton = true;

    /**
     * @var bool Whether to enable expandable/collapsible details
     */
    public $expandableDetails = false;

    /**
     * @var array Fields to show in the card header (summary)
     */
    public $summaryFields = [];

    /**
     * @var string Icon for the cards (Bootstrap icon class without the 'bi-' prefix)
     */
    public $cardIcon = 'file-text';

    /**
     * @var array Custom CSS classes for specific fields
     */
    public $fieldClasses = [];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (empty($this->displayFields)) {
            // If no display fields are specified, use all fields from the first record
            if (!empty($this->records)) {
                $firstRecord = is_array($this->records) ? reset($this->records) : $this->records;
                $this->displayFields = is_object($firstRecord) ? array_keys(get_object_vars($firstRecord)) : array_keys($firstRecord);
            }
        }

        // If summary fields not set, use first field or id as default
        if (empty($this->summaryFields) && !empty($this->displayFields)) {
            $this->summaryFields = [$this->displayFields[0]];
        }

        // Validate columns
        $this->columns = max(1, min(4, (int)$this->columns));
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (empty($this->records)) {
            return Html::tag('div', 'No records found.', ['class' => 'alert alert-info']);
        }

        $this->registerAssets();

        $content = Html::beginTag('div', ['class' => $this->containerCssClass . ' mb-4']);

        // Add title and print button if enabled
        if (!empty($this->title)) {
            $titleContent = Html::tag('h3', $this->title, ['class' => 'record-title']);

            // Add print button if enabled
            if ($this->showPrintButton) {
                $printButton = Html::button(
                    '<i class="bi bi-printer"></i> Print',
                    [
                        'class' => 'btn btn-outline-primary float-end print-button',
                        'onclick' => 'printRecordsSection(this)',
                    ]
                );
                $titleContent .= $printButton;
            }

            $content .= Html::tag('div', $titleContent, ['class' => 'record-header-container mb-3 d-flex justify-content-between align-items-center']);
        }

        // Add records container based on layout
        $content .= Html::beginTag('div', ['class' => 'records-container']);

        switch ($this->layout) {
            case 'panels':
                $content .= $this->renderPanelLayout();
                break;
            case 'list':
                $content .= $this->renderListLayout();
                break;
            case 'cards':
            default:
                $content .= $this->renderCardLayout();
                break;
        }

        $content .= Html::endTag('div'); // close records-container
        $content .= Html::endTag('div'); // close container

        return $content;
    }

    /**
     * Renders records in a card layout
     *
     * @return string The HTML content
     */
    protected function renderCardLayout()
    {
        $colClass = 'col-md-' . (12 / $this->columns);
        $content = Html::beginTag('div', ['class' => 'row g-4']);

        foreach ($this->records as $index => $record) {
            $recordKey = $this->keyField ? $this->getRecordValue($record, $this->keyField) : $index;

            $cardContent = '';

            // Card header with primary info and icon
            $headerContent = '';

            // Add icon if specified
            if ($this->cardIcon) {
                $headerContent .= Html::tag('div', '<i class="bi bi-' . $this->cardIcon . ' me-2"></i>', ['class' => 'card-icon']);
            }

            // Add summary field(s) to header
            foreach ($this->summaryFields as $field) {
                $value = $this->getRecordValue($record, $field);
                $label = ArrayHelper::getValue($this->fieldLabels, $field, $this->formatFieldLabel($field));

                if ($this->fieldFormatter instanceof \Closure) {
                    $formattedValue = call_user_func($this->fieldFormatter, $field, $value, $record);
                } else {
                    $formattedValue = $this->formatFieldValue($value);
                }

                $headerContent .= Html::tag('span', $formattedValue, ['class' => 'card-title-text', 'data-field' => $field]);
            }

            // Add card body with remaining fields
            $bodyContent = Html::beginTag('div', ['class' => 'card-body']);

            // Add details list
            $bodyContent .= Html::beginTag('dl', ['class' => 'row mb-0']);

            foreach ($this->displayFields as $field) {
                // Skip fields already shown in summary
                if (in_array($field, $this->summaryFields)) {
                    continue;
                }

                $value = $this->getRecordValue($record, $field);
                $label = ArrayHelper::getValue($this->fieldLabels, $field, $this->formatFieldLabel($field));

                // Apply custom formatter if provided
                if ($this->fieldFormatter instanceof \Closure) {
                    $formattedValue = call_user_func($this->fieldFormatter, $field, $value, $record);
                } else {
                    $formattedValue = $this->formatFieldValue($value);
                }

                $fieldClass = ArrayHelper::getValue($this->fieldClasses, $field, '');

                if ($this->showLabels) {
                    $bodyContent .= Html::tag('dt', $label, ['class' => 'col-sm-4 ' . $fieldClass]);
                    $bodyContent .= Html::tag('dd', $formattedValue, ['class' => 'col-sm-8 ' . $fieldClass, 'data-field' => $field]);
                } else {
                    $bodyContent .= Html::tag('dd', $formattedValue, ['class' => 'col-12 ' . $fieldClass, 'data-field' => $field]);
                }
            }

            $bodyContent .= Html::endTag('dl');

            // Add actions if any
            if (!empty($this->actions)) {
                $actionsContent = Html::beginTag('div', ['class' => 'card-actions mt-3']);

                foreach ($this->actions as $actionName => $actionCallback) {
                    if ($actionCallback instanceof \Closure) {
                        $actionsContent .= call_user_func($actionCallback, $record);
                    }
                }

                $actionsContent .= Html::endTag('div');
                $bodyContent .= $actionsContent;
            }

            $bodyContent .= Html::endTag('div'); // close card-body

            // Combine header and body into card
            $cardContent .= Html::tag('div', $headerContent, ['class' => 'card-header d-flex align-items-center']);
            $cardContent .= $bodyContent;

            $cardOptions = [
                'class' => $this->itemCssClass,
                'data-key' => $recordKey,
            ];

            $card = Html::tag('div', $cardContent, $cardOptions);
            $content .= Html::tag('div', $card, ['class' => $colClass]);
        }

        $content .= Html::endTag('div'); // close row

        return $content;
    }

    /**
     * Renders records in a panel layout (accordion)
     *
     * @return string The HTML content
     */
    protected function renderPanelLayout()
    {
        $accordionId = $this->id . '-accordion';
        $content = Html::beginTag('div', ['class' => 'accordion', 'id' => $accordionId]);

        foreach ($this->records as $index => $record) {
            $recordKey = $this->keyField ? $this->getRecordValue($record, $this->keyField) : $index;
            $itemId = $accordionId . '-item-' . $recordKey;
            $headerId = $itemId . '-header';
            $collapseId = $itemId . '-collapse';

            // Panel header with summary fields
            $headerContent = '';
            foreach ($this->summaryFields as $field) {
                $value = $this->getRecordValue($record, $field);

                if ($this->fieldFormatter instanceof \Closure) {
                    $formattedValue = call_user_func($this->fieldFormatter, $field, $value, $record);
                } else {
                    $formattedValue = $this->formatFieldValue($value);
                }

                $headerContent .= $formattedValue . ' ';
            }

            // Panel body with all fields
            $bodyContent = Html::beginTag('dl', ['class' => 'row mb-0']);

            foreach ($this->displayFields as $field) {
                $value = $this->getRecordValue($record, $field);
                $label = ArrayHelper::getValue($this->fieldLabels, $field, $this->formatFieldLabel($field));

                // Apply custom formatter if provided
                if ($this->fieldFormatter instanceof \Closure) {
                    $formattedValue = call_user_func($this->fieldFormatter, $field, $value, $record);
                } else {
                    $formattedValue = $this->formatFieldValue($value);
                }

                $fieldClass = ArrayHelper::getValue($this->fieldClasses, $field, '');

                if ($this->showLabels) {
                    $bodyContent .= Html::tag('dt', $label, ['class' => 'col-sm-3 ' . $fieldClass]);
                    $bodyContent .= Html::tag('dd', $formattedValue, ['class' => 'col-sm-9 ' . $fieldClass, 'data-field' => $field]);
                } else {
                    $bodyContent .= Html::tag('dd', $formattedValue, ['class' => 'col-12 ' . $fieldClass, 'data-field' => $field]);
                }
            }

            $bodyContent .= Html::endTag('dl');

            // Add actions if any
            if (!empty($this->actions)) {
                $actionsContent = Html::beginTag('div', ['class' => 'panel-actions mt-3']);

                foreach ($this->actions as $actionName => $actionCallback) {
                    if ($actionCallback instanceof \Closure) {
                        $actionsContent .= call_user_func($actionCallback, $record);
                    }
                }

                $actionsContent .= Html::endTag('div');
                $bodyContent .= $actionsContent;
            }

            // Create accordion item
            $accordionHeader = Html::button(
                $headerContent,
                [
                    'class' => 'accordion-button ' . ($index === 0 ? '' : 'collapsed'),
                    'type' => 'button',
                    'data-bs-toggle' => 'collapse',
                    'data-bs-target' => '#' . $collapseId,
                    'aria-expanded' => ($index === 0 ? 'true' : 'false'),
                    'aria-controls' => $collapseId,
                ]
            );

            $header = Html::tag('h2', $accordionHeader, [
                'class' => 'accordion-header',
                'id' => $headerId,
            ]);

            $body = Html::tag('div',
                Html::tag('div', $bodyContent, ['class' => 'accordion-body']),
                [
                    'id' => $collapseId,
                    'class' => 'accordion-collapse collapse ' . ($index === 0 ? 'show' : ''),
                    'aria-labelledby' => $headerId,
                    'data-bs-parent' => '#' . $accordionId,
                ]
            );

            $content .= Html::tag('div', $header . $body, [
                'class' => 'accordion-item ' . $this->itemCssClass,
                'data-key' => $recordKey,
            ]);
        }

        $content .= Html::endTag('div'); // close accordion

        return $content;
    }

    /**
     * Renders records in a list layout
     *
     * @return string The HTML content
     */
    protected function renderListLayout()
    {
        $content = Html::beginTag('div', ['class' => 'list-group']);

        foreach ($this->records as $index => $record) {
            $recordKey = $this->keyField ? $this->getRecordValue($record, $this->keyField) : $index;

            // Create list item content
            $itemHeader = '';

            // Add summary fields to header
            foreach ($this->summaryFields as $field) {
                $value = $this->getRecordValue($record, $field);

                if ($this->fieldFormatter instanceof \Closure) {
                    $formattedValue = call_user_func($this->fieldFormatter, $field, $value, $record);
                } else {
                    $formattedValue = $this->formatFieldValue($value);
                }

                $itemHeader .= Html::tag('h5', $formattedValue, ['class' => 'mb-1 list-item-title']);
            }

            // Add details
            $itemBody = Html::beginTag('div', ['class' => 'row mt-2']);

            foreach ($this->displayFields as $field) {
                // Skip fields already shown in summary
                if (in_array($field, $this->summaryFields)) {
                    continue;
                }

                $value = $this->getRecordValue($record, $field);
                $label = ArrayHelper::getValue($this->fieldLabels, $field, $this->formatFieldLabel($field));

                // Apply custom formatter if provided
                if ($this->fieldFormatter instanceof \Closure) {
                    $formattedValue = call_user_func($this->fieldFormatter, $field, $value, $record);
                } else {
                    $formattedValue = $this->formatFieldValue($value);
                }

                $fieldClass = ArrayHelper::getValue($this->fieldClasses, $field, '');

                if ($this->showLabels) {
                    $itemBody .= Html::beginTag('div', ['class' => 'col-md-6 mb-2']);
                    $itemBody .= Html::tag('small', $label . ': ', ['class' => 'text-muted ' . $fieldClass]);
                    $itemBody .= Html::tag('span', $formattedValue, ['class' => $fieldClass, 'data-field' => $field]);
                    $itemBody .= Html::endTag('div');
                } else {
                    $itemBody .= Html::beginTag('div', ['class' => 'col-md-6 mb-2']);
                    $itemBody .= Html::tag('span', $formattedValue, ['class' => $fieldClass, 'data-field' => $field]);
                    $itemBody .= Html::endTag('div');
                }
            }

            $itemBody .= Html::endTag('div');

            // Add actions if any
            if (!empty($this->actions)) {
                $actionsContent = Html::beginTag('div', ['class' => 'list-actions mt-2']);

                foreach ($this->actions as $actionName => $actionCallback) {
                    if ($actionCallback instanceof \Closure) {
                        $actionsContent .= call_user_func($actionCallback, $record);
                    }
                }

                $actionsContent .= Html::endTag('div');
                $itemBody .= $actionsContent;
            }

            // Combine all content
            $itemContent = $itemHeader . $itemBody;

            $content .= Html::tag('div', $itemContent, [
                'class' => 'list-group-item ' . $this->itemCssClass,
                'data-key' => $recordKey,
            ]);
        }

        $content .= Html::endTag('div'); // close list-group

        return $content;
    }

    /**
     * Gets a value from a record (supports both arrays and objects)
     *
     * @param mixed $record The record (array or object)
     * @param string $field The field name
     * @return mixed The field value
     */
    protected function getRecordValue($record, $field)
    {
        if (is_object($record)) {
            return $record->$field ?? null;
        }

        return $record[$field] ?? null;
    }

    /**
     * Formats the field label by converting camelCase or underscore_names to readable text
     *
     * @param string $field The field name
     * @return string The formatted label
     */
    protected function formatFieldLabel($field)
    {
        // Convert camelCase to spaces
        $label = preg_replace('/(?<!^)[A-Z]/', ' $0', $field);

        // Convert underscores to spaces
        $label = str_replace('_', ' ', $label);

        return ucfirst($label);
    }

    /**
     * Formats field value
     *
     * @param mixed $value The field value
     * @return string The formatted value
     */
    protected function formatFieldValue($value)
    {
        if ($value === null) {
            return '<span class="text-muted">(not set)</span>';
        }

        if (is_bool($value)) {
            return $value ?
                '<span class="badge bg-success">Yes</span>' :
                '<span class="badge bg-danger">No</span>';
        }

        if (is_array($value)) {
            return Html::encode(json_encode($value));
        }

        return Html::encode($value);
    }

    /**
     * Register required CSS and JS assets
     */
    protected function registerAssets()
    {
        $view = $this->getView();

        // Register print functionality
        $js = <<<JS
function printRecordsSection(button) {
    const sectionToPrint = $(button).closest('.record-detail-view');
    
    // Create a new window for printing
    const printWindow = window.open('', '_blank', 'height=600,width=800');
    
    // Get the Bootstrap CSS
    const bootstrapCss = '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
    
    // Get the Bootstrap Icons CSS 
    const bootstrapIcons = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">';
    
    // Custom print styles
    const printStyles = `
        <style>
            body { padding: 20px; font-family: Arial, sans-serif; }
            .print-button { display: none; }
            .card { page-break-inside: avoid; margin-bottom: 15px; border: 1px solid #ddd; }
            .accordion-button::after { display: none; }
            .card-header { background-color: #f8f9fa !important; padding: 10px 15px; border-bottom: 1px solid #ddd; }
            .card-body { padding: 15px; }
            dt { font-weight: bold; }
            @media print {
                .row { display: flex; flex-wrap: wrap; }
                .col-md-4 { width: 33.333%; }
                .col-md-6 { width: 50%; }
                .col-sm-3 { width: 25%; }
                .col-sm-9 { width: 75%; }
            }
        </style>
    `;
    
    // Clone the section and modify it for printing
    const content = sectionToPrint.clone();
    content.find('.print-button').hide();
    
    // Construct the HTML for the print window
    const html = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>{content.find('.record-title').text()}</title>
            {bootstrapCss}
            {bootstrapIcons}
            {printStyles}
        </head>
        <body>
            {content.html()}
            <script>
                window.onload = function() {
                    window.print();
                    setTimeout(function() {
                        window.close();
                    }, 500);
                };
            </script>
        </body>
        </html>
    `;
    
    // Write to the new window and trigger print
    printWindow.document.open();
    printWindow.document.write(html);
    printWindow.document.close();
}

// Initialize expandable details functionality if needed
document.addEventListener('DOMContentLoaded', function() {
    // Add any initialization needed for expandable sections
    const expandButtons = document.querySelectorAll('.expand-details-btn');
    expandButtons.forEach(button => {
        button.addEventListener('click', function() {
            const detailsSection = this.closest('.record-card').querySelector('.record-details');
            if (detailsSection) {
                detailsSection.classList.toggle('show');
                this.querySelector('i').classList.toggle('bi-chevron-down');
                this.querySelector('i').classList.toggle('bi-chevron-up');
            }
        });
    });
});
JS;

        $view->registerJs($js, \yii\web\View::POS_END);

        // Register CSS for Bootstrap 5 styling
        $css = <<<CSS
.record-detail-view {
    margin-bottom: 2rem;
}
.record-title {
    margin-bottom: 0;
}
.record-card {
    height: 100%;
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
    border: 1px solid rgba(0,0,0,.125);
    border-radius: .25rem;
    transition: all 0.3s ease;
    overflow: hidden;
}
.record-card:hover {
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
    transform: translateY(-3px);
}
.card-header {
    background-color: #f8f9fa;
    font-weight: 500;
    display: flex;
    align-items: center;
}
.card-icon {
    font-size: 1.25rem;
    color: #6c757d;
}
.card-title-text {
    font-size: 1.1rem;
}
.card-actions .btn, .panel-actions .btn, .list-actions .btn {
    margin-right: 5px;
}
.list-group-item {
    border-left: 0;
    border-right: 0;
    padding: 1rem 1.25rem;
}
.list-group-item:first-child {
    border-top: 0;
}
.list-group-item:last-child {
    border-bottom: 0;
}
.accordion-button:not(.collapsed) {
    background-color: #f8f9fa;
    color: #212529;
    box-shadow: none;
}
.accordion-button:focus {
    box-shadow: none;
    border-color: rgba(0,0,0,.125);
}
dl.row {
    margin-bottom: 0;
}
dt {
    color: #6c757d;
    font-weight: 500;
}
.record-details {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out;
}
.record-details.show {
    max-height: 1000px;
    transition: max-height 0.5s ease-in;
}
CSS;

        $view->registerCss($css);
    }
}

/**
 * RecordDetailView displays detailed information about a set of records using modern Bootstrap 5 styling.
 *
 * Basic Usage:
 * <?= RecordDetailView::widget([
 *     'records' => $records,
 *     'title' => 'Customer Records',
 *     'layout' => 'cards', // 'cards', 'panels', or 'list'
 *     'columns' => 3, // Number of columns in card layout (1-4)
 *     'displayFields' => ['id', 'name', 'email', 'phone', 'address'],
 *     'summaryFields' => ['name'], // Fields to show in card/panel header
 *     'fieldLabels' => [
 *         'id' => 'ID',
 *         'name' => 'Full Name',
 *         'email' => 'Email Address',
 *     ],
 *     'cardIcon' => 'person', // Bootstrap icon name
 *     'showPrintButton' => true,
 * ]) ?>
 *
 * Advanced usage:
 *
 * <?= \app\widgets\RecordDetailView::widget([
 *     'records' => $orders,
 *     'title' => 'Order Details',
 *     'layout' => 'panels',
 *     'summaryFields' => ['id', 'customer_name'],
 *     'displayFields' => ['id', 'customer_name', 'total', 'status', 'created_at', 'notes'],
 *     'cardIcon' => 'cart',
 *     'fieldClasses' => [
 *         'status' => 'fw-bold',
 *         'total' => 'fw-bold',
 *     ],
 *     'fieldFormatter' => function($field, $value, $record) {
 *         if ($field === 'total') {
 *             return '$' . number_format($value, 2);
 *         } elseif ($field === 'status') {
 *             $statusClasses = [
 *                 'pending' => 'bg-warning',
 *                 'completed' => 'bg-success',
 *                 'cancelled' => 'bg-danger',
 *             ];
 *             $class = $statusClasses[$value] ?? 'bg-secondary';
 *             return "<span class='badge $class'>" . ucfirst($value) . "</span>";
 *         }
 *         return $value;
 *     },
 *     'actions' => [
 *         'view' => function($record) {
 *             return Html::a('<i class="bi bi-eye"></i> Details', ['order/view', 'id' => $record['id']],
 *                 ['class' => 'btn btn-sm btn-outline-info']);
 *         },
 *         'update' => function($record) {
 *             return Html::a('<i class="bi bi-pencil"></i> Edit', ['order/update', 'id' => $record['id']],
 *                 ['class' => 'btn btn-sm btn-outline-primary']);
 *         }
 *     ],
 * ]) ?>
 */
