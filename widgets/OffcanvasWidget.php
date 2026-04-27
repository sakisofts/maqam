<?php
namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\View;


class OffcanvasWidget extends Widget
{
    /**
     * Offcanvas placement options
     */
    const PLACEMENT_START = 'start';
    const PLACEMENT_END = 'end';
    const PLACEMENT_TOP = 'top';
    const PLACEMENT_BOTTOM = 'bottom';

    /**
     * Unique identifier for the offcanvas
     */
    public $id;

    /**
     * Predefined size class for the offcanvas
     */
    public $size = 'offcanvas-size-xxl';

    /**
     * Force the offcanvas to be at least half of the viewport width
     */
    public $halfWidth = false;

    /**
     * Custom width percentage (50-100)
     */
    public $widthPercentage = null;

    /**
     * Title of the offcanvas
     */
    public $title = '';

    /**
     * Content of the offcanvas
     */
    public $content = '';

    /**
     * Placement of the offcanvas
     */
    public $placement = self::PLACEMENT_END;

    /**
     * Additional HTML options for the offcanvas
     */
    public $options = [];

    /**
     * Button/Trigger options
     */
    public $buttonOptions = [];

    /**
     * External trigger button ID
     */
    public $triggerId;

    /**
     * Scroll behavior
     */
    public $scroll = false;

    /**
     * Backdrop behavior
     */
    public $backdrop = true;

    public $renderButton = false;

    /**
     * Custom header content
     */
    public $header;

    /**
     * Custom footer content
     */
    public $footer;

    /**
     * Initialization method
     */
    public function init()
    {
        parent::init();

        // Generate a unique ID if not provided
        if (empty($this->id)) {
            $this->id = 'offcanvas-' . uniqid();
        }

        // Default button options
        $defaultButtonOptions = [
            'class' => 'btn btn-primary',
            'data-bs-toggle' => 'offcanvas',
            'data-bs-target' => "#{$this->id}",
            'aria-controls' => $this->id,
        ];
        $this->buttonOptions = ArrayHelper::merge($defaultButtonOptions, $this->buttonOptions);

        // Register external trigger script if needed
        $this->registerExternalTriggerScript();

        // Register custom CSS for width if needed
        if ($this->halfWidth || $this->widthPercentage !== null) {
            $this->registerCustomWidthStyles();
        }
    }

    /**
     * Register JavaScript to handle external trigger
     */
    protected function registerExternalTriggerScript()
    {
        if (!empty($this->triggerId)) {
            $view = $this->getView();
            $view->registerJs("
                (function() {
                    var triggerEl = document.getElementById('{$this->triggerId}');
                    var offcanvasEl = document.getElementById('{$this->id}');
                    
                    if (triggerEl && offcanvasEl) {
                        triggerEl.addEventListener('click', function() {
                            var offcanvas = new bootstrap.Offcanvas(offcanvasEl);
                            offcanvas.show();
                        });
                    }
                })();
            ", View::POS_READY);
        }
    }

    /**
     * Register custom CSS for width control
     */
    protected function registerCustomWidthStyles()
    {
        $view = $this->getView();
        $width = $this->widthPercentage !== null ?
            max(min($this->widthPercentage, 100), 30) : // Ensure percentage is between 50-100
            30; // Default to 50% if halfWidth is true without specific percentage

        // Custom CSS for horizontal placements only (start/end)
        if (in_array($this->placement, [self::PLACEMENT_START, self::PLACEMENT_END])) {
            $view->registerCss("
                #{$this->id} {
                    width: {$width}% !important;
                    max-width: {$width}% !important;
                }
            ");
        }
    }

    /**
     * Runs the widget
     */
    public function run()
    {
        // Render the button trigger if enabled
        $button = $this->renderButton ? $this->renderButton() : '';

        // Render the offcanvas
        $offcanvas = $this->renderOffcanvas();

        return $button . $offcanvas;
    }

    /**
     * Renders the button trigger
     */
    protected function renderButton()
    {
        $label = ArrayHelper::remove($this->buttonOptions, 'label', 'Open Offcanvas');
        return Html::button($label, $this->buttonOptions);
    }

    /**
     * Renders the offcanvas
     */
    protected function renderOffcanvas()
    {
        // Prepare offcanvas options
        $defaultOptions = [
            'class' => "offcanvas offcanvas-{$this->placement} {$this->size}",
            'tabindex' => '-1',
            'id' => $this->id,
            'aria-labelledby' => "{$this->id}-label",
        ];

        // Add custom width class if needed
        if ($this->halfWidth || $this->widthPercentage !== null) {
            $defaultOptions['class'] .= ' custom-width-offcanvas';
        }

        // Merge with user-provided options
        $options = ArrayHelper::merge($defaultOptions, $this->options);

        // Add data attributes for scroll and backdrop
        $options['data-bs-scroll'] = $this->scroll ? 'true' : 'false';
        $options['data-bs-backdrop'] = $this->backdrop ? 'true' : 'false';

        // Start offcanvas
        $html = Html::beginTag('div', $options);

        // Offcanvas header
        $html .= $this->renderOffcanvasHeader();

        // Offcanvas body
        $html .= Html::beginTag('div', ['class' => 'offcanvas-body']);
        $html .= $this->content;
        $html .= Html::endTag('div');

        if (!empty($this->footer)) {
            $html .= Html::beginTag('div', ['class' => 'offcanvas-footer']);
            $html .= $this->footer;
            $html .= Html::endTag('div');
        }
        $html .= Html::endTag('div');

        return $html;
    }

    /**
     * Renders the offcanvas header
     */
    protected function renderOffcanvasHeader()
    {
        $html = Html::beginTag('div', ['class' => 'offcanvas-header']);

        // Custom or default header
        if (!empty($this->header)) {
            $html .= $this->header;
        } else {
            // Default header with title and close button
            $html .= Html::tag('h5', $this->title, [
                'class' => 'offcanvas-title',
                'id' => "{$this->id}-label"
            ]);

            $html .= Html::button('', [
                'class' => 'btn-close',
                'data-bs-dismiss' => 'offcanvas',
                'aria-label' => 'Close'
            ]);
        }

        $html .= Html::endTag('div');

        return $html;
    }

    /**
     * Validates placement option
     */
    public function validatePlacement($placement)
    {
        $validPlacements = [
            self::PLACEMENT_START,
            self::PLACEMENT_END,
            self::PLACEMENT_TOP,
            self::PLACEMENT_BOTTOM
        ];

        return in_array($placement, $validPlacements)
            ? $placement
            : self::PLACEMENT_END;
    }
}

/**
 * usage example
 */

//echo Html::button('External Trigger', ['id' => 'externalTrigger', 'class' => 'btn btn-info']);
//echo OffcanvasWidget::widget([
//    'id' => 'externalOffcanvas',
//    'title' => 'sakisofts',
//    'content' => 'This offcanvas is triggered by an external button.',
//    'triggerId' => 'externalTrigger',
//    'widthPercentage' => 50,
//]);
