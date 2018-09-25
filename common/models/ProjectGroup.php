<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project_group".
 *
 * @property integer $id
 * @property integer $group_id
 * @property integer $project_id
 *
 * @property Group $group
 * @property Project $project
 */
class ProjectGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%project_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'project_id'], 'required'],
            [['group_id', 'project_id'], 'integer'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Group::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'group_id' => Yii::t('common', 'Group ID'),
            'project_id' => Yii::t('common', 'Project ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\ProjectGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProjectGroupQuery(get_called_class());
    }

    /**
     * @param $projectId
     * @param $groupId
     * @return bool
     */
    public static function addProject($projectId, $groupId)
    {
        $projectGroup = new ProjectGroup();
        $projectGroup->project_id = $projectId;
        $projectGroup->group_id = $groupId;
        return $projectGroup->save();
    }
}
