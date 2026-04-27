<?php
// components/Generics/Modal.php
namespace app\components\Generics;

use yii\base\Widget;
use yii\helpers\Html;

class Modal extends Widget
{
    /**  Modal ID */
    public $id;

    /**  Modal title */
    public $title;

    /**  Modal size (sm, md, lg, xl) */
    public $size = 'md';

    /**  Modal position */
    public $position = 'centered';

    /**  Additional options for the modal */
    public $options = [];


    /**  Show close button in header */
    public $Close = true;

    /**
     * Initializes the widget
     */
    public function init()
    {
        parent::init();

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        // Start output buffering to capture content between begin() and end()
        ob_start();
        // Output the modal opening structure
        echo $this->renderHeader();
        echo "<div class='modal-body'>";
    }

    /**
     * Executes the widget
     * @return string The rendered content
     */
    public function run()
    {
        // Get content between begin() and end()
        $content = ob_get_clean();
        // Combine the content with the closing structure
        echo $content;
        echo "</div>"; // Close modal-body
        echo $this->renderClosing();
    }


    protected function renderHeader()
    {
        $sizeClass = $this->size ? "modal-{$this->size}" : '';
        $positionClass = "modal-dialog-$this->position" ?: '';

        return sprintf("
        <div class='modal fade' id='{$this->id}' tabindex='-1' aria-labelledby='{$this->id}Label' aria-hidden='true' >
            <div class='modal-dialog {$sizeClass} {$positionClass}' >
                <div class='modal-content' style='z-index:999 !important;'>
                    <div class='modal-header mb-2'>
                        <h5 class='modal-title' id='{$this->id}Label'>{$this->title}</h5>
                        %s
                    </div>",
            $this->Close ? "<button type='button' class='btn-close btn-sm btn-outline-primary text-white' data-bs-dismiss='modal' aria-label='Close'>X</button>" : "");
    }

    /**
     * Renders the modal closing tags
     * The closing HTML
     */
    protected function renderClosing()
    {
        return "</div></div></div>";
    }
}
