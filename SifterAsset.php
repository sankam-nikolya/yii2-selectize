<?php
/**
 * Created by PhpStorm.
 * User: Nghia
 * Date: 10/22/2014
 * Time: 4:29 AM
 */

namespace yii\selectize;

use yii\web\AssetBundle;

class SifterAsset extends AssetBundle
{
    public $sourcePath = '@bower/sifter';
    public $depends =[
        'yii\web\YiiAsset'
    ];
    public $js = ['microplugin.js'];
} 