<?php

namespace admin\modules\jrbac\controllers;
  

/**
 * Class DefaultController
 * @package admin\modules\jrbac\controllers
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
