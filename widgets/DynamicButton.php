<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class DynamicButton extends Widget
{
    /**
     * Button types
     */
    const TYPE_BUTTON = 'button';
    const TYPE_LINK = 'link';

    /**
     * Button styles (Bootstrap classes)
     */
    const STYLE_DEFAULT = 'default';
    const STYLE_PRIMARY = 'primary';
    const STYLE_SUCCESS = 'success';
    const STYLE_INFO = 'info';
    const STYLE_WARNING = 'warning';
    const STYLE_DANGER = 'danger';
    const STYLE_LINK = 'link';

    /**
     * Button sizes (Bootstrap classes)
     */
    const SIZE_XS = 'xs';
    const SIZE_SM = 'sm';
    const SIZE_DEFAULT = '';
    const SIZE_LG = 'lg';

    /**
     * @var string The type of element to render (button or link)
     */
    public $type = self::TYPE_BUTTON;

    /**
     * @var string Button/link text label
     */
    public $label = '';

    /**
     * @var string FontAwesome icon name (e.g., 'user', 'edit', etc.)
     * No need to include 'fa fa-' prefix - it will be added automatically
     */
    public $icon = '';

    /**
     * @var string Icon position relative to label (before or after)
     */
    public $iconPosition = 'before';

    /**
     * @var string The style/color of the button (Bootstrap class)
     */
    public $style = self::STYLE_DEFAULT;

    /**
     * @var string The size of the button (Bootstrap class)
     */
    public $size = self::SIZE_DEFAULT;

    /**
     * @var string|array URL for links (used when type is 'link')
     */
    public $url = '#';

    /**
     * @var string Required permission/role to display this button
     * If empty, the button will be visible to all users
     */
    public $permission = '';

    /**
     * @var array Additional HTML options for the button/link
     */
    public $options = [];

    /**
     * @var bool Whether to show the button in a disabled state
     */
    public $disabled = false;

    /**
     * @var string Tooltip text (will add data-toggle="tooltip" and title)
     */
    public $tooltip = '';

    /**
     * @var string ID attribute for the button/link
     */
    public $id;

    /**
     * @var string CSS class for the button/link
     */
    public $cssClass = '';

    public $useFontAwesome5 = false;

    /**
     * @var bool Whether to add a confirmation prompt
     */
    public $confirm = false;

    /**
     * @var string Confirmation message
     */
    public $confirmMessage = 'Are you sure?';

    /**
     * Initializes the widget
     */
    public function init()
    {
        parent::init();

        // Generate a unique ID if not provided
        if (empty($this->id)) {
            $this->id = $this->getId();
        }

        // Add ID to options
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->id;
        }

        // Process options for confirmation
        if ($this->confirm) {
            $this->options['data-confirm'] = $this->confirmMessage;
        }

        // Process options for tooltip
        if ($this->tooltip) {
            $this->options['title'] = $this->tooltip;
            $this->options['data-toggle'] = 'tooltip';
        }

        // Handle disabled state
        if ($this->disabled) {
            if ($this->type === self::TYPE_BUTTON) {
                $this->options['disabled'] = 'disabled';
            } else {
                $this->options['class'] = ArrayHelper::getValue($this->options, 'class', '') . ' disabled';
                $this->options['aria-disabled'] = 'true';
                $this->options['tabindex'] = '-1';
            }
        }
    }

    /**
     * Runs the widget
     * @return string|null The rendered button/link or null if permission check fails
     */
    public function run()
    {
        // Check permissions - return null if the user doesn't have required permission
        if (!$this->checkPermission()) {
            return null;
        }

        // Render button or link based on type
        if ($this->type === self::TYPE_BUTTON) {
            return $this->renderButton();
        } else {
            return $this->renderLink();
        }
    }

    /**
     * Checks if the current user has permission to see this button
     * @return bool True if the user has permission or if no permission is required
     */
    protected function checkPermission()
    {
        // If no permission specified, allow for everyone
        if (empty($this->permission)) {
            return true;
        }

        // Check user permission
        return Yii::$app->sec->hasRole($this->permission) ;
    }

    /**
     * Renders a button element
     * @return string The rendered button
     */
    protected function renderButton()
    {
        // Prepare button options
        $options = $this->prepareOptions('btn');

        // Prepare button content with icon and label
        $content = $this->prepareContent();

        // Render button
        return Html::button($content, $options);
    }

    /**
     * Renders a link element
     * @return string The rendered link
     */
    protected function renderLink()
    {
        // Prepare link options
        $options = $this->prepareOptions($this->style !== self::STYLE_LINK ? 'btn' : '');

        // Prepare link content with icon and label
        $content = $this->prepareContent();

        // Render link
        return Html::a($content, $this->url, $options);
    }

    /**
     * Prepares HTML options for the button/link
     * @param string $baseClass The base CSS class
     * @return array The prepared options
     */
    protected function prepareOptions($baseClass = '')
    {
        $options = $this->options;

        // Handle CSS classes
        $classes = [];

        // Add base class (btn) if provided
        if (!empty($baseClass)) {
            $classes[] = $baseClass;

            // Add button style class (btn-primary, btn-success, etc.)
            if ($this->style !== self::STYLE_DEFAULT) {
                $classes[] = "$baseClass-{$this->style}";
            }

            // Add button size class (btn-lg, btn-sm, etc.)
            if (!empty($this->size)) {
                $classes[] = "$baseClass-{$this->size}";
            }
        }

        // Add custom CSS class if provided
        if (!empty($this->cssClass)) {
            $classes[] = $this->cssClass;
        }

        // Merge with existing classes in options
        if (isset($options['class'])) {
            $options['class'] .= ' ' . implode(' ', $classes);
        } else {
            $options['class'] = implode(' ', $classes);
        }

        return $options;
    }

    /**
     * Prepares button/link content with icon and label
     * @return string The prepared content
     */
    protected function prepareContent()
    {
        $content = '';

        // Create icon HTML if specified
        $icon = $this->renderIcon();

        // Arrange icon and label according to iconPosition
        if ($this->iconPosition === 'before') {
            $content = $icon . ($icon && $this->label ? ' ' : '') . $this->label;
        } else {
            $content = $this->label . ($icon && $this->label ? ' ' : '') . $icon;
        }

        return $content;
    }

    /**
     * Renders FontAwesome icon
     * @return string The rendered icon or empty string if no icon specified
     */
    protected function renderIcon()
    {
        if (empty($this->icon)) {
            return '';
        }

        $iconPrefix = $this->useFontAwesome5 ? 'fas fa-' : 'fa fa-';
        return Html::tag('i', '', ['class' => $iconPrefix . $this->icon]);
    }

    /**
     * Gets available button styles
     * @return array Array of available styles
     */
    public static function getStyles()
    {
        return [
            self::STYLE_DEFAULT => 'Default',
            self::STYLE_PRIMARY => 'Primary',
            self::STYLE_SUCCESS => 'Success',
            self::STYLE_INFO => 'Info',
            self::STYLE_WARNING => 'Warning',
            self::STYLE_DANGER => 'Danger',
            self::STYLE_LINK => 'Link',
        ];
    }

    /**
     * Gets available button sizes
     * @return array Array of available sizes
     */
    public static function getSizes()
    {
        return [
            self::SIZE_XS => 'Extra Small',
            self::SIZE_SM => 'Small',
            self::SIZE_DEFAULT => 'Default',
            self::SIZE_LG => 'Large',
        ];
    }
}
