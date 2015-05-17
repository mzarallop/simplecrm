<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $title; ?></title>
<!-- CSS -->
<link href='http://fonts.googleapis.com/css?family=Archivo+Narrow' rel='stylesheet' type='text/css'>
<?php foreach($css as $cascada): ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/<?php echo $cascada; ?>?v=<?= rand(0,99)  ?>" type="text/css">
<?php endforeach; ?>
<!-- JAVASCRIPT -->
<?php foreach($js as $java):?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/<?php echo $java; ?>"></script>
<?php endforeach; ?>

</head>
<body>
