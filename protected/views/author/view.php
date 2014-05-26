<?php
/* @var $this AuthorController */
/* @var $model Author */

$this->breadcrumbs=array(
	'Authors'=>array('index'),
	$model->authorId,
);

$this->menu=array(
	array('label'=>'List Author', 'url'=>array('index')),
	array('label'=>'Create Author', 'url'=>array('create')),
	array('label'=>'Update Author', 'url'=>array('update', 'id'=>$model->authorId)),
	array('label'=>'Delete Author', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->authorId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Author', 'url'=>array('admin')),
);
?>

<h1>View Author #<?php echo $model->authorId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'authorId',
		'fullName',
		'photo',
	),
)); ?>
