<?php
namespace yii\selectize;

use yii\helpers\Html;
use yii\widgets\InputWidget;
use yii\helpers\Json;
use yii\jui\JuiAsset;

class Selectize extends InputWidget
{
    /**
     * @var array
     */
    public $items;
    /**
     * @var array
     * @see https://github.com/brianreavis/selectize.js/blob/master/docs/usage.md#options
     */
    public $clientOptions;
    /**
     * @var array
     * @see https://github.com/brianreavis/selectize.js/blob/master/docs/events.md
     */
    public $clientEvents;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!isset($this->options['id'])) {
            if ($this->hasModel()) {
                $this->options['id'] = Html::getInputId($this->model, $this->attribute);
            } else {
                $this->options['id'] = $this->id;
            }
        }
        $this->registerAssetBundle();
        $this->registerJs();
        $this->registerEvents();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            if (is_array($this->items)) {
                echo Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options);
            } else {
                echo Html::activeTextInput($this->model, $this->attribute, $this->options);
            }
        } else {
            if (is_array($this->items)) {
                echo Html::dropDownList($this->name, $this->value, $this->items, $this->options);
            } else {
                echo Html::textInput($this->name, $this->value, $this->options);
            }
        }
    }

    /**
     * Register asset bundles
     */
    public function registerAssetBundle()
    {
        if (isset($this->clientOptions['plugins']) && in_array('drag_drop', $this->clientOptions['plugins'])) {
            JuiAsset::register($this->getView());
        }
        MicroPluginAsset::register($this->getView());
        SifterAsset::register($this->getView());
        SelectizeAsset::register($this->getView());
    }

    /**
     * Register client script
     */
    public function registerJs()
    {
        if (!isset($this->clientOptions['create']) && empty($this->items)) {
            $this->clientOptions['create'] = "function(input) { return { value: input, text: input };}";
        }
        $clientOptions = (count($this->clientOptions)) ? Json::encode($this->clientOptions) : '';
        $this->getView()->registerJs("jQuery('#{$this->options['id']}').selectize({$clientOptions});");
    }

    /**
     * Register client script handles
     */
    public function registerEvents()
    {
        if (!empty($this->clientEvents)) {
            $js = [];
            foreach ($this->clientEvents as $event => $handle) {
                $js[] = "jQuery('#{$this->options['id']}').on('{$event}',{$handle});";
            }
            $this->getView()->registerJs(implode(PHP_EOL, $js));
        }
    }
} 
