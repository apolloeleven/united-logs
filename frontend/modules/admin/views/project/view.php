<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$imageUrl = null;
if ($model->getImageAbsoluteUrl()) {
    $imageUrl = $model->getImageAbsoluteUrl();
} else {
    $imageUrl = '@web/img/project-no-image-image.png';
}

?>
<div class="project-view">

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
            [
                'label' => Yii::t('frontend', 'Image'),
                'format' => ['html'],
                'value' => Html::img($imageUrl, [
                    'class' => 'img-responsive'
                ])
            ],
            'name',
            'token',
            'description'
        ],
    ]) ?>

</div>
