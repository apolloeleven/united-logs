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


$this->title = Yii::t('frontend', 'Subscribers of project: {name}', ['name' => $project->name]);
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('frontend', 'Projects'),
    'url' => ['/admin/project']
];
$this->params['breadcrumbs'][] = [
    'label' => $project->name,
    'url' => Url::to(['/admin/project/view', 'id' => $project->id])
];
$this->params['breadcrumbs'][] = Yii::t('frontend', 'Subscriptions');

echo Html::a(
    Yii::t('frontend', 'Logs'),
    \yii\helpers\Url::to(['/admin/project-log/index', 'id' => $project->id]),
    [
        'class' => 'btn btn-primary',
        'style' => 'margin-bottom: 2px'
    ]
);
?>
<div class="project-subscriber-index">


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
                    'placeholder' => Yii::t('frontend', 'Insert an Email'),
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
                    'prompt' => Yii::t('frontend', '--Select Log Level--'),
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
                    'placeholder' => Yii::t('frontend', '--Insert a Category--'),
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
                    'prompt' => Yii::t('frontend', '--Select an Environment--'),
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
