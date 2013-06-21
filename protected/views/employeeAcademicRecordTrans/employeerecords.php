</br>
<?php 
echo CHtml::link('GO BACK',YII::app()->request->urlReferrer);
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'employee-academic-record-trans-grid',
	'dataProvider'=>$employeerecords->mysearch(),
	//'filter'=>$model,
	'enableSorting'=>false,
	'columns'=>array(
		array(
		'header'=>'SN.',
		'class'=>'IndexColumn',
		),
		
		array('name' => 'employee_academic_record_trans_qualification_id',
	              'value' => '$data->Rel_employee_qualification->qualification_name',
                     ),
		array('name' => 'employee_academic_record_trans_eduboard_id',
			'value' => '$data->Rel_employee_eduboard->eduboard_name',
                     ),
		array('name' => 'employee_academic_record_trans_year_id',
			'value' => '$data->Rel_employee_year->year',
                     ),
		array('name' => 'theory_mark_obtained',
			'value' => '$data->theory_mark_obtained',
                     ),
		array('name' => 'theory_mark_max',
			'value' => '$data->theory_mark_max',
                     ),
		array('name' => 'theory_percentage',
			'value' => '$data->theory_percentage',
                     ),
		array('name' => 'practical_mark_obtained',
			'value' => '$data->practical_mark_obtained',
                     ),
		array('name' => 'practical_mark_max',
			'value' => '$data->practical_mark_max',
                     ),
		array('name' => 'practical_percentage',
			'value' => '$data->practical_percentage',
                     ),
		
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}',
	                'buttons'=>array(
/*			'view' => array(
				'url'=>'Yii::app()->createUrl("employeeAcademicRecordTrans/view", array("id"=>$data->employee_academic_record_trans_id))',
                        ),*/
			'update' => array(
				'url'=>'Yii::app()->createUrl("employeeAcademicRecordTrans/update", array("id"=>$data->employee_academic_record_trans_id))',
				'options'=>array('id'=>'update-qualification'),
                        ),
			'delete' => array(
				'url'=>'Yii::app()->createUrl("employeeAcademicRecordTrans/delete", array("id"=>$data->employee_academic_record_trans_id))',
                        ),
			),
		),
	),
));
