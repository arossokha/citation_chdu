<?php
/* @var $this AuthorController */
/* @var $model Author */

$this->breadcrumbs=array(
	'Authors'=>array('index'),
	$model->fullName,
);

$this->menu=array(
	array('label'=>'List Author', 'url'=>array('index')),
	array('label'=>'Create Author', 'url'=>array('create')),
	array('label'=>'Update Author', 'url'=>array('update', 'id'=>$model->authorId)),
	array('label'=>'Delete Author', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->authorId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Author', 'url'=>array('admin')),
);
?>

<h1>Profile Card: <?php echo $model->fullName; ?></h1>
<div class="author-info">
	<?php 
        $image = $model->photo ? : '/images/author.png';
        $imgData = getimagesize(Yii::getPathOfAlias('webroot').$image);
        if($imgData[1] > $imgData[0]) {
            $options = array('style' => 'height:190px;');
        } elseif($imgData[1] <= $imgData[0]) {
            $options = array('style' => 'width:190px;');
        } 
        echo CHtml::link(CHtml::image($image,$model->fullName,$options), array('view', 'id'=>$model->authorId));
    ?>
	<div class="author-about">
		<p><b>Name:</b> <?php echo $model->fullName; ?></p>
		<p><b>Work count:</b> <?php echo $model->getWorkCount(); ?></p>
		<p><b>Middle index:</b> <?php echo $model->index; ?></p>
	</div>
</div>
<?php 
if($model->getWorkCount()) {
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
		$articles = array_map(function($item){
			return $item->article;
		},$model->articles);
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
				echo "<td>{$article->name}</td>";
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
	echo "Статей нет!";
}
?>

