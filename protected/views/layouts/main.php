<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<header>
	<div class="headmenu">
		<div id="logo">
			<a href="/"><img src="css/logo.gif"></a>
			
		</div>

		<div id="mainmenu">
			<?php $this->widget('zii.widgets.CMenu',array(
				'items'=>array(
					array('label'=>'Home', 'url'=>array('/site/index')),
					array('label'=>'Authors', 'url'=>array('/site/page', 'view'=>'authors')),
					array('label'=>'Articles', 'url'=>array('/site/page', 'view'=>'articles')),
					array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				),
			)); ?>
		</div><!-- mainmenu -->
	</div>
		<div class="search">
			<input type="text" class="main-search" placeholder="Search by article name...">
			<input type="submit" class="main-search-button"  value="">
		</div>

		
		
	</header><!-- header -->

<div class="container" id="page">


	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	

</div><!-- page -->

<footer>
		<p>Copyright &copy; <?php echo date('Y'); ?> by My Company.
		<p>All Rights Reserved.
		<p><?php echo Yii::powered(); ?>
</footer><!-- footer -->

</body>
</html>
