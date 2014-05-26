<?php
/* @var $this ArticleController */
/* @var $model Article */

$this->breadcrumbs=array(
	'Articles'=>array('index'),
	$model->name=>array('view','id'=>$model->articleId),
	'Update',
);

$this->menu=array(
	array('label'=>'List Article', 'url'=>array('index')),
	array('label'=>'Create Article', 'url'=>array('create')),
	array('label'=>'View Article', 'url'=>array('view', 'id'=>$model->articleId)),
	array('label'=>'Manage Article', 'url'=>array('admin')),
);
?>

<h1>Update Article <?php echo $model->articleId; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>