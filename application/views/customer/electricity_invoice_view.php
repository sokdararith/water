<div class="row-fluid">    
	<div class="span12">
		<div id="example" class="k-content">

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
			
			<div class="row-fluid">    
				<div class="span6">
					<div class="barcodeTargetImage"></div>

					<span data-bind="text: number"></span>
					<span data-bind="text: customer_name"></span> <br>
					<span data-bind="text: address"></span>							         
				</div>
				<div class="span6">
					<table align="right" width="100%">
						<tr>
							<td>លេខវិក្កយបត្រ NO.</td>
							<td><span data-bind="text: invoice_no"></span></td>
						</tr>
						<tr>							
							<td>វិក្កយបត្រ INVOICE</td>
							<td><span data-bind="text: billing_date"></span></td>
						</tr>
						<tr>														
							<td width="150px">តំបន់ AREA</td>
							<td width="150px"><span data-bind="text: area"></span></td>							
						</tr>
						<tr>
							<td width="150px">លេខប្រអប់ BOX NO.</td>
							<td width="150px"><span data-bind="text: box_no"></span></td>						
						</tr>
						<tr>
							<td>គិតចាប់ពីថ្ងៃទី FROM</td>
							<td><span data-bind="text: date_read_from"></span></td>							
						</tr>
						<tr>
							<td>ដល់ថ្ងៃទី TO</td>
							<td><span data-bind="text: date_read_to"></span></td>
						</tr>
					</table>						 							         
				</div>								
			</div>
			
			<div class="well">
				<table class="table table-bordered">
					<tr align="center">
						<td width="150px">លេខកុងទ័រ <br> METER</td>
						<td width="50px">អំនានចាស់ <br> PREVIOUS</td>
						<td width="50px">អំនានថ្មី <br> CURRENT</td>
						<td width="50px">មេគុណ <br> <span style="font-size: smaller">MULTIPLICATION</span></td>
						<td width="70px">ប្រើប្រាស់ <br> CONSUMPTION</td>
						<td width="100px">តំលៃឯកត្តា <br> RATE</td>
						<td width="150px">តំលៃសរុប <br> AMOUNT</td>	
					</tr>
				</table>

				<div align="right">						
					<table>
						<tr>
							<td>ប្រាក់ជំពាក់ខែមុន</td>
							<td width="150px" align="right"><span data-bind="text: total_debt"></span></td>
						</tr>
						<tr>
							<td>ប្រាក់សងខែមុន</td>
							<td align="right"><span data-bind="text: total_payment"></span></td>
						</tr>
						<tr>
							<td>ប្រាក់នៅជំពាក់</td>
							<td align="right"><span data-bind="text: total_remain"></span></td>
						</tr>
					</table>
				</div>

				<table id="invoiceItemListview" class="table table-condensed">
					<thead></thead>
		            <tbody></tbody>
		            <tfoot></tfoot>			            
		        </table>

		        <table width="100%" border="1">
		        	<tr>
		        		<td width="400px" rowspan="5"></td>
		        		<td width="200px"><span class="text-left">បំណុលសរុបខែនេះ</span> <span class="text-right">TOTAL BALANCE</span></td>
		        		<td width="170px" align="right"><span data-bind="text: total"></span></td>
		        	</tr>
		        	<tr>
		        		<td>ទឹកប្រាក់ត្រូវបង់ TOTAL DUE</td>
		        		<td align="right"><span data-bind="text: total_due"></span></td>
		        	</tr>
		        	<tr>
		        		<td><span style="text-align:left">ថ្ងៃផុតកំណត់បង់ប្រាក់</span> <span style="text-align:right">DUE DATE</span></td>
		        		<td align="right"><span data-bind="text: due_date"></span></td>
		        	</tr>
		        	<tr>
		        		<td><span style="text-align: right">ថ្ងៃបង់ប្រាក់</span> <span class="text-right"> PAY DATE</span></td>
		        		<td></td>
		        	</tr>
		        	<tr>
		        		<td>ចំនួនទឹកប្រាក់បានបង់ AMOUNT</td>
		        		<td></td>
		        	</tr>
		        </table>
			</div>

			<div style="border-top: 1px dashed #000"></div>

			<br>

			<div class="well">
				<table width="100%" border="1" class="tab">
					<tr>							
						<td width="120px" rowspan="4">
							<div class="barcodeTargetImage"></div>
						</td>
						<td class="first" width="60px">វិក្កយបត្រ</td>
						<td class="first">
							<span data-bind="text: billing_date"></span>
							
							<span data-bind="text: invoice_no"></span>
						</td>
						<td width="240px">ទឹកប្រាក់ត្រូវបង់ TOTAL DUE</td>
						<td width="190px" align="right"><span data-bind="text: total_due"></td>
					</tr>
					<tr>
					    <td class="first">អតិថិជន</td>
					    <td class="first">
							<span data-bind="text: number"></span>
							<span data-bind="text: customer_name"></span>
							<span data-bind="text: phone"></span>
					    </td>
						<td>ថ្ងៃផុតកំណត់បង់ប្រាក់ DUE DATE</td>
						<td align="right"><span data-bind="text: due_date"></td>
					</tr>
					<tr>
					    <td class="first">ទីតាំងចរន្ត</td>
					    <td class="first">
							<span data-bind="text: area"></span>, 
							<span data-bind="text: box_no"></span>
					    </td>
						<td>ថ្ងៃបង់ប្រាក់ PAY DATE</td>
						<td></td>
					</tr>
					<tr>
					    <td>អាសយដ្ឋាន</td>
					    <td class="second"><span data-bind="text: address"></span></td>
						<td>ចំនួនទឹកប្រាក់បានបង់ AMOUNT</td>
						<td></td>
					</tr>
				</table>
			</div>

		</div> <!--end div example-->            
	</div> <!--End div span12-->		
</div> <!--End div row-->    


<!-- invoice item grid template -->
<script type="text/x-kendo-tmpl" id="list-tmpl">		
	<tr>
		<td width="150px">#:meter_id==0 ? description : meters.meter_no #</td>
		<td width="50px">#:prev_reading==0 ? "" : prev_reading#</td>
		<td width="50px">#:new_reading==0 ? "" : new_reading#</td>
		<td width="50px">#:multiplier==0 ? "" : multiplier#</td>
		<td width="70px">#:quantity==0 ? "" : kendo.toString(kendo.parseFloat(quantity), '0')#</td>
		<td width="100px">#:unit_price==0 ? "" : kendo.toString(kendo.parseFloat(unit_price), 'c0')#</td>
		<td width="150px" style="text-align:right">#:amount==0 ? "" : kendo.toString(kendo.parseFloat(amount), 'c0')#</td>
    </tr>
</script>

<style>
.tab {border-collapse:collapse;}
.tab .first {border-bottom:1px solid #EEE;border-left:1px solid #EEE;}
.tab .second {border-left:1px solid #EEE;}​
</style>

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
		number			:"",
		customer_name		:"",
		phone				:"",
		address 			:"",
		
		//Meter record
		area				:"",
		box_no				:"",
		date_read_from		:"",
		date_read_to		:"",
		
		//Invoice
		invoice_no			: "",				  	  
		billing_date		: "",
		due_date			: "",

		total_debt 			: 0,
		total_payment 		: 0,
		total_remain		: 0,
			
	    total				: 0,
	    total_due			: 0
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
		var d = new Date(data[0].date_read_from);
		var billedDate = "ខែ " + (parseInt(d.getMonth())+1) + " ឆ្នាំ " + d.getFullYear();
		var dueDate = kendo.toString(new Date(data[0].due_date), "dd/MM/yyyy");
		var dateFrom = kendo.toString(d, "dd/MM/yyyy");
		var dateTo = kendo.toString(new Date(data[0].date_read_to), "dd/MM/yyyy");

		viewModel.set("customer_id", data[0].customer_id);
		viewModel.set("invoice_no", data[0].number);
		viewModel.set("billing_date", billedDate);
		viewModel.set("area", data[0].area);
		viewModel.set("box_no", data[0].box_no);
		viewModel.set("date_read_from", dateFrom);
		viewModel.set("date_read_to", dateTo);
		viewModel.set("phone", data[0].phone);

		viewModel.set("number", data[0].number);
		viewModel.set("customer_name", data[0].fullname);

		var addr = data[0].house_no + ", " + data[0].street_no;
		viewModel.set("address", addr);

		$(".barcodeTargetImage").barcode(data[0].number, "code128");

		viewModel.set("due_date", dueDate);
		get_total_amount(data[0].billing_date);
	});
		

	//Get total amount invoice item
	function get_total_amount(billingDate){
		$.ajax({
			type: "GET",
			url: ARNY.baseUrl + "api/invoices/total_debt_payment",
			data: {				
				customer_id : viewModel.get("customer_id"),
				invoice_id	: inv_id,
				billing_date: billingDate
			},
			dataType: "json",
			success: function (response) {							
				viewModel.set("total_debt", kendo.toString(kendo.parseFloat(response[0].tdebt), "c0"));
				viewModel.set("total_payment", kendo.toString(kendo.parseFloat(response[0].tpayment), "c0"));
				viewModel.set("total_remain", kendo.toString(kendo.parseFloat(response[0].tremain), "c0"));

				viewModel.set("total", kendo.toString(kendo.parseFloat(response[0].tamt), "c0"));			  
				viewModel.set("total_due", kendo.toString(kendo.parseFloat(response[0].tdue), "c0"));
			}
		}); 
	}

	//Invoice Item listView	
	var invoiceItemLV = $("#invoiceItemListview tbody").kendoListView({
		dataSource : invoiceItemDS,
		template: kendo.template($("#list-tmpl").html())
	}).data("kendoListView");
	


});<!--End of document.ready-->
</script>
<style scoped>
	span .right {
		text-align: right;
	}
</style>