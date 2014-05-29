<?php
class FieldProcessor
{
	static function getActiveField($model, $item, $form)
	{
		$modelName = get_class($model);
		switch ($item['type']) {
            case 'number':{
                echo '<input name="'.get_class($model).'['.$item['attribute'].']" type="number" value="'.$model->{$item['attribute']}.'" min="0" max="1" step="0.01" />';
            }
            break;
			case 'text' :
				{
				echo $form->textField($model, $item['attribute'], $item['htmlOptions']);
				}
				break;

            case 'password' :
				{
                    $model->$item['attribute'] = '';
				echo $form->passwordField($model, $item['attribute'], $item['htmlOptions']);
				}
				break;

			case 'textarea' :
				{
				echo $form->textArea($model, $item['attribute'], $item['htmlOptions']);
				}
				break;

            case 'autocomplete' :
            {
                if($item['fieldName']) {
                    $name = get_class($model) . $item['fieldName'];
                } else {
                    $name = 'ac_' . get_class($model);
                }

                $value = (
                    $_POST[$name] ?
                        $_POST[$name] : ($item['relation'] ? $model->{$item['relationName']}->{$item['value']} :
                        ($model->hasAttribute($item['textField']) ? $model->{$item['textField']}
                            : $item['value'])
                    )
                );

//                $value = ($_POST[$name] ? $_POST[$name] : $item['value']);

                Yii::app()->controller->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                                                                        'id' => $item['id']? $item['id'] : null,
                                                                                        'name' => $name,
                                                                                        'value' => $value,
                                                                                        'source' => $item['source'],
                                                                                        'options' => array(
                                                                                            'minLength' => '2',
                                                                                            'showAnim' => 'fold',
                                                                                            'select' => 'js: function(event, ui) {
                                                                                                    event.preventDefault();
                                                                                                    event.stopPropagation();
                                                                                                    this.value = ui.item.label;
                                                                                                    $(this).next().val(ui.item.' . $item['attribute'] . ');
                                                                                                    return false;
                                                                                            }',
                                                                                        ),
                                                                                        'htmlOptions' => array(
                                                                                            'maxlength' => 100,
                                                                                        ),
                                                                                   ));

                if($item['attributeName']) {
                    $params = array('name' => $item['attributeName']);
                } else {
                    $params = array();
                }
                echo $form->hiddenField($model, $item['attribute'], $params);
            }
                break;

			case 'dropdown' :
				{
                    $htmlOptions = $item['htmlOptions'];
                    if(empty($htmlOptions['empty'])) {
                        $htmlOptions['empty'] = 'Select ...';
                    }
                    
                    if(isset($item['data']['model'])) {
                        if(empty($item['data']['model'])) {
                            $data = array();
                        } else {
                            $data = CHtml::listData($item['data']['model'], $item['data']['valueField'], $item['data']['textField']);
                        }
                    } else {
                        $data = $item['data'];
                    }

                    if($item['fieldName']) {
                        echo CHtml::dropDownList($item['fieldName'],$model->{$item['attribute']},$data);
                    } else {
                        echo $form->dropDownList($model, $item['attribute'], $data, $htmlOptions);
                    }
				}
				break;

			case 'date' :
				{
				Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
																					  'value' => $model->{$item['attribute']} ? date('d/m/Y', strtotime($model->{$item['attribute']})) : '',
																					  'name' => get_class($model) . '[' . $item['attribute'] . ']',
																					  'language' => 'ru',
																					  'htmlOptions' => CMap::mergeArray(
																						  array('size' => 10, 'maxlength' => 15, 'style' => 'height:20px;'),
																						  $item['htmlOptions'] ? $item['htmlOptions'] : array()),
																					  'options' => CMap::mergeArray(array(
																														 'showAnim' => 'fold',
																														 'changeMonth' => true,
																														 'changeYear' => true,
																														 'yearRange' => '1980:' . (date('Y')+10),
																														 'dateFormat' => 'dd/mm/yy'
																													), $item['options'] ? $item['options'] : array()),
																				 ));
				}
				break;

			case 'textEditor' :
				{

				Yii::app()->controller->widget('application.extensions.tinymce.ETinyMce', array(
					'name'=> get_class($model).'['.$item['attribute'].']',
					'value' => $model->{$item['attribute']},
					'language' => 'ru',
					'mode' => 'text',
					'editorTemplate' => 'full',
					));

				// Yii::app()->controller->widget('application.extensions.ckeditor.CKEditor', array(
				// 																				'model' => $model,
				// 																				'attribute' => $item['attribute'],
				// 																				'language' => 'ru',
				// 																				'editorTemplate' => 'full',
				// 																		   ));

				}
				break;
            case 'file':{
                $path = CHtml::value($model,$item['attributePath'] ? $item['attributePath'] : 'path');
                if($path) {
                    echo  CHtml::image($path,'',array('style' => 'width:100px;height: 100px'));
                    echo "<div class='clear'></div>";
                }

                echo $form->fileField($model,$item['attribute'],'');
            }
            break;
            case 'filedoc':{
                $path = CHtml::value($model,$item['attributePath'] ? $item['attributePath'] : 'path');
                if($path) {
                    echo  CHtml::link('Download ( or open ) document...',$path,array('style' => 'color:red;'));
                    echo "<div class='clear'></div><br />";
                }

                echo $form->fileField($model,$item['attribute'],'');
                $value = $model->{$item['attribute']};
                if(strpos($value, 'http://') === false) {
                    $value = '';
                }
                echo " url: ".CHtml::textField((get_class($model).'['.$item['attribute'].']'),$value);
            }
            break;
            case 'view' :
            {
                echo Yii::app()->controller->renderPartial($item['viewName'],
                    array(
                         'model' => $model,
                         'item' => $item,
                         'form' => $form,
                    ), false, true);
            }
            break;

			default:
				echo $form->textField($model, $item['attribute'], $item['htmlOptions']);
		}

		if($item['after']) {
			echo $item['after'];
		}
		//		exit();
	}
}
