<?php
/**
 * @var $this yii\web\View
 */
?>
<?php $this->beginContent('@frontend/views/layouts/common.php'); ?>
    <div class="box">
        <div class="box-body">
            <?php echo $content ?>
        </div>
    </div>
<?php $this->endContent(); ?>