<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\ProjectSubscriber */
/* @var $projectLogLevels [] */
/* @var $project common\models\Project */

$this->title = Yii::t('frontend', 'Create Project Subscriber');
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
<div class="project-subscriber-create">


    <?= $this->render('_form', [
        'project' => $project,
        'projectLogLevels' => $projectLogLevels,
        'model' => $model,
    ]) ?>

</div>
