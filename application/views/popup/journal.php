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
<link rel="stylesheet" href="<?php echo base_url(CSS."kendo.common.min.css");?>">
<link rel="stylesheet" href="<?php echo base_url(CSS."kendo.flat.min.css");?>">
<link rel="stylesheet" href="<?php echo base_url(CSS."kendo.dataviz.min.css");?>">
<link rel="stylesheet" href="<?php echo base_url(CSS."kendo.dataviz.flat.min.css");?>">

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


<link rel="stylesheet" href="<?php echo base_url(); ?>resources/fonts/stylesheet.css" type="text/css" charset="utf-8" />

<script src="<?php echo base_url(JS."libs/modernizr-2.6.1-respond-1.1.0.min.js");?>"></script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
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

<!-- DateTimePicker Plugin -->
<link href="<?php echo base_url();?>resources/common/theme/scripts/plugins/forms/bootstrap-datetimepicker/css/datetimepicker.css" rel="stylesheet" />

<!-- JQueryUI -->
<link href="<?php echo base_url();?>resources/common/theme/scripts/plugins/system/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" />

<!-- MiniColors ColorPicker Plugin -->
<link href="<?php echo base_url();?>resources/common/theme/scripts/plugins/color/jquery-miniColors/jquery.miniColors.css" rel="stylesheet" />

<!-- Notyfy Notifications Plugin -->
<link href="<?php echo base_url();?>resources/common/theme/scripts/plugins/notifications/notyfy/jquery.notyfy.css" rel="stylesheet" />
<link href="<?php echo base_url();?>resources/common/theme/scripts/plugins/notifications/notyfy/themes/default.css" rel="stylesheet" />

<!-- Gritter Notifications Plugin -->
<link href="<?php echo base_url();?>resources/common/theme/scripts/plugins/notifications/Gritter/css/jquery.gritter.css" rel="stylesheet" />

<!-- Easy-pie Plugin -->
<link href="<?php echo base_url();?>resources/common/theme/scripts/plugins/charts/easy-pie/jquery.easy-pie-chart.css" rel="stylesheet" />

<!-- Google Code Prettify Plugin -->
<link href="<?php echo base_url();?>resources/common/theme/scripts/plugins/other/google-code-prettify/prettify.css" rel="stylesheet" />

<!-- Select2 Plugin -->
<link href="<?php echo base_url();?>resources/common/theme/scripts/plugins/forms/select2/select2.css" rel="stylesheet" />

<!-- Pageguide Guided Tour Plugin -->
<!--[if gt IE 8]><!--><link media="screen" href="<?php echo base_url();?>resources/common/theme/scripts/plugins/other/pageguide/css/pageguide.css" rel="stylesheet" /><!--<![endif]-->

<!-- Bootstrap Image Gallery -->
<link href="<?php echo base_url();?>resources/common/bootstrap/extend/bootstrap-image-gallery/css/bootstrap-image-gallery.min.css" rel="stylesheet" />

<!-- Main Theme Stylesheet :: CSS -->
<link href="<?php echo base_url();?>resources/common/theme/css/style-default-menus-dark.css?1374506511" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>resources/common/theme/skins/css/blue-gray.css" rel="stylesheet" type="text/css" />

<style>
	#module-image {
		list-style: none;
	}
	#module-image li {
		width: 145px;
		float: left;
		margin: 5px;
	}
</style>

<!-- FireBug Lite -->
<!-- <script src="https://getfirebug.com/firebug-lite-debug.js"></script> -->

<!-- LESS.js Library -->
<script src="<?php echo base_url();?>resources/common/theme/scripts/plugins/system/less.min.js"></script>

<!-- Print JS -->
<script src="<?php echo base_url();?>resources/js/jquery.print.js"></script>

<!-- Global -->
<script>
//<![CDATA[
var basePath = '',
	commonPath = '<?php echo base_url();?>resources/common/';
//]]>
</script>


<script src="<?php echo base_url(JS."kendo.all.min.js");?>"></script>

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
<body class="document-body ">
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span9" id="wrapper">
				<div class="row-fluid">
					<div class="span12">
							<h2 style="text-align: center;">កត់ត្រាទិន្នានុប្បវត្តិ</h2>
	<div id="application">
		<div class="well">
			<input type="text" data-role="datepicker" data-bind="value: date">
			<input type="text" placeholder="លេខសក្ខីបត្រ័" data-bind="value: entryNumber" style="margin-top: 10px;">
		</div>
		<i class="icon-plus" data-bind="click: addNew"></i>
		<div id="grid" data-role="grid" 
				 	   data-bind="source: journalItem.items" 
				 	   data-row-template="gridTmpl" 
				 	   data-columns="[
				 	   	  {title: 'គណនី', width:'265px'},
				 	   	  {title:'ឥណពន្ធ (Dr.)', width:'120px'},
				 	   	  {title:'ឥណទាន (Cr.)', width:'120px'},
				 	   	  {title:'Class', width:'180px'},
				 	   	  {title:'ពិពណ៍នា'},
				 	   	  {title:'', width:'30px'}]"></div>
		<table class="table">
			<tbody>
				<tr>
					<td width="310"></td>
					<td width="103"><span data-bind="text: debit"></span></td>
					<td width="103"><span data-bind="text: credit"></span></td>
					<td></td>
				</tr>
				<tr>
					<td width="310">លំអៀង </td>
					<td width="103"><span data-bind="text: dif"></span></td>
					<td width="103"></td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<div class="span3 pull-right">
			<button class="btn pull-right" data-bind="click: cancel">មិនយក</button>
			<button class="btn pull-right" data-bind="click: record">កត់ត្រាប្រត្តិការនេះ</button>
		</div>
		<span data-bind="text: journalItem.items.account_id"></span>
	</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(function(){
			kendo.init($("#wrapper"));
		});
	</script>
	<script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>
</body>
</html>
