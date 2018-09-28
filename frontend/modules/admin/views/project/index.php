<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'Projects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('frontend', 'Create {modelClass}', [
            'modelClass' => 'Project',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'image',
                'format' => ['html'],
                'value' => function ($model) {
                    /* @var $model common\models\Project */
                    $imageUrl = null;
                    if ($model->getImageAbsoluteUrl()) {
                        $imageUrl = $model->getImageAbsoluteUrl();
                    } else {
                        $imageUrl = '@web/img/project-no-image-image.png';
                    }
                    return Html::img($imageUrl, [
                        'class' => 'img-responsive'
                    ]);
                }
            ],
            'name',
            'token',
            [
                'attribute' => 'Actions',
                'format' => ['html'],
                'value' => function ($model) {
                    return Html::a(
                            Yii::t('frontend', ''),
                            \yii\helpers\Url::to(['/admin/project-log/index', 'id' => $model->id]),
                            [
                                'class' => 'glyphicon glyphicon-book',
                                'title' => Yii::t('frontend', 'Logs'),
                                'style' => 'margin:4px; font-size: 14px;'
                            ]
                        ) . Html::a(
                            Yii::t('frontend', ''),
                            Url::to(['/admin/project-subscriber/index', 'id' => $model->id]),
                            [
                                'class' => 'glyphicon glyphicon-user',
                                'title' => Yii::t('frontend', 'Subscribers'),
                                'style' => 'margin:4px; font-size: 14px;'
                            ]
                        );
                }
            ],
            [
                'class' => ActionColumn::className(),
//                'template' => '{view}'
            ],
        ],
    ]); ?>

</div>
