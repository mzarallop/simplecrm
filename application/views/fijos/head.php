<!DOCTYPE html>
<html lang="es">
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<meta charset="utf-8">
<title><?php echo $title; ?></title>
<!-- CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/prettify.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/theme.bootstrap.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.tablesorter.pager.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/datepicker.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/general.css" type="text/css">
<?php foreach($css as $cascada): ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/<?php echo $cascada; ?>?v=<?= rand(0,99); ?>" type="text/css">
<?php endforeach; ?>
<!-- JAVASCRIPT -->


<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/notify.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/usabilidad.js"></script>
<?php foreach($js as $java):?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/<?php echo $java; ?>"></script>
<?php endforeach; ?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrO_ASb-jGw0wrubNplRUQ-_IUpUZ7reU&signed_in=true&callback=initMap"></script>
</head>
<body>
