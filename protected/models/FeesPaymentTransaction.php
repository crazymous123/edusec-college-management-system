<?php

/**
 * This is the model class for table "fees_payment_transaction".
 *
 * The followings are the available columns in table 'fees_payment_transaction':
 * @property integer $fees_payment_transaction_id
 * @property integer $fees_payment_master_id
 * @property integer $fees_payment_method_id
 * @property integer $fees_payment_cash_cheque_id
 * @property integer $fees_receipt_id
 * @property integer $fees_payment
 * @property integer $fees_received_user_id
 * @property integer $fees_full_part_payment_id
 * @property integer $fees_student_id
 */
class FeesPaymentTransaction extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FeesPaymentTransaction the static model class
	 */


	public $fees_master_id,$receipt_start_from,$receipt_end_to,$start_date,$end_date;
	public $fees_acdm_period,$fees_acdm_name,$fees_branch,$fees_division,$student_roll_no,$fees_acdm;

	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'fees_payment_transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('start_date,end_date,fees_acdm_period' ,'required' ,'on'=>'date_report','message'=>''),			
	
		array('fees_acdm_period','required','on'=>'Branch_receipt_generate_print','message'=>''),
			
			array('fees_payment_master_id, fees_payment_method_id, fees_payment_cash_cheque_id, fees_receipt_id, fees_payment, fees_received_user_id, fees_full_part_payment_id, fees_academic_period_id, fees_academic_term_id, fees_student_id', 'required','message'=>''),
			array('fees_payment_master_id, fees_payment_method_id,  fees_academic_period_id, fees_academic_term_id, fees_payment_cash_cheque_id, fees_receipt_id, fees_payment, fees_received_user_id, fees_full_part_payment_id, fees_acdm_period, fees_acdm_name, fees_branch, fees_division, fees_student_id, fees_payment_transaction_organization_id, receipt_start_from, receipt_end_to', 'numerical', 'integerOnly'=>true,'message'=>''),
			array('receipt_start_from, receipt_end_to', 'required','on'=>'receipt_generate_print','message'=>''),
			array('receipt_start_from, receipt_end_to','CRegularExpressionValidator','pattern'=>'/^([0-9]+)$/','message'=>'' ),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fees_payment_transaction_id, fees_payment_master_id, fees_payment_method_id, fees_payment_cash_cheque_id, fees_receipt_id, fees_payment, fees_received_user_id, fees_full_part_payment_id, fees_student_id, fees_payment_master_id,fees_payment_transaction_organization_id, receipt_start_from, receipt_end_to, fees_acdm_period, fees_acdm_name, fees_branch, fees_division', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'Rel_pay_method' => array(self::BELONGS_TO, 'FeesPaymentMethod', 'fees_payment_method_id'),
			

		);
	}

	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fees_payment_transaction_id' => 'Fees Payment Transaction',
			'fees_payment_master_id' => 'Fees Master',
			'fees_payment_method_id' => 'Fees Payment Method',
			'fees_payment_cash_cheque_id' => 'Fees Payment Cash Cheque',
			'fees_receipt_id' => 'Fees Receipt',
			'fees_payment' => 'Fees Payment',
			'fees_received_user_id' => 'Fees Received User',
			'fees_full_part_payment_id' => 'Fees Full Part Payment',
			'fees_student_id' => 'Fees Student',
			'fees_payment_transaction_organization_id'=>'Organization',
			'receipt_start_from'=>'Receipt Number From',
			'receipt_end_to'=>'Receipt Number To',
			'start_date'=>'Start Date',
			'end date'=>'End Date',
			'fees_acdm_period'=> 'Academic Year', 	
			'fees_acdm_name'=>'Semester', 
			'fees_branch'=>'Branch',
			'fees_division'=>'Division',
			'student_roll_no'=>'Student Roll No.',

		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('fees_payment_transaction_id',$this->fees_payment_transaction_id);
		$criteria->compare('fees_payment_master_id',$this->fees_payment_master_id);
		$criteria->compare('fees_payment_method_id',$this->fees_payment_method_id);
		$criteria->compare('fees_payment_cash_cheque_id',$this->fees_payment_cash_cheque_id);
		$criteria->compare('fees_receipt_id',$this->fees_receipt_id);
		$criteria->compare('fees_payment',$this->fees_payment);
		$criteria->compare('fees_received_user_id',$this->fees_received_user_id);
		$criteria->compare('fees_full_part_payment_id',$this->fees_full_part_payment_id);
		$criteria->compare('fees_student_id',$this->fees_student_id);
		$criteria->compare('fees_payment_transaction_organization_id',$this->fees_payment_transaction_organization_id);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,

		));
	}

	public function cashsearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$stud_trans = StudentTransaction::model()->findByPk($_REQUEST['id']);
		$criteria->condition = 'fees_student_id = :studentid AND fees_payment_method_id = :payment_method_id AND fees_academic_period_id = :term_period AND fees_academic_term_id = :term_name';
	        $criteria->params = array(':studentid' => $_REQUEST['id'],':payment_method_id' => 1,':term_name' =>$stud_trans['student_academic_term_name_id'],':term_period' =>$stud_trans['student_academic_term_period_tran_id']);
		$criteria->compare('fees_payment_transaction_id',$this->fees_payment_transaction_id);
		$criteria->compare('fees_payment_master_id',$this->fees_payment_master_id);
		$criteria->compare('fees_payment_method_id',$this->fees_payment_method_id);
		$criteria->compare('fees_payment_cash_cheque_id',$this->fees_payment_cash_cheque_id);
		$criteria->compare('fees_receipt_id',$this->fees_receipt_id);
		$criteria->compare('fees_payment',$this->fees_payment);
		$criteria->compare('fees_received_user_id',$this->fees_received_user_id);
		$criteria->compare('fees_full_part_payment_id',$this->fees_full_part_payment_id);
		$criteria->compare('fees_student_id',$this->fees_student_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function chequesearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$stud_trans = StudentTransaction::model()->findByPk($_REQUEST['id']);
		$criteria->alias='i';
		$criteria->select= 'i.fees_payment_transaction_id,i.fees_payment_cash_cheque_id,i.fees_receipt_id,i.fees_payment_method_id,d.fees_payment_cheque_number, d.fees_payment_cheque_id';
		$criteria->join = 'JOIN fees_payment_cheque d ON d.fees_payment_cheque_id = i.fees_payment_cash_cheque_id';

		$criteria->condition = 'i.fees_student_id = :student_id AND i.fees_academic_period_id = :term_period AND i.fees_academic_term_id = :term_name AND i.fees_payment_method_id = :payment_method_id AND d.fees_payment_cheque_status <> :cheque_status';
	        $criteria->params = array(':student_id' => $_REQUEST['id'],':payment_method_id' => 2, ':cheque_status' => 1,':term_name' =>$stud_trans['student_academic_term_name_id'],':term_period' =>$stud_trans['student_academic_term_period_tran_id']);

		/*$criteria->compare('fees_payment_transaction_id',$this->fees_payment_transaction_id);
		$criteria->compare('fees_payment_master_id',$this->fees_payment_master_id);
		$criteria->compare('fees_payment_method_id',$this->fees_payment_method_id);
		$criteria->compare('fees_payment_cash_cheque_id',$this->fees_payment_cash_cheque_id);
		$criteria->compare('fees_receipt_id',$this->fees_receipt_id);
		$criteria->compare('fees_payment',$this->fees_payment);
		$criteria->compare('fees_received_user_id',$this->fees_received_user_id);
		$criteria->compare('fees_full_part_payment_id',$this->fees_full_part_payment_id);
		$criteria->compare('fees_student_id',$this->fees_student_id);*/

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	
}
