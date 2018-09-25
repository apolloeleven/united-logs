<?php
/**
 * User: zura
 * Date: 5/25/17
 * Time: 6:05 PM
 */

namespace frontend\modules\user\controllers;
use yii\web\Controller;


/**
 * Class DashboardController
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package frontend\modules\user\controllers
 */
class DashboardController extends Controller
{

    public function actionIndex()
    {
        return $this->renderContent("Vasha");
    }
}