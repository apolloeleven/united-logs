<?php

namespace frontend\modules\admin\controllers;

use common\models\Project;
use Yii;
use common\models\ProjectLog;
use frontend\models\search\ProjectLogSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectLogController implements the CRUD actions for ProjectLog model.
 */
class ProjectLogController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied by default
                ],
            ],
        ];
    }

    /**
     * Lists all ProjectLog models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $projectId = $id;
        $searchModel = new ProjectLogSearch();

        $logCategories = ProjectLog::find()->select('category')->distinct()->byProjectId($projectId)->all();
        $logEnvironments = ProjectLog::find()->select('environment')->distinct()->byProjectId($projectId)->all();

//        $projectLogEnvironments = [];
//        $projectLogCategories = [];
//        foreach ($logCategories as $log){
//            $projectLogCategories[$log->category] =$log->category;
//        }
//        foreach ($logCategories as $log){
//            $projectLogEnvironments[$log->environment] = $log->environment;
//        }


        $project = Project::findOne($projectId);
        return $this->render('index', [
            'project' => $project,
            'searchModel' => $searchModel,
            'dataProvider' => $searchModel->search(Yii::$app->request->queryParams, $projectId),
            'projectLogCategories' => ArrayHelper::map($logCategories, 'category', 'category'),
            'projectLogLevels' => ProjectLog::getLevels(),
            'projectLogEnvironments' => ArrayHelper::map($logEnvironments, 'environment', 'environment')
        ]);
    }

    /**
     * Displays a single ProjectLog model.
     * @param integer $id
     * @return mixed
     */

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Deletes an existing ProjectLog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id = null)
    {
        $id = $id ?: Yii::$app->request->post('id');

        $oneId = $id;
        if(is_array($id)){
            $oneId = $id[0];
        }
        $log = $this->findModel($oneId);
        $projectId = $log->project_id;

        ProjectLog::deleteAll(['id' => $id]);

        return $this->redirect(['index', 'id' => $projectId]);
    }

    /**
     * Finds the ProjectLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProjectLog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
