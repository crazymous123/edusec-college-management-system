<script>
$(function () {
    $('.checkall').click(function () {
        $(this).parents('fieldset:eq(0)').find(':checkbox').attr('checked', this.checked);
    });
});
</script>
<fieldset>
    <!-- these will be affected by check all -->
    <div><input type="checkbox" class="checkall"> Check All</div></br>
 

<?php 

echo Yii::app()->user->getFlash('no_criteria');




?>

<input  type="hidden" name="query" value="<?php echo $query;?>" />

<div class="row">
<input tabindex="9" type="checkbox" name="stud_info[]" id="student_enroll_no" value="student_enroll_no" />&nbsp;Enrollment Number 
</div>
 
<div class="row">
<input tabindex="10" type="checkbox" name="stud_info[]" id="student_roll_no" value="student_roll_no" />&nbsp;Roll Number
</div>
 
 	
<div class="row">
<input tabindex="11" type="checkbox" name="stud_info[]" id="student_merit_no" value="student_merit_no" />&nbsp;Merit Number
</div>
 

<div class="row">
<input tabindex="12" type="checkbox" name="stud_info[]" id="student_first_name" value="student_first_name" /> &nbsp;First Name
</div>
 
	 	
<div class="row">
<input tabindex="13" type="checkbox" name="stud_info[]" id="student_middle_name" value="student_middle_name" /> &nbsp;Middle Name
</div>
 
	
<div class="row">
<input tabindex="14" type="checkbox" name="stud_info[]" id="student_last_name" value="student_last_name" /> &nbsp;Last Name
</div>
 

<div class="row">
<input tabindex="15" type="checkbox" name="stud_info[]" id="student_mother_name" value="student_mother_name" /> &nbsp;Mother Name
</div>
 

<div class="row">
<input tabindex="16" type="checkbox" name="stud_info[]" id="quota_name" value="quota_name" /> &nbsp;Quota
</div>
 

<div class="row">
<input tabindex="17" type="checkbox" name="stud_info[]" id="sem" value="sem" /> &nbsp;Semester
</div>
 

<div class="row">
<input tabindex="18" type="checkbox" name="stud_info[]" id="category_name" value="category_name" /> &nbsp;Category
</div>
 

<div class="row">
<input tabindex="19" type="checkbox" name="stud_info[]" id="city" value="city" /> &nbsp;City
</div>
 

<div class="row">
<input tabindex="20" type="checkbox" name="stud_info[]" id="branch_name" value="branch_name" /> &nbsp;Branch Name
</div>
 

<div class="row">
<input tabindex="21" type="checkbox" name="stud_info[]" id="division_code" value="division_code" /> &nbsp;Division Name
</div>
 

<div class="row">
<input tabindex="22" type="checkbox" name="stud_info[]" id="student_address_c_line1" value="student_address_c_line1" /> &nbsp;Current Address
</div>

<div class="row">
<input tabindex="23" type="checkbox" name="stud_info[]" id="student_address_p_line1" value="student_address_p_line1" /> &nbsp;Permenent Address
</div>
<div class="row">
<input tabindex="24" type="checkbox" name="stud_info[]" id="student_bloodgroup" value="student_bloodgroup" /> &nbsp;Blood Group
</div>
 <div class="row">
<input tabindex="25" type="checkbox" name="stud_info[]" id="student_guardian_mobile" value="student_guardian_mobile" /> &nbsp;Guardian Mobile
</div>
<div class="row">
<input tabindex="26" type="checkbox" name="stud_info[]" id="student_gender" value="student_gender" /> &nbsp;Gender
</div>

<div class="row">
<input tabindex="27" type="checkbox" name="stud_info[]" id="student_dob", value="student_dob" />&nbsp;Birthdate
</div>


<div class="row">
<input tabindex="28" type="checkbox" name="stud_info[]" id="student_guardian_phoneno" value="student_guardian_phoneno" /> &nbsp;Phone No
</div>

<div class="row">
<input tabindex="29" type="checkbox" name="stud_info[]" id="student_mobile_no", value="student_mobile_no" />&nbsp;Mobile No 
</div>
 
<div class="row">
<input tabindex="30" type="checkbox" name="stud_info[]" id="student_email_id_1" value="student_email_id_1" />&nbsp;College Email-ID 
</div>

<div class="row">
<input tabindex="31" type="checkbox" name="stud_info[]" id="student_email_id_2" value="student_email_id_2" />&nbsp;Email-ID 
</div>

<div class="row">
<input tabindex="32" type="checkbox" name="stud_info[]" id="student_adm_date" value="student_adm_date" />&nbsp;ACPC Admission Date 
</div>
</fieldset>



