<div class="row-fluid">    
	<div class="span12">
		<div id="example">

			<div class="hidden-print">
								
				<select id="company" name="company" data-role="dropdownlist" data-text-field="abbr" data-value-field="id" 
			            	data-bind="source: companyList, value: company_id" data-option-label="(--- រើស អាជ្ញាប័ណ្ណ ---)"></select>

			    <select id="transformer" name="transformer" data-role="dropdownlist" data-text-field="transformer_number" data-value-field="id"
          				data-cascade-from="company" data-bind="source: transformerList, value: transformer_id" data-auto-bind="false" 
          				data-option-label="(--- រើស ត្រង់ស្វូ ---)"></select>	
				<input id="mof" data-role="datepicker" data-bind="value: month_of" data-start="year" data-depth="year" 
						data-format="MM-yyyy" placeHolder="ប្រចាំខែ" />
				<input type="text" data-bind="value: invoice_no" style="width:100px" placeholder="លេខវិក្កយបត្រ">
				<button type="button" class="btn btn-default" data-bind="click: search"><i class="icon-search"></i></button>
				<button type="button" class="btn btn-default" data-bind="click: printInvoice"><i class="icon-print"></i></button>				
				<input id="chkVisible" type="checkbox" data-bind="events: {click: print}" /> ប្រើក្រដាសពុម្ព																			
			</div>
			
			<div data-role="listview" data-bind="source: invoiceList" data-template="invoiceTemplate" data-auto-bind="false"></div>

		</div> <!--end div example-->            
	</div> <!--End div span12-->		
</div> <!--End div row-fluid-->

<script type="text/x-kendo-tmpl" id="invoiceTemplate">
	
	  	<div class="print">
	  		<table width="100%">
		    	<tr>
		    		<td valign="top" align="left" width="250">
		    			<img src="/production/#:companys.image_url#" height="200" width="300" >
		    		</td>
		    		<td style="float:left;">
		    			<div class="center">
			    			<h4>#:companys.name#</h4>
							<p>
								#:companys.address# <br>
								#:companys.phone# /
								#:companys.mobile#							
							</p>
						</div>
		    		</td>
		    	</tr>
		    </table>							
		
			<table width="100%" class="table table-condensed" style="margin-top: 15px">
				<tr>
					<td valign="top" rowspan="6">
						<span class="#:number#"></span>
						#:customers.number# #:customers.surname# #:customers.name# <br>
						#:address#
					</td>
					<td class="hiddenPrint">លេខវិក្កយបត្រ INVOICE NO</td>
					<td>#:number#</td>							
				</tr>
				<tr>
					<td class="hiddenPrint">វិក្កយបត្រ INVOICE DATE</td>
					<td>#:kendo.toString(new Date(issued_date), "dd-MM-yyyy")#</td>											
				</tr>
				<tr>
					<td class="hiddenPrint" width="150px">តំបន់ AREA</td>
					<td width="150px">#:transformers.transformer_number#</td>							
				</tr>
				<tr>
					<td class="hiddenPrint" width="150px">លេខប្រអប់ BOX NO</td>
					<td width="150px">#:box_no#</td>				
				</tr>
				<tr>
					<td class="hiddenPrint">គិតចាប់ពីថ្ងៃទី FROM</td>
					<td>#:kendo.toString(new Date(date_read_from), "dd-MM-yyyy")#</td>							
				</tr>
				<tr>
					<td class="hiddenPrint">ដល់ថ្ងៃទី TO</td>
					<td>#:kendo.toString(new Date(date_read_to), "dd-MM-yyyy")#</td>
				</tr>
			</table>															
		
			<table class="hiddenPrint" border="1" width="100%">
				<tr>
					<td align="center" width="100">លេខកុងទ័រ <br> METER</td>
					<td align="center" width="80">អំនានចាស់ <br> PREVIOUS</td>
					<td align="center" width="80">អំនានថ្មី <br> CURRENT</td>
					<td align="center" width="70">មេគុណ <br> <span style="font-size:x-small">MULTIPLICATION</span></td>
					<td align="center" width="100">ប្រើប្រាស់ <br> CONSUMPTION</td>
					<td align="center" width="80">តំលៃឯកត្តា <br> RATE</td>
					<td align="center" width="100">តំលៃសរុប <br> AMOUNT</td>	
				</tr>
			</table>
									
			<table align="right">
				<tr>
					<td>ប្រាក់ជំពាក់ខែមុន</td>
					<td width="150px" align="right">#:kendo.toString(kendo.parseFloat(tdebt), 'c0')#</td>
				</tr>
				<tr>
					<td>ប្រាក់សងខែមុន</td>
					<td align="right">#:kendo.toString(kendo.parseFloat(tpayment), 'c0')#</td>
				</tr>
				<tr>
					<td>ប្រាក់នៅជំពាក់</td>
					<td align="right">#:kendo.toString(kendo.parseFloat(tremain), 'c0')#</td>
				</tr>
			</table>
			
			<div style="height:350px">
				<table width="100%">
					#for(var i=0; i < invoice_items.length; i++) {#
						<tr>
							<td width="100">#:invoice_items[i].meter_no#</td>
							<td align="right" width="80">#:invoice_items[i].prev_reading#</td>
							<td align="right" width="80">#:invoice_items[i].new_reading#</td>
							<td align="center" width="70">#:invoice_items[i].multiplier#</td>
							<td align="right" width="100">#:kendo.toString(kendo.parseInt(invoice_items[i].quantity), 'n0')#</td>
							<td align="right" width="80">#:kendo.toString(kendo.parseFloat(invoice_items[i].unit_price), 'c0')#</td>
							<td align="right" width="100">#:kendo.toString(kendo.parseFloat(invoice_items[i].amount), 'c0')#</td>
						</tr>
					# } #
				</table>

				<p>#:memo#</p>
			</div>		

	        <table class="hiddenPrint" width="100%" border="1" cellpadding="5" cellspacing="5">
	        	<tr>
	        		<td rowspan="5" style="font-size:smaller">
	        			#=companys.term_of_condition#
	        		</td>
	        		<td width="200">
	        			<div style="float:left;text-align:left;">បំណុលសរុបខែនេះ</div>
	  					<div style="float:right;text-align:right;">TOTAL BALANCE</div>
	        		</td>
	        		<td width="110" align="right" style="visibility:visible;">#:kendo.toString(kendo.parseFloat(total), 'c0')#</td>
	        	</tr>
	        	<tr>
	        		<td>
	        			<div style="float:left;text-align:left;">ទឹកប្រាក់ត្រូវបង់</div>
	  					<div style="float:right;text-align:right;">TOTAL DUE</div>
	        		</td>
	        		<td align="right" style="visibility:visible;">#:kendo.toString(kendo.parseFloat(tdue), 'c0')#</td>        		
	        	</tr>
	        	<tr>
	        		<td>
	        			<div style="float:left;text-align:left;">ថ្ងៃផុតកំណត់បង់ប្រាក់</div>
	  					<div style="float:right;text-align:right;">DUE DATE</div>
	        		</td>
	        		<td align="right" style="visibility:visible;">#:kendo.toString(new Date(due_date), 'dd-MM-yyyy')#</td>        		
	        	</tr>
	        	<tr>
	        		<td>
	        			<div style="float:left;text-align:left;">ថ្ងៃបង់ប្រាក់</div>
	  					<div style="float:right;text-align:right;">PAY DATE</div>
	        		</td>
	        		<td></td>        		
	        	</tr>
	        	<tr>
	        		<td>
	        			<div style="float:left;text-align:left;">ចំនួនទឹកប្រាក់បានបង់</div>
	  					<div style="float:right;text-align:right;">PAY AMOUNT</div>
	        		</td>
	        		<td></td>        		
	        	</tr>
	        </table>			

			<div class="hiddenPrint" style="border-top: 1px dashed black; margin: 7px 5px 5px 5px;"></div>

			<table class="hiddenPrint" width="100%" border="1" cellpadding="5" cellspacing="5">
				<tr>							
					<td rowspan="4">
						<table width="100%">
							<tr>
								<td></td>
								<td style="visibility:visible;">
									<span class="#:number#"></span>
								</td>							
							</tr>
							<tr valign="top" style="visibility:visible;">
								<td>វិក្កយបត្រ</td>
								<td>#:number#</td>
							</tr>
							<tr valign="top" style="visibility:visible;">
								<td>អតិថិជន</td>
								<td>#:customers.number# #:customers.surname# #:customers.name#</td>
							</tr>
							<tr valign="top" style="visibility:visible;">
								<td>អាសយដ្ឋាន</td>
								<td>#:address#</td>
							</tr>
							<tr valign="top" style="visibility:visible;">
								<td>ទីតាំងចរន្ត</td>
								<td>#:transformers.transformer_number#, #:box_no#</td>
							</tr>
						</table>
					</td>				
					<td width="200">
						<div style="float:left;text-align:left;">ទឹកប្រាក់ត្រូវបង់</div>
	  					<div style="float:right;text-align:right;">TOTAL DUE</div>
					</td>
					<td width="110" align="right" style="visibility:visible;">#:kendo.toString(kendo.parseFloat(tdue), 'c0')#</td>
				</tr>
				<tr>			    
					<td>
						<div style="float:left;text-align:left;">ថ្ងៃផុតកំណត់បង់ប្រាក់</div>
	  					<div style="float:right;text-align:right;">DUE DATE</div>
					</td>
					<td align="right" style="visibility:visible;">#:kendo.toString(new Date(due_date), 'dd-MM-yyyy')#</td>
				</tr>
				<tr>			    
					<td>
						<div style="float:left;text-align:left;">ថ្ងៃបង់ប្រាក់</div>
	  					<div style="float:right;text-align:right;">PAY DATE</div>
					</td>
					<td></td>
				</tr>
				<tr>
					<td>
						<div style="float:left;text-align:left;">អ្នកទទួលប្រាក់</div>
	  					<div style="float:right;text-align:right;">CASHIER</div>
					</td>
					<td></td>
				</tr>
			</table>
		</div>
	
</script>

<script>
$(document).ready(function() {

var invoiceDS = new kendo.data.DataSource({
  	transport: {	  
	  	read: {
		  	url : ARNY.baseUrl + "api/invoices/print_batch",
		  	type: "GET",
		  	dataType: "json"		  
	  	}
  	},	 	
  	serverFiltering: true,
  	requestEnd: function(e) {
  		if(e.type === "read") {  			
  			viewModel.set("invoiceList", e.response);
  			viewModel.barcod();
  		}
  		
  	}
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

var transformerDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/electricities/transformer_cascading",
			type: "GET",
			dataType: "json"
		}
	},	
	serverFiltering: true
});

//View model
var viewModel = kendo.observable({
	invoice_no 			: "",	
	company_id 			: 0,
	month_of 			: new Date(),	
	isVisible 			: true,
	
	invoiceList 		: [],
	companyList 		: companyDS,	
	transformerList 	: transformerDS,

	pageLoad 			: function(){
		var no = "<?php echo $this->uri->segment(3); ?>";		
		if(no!=""){
			this.set("invoice_no", no);
			this.search();			
		}
	},
	search 				: function(){
		var para = new Array();
		var transformer = this.get("transformer_id");
		var monthOf = new Date(this.get("month_of"));		
		monthOf.setDate(1);
		monthOf = kendo.toString(monthOf, "yyyy-MM-dd");

		var invoice_no = this.get("invoice_no");		
		if(invoice_no!=""){
			para.push({field: "number", value: invoice_no});
		}
		
		if(transformer!=null && monthOf!=""){
			para.push({ field: "transformer_id", value: transformer.id },
					{ field: "month_of", value: monthOf }
			);
		}
		if(para.length>0){
			invoiceDS.filter(para);
		}			
	},	
	barcod 				: function(){			
		var data = this.invoiceList;
		for (var i=0;i<data.length;i++) {
			var d = data[i];
			var id = d.customers.number;

			$("."+d.number).kendoBarcode({
			  	value: id,
			  	width: 200,
				height: 30,
				text:{
				    visible: false
				}				
			});
		}		
	},
	print 				: function(e) {
		var printBtn = e.target;
		if(printBtn.checked) {
			$(".hiddenPrint").css("visibility", "hidden");
		} else {
			$(".hiddenPrint").css("visibility", "visible");
		}
	},
	printInvoice : function(){
		javascript:window.print();
	}
});
kendo.bind($("#example"), viewModel);

viewModel.pageLoad();

});//End document ready
</script>