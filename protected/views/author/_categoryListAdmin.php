<script>
    var next = 0;
    function getNext() {
        return next++;
    }
    $(document).ready(function () {
        $('.deleteRowOfModel').live('click', function () {
            if ($('.rowModelDiv').size() > 1) {
                $(this).parent().remove();
            }
        });

        $('.addRowOfModel').live('click', function () {
            var div = $(this).parent();
            var newDiv = $(div).clone();
            newDiv.children('link,script').remove();
            var newId = $(newDiv).find('input').attr('id') + getNext();
            $(newDiv).find('input:first').attr('id', newId).val('');
            $(newDiv).find('input:hidden').val('');
            $(div).after(newDiv);

        });
    });
</script>
<?php
/**
 *
 * Date Time: 2/25/13 8:16 PM
 */
//echo "<pre>";
//CVarDumper::dump($item);
//CVarDumper::dump($form);
//CVarDumper::dump($model);
//echo "</pre>";
$relationName = $item['data']['relation'];
$curModels = $model->{$relationName};

// CVarDumper::dump($curModels);

if(!$curModels) {
    $relations = $model->relations();
    if(!$relations[$relationName]) {
        throw new CException('No relation with this name');
    }
    $relation = $relations[$relationName];

    $relationModel = $relation[1];

    $curModels[] = new $relationModel();
}

foreach ($curModels as $curModel) {
    echo "<div class='rowModelDiv'>";
    FieldProcessor::getActiveField($curModel, $item['data'], $form);
    echo " " . CHtml::link('Add', 'javascript:void(0);', array('class' => 'addRowOfModel'));
    echo " " . CHtml::link('Delete', 'javascript:void(0);', array('class' => 'deleteRowOfModel'));
    echo "</div>";
}

