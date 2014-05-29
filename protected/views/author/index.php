<?php
$this->breadcrumbs=array(
	'Authors',
);

$this->menu=array(
	array('label'=>'Create Author', 'url'=>array('create')),
	array('label'=>'Manage Author', 'url'=>array('admin')),
);
?>

<h1>Authors</h1>

<?php 

if(count($data)) {
    $gap = '<br /><br /><br />';
    $num = 0;
    foreach ($data as $categoryName => $dataProvider) {
        if($dataProvider->getTotalItemCount()) {
            if($num){echo $gap;} else {$num++;}
            echo "<h2>{$categoryName}</h2>";
            $this->widget('zii.widgets.CListView', array(
                'dataProvider'=>$dataProvider,
                'itemView'=>'_view',
            ));
        }
    }
} else {
    echo "<h2>Авторов нет</h2>";
}
