<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登陆</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo REC_CSS; ?>/login.css">
    <?php

	$cs = Yii::app()->clientScript;
	$themePath = Yii::app()->baseUrl;

	$cs
        ->registerCssFile($themePath.'/public/bootstrap/css/bootstrap.css')
        ->registerCssFile($themePath.'/public/bootstrap/css/bootstrap-theme.css')

    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/login.css" media="screen, projection">
</head>
<body>
   <!-- 页面头部 -->
   <!-- header end -->
   <nav class="navbar navbar-default navbar-fixed-top">
       <div class="container">
           <div class="navbar-header">
               <a href="#" class="navbar-brand"
                  style=""><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.jpg" alt="logo图片"></a>
           </div>
       </div>
   </nav>
   <!--   end header -->
   <!--  页面主体 -->
   <!--  main end  -->
   <div class="main">
        <div class="container">
            <div class="form_div pull-right">
                <?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
                    'id'=>'user-form',
                    'enableAjaxValidation'=>true,
                    'enableClientValidation'=>true,
                    'focus'=>array($loginFormModel,'username'),
                    'htmlOptions'=>array(
                        'class'=>'form-horizontal'
                    )
                )); ?>
                    <div class="form-group">
                        <?php echo $form->textField($loginFormModel,'email',array('class'=>'form-control','id'=>'inputEmail','placeholder'=>'请输入邮箱'));?>
                        <i class="glyphicon glyphicon-envelope"></i>
                    </div>
                    <div class="form-group">
                         <?php echo $form->passwordField($loginFormModel,'pwd',array('class'=>'form-control','id'=>'inputPassword','placeholder'=>'请输入密码'));?>
                        <?php echo $form->error($loginFormModel,'pwd'); ?>
                         <i class="glyphicon glyphicon-lock"></i>
                    </div>
                    <div class="form-group">
                        <div class="main-checkboxa">
                            <?php echo $form->checkBox($loginFormModel,'rememberMe',array('id'=>'checkbox1')); ?>
                            <label for="checkbox1"></label>
                        </div>
                        <span class="text">下次自动登录</span>
                        <a href="#" class="wj">忘记密码?</a>
                    </div>
                    <div class="form-group">
                        <?php echo CHtml::submitButton('登录',array('class'=>'form-control '));?>

                    </div>
                    <!--<div class="form-group">
                       <input type="submit" value="注册" class="form-control btn-danger">
                    </div>-->
                    <?php $this->endWidget(); ?>
            </div>
        </div>
   </div>
   <!-- end main -->
   <script src="http://code.jquery.com/jquery.js"></script>
   <script src="../public/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>