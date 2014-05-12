<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div class="menu-row">
	<a href="<?php echo $this->createUrl('/site/page', array('view'=>'authors')); ?>">
		<div class="menu-container">
			<img src="img/authors.png">
			<div>Authors</div>
		</div>
	</a>
	<a href="<?php echo $this->createUrl('/site/page', array('view'=>'articles')); ?>">
		<div class="menu-container">
			<img src="img/articles.png">
			<div>Articles</div>
		</div>
	</a>
</div>

<div >
	<h2>Top articles</h2>
	<table class="index-table">
		<tr>
			<td>Raiting</td>
			<td>Author</td>
			<td>Article</td>
			<td>Index Citation</td>
			<td>Download link</td>
		</tr>
		<tr>
			<td>1</td>
			<td>Test</td>
			<td>Test</td>
			<td>0.7788</td>
			<td><a href="#"><img src="/img/pdf.png">></a><td>
		</tr>
		<tr>
			<td>2</td>
			<td>Test</td>
			<td>Test</td>
			<td>0.7688</td>
			<td><a href="#"><img src="/img/pdf.png">></a><td>
		</tr>
		<tr>
			<td>3</td>
			<td>Test</td>
			<td>Test</td>
			<td>0.6688</td>
			<td><a href="#"><img src="/img/pdf.png">></a><td>
		</tr>
		<tr>
			<td>4</td>
			<td>Test</td>
			<td>Test</td>
			<td>0.6588</td>
			<td><a href="#"><img src="/img/pdf.png">></a><td>
		</tr>
		<tr>
			<td>5</td>
			<td>Test</td>
			<td>Test</td>
			<td>0.6488</td>
			<td><a href="#"><img src="/img/pdf.png">></a><td>
		</tr>
		<tr>
			<td>5</td>
			<td>Test</td>
			<td>Test</td>
			<td>0.5688</td>
			<td><a href="#"><img src="/img/pdf.png">></a><td>
		</tr>
	</table>
</div>
