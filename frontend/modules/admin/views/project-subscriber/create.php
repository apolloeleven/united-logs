<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProjectSubscriber */
/* @var $projectLogLevels [] */
/* @var $project common\models\Project */

$this->title = Yii::t('frontend', 'Create Project Subscriber');
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Project Subscribers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-subscriber-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'project' => $project,
        'projectLogLevels' => $projectLogLevels,
        'model' => $model,
    ]) ?>

</div>
