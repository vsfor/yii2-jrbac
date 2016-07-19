<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
        <label class="control-label"><?php echo "用户名: ".$model->username;?></label>
    </div>
    <div class="form-group">
        <label class="control-label"><?php echo "邮箱: ".$model->email;?></label>
    </div>
    <?php
    $label = $model->password_hash ? '密码(留空表示不更新)' : '密码(留空则使用默认密码:louli123)';
    echo $form->field($model, 'passwordtext')->textInput(['maxlength' => 32,'name'=>'passwordtext'])->label($label); ?>

    <?php echo $form->field($model, 'realname')->textInput(['maxlength' => 32,'name'=>'realname']); ?>

    <?php echo $form->field($model, 'mobile')->textInput(['maxlength' => 32,'name'=>'mobile']); ?>

    <?php echo $form->field($model, 'content')->textarea(['maxlength' => 255,'name'=>'content']); ?>

    <div class="form-group">
        <?php echo Html::submitButton('保存', ['class' =>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="form-group">
        <label class="control-label"><?php echo "如需修改其他信息请联系系统管理员";?></label>
    </div>

</div>
