<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectLog */

$this->title = $model->id;
$this->title = Yii::t('frontend', 'Logs for project: {name}', ['name' => $model->project->name]);
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('frontend', 'Projects'),
    'url' => ['/admin/project']
];
$this->params['breadcrumbs'][] = [
    'label' => $model->project->name,
    'url' => Url::to(['/admin/project/view', 'id' => $model->project->id])
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('frontend', 'Logs'),
    'url' => Url::to(['/admin/project-log/index', 'id' => $model->project->id])
];

$this->params['breadcrumbs'][] = $model->id;

?>
<div class="project-log-view">

    <p>
        <?php echo Html::a(Yii::t('frontend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('frontend', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('frontend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'project_id',
            'level',
            'ip',
            'category',
            'environment',
            'message:ntext',
            [
                'attribute' => 'params',
                'format' => 'html',
                'value' => '<pre>' . json_encode(json_decode($model->params), JSON_PRETTY_PRINT) . '</pre>'
            ],
            [
                'attribute' => 'created_at',
                'format' => ['datetime', 'medium']
            ]
        ],
    ]) ?>

</div>
