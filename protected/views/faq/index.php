<?php
$this->breadcrumbs=array(
	'Faqs',
);

$this->menu=array(
	array('label'=>'Create Faq', 'url'=>array('create')),
	array('label'=>'Manage Faq', 'url'=>array('admin')),
);
?>

<?php $this->pageTitle="Faq - InGruz";  ?> <h1>Faq</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=> $dataProvider,
	'itemView'=>'_view',
	'template' => '{items}'
)); ?>
