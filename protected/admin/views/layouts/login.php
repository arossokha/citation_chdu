<?php
/**
 * admin panel login layout
 * @author:  
 */

$this->beginContent('//layouts/main');
?>
<style>
	#wrapper {
		background: #010101 !important;
	}
</style>
<div id="popup">
	<?php
	echo $content;
	?>
</div>
<?php $this->endContent(); ?>