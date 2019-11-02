<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登陆</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <?php
    $cs = Yii::app()->clientScript;
    $themePath = Yii::app()->baseUrl;
    $cs
        ->registerCssFile($themePath . '/public/bootstrap/css/bootstrap.css')
        ->registerCssFile($themePath . '/public/bootstrap/css/bootstrap-theme.css')
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/login.css"
          media="screen, projection">
</head>
<body>
<!-- 页面头部 -->
<!-- header end -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="#" class="navbar-brand">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/cvslogo.png" alt="logo图片">
            </a>
            <span><?= Yii::t('cvs', '可口可乐新零售商超便利O2O追踪平台'); ?></span>
        </div>
<!--        <div class="login-english">-->
<!--           <span>-->
<!--                       --><?php
//                       if (Yii::app()->language == 'zh_cn') {
//                           echo CHtml::link('中', array('Site/ChangeLanguage', 'language' => 'zh_cn'), array('class' => 'changeRed'));
//                           ?>
<!--                           <i class="glyphicon glyphicon-resize-horizontal"></i>-->
<!--                           --><?php
//                           echo CHtml::link('En', array('Site/ChangeLanguage', 'language' => 'es'));
//                       } elseif (Yii::app()->language == 'es') {
//                           echo CHtml::link('中', array('Site/ChangeLanguage', 'language' => 'zh_cn'));
//                           ?>
<!--                           <i class="glyphicon glyphicon-resize-horizontal"></i>-->
<!--                           --><?php
//                           echo CHtml::link('En', array('Site/ChangeLanguage', 'language' => 'es'), array('class' => 'changeRed'));
//                       }
//                       ?>
<!--                   </span>-->
<!--        </div>-->
    </div>
</nav>
<!--   end header -->
<!--  页面主体 -->
<!--  main end  -->
<div class="main">
    <div class="container">
        <div class="form_div pull-right">
            <?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
                'id' => 'user-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'focus' => array($loginFormModel, 'username'),
                'htmlOptions' => array(
                    'class' => 'form-horizontal'
                )
            )); ?>
            <div class="form-group">
                <?php echo $form->textField($loginFormModel, 'email', array('class' => 'form-control', 'id' => 'inputEmail', 'placeholder' => Yii::t('cvs', '请输入邮箱'))); ?>
                <?php echo $form->error($loginFormModel, 'emaill'); ?>
                <i class="glyphicon glyphicon-envelope"></i>
            </div>
            <div class="form-group">
                <?php echo $form->passwordField($loginFormModel, 'pwd', array('class' => 'form-control', 'id' => 'inputPassword', 'placeholder' => Yii::t('cvs', '请输入密码'))); ?>
                <?php echo $form->error($loginFormModel, 'pwd'); ?>
                <i class="glyphicon glyphicon-lock"></i>
            </div>
            <div class="form-group">
                <div class="main-checkboxa">
                    <?php echo $form->checkBox($loginFormModel, 'rememberMe', array('id' => 'checkbox1')); ?>
                    <label for="checkbox1"></label>
                </div>
                <span class="text"><?= Yii::t('cvs', '自动登录') ?></span>
                <span class="text" style="float: right"><?= Yii::t('cvs', '忘记密码') ?>?</span>
            </div>
            <div class="form-group">
                <?php echo CHtml::submitButton(Yii::t('cvs', '登录'), array('class' => 'form-control')); ?>
            </div>
            <!--<div class="form-group">
               <input type="submit" value="注册" class="form-control btn-danger">
            </div>-->
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<!-- end main -->

</body>
</html>