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
<form action="" method="post" class="bootstrap-frm">
    <h1>Filter Form 
        <span>Please fill fields you want to filter.</span>
    </h1>
     <label>
        <span>Category:</span>
        <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                'name'=>'categoryId',
                'source'=>'/site/categoryautocomplete',
                'options' => array(
                    'minLength' => '2',
                    'showAnim' => 'fold',
                    'select' => 'js: function(event, ui) {
                            event.preventDefault();
                            event.stopPropagation();
                            console.dir(ui.item.categoryId);
                            $.post(document.location.href,{\'categoryId\':ui.item.categoryId},
                                function(data){
                                        html = $(data).find(\'.author-data\').html();
                                        $(\'.author-data\').html(html);
                                    }
                                    );
                            return false;
                    }',
                ),
                'htmlOptions'=>array(
                    'style'=>'height:20px;',
                ),
            ));
        ?>
    </label>
    <label>
        <span>&nbsp;</span>
        <span>&nbsp;</span>
        <input type="reset" class="button reset-filter-authors" value="Clear" />
    </label>
</form>
<div class="author-data">
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
        } else {
            if(isset($_REQUEST['categoryId'])) {
                echo "<h2>{$categoryName}</h2>";
                echo "<h2>No authors</h2>";
            }
        }
    }
} else {
    echo "<h2>No available category</h2>";
}
?>
</div>