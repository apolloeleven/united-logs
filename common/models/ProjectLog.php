<?php

namespace common\models;

use Yii;
use yii\base\Behavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "project_log".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $level
 * @property string $ip
 * @property string $category
 * @property string $environment
 * @property string $message
 * @property string $params
 * @property integer $created_at
 *
 * @property Project $project
 * @property ProjectSubscriber[] $projectSubscribers
 */
class ProjectLog extends \yii\db\ActiveRecord
{
    const LEVEL_SUCCESS = 1;
    const LEVEL_WARNING = 2;
    const LEVEL_INFO = 3;
    const LEVEL_ERROR = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%project_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'level', 'ip', 'category', 'environment', 'message'], 'required'],
            [['project_id', 'level', 'created_at'], 'integer'],
            [['message', 'params'], 'string'],
            [['ip', 'category', 'environment'], 'string', 'max' => 255],
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
            'level' => Yii::t('common', 'Level'),
            'ip' => Yii::t('common', 'Ip'),
            'category' => Yii::t('common', 'Category'),
            'environment' => Yii::t('common', 'Environment'),
            'message' => Yii::t('common', 'Message'),
            'params' => Yii::t('common', 'Params'),
            'created_at' => Yii::t('common', 'Created At'),
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false
            ]
        ];
    }

    /**
     * @return Behavior[]
     */
    public function getBehaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false
            ]
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
    public function getProjectSubscribers()
    {
        return $this->hasMany(ProjectSubscriber::className(), ['project_id' => 'project_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\ProjectLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProjectLogQuery(get_called_class());
    }

    public function load($data, $formName = null)
    {
        if (ArrayHelper::getValue($data, 'params') && is_array($data['params'])){
            $data['params'] = Json::encode($data['params']);
        }
        return parent::load($data, $formName);
    }

    public function sendEmails(Project $project)
    {
//        \centigen\base\helpers\UtilHelper::vardump(QueryHelper::getRawSql(ProjectSubscriber::find()
//            ->byProjectId($this->project_id)
//            ->byLevel($this->level)
//            ->byCategory($this->category)
//            ->byEnvironment($this->environment)
//            ->notDeleted()));
        $subscribers = ProjectSubscriber::find()
            ->byProjectId($this->project_id)
            ->byLevel($this->level)
            ->byCategory($this->category)
            ->byEnvironment($this->environment)
            ->notDeleted()
            ->all();

        $emails = [];
        foreach ($subscribers as $subscriber) {
            $emails = array_merge($emails, explode(",", $subscriber->email));
        }
        if (count($emails) > 0) {
            try {
                $emails = preg_replace('/[(\{\{)(\}\})]/', '', implode(',', array_unique($emails)));
                $emails = explode(',', $emails);
                return Yii::$app->mailer->compose()
                    ->setFrom(Yii::$app->params['robotEmail'])
                    ->setTo($emails)
                    ->setSubject(\Yii::t('email', self::getLevels()[$this->level] . ' ' . $project->name))
                    ->setHtmlBody("<h1>$this->environment</h1><br><h2>$this->category</h2><br><pre>$this->message</pre>")
                    ->send();
            } catch (\Exception $e) {
                Yii::error($e->getMessage(), 'mail_send');
                \centigen\base\helpers\UtilHelper::vardump($e->getMessage());
                return false;
            }
        }else{
            return true;
        }
    }

    /**
     * @author Saiat Kalbiev <kalbievich11@gmail.com>
     * @return array
     */
    public static function getLevels()
    {
        return [
            self::LEVEL_SUCCESS => Yii::t('common', 'SUCCESS'),
            self::LEVEL_WARNING => Yii::t('common', 'WARNING'),
            self::LEVEL_INFO => Yii::t('common', 'INFO'),
            self::LEVEL_ERROR => Yii::t('common', 'ERROR')
        ];
    }
}
