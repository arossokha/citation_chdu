<?php
/* @var $this ArticleController */
/* @var $model Article */

$this->breadcrumbs=array(
	'Articles'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Article', 'url'=>array('index')),
	array('label'=>'Create Article', 'url'=>array('create')),
	array('label'=>'Update Article', 'url'=>array('update', 'id'=>$model->articleId)),
	array('label'=>'Delete Article', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->articleId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Article', 'url'=>array('admin')),
);
?>


<h1>Article Card: <?php echo $model->name; ?></h1>
<div class="author-info">
	<div class="author-about">
		<p><b>Category:</b> <?php echo $model->category->name; ?></p>
		<p><b>Authors:</b> <?php echo $model->getAuthorsList(true,true); ?></p>
		<p><b>Index index:</b> <?php echo $model->index; ?></p>
		<p><b style="float:left;">Download link:</b> 
			<span style="float: left;margin-left: 20px;;">
				<a href="<?php echo $model->file;?>">
					<img style="width: 30px; float: left;" src='/images/pdf.png' />
				</a>
			</span>
		</p>
	</div>
</div>

<?php 
if($model->getArticlesCitation()) {
?>
<div class="articles-list">
	<table class="index-table">
		<tr>
			<td>Raiting</td>
			<td>Article</td>
			<td>Year</td>
			<td>Index Citation</td>
			<td>Download link</td>
		</tr>
	<?php
		$articles = $model->getArticlesCitation();
		if(count($articles)>1) {
			usort($articles, function($a,$b) {
				if ($a->index == $b->index) {
			        return 0;
			    }
	    		return ($a->index < $b->index) ? 1 : -1;
			});
		}
		foreach ($articles as $rating => $article) {
			echo "<tr>";
				echo "<td>".($rating+1)."</td>";
				echo "<td>".CHtml::link($article->name,Yii::app()->controller->createUrl("/article/{$article->primaryKey}"))."</td>";
				echo "<td>{$article->year}</td>";
				echo "<td>{$article->index}</td>";
				echo "<td><a href='{$article->file}'><img src='/images/pdf.png'></a></td>";
			echo "</tr>";
		}
	?>
	</table>
</div>
<?php 
} else {
	echo "<br /><span style='text-align: center;display: block;'>To this article is not referenced!</span>";
}
?>
