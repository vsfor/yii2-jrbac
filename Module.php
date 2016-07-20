<?php

namespace jext\jrbac;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'jext\jrbac\controllers';

    public function init()
    {
        parent::init();

        \Yii::setAlias('@jext/jrbac', dirname(__FILE__));
        // custom initialization code goes here
    }
}
