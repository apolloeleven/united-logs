<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectSubscriber */
/* @var $project common\models\Project*/
/* @var $projectLogLevels [] */

$this->title = Yii::t('frontend', 'Update {modelClass}: ', [
    'modelClass' => 'Project Subscriber',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Project Subscribers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('frontend', 'Update');
?>
<div class="project-subscriber-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'projectLogLevels' => $projectLogLevels,
        'project' => $project,
        'model' => $model,
    ]) ?>

</div>
