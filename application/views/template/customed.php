<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php echo $title ?></title>

<meta name="viewport" content="width=device-width">


<link rel="stylesheet" href="<?php echo base_url(CSS."style.css");?>">
<link rel="stylesheet" href="<?php echo base_url(CSS."kendo.common.min.css");?>">
<link rel="stylesheet" href="<?php echo base_url(CSS."kendo.bootstrap.min.css");?>">


<script src="<?php echo base_url(JS."libs/modernizr-2.6.1-respond-1.1.0.min.js");?>"></script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo base_url(JS."libs/jquery-1.8.2.min.js");?>"><\/script>')</script>
<script src="<?php echo base_url(JS."libs/underscore-1.3.3.min.js");?>"></script>
<script src="<?php echo base_url(JS."plugins.js");?>"></script>
<script src="<?php echo base_url(JS."script.js");?>"></script>
<script src="<?php echo base_url(JS."kendo.web.min.js");?>"></script>
<script src="<?php echo base_url(JS."cultures/kendo.culture.km-KH.min.js");?>"></script>

<!--start kendo localization in Khmer-->
<script>
	kendo.culture("km-KH");
</script>
<!--start kendo localization in Khmer-->

<!-- Le fav and touch icons -->
<link rel="shortcut icon" href="<?php echo base_url(IMAGES.'ico/favicon.ico');?>">
<link rel="apple-touch-icon" href="<?php echo base_url(IMAGES.'ico/apple-touch-icon-precompresse.png');?>">
<link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(IMAGES.'ico/apple-touch-icon-57x57-precompressed.png');?>">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(IMAGES.'ico/apple-touch-icon-72x72-precompressed.png');?>">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(IMAGES.'ico/apple-touch-icon-114x114-precompressed.png');?>">

</head>
<body>
	<?php $this->load->view($main_content); ?>
</body>

</html>
