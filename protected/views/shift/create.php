<?php
$this->breadcrumbs=array(
	'Shifts'=>array('admin'),
	'Add',
);

$this->menu=array(
//	array('label'=>'List Shift', 'url'=>array('index')),
	array('label'=>'', 'url'=>array('admin'),'linkOptions'=>array('class'=>'Manage','title'=>'Manage')),
);
?>

<h1>Add Shift</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
