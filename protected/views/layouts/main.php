<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />	
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />


	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/rudrasoftech_favicon.png" type="image/x-icon" />	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/sal.css" media="print, projection" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/tableview.css" media="print,screen" />

<script>
       $(document).ready(function() {
                $('#fancybox-close').click(function() {
                location.reload();
               });
    });
</script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<?php 
		//Yii::app()->clientscript->scriptMap['jquery.js'] = false;
		//$dataProvider = new CActiveDataProvider(Message::model()->sent(Yii::app()->getModule('mailbox')->getUserId()));
		//echo $dataProvider->getItemCount(); 
	?>
</head>
<body>
<div id="header">

		<?php 
			if(isset($_REQUEST['organization_name']))
			{
				$org_id = $_REQUEST['organization_name']; 
				Yii::app()->user->setState('org_id',$_REQUEST['organization_name']);
			}
		?>
		
		<div id="logo"><div id="site-logo">

			<?php
			$test = Yii::app()->user->getState('org_id');
			if(isset($test))	
			{
			
			echo CHtml::link(CHtml::image(Yii::app()->controller->createUrl('/site/loadImage', array('id'=>Yii::app()->user->getState('org_id'))),'No Image',array('width'=>80,'height'=>70)),array('/site/newdashboard'));
			}
			?>
		

		</div>
		<div id="site-logo" style="padding-top:15px;">
		<?php
			if(isset($test))	
			{
			
			echo Organization::model()->findByPk(Yii::app()->user->getState('org_id'))->organization_name;
			}
		
		 ?>
		</div>
		
		<div id="site-name">
		
		<?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/edusec.png'); ?>
		<!--<div id="company-name">

		<?php	/*
			$new_org_id = Yii::app()->user->getState('org_id');			if(isset($new_org_id))
			{

				$company = Organization::model()->findByPk($new_org_id);
				echo "Welcome to ".$company->organization_name;
			}*/
		
		?>
		</div>--></div></div>
	</div><!-- header -->
<div id="main-content">

<div id="page">
	

	<?php 
		if(isset($_REQUEST['organization_name']))
		{
			$role_id = assignCompanyUserTable::model()->find('assign_org_id=:org_id AND assign_user_id=:user_id',array(':org_id'=>Yii::app()->user->getState('org_id'),':user_id'=>Yii::app()->user->id));
			$role_name = RoleMaster::model()->findByPk($role_id->assign_role_id);
			//echo $role_name->role_master_name;
			if(Yii::app()->user->id != 1)
			Yii::app()->user->setState('role',$role_name->role_master_name);
			else
			Yii::app()->user->setState('role','sadmin');
		}
	 ?>

	<div id="mainmenu">
		<div id="nav-bar">	
		
		<?php 
			$empsession = 0;
			$studsession = 0;
			$count = 0;
			if(!Yii::app()->user->isGuest)
			{
				echo '<div class="left-menu-link"><ul id ="nav"><li class="pwd" style=" text-align: center; padding: 0px;">'.CHtml::link("Menu", "" ,array('onClick'=>'$("#master").dialog("open");return false;')).'</li>';
			$studsession = Yii::app()->user->getState('stud_id');
			$empsession = Yii::app()->user->getState('emp_id');
				$count = 0;
				$count = Mailbox::model()->newMsgs(Yii::app()->user->id);
 				echo '<li>'.CHtml::link("Mail(".$count.")", array('/mailbox')).'</li></ul></div>';   
			}
		?>
 
		
	
				<?php 
				if(isset($studsession))
				{
				   $stud_model = StudentInfo::model()->findByAttributes(array('student_info_transaction_id'=>$studsession));
				   $login_user_name = ucfirst(strtolower($stud_model->student_first_name)).' '.ucfirst(strtolower($stud_model->student_last_name));
				}
				else if(isset($empsession))
				{	
				
				   $emp_model = EmployeeInfo::model()->findByAttributes(array('employee_info_transaction_id'=>$empsession));
				
				   $login_user_name = ucfirst(strtolower($emp_model->employee_first_name)).' '.ucfirst(strtolower($emp_model->employee_last_name));

				}
				else
				{
				  $login_user_name = ucfirst(strtolower(strstr(Yii::app()->user->name,'@',true)));
				}
				?>

				<?php echo '<div class="right-menu-link"><ul id ="nav"><li class="welcome">Welcome, '. $login_user_name.'</li>';
	echo '<li>'.CHtml::link('Edusec Support','http://124.125.156.120:8081', array('target'=>'_blank'))."</li>";
				if(isset($studsession))
				{
					echo '<li>'.CHtml::link("My Account",array('/studentTransaction/update/'.$studsession)).'</li>';
				}
				if(isset($empsession))
				{
					
					echo '<li>'.CHtml::link("My Account",array('/employeeTransaction/update/'.$empsession)).'</li>';
				}

				echo '<li>'.CHtml::link(" Change Password", array('/user/change/')).'</li>';	
				echo '<li class="last-menu-item">'.CHtml::link(" Logout", array('/site/logout')).'</li></ul></div>';
					?>
	
		</div>
	</div><!-- mainmenu -->
</div>
<!--menu window-->
<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'menuwindow',
	// additional javascript options for the dialog plugin
	'options'=>array(
		'title'=>'Control Panel',
		'autoOpen'=>false,
		'modal'=>true,	
                'height'=>'auto',
                'width'=>'auto',
                'resizable'=>false,
               'draggable'=>false,
		
	),
	'htmlOptions'=>array('style'=>'max-width:800px'),
));
?>

<div class="main-div" style="display:none;">
		
	<div class="pop-user-mng-link">
	<?php echo CHtml::link("User Managements",array('/rights'));?>
	</div>

</div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<!--masters-->
<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'master',
	// additional javascript options for the dialog plugin
	'options'=>array(
		'title'=>'Module List',
		'autoOpen'=>false,
		'modal'=>true,	
                'height'=>'auto',
                'width'=>'305',
                'resizable'=>false,
                'draggable'=>false,
		
	),
	'htmlOptions'=>array('style'=>'max-width:770px; display:none;'),
));
?>

<div class="main-dialog" >

	<?php if(Yii::app()->user->checkAccess('Configuration')) { ?>
	<div class="pop-master-link">
	<?php echo CHtml::link("Configuration","", array('onClick'=>'$("#master1").dialog("open");return false;'));?>
	</div>
	<?php } ?>
	
	<?php if(Yii::app()->user->checkAccess('EmployeeTransaction.Admin')) { ?>
	<div class="pop-emp-link">
	<?php echo CHtml::link("",array('/employeeTransaction/admin'));?>
	</div>
	<?php } ?>

	<?php if(Yii::app()->user->checkAccess('Studentmodule')) { ?>	
	<div class="pop-studentmodule-link">
<?php echo CHtml::link("Student","", array('onClick'=>'$("#studentmodule").dialog("open");return false;'));?>
	</div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('Fees')) { ?>
	<div class="pop-fee-link">
	<?php echo CHtml::link("Fees","", array('onClick'=>'$("#fees").dialog("open");return false;'));?>
	</div>
	<?php } ?>
	
	<?php if(Yii::app()->user->checkAccess('Dashboard')) { ?>	
	<div class="pop-dashboard-link">
	<?php echo CHtml::link("Dashboard","", array('onClick'=>'$("#my-dashboard").dialog("open");return false;'));?>
	</div>
	<?php } ?>

	
	<?php if(Yii::app()->user->checkAccess('Controlpanel')) { ?>
	<div class="pop-mainpanel-link">
	<?php echo CHtml::link("Control Panel","", array('onClick'=>'$("#menuwindow").dialog("open");return false;'));?>
	</div>
	<?php } ?>
		
	<?php if(Yii::app()->user->checkAccess('Resetlogin')) { ?>
	<div class="pop-resetlogin-link">
       <?php echo CHtml::link("Reset Login","", array('onclick'=>'$("#login").dialog("open");return false;'));?>
        </div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('Reports') ) { ?>
	 <div class="pop-report-link">
       <?php echo CHtml::link("Reports Center","", array('onclick'=>'$("#reports").dialog("open");return false;'));?>
        </div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('Resetpassword')) { ?>	
	<div class="pop-resetpassword-link">
	<?php echo CHtml::link("Reset Password","", array('onclick'=>'$("#password").dialog("open");return false;'));?>
	</div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('Loginhistory')) { ?>	
	<div class="pop-login-history-link">
	<?php echo CHtml::link("Login History",array('/LoginUser/login_user'));?>
	</div>
	<?php } ?>
		
	<?php if(Yii::app()->user->checkAccess('Photogallery')) { ?>
	<div class="pop-photo-link">
       <?php echo CHtml::link("Photo Gallery",array('/photoGallery/Admin'));?>
       </div>
	<?php } ?>
		
</div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<!-- studentmodule-->
<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'studentmodule',
	// additional javascript options for the dialog plugin
	'options'=>array(
		'title'=>'Student',
		'autoOpen'=>false,
		'modal'=>true,	
                'height'=>'auto',
                'width'=>'auto',
                'resizable'=>false,
                 'draggable'=>false,
	),
	'htmlOptions'=>array('style'=>'max-width:260px'),
));
?>

<div class="main-div" style="display:none;">
	
	<?php if(Yii::app()->user->checkAccess('StudentTransaction.Admin')) { ?>
	<div class="pop-stud-link">
	<?php echo CHtml::link("Student",array('/studentTransaction/admin'));?>
	</div>
	<?php } ?>
	
	
	<?php if(Yii::app()->user->checkAccess('feesPaymentTransaction.StudentFeesReportwithoutform')) { ?>
	<div class="pop-studentfeesreport1-link">
       <?php echo CHtml::link("Student Fees Report",array('/feesPaymentTransaction/StudentFeesReportwithoutform'));?>
       </div>
	<?php } ?>

	
<?php if(Yii::app()->user->checkAccess('report.Studenthistory')) { ?>
	<div class="pop-studenthistory-link">
	<?php if($studsession != 0)
		echo CHtml::link("Student History",array('/report/Studenthistory/'.$studsession));
		else
		echo CHtml::link("Student History",array('/report/Studenthistory'));
	?></div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('feedbackCategoryMaster.Admin')) { ?>
<div class="pop-feedbackcategory-link big-string-icon">
<?php echo CHtml::link("Performance Category",array('/feedbackCategoryMaster/admin'));?>
</div>
<?php } ?>

</div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>


<!-- empmodule-->
<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'empmodule',
	// additional javascript options for the dialog plugin
	'options'=>array(
		'title'=>'Employee',
		'autoOpen'=>false,
		'modal'=>true,	
                'height'=>'auto',
                'width'=>'auto',
                'resizable'=>false,
                'draggable'=>false,
	),
	'htmlOptions'=>array('style'=>'max-width:260px'),
));
?>

<div class="main-div" style="display:none;">
	
	<?php if(Yii::app()->user->checkAccess('EmployeeTransaction.Admin')) { ?>
	<div class="pop-emp-link">
	<?php echo CHtml::link("Employee",array('/employeeTransaction/admin'));?>
	</div>
	<?php } ?>


</div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<!-- documentmanagement -->
<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'documentmanagement',
	// additional javascript options for the dialog plugin
	'options'=>array(
		'title'=>'Document',
		'autoOpen'=>false,
		'modal'=>true,	
                'height'=>180,
                'width'=>'auto',
                'resizable'=>false,
               'draggable'=>false,
	),
	 'htmlOptions'=>array('style'=>'max-width:800px'),
));
?>

<div class="main-div" style="display:none;">
	
	<?php if(Yii::app()->user->checkAccess('DocumentCategoryMaster.Admin')) { ?>
	<div class="pop-documentcategory-link big-string-icon">
	<?php echo CHtml::link("Document Category",array('/documentCategoryMaster/admin'));?>
	</div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('report.studentDocumentsearch')) { ?>
	<div class="pop-studentdocument-link big-string-icon">
	<?php echo CHtml::link("Student Document",array('/report/studentDocumentsearch'));?>
	</div>
	<?php } ?>

	<?php if(Yii::app()->user->checkAccess('report.documentsearch')) { ?>
	<div class="pop-employeedocument-link big-string-icon">
	<?php echo CHtml::link("Employee Document",array('/report/documentsearch'));?>
	</div>
	<?php } ?>

</div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<!-- transport module -->
<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'transport',
	// additional javascript options for the dialog plugin
	'options'=>array(
		'title'=>'Transport',
		'autoOpen'=>false,
		'modal'=>true,	
                'height'=>'auto',
                'width'=>'auto',
                'resizable'=>false,
               'draggable'=>false,
	),
	 'htmlOptions'=>array('style'=>'max-width:260px'),
));
?>

<div class="main-div" style="display:none;">
	
	<?php if(Yii::app()->user->checkAccess('transport.TransportBusMaster.Admin')) { ?>
	<div class="pop-busdetails-link">
	<?php echo CHtml::link("Bus",array('/transport/transportBusMaster/admin'));?>
	</div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('transport.TransportDriverRegistration.Admin')) { ?>
	<div class="pop-driver-link">
	<?php echo CHtml::link("Driver Details",array('/transport/transportDriverRegistration/admin'));?>
	</div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('transport.TransportRouteMaster.Admin')) { ?>
	<div class="pop-routemaster-link">
	<?php echo CHtml::link("Route",array('/transport/transportRouteMaster/admin'));?>
	</div>
	<?php } ?>

	<!--<?php if(Yii::app()->user->checkAccess('transport.TransportRouteDetailMaster.Admin')) { ?>
	<div class="pop-routedetails-link">
	<?php echo CHtml::link("Route Details",array('/transport/transportRouteDetailMaster/admin'));?>
	</div>
	<?php } ?>-->


	<?php if(Yii::app()->user->checkAccess('transport.TransportBusRouteAllocation.Admin')) { ?>
	<div class="pop-busroute-link">
	<?php echo CHtml::link("Route Allocation",array('/transport/transportBusRouteAllocation/admin'));?>
	</div>
	<?php } ?>

	<?php if(Yii::app()->user->checkAccess('transport.TransportStudentRegistration.StudentList')) { ?>
	<div class="pop-transport-reg-link big-string-icon">
	<?php echo CHtml::link("Transport Registration",array('/transport/transportStudentRegistration/StudentList'));?>
	</div>
	<?php } ?>

	<?php if(Yii::app()->user->checkAccess('transport.TransportStudentRegistration.Admin')) { ?>
	<div class="pop-reg-student-link big-string-icon">
	<?php echo CHtml::link("Registered Student",array('/transport/transportStudentRegistration/admin'));?>
	</div>
	<?php } ?>
</div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<!-- subjectmanagement -->
<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'subjectmanagement',
	// additional javascript options for the dialog plugin
	'options'=>array(
		'title'=>'Subject',
		'autoOpen'=>false,
		'modal'=>true,	
                'height'=>'auto',
                'width'=>'auto',
                'resizable'=>false,
                'draggable'=>false,
	),
	 'htmlOptions'=>array('style'=>'max-width:800px'),
));
?>

<div class="main-div" style="display:none;">
	<?php if(Yii::app()->user->checkAccess('SubjectType.Admin')) { ?>	
	<div class="pop-subject-type-link">
	<?php echo CHtml::link("Subject Type",array('/subjectType/admin'));?>
	</div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('SubjectMaster.Admin')) { ?>
	<div class="pop-subject-link">
	<?php echo CHtml::link("Subject",array('/subjectMaster/admin'));?>
	</div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('AssignSubject.Admin')) { ?>
	<div class="pop-assignSubject-link">
	<?php echo CHtml::link("Assign Subject",array('/assignSubject/admin'));?>
	</div>
	<?php } ?>

	<?php if(Yii::app()->user->checkAccess('subjectSyllabus.teachinghours')) { ?>
	<div class="pop-lecturescheduling-link big-string-icon">
	<?php echo CHtml::link("Lesson Planning",array('/subjectSyllabus/teachinghours'));?>
	</div>
	<?php } ?>
</div>


<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<!-- roommanagement -->
<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'roommanagement',
	// additional javascript options for the dialog plugin
	'options'=>array(
		'title'=>'Room',
		'autoOpen'=>false,
		'modal'=>true,	
                'height'=>'auto',
                'width'=>'auto',
                'resizable'=>false,
                'draggable'=>false,
	),
	 'htmlOptions'=>array('style'=>'max-width:800px'),
));
?>

<div class="main-div" style="display:none;">
	
	<?php if(Yii::app()->user->checkAccess('RoomCategory.Admin')) { ?>
	<div class="pop-roomcategorymaster-link">
	<?php echo CHtml::link("Room Category Master",array('/roomCategory/admin'));?>
	</div>
	<?php } ?>

       <?php if(Yii::app()->user->checkAccess('RoomDetailsMaster.Admin')) { ?>
	<div class="pop-roomdetails-link">
	<?php echo CHtml::link("Room Details",array('/roomDetailsMaster/admin'));?>
	</div>
	<?php } ?>

</div>


<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>


<!-- inventory -->
<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'inventory',
	// additional javascript options for the dialog plugin
	'options'=>array(
		'title'=>'Asset Management',
		'autoOpen'=>false,
		'modal'=>true,	
                'height'=>'auto',
                'width'=>'auto',
                'resizable'=>false,
                'draggable'=>false,
	),
	 'htmlOptions'=>array('style'=>'max-width:800px'),
));
?>

<div class="main-div" style="display:none;">
	
	<?php if(Yii::app()->user->checkAccess('Inward.Admin')) { ?>
	<div class="pop-inward-link">
	<?php echo CHtml::link("Inward",array('/inward/admin'));?>
	</div>
	<?php } ?>

	<?php if(Yii::app()->user->checkAccess('Assets.Admin')) { ?>
	<div class="pop-assest-link">
	<?php echo CHtml::link("assets",array('/assets/admin'));?>
	</div>
	<?php } ?>

	<?php if(Yii::app()->user->checkAccess('Outward.Admin')) { ?>
	<div class="pop-outward-link">
	<?php echo CHtml::link("Outward",array('/outward/admin'));?>
	</div>
	<?php } ?>

</div>


<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>


<!-- Dashboard -->
<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'my-dashboard',
	// additional javascript options for the dialog plugin
	'options'=>array(
		'title'=>'Dashboard',
		'autoOpen'=>false,
		'modal'=>true,	
                'height'=>'auto',
                'width'=>'auto',
                'resizable'=>false,
               'draggable'=>false,
	),
	 'htmlOptions'=>array('style'=>'max-width:800px'),
));
?>

<div class="main-div" style="display:none;">
	
	<!--<?php if(Yii::app()->user->checkAccess('ImportantNotice.Admin')) { ?>	
	<div class="pop-importantnotice-link">
	<?php echo CHtml::link("Important Notice",array('/importantNotice/admin'));?>
	</div>
	<?php } ?>-->
	
	<?php if(Yii::app()->user->checkAccess('Gtunotice.Admin')) { ?>	
	<div class="pop-gtunotice-link">
	<?php echo CHtml::link("Gtu Notice",array('/gtunotice/admin'));?>
	</div>
	<?php } ?>

	<?php if(Yii::app()->user->checkAccess('messageOfDay.Admin')) { ?>	
	<div class="pop-message-link big-string-icon">
	<?php echo CHtml::link("Message Of Day",array('/messageOfDay/admin'));?>
	</div>
	<?php } ?>
</div>


<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<!-- exam module-->
<?php       

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
       'id'=>'exammodule',
       // additional javascript options for the dialog plugin
       'options'=>array(
               'title'=>'Examination',
               'autoOpen'=>false,
               'modal'=>true,       
               'height'=>'auto',
               'width'=>'auto',
               'resizable'=>false,
               'draggable'=>false,
       ),
	 'htmlOptions'=>array('style'=>'max-width:360px'),
));
?>

<div class="main-div" style="display:none;">
   
    <?php if(Yii::app()->user->checkAccess('exam.examType.Admin')) { ?> 
    <div class="pop-examtype-link big-string-icon">
    <?php echo CHtml::link("Exam Type",array('/exam/examType/admin'));?>
    </div>
   <?php } ?>
  
    <?php if(Yii::app()->user->checkAccess('exam.examCategory.Admin')) { ?> 
    <div class="pop-examcategory-link big-string-icon">
    <?php echo CHtml::link("Exam Category",array('/exam/examCategory/admin'));?>
    </div>
    <?php } ?>

    <?php if(Yii::app()->user->checkAccess('exam.examName.Admin')) { ?> 
    <div class="pop-examname-link big-string-icon">
    <?php echo CHtml::link("Exam Name",array('/exam/examName/admin'));?>
    </div>
    <?php } ?>


    <?php if(Yii::app()->user->checkAccess('exam.examResult.Admin')) { ?> 
    <div class="pop-examresult-link big-string-icon">
    <?php echo CHtml::link("Exam Result",array('/exam/examResult/admin'));?>
    </div>
    <?php } ?>

   <?php if(Yii::app()->user->checkAccess('exam.examSchedule.Admin')) { ?> 
    <div class="pop-examschedule-link big-string-icon">
    <?php echo CHtml::link("Exam Schedule",array('/exam/examSchedule/admin'));?>
    </div>
    <?php } ?>


    <?php if(Yii::app()->user->checkAccess('exam.examScheduleSubject.Admin')) { ?> 
    <div class="pop-examschedulesubject-link big-string-icon">
    <?php echo CHtml::link("Exam Schedule Subject",array('/exam/examScheduleSubject/admin'));?>
    </div>
    <?php } ?>


    <?php if(Yii::app()->user->checkAccess('exam.examAttendence.Admin')) { ?> 
    <div class="pop-examattendence-link big-string-icon">
    <?php echo CHtml::link("Exam Attendence",array('/exam/examAttendence/admin'));?>
    </div>
    <?php } ?>


</div>

<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<!-- sms module-->
<?php       

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
       'id'=>'sms',
       // additional javascript options for the dialog plugin
       'options'=>array(
               'title'=>'SMS-Email',
               'autoOpen'=>false,
               'modal'=>true,       
               'height'=>'auto',
               'width'=>'auto',
               'resizable'=>false,
               'draggable'=>false,
       ),
	 'htmlOptions'=>array('style'=>'max-width:800px'),
));
?>

<div class="main-div" style="display:none;">
    <?php if(Yii::app()->user->checkAccess('EmployeeSmsEmailDetails.employeebulksmsemail')) { ?>
    <div class="pop-emp-sms-email-link">
    <?php echo CHtml::link("Employee Sms/Email",array('/EmployeeSmsEmailDetails/employeebulksmsemail'));?>
    </div>
    <?php } ?>

    <?php if(Yii::app()->user->checkAccess('studentSmsEmailDetails.studentbulksmsemail')) { ?>
    <div class="pop-stud-sms-email-link">
    <?php echo CHtml::link("Student Sms/Email",array('/StudentSmsEmailDetails/studentbulksmsemail'));?>
    </div>
    <?php } ?>
    <?php if(Yii::app()->user->checkAccess('studentSmsEmailDetails.ScheduleFeesMessage')) { ?>

    <div class="pop-stud-schedule-fees-msg-link">
    <?php echo CHtml::link("Schedule Fees Message",array('/StudentSmsEmailDetails/ScheduleFeesMessage'));?>
    </div>
    <?php } ?>
    <?php if(Yii::app()->user->checkAccess('studentSmsEmailDetails.ScheduleAttendanceMessage')) { ?>

    <div class="pop-stud-schedule-attendance-msg-link">
    <?php echo CHtml::link("Schedule Attendance Message",array('/StudentSmsEmailDetails/ScheduleAttendanceMessage'));?>    </div>
    <?php } ?>
     <?php if(Yii::app()->user->checkAccess('scheduleTiming/admin')) { ?>
    <div class="pop-stud-schedule-timing-link">
    <?php echo CHtml::link("Schedule Timing",array('/ScheduleTiming/admin'));?>    </div>
    <?php } ?>

    
</div>

<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<!-- certificate module -->
<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
       'id'=>'certificate',
       // additional javascript options for the dialog plugin
       'options'=>array(
               'title'=>'Certificate',
               'autoOpen'=>false,
               'modal'=>true,        
               'height'=>'auto',
               'width'=>'auto',
               'resizable'=>false,
               'draggable'=>false,
       ),
       'htmlOptions'=>array('style'=>'max-width:800px'),
));
?>

<div class="main-div" style="display:none;">

<?php if(Yii::app()->user->checkAccess('certificate.Admin')) { ?>
<div class="pop-certificatemaster-link big-string-icon">
<?php echo CHtml::link("Certificate",array('/certificate/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('certificate.certificategeneration')) { ?>
<div class="pop-gen-certificate-link big-string-icon">
<?php echo CHtml::link("Student Certificate",array('/certificate/certificategeneration'));?>
</div>
<?php } ?>

	
<?php if(Yii::app()->user->checkAccess('certificate.EmployeeCertificategeneration')) { ?>
<div class="pop-employeecertificategeneration-link big-string-icon">
<?php echo CHtml::link("Employee Certificate",array('/Certificate/EmployeeCertificategeneration'));?>
</div>
<?php } ?>


</div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<!--
<?php        
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
       'id'=>'alumni',
       // additional javascript options for the dialog plugin
       'options'=>array(
               'title'=>'Alumni',
               'autoOpen'=>false,
               'modal'=>true,        
               'height'=>'auto',
               'width'=>'auto',
               'resizable'=>false,
               'draggable'=>true,
       ),
	 'htmlOptions'=>array('style'=>'max-width:800px'),
));
?>

<div class="main-div" style="display:none;">

<?php if(Yii::app()->user->checkAccess('alumni.alumniStudentRegistration.Admin')) { ?> 	
<div class="pop-alumni-student-reg-link big-string-icon">
<?php echo CHtml::link("Alumni Student Registration ",array('/alumni/alumniStudentRegistration/admin'));?>
</div>
<?php } ?>

</div>

<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
-->
<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
       'id'=>'idcard',
       // additional javascript options for the dialog plugin
       'options'=>array(
               'title'=>'Id Card',
               'autoOpen'=>false,
               'modal'=>true,        
               'height'=>'auto',
               'width'=>'auto',
               'resizable'=>false,
               'draggable'=>false,
       ),
       'htmlOptions'=>array('style'=>'max-width:800px'),
));
?>

<div class="main-div" style="display:none;">

	<?php if(Yii::app()->user->checkAccess('Report.Studentid')) { ?>
		<div class="pop-icard-link">
	       <?php echo CHtml::link("Student ID Card",array('/report/Studentid'));?>
	       </div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('Report.Employeeid')){?>
	<div class="pop-empicard-link big-string-icon">
       <?php echo CHtml::link("Employee ID Card",array('/report/Employeeid'));?>
       </div>
	<?php } ?>

</div>
<!-- hostel module -->
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
       'id'=>'hostel',
       // additional javascript options for the dialog plugin
       'options'=>array(
               'title'=>'Hostel',
               'autoOpen'=>false,
               'modal'=>true,        
               'height'=>'auto',
               'width'=>'auto',
               'resizable'=>false,
               'draggable'=>false,
       ),
	 'htmlOptions'=>array('style'=>'max-width:425px'),
));
?>

<div class="main-div" style="display:none;">

<?php if(Yii::app()->user->checkAccess('hostel.hostelType.Admin')) { ?> 	
<div class="pop-hosteltype-link big-string-icon">
<?php echo CHtml::link("Hostel Type",array('/hostel/hostelType/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('hostel.hostelFeesStructure.Admin')) { ?> 	
<div class="pop-hostelfees-link big-string-icon">
<?php echo CHtml::link("Hostel Fees Master",array('/hostel/hostelFeesStructure/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('hostel.hostelInformation.Admin')) { ?> 	
<div class="pop-hostelinfo-link big-string-icon">
<?php echo CHtml::link("Hostel Details",array('/hostel/hostelInformation/admin'));?>
</div>
<?php } ?>



<?php if(Yii::app()->user->checkAccess('hostel.hostelFacilityMaster.Admin')) { ?> 	
<div class="pop-hostelfacility-link big-string-icon">
<?php echo CHtml::link("Hostel Facility",array('/hostel/hostelFacilityMaster/admin'));?>
</div>
<?php } ?>


<?php /*if(Yii::app()->user->checkAccess('hostel.hostelRoomStatus.Admin')) { ?> 	
<div class="pop-hostelstatus-link">
<?php echo CHtml::link("Room Status",array('/hostel/hostelRoomStatus/admin'));?>
</div>
<?php }*/ ?>
<?php if(Yii::app()->user->checkAccess('hostel.hostelRoomCategoryFacility.Admin')) { ?> 	
<div class="pop-facilitycategory-link big-string-icon">
<?php echo CHtml::link("Room Category Facility",array('/hostel/hostelRoomCategoryFacility/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('hostel.hostelRoomMaster.Admin')) { ?> 	
<div class="pop-hostelroommaster-link big-string-icon">
<?php echo CHtml::link("Room Details",array('/hostel/hostelRoomMaster/admin'));?>
</div>
<?php } ?>
<!--
<?php if(Yii::app()->user->checkAccess('hostel.hostelRoomStatusMaster.Admin')) { ?> 	
<div class="pop-hostelroomstatusmaster-link">
<?php echo CHtml::link("Room Status Master",array('/hostel/hostelRoomStatusMaster/admin'));?>
</div>
<?php } ?>
-->

<?php if(Yii::app()->user->checkAccess('hostel.hostelStudentRegistration.Admin')) { ?> 	
<div class="pop-hostelstudentregistration-link big-string-icon">
<?php echo CHtml::link("Hostel Registration",array('/hostel/hostelStudentRegistration/Studentlist'));?></div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('hostel.hostelStudentRegistration.Admin')) { ?> 	
<div class="pop-hostelstatus-link big-string-icon">
<?php echo CHtml::link("Registered Student List",array('/hostel/hostelStudentRegistration/admin'));?>
</div>
<?php } ?>
<!--
<?php if(Yii::app()->user->checkAccess('hostel.hostelRoomCategory.Admin')) { ?> 	
<div class="pop-roomcategory-link">
<?php echo CHtml::link("Room Category",array('/hostel/hostelRoomCategory/admin'));?>
</div>
<?php } ?>
-->
<?php if(Yii::app()->user->checkAccess('hostel.hostelVisitorInfo.Admin')) { ?> 	
<div class="pop-hostelvisitor-link big-string-icon">
<?php echo CHtml::link("Hostel Visitor",array('/hostel/hostelVisitorInfo/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('hostel.hostelTermsCondition.Admin')) { ?> 	
<div class="pop-hostelterms-link big-string-icon">
<?php echo CHtml::link("Hostel Terms",array('/hostel/hostelTermsCondition/admin'));?>
</div>
<?php } ?>


<!--<div class="pop-occupancyreport-link big-string-icon">
<?php echo CHtml::link("Occupancy Report",array('/hostel/Report/HostelRoomOccupancy'));?>
</div>

<div class="">
<?php echo CHtml::link("RoomFacilty Report",array('/hostel/Report/RoomCategoryWise'));?>
</div>-->
</div>

<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
       'id'=>'hrms',
       // additional javascript options for the dialog plugin
       'options'=>array(
               'title'=>'HRMS',
               'autoOpen'=>false,
               'modal'=>true,        
               'height'=>'400',
               'width'=>'auto',
               'resizable'=>false,
               'draggable'=>false,
       ),
	 'htmlOptions'=>array('style'=>'max-width:440px'),
));
?>

<div class="main-div" style="display:none;">

	<?php /*if(Yii::app()->user->checkAccess('userType.Admin')) { ?>
<div class="pop-usertype-link">
<?php echo CHtml::link("User Type Master",array('/userType/admin'));?>
</div>
<?php }*/ ?>

       <?php if(Yii::app()->user->checkAccess('hrms.NationalHolidays.Admin')) { ?>
       <div class="pop-nationalholiday-link">
       <?php echo CHtml::link("National Holidays",array('/hrms/nationalHolidays/admin'));?>
       </div>
       <?php } ?>
	<?php /*if(Yii::app()->user->checkAccess('hrms.AttendanceMachineMaster.Admin')) { ?>
       <div class="pop-attendancemachine-link">
       <?php echo CHtml::link("Attendance Machine",array('/hrms/attendanceMachineMaster/admin'));?>
       </div>
	<?php } */?>
	<?php if(Yii::app()->user->checkAccess('hrms.LeaveMaster.Admin')) { ?>       
       <div class="pop-leavemaster-link">
       <?php echo CHtml::link("Leave Master",array('/hrms/leaveMaster/admin'));?>
       </div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('hrms.LeaveRuleMaster.Admin')) { ?>  
       <div class="pop-leaverulemaster-link">
       <?php echo CHtml::link("Leave Rule Master",array('/hrms/leaveRuleMaster/admin'));?>
       </div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('hrms.leaveTransaction.Admin')) { ?>
<div class="pop-leaveTransaction-link big-string-icon">
<?php echo CHtml::link("Leave Characteristics",array('/hrms/leaveTransaction/admin'));?>
</div>
<?php } ?>
	<?php if(Yii::app()->user->checkAccess('hrms.LeaveStatusMaster.Admin')) { ?> 
       <div class="pop-leavestatusmaster-link">
       <?php echo CHtml::link("Leave Status Master",array('/hrms/leaveStatusMaster/admin'));?>
       </div>
	<?php } ?>
	
	<?php /* if(Yii::app()->user->checkAccess('hrms.ReportingLevelMaster.Admin')) { ?> 
       <div class="pop-reportinglevelmaster-link">
       <?php echo CHtml::link("Reporting Level Master",array('/hrms/reportingLevelMaster/admin'));?>
       </div><?php }*/ ?>
	
	<?php if(Yii::app()->user->checkAccess('hrms.leaveStructureDesignationDuration.Admin')) { ?>
<div class="pop-leaveduration-link">
<?php echo CHtml::link("Leave Duration",array('/hrms/leaveStructureDesignationDuration/admin'));?>
</div>
<?php } ?>
	<?php if(Yii::app()->user->checkAccess('hrms.EmployeeReportingTable.Admin')) { ?> 
       <div class="pop-EmployeeReportingTable-link big-string-icon">
       <?php echo CHtml::link("Employee Reporting",array('/hrms/employeeReportingTable/admin'));?>
       </div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('hrms.leaveStructureDesignation.selectdesignation')) { ?>
<div class="pop-deswiseleave-link big-string-icon">
<?php echo CHtml::link("Designation Wise Leave",array('/hrms/leaveStructureDesignation/admin'));?>
</div>
<?php } ?>

	<?php if(Yii::app()->user->checkAccess('hrms.salaryStructureDesignationDuration.Admin')) { ?>
<div class="pop-salaryduration-link big-string-icon">
<?php echo CHtml::link("Salary Duration",array('/hrms/salaryStructureDesignationDuration/admin'));?>
</div>
<?php } ?>


	<?php if(Yii::app()->user->checkAccess('hrms.SalaryHeadMaster.Admin')) { ?> 
       <div class="pop-salaryheadmaster-link">
       <?php echo CHtml::link("Salary Head Master",array('/hrms/salaryHeadMaster/admin'));?>
       </div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('hrms.SalaryStructureDesignation.Admin')) { ?> 
       <div class="pop-sal_st_des-link big-string-icon">
       <?php echo CHtml::link("Designation  Wise Salary",array('/hrms/salaryStructureDesignation/designationwisehead'));?>
       </div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('hrms.EmployeeSalaryStructure.Admin')) { ?> 
       <div class="pop-emp_sal_des-link">
       <?php echo CHtml::link("Salary Structure",array('/hrms/employeeSalaryStructure/admin'));?>
       </div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('hrms.employeeSalaryStructure.employeelist')) { ?>
	<div class="pop-salaryslip-link">
	<?php echo CHtml::link("Salary Slip",array('/hrms/employeeSalaryStructure/Monthlyempsalary'));?>
	</div>
	<?php } ?>


	<?php if(Yii::app()->user->checkAccess('hrms.Weekoff.Admin')) { ?>
	<div class="pop-weekoff-link">
	<?php echo CHtml::link("Week Off",array('/hrms/weekoff/admin'));?>
	</div>
	<?php } ?>

	<!--<?php if(Yii::app()->user->checkAccess('hrms.employeeSalarySlip.Admin')) { ?> 
       <div class="pop-employeeSalarySlip-link">
       <?php echo CHtml::link("Salary Structure Duration",array('/hrms/employeeSalarySlip/admin'));?>
       </div>
	<?php } ?>-->


</div>

<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<!--reports module-->
<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
       'id'=>'reports',
       // additional javascript options for the dialog plugin
       'options'=>array(
               'title'=>'Reports Center',
               'autoOpen'=>false,
               'modal'=>true,        
               'height'=>'auto',
               'width'=>'auto',
               'resizable'=>false,
               'draggable'=>false,
       ),
	 'htmlOptions'=>array('style'=>'max-width:425px'),
));
?>

<div class = "main-div" style="display:none;">
	
       <?php if(Yii::app()->user->checkAccess('feesPaymentTransaction.studentfeesreport')) { ?>
       <div class="pop-studentfeesreport-link">
       <?php echo CHtml::link("Student Fees Report",array('/feesPaymentTransaction/studentfeesreport'));?>
       </div>
	<?php } ?>

	<?php if(Yii::app()->user->checkAccess('Report.StudInfoReport')) { ?>
       <div class="pop-studentinforeport-link">
       <?php echo CHtml::link("Student Info Report",array('/report/StudInfoReport'));?>
       </div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('report.EmployeeInfoReport')) { ?>
       <div class="pop-empinforeport-link">
       <?php echo CHtml::link("Employee Info Report",array('/report/EmployeeInfoReport'));?>
       </div>
	<?php } ?>
	

</div>

<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<!-- finish report module-->

<!--aictreports module-->
<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
       'id'=>'aictreports',
       // additional javascript options for the dialog plugin
       'options'=>array(
               'title'=>'AICTE Reports',
               'autoOpen'=>false,
               'modal'=>true,        
               'height'=>'auto',
               'width'=>'auto',
               'resizable'=>false,
               'draggable'=>false,
       ),
	 'htmlOptions'=>array('style'=>'max-width:800px'),
));
?>

<div class = "main-div" style="display:none;">
      
	<?php if(Yii::app()->user->checkAccess('exportToPDFExcel.AdminlibdataExportToExcel')) { ?>
       <div class="pop-adminstaffreport-link big-string-icon">
       <?php echo CHtml::link("Admin Staff Report",array('/exportToPDFExcel/AdminlibdataExportToExcel'),array('target'=>'_blank'));?>
       </div>
	<?php } ?>

	<?php if(Yii::app()->user->checkAccess('exportToPDFExcel.EmployeedataExportToExcel')) { ?>
       <div class="pop-facultyreport-link big-string-icon">
       <?php echo CHtml::link("Faculty Report",array('/exportToPDFExcel/EmployeedataExportToExcel'),array('target'=>'_blank'));?>
       </div>
	<?php } ?>


	<?php if(Yii::app()->user->checkAccess('exportToPDFExcel.TechnicalstaffdataExportToExcel')) { ?>
       <div class="pop-technicalreport-link big-string-icon">
       <?php echo CHtml::link("Technical Staff Report",array('/exportToPDFExcel/TechnicalstaffdataExportToExcel'),array('target'=>'_blank'));?>
       </div>
	<?php } ?>

	

	<?php if(Yii::app()->user->checkAccess('exportToPDFExcel.StudentdataExportExcel')) { ?>
       <div class="pop-student-report-link big-string-icon">
       <?php echo CHtml::link("Student Report",array('/exportToPDFExcel/StudentdataExportExcel'),array('target'=>'_blank'));?>
       </div>
	<?php } ?>

	


</div>

<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<!-- finish report module-->




<!-- password -->
<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'password',
	// additional javascript options for the dialog plugin
	'options'=>array(
		'title'=>'Reset Password',
		'autoOpen'=>false,
		'modal'=>true,	
                'height'=>'auto',
                'width'=>'auto',
                'resizable'=>false,
                 'draggable'=>false,
	),
	'htmlOptions'=>array('style'=>'max-width:800px'),
));
?>
<div class = "main-div" style="display:none;">
	<?php if(Yii::app()->user->checkAccess('User.Admin')) { ?>
	<div class="pop-studpassword-link" >
	<?php echo CHtml::link("Reset Student Password",array('/user/resetstudpassword'));?>
	</div>
	<?php } ?>

	<?php if(Yii::app()->user->checkAccess('User.Admin')) { ?>
	<div class="pop-emppassword-link">
	<?php echo CHtml::link("Reset Employee Password",array('/user/resetemppassword'));?>
	</div>
	<?php } ?>
</div>


<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<!-- Reset Login Id -->
<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
       'id'=>'login',
       // additional javascript options for the dialog plugin
       'options'=>array(
               'title'=>'Reset Login',
               'autoOpen'=>false,
               'modal'=>true,        
               'height'=>'auto',
               'width'=>'auto',
               'resizable'=>false,
              'draggable'=>false,
       ),
	'htmlOptions'=>array('style'=>'max-width:800px'),
));
?>

<div class = "main-div" style="display:none;">
       <?php if(Yii::app()->user->checkAccess('User.resetstudloginid')) { ?>
       <div class="pop-studloginid-link" >
       <?php echo CHtml::link("Reset Student Loginid",array('/user/resetstudloginid'));?>
       </div>
       <?php } ?>
       <?php if(Yii::app()->user->checkAccess('User.resetemploginid')) { ?>	
       <div class="pop-emploginid-link">
       <?php echo CHtml::link("Reset Employee Loginid",array('/user/resetemploginid'));?>
       </div>
       <?php } ?>
</div>


<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<!--student info-->

<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'stud',
	// additional javascript options for the dialog plugin
	'options'=>array(
		'title'=>'Student Information',
		'autoOpen'=>false,
		'modal'=>true,	
                'height'=>'auto',
                'width'=>210,
                'resizable'=>false,
                'draggable'=>false,
	),
));
?>

<div class="main-div" style="display:none;">
	<?php if(Yii::app()->user->checkAccess('StudentTransaction.Create')) { ?>
	<div class="pop-studadd-link">
	<?php echo CHtml::link("Add Student",array('/studentTransaction/create'));?>
	</div>
	<?php } ?>

	<?php if(Yii::app()->user->checkAccess('StudentTransaction.Admin')) { ?>
	<div class="pop-studaddfee-link">
	<?php echo CHtml::link("Add Student Fees",array('/studentTransaction/admin'));?>
	</div>
	<?php } ?>
</div>

<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>


<!--fees info-->
<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'fees',
	// additional javascript options for the dialog plugin
	'options'=>array(
		'title'=>'Fees Management',
		'autoOpen'=>false,
		'modal'=>true,	
                'height'=>'auto',
                'width'=>'auto',
                'resizable'=>false,
                 'draggable'=>false,
	),
	'htmlOptions'=>array('style'=>'max-width:425px'),
));
?>

<div class="main-div" style="display:none;">

	<?php if(Yii::app()->user->checkAccess('FeesMaster.Admin')) { ?>
	<div class="pop-feemaster-link">
	<?php echo CHtml::link("Fees Master",array('/feesMaster/admin'));?>
	</div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('MiscellaneousFeesMaster.Admin')) { ?>
        <div class="pop-miscellaneousfeesmaster-link">
        <?php echo CHtml::link("Miscellaneous Fees Master",array('/miscellaneousFeesMaster/admin'));?>
        </div>
        <?php } ?>
	<?php if(Yii::app()->user->checkAccess('MiscellaneousFeesPaymentTransaction.*')) { ?>
	<div class="pop-miscellaneousfees-link">
	<?php echo CHtml::link("Miscellaneous Fees",array('/miscellaneousFeesPaymentTransaction'));?>
	</div>
	<?php } ?>
	<?php if(Yii::app()->user->checkAccess('FeesPaymentType.Admin')) { ?>
	<div class="pop-feetype-link">
	<?php echo CHtml::link("Fees Type",array('/feesPaymentType/admin'));?>
	</div>
	<?php } ?>
		
	<?php if(Yii::app()->user->checkAccess('FeesPaymentTransaction.Addfees')) { ?>	
	<div class="pop-studaddfee-link">
	<?php echo CHtml::link("Add Student Fees",array('/feesPaymentTransaction/addfees'));?>
	</div>
	<?php } ?>

	<?php if(Yii::app()->user->checkAccess('FeesPaymentTransaction.Branch_receipt_generate_print')) { ?>	
	<div class="pop-print-recipt-link">
	<?php echo CHtml::link("Print Receipt",array('/feesPaymentTransaction/Branch_receipt_generate_print'));?>
	</div>
	<?php } ?>
	
	<?php if(Yii::app()->user->checkAccess('FeesPaymentCheque.cheque_search')) { ?>
	<div class="pop-chequereturn-link">
	<?php echo CHtml::link("Cheque Return",array('/feesPaymentCheque/cheque_search'));?>
	</div>
	<?php } ?>

	<?php if(Yii::app()->user->checkAccess('FeesPaymentTransaction.mis_report')) { ?>
	<div class="pop-misreport-link">
	<?php echo CHtml::link("MIS Report",array('/feesPaymentTransaction/mis_report'));?>
	</div>
	<?php } ?>

	<?php if(Yii::app()->user->checkAccess('FeesPaymentTransaction.Receipt_generate_print')) { ?>
	<div class="pop-range-receipt-link">
	<?php echo CHtml::link("Numberwise Receipt",array('/feesPaymentTransaction/Receipt_generate_print'));?>
	</div>
	<?php } ?>

	<?php if(Yii::app()->user->checkAccess('FeesPaymentTransaction.date_report')) { ?>
	<div class="pop-date-receipt-link">
	<?php echo CHtml::link("Datewise Receipt",array('/feesPaymentTransaction/date_report'));?>
	</div>
	<?php } ?>

	<?php if(Yii::app()->user->checkAccess('BankMaster.*')) { ?>
	<div class="pop-bankMaster-link">
	<?php echo CHtml::link("Bank Master",array('/bankMaster/admin'));?>
	</div>
	<?php } ?>
	
	<?php if(Yii::app()->user->checkAccess('FeesPaymentCheque.Admin')) { ?>
	<div class="pop-list_return_cheque-link big-string-icon">
	<?php echo CHtml::link("Return Cheque",array('/feesPaymentCheque/admin'));?>
	</div>
	<?php } ?>

	<?php if(Yii::app()->user->checkAccess('feesDetailsMaster.Admin')) { ?>
	<div class="pop-feesdetails-link">
	<?php echo CHtml::link("Fees Details",array('/feesDetailsMaster/admin'));?>
	</div>
	<?php } ?>


	<?php if(Yii::app()->user->checkAccess('StudentFeesMaster.Admin')) { ?>
	<div class="pop-studenwisefees-link">
	<?php echo CHtml::link("Student Fees",array('/studentFeesMaster/admin'));?>
	</div>
	<?php } ?>
	</div>

<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<!--masters2-->

<?php        

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'master1',
	// additional javascript options for the dialog plugin
	'options'=>array(
		'title'=>'Master',
		'autoOpen'=>false,
		'modal'=>true,	
                'height'=>'auto',
                'width'=>'auto',
                'resizable'=>false,
                'draggable'=>false,
	),
	'htmlOptions'=>array('style'=>'max-width:765px'),
));
?>

<div class="main-div" style="display:none;">

<div class="master2">

<?php if(Yii::app()->user->checkAccess('AcademicTermPeriod.Admin')) { ?>	
<div class="pop-academicTermPeriod-link">
<?php echo CHtml::link("Academic Year",array('/academicTermPeriod/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('AcademicTerm.Admin')) { ?>	
<div class="pop-academicTermName-link">
<?php echo CHtml::link("Semester",array('/academicTerm/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('BranchPassoutsemTagTable.Admin')) { ?>	
<div class="pop-branchtags-link">
<?php echo CHtml::link("Branch Tags",array('/BranchPassoutsemTagTable/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('Branch.Admin')) { ?>	
<div class="pop-branch-link">
<?php echo CHtml::link("Branch",array('/branch/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('Division.Admin')) { ?>	
<div class="pop-division-link">
<?php echo CHtml::link("Division",array('/division/admin'));?>
</div>
<?php } ?>
<?php if(Yii::app()->user->checkAccess('Batch.Admin')) { ?>	
<div class="pop-batch-link">
<?php echo CHtml::link("Batch",array('/batch/admin'));?> 
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('Category.Admin')) { ?>	
<div class="pop-category-link">
<?php echo CHtml::link("Category",array('/category/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('Department.Admin')) { ?>	
<div class="pop-department-link">
<?php echo CHtml::link("Department",array('/department/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('EmployeeDesignation.Admin')) { ?>	
<div class="pop-empdesi-link">
<?php echo CHtml::link("Employee Designation",array('/employeeDesignation/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('Nationality.Admin')) { ?>	
<div class="pop-nationality-link">
<?php echo CHtml::link("Nationality",array('/nationality/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('Quota.Admin')) { ?>	
<div class="pop-quota-link">
<?php echo CHtml::link("Quota",array('/quota/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('Religion.Admin')) { ?>	
<div class="pop-religion-link">
<?php echo CHtml::link("Religion",array('/religion/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('Shift.Admin')) { ?>	
<div class="pop-shift-link">
<?php echo CHtml::link("Shift",array('/shift/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('Country.Admin')) { ?>	
<div class="pop-country-link">
<?php echo CHtml::link("Country",array('/country/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('State.Admin')) { ?>	
<div class="pop-state-link">
<?php echo CHtml::link("State",array('/state/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('City.Admin')) { ?>	
<div class="pop-city-link">
<?php echo CHtml::link("City",array('/city/admin'));?>
</div>
<?php } ?>
<?php if(Yii::app()->user->checkAccess('Languages.Admin')) { ?>
<div class="pop-language-link">
<?php echo CHtml::link("Languages",array('/languages/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('Eduboard.Admin')) { ?>
<div class="pop-eduboard-link">
<?php echo CHtml::link("Education Board",array('/eduboard/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('Studentstatusmaster.Admin')) { ?>
<div class="pop-studentstatus-link">
<?php echo CHtml::link("Student Status",array('/Studentstatusmaster/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('Year.Admin')) { ?>
<div class="pop-year-link">
<?php echo CHtml::link("Year",array('/Year/admin'));?>
</div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('FeesTermsAndCondition.Admin')) { ?>
<div class="pop-feesterm-link">
<?php echo CHtml::link("Fees Terms & Conditions",array('/FeesTermsAndCondition/admin'));?>
</div>
<?php } ?>

<!-- 

 dialogue box link -->

</div>
</div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		    'homeLink'=>CHtml::link('Home', array('/site/newdashboard')),
		    'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->


	<?php endif?>

	<?php echo $content; ?>



</div><!-- page -->
</div><!-- content -->

	<div id="footer">
<div class="powered-by"><span class="powered-text">© Copyright 2013 Rudra Softech. All Rights Reserved.
</span><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/rudraSoftech.png" /> </div>
	</div><!-- footer -->

</body>
</html>

