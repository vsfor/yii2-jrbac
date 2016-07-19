<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modelssearch\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h3><?php echo Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a('添加管理员', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            'username',
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
             'email:email',
            [
                'class'=>'yii\grid\DataColumn',
                'header'=>'所属角色',
                'value'=>function($data) {
                    $t = [];
                    $uRoles = \Yii::$app->getAuthManager()->getRolesByUser($data->id);
                    foreach($uRoles as $role) {
                        $t[] = $role->description;//$role->name;
                    }
                    return implode(', ',$t);
                }
            ],
            [
                'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]); ?>

</div>
