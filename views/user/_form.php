<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
if(!$model->status) $model->status = 1; //设置默认状态为正常
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'username')->textInput(['maxlength' => 32]); ?>

    <?php
    $label = $model->id ? '密码(留空表示不更新)' : '密码(留空则使用默认密码:jymall)';
    echo $form->field($model, 'passwordtext')->textInput(['maxlength' => 32])->label($label); ?>

    <?php echo $form->field($model, 'email')->textInput(['type'=>'email','maxlength' => 255]); ?>

    <?php
    echo $form->field($model, 'status')
        ->radioList([
        $model::STATUS_ACTIVE=>'正常',
        $model::STATUS_LOCKED=>'锁定'
        ]);
    ?>

    <div class="form-group">
        <?php echo Html::submitButton(!$model->id ? '添加' : '编辑', ['class' => !$model->id ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
