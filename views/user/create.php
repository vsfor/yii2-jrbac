<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = '添加 管理员';
$this->params['breadcrumbs'][] = ['label' => '管理员列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h3><?php echo Html::encode($this->title) ?></h3>

    <?php
    $model->loadDefaultValues();
    echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
