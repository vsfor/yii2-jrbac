<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = '编辑 个人信息: ' . ' ' . $model->username;
$this->params['breadcrumbs'][] = '编辑:'.$model->username;
?>
<div class="user-setinfo">

    <h3><?php echo Html::encode($this->title) ?></h3>

    <?php if(isset($msg)&& $msg) {
        echo Html::tag('div',$msg,['class'=>'alert alert-warning']);
    }?>
    <?php echo $this->render('_setinfoform', [
        'model' => $model,
    ]) ?>

</div>