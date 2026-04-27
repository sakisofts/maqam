<?php
namespace app\components\Generics;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\View;
use app\components\Generics\OneTimeFlash;
class FlashAlertWidget extends Widget
{
    //    supported alerts { info, success, error, warning }

    /**
     * Set Duration in milliseconds before the alert fades out
     */
    public $duration = 5000;

    /**
     * Position of the alert (top-center, top-right, top-left)
     */
    public $position = 'top-center';

    /**
     * Whether to show close button
     */
    public $showCloseButton = true;

    /**
     * Bootstrap alert types mapping
     */
    private $alertTypes = [
        'success' => 'alert-success',
        'error' => 'alert-danger',
        'danger' => 'alert-danger',
        'warning' => 'alert-warning',
        'info' => 'alert-info',
    ];

    /**
     * Initializes the widget
     */
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    /**
     * Executes the widget
     * and the rendered content
     */
    public function run()
    {
        $flashMessages = $this->getFlashMessages();
        if (empty($flashMessages)) {
            return '';
        }

        $html = Html::beginTag('div', [
            'class' => 'flash-alert-container position-fixed',
            'style' => $this->getPositionStyles(),
            'id' => 'flashAlertContainer'
        ]);

        foreach ($flashMessages as $type => $message) {
            $html .= $this->renderAlert($type, $message);
        }

        $html .= Html::endTag('div');
        return $html;
    }

    /**
     * Gets all flash messages
     */
    private function getFlashMessages()
    {
        $messages = [];
        foreach ($this->alertTypes as $type => $class) {
            if (OneTimeFlash::has($type)) {
                $messages[$type] = OneTimeFlash::get($type);
            }
        }
        return $messages;
    }

    /**
     * Renders a single alert
     */
    private function renderAlert($type, $message)
    {
        $alertClass = $this->alertTypes[$type] ?? 'alert-info';

        return Html::tag('div',
            ($this->showCloseButton ?
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' : '') .
            $message,
            [
                'class' => "alert $alertClass alert-dismissible fade show",
                'role' => 'alert'
            ]
        );
    }

    /**
     * Gets CSS styles for positioning
     */
    private function getPositionStyles()
    {
        $styles = [
            'z-index' => '9999',
            'top' => '20px',
        ];

        switch ($this->position) {
            case 'top-right':
                $styles['right'] = '20px';
                break;
            case 'top-left':
                $styles['left'] = '20px';
                break;
            default: // top-center
                $styles['left'] = '50%';
                $styles['transform'] = 'translateX(-50%)';
        }

        return $this->convertStylesToString($styles);
    }

    /**
     * Converts style array to string
     */
    private function convertStylesToString($styles)
    {
        return implode(';', array_map(
            fn($key, $value) => "$key: $value",
            array_keys($styles),
            $styles
        ));
    }

    /**
     * Registers required CSS and JS
     */
    private function registerAssets()
    {
        $view = $this->getView();

        // Register CSS
        $css = <<<CSS
            .flash-alert-container {
                min-width: 300px;
                max-width: 600px;
            }
            .flash-alert-container .alert {
                margin-bottom: 10px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            }
CSS;
        $view->registerCss($css);

        // Register JS
        $js = <<<JS
            document.addEventListener('DOMContentLoaded', function() {
                const alerts = document.querySelectorAll('.flash-alert-container .alert');
                alerts.forEach(alert => {
                    setTimeout(() => {
                        if (alert) {
                            const bsAlert = new bootstrap.Alert(alert);
                            bsAlert.close();
                        }
                    }, {$this->duration});
                });
            });
JS;
        $view->registerJs($js, View::POS_END);
    }
}
