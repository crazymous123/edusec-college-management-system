<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<!--<div class="row">
		<?php echo $form->label($model,'batch_id'); ?>
		<?php echo $form->textField($model,'batch_id'); ?>
	</div>-->

	<div class="row">
		<?php echo $form->label($model,'batch_name'); ?>
		<?php echo $form->textField($model,'batch_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>
<br/>
	<div class="row">
		<?php echo $form->label($model,'batch_organization_id'); ?>
		<?php echo $form->textField($model,'batch_organization_id'); ?>
	</div>

	<!--<div class="row">
		<?php echo $form->label($model,'batch_created_by'); ?>
		<?php echo $form->textField($model,'batch_created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'batch_creation_date'); ?>
		<?php echo $form->textField($model,'batch_creation_date'); ?>
	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
