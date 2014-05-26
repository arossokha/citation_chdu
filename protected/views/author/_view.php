<?php
/* @var $this AuthorController */
/* @var $data Author */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('authorId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->authorId), array('view', 'id'=>$data->authorId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fullName')); ?>:</b>
	<?php echo CHtml::encode($data->fullName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('photo')); ?>:</b>
	<?php echo CHtml::encode($data->photo); ?>
	<br />


</div>