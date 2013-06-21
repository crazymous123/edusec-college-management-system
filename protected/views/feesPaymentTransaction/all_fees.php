<?php
	
	$student_name=StudentInfo::model()->findByPk(StudentTransaction::model()->findByPk($_REQUEST['id'])->student_transaction_student_id);

	$org_id=Yii::app()->user->getState('org_id');
	
	$fees=FeesPaymentTransaction::model()->findAll('fees_student_id='.$_REQUEST['id'].' and  	fees_payment_transaction_organization_id = '.$org_id);
	
	if(!empty($fees))
	{	?>	
		
		
		<?php 
		$i=1;
		$m=1;
		$k=0;
		$var = 0;
		$out = 0;
		$payable = 0;
		$payable1 = 0;
		$term_id = 0;
		$ch_num = "";
		$temp = 0;


		foreach($fees as $f)
		{
			$flag=0;

			$columns = array();
			$columns['id'] = $m;

			$columns['acdm_period'] = AcademicTermPeriod::model()->findByPk($f->fees_academic_period_id)-> academic_term_period;
			$columns['sem'] = AcademicTerm::model()->findByPk($f->fees_academic_term_id)->academic_term_name;
		        $columns['method'] = FeesPaymentMethod::model()->findByPk($f->fees_payment_method_id)->fees_payment_method_name;

			
			if($f->fees_payment_method_id==1)
			{
				if($m ==  1)
				$term_id = $f->fees_academic_term_id;
				if($term_id == $f->fees_academic_term_id)
				{
					$var += FeesPaymentCash::model()->findByPk($f->fees_payment_cash_cheque_id)->fees_payment_cash_amount;
					$total = 0;
					$student_fees = StudentFeesMaster::model()->findAll('fees_master_table_id = :fees_master_id AND student_fees_master_student_transaction_id = :student_id', array(':fees_master_id'=>$f->fees_payment_master_id,':student_id'=>$f->fees_student_id));
		
		//print_r($student_fees);  exit;
				foreach($student_fees as $fees_data)
					$total += $fees_data->fees_details_amount;
					$payable = $total; 
					//$payable = FeesMaster::model()->findByPk($f->fees_payment_master_id)->fees_master_total;			
					if($i == 1)
					{
						$payable1 = $payable;
						
					}
					else
						$payable1 = '-';
					
				}
				
				else{
					
					$term_id = $f->fees_academic_term_id;
					$var = FeesPaymentCash::model()->findByPk($f->fees_payment_cash_cheque_id)->fees_payment_cash_amount;
					$total = 0;
					$student_fees = StudentFeesMaster::model()->findAll('fees_master_table_id = :fees_master_id AND student_fees_master_student_transaction_id = :student_id', array(':fees_master_id'=>$f->fees_payment_master_id,':student_id'=>$f->fees_student_id));
		
		//print_r($student_fees);  exit;
				foreach($student_fees as $fees_data)
					$total += $fees_data->fees_details_amount;
					$payable = $total; 
					//$payable = FeesMaster::model()->findByPk($f->fees_payment_master_id)->fees_master_total;
					$payable1 = $payable;
					
					
				}
				
				$out = $payable - $var;
				$ch_num = '-';

				$columns['payable'] = $payable1;
				$columns['paid'] = FeesPaymentCash::model()->findByPk($f->fees_payment_cash_cheque_id)->fees_payment_cash_amount;

				$date = $f->fees_received_date;
				$new_date = date("d-m-Y", strtotime($date));
				$columns['date'] = $new_date;
				$columns['cheque_no'] = $ch_num;				
				$columns['receipt'] = FeesReceipt::model()->findByPk($f->fees_receipt_id)->fees_receipt_number;
				++$temp;
				$flag=1;

			}
			else
			{
				$status = FeesPaymentCheque::model()->findByPk($f->fees_payment_cash_cheque_id)->fees_payment_cheque_status;
				if($status == 0)
				{
				if($m ==  1)
				$term_id = $f->fees_academic_term_id;
				if($term_id == $f->fees_academic_term_id)
				{
					$var += FeesPaymentCheque::model()->findByPk($f->fees_payment_cash_cheque_id)->fees_payment_cheque_amount;
					$total = 0;
					$student_fees = StudentFeesMaster::model()->findAll('fees_master_table_id = :fees_master_id AND student_fees_master_student_transaction_id = :student_id', array(':fees_master_id'=>$f->fees_payment_master_id,':student_id'=>$f->fees_student_id));
		
		//print_r($student_fees);  exit;
				foreach($student_fees as $fees_data)
					$total += $fees_data->fees_details_amount;
					$payable = $total; 
					//$payable = FeesMaster::model()->findByPk($f->fees_payment_master_id)->fees_master_total;

					if($i == 1)
					{
						$payable1 = $payable;
						++$k;
					}
					else
						$payable1 = '-';

					
				}
				else{

					$term_id = $f->fees_academic_term_id;
					$var = FeesPaymentCheque::model()->findByPk($f->fees_payment_cash_cheque_id)->fees_payment_cheque_amount;
					$total = 0;
					$student_fees = StudentFeesMaster::model()->findAll('fees_master_table_id = :fees_master_id AND student_fees_master_student_transaction_id = :student_id', array(':fees_master_id'=>$f->fees_payment_master_id,':student_id'=>$f->fees_student_id));
		
		//print_r($student_fees);  exit;
				foreach($student_fees as $fees_data)
					$total += $fees_data->fees_details_amount;
					$payable = $total; 
					//$payable = FeesMaster::model()->findByPk($f->fees_payment_master_id)->fees_master_total;

					$payable1 = $payable;

				
				}
				$out = $payable - $var;

				$ch_num = FeesPaymentCheque::model()->findByPk($f->fees_payment_cash_cheque_id)->fees_payment_cheque_number;
				$columns['payable'] = $payable1;
				$columns['paid'] = FeesPaymentCheque::model()->findByPk($f->fees_payment_cash_cheque_id)->fees_payment_cheque_amount;

				$date = $f->fees_received_date;
				$new_date = date("d-m-Y", strtotime($date));

				$columns['date'] = $new_date;
				$columns['cheque_no'] = $ch_num;				
				$columns['receipt'] = FeesReceipt::model()->findByPk($f->fees_receipt_id)->fees_receipt_number;
				++$temp;
				$flag=1;
				}
			}

			if($flag==1 && $temp!=0)
			{
			$columns['out'] = $out;


			$dataArray[] = $columns;	

			$i += 1;
			$m++;
			}
		}

	if($temp!=0)
	{
	
		$dataProvider = new CArrayDataProvider($dataArray,
		array(
		'pagination' => array(
		    'pageSize' => count($dataArray),
		    'pageVar' => 'page'
		),
		
	    ));
?>
<div id="fees-cash-grid">
		<h3 class="past-fees-grid" > All Fees </h3>
<?php

		$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'student-grid',
		'dataProvider'=>$dataProvider,
		'columns'=>array(

		array(
			'header'=>'SI No',
			'name'=>'id',
		),
		array(
			'header'=>'Academic Year',
			'name'=>'acdm_period',
		),
		array(
			'header'=>'Semester',
			'name'=>'sem',
		),
		array(
			'header'=>'Payment Method',
			'name'=>'method',
		),
		array(
			'header'=>'Payable Amount',
			'name'=>'payable',
		),
		array(
			'header'=>'Paid Amount',
			'name'=>'paid',
		),
		array(
			'header'=>'Date',
			'name'=>'date',
		),
		array(
			'header'=>'Cheque/DD Number',
			'name'=>'cheque_no',
		),
		array(
			'header'=>'Receipt Number',
			'name'=>'receipt',
		),
		array(
			'header'=>'OutStanding Amount ',
			'name'=>'out',
		),
		),

		));
	}

}

?>
</div>


