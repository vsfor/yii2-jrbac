<?php

namespace jext\jrbac\controllers;

use common\core\Jeen;
use Yii;
use common\models\User;
use common\modelssearch\UserSearch;
use yii\web\NotFoundHttpException;

/** 管理员用户管理
 * UserController implements the CRUD actions for User model.
 */
class UserController extends ControllerJrbac
{
    /** 查看管理员列表
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /** 查看管理员详细信息 */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /** 添加管理员
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            $model->setPassword(trim($model->passwordtext) ? : 'jymall');
            $model->generateAuthKey();
            $model->generatePasswordResetToken();
            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Jeen::echoln($model->getErrors());exit();
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /** 编辑管理员信息
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if (trim($model->passwordtext)) {
                $model->setPassword($model->passwordtext);
            }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /** 删除管理员
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //变更状态
        $model = $this->findModel($id);
        $model->status = 9;
        $model->save();
        //清空角色及权限
        $auth = \Yii::$app->getAuthManager();
        $auth->revokeAll($model->id);

        return $this->redirect(['index']);
    }

    /** 
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /** 更新个人信息 */
    public function actionSetinfo()
    {
        $model = User::findOne(\Yii::$app->getUser()->getId());
        $msg = '';
        if(!$model) exit("0");
        if(\Yii::$app->getRequest()->getIsPost()) {
            if(trim($_POST['passwordtext'])) {
                if(trim($_POST['passwordtext']) != $_POST['passwordtext']) {
                    $model->addError('passwordtext','密码不可包含空格');
                } else {
                    $model->setPassword(trim($_POST['passwordtext']));
                }
            }
            $model->mobile = trim($_POST['mobile']);
            $model->realname = trim($_POST['realname']);
            $model->content = trim($_POST['content']);
            $model->utime = time();
            if(!$model->getErrors() && $model->save()) {
                $msg = '保存成功';
            } else {
                $msg = '保存失败，请核查相关设置';
            }
        }
        return $this->render('setinfo',['model'=>$model,'msg'=>$msg]);
    }
}
