<?php
/* @var $this PresentationController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs = array(
    'Presentation Cvs',
);

$this->menu = array(
    array('label' => 'Create Presentation', 'url' => array('create')),
    array('label' => 'Manage Presentation', 'url' => array('admin')),
);
?>
<?php echo BSHtml::pageHeader('Presentation Cvs') ?>
<?php $this->widget('bootstrap.widgets.BsListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>