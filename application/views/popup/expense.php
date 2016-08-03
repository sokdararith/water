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
				<div id="view"></div>
				<script type="text/x-kendo-template" id="template">
					<div id="payment">
						<div class="btn-group">
							<button class="btn" data-bind="disabled: paidCash, click: cashBtn">ចំណាយជាសាច់ប្រាក់</button>
							<button class="btn" data-bind="enabled: paidCash, click: cashBtn">ចំណាយជំពាក់</button>
						</div>
						<div id="cashPayment" data-bind="visible: paidCash" class="well">
							<table class="table">
								<tbody>
									<tr>
										<td>គណនីសាច់ប្រាក់</td>
										<td><input type="text" placeholder="គណនីសាច់ប្រាក់" data-bind="source: cashAccts, value: cashAcct" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 220px;"></td>
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
										<td><input type="text" placeholder="ពិពណ៍នារួម" data-bind="value: memo"></td>
									</tr>
									<tr>
										<td>Class</td>
										<td><input type="text" placeholder="រើសយក license" data-bind="source: classes, value: class_id" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 220px;"></td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>
						
						<div id="creditPayment" data-bind="invisible: paidCash" class="well">
							<table class="table">
								<tbody>
									<tr>
										<td>គណនីជំពាក់</td>
										<td><input type="text" placeholder="គណនីជំពាក់" data-bind="source: creditAccts, value: creditAcct" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 220px;"></td>
										<td>កាលបរិច្ឆេទកត់ត្រា</td>
										<td><input type="text" data-role="datepicker" placeholder="cash" data-bind="value: date" style="width: 220px;"></td>
									</tr>
									<tr>
										<td>វិធីទូទាត់</td>
										<td><input type="text" placeholder="វិធីទូទាត់" data-bind="source: paymentTerms, value: paymentTerm" data-role="combobox" data-text-field="term" data-value-field="id" style="width: 220px;"></td>
										<td>លេខសក្ខីបត្រ័</td>
										<td><input type="text" placeholder="លេខសក្ខីបត្រ័" data-bind="value: ref"></td>
									</tr>
									<tr>
										<td>ថ្ងៃត្រូវបង់ប្រាក់</td>
										<td><input type="text" data-role="datepicker" placeholder="Due Date" data-bind="value: dateDue" style="width: 220px;"></td>
										<td>ពិពណ៍នារួម</td>
										<td><input type="text" placeholder="ពិពណ៍នារួម" data-bind="value: memo"></td>
									</tr>
									<tr>
										<td>Class</td>
										<td><input type="text" placeholder="រើសយក license" data-bind="source: classes, value: class_id" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 220px;"></td>
										<td>លេខវិក្កយប័ត្រ</td>
										<td><input type="text" placeholder="លេខវិក្កយប័ត្រ" data-bind="value: invoiceNumber"></td>
									</tr>
								</tbody>
							</table>
						</div>
						<hr>
						
						<table class="table">

							<tbody data-role="grid" data-bind="source: bucket" 
													data-row-template="expenseCart"
													data-columns="[{title:'គណនី', width: '150px'},{title:'ចំនួន', width: '110px'},'ពិពណ៍នាសម្រាប់គណនីនេះ',{title:'Class', width:'140px'},{title:'', width:'50px'}]"></tbody>
						</table>
						<i class="icon-plus" data-bind="click: addToCart"></i>
						<table>
							<tr>
								<td colspan="5"><p style="text-align:right">ចំនួនដែលត្រូវទូទាត់ <span data-format="{0:C}" data-bind="text: total"></span></p></td>
							</tr>
						</table>
						<button class="btn pull-right" data-bind="click: record">កត់ត្រាប្រតិបត្តិការនេះ</button>
					</div>
				</script>
					
			</div>
		</div>
	</div>
	<script>
		var cashAccountDS, creditAccountDS, accountDS,PaymentTermDS;
		var expenseModel = kendo.observable({
			cashAccts	: cashAccountDS,
			expenseAccts: [],
			creditAccts : creditAccountDS,
			accounts 	: accountDS,
			paymentTerms : PaymentTermDS,
			classes 	: [],
			class_id 	: "",
			invoiceNumber: "",
			paymentMethod: [
				{ id: 1, method: "Cash"},
				{ id: 2, method: "Check"},
				{ id: 3, method: "Credit Card"}
			],
			close 		: function(e) {
				e.preventDefault();
				layout.showIn("#info", vendor);
				var uri = "/"+vendorModel.vendor.id;
				router.navigate(uri, false);		},
			pmtMethod 	: "",
			cashAcct 	: "",
			ExpAcct 	: "",
			creditAcct 	: "",
			checkNo 	: "",
			paymentTerm : "",		
			vendor  	: "",
			billed 		: false,
			bucket 		: [
				{bill_id: 0, account_id: "", code: 0, account_name: 0, amount: 0, memo: "", class_id: ""}
			],
			paidCash   	: true,
			checkoutBtn	: false,
			date 		: new Date(),
			ref 		: "",
			memo 		: "",
			dateDue 	: function() {
				var date;
				if(this.get("paymentTerm") !== "") {
					
					var net = parseInt(PaymentTermDS.get(this.get("paymentTerm")).net_due_in);
					var due_date = new Date(this.get("date"));
					due_date.setDate(due_date.getDate() + net);
					date = new Date(due_date);
				} else {
					date = new Date();
				}
				return date;
			},
			cashBtn 	: function() {
				if(this.get("paidCash")) {
					this.set("paidCash", false);
				} else {
					this.set("paidCash", true);
				}
			},
			cleared: false,
			addToCart 	: function(e) {
				this.bucket.push(
					{bill_id: 0, account_id: "", code: 0, account_name: 0, amount: 0, memo: "", class_id: ""}
				);
			},
			change 	: function(e) {
				for (var i = 0; i < this.bucket.length; i ++) {
		            var current = this.bucket[i];
		            if (current === e.data) {
		            	//loop through items to find the last reading
		            	for(var i=0; i<this.get("expenseAccts").length; i++) {
		            		if(this.get("expenseAccts")[i].id === e.data.account_id) {	            			
		            				current.set("memo", this.get("expenseAccts")[i].description);
		            			break;
		            		}
		            	}
		                break;
		            }
		        }
			},
			total 	: function() {
				var total=0;
				var bucket = this.get("bucket");
				if(bucket.length > 0) {
					for(var i = 0; i < bucket.length; i++) {
						total += parseFloat(bucket[i].get("amount"));
					}	
				}
				
				return total;
			},
			cartCount 	: function() {
				return this.get("bucket").length;
			},
			remove		: function(e) {
				for (var i = 0; i < this.bucket.length; i ++) {
		            var current = this.bucket[i];
		            if (current === e.data) {
		                this.bucket.splice(i, 1);
		                break;
		            }
		        }	        
		    },
			empty: function() {
		        var contents = this.get("bucket");
		        contents.splice(0, contents.length);
		        this.set("checkoutBtn", false);
		    },
		    clear: function() {
		        var contents = this.get("bucket");
		        contents.splice(0, contents.length);
		        this.set("cleared", true);
		        this.set("checkoutBtn", true);
		    },
			record 			: function() {
				var amount_due = 0;
				var amount_s =0;
				var journalEntries = [];
				if(this.cartCount() > 0) {
					if(this.get("paidCash")) {
						//3. save to journal
					
						journalEntries.push(
						 	{
						 		account_id: this.get("cashAcct"), 
						 		bill_id: 0,
						 		dr: 0, 
						 		cr: this.total(),
						 		class_id: this.get("class_id"), 
					 			memo: this.get('memo'),  
					 		});
						for(var i = 0; i<this.cartCount(); i++) {
							journalEntries.push({
						 		account_id: this.bucket[i].account_id,
						 		bill_id: 0, 
						 		dr: this.bucket[i].amount, 
						 		cr: 0, 
						 		class_id: this.get("class_id"),
						 		memo: this.bucket[i].memo, 
							});
						}

						if(journalEntries.length > 0) {
							journalDS.add({
						 		bill_id: 0,
						 		journalEntries : journalEntries,
						 		memo: this.get('memo'), 
						 		voucher: this.get('ref'),
						 		class_id: this.get("class_id"),
						 		budget_id: 0,
						 		donor_id: 0,
						 		check_no: this.get('checkNo'),
						 		people_id: vendorModel.get("vendor").id,
						 		employee_id: <?php echo $this->session->userdata('user_id'); ?>,
						 		invoice_id: 0,
						 		payment_id: 0,	
						 		date: kendo.toString(this.get("date"), "yyyy-MM-dd"), 
						 		transaction_type: "ចំណាយជាសាច់ប្រាក់",
						 		people_id: vendorModel.get("vendor").id,
						 	});
						 	journalEntries.splice(0, journalEntries.length);
						}
						journalDS.sync();
						this.empty();
						this.set("account_id", "");
						this.set("pmtMethod", "");
						this.set("class_id", "");
						this.set("checkNo", "");
						this.set("ref", "");
						this.set("memo", "");
						if(this.bucket.length > 0) {
							
							for(var i = 0; i < journalDS.data().length; i++) {
								journalDS.remove(journalDS.at(i))
							}
							bills.remove(bills.at(0));
							this.bucket.splice(0, this.bucket.length);
						}
					} else {
						console.log(this.dateDue());
						bills.add({
							type: "expense",
							vendor_id: vendorModel.get("vendor").id,
							employee_id: <?php echo $this->session->userdata('user_id'); ?>,
							bill_type: "ចំណាយជំពាក់",
							date: kendo.toString(this.get("date"), "yyyy-MM-dd"),
							due_date: kendo.toString(this.dateDue, "yyyy-MM-dd"),
							amount_due: 0,
							amount_paid: 0,
							invoice_number: this.get("invoiceNumber"),
							class_id: this.get("class_id"),
							voucher: this.get("ref"),
							amount_billed: parseFloat(this.total()),
							status: 0
						});
					}
					bills.sync();			
				} else {
					alert("cart empty");
				}
			},
			sync 			: function(billId) {
				//2. get the bill id and save to item_records table
				for(var i = 0; i < this.cartCount(); i++) {
					this.bucket[i].set("bill_id", billId);
				}
				var journalEntries = [];
				if(this.get("paidCash")) {
					
				} else {
					journalEntries.push(
					 	{
					 		account_id: this.get("creditAcct"),
					 		bill_id: billId, 
					 		payment_id: this.get("paymentTerm"),
					 		dr: 0, 
					 		cr: this.total(), 
					 		memo: this.get('memo'), 
					 		class_id: this.get("class_id")
				 		});
					for(var i = 0; i<this.cartCount(); i++) {
						journalEntries.push({
					 		account_id: this.bucket[i].account_id,
					 		bill_id: billId, 
					 		dr: this.bucket[i].amount, 
					 		cr: 0, 
					 		memo: this.bucket[i].memo,
					 		class_id: this.bucket[i].class_id
						});
					}

					if(journalEntries.length > 0) {
						journalDS.add({
					 		bill_id: billId,
					 		journalEntries : journalEntries,
					 		memo: this.get('memo'), 
					 		voucher: this.get('ref'),
					 		class_id: this.get("class_id"),
					 		budget_id: 0,
					 		donor_id: 0,
					 		check_no: this.get('checkNo'),
					 		people_id: vendorModel.get("vendor").id,
					 		employee_id: <?php echo $this->session->userdata('user_id'); ?>,
					 		invoice_id: 0,
					 		payment_id: 0,	
					 		date: kendo.toString(this.get("date"), "yyyy-MM-dd"), 
					 		transaction_type: "ចំណាយជំពាក់",
					 		people_id: vendorModel.get("vendor").id,
					 	});
					 	journalEntries.splice(0, journalEntries.length);
					}
					
				}
				journalDS.sync();
				this.empty();
				if(this.bucket.length > 0) {
					
					for(var i = 0; i < journalDS.data().length; i++) {
						journalDS.remove(journalDS.at(i))
					}
					bills.remove(bills.at(0));
					this.bucket.splice(0, this.bucket.length);
				}
			}
		});
		var view = new kendo.View("#template", {model: expenseModel});
		$(function(){
			// kendo.init($("#wrapper"));
			// kendo.bind($("#wrapper"), expenseModel);
			view.render("#view");
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
