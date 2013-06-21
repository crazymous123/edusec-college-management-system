<div class = "test" style="display:none;">
<?php        
if($model->scenario == 'insert')
$name = "Add Batch";
else
$name = "Edit Batch";
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'mydialog',
	// additional javascript options for the dialog plugin
	'options'=>array(
		'title'=>$name,
		'autoOpen'=>true,
		'modal'=>true,	
                'height'=>'auto',
                'width'=>480,
                'resizable'=>false,
                'draggable'=>false,
		'close' => 'js:function(event, ui) { location.href = "'.Yii::app()->createUrl("batch/admin").'"; }'
	),
));
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'batch-form',
	'enableAjaxValidation'=>true,
	 'clientOptions'=>array('validateOnSubmit'=>true),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php  //echo $form->errorSummary($model); 
$org_id=Yii::app()->user->getState('org_id');
?>

	<div class="row">
		<?php echo $form->labelEx($model,'batch_name'); ?>
		<?php echo $form->error($model,'batch_name'); ?>
		<?php echo $form->textField($model,'batch_name',array('size'=>25,'maxlength'=>60)); ?><span class="status">&nbsp;</span>
	</div>
	<div class="row1">
		<?php echo $form->labelEx($model,'academic_period_id'); ?>
		<?php echo $form->error($model,'academic_period_id'); ?>
		<?php
			echo $form->dropDownList($model,'academic_period_id',AcademicTermPeriod::items(),
			array(
			'prompt' => 'Select Year',
			'ajax' => array(
			'type'=>'POST', 
			'url'=>CController::createUrl('dependent/getBatchItemName'), 
			'update'=>'#Batch_academic_name_id', //selector to update
			))); 
			 
			?><span class="status">&nbsp;</span>
	</div>
	<div class="row1">
		<?php echo $form->labelEx($model,'academic_name_id'); ?>
		<?php echo $form->error($model,'academic_name_id'); ?>
		<?php 
			
			if(isset($model->academic_name_id))
				echo $form->dropDownList($model,'academic_name_id', CHtml::listData(AcademicTerm::model()->findAll(array('condition'=>'academic_term_id='.$model->academic_name_id)), 'academic_term_id', 'academic_term_name'));
			else
				echo $form->dropDownList($model,'academic_name_id',array()); 
		?><span class="status">&nbsp;</span>
	</div>

	<div class="row1">
		<?php echo $form->labelEx($model,'branch_id'); ?>
		<?php echo $form->error($model,'branch_id'); ?>
		<?php //echo $form->dropDownList($model,'branch_id',Branch::code(), array('empty' => '-----------Select---------')) ?>
		
		<?php
			echo $form->dropDownList($model,'branch_id',
				CHtml::listData(Branch::model()->findAll(array('condition'=> 'branch_organization_id='.$org_id)),'branch_id','branch_name'),
				array(
				'prompt' => 'Select Branch',
				'ajax' => array(
				'type'=>'POST', 
				'url'=>CController::createUrl('dependent/getBatchItemName1'),	 	
				'update'=>'#Batch_div_id', //selector to update
				
				)));
			 
			 
		?>

<span class="status">&nbsp;</span>
	</div>
	<div class="row1">
		<?php echo $form->labelEx($model,'div_id'); ?>
		<?php echo $form->error($model,'div_id'); ?>
		<?php echo $form->dropDownList($model,'div_id',Division::items(), array('empty' => 'Select Division')) ?><span class="status">&nbsp;</span>
	</div>
<!--	

	<div class="row1">
		<?php echo $form->labelEx($model,'batch_organization_id'); ?>
		<?php echo $form->dropDownList($model,'batch_organization_id', Organization :: items()); ?>
		<?php echo $form->error($model,'batch_organization_id'); ?>
	</div>
-->
	<!--<div class="row">
		<?php echo $form->labelEx($model,'batch_created_by'); ?>
		<?php echo $form->textField($model,'batch_created_by'); ?>
		<?php echo $form->error($model,'batch_created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'batch_creation_date'); ?>
		<?php echo $form->textField($model,'batch_creation_date'); ?>
		<?php echo $form->error($model,'batch_creation_date'); ?>
	</div>-->
<br/>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save',array('class'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
</div>
