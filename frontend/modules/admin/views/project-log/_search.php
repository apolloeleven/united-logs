<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\search\ProjectLogSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="project-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'project_id') ?>

    <?php echo $form->field($model, 'level') ?>

    <?php echo $form->field($model, 'ip') ?>

    <?php echo $form->field($model, 'category') ?>

    <?php // echo $form->field($model, 'environment') ?>

    <?php // echo $form->field($model, 'message') ?>

    <?php // echo $form->field($model, 'params') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('frontend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('frontend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
