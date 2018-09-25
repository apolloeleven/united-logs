<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project_share".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $project_id
 * @property integer $role
 *
 * @property Project $project
 * @property User $user
 */
class ProjectShare extends \yii\db\ActiveRecord
{
    const ROLE_ADMIN = 1;
    const ROLE_VIEWER = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%project_share}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'project_id', 'role'], 'required'],
            [['user_id', 'project_id', 'role'], 'integer'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'User ID'),
            'project_id' => Yii::t('common', 'Project ID'),
            'role' => Yii::t('common', 'Role'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\ProjectShareQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProjectShareQuery(get_called_class());
    }
}
