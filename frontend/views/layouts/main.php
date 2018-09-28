<?php
/**
 * @var $this yii\web\View
 */

use backend\widgets\Menu;
use yii\bootstrap\Alert;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => '/favicon.png']);
$userIdentity = Yii::$app->user->identity;
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
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo $userIdentity->userProfile->getAvatar('/img/anonymous.jpg') ?>"
                                 class="user-avatar">
                            <span><?php echo $userIdentity->username ?> <i class="caret"></i></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="<?php echo Url::to(['/user/sign-in/profile']) ?>"><span
                                            class="glyphicon glyphicon-user"></span><?php echo Yii::t('frontend', 'Profile') ?></a>
                            </li>
                            <li>
                                <a href="<?php echo Url::to(['/user/sign-in/account']) ?>"><span
                                            class="fa fa-key"></span><?php echo Yii::t('frontend', 'Account') ?></a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo Url::to(['/user/sign-in/logout']) ?>" data-method="post">
                                    <span class="glyphicon glyphicon-off"></span>
                                    &nbsp;&nbsp;<?php echo Yii::t('frontend', 'Log out') ?>
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
                                <?php echo Yii::t('frontend', 'Timeline') ?>
                            </div>
                            <div class="notifications-footer border-top-1 bg-white text-center">
                                <?php echo Html::a(Yii::t('frontend', 'View all'), ['/timeline-event/index']) ?>
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
                            'label' => Yii::t('frontend', 'Projects'),
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
            <div id="ribbon" class="hidden-print">
                <?php
                echo Breadcrumbs::widget([
                    'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
//                'links' => [
//                    [
//                        'label' => 'Projects',
//                        'url' => ['/admin/project']
//                    ],
//                    [
//                        'label' => $project->name,
//                        'url' => Url::to(['/admin/project/view', 'id' => $project->id])
//                    ],
//                    'Logs',
//                ],
                ]);
                ?>
            </div>


            <div id="content">
                <h2>
                    <?php echo $this->title ?>
                    <?php if (isset($this->params['subtitle'])): ?>
                        <small><?php echo $this->params['subtitle'] ?></small>
                    <?php endif; ?>
                </h2>

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