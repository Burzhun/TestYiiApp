<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	$this->name => array('admin') ,
);


?>

<h1><? echo $this->name." - изменить"?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>