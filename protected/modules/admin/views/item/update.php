<?php
$this->breadcrumbs=$breadcrumbs;

$this->menu=array(
	array('label'=>'List Item', 'url'=>array('index')),
	array('label'=>'Create Item', 'url'=>array('create')),
	array('label'=>'View Item', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Item', 'url'=>array('admin')),
);
?>

<h1>Изменить товар <?php echo $model->name; ?></h1>
 
<h3>Уже добавленные фото:</h3>
<i>В каталоге в качестве главного фото выступает первая фотография, вы можете изменить их порядок, перетаскивая мышью фотографии</i>
<?

  $str_js = "
        var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };
        
        $('#project-grid table.items tbody').sortable({
            forcePlaceholderSize: true,
            forceHelperSize: true,
            items: 'tr',
            update : function () {
                serial = $('#project-grid table.items tbody').sortable('serialize', {key: 'items[]', attribute: 'class'});
               
                $.ajax({
                    'url': '".Yii::app()->baseUrl."/admin/itemImage/sort',
                    'type': 'post',
                    'data': serial,
                    'success': function(data){
                    },
                    'error': function(request, status, error){
                        alert('К сожалению при сортировке возникает ошибка.Попробуйте снова!!!');
                    }
                });
            },
            helper: fixHelper
        }).disableSelection();
    ";
    Yii::app()->clientScript->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js');
    Yii::app()->clientScript->registerScript('sortable-project', $str_js);
	

 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid',
	'dataProvider'=>$dataProvider,
    'summaryText' => 'Всего : {count}',
    'rowCssClassExpression'=>'"items[]_{$data->id}"',
    'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
		'name',




		array(
        'type'=>'image',
        'value'=> '"/uploads/small_$data->filename"'),
		array(
			'header' => 'Операции',
			'class' => 'CButtonColumn', 
		    'template'=>'{delete}',
		    'deleteButtonUrl' => '"/admin/itemImage/delete/id/".$data->id',
		),
	),
));
?>