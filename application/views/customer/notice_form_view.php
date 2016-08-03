<div class="row-fluid">    
	<div class="span12">
		<div id="example" class="k-content">

			<div class="row-fluid">    
				<div class="span4">
					<img data-bind="attr: { src: image_url }" alt="" >						         
				</div> 
				<div class="span4">
					<h1 align="center"><span data-bind="text: company.name"></span></h1>
					<p align="center">
						<span data-bind="text: company.address"></span> <br>
						<span data-bind="text: company.phone"></span> /
						<span data-bind="text: company.mobile"></span>							
					</p>						    
				</div>									
			</div>

			<div align="center">
				<h3>លិខិតរំលឹក</h3>
			</div>			

			<div class="row-fluid">    
				<div class="span2">
					<div class="barcodeTargetImage"></div>										
				</div>
				<div class="span6">
					<table width="100%">
						<tr>
							<td>ឈ្មោះ</td>
							<td><span data-bind="text: customer.fullname"></td>
							<td>ទីតាំង</td>
							<td><span data-bind="text: invoice.address"></span></td>														
						</tr>						
						<tr>
							<td>លេខកូដ</td>
							<td><span data-bind="text: customer.number"></td>
							<td>លេខលិខិត</td>
							<td><span data-bind="text: invoice.number"></span></td>							
						</tr>						
						<tr>
							<td>ចំនួនអំពែ</td>
							<td><span data-bind="text: customer.amperes.ampere"></td>
							<td>ថ្ងៃចេញលិខិត</td>
							<td><span data-bind="text: issued_date"></span></td>							
						</tr>
						<tr>
							<td>អាសយដ្ឋាន</td>
							<td><span data-bind="text: customer.address"></td>							
							<td>ថ្ងៃបង់ប្រាក់</td>
							<td><span data-bind="text: due_date"></span></td>
						</tr>
					</table>
				</div>
				<div class="span4">
					<div data-role="grid" data-bind="source: readingList"
				        data-auto-bind="false" data-row-template="readingRowTemplate"                  
				        data-columns='[						        	
				            { title: "ថ្ងៃអាន" },	                     
				            { title: "ដល់" },
				            { title: "អំនានសរុប" }				                            	                    
				        ]'>
					</div>
					
					<table width="100%">
						<tr>
							<td>ថាមពលមធ្យម</td>
							<td>
								<span data-bind="text: totalReading"></span> Kw
								/
								<span data-bind="text: selectedReading"></span>
								=
								<span data-bind="text: avg"></span> Kw
							</td>											
						</tr>
						<tr>
							<td>ថាមពលប្រើប្រាស់ក្នុងមួយថ្ងៃ</td>
							<td>
								<span data-bind="text: avg"></span> Kw
								/ 30 ថ្ងៃ =												
								<span data-bind="text: usage_per_day"></span> Kw
							</td>											
						</tr>
					</table>

				</div>								
			</div>			
			
			<div data-role="grid" data-bind="source: invoiceItemList"
		        data-auto-bind="false" data-row-template="invoiceRowTemplate"                  
		        data-columns='[						        	
		            { title: "បរិយាយ" },	                     
		            { title: "ចំនួនថ្ងៃ", width: 60 },
		            { title: "kw/ថ្ងៃ", width: 60 },
		            { title: "ថាមពល", width: 60 },						            
		            { title: "តំលៃរាយ", width: 80 },
		            { title: "ទឹកប្រាក់" },
		            { title: "ប្រាក់បង់រូច" },
		            { title: "ទឹកប្រាក់សរុប" }	                    	                    
		        ]'>
			</div>

			<br>
			
			<div align="right" style="font-size: 20px">
				សរុប
				<span data-bind="text: total"></span>
			</div>
			
		</div> <!--end div example-->            
	</div> <!--End div span12-->		
</div> <!--End div row-->    

<!-- reading row template -->
<script id="readingRowTemplate" type="text/x-kendo-tmpl">		
	<tr>						
		<td>#:kendo.toString(meter_records.date_read_from, 'dd-MM-yyyy')#</td>		
		<td>#:kendo.toString(meter_records.date_read_to, 'dd-MM-yyyy')#</td>		
		<td>#:active_usage#</td>				
    </tr>   
</script>

<!-- invoice item template -->
<script id="invoiceRowTemplate" type="text/x-kendo-tmpl">		
	<tr>				
		<td>#:description#</td>		
		<td align="right">#:days#</td>
		<td align="right">#:usage_per_day#</td>
		<td align="right">#:kendo.parseInt(days*usage_per_day)#</td>
		<td align="right">#:kendo.toString(unit_price, 'c0')#</td>
		<td align="right">#:kendo.toString((kendo.parseInt(days*usage_per_day))*unit_price, 'c0')#</td>
		<td align="right">#:kendo.toString(amount_paid, 'c0')#</td>		
		<td align="right">
			#:kendo.toString(kendo.parseFloat(amount), 'c0')#			
		</td>					
    </tr>   
</script>

<script>
$(document).ready(function() {
	var inv_id = <?php echo $invoice_id;?>;

	//Datasource
	var companyDS = new kendo.data.DataSource({
	  	transport: {	  
		  	read: {
				  url : ARNY.baseUrl + "api/companies/index",
				  type: "GET",
				  dataType: "json"			  		  
		  	}
	  	}
	});
	
	var customerDS = new kendo.data.DataSource({
	  	transport: {	  
		  	read: {
			  	url : ARNY.baseUrl + "api/people_api/people",
			  	type: "GET",
			  	dataType: "json"	  
		  	}
	  	},
	  	requestEnd: function(e) {
		    var response = e.response;
		    var type = e.type;
		    if(type==='read'){
		    	viewModel.set("customer", response[0]);
		    	$(".barcodeTargetImage").barcode(response[0].number, "code128");		    	
		    }
		},	  	
	  	serverFiltering: true	  	
	});

	var averageRecordDS = new kendo.data.DataSource({
	  	transport: {	  
		  	read: {
			  	url : ARNY.baseUrl + "api/average_records/average_record",
			  	type: "GET",
			  	dataType: "json"	  
		  	}
	  	},
	  	requestEnd: function(e) {
		    var response = e.response;
		    var type = e.type;
		    if(type==='read'){
		    	var total = 0;
				var counter = response.length;
				for (var i=0;i< counter; i++) {
					var d = response[i];					
						total += d.active_usage;					
				}

				var avgNum = total/counter;
				var avg = Math.ceil(avgNum * 100) / 100;

				var num = avg/30;
				var usage_per_day = Math.ceil(num * 100) / 100;
				
				viewModel.set("totalReading", total);
				viewModel.set("avg", avg);
				viewModel.set("selectedReading", counter);
				viewModel.set("usage_per_day", usage_per_day);		    	
		    }
		}, 	  		  	
	  	filter: { field: "notice_id", value: inv_id },
	  	serverFiltering: true
	});
		
	var invoiceDS = new kendo.data.DataSource({
	  	transport: {	  
		  	read: {
				url : ARNY.baseUrl + "api/invoices/invoice",
				type: "GET",
				dataType: "json"	  
		  	}
	  	},	  		  	
	  	filter: { field: "id", value: inv_id },
	  	serverFiltering: true
	});
	
	var invoiceItemDS = new kendo.data.DataSource({
	  	transport: {	  
		  	read: {
			  	url : ARNY.baseUrl + "api/invoice_items/invoice_item",
			  	type: "GET",
			  	dataType: "json"			  		  		  
		  	}
	  	},
	  	requestEnd: function(e) {
		    var response = e.response;
		    var type = e.type;
		    if(type==='read'){
		    	var total = 0;
		    	for (var i=0;i< response.length; i++) {
		    		total += kendo.parseFloat(response[i].amount);
		    	}
		    	viewModel.set("total", kendo.toString(total, 'c0'));    	
		    }
		},	  	
	  	filter: { field: "invoice_id", value: inv_id },
	  	serverFiltering: true
	});
	
	//View model
	var viewModel = kendo.observable({
		//Company		
		image_url			: "",

		customer_id 		: 0,
		total 				: 0,
			    	    
	    company 			: null,
	    invoice 			: null,
	    customer 			: null,

	    readingList 		: averageRecordDS,
	    invoiceItemList 	: invoiceItemDS,

	    pageLoad 			: function(){	    	
	    	averageRecordDS.read();	    	
	    	invoiceItemDS.read();

	    	this.loadCompany();
	    	this.loadInvoice();    		    	
	    },
	    loadCompany 		: function(){
	    	companyDS.fetch(function(){
			  	var data = this.data();			  	
			  	var imgUrl = ARNY.baseUrl + data[0].image_url;	  
			  	viewModel.set("image_url", imgUrl);
			  	viewModel.set("company", data[0]);	  
			});
	    },	    
		loadInvoice 		:function(){
			invoiceDS.fetch(function(){			
				var data = this.data();
				viewModel.set("invoice", data[0]);

				customerDS.filter({ field: "id", value: data[0].customer_id });
								
				viewModel.set("issued_date", kendo.toString(new Date(data[0].issued_date), "dd/MM/yyyy"));
				viewModel.set("due_date", kendo.toString(new Date(data[0].due_date), "dd/MM/yyyy"));
			});
		}		
	});  
	kendo.bind($("#example"), viewModel);

	viewModel.pageLoad();


});//End of document.ready
</script>