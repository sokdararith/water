<div class="row-fluid">    
	<div class="span12">
		<div id="example" class="k-content">
			<button type="button" class="btn btn-default hidden-print" data-bind="click: printInvoice"><i class="icon-print"></i></button>

			<div class="row-fluid">    
				<div class="span4">
					<img data-bind="attr: { src: image_url }" alt="" >						         
				</div> 
				<div class="span4">
					<h1 align="center"><span data-bind="text: company_name"></span></h1>
					<p align="center">
						<span data-bind="text: company_address"></span> <br>
						<span data-bind="text: phone"></span> /
						<span data-bind="text: mobile"></span>							
					</p>						    
				</div>					
			</div>				
					
			<h3 align="center" data-bind="text: title"></h3>
			
			<div class="row-fluid">
				<div class="span6">
					អាសយដ្ឋាន
					<br>
					<textarea id="address" cols="" rows="3" data-bind="value: address"></textarea>
				</div>
				<div class="span6 pull-right">						
					<table width="100%">
						<tr>
							<td>កាលបរិច្ឆេទ</td>
							<td><span data-bind="text: issued_date"></span></td>
						</tr>
						<tr>
							<td>លេខវិក្កយបត្រ</td>
							<td><span data-bind="text: invoice_no"></span></td>
						</tr>												
					</table>
				</div>
			</div>								
			
			<div id="grid"></div>

			<br>
			
			<table align="right">
				<tr>
					<td>សរុប</td>
					<td align="right" width="200px"><span data-bind="text: total"></span></td>
				</tr>
			</table>
						

		</div> <!--end div example-->            
	</div> <!--End div span12-->		
</div> <!--End div row-->    


<!-- invoice item grid template -->
<script id="rowTemplate" type="text/x-kendo-tmpl">		
	<tr>
		<td>#:items.name#</td>
		<td>#:description#</td>		
		<td>#:kendo.toString(kendo.parseFloat(quantity), '0')#</td>
		<td>#:kendo.toString(kendo.parseFloat(unit_price), 'c0')#</td>
		<td style="text-align:right">#:kendo.toString(kendo.parseFloat(amount), 'c0')#</td>
    </tr>
</script>

<script>
$(document).ready(function() {
	var inv_id = <?php echo $invoice_id;?>;

	//View model
	var viewModel = kendo.observable({
		//Company
		company_name		:"",
		company_address		:"",
		mobile				:"",
		phone				:"",
		image_url			:"",

		//Customer
		customer_id 		: 0,
		address				: "",				
		
		//Invoice
		title 				: "វិក្កយបត្រ",
		invoice_no			: "",				  	  
		issued_date			: "",
				
	    total				: 0,

	    printInvoice : function(){
			javascript:window.print();
		}	    
	});  
	kendo.bind($("#example"), viewModel);

	//Company datasource
	var companyDS = new kendo.data.DataSource({
	  transport: {	  
		  read: {
			  url : ARNY.baseUrl + "api/companies/index",
			  type: "GET",
			  dataType: "json"			  		  
		  }
	  }
	});
	
	//Invoice datasource
	var invoiceDS = new kendo.data.DataSource({
	  transport: {	  
		  read: {
			  url : ARNY.baseUrl + "api/invoices/invoice_for_customer",
			  type: "GET",
			  dataType: "json",
			  data:{
			  	invoice_id : inv_id
			  }			  		  
		  }
	  }
	});

	//Invoice item datasource
	var invoiceItemDS = new kendo.data.DataSource({
	  	transport: {	  
		  	read: {
			  	url : ARNY.baseUrl + "api/invoice_items/invoice_item",
			  	type: "GET",
			  	dataType: "json"  
		  	}
	  	},	  	  	
	  	filter: { field: "invoice_id", value: inv_id },
	  	serverFiltering: true
	});

	//Bind company
	companyDS.fetch(function(){
	  var data = this.data();
	  var imgUrl = ARNY.baseUrl + data[0].image_url;

	  viewModel.set("company_name", data[0].name);
	  viewModel.set("company_address", data[0].address);
	  viewModel.set("mobile", data[0].mobile);
	  viewModel.set("phone", data[0].phone);
	  viewModel.set("image_url", imgUrl);	  
	});

	//Bind invoice
	invoiceDS.fetch(function(){
		var data = this.data();		

		viewModel.set("customer_id", data[0].customer_id);
		viewModel.set("invoice_no", data[0].number);
		viewModel.set("issued_date", kendo.toString(new Date(data[0].issued_date), "dd-MM-yyyy"));		
		
		var addr = data[0].house_no +' '+ data[0].street_no;
		viewModel.set("address", addr);

		var type = data[0].type;
		if(type==='Receipt'){
			viewModel.set("title", "បង្គាន់ដៃលក់ជាសាច់ប្រាក់");
		}else if(type==='Estimate'){
			viewModel.set("title", "សម្រង់តម្លៃ");
		}else if(type==='GDN'){
			viewModel.set("title", "លិខិតដឹកជញ្ជូន");
		}else if(type==='SO'){
			viewModel.set("title", "បញ្ជាលក់");
		}else{
			viewModel.set("title", "វិក្កយបត្រ");
		}
		
		get_total_amount();
	});

	//Get total amount invoice item
	function get_total_amount(){
		$.ajax({
			type: "GET",
			url: ARNY.baseUrl + "api/invoices/total_debt_payment",
			data: {				
				customer_id : viewModel.get("customer_id"),
				invoice_id	: inv_id
			},
			dataType: "json",
			success: function (response) {
				viewModel.set("total", kendo.toString(kendo.parseFloat(response[0].tamt), "c0"));				
			}
		}); 
	}

	//Invoice Item 	
	var grid = $("#grid").kendoGrid({
		dataSource : invoiceItemDS,
		rowTemplate: kendo.template($("#rowTemplate").html()),
		columns: [
			{ title: "ទំនិញ" },
            { title: "ពណ៌នា" },
            { title:"ចំនួន" },
            { title:"តំលៃឯកត្តា" },
            { title:"ទឹកប្រាក់" }            
        ]
	}).data("kendoGrid");
	


});<!-- //End of document.ready-->
</script>
