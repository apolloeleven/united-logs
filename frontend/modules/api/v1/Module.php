<?php

namespace frontend\modules\api\v1;

use common\models\Project;
use Yii;

class Module extends \frontend\modules\api\Module
{
    public $controllerNamespace = 'frontend\modules\api\v1\controllers';

    /**
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @var Project
     */
    public $currentProject;

    public function init()
    {
        parent::init();
    }
}
