<?php

namespace jext\jrbac\controllers;
  

/**
 * Class DefaultController
 * @package jext\jrbac\controllers
 */
class DefaultController extends ControllerJrbac
{
    /**
     * @return string
     */
    public function actionIndex()
    { 
        return $this->render('index');
    }

}
