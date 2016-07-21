<?php

namespace jext\jrbac\models;

use Yii;

/**
 * This is the model class for table "{{%admin_menu}}".
 *
 * @property integer $id
 * @property integer $pid
 * @property string $label
 * @property string $icon
 * @property string $url
 * @property integer $sortorder
 * @property string $content
 * @property integer $status
 */
class AdminMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'sortorder', 'status'], 'integer'],
            [['label','icon'], 'string', 'max' => 32],
            [['url', 'content'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin/menu', 'ID'),
            'pid' => Yii::t('admin/menu', 'Pid'),
            'label' => Yii::t('admin/menu', 'Label'),
            'icon' => Yii::t('admin/menu', 'Icon'),
            'url' => Yii::t('admin/menu', 'Url'),
            'sortorder' => Yii::t('admin/menu', 'Sortorder'),
            'content' => Yii::t('admin/menu', 'Content'),
            'status' => Yii::t('admin/menu', 'Status'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\modelsquery\AdminMenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \jext\jrbac\models\AdminMenuQuery(get_called_class());
    }
}
