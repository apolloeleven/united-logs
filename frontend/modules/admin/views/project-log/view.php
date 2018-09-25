<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectLog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Project Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
                'value' => '<pre>'.json_encode(json_decode($model->params), JSON_PRETTY_PRINT).'</pre>'
            ],
            [
                'attribute' => 'created_at',
                'format' => ['datetime', 'medium']
            ]
        ],
    ]) ?>

</div>
