<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectSubscriber */
/* @var $form yii\widgets\ActiveForm */
/* @var $projectLogLevels [] */
/* @var $project common\models\Project */
?>

<div class="project-subscriber-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'project_id')->hiddenInput(['value' => $project->id])->label(false) ?>

    <?= $form->field($model, 'level')->dropDownList($projectLogLevels,[
        'multiple' => true
    ])?>
    
    <?= $form->field($model, 'email')->widget(\pudinglabs\tagsinput\TagsinputWidget::className(),[
        'options' => [],
        'clientOptions' => [],
        'clientEvents' => [],
    ]) ?>

    <?= $form->field($model, 'category')->widget(\pudinglabs\tagsinput\TagsinputWidget::className(),[
        'options' => [],
        'clientOptions' => [],
        'clientEvents' => [],
    ]) ?>

    <?= $form->field($model, 'environment')->widget(\pudinglabs\tagsinput\TagsinputWidget::className(),[
        'options' => [],
        'clientOptions' => [],
        'clientEvents' => [],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('frontend', 'Create') : Yii::t('frontend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
