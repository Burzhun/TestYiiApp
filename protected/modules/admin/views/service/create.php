<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Управление услугами' => array('/admin/service'),
	'Добавить',
);



?>

<h1>Добавить </h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>