<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie lt-ie9 lt-ie8 lt-ie7 fluid top-full menuh-top sticky-top"> <![endif]-->
<!--[if IE 7]>    <html class="ie lt-ie9 lt-ie8 fluid top-full menuh-top sticky-top"> <![endif]-->
<!--[if IE 8]>    <html class="ie lt-ie9 fluid top-full menuh-top sticky-top"> <![endif]-->
<!--[if gt IE 8]> <html class="animations ie gt-ie8 fluid top-full menuh-top sticky-top"> <![endif]-->
<!--[if !IE]><!--><html class="animations fluid top-full menuh-top sticky-top"><!-- <![endif]-->
<head>
<title><?php echo $title ?></title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
<meta name="description" content="<?php echo $description ?>" />
<meta name="keywords" content="<?php echo $keywords ?>" />
<meta name="author" content="<?php echo $author ?>" />

<!-- Kendo UI -->
<link rel="stylesheet" href="<?php echo base_url(JS."kendoui/styles/kendo.common.min.css");?>">
<link rel="stylesheet" href="<?php echo base_url(JS."kendoui/styles/kendo.bootstrap.min.css");?>">
<link rel="stylesheet" href="<?php echo base_url(JS."kendoui/styles/kendo.dataviz.material.min.css");?>">
<link rel="stylesheet" href="<?php echo base_url(JS."kendoui/styles/kendo.dataviz.bootstrap.min.css");?>">

<!-- Bootstrap -->
<link rel="stylesheet" href="<?php echo base_url();?>resources/common/bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url();?>resources/common/bootstrap/css/responsive.css">

<!-- Glyphicons Font Icons -->
<link href="<?php echo base_url();?>resources/common/theme/fonts/glyphicons/css/glyphicons.css" rel="stylesheet" />

<link rel="stylesheet" href="<?php echo base_url();?>resources/common/theme/fonts/font-awesome/css/font-awesome.min.css">
<!--[if IE 7]><link rel="stylesheet" href="../../../../../common/theme/fonts/font-awesome/css/font-awesome-ie7.min.css"><![endif]-->

<!-- Uniform Pretty Checkboxes -->
<link href="<?php echo base_url();?>resources/common/theme/scripts/plugins/forms/pixelmatrix-uniform/css/uniform.default.css" rel="stylesheet" />

<!-- PrettyPhoto -->
<link href="<?php echo base_url();?>resources/common/theme/scripts/plugins/gallery/prettyphoto/css/prettyPhoto.css" rel="stylesheet" />



<!-- extra CSS-->
<?php foreach($css as $c):?>
<link rel="stylesheet" href="<?php echo base_url().CSS.$c?>">
<?php endforeach;?>

<!-- extra fonts-->
<?php foreach($fonts as $f):?>
<link href="https://fonts.googleapis.com/css?family=<?php echo $f?>"
	rel="stylesheet" type="text/css">
<?php endforeach;?>


<script src="<?php echo base_url(JS."libs/modernizr-2.6.1-respond-1.1.0.min.js");?>"></script>

<script>window.jQuery || document.write('<script src="<?php echo base_url(JS."libs/jquery-1.8.2.min.js");?>"><\/script>')</script>
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
  <script src="<?php echo base_url();?>resources/common/theme/scripts/plugins/system/html5shiv.js"></script>
<![endif]-->

<!--[if IE]><!--><script src="<?php echo base_url();?>resources/common/theme/scripts/plugins/other/excanvas/excanvas.js"></script><!--<![endif]-->
<!--[if lt IE 8]><script src="../../../../../common/theme/scripts/plugins/other/json2.js"></script><![endif]-->

<!-- Bootstrap Extended -->
<link href="<?php echo base_url();?>resources/common/bootstrap/extend/jasny-fileupload/css/fileupload.css" rel="stylesheet">
<link href="<?php echo base_url();?>resources/common/bootstrap/extend/bootstrap-wysihtml5/css/bootstrap-wysihtml5-0.0.2.css" rel="stylesheet">
<link href="<?php echo base_url();?>resources/common/bootstrap/extend/bootstrap-select/bootstrap-select.css" rel="stylesheet" />
<link href="<?php echo base_url();?>resources/common/bootstrap/extend/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" rel="stylesheet" />

<!-- JQueryUI -->
<link href="<?php echo base_url();?>resources/common/theme/scripts/plugins/system/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" />

<!-- Notyfy Notifications Plugin -->
<link href="<?php echo base_url();?>resources/common/theme/scripts/plugins/notifications/notyfy/jquery.notyfy.css" rel="stylesheet" />
<link href="<?php echo base_url();?>resources/common/theme/scripts/plugins/notifications/notyfy/themes/default.css" rel="stylesheet" />

<!-- Gritter Notifications Plugin -->
<link href="<?php echo base_url();?>resources/common/theme/scripts/plugins/notifications/Gritter/css/jquery.gritter.css" rel="stylesheet" />

<!-- Google Code Prettify Plugin -->
<link href="<?php echo base_url();?>resources/common/theme/scripts/plugins/other/google-code-prettify/prettify.css" rel="stylesheet" />

<!-- Pageguide Guided Tour Plugin -->
<!--[if gt IE 8]><!--><link media="screen" href="<?php echo base_url();?>resources/common/theme/scripts/plugins/other/pageguide/css/pageguide.css" rel="stylesheet" /><!--<![endif]-->

<!-- Bootstrap Image Gallery -->
<link href="<?php echo base_url();?>resources/common/bootstrap/extend/bootstrap-image-gallery/css/bootstrap-image-gallery.min.css" rel="stylesheet" />

<!-- Main Theme Stylesheet :: CSS -->
<link href="<?php echo base_url();?>resources/common/theme/css/style-default-menus-dark.css?1374506511" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>resources/common/theme/skins/css/blue-gray.css" rel="stylesheet" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Content:400,700' rel='stylesheet' type='text/css'>
<style>
	
	#module-image {
		list-style: none;
	}
	#module-image li {
		width: 145px;
		float: left;
		margin: 0.5px;
	}
	.main {
		border: 1px solid #C8C8C8;
		padding: 1px;
		margin: 0;
		padding-top: 0;
	}
	.full-height {
		height: 100%;
		min-height: 100%;
	}
	.mainContainer {
		min-height: 100%;
		height: 100%;
		margin 0 auto -40px;
	}
	#content {
		margin-top: -20px;
	}
	.vendor {
		list-style: none;
		padding: 0;
		margin: 0;
	}
	.vendor>li {
		padding: 2px;
	}
	.k-listview {
		border: 0;
	}
	.k-listview>li(even){
		border-top: 1px solid #cccccc;
	}

	input.k-textbox {
		height: 30px;
		width: 220px;
		line-height: 30px;
		vertical-align: middle;
		border-radius: 5px;
	}

	.brand {
		color: #ffffff;
	}
</style>

<!-- Global -->
<script>
//<![CDATA[
var basePath = '',
	commonPath = '<?php echo base_url();?>resources/common/';

// colors
var primaryColor = '#5dd9c8',
	dangerColor = '#b55151',
	successColor = '#609450',
	warningColor = '#ab7a4b',
	inverseColor = '#45484d';

var themerPrimaryColor = primaryColor;
//]]>
</script>

<script src="<?php echo base_url(JS."kendoui/js/kendo.all.min.js");?>"></script>
<script src="<?php echo base_url(JS."kendoui/js/cultures/kendo.culture.km-KH.min.js");?>"></script>
<script src="<?php echo base_url(JS."kendoui/js/cultures/kendo.culture.th-TH.min.js");?>"></script>
<script src="<?php echo base_url(JS."kendoui/js/cultures/kendo.culture.vi-VN.min.js");?>"></script>
<!-- LESS.js Library -->
<script src="<?php echo base_url();?>resources/common/theme/scripts/plugins/system/less.min.js"></script>

<!-- Print JS -->
<script src="<?php echo base_url();?>resources/js/jquery.print.js"></script>
<script src="<?php echo base_url();?>resources/common/theme/scripts/demo/megamenu.js?1374506514"></script>

<script src="<?php echo base_url();?>resources/js/language/km-KH.js"></script>
<script src="<?php echo base_url();?>resources/js/language/en-US.js"></script>

<!--start kendo localization in Khmer-->
<script>
	kendo.pdf.defineFont({
		"Battambang" 		: "<?php echo base_url(); ?>resources/fonts/Battambang-Regular.ttf",
		"Battambang|Bold"	: "<?php echo base_url(); ?>resources/fonts/Battambang-Bold.ttf",
	});
</script>
<!--start kendo localization in Khmer-->

<!-- Le fav and touch icons -->
<link rel="shortcut icon" href="<?php echo base_url(IMAGES.'ico/favicon.ico');?>">
<link rel="apple-touch-icon" href="<?php echo base_url(IMAGES.'ico/apple-touch-icon-precompresse.png');?>">
<link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(IMAGES.'ico/apple-touch-icon-57x57-precompressed.png');?>">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(IMAGES.'ico/apple-touch-icon-72x72-precompressed.png');?>">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(IMAGES.'ico/apple-touch-icon-114x114-precompressed.png');?>">

</head>
<body class="document-body ">
	<?php echo $body ?>

	<!-- extra js-->
	<?php foreach($javascript as $js):?>
	<script defer src="<?php echo base_url().JS.$js?>"></script>
	<?php endforeach;?>
	
	<script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>
</body>
</html>
