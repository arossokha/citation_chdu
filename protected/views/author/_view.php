<div class="item-container">
<br />
    <b> &nbsp;&nbsp;&nbsp;<?php echo CHtml::encode($data->index); ?></b>
    <?php 
        $image = $data->photo ? : '/images/author.png';
        $imgData = getimagesize(Yii::getPathOfAlias('webroot').$image);
        if($imgData[1] > $imgData[0]) {
            $options = array('style' => 'height:190px;');
        } elseif($imgData[1] <= $imgData[0]) {
            $options = array('style' => 'width:190px;');
        } 
        echo CHtml::link(CHtml::image($image,$data->fullName,$options), array('view', 'id'=>$data->authorId));
        ?>
    <br />
    <div><?php echo CHtml::encode($data->fullName); ?></div>
    <div><?php echo CHtml::link(CHtml::encode($data->fullName), array('view', 'id'=>$data->authorId)); ?></div>
</div>