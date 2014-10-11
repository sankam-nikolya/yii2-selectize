<?php
/**
 * Created by PhpStorm.
 * User: Nghia
 * Date: 10/10/2014
 * Time: 6:43 AM
 */

namespace yii\selectize;


use yii\helpers\Html;
use yii\widgets\InputWidget;

class Selectize extends InputWidget
{
    public $clientOptions;
    public $clientEvents;

    public function init()
    {
        if ($this->hasModel()) {
            $this->options['id'] = Html::getInputId($this->model, $this->attribute);
        } else {
            $this->options['id'] = $this->id;
        }

        $this->registerAssetBundle();
        $this->registerJs();
        $this->registerEvents();
    }

    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textInput($this->name, $this->value, $this->options);
        }
    }

    public function registerAssetBundle()
    {
        SelectizeAsset::register($this->getView());
    }

    public function registerJs()
    {
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