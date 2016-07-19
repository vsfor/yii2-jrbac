<?php
namespace admin\modules\jrbac\vendor;

use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\rbac\DbManager;
use yii\rbac\Item;

class JDbManager extends DbManager implements JManagerInterface
{
    public function isRoot()
    {
        if(\Yii::$app->getUser()->getIsGuest()) return false;
        $user = \Yii::$app->getUser()->getIdentity();
        if($user->getId() == 1) return true;
        $auth = \Yii::$app->getAuthManager();
        $roles = $auth->getRolesByUser($user->getId());
        $roleNames = ArrayHelper::getColumn($roles,'name',false);
        return in_array('root',$roleNames);
    }

    public function getUserQuery()
    {
        $userModel = \Yii::$app->getUser()->identityClass;
        return $userModel::find();
    }

    public function getUsersByRole($roleName)
    {
        if (empty($roleName)) {
            return [];
        }

        $query = (new Query())->select('*')
            ->from($this->assignmentTable)
            ->where(['item_name' => (string) $roleName]);

        $users = [];
        $userModel = \Yii::$app->getUser()->identityClass;
        foreach ($query->all($this->db) as $row) {
            $user = $userModel::findOne($row['user_id']);
            if($user) $users[$row['user_id']] = $user;
        }
        return $users;
    }

    public function getUserIdsByRole($roleName)
    {
        if (empty($roleName)) {
            return [];
        }

        $query = (new Query())->select('user_id')
            ->from($this->assignmentTable)
            ->where(['item_name' => (string) $roleName]);
        $rows = $query->all($this->db);
        if($rows) {
            return ArrayHelper::getColumn($rows,'user_id');
        }
        return [];
    }

    public function getPermissionsByRule($ruleName)
    {
        $query = (new Query)->from($this->itemTable)->where([
            'type' => Item::TYPE_PERMISSION,
            'rule_name' => $ruleName,
        ]);
        $permissions = [];
        foreach ($query->all($this->db) as $row) {
            $permissions[$row['name']] = $this->populateItem($row);
        }
        return $permissions;
    }

}