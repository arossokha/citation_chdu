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
<form action="" method="post" class="bootstrap-frm article-filter">
    <h1>Filter Form 
        <span>Please fill fields you want to filter.</span>
    </h1>
    <label>
        <span>Author name:</span>
        <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                'name'=>'autohorName',
                'source'=>'/site/authorautocomplete',
                'options' => array(
                    'minLength' => '2',
                    'showAnim' => 'fold',
                    'select' => 'js: function(event, ui) {
                            $(this).parent().children(\'input[type="hidden"]\').val(ui.item.authorId);
                            $.post("/article",$(".article-filter").serialize(),
                                function(data){
                                        html = $(data).find(\'.top-table\').html();
                                        $(\'.top-table\').html(html);
                                    }
                                    );
                            return false;
                    }',
                ),
                'htmlOptions'=>array(
                    'style'=>'height:20px;',
                ),
            ));
            echo CHtml::hiddenField('authorId');
        ?>
    </label>
    
    <label>
        <span>Article name:</span>
        <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                'name'=>'articleName',
                'value' => $_REQUEST['Article']['name'],
                'source'=>'/site/articleautocomplete',
                'options' => array(
                    'minLength' => '2',
                    'showAnim' => 'fold',
                    'select' => 'js: function(event, ui) {
                            $(this).parent().children(\'input[type="hidden"]:first\').val(ui.item.articleId);
                            $.get("/article",$(".article-filter").serialize(),
                                function(data){
                                        html = $(data).find(\'.top-table\').html();
                                        $(\'.top-table\').html(html);
                                    });
                    }',
                    'search' => 'js: function(event, ui) {
                            $(this).parent().children(\'input[type="hidden"]:last\').val($(event.currentTarget).val());
                            $.get("/article",$(".article-filter").serialize(),
                                function(data){
                                        html = $(data).find(\'.top-table\').html();
                                        $(\'.top-table\').html(html);
                                    });
                    }',
                    // 'change' => 'js: function(event, ui) {
                    //         $(this).parent().children(\'input[type="hidden"]:last\').val($(event.currentTarget).val());
                    //         $.get("/article",$(".article-filter").serialize(),
                    //             function(data){
                    //                     html = $(data).find(\'.top-table\').html();
                    //                     $(\'.top-table\').html(html);
                    //                 });
                    // }',
                ),
                'htmlOptions'=>array(
                    'style'=>'height:20px;',
                ),
            ));
            echo CHtml::hiddenField('Article[articleId]');
            echo CHtml::hiddenField('Article[name]');
        ?>
    </label>
    
     <label>
        <span>Category:</span>
        <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                'name'=>'categoryName',
                'source'=>'/site/categoryautocomplete',
                'options' => array(
                    'minLength' => '2',
                    'showAnim' => 'fold',
                    'select' => 'js: function(event, ui) {
                            $(this).parent().children(\'input[type="hidden"]\').val(ui.item.categoryId);
                            $.post("/article",$(".article-filter").serialize(),
                                function(data){
                                        html = $(data).find(\'.top-table\').html();
                                        $(\'.top-table\').html(html);
                                    }
                                    );
                            return false;
                    }',
                ),
                'htmlOptions'=>array(
                    'style'=>'height:20px;',
                ),
            ));

            echo CHtml::hiddenField('Article[categoryId]');
        ?>
    </label>  
     <label>
        <span>&nbsp;</span>
        <span>&nbsp;</span>
        <input type="reset" class="button reset-filter-articles" value="Clear" />
    </label>
</form>
<div class="top-table">
    <h1>Articles</h1>
    <?php
        // Article::updateAllIndexes();

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
                    'type' => 'raw',
                    'value'=>'CHtml::link($data->name,Yii::app()->controller->createUrl("/article/{$data->primaryKey}"));',
                ),
                array(
                    'name'=>'Category',
                    'value'=>'$data->category->name',
                ),
                array(
                    'name'=>'Year',
                    'value'=>'$data->year',
                ),
                'index',
                array(
                    'name'=>'Download link',
                    'type' => 'raw',
                    'value'=>'"<a href=\"{$data->file}\"><img src=\'/images/pdf.png\'>"',
                ),
            ),
        ));
    ?>
</div>