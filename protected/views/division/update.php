<?php
$this->breadcrumbs=array(
	'Divisions'=>array('admin'),
	//$model->division_name=>array('view','id'=>$model->division_id),
	$model->division_name,
	'Edit',
);

$this->menu=array(
//	array('label'=>'', 'url'=>array('index')),
	array('label'=>'', 'url'=>array('create'),'linkOptions'=>array('class'=>'Create','title'=>'Add')),
	array('label'=>'', 'url'=>array('view', 'id'=>$model->division_id),'linkOptions'=>array('class'=>'View','title'=>'View')),
	array('label'=>'', 'url'=>array('admin'),'linkOptions'=>array('class'=>'Manage','title'=>'Manage')),
);
?>

<h1>Edit Division <?php //echo $model->division_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
