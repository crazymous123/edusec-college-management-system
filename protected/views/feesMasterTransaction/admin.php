<?php
$this->breadcrumbs=array(
	'Fees Master Transactions'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List FeesMasterTransaction', 'url'=>array('index')),
	array('label'=>'Create FeesMasterTransaction', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('fees-master-transaction-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Fees Master Transactions</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'fees-master-transaction-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
		'header'=>'SI No',
		'class'=>'IndexColumn',
		),
		//'fees_id',
		'fees_master_id',
//		'fees_desc_id',
		array(
			'name'=>'fees_details_name',
			'value'=>'$data->Rel_Fees_Details->fees_details_name',
		),
		array(
			'class'=>'MyCButtonColumn',
		),
	),
)); ?>
