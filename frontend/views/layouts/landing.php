<?php
/**
 * Created by PhpStorm.
 * User: heckslay
 * Date: 9/28/18
 * Time: 12:29 PM
 */
?>
<?php $this->beginContent('@frontend/views/layouts/base.php'); ?>

<?php echo \yii\helpers\Html::a(Yii::t('frontend', 'Login'), ['/user/sign-in/login']);
?>

<?php echo $content ?>

<?php $this->endContent(); ?>
