<?php
namespace jext\jrbac;

use yii\web\AssetBundle;

class JrbacAsset extends AssetBundle
{
    public $sourcePath = '@jext/jrbac/assets';
    public $css = [
        'main.css',
        'toastmessage/resources/css/jquery.toastmessage.css',
    ];
    public $js = [
        'toastmessage/javascript/jquery.toastmessage.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
