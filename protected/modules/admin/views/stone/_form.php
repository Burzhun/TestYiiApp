<?php
/* @var $this TireController */
/* @var $model Tire */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tire-form',
	'enableAjaxValidation'=>false,
	    'htmlOptions' => array(
            'enctype' => 'multipart/form-data')
)); ?>



	<?php echo $form->errorSummary($model); ?>
 
 	
	 
 

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->fileField($model,'image',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>
 

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->