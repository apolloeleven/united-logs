<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ProjectSubscriberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $project common\models\Project */
/* @var $projectLogLevels [] */
/* @var $projectLogEnvironments [] */

echo Breadcrumbs::widget([
    'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
    'links' => [
        [
            'label' => 'Projects',
            'url' => ['/admin/project']
        ],
        [
            'label' => $project->name,
            'url' => Url::to(['/admin/project/view', 'id' => $project->id])
        ],
        'Subscribers',
    ],
]);
echo Html::a(
    Yii::t('frontend', 'Logs'),
    \yii\helpers\Url::to(['/admin/project-log/index', 'id' => $project->id]),
    [
        'class' => 'btn btn-primary'
    ]
);
?>
<div class="project-subscriber-index">

    <h1><?= $project->name ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(
            Yii::t('frontend', 'Create Project Subscriber'),
            \yii\helpers\Url::to(['/admin/project-subscriber/create', 'id' => $project->id]),
            ['class' => 'btn btn-success']
        )
        ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'email',
                'format' => ['html'],
                'filter' => Html::activeTextInput($searchModel, 'email', [
                    'placeholder' => '--Please insert an email--',
                    'class' => 'form-control',
                ]),
                'value' => function ($data) {
                    $dataArray = explode(',', $data->email);
                    $content = "";
                    foreach ($dataArray as $value) {
                        $content .= \yii\bootstrap\Html::tag('span',
                            preg_replace('/[(\{\{)(\}\})]/', '', $value), [
                                'style' => 'margin-right: 5px',
                                'class' => 'label label-default'
                            ]);
                    }
                    return $content;
                }
            ],
            [
                'attribute' => 'level',
                'format' => ['html'],
                'filter' => Html::activeDropDownList($searchModel, 'level', $projectLogLevels, [
                    'class' => 'form-control',
                    'prompt' => '--Please select log level--',
                ]),
                'value' => function ($data) {
                    if (!$data->level) {
                        return '';
                    }
                    $levels = \common\models\ProjectLog::getLevels();
                    $dataArray = explode(',', $data->level);
                    $content = "";
                    foreach ($dataArray as $value) {
                        $number = preg_replace('/[(\{\{)(\}\})]/', '', $value);
                        if ($levels[$number] !== "ERROR") {
                            $content .= \yii\bootstrap\Html::tag('span', $levels[$number], [
                                'style' => 'margin-right: 5px',
                                'class' => 'label label-' . strtolower($levels[$number])
                            ]);
                        } else {
                            $content .= \yii\bootstrap\Html::tag('span', $levels[$number], [
                                'style' => 'margin-right: 5px',
                                'class' => 'label label-danger'
                            ]);
                        }
                    }
                    return $content;
                }
            ],
            [
                'attribute' => 'category',
                'format' => ['html'],
                'filter' => Html::activeTextInput($searchModel, 'category', [
                    'placeholder' => '--Please insert a category--',
                    'class' => 'form-control',
                ]),
                'value' => function ($data) {
                    $dataArray = explode(',', $data->category);
                    $content = "";
                    foreach ($dataArray as $value) {
                        $content .= \yii\bootstrap\Html::tag('span',
                            preg_replace('/[(\{\{)(\}\})]/', '', $value), [
                                'style' => 'margin-right: 5px',
                                'class' => 'label label-default'
                            ]);
                    }
                    return $content;
                }
            ],
            [
                'attribute' => 'environment',
                'format' => ['html'],
                'filter' => Html::activeDropDownList($searchModel, 'environment', $projectLogEnvironments, [
                    'prompt' => '--Please select an environment--',
                    'class' => 'form-control'
                ]),
                'value' => function ($data) {
                    $dataArray = explode(',', $data->environment);
                    $content = "";
                    foreach ($dataArray as $value) {
                        $content .= \yii\bootstrap\Html::tag('span',
                            preg_replace('/[(\{\{)(\}\})]/', '', $value), [
                                'style' => 'margin-right: 5px',
                                'class' => 'label label-default'
                            ]);
                    }
                    return $content;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
            ]
        ],
    ]); ?>
</div>
