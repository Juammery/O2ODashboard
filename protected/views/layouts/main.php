<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!-- [if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif] -->
	<link rel="shortcut icon" type="images/x-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/cvslogo.png">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css?v=1.0.10">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">
	<?php
	$cs = Yii::app()->clientScript;
	$themePath = Yii::app()->baseUrl;

	$cs
		->registerCssFile($themePath.'/css/chosen.css')
		->registerCssFile($themePath.'/public/bootstrap/css/bootstrap.css')
		->registerCssFile($themePath.'/public/bootstrap/css/bootstrap-theme.css')
		->registerCoreScript('jquery',CClientScript::POS_END)
		// ->registerCoreScript('jquery.ui',CClientScript::POS_END)
		->registerScriptFile($themePath.'/public/bootstrap/js/bootstrap.min.js',CClientScript::POS_END)
		->registerScriptFile($themePath.'/js/chosen.jquery.js')
		->registerScriptFile($themePath.'/js/echarts.min.js')
		->registerCssFile($themePath. '/public/datepicker/datepicker3.css')
		->registerScriptFile($themePath. "/public/datepicker/bootstrap-datepicker.js")
		->registerScriptFile($themePath. "/public/datepicker/bootstrap-datepicker.zh-CN.js")
		->registerScriptFile($themePath. "/public/layer/layer.js")
		->registerCssFile($themePath.'/css/index.css?v=1.0.10')

	?>

	<title><?=yii::app()->name; ?></title>
	<style>
		.layui-layer-prompt textarea.layui-layer-input{
			resize: none;
			height: 36px;
			line-height: 32px;
			white-space: nowrap;
			overflow: hidden;

		}
	</style>
</head>

<body>

<div class="container" id="page" style="padding: 0;background-color: #F3F2FF;">

	<?php echo $content; ?>

	<div class="clear"></div>
</div><!-- page -->
<div id="canvas-box"></div>
</body>
</html>
