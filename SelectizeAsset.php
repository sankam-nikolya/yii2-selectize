<?php
/**
 * Created by PhpStorm.
 * User: Nghia
 * Date: 10/10/2014
 * Time: 6:44 AM
 */

namespace yii\selectize;
use yii\web\AssetBundle;

class SelectizeAsset extends AssetBundle
{
    public $sourcePath = '@bower/selectize/dist';
    public $depends =[
        'yii\bootstrap\BootstrapAsset',
    ];
    public $js = ['js/selectize.js'];
    public $css = ['css/selectize.bootstrap3.css'];
} 