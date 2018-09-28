<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;


/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ProjectLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $project common\models\Project */
/* @var $projectLogCategories [] */
/* @var $projectLogLevels [] */
/* @var $projectLogEnvironments [] */


//$this->registerAssetBundle('centigen\i18ncontent\AssetBundle');
$this->title = Yii::t('frontend', 'Logs for project: {name}', ['name' => $project->name]);
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('frontend', 'Projects'),
    'url' => ['/admin/project']
];
$this->params['breadcrumbs'][] = [
    'label' => $project->name,
    'url' => Url::to(['/admin/project/view', 'id' => $project->id])
];
$this->params['breadcrumbs'][] = Yii::t('frontend', 'Logs');

echo Html::a(Yii::t('frontend', 'Subscribers'), Url::to(['/admin/project-subscriber/index', 'id' => $project->id]), ['class' => 'btn btn-primary']);
echo Html::a(Yii::t('frontend', 'Delete'), [null], ['class' => 'btn btn-danger delete-multiple', 'style' => 'margin:5px']);

?>
<div class="project-log-index">
    <?php echo GridView::widget([
//        'orderColumnName' => 'id',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => \yii\grid\CheckboxColumn::class,
//                'class' => \centigen\base\grid\CheckboxColumn::className(),
//                'prefix' => '<div class="om-checkbox"><label>',
//                'suffix' => '<span class="om-checkbox-material"><span class="check"></span></span></label></div>',
//                'headerPrefix' => '<div class="om-checkbox"><label>',
//                'headerSuffix' => '</label></div>',
                'options' => [
                    'style' => 'width: 1px;',
                    'class' => 'text-center',
                ],
                'contentOptions' => [
                    'style' => 'vertical-align: middle;'
                ],
            ],
            [
                'attribute' => 'id',
                'options' => [
                    'style' => 'width: 100px;',
                ]
            ],
            [
                'attribute' => 'level',
                'format' => ['html'],
                'filter' => Html::activeDropDownList($searchModel, 'level', $projectLogLevels, [
                    'class' => 'form-control',
                    'prompt' => Yii::t('frontend', '--Select Log Level--'),
                ]),
                'value' => function ($data) {
                    $levels = \common\models\ProjectLog::getLevels();
                    $dataArray = explode(',', $data->level);
                    $content = "";
                    foreach ($dataArray as $value) {
                        $number = preg_replace('/[(\{\{)(\}\})]/', '', $value);

                        $label = $levels[$number] === "ERROR" ? 'danger' : strtolower($levels[$number]);
                        $content .= \yii\bootstrap\Html::tag('span', $levels[$number], [
                            'style' => 'margin-right: 5px',
                            'class' => 'label label-' . $label
                        ]);

                    }
                    return $content;
                }
            ],

            [
                'attribute' => 'category',
                'filter' => Html::activeDropDownList($searchModel, 'category', $projectLogCategories, [
                    'class' => 'form-control',
                    'prompt' => Yii::t('frontend', '--Select a Category--'),
                ])
            ],
            [
                'attribute' => 'environment',
                'filter' => Html::activeDropDownList($searchModel, 'environment', $projectLogEnvironments, [
                    'class' => 'form-control',
                    'prompt' => Yii::t('frontend', '--Select Environment--'),
                ])
            ],
            [
                'attribute' => 'message',
                'filter' => Html::activeTextInput($searchModel, 'message', [
                    'class' => 'form-control',
                ]),
            ],
            [
                'attribute' => 'created_at',
                'filter' => \kartik\daterange\DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'Y-M-D'
                        ]
                    ]
                ]),
                'format' => ['datetime', 'medium']
                //intl format
                //php format
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}'
            ],
        ],
    ]) ?>
</div>
