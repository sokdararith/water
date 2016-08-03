<div class="row-fluid">    
	<div class="span12">
		<div id="example">

			<div class="print">
				<div class="hidden-print">
					<button type="button" class="btn btn-default" data-bind="click: printInvoice"><i class="icon-print"></i></button>																			
				</div>
				
		  		<table width="100%">
			    	<tr>
			    		<td valign="top" align="left" width="250">
			    			<img data-bind="attr: { src: image_url }" alt="logo" height="200" width="300" >			    			
			    		</td>
			    		<td style="float:left;">
			    			<div class="center">
				    			<h4><span data-bind="text: company_name"></span></h4>
								<p>									
									<span data-bind="text: company_address"></span> <br>
									<span data-bind="text: company_phone"></span> /
									<span data-bind="text: company_mobile"></span>							
								</p>
							</div>
			    		</td>
			    	</tr>
			    </table>

			    <h3 align="center" data-bind="text: title"></h3>							
			
				<div class="row-fluid">
					<div class="span12">
						<div class="span5">
							អាសយដ្ឋាន
							<br>
							<textarea id="memo" cols="0" rows="2" class="k-textbox" style="width:250px" data-bind="value: address"></textarea>
						</div>

						<div class="span5">
							<table align="right">								
								<tr>								
									<td></td>
									<td>
										<span id="barcode"></span>									
									</td>							
								</tr>							
								<tr>									
									<td>លេខវិក្កយបត្រ</td>
									<td><span data-bind="text: number"></span></td>
								</tr>
								<tr>
									
									<td>កាលបរិច្ឆេទ</td>
									<td><span data-bind="text: issued_date"></span></td>
								</tr>												
							</table>	
						</div>
					</div>									
				</div>

				
				<div id="grid" data-role="grid" data-bind="source: invoiceItemList"
			        data-row-template="invoiceItemRowTemplate"                  
			        data-columns='[{ title: "#", width: 35 }, 
			            { title: "ទំនិញ", width: 175 },	                     
			            { title: "ពណ៌នា", width: 200 },
			            { title: "ចំនួន", width: 95 },
			            { title: "តំលៃ", width: 115 },	                    	                     
			            { title: "VAT", width: 80 },
			            { title: "ទឹកប្រាក់" }	                    	                    
			            ]'>
				</div>

				<br>
				
				<table align="right">
					<tr>
						<td>សរុប</td>
						<td align="right" width="200px"><span data-bind="text: total"></span></td>
					</tr>
				</table>
			</div>

		</div> <!--end div example-->            
	</div> <!--End div span12-->		
</div> <!--End div row-fluid-->

<!-- invoice item grid template -->
<script id="invoiceItemRowTemplate" type="text/x-kendo-tmpl">		
	<tr>
		<td>#= ++no #</td>
		<td>#:items.item_sku#</td>
		<td>#:description#</td>		
		<td>#:kendo.toString(kendo.parseFloat(quantity), '0')#</td>		
		<td>#:kendo.toString(kendo.parseFloat(unit_price), 'c0')#</td>
		<td>#:kendo.toString(kendo.parseFloat(vat), 'c0')#</td>
		<td style="text-align:right">#:kendo.toString(kendo.parseFloat(amount), 'c0')#</td>		
    </tr>
</script>

<script>
var no = 0;

$(document).ready(function() {
var i = 0;
var id = "<?php echo $this->uri->segment(3); ?>";

var invoiceDS = new kendo.data.DataSource({
  	transport: {	  
	  	read: {
		  	url : ARNY.baseUrl + "api/invoices/invoice_for_customer",
		  	type: "GET",
		  	dataType: "json",
		  	data:{
		  		invoice_id : id
		  	}			  		  
	  	}
  	}
});

var invoiceItemDS = new kendo.data.DataSource({
  	transport: {	  
	  	read: {
		  	url : ARNY.baseUrl + "api/invoice_items/invoice_item",
		  	type: "GET",
		  	dataType: "json"  
	  	}
  	},  	 	  	
  	filter: { field: "invoice_id", value: id },
  	serverFiltering: true
});

var companyDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/companies/company",
			type: "GET",
			dataType: "json"
		}
	}		
});

companyDS.fetch(function(){
	var data = this.data();
	var imgUrl = ARNY.baseUrl + data[0].image_url;

	viewModel.set("company_name", data[0].name);
	viewModel.set("company_address", data[0].address);
	viewModel.set("company_mobile", data[0].mobile);
	viewModel.set("company_phone", data[0].phone);
	viewModel.set("image_url", imgUrl);	  
});

//Bind invoice
invoiceDS.fetch(function(){
	var data = this.data();		

	viewModel.set("customer_id", data[0].customer_id);
	viewModel.set("number", data[0].number);
	viewModel.set("number", data[0].number);
	viewModel.set("issued_date", kendo.toString(new Date(data[0].issued_date), "dd-MM-yyyy"));
	viewModel.set("total", kendo.toString(kendo.parseFloat(data[0].amount), "c0"));	
	viewModel.set("address", data[0].address);

	var type = data[0].type;
	if(type==='Receipt'){
		viewModel.set("title", "បង្គាន់ដៃលក់ជាសាច់ប្រាក់");
	}else if(type==='Estimate'){
		viewModel.set("title", "សម្រង់តម្លៃ");
	}else if(type==='GDN'){
		viewModel.set("title", "លិខិតដឹកជញ្ជូន");
		var grid = $("#grid").data("kendoGrid");
		grid.hideColumn(4);
		grid.hideColumn(5);
		grid.hideColumn(6);		
	}else if(type==='SO'){
		viewModel.set("title", "បញ្ជាលក់");
	}else{
		viewModel.set("title", "វិក្កយបត្រ");
	}
		
	viewModel.autoIncreaseNo();
	viewModel.barcod();
});

//View model
var viewModel = kendo.observable({
	total 				: 0,	
	invoiceItemList 	: invoiceItemDS,
	
	autoIncreaseNo 		: function(){
		$(".sno").each(function(index,element){                 
		   $(element).text(index + 1); 
		});
	},	
	barcod 				: function(){
		var cusNo = this.get("number");
		$("#barcode").kendoBarcode({
		  	value: cusNo,
		  	width: 200,
			height: 30,
			text:{
			    visible: false
			}				
		});			
	},	
	printInvoice : function(){
		javascript:window.print();
	}
});
kendo.bind($("#example"), viewModel);


});//End document ready
</script>