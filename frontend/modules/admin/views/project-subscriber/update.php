<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectSubscriber */
/* @var $project common\models\Project*/
/* @var $projectLogLevels [] */

$this->title = Yii::t('frontend', 'Update {modelClass}: ', [
    'modelClass' => 'Project Subscriber',
]) . $model->id;
$this->params['breadcrumbs'][] = [
    'label' => 'Projects',
    'url' => ['/admin/project']
];
$this->params['breadcrumbs'][] = [
    'label' => $project->name,
    'url' => Url::to(['/admin/project/view', 'id' => $project->id])
];
$this->params['breadcrumbs'][] = [
    'label' => 'Subscriptions',
    'url' => Url::to(['/admin/project-subscriber/index', 'id' => $project->id])
];
$this->params['breadcrumbs'][] = $model->id;


?>
<div class="project-subscriber-update">


    <?= $this->render('_form', [
        'projectLogLevels' => $projectLogLevels,
        'project' => $project,
        'model' => $model,
    ]) ?>

</div>
