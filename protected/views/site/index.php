<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div class="menu-row">
	<a href="<?php echo $this->createUrl('/author'); ?>">
		<div class="menu-container">
			<img src="/images/authors.png">
			<div>Authors</div>
		</div>
	</a>
	<a href="<?php echo $this->createUrl('/article'); ?>">
		<div class="menu-container">
			<img src="/images/articles.png">
			<div>Articles</div>
		</div>
	</a>
	<a href="<?php echo $this->createUrl('/site/diagram'); ?>">
		<div class="menu-container">
			<img src="/images/graph.png">
			<div>Diagrams</div>
		</div>
	</a>
</div>

<div class="top-table">
	<h2>Top articles</h2>
	<table class="index-table">
		<tr>
			<td>Raiting</td>
			<td>Author</td>
			<td>Article</td>
			<td>Category</td>
			<td>Year</td>
			<td>Index Citation</td>
			<td>Download link</td>
		</tr>

		<?php
			foreach (Article::model()->findAll(array(
				'limit' => '10',
				'order' => '`index` DESC',
				)) as $key => $article) {
				echo "<tr>";
					echo "<td>".($key+1)."</td>";
					echo "<td>".$article->getAuthorsList()."</td>";
					echo "<td>{$article->name}</td>";
					echo "<td>{$article->category->name}</td>";
					echo "<td>{$article->year}</td>";
					echo "<td>{$article->index}</td>";
					echo "<td><a href=\"{$article->file}\"><img src='/images/pdf.png'></td>";
				echo "</tr>";
			}
		?>
	</table>
	<br/>
	<a href="<?php echo $this->createUrl('/article'); ?>">View all -></a>
</div>
