<?php
/**
 * Created by PhpStorm.
 * User: guga
 * Date: 5/5/17
 * Time: 3:05 PM
 */

namespace frontend\modules\api\v1\controllers;


use common\models\Project;
use common\models\ProjectLog;
use frontend\modules\api\v1\filters\ValidateProjectKeyFilter;
use frontend\modules\api\v1\Module;
use Yii;
use yii\rest\ActiveController;

class LogController extends ActiveController
{
    public $modelClass = 'log';


    /**
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @var Project
     */
    protected $project = null;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

//        // remove authentication filter
//        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];

        // re-add authentication filter
        $behaviors['authenticator'] = [
            'class' => ValidateProjectKeyFilter::className(),
        ];
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];

        return $behaviors;
    }

    public function beforeAction($action)
    {
        $res = parent::beforeAction($action);

        /** @var Module $module */
        $module = Yii::$app->getModule('api')->getModule('v1');
        $this->project = $module->currentProject;

        return $res;
    }

    /**
     * @return array
     */
    public function actionSaveLog($level)
    {
        $data = Yii::$app->request->post();
        $data['level'] = constant(ProjectLog::className().'::LEVEL_'.strtoupper($level));
        $data['project_id'] = $this->project->id;
        $data['ip'] = Yii::$app->request->getUserIP();

        $log = new ProjectLog();
        if ($log->load($data, '') && $log->save() && $log->sendEmails($this->project)){
            return ['success' => true];
        }
        return ['success' => false, 'errors' => $log->errors];

//        \centigen\base\helpers\UtilHelper::vardump($level, Yii::$app->request->post());
//        return ProjectLog::createLog(ProjectLog::LEVEL_ERROR, Yii::$app->request, $this->project);
    }

//    /**
//     * @return array
//     */
//    public function actionError()
//    {
//        return ProjectLog::createLog(ProjectLog::LEVEL_ERROR, Yii::$app->request, $this->project);
//    }
//
//    /**
//     * @return array
//     */
//    public function actionInfo()
//    {
//        return ProjectLog::createLog(ProjectLog::LEVEL_INFO, Yii::$app->request, $this->project);
//    }
//
//    /**
//     * @return array
//     */
//    public function actionWarning()
//    {
//        return ProjectLog::createLog(ProjectLog::LEVEL_WARNING, Yii::$app->request, $this->project);
//    }
//
//    /**
//     * @return array
//     */
//    public function actionSuccess()
//    {
//        return ProjectLog::createLog(ProjectLog::LEVEL_SUCCESS, Yii::$app->request, $this->project);
//    }
}