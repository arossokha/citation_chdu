<?php
/* @var $this ArticleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Articles',
);

$this->menu=array(
	array('label'=>'Create Article', 'url'=>array('create')),
	array('label'=>'Manage Article', 'url'=>array('admin')),
);
?>

<div class="top-table">
    <h1>Articles</h1>
    <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'article-grid',
            'htmlOptions' => array('class' => 'article-table'),
            'dataProvider'=> $model->search(),
            'columns'=>array(
                array(
                    'name'=>'Rating',
                    'type'=>'raw',
                    'value'=>'($row+1)',
                ),
                array(
                    'name'=>'Author',
                    'value'=>'$data->getAuthorsList()',
                ),
                array(
                    'name'=>'Article',
                    'value'=>'$data->name',
                ),
                array(
                    'name'=>'Category',
                    'value'=>'$data->category->name',
                ),
                array(
                    'name'=>'Year',
                    'value'=>'$data->year',
                ),
                array(
                    'name'=>'Index Citation',
                    'value'=>'$data->index',
                ),
                array(
                    'name'=>'Download link',
                    'type' => 'raw',
                    'value'=>'"<a href=\"{$data->file}\"><img src=\'/images/pdf.png\'>"',
                ),
            ),
        ));
    ?>
</div>