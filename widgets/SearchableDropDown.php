<?php

namespace app\widgets;
use kartik\select2\Select2;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

class SearchableDropDown extends Widget
{
    public $model;
    public $attribute;
    public $name;
    public $data = [];
    public $pluginOptions = [];
    public $options = [];
    public $placeholder = 'Search...';
    public $allowClear = false;
    public $enableAjax = false;
    public $ajaxUrl = '';
    public $ajaxOptions = [];
    public $dropdownOptions = [];
    public $isMultiple = false;
    public $cssClass = '';

    public function init()
    {
        parent::init();

        if (!empty($this->dropdownOptions)) {
            $this->dropdownOptions = [
                'dropdownAutoWidth' => false, // This makes the dropdown width adjust to content
                'dropdownCssClass' => 'select2-dropdown-large', // Custom class for styling
            ];
            $this->pluginOptions['dropdownOptions'] = $this->dropdownOptions;
        }

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->id;
        }

        // Apply the custom CSS class if provided
        if (!isset($this->options['class'])) {
            $this->options['class'] = 'form-control';
        }

        if (!empty($this->cssClass)) {
            $this->options['class'] .= ' ' . $this->cssClass;
        }

        // Configure multi-select option
        if ($this->isMultiple) {
            $this->options['multiple'] = true;
        }

        // Default plugin options
        $defaultPluginOptions = [
            'allowClear' => $this->allowClear,
            'placeholder' => $this->placeholder,
            'width' => '100%',
//            'theme' => 'bootstrap5',
            'theme' => 'krajee',
        ];

        $this->pluginOptions = ArrayHelper::merge($defaultPluginOptions, $this->pluginOptions);

        // Setup AJAX configuration if enabled
        if ($this->enableAjax && !empty($this->ajaxUrl)) {
            $defaultAjaxOptions = [
                'url' => $this->ajaxUrl,
                'dataType' => 'json',
                'delay' => 250,
                'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                'processResults' => new JsExpression('function(data) { return {results: data}; }'),
                'cache' => true
            ];

            $this->pluginOptions['ajax'] = ArrayHelper::merge($defaultAjaxOptions, $this->ajaxOptions);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        // If using within ActiveForm with a model
        if ($this->model !== null && $this->attribute !== null) {
            return Select2::widget([
                'model' => $this->model,
                'attribute' => $this->attribute,
                'data' => $this->data,
                'options' => $this->options,
                'pluginOptions' => $this->pluginOptions,
            ]);
        }

        if ($this->name !== null) {
            return Select2::widget([
                'name' => $this->name,
                'data' => $this->data,
                'options' => $this->options,
                'pluginOptions' => $this->pluginOptions,
            ]);
        }

        return '';
    }
}
