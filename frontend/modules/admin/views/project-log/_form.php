<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectLog */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="project-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'project_id')->textInput() ?>

    <?php echo $form->field($model, 'level')->textInput() ?>

    <?php echo $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'environment')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'message')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'params')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('frontend', 'Create') : Yii::t('frontend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
