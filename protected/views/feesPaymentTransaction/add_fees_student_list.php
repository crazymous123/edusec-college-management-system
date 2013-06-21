<?php
$this->breadcrumbs=array(
	//'Student'=>array('/feesPaymentTransaction/addfees'),
	'Fees Collection',
);



//echo CHtml::link('Export To Pdf',array('StudentTransaction/GeneratePdf'),array('style'=>'color:red'));

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('student-transaction-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Student Fees Collection</h1>



<?php
$dataProvider = $stud_model->search();
if(Yii::app()->user->getState("pageSize",@$_GET["pageSize"]))
$pageSize = Yii::app()->user->getState("pageSize",@$_GET["pageSize"]);
else
$pageSize = Yii::app()->params['pageSize'];
$dataProvider->getPagination()->setPageSize($pageSize);
?>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'student-transaction-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$stud_model,
	'ajaxUpdate'=>false,
	'columns'=>array(

		array(
		'header'=>'SI No',
		'class'=>'IndexColumn',
		),
		
		 array('name' => 'student_enroll_no',
		       'value' => '$data->Rel_Stud_Info->student_enroll_no',
                     ),
		array('name' => 'student_roll_no',
		      'value' => '$data->Rel_Stud_Info->student_roll_no',
                     ),
		array('name' => 'student_first_name',
		      'value' => '$data->Rel_Stud_Info->student_first_name',
                     ),
		array('name' => 'student_last_name',
		      'value' => '$data->Rel_Stud_Info->student_last_name',
                     ),
		array('name'=>'student_transaction_branch_id',
		      'value'=>'Branch::model()->findByPk($data->student_transaction_branch_id)->branch_name',
		      'filter' =>CHtml::listData(Branch::model()->findAll(array('condition'=>'branch_organization_id='.Yii::app()->user->getState('org_id'))),'branch_id','branch_name'),
		    ), 
		array('name'=>'student_transaction_quota_id',
		      'value'=>'Quota::model()->findByPk($data->student_transaction_quota_id)->quota_name',
		      'filter' =>CHtml::listData(Quota::model()->findAll(array('condition'=>'quota_organization_id='.Yii::app()->user->getState('org_id'))),'quota_id','quota_name'),
		     ),
		array('name'=>'student_academic_term_period_tran_id',
		      'value'=>'AcademicTermPeriod::model()->findByPk($data->student_academic_term_period_tran_id)->academic_term_period',
		     ), 
		array('name'=>'student_academic_term_name_id',
		      'value'=>'AcademicTerm::model()->findByPk($data->student_academic_term_name_id)->academic_term_name',
		      'filter' =>CHtml::listData(AcademicTerm::model()->findAll(array('condition'=>'current_sem=1 and academic_term_organization_id='.Yii::app()->user->getState('org_id'))),'academic_term_id','academic_term_name'),
   		     ), 

		 array('name' => 'student_dtod_regular_status',
	         'value' => '$data->Rel_Stud_Info->student_dtod_regular_status',
                     ),
		array('name' => 'status_name',
		      'value' => '$data->Rel_Status->status_name',
                     ),

		array(
			'class'=>'MyCButtonColumn',
			'template' => '{Add Fees}',
	                'buttons'=>array(
                        'Add Fees' => array(
                                'label'=>'Take Fees', 
				'url'=>'Yii::app()->createUrl("feesPaymentTransaction/create", array("id"=>$data->student_transaction_id))',
                                'imageUrl'=> Yii::app()->baseUrl.'/images/add.jpeg',
                                'options' => array('class'=>'fees'),
                        ),
                   ),

		),
	),
	'pager'=>array(
		'class'=>'AjaxList',
	//	'maxButtonCount'=>25,
		'maxButtonCount'=>$stud_model->count(),
		'header'=>''
	    ),

)); ?>
