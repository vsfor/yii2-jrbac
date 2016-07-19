<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => '管理员列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h3><?php echo Html::encode($this->title) ?></h3>

    <p>
        <?php echo Html::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确认删除?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php
    $auth = \Yii::$app->getAuthManager();
    $t = [];
    $uRoles = $auth->getRolesByUser($model->id);
    foreach($uRoles as $role) {
        $t[] = $role->description;//$role->name;
    }
    $roleStr = implode(', ',$t);
    $t = [];
    $uPermissions = $auth->getPermissionsByUser($model->id);
    foreach($uPermissions as $permission) {
        $t[] = $permission->description;
    }
    $permissionStr = implode(', ',$t);
    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
//            'auth_key',
            'password_hash',
//            'password_reset_token',
            'email:email',
//            'role',
//            'level',
//            'status',
            [
                'attribute'=>'status',
                'value'=> ($model->status == 1 ? '正常' : '停用')
            ],
            [
                'label' => '角色',
                'value' => $roleStr
            ],
            [
                'label' => '权限',
                'value' => $permissionStr
            ],
        ],
    ]) ?>

</div>
