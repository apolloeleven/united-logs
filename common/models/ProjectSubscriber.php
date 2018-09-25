<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%project_subscriber}}".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $deleted_at
 * @property string $email
 * @property string $level
 * @property string $category
 * @property string $environment
 *
 * @property Project $project
 */
class ProjectSubscriber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%project_subscriber}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'email'], 'required'],
            [['project_id','created_at','updated_at','deleted_at'], 'integer'],
            [['email', 'category', 'environment'], 'string'],
//            [['level'], 'string', 'max' => 255],
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
            'project_id' => Yii::t('common', 'Project ID'),
            'email' => Yii::t('common', 'Email'),
            'level' => Yii::t('common', 'Level'),
            'category' => Yii::t('common', 'Category'),
            'environment' => Yii::t('common', 'Environment'),
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
     * @inheritdoc
     * @return \common\models\query\ProjectSubscriberQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProjectSubscriberQuery(get_called_class());
    }

    /**
     * @author Saiat Kalbiev <kalbievich11@gmail.com>
     * @param $projectSubscriber
     * @return bool
     */
    public function saveData($projectSubscriber){
        $subscriber = $projectSubscriber;

        $levels = $this->createCurlyBracesFormat($subscriber['level']);
        $categories = $this->createCurlyBracesFormat(explode(',', $subscriber['category']));
        $environments = $this->createCurlyBracesFormat(explode(',', $subscriber['environment']));
        $emails = $this->createCurlyBracesFormat(explode(',', $subscriber['email']));

        $this->project_id = $subscriber['project_id'];
        $this->level = $levels;
        $this->category = $categories;
        $this->environment = $environments;
        $this->email = $emails;

        if($this->save()){
            return true;
        }
        return false;
    }

    /**
     * @author Saiat Kalbiev <kalbievich11@gmail.com>
     * @param $array
     * @return null|string
     */
    protected function createCurlyBracesFormat($array){
        $string = null;
        $return = [];
        foreach ($array as $value){
            $return[] = "{{".$value."}}";
        }
        return implode(",", $return);
    }

    /**
     * @author Saiat Kalbiev <kalbievich11@gmail.com>
     */
    public function removeCurlyBracesFormat(){
        $categoryArray = explode(',', $this->category);
        $environmentArray = explode(',', $this->environment);
        $emailArray = explode(',', $this->email);
        $levelArray = explode(',',$this->level);

        $emailContent = [];
        $environmentContent = [];
        $categoryContent = [];
        $levelContent = [];

        foreach ($categoryArray as $value) {
            array_push($categoryContent,preg_replace('/[(\{\{)(\}\})]/', '', $value));
        }
        foreach ($environmentArray as $value) {
            array_push($environmentContent,preg_replace('/[(\{\{)(\}\})]/', '', $value));
        }
        foreach ($emailArray as $value) {
            array_push($emailContent,preg_replace('/[(\{\{)(\}\})]/', '', $value));
        }
        foreach ($levelArray as $value) {
            array_push($levelContent,preg_replace('/[(\{\{)(\}\})]/', '', $value));
        }

        $this->category = implode(',',$categoryContent);
        $this->environment = implode(',',$environmentContent);
        $this->email = implode(',',$emailContent);
        $this->level = $levelContent;

    }

    /**
     * @author Saiat Kalbiev <kalbievich11@gmail.com>
     * @return bool
     */
    public function markDeleted(){
        $this->deleted_at = time();
        if($this->save()){
            return true;
        }
        return false;
    }
}
