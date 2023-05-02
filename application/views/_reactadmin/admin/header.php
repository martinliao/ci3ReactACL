<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="<?php echo $lang; ?>">

<head>
	<meta charset="<?php echo $charset; ?>">
	<title><?php echo $title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php echo base_url(); ?>/favicon.ico">
	<?= $css ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
	<div class="preloader">
		<div class="loading">
			<img src="<?= base_url() ?>assets/img/loader.gif" width="300">
			<p class="text-center">Harap Tunggu</p>
		</div>
	</div>

	<div class="wrapper">
