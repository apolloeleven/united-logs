<?php
/**
 * Created by PhpStorm.
 * User: guga
 * Date: 5/5/17
 * Time: 2:53 PM
 */

namespace frontend\modules\api\v1\filters;


use common\models\Project;
use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

class ValidateProjectKeyFilter extends ActionFilter
{
    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws ForbiddenHttpException
     */
    public function beforeAction($action)
    {
        $key = Yii::$app->request->post('api');
        if (!$key || !($project = Project::find()->notDeleted()->byToken($key)->one())) {
            throw new ForbiddenHttpException(Yii::t('api', 'Project Not Found'));
        }
        /** @var \frontend\modules\api\v1\Module $v1 */
        $v1 = Yii::$app->getModule('api')->getModule('v1');
        $v1->currentProject = $project;
        return true;
    }

}