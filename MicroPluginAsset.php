<?php
/**
 * Created by PhpStorm.
 * User: Nghia
 * Date: 10/18/2014
 * Time: 3:19 AM
 */

namespace yii\selectize;
use yii\web\AssetBundle;

class MicroPluginAsset extends AssetBundle{
    public $sourcePath = '@bower/microplugin/src';
    public $depends =[
        'yii\bootstrap\BootstrapAsset'
    ];
    public $js = ['microplugin.js'];
} 