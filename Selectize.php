<?php
/**
 * Created by PhpStorm.
 * User: Nghia
 * Date: 10/10/2014
 * Time: 6:43 AM
 */

namespace yii\selectize;


use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\InputWidget;
use yii\helpers\Json;

class Selectize extends InputWidget
{
    public $items = [];
    public $clientOptions;
    public $clientEvents;

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

    public function run()
    {
        if ($this->hasModel()) {
            if (empty($this->items)) {
                echo Html::activeTextInput($this->model, $this->attribute, $this->options);
            } else {
                echo Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options);
            }
        } else {
            if (empty($this->items)) {
                echo Html::textInput($this->name, $this->value, $this->options);
            } else {
                echo Html::dropDownList($this->name, $this->value, $this->items, $this->options);
            }
        }
    }

    public function registerAssetBundle()
    {
        if (isset($this->clientOptions['plugins']) && array_search('drag_drop', $this->clientOptions['plugins'])) {
            JuiAsset::register($this->getView());
        }
        MicroPluginAsset::register($this->getView());
        SifterAsset::register($this->getView());
        SelectizeAsset::register($this->getView());
    }

    public function registerJs()
    {
        if (!isset($this->clientOptions['create']) && empty($this->items)) {
            $this->clientOptions['create'] = "function(input) { return { value: input, text: input };}";
        }
        $clientOptions = (count($this->clientOptions)) ? Json::encode($this->clientOptions) : '';
        $this->getView()->registerJs("jQuery('#{$this->options['id']}').selectize({$clientOptions});");
    }

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