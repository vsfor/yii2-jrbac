<?php

namespace jext\jrbac\models;

/**
 * This is the ActiveQuery class for [[\common\models\AdminMenu]].
 *
 * @see \jext\jrbac\models\AdminMenu
 */
class AdminMenuQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\AdminMenu[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\AdminMenu|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
