<?php
/* @var $this ArticleController */
/* @var $data Article */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('articleId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->articleId), array('view', 'id'=>$data->articleId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('categoryId')); ?>:</b>
	<?php echo CHtml::encode($data->categoryId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('index')); ?>:</b>
	<?php echo CHtml::encode($data->index); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file')); ?>:</b>
	<?php echo CHtml::encode($data->file); ?>
	<br />


</div>