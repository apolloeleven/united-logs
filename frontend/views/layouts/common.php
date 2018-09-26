<?php
/**
 * @var $this    yii\web\View
 * @var $content string
 */

use frontend\assets\FrontendAsset;
use backend\modules\system\models\SystemLog;
use backend\widgets\Menu;
use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\log\Logger;
use yii\widgets\Breadcrumbs;

$bundle = FrontendAsset::register($this);

?>

<?php $this->beginContent('@frontend/views/layouts/base.php'); ?>

<div class="wrapper">
    <!-- header logo: style can be found in header.less -->
    <nav class="navbar navbar-default navbar-header header">
        <a class="navbar-brand" href="<?php echo Yii::getAlias('@frontendUrl') ?>">
            <div class="navbar-brand-img"></div>
            <!--<img src="img/logo/lobiadmin-logo-text-white-32.png" class="hidden-xs" alt="" />-->
        </a>
        <!--Menu show/hide toggle button-->
        <ul class="nav navbar-nav pull-left show-hide-menu">
            <li>
                <a href="#" class="border-radius-0 btn font-size-lg" data-action="show-hide-sidebar">
                    <i class="fa fa-bars"></i>
                </a>
            </li>
        </ul>
        <div class="navbar-items">
            <!--User avatar dropdown-->
            <ul class="nav navbar-nav navbar-right user-actions">
                <li class="dropdown">
                    <?php if (Yii::$app->user->identity): ?>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle,
                                'img/anonymous.jpg')) ?>"
                                 class="user-avatar">
                            <span><?php echo Yii::$app->user->identity->username ?> <i class="caret"></i></span>
                        </a>
                    <?php endif; ?>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo Url::to(['/sign-in/profile']) ?>"><span
                                        class="glyphicon glyphicon-user"></span> &nbsp;&nbsp;Profile</a>
                        </li>
                        <li><a href="<?php echo Url::to(['/sign-in/account']) ?>"><span
                                        class="fa fa-key"></span> &nbsp;&nbsp;Account</a>
                        </li>
                        <li class="divider"></li>
                        <a href="<?php echo Url::to(['user/sign-in/logout']) ?>" data-method="post">
                            <span class="glyphicon glyphicon-off"></span>
                            &nbsp;&nbsp;<?php echo Yii::t('backend', 'Log out') ?>
                        </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="clearfix-xxs"></div>
        <div class="navbar-items-2">
            <!--Choose languages dropdown-->
            <ul class="nav navbar-nav navbar-actions">
                <li>
                    <div class="dropdown-menu dropdown-notifications dropdown-timeline notification-news border-1 animated-fast flipInX">
                        <div class="notifications-heading border-bottom-1 bg-white">
                            <?php echo Yii::t('backend', 'Timeline') ?>
                        </div>
                        <div class="notifications-footer border-top-1 bg-white text-center">
                            <?php echo Html::a(Yii::t('backend', 'View all'), ['/timeline-event/index']) ?>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </nav>

    <div class="menu">
        <nav>
            <?php

            echo Menu::widget([
                'options' => ['class' => 'sidebar-menu'],
                'linkTemplate' => '<a href="{url}"><i class="{icon} menu-item-icon"></i><span class="inner-text">{label}</span>{badge}</a>',
                'activateParents' => true,
                'activeCssClass' => 'opened',
                'items' => [
                    [
                        'label' => Yii::t('backend', 'Projects'),
                        'url' => ['/admin/project/index'],
                        'icon' => 'fa fa-edit'
                    ],
                ]
            ]);
            ?>
        </nav>
        <div class="menu-collapse-line">
            <!--Menu collapse/expand icon is put and control from LobiAdmin.js file-->
            <div class="menu-toggle-btn" data-action="collapse-expand-sidebar"></div>
        </div>
    </div>

    <div id="main">
        <!--        <div id="ribbon" class="hidden-print">-->
        <!--            <a href="#dashboard" class="btn-ribbon" data-container="#main" data-toggle="tooltip"-->
        <!--               data-title="Show dashboard"><i class="fa fa-home"></i></a>-->
        <!--            <span class="vertical-devider">&nbsp;</span>-->
        <!--            <button class="btn-ribbon" data-container="#main" data-action="reload" data-toggle="tooltip"-->
        <!--                    data-title="Reload content by ajax"><i class="fa fa-refresh"></i></button>-->
        <!--            --><?php //echo Breadcrumbs::widget([
        //                'homeLink' => false,
        //                'tag' => 'ol',
        //                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        //            ]) ?>
        <!--        </div>-->
        <div id="content">
            <h1>
                <?php echo $this->title ?>
                <?php if (isset($this->params['subtitle'])): ?>
                    <small><?php echo $this->params['subtitle'] ?></small>
                <?php endif; ?>
            </h1>

            <?php if (Yii::$app->session->hasFlash('alert')): ?>
                <?php echo Alert::widget([
                    'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
                    'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
                ]) ?>
            <?php endif; ?>

            <?php echo $content ?>
        </div>
    </div>
</div><!-- ./wrapper -->

<?php $this->endContent(); ?>
