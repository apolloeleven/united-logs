<?php

namespace frontend\modules\admin\controllers;

use yii\filters\AccessControl;
use common\models\Project;
use common\models\ProjectLog;
use Yii;
use common\models\ProjectSubscriber;
use frontend\models\search\ProjectSubscriberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectSubscriberController implements the CRUD actions for ProjectSubscriber model.
 */
class ProjectSubscriberController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
     * Lists all ProjectSubscriber models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $projectId = $id;
        $projectLogEnvironments = [];
        $searchModel = new ProjectSubscriberSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$projectId);
        $project = Project::find()->byId($projectId)->one();

        $query = ProjectLog::find()->select('environment')->distinct()->byProjectId($projectId)->all();
        foreach ($query as $log){
            $projectLogEnvironments[$log->environment] = $log->environment;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'project' => $project,
            'projectLogLevels' => ProjectLog::getLevels(),
            'projectLogEnvironments' => $projectLogEnvironments
        ]);
    }

    /**
     * Displays a single ProjectSubscriber model.
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
     * Creates a new ProjectSubscriber model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $id = null;
        $project = null;
        if(Yii::$app->request->get('id')){
            $id = Yii::$app->request->get('id');
            $project = Project::find()->byId($id)->one();
        }
        $model = new ProjectSubscriber();
        $model->created_at = time();

        $projectSubscriber = Yii::$app->request->post('ProjectSubscriber');

        if ($projectSubscriber && $model->saveData($projectSubscriber)) {
            return $this->redirect(['index','id'=> $projectSubscriber['project_id']]);
        } else {
            return $this->render('create', [
                'project' => $project,
                'model' => $model,
                'projectLogLevels' => ProjectLog::getLevels(),
            ]);
        }
    }

    /**
     * Updates an existing ProjectSubscriber model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->updated_at = time();

        $project = Project::find()->byId($model->project_id)->one();
        $projectSubscriber = Yii::$app->request->post('ProjectSubscriber');

        if ($projectSubscriber && $model->saveData($projectSubscriber)) {
            return $this->redirect(['index','id'=> $projectSubscriber['project_id']]);
        } else {
            $model->removeCurlyBracesFormat();

            return $this->render('update', [
                'project' => $project,
                'projectLogLevels' => ProjectLog::getLevels(),
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProjectSubscriber model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if($model->markDeleted()){
            return $this->redirect(['index','id'=> $model->project_id]);
        }
        return false;
    }

    /**
     * Finds the ProjectSubscriber model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectSubscriber the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProjectSubscriber::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
