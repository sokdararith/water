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
				<div id="payment">
					<div class="btn-group offset4">
						<button class="btn" style="width: 120px;" data-bind="disabled: paidCash, click: cashBtn">ទិញជាសាច់ប្រាក់</button>
						<button class="btn" style="width: 120px;" data-bind="enabled: paidCash, click: cashBtn">ទិញជំពាក់</button>
					</div>

					<div id="cashPayment" data-bind="visible: paidCash">
						<table class="table">
							<tbody>
								<tr>
									<td>គណនីសាច់ប្រាក់</td>
									<td><input type="text" placeholder="គណនីសាច់ប្រាក់" 
														   data-bind="source: cashAccts, value: cashAcct" 
														   data-role="combobox" 
														   data-text-field="name" 
														   data-value-field="id" style="width: 220px;"
														   name="cashAccount" 
														   required data-required-msg="សូមផ្ដល់លេខគណនីសាច់ប្រាក់">
										<span class="k-invalid-msg" data-for="cashAccount"></span>
									</td>
									<td>កាលបរិច្ឆេទកត់ត្រា</td>
									<td><input type="text" data-role="datepicker" placeholder="cash" data-bind="value: date" style="width: 220px;"></td>
								</tr>
								<tr>
									<td>វិធីទូទាត់</td>
									<td><input type="text" placeholder="វិធីទូទាត់" data-bind="source: paymentMethod, value: pmtMethod" data-role="combobox" data-text-field="method" data-value-field="id" style="width: 220px;"></td>
									<td>លេខសក្ខីបត្រ័</td>
									<td><input type="text" placeholder="លេខសក្ខីបត្រ័" data-bind="value: ref"></td>
								</tr>
								<tr>
									<td>លេខសែក</td>
									<td><input type="text" placeholder="លេខសែក" data-bind="value: checkNo"></td>
									<td>ពិពណ៍នារួម</td>
									<td><input type="text" placeholder="ពិពណ៍នាសម្រាបសាច់ប្រាក់" data-bind="value: memo"></td>
								</tr>
								<tr>
									<td>Class</td>
									<td><input type="text" placeholder="រើសយក license" data-bind="source: classes, value: class_id" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 220px;"></td>
									<td>P.O</td>
									<td>
										<input data-role="combobox"
							                   data-placeholder="ទាញពីបញ្ជាទិញ"				                   
							                   data-text-field="number"
							                   data-value-field="id"
							                   data-bind="value: po_id, source: poList, events:{ change: poChange }"
							                   style="width: 220px" />
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					
					<div id="creditPayment" data-bind="invisible: paidCash">
						<table class="table">
							<tbody>
								<tr>	
									<td>គណនីជំពាក់</td>
									<td><input type="text" placeholder="គណនីអ្នកផ្គត់ផ្គង់" 
														   data-bind="source: creditAccts, value: creditAcct" 
														   data-role="combobox" 
														   data-text-field="name" 
														   data-value-field="id" 
														   style="width: 220px;"
														   name="creditAccount" 
														   required data-required-msg="សូមផ្ដល់លេខគណនីជំពាក់">
										<span class="k-invalid-msg" data-for="creditAccount"></span>
									</td>
									<td>កាលបរិច្ឆេទកត់ត្រា</td>
									<td><input type="text" data-role="datepicker" placeholder="Date" data-bind="value: date" style="width: 220px;"></td>
								</tr>
								<tr>
									<td>វិធីទូទាត់</td>
									<td><input type="text" placeholder="វិធីទូទាត់" data-bind="source: paymentTerms, value: paymentTerm" data-role="combobox" data-text-field="term" data-value-field="id" style="width: 220px;"></td>
									<td>លេខសក្ខីបត្រ័</td>
									<td><input type="text" placeholder="លេខសក្ខីបត្រ័" data-bind="value: ref"></td>

								</tr>
								<tr>
									<td>ថ្ងៃត្រូវទូទាត់</td>
									<td><input type="text" data-role="datepicker" placeholder="Due Date" data-bind="value: due_date" style="width: 220px;"></td>
									<td>ពិពណ៍នារួម</td>
									<td><input type="text" placeholder="ពិពណ៍នាសម្រាប់គណនីជំពាក់" data-bind="value: memo"></td>
								</tr>
								<tr>
									<td>Class</td>
									<td><input type="text" placeholder="រើសយក license" data-bind="source: classes, value: class_id" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 220px;"></td>
									<td>លេខវិក្កយប័ត្រ</td>
									<td><input type="text" placeholder="លេខវិក្កយប័ត្រអ្នកផ្គត់ផ្គង់" data-bind="value: invoiceNumber"></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td>P.O</td>
									<td>
										<input data-role="combobox"
							                   data-placeholder="ទាញពីបញ្ជាទិញ"				                   
							                   data-text-field="number"
							                   data-value-field="id"
							                   data-bind="value: po_id, source: poList, events:{ change: poChange }"
							                   style="width: 220px" />
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<table class="table table-condensed">
						<tbody data-role="grid" data-bind="source: cart" data-row-template="cartTmpl" data-columns="[{title: 'ឈ្មោះសន្និធិ', width: '140px'}, {title:'ពិពណ៏នា'}, {title:'តំលៃ', width: '110px'}, {title:'ចំនួន', width: '100px'}, {title:'សរុប', width: '120px'}, {title:'', width: '40px'}]"></tbody>
					</table>
					<i class="icon-plus" data-bind="click: addToCart"></i>
					<table>
						<tbody>
							<tr>
								<td colspan="6" style="text-align:right; font-size: 30px;margin: 20px 0;">សរុប:<span data-bind="text: total"></span></td>
							</tr>
						</tbody>
					</table>
					<button class="btn btn-primary pull-right" data-bind="click: record">កត់ត្រាប្រតិបត្តិការនេះ</button>
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
