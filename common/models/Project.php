<?php

namespace common\models;

use Codeception\Exception\ContentNotFound;
use Yii;
use yii\db\Exception;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property string $name
 * @property string $token
 * @property string $description
 * @property string $image
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $trusted_domains
 *
 * @property User $createdBy
 * @property User $deletedBy
 * @property User $updatedBy
 * @property ProjectGroup[] $projectGroups
 * @property ProjectLog[] $projectLogs
 * @property ProjectShare[] $projectShares
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%project}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['name', 'image'], 'string', 'max' => 255],
            [['trusted_domains'], 'string', 'max' => 2000],
            [['token'], 'string', 'max' => 128],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['deleted_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'name' => Yii::t('common', 'Name'),
            'token' => Yii::t('common', 'API Key'),
            'description' => Yii::t('common', 'Description'),
            'image' => Yii::t('common', 'Image'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'deleted_at' => Yii::t('common', 'Deleted At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'deleted_by' => Yii::t('common', 'Deleted By'),
            'trusted_domains' => Yii::t('common', 'Trusted Domains'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'deleted_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectGroups()
    {
        return $this->hasMany(ProjectGroup::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectLogs()
    {
        return $this->hasMany(ProjectLog::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectShares()
    {
        return $this->hasMany(ProjectShare::className(), ['project_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProjectQuery(get_called_class());
    }


    /**
     * @return array|Project[]
     */
    public static function getProjectsByCurrentUser()
    {
        return Project::find()->byUserId(Yii::$app->user->id)->notDeleted()->all();
    }


    /**
     * creates project and shares it to creator
     *
     * @return bool
     */
    public function createProject()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try{
            if(!$this->save()){
                Yii::error($this->errors,'project');
                throw new \Exception(VarDumper::dumpAsString($this->errors));
            }
            if(!self::shareProject($this->id,Yii::$app->user->id,ProjectShare::ROLE_ADMIN)){
                throw new \Exception();
            }
            $transaction->commit();
            return true;
        }catch (\Exception $e){
            $transaction->rollBack();
        }
        return false;
    }

    /**
     * takes projectID, userId and role and shares it flawlessly.
     *
     * @param $projectId integer
     * @param $userId integer
     * @param $role integer
     * @return bool
     */
    public static function shareProject($projectId, $userId, $role)
    {
        $projectShare = ProjectShare::find()->byUserId($userId)->byProjectId($projectId)->one();
        if(!$projectShare){
            $projectShare = new ProjectShare();
            $projectShare->project_id = $projectId;
            $projectShare->user_id = $userId;
        }
        $projectShare->role =$role;
        if(!$projectShare->save()){
            Yii::error($projectShare->errors,'project_share');
            return false;
        }
        return true;
    }

    /**
     * @author Saiat Kalbiev <kalbievich11@gmail.com>
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if($insert){
            $this->created_at = time();
            $this->generateToken();
        }else{
            $this->updated_at = time();
        }
        return parent::beforeSave($insert);
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

    protected function generateToken()
    {
        $this->token = Yii::$app->getSecurity()->generateRandomString(64);
    }

    /**
     * @author Saiat Kalbiev <kalbievich11@gmail.com>
     * @return bool
     */
    public function saveImage(){
        $file = UploadedFile::getInstance($this,'image');
        if(!isset($file)){
            return true;
        }
        $path =  Yii::getAlias('@storage').'/web/source/project';
        if(!is_dir($path)){
            mkdir($path);
        }
        $name = time().'.'.$file->getExtension();
        $path = $path.'/'.$name;
        $this->image = $name;
        if($file->saveAs($path)){
            return true;
        }
        return false;
    }


    /**
     * @author Saiat Kalbiev <kalbievich11@gmail.com>
     * @return null|string
     */
    public function getImageAbsoluteUrl(){
        if($this->image){
            return Yii::getAlias('@storageUrl/source/project/'.$this->image);
        }
        return null;
    }
}
