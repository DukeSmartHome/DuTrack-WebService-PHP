<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Reciever Test Form</title>
</head>

<style>
	label, input {
		display: block;
	}
</style>
<body>

<?php
// copied from controllers/reciever.php _map_post_data_for_model()
$post_data_map = array(
	'id'	=> 'device_id',
	'h'		=> 'heading',
	'la'	=> 'latitude',
	'lo'   	=> 'longitude',
	's'   	=> 'speed',
	't'   	=> 'timestamp',
);

$defaults = array(
	'device_id' => '1',
	'heading' => '123.56',
	'latitude' => '3601.1512N',
	'longitude' => '07856.7354W',
	'speed' => '45.67',
	'timestamp' => '013726.010311',
);

$action_url = '/receiver/event/';
if ($debug) $action_url . 'debug';
?>

<?=form_open('/receiver/event/')?>
	<? foreach($post_data_map as $name=>$title):?>
		<?=form_label($title, $name)?>
		<?=form_input(array('name'=>$name), $defaults[$title])?>
	<? endforeach;?>
	<?=form_submit('submit', 'Submit')?>
<?=form_close()?>
</body>
</html>