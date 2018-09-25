<?php

namespace frontend\modules\api;

use Yii;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();

        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = null;

        Yii::$app->request->parsers['application/json'] = 'yii\web\JsonParser';
    }
}
