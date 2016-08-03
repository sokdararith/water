<div class="row-fluid">
	<div class="span12">		
		<div id="example" class="k-content">										
			<div id="top" align="right">
				<a href="#bottom">ទៅកាន់ផ្នែកខាងក្រោម &darr;</a>
			</div>
			
			<div>				
				<select id="company" name="company" data-role="dropdownlist" data-text-field="abbr" data-value-field="id" 
			            	data-bind="source: companyList, value: company_id" data-option-label="(--- រើស អាជ្ញាប័ណ្ណ ---)"></select>

			    <select id="transformer" name="transformer" data-role="dropdownlist" data-text-field="transformer_number" data-value-field="id"
          				data-cascade-from="company" data-bind="source: transformerList, value: transformer_id" data-auto-bind="false" 
          				data-option-label="(--- រើស ត្រង់ស្វូ ---)"></select>				
				<input data-role="datepicker" data-bind="value: monthOfSearch" data-start="year" data-depth="year" data-format="MM-yyyy" placeHolder="អំនានប្រចាំខែ" />
				<button type="button" class="btn btn-default" data-bind="click: searchReading"><i class="icon-search"></i></button>
				<button type="button" class="btn btn-default" data-bind="click: linkPrint"><i class="icon-print"></i></button>				
			</div>											

			<br>
			
			<table class="table table-bordered table-striped table-white">
	            <thead>
	                <tr>
	                    <th><input type="checkbox" data-bind="checked: checkAll, events: {change : changeAll}" /></th>
	                    <th>អំនានប្រចាំខែ</th>
	                    <th>លេខកូដ</th>
	                    <th>អតិថិជន</th>	                    
	                    <th>លេខប្រអប់</th>
	                    <th>លេខកុងទ៍រ</th>
	                    <th>មេគុណ</th>
	                    <th>អំនានចាស់R</th>
	                    <th>អំនានថ្មីR</th>
	                    <th>សរុប Reactive</th>
	                    <th>អំនានចាស់</th>
	                    <th>អំនានថ្មី</th>
	                    <th>សរុប Active</th>	                    
	                </tr>
	            </thead>
	            <tbody data-role="listview" data-template="rowTemplate" data-auto-bind="false" data-bind="source: meterRecordList">
	            </tbody>	            
	        </table>

		    <br>
		    
		    <table width="100%">
				<tr>
		            <td>ប្រចាំខែ</td>            
		            <td><input data-role="datepicker" data-bind="value: month_of" data-start="year" data-depth="year" data-format="MM-yyyy" /></td>		            
		            <td></td>
		            <td></td>	
		            <td align="right">ចំនួនអំនានសរុប:</td>            
		            <td align="right" width="90px">
		            	<span data-bind="text: totalSelected"></span>
		            	/
		            	<span data-bind="text: total_reading"></span>
		            </td>		            		            
		      	</tr>		          	
		      	<tr>		            
		            <td>ថ្ងៃចេញវិក្កយបត្រ</td>            
		            <td><input data-role="datepicker" data-bind="value: issued_date" data-format="dd-MM-yyyy" /></td>
		            <td>Class</td>
		            <td>
		            	<select id="classes" name="classes" data-role="combobox" data-text-field="name" data-value-field="id" 
			            	data-bind="source: classList, value: class_id" placeholder="(--- រើស Class ---)"></select>		            	
			        </td>			            
		            <td align="right">ចំនួនប្រើប្រាស់ Active សរុប:</td>            
		            <td align="right" width="90px"><span data-bind="text: total_active"></span></td>
		      	</tr>
		      	<tr>		            
		            <td>ថ្ងៃបង់ប្រាក់</td>
		            <td><input data-role="datepicker" data-bind="value: payment_date" data-format="dd-MM-yyyy" /></td>
		            <td>ថ្ងៃផុតកំណត់</td>
		            <td><input data-role="datepicker" data-bind="value: due_date" data-format="dd-MM-yyyy" /></td>
		            <td align="right">ចំនួនប្រើប្រាស់ Reactive សរុប:</td>            
		            <td align="right" width="90px"><span data-bind="text: total_reactive"></span></td>		            
		      	</tr>		          	
		    </table>
		         
		    <br />
		    
		    <div align="right">
		      	<div class="status"></div> 
		      	<button class="btn btn-primary" data-bind="click: btnCreateInvoice"><i class="icon-list-alt icon-white"></i> រៀបចំវិក្កយបត្រ</button>     
		    </div>

		    <br>

		    <div id="bottom" align="right">
				<a href="#top">ទៅកាន់ផ្នែកខាងលើ &uarr;</a>
			</div>

		</div> <!--End div example-->
	</div>
</div>	

<!-- Row template -->
<script id="rowTemplate" type="text/x-kendo-tmpl">
	<tr>
		<td align="center">
		   <input type="checkbox" data-bind="checked: check, events: {change : change" #: invoice_id>0 ? disabled="disabled" : "" # />
		</td>
		<td>#:kendo.toString(new Date(month_of), "MM-yyyy") #</td>
		<td>#:people.number#</td>			
		<td>#:people.surname# #:people.name#</td>		
		<td>#:electricity_boxes.box_no#</td>
		<td>#:meter_no#</td>
		<td>#:multiplier#</td>				
		<td align="right">#:reactive_prev_reading #</td>
		<td align="right">#:reactive_new_reading #</td>
		<td align="right">#:reactive_usage #</td>
		<td align="right">#:prev_reading #</td>
		<td align="right">#:new_reading #</td>		
		<td align="right">#:active_usage#</td>		
    </tr>
</script>

<script>
$(document).ready(function() {

//Datasources
var peopleDS = new kendo.data.DataSource({
  transport: {	  
	  update: {
		  url : ARNY.baseUrl + "api/people_api/people_batch",
		  type: "PUT",
		  dataType: "json"		  
	  },	    
	  parameterMap: function(options, operation) {
		  if (operation !== "read" && options.models) {			  
			  return {models: kendo.stringify(options.models)};
		  }		  
		  return options;  
	  }
  },  
  schema: {
	  model: {
		  id : "id"
	  }		
  }
});

var meterRecordDS = new kendo.data.DataSource({
  	transport: {	
  	  	read:  {
			url: ARNY.baseUrl + "api/meter_records/meter_record_for_invoice",		  
		  	type: "GET",
		  	dataType: "json"
		}
  	},  
  	requestEnd: function(e) {
	    var response = e.response;
	    var type = e.type;
	    if(type==='read'){
	    	
	    	var total_active = 0;
			var total_reactive = 0;
						
			for (var i=0;i<response.length;i++)	{			 
				total_active += response[i].active_usage;	
				total_reactive += response[i].reactive_usage;							
			}

			viewModel.set("total_active", kendo.toString(total_active, 'n0'));
			viewModel.set("total_reactive", kendo.toString(total_reactive, 'n0'));
			viewModel.set("total_reading", response.length);
					
		}	
  	},
  	aggregate: { field: "check", aggregate: "sum" },  
	serverFiltering: true
});

var invoiceDS = new kendo.data.DataSource({
  	transport: {	  
	  	create: {
		  	url : ARNY.baseUrl + "api/invoices/invoice_batch",
		  	type: "POST",
		  	dataType: "json"		  
	  	},	    
	  	parameterMap: function(options, operation) {
		  	if (operation !== "read" && options.models) {			  
			  	return {models: kendo.stringify(options.models)};
		  	}		  
		  	return options;  
	  	}
  	},  	  
  	schema: {
	  	model: {
		  	id : "id"
	  	}		
  	}
});

var invoiceItemDS = new kendo.data.DataSource({
  	transport: {	  
	  	create: {
		 	url : ARNY.baseUrl + "api/invoice_items/invoice_item_batch",
		  	type: "POST",
		  	dataType: "json"
	  	},
	  	parameterMap: function(options, operation) {
		  	if (operation !== "read" && options.models) {
			  	return {models: kendo.stringify(options.models)};
		  	}		  
		  	return options;  
	  	}
  	},  	 
  	schema: {
	 	model: {
		  	id : "id"
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

var classDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/classes/class",
			type: "GET",
			dataType: "json"
		}
	},
	filter: { field: "type", value: "Class" },
	serverFiltering: true		
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

var planItemDS = new kendo.data.DataSource({
  	transport: {	  
	  	read: {
		  	url : ARNY.baseUrl + "api/plan_items/plan_item",
		  	type: "GET",
		  	dataType: "json"
	  	}
  	},  
  	sort: { field: "start_date", dir: "desc" }
});

var tariffDS = new kendo.data.DataSource({
  transport: {	  
	  read: {
		  url : ARNY.baseUrl + "api/tariffs/tariff",
		  type: "GET",
		  dataType: "json"
	  }
  }  
});

var tariffItemDS = new kendo.data.DataSource({
  	transport: {	  
	  	read: {
		  	url : ARNY.baseUrl + "api/tariff_items/tariff_item",
		  	type: "GET",
		  	dataType: "json"
	  	}
  	},  
  	sort: { field: "usage", dir: "desc" },
  	serverSorting: true
});

var maintenanceDS = new kendo.data.DataSource({
  transport: {	  
	  read: {
		  url : ARNY.baseUrl + "api/maintenances/maintenance",
		  type: "GET",
		  dataType: "json"
	  }
  }
});

var exemptionDS = new kendo.data.DataSource({
  transport: {	  
	  read: {
		  url : ARNY.baseUrl + "api/exemptions/exemption",
		  type: "GET",
		  dataType: "json"
	  }
  }
});

var journalDS = new kendo.data.DataSource({
  	transport: {	  
	    create: {
		  	url : ARNY.baseUrl + "api/accounting_api/journals",
		  	type: "POST",
		  	dataType: "json"
	    },
        parameterMap: function(options, operation) {
            if (operation !== "read" && options.models) {
                return {models: kendo.stringify(options.models)};
            }
            return options;
        }
  	},
  	requestEnd: function(e) {
  		var response = e.response;
    	var type = e.type;	    			   
	    if(type==="create"){	    	   	
	    	viewModel.clearControls();	    		    	
	    }
  	},  
  	schema: {
	 	model: {
		  	id : "id"
	  	}		
  	}
});

//Read all data sources
planItemDS.read();
tariffDS.read();
tariffItemDS.read();
maintenanceDS.read();
exemptionDS.read();

//View model
var viewModel = kendo.observable({	
	account_receiveable_id 	: 3,
	resident_acct_id 		: 44,
	comercial_acct_id 		: 45,
	institute_acct_id 		: 46,
	
	//Invoice
	checkAll 		: false,
	totalSelected 	: 0,	
	next_inv_id 	: <?php echo $next_inv_id;?>,
	last_no			: "<?php echo $last_invoice_no;?>",
	transformer_id 	: "",
	type 			: "eInvoice",				
	status			: 0,
	biller			: <?php echo $this->session->userdata('user_id'); ?>,					  	  
	
	issued_date		: new Date(),
	payment_date 	: new Date(),
	due_date 		: new Date(),	
	month_of 		: new Date(),
	monthOfSearch 	: new Date(),

	payment_term_id	: 1,	
	currency_id		: 1,
	memo			: "",
	class_id		: 0,
	company_id 		: 0,
		
	total_reading	: 0,
	total_active 	: 0,
	total_reactive	: 0,
	total_amount	: 0,

	account_receiveable	: 0,
	resident_revenue 	: 0,
	comercial_revenue 	: 0,
	institute_revenue 	: 0,
	
	classList 		: classDS,
	companyList 	: companyDS,
	transformerList : transformerDS,	 
	meterRecordList : meterRecordDS,

	invoiceList 	: [],
	invoiceItemList : [],
	journalList		: [],
	meterRecordIDList 	: [],
	customerBalanceList : [],
	receiveableList	: [],
	revenueList 	: [],
	customerIDList  : [],

	
	pageLoad 		: function(){
		this.setDueDate();				
	},
	setDueDate		: function(){
		var duedate = new Date();
		duedate.setDate(duedate.getDate()+7);
		this.set("due_date", duedate);
	},
	linkPrint 		: function(){
		window.location.href = ARNY.baseUrl + "customer/print_invoice"
	},
	searchReading 	: function(){
		var monthOf = new Date(this.get("monthOfSearch"));		
		monthOf.setDate(1);
		monthOf = kendo.toString(monthOf, "yyyy-MM-dd");

		var transformerID = this.get("transformer_id");
		if(transformerID!="" && monthOf!=""){			
			meterRecordDS.filter({
				filters: [
					{ field: "meters.transformer_id", value: transformerID },
					{ field: "meters.status", value: 1 },
					{ field: "meter_records.month_of", value: monthOf }					
				]
			});
		}

		this.set("checkAll", false);
		this.set("totalSelected", 0);									
	},	
	changeAll 		: function(){		
		var bolValue = this.get("checkAll");
		var data = meterRecordDS.data();
		if(data.length>0){
			var ts = 0;		
	        for (var i = 0; i < data.length; i++) {
	            var d = data[i];
	            if(d.invoice_id==0){					
					d.set("check", bolValue);
					ts++;
				}
	        }
	        this.set("totalSelected", ts);
        }
	},
	change 			: function(){		
		var ageAggregates = meterRecordDS.aggregates().check;
		this.set("totalSelected", ageAggregates.sum); 
	},
	getTariffId  	: function(tariff_plan_id, month_of){
		var tariff_id = 0;						
		var data = planItemDS.data();
        for (var i = 0; i < data.length; i++) {
            var d = data[i];
            if((d.tariff_plan_id==tariff_plan_id) && (month_of>=d.start_date)){
            	tariff_id = d.tariff_id;
            	break;
            }
        }
        return tariff_id;		
	},
	distrinctCustomer	: function(){
		//Get all avialiable id
		var ids = new Array();
		var receiveableIDs = new Array();
		var revenueIDs = new Array();

		for (var i=0;i<meterRecordDS.total();i++) {
			var d = meterRecordDS.at(i);
			ids.push(d.customer_id);
			receiveableIDs.push(d.people.account_receiveable_id);
			revenueIDs.push(d.people.revenue_account_id);
		}
		
		//Remove duplicate id
		var uniqueID = [];
		$.each(ids, function(j, el){
		    if($.inArray(el, uniqueID) === -1) uniqueID.push(el);
		});

		var ARuniqueID = [];
		$.each(receiveableIDs, function(k, elk){
		    if($.inArray(elk, ARuniqueID) === -1) ARuniqueID.push(elk);
		});

		var REVuniqueID = [];
		$.each(revenueIDs, function(l, ell){
		    if($.inArray(ell, REVuniqueID) === -1) REVuniqueID.push(ell);
		});

		//Add to list
		var arList = [];
		for (var j=0;j<ARuniqueID.length;j++) {
			var dj = ARuniqueID[j];
			arList.push({id:dj, amt:0});
		}

		var revList = [];
		for (var k=0;k<REVuniqueID.length;k++) {
			var dk = REVuniqueID[k];
			revList.push({id:dk, amt:0});
		}

		this.set("customerIDList", uniqueID);
		this.set("receiveableList", arList);
		this.set("revenueList", revList);

		console.log(arList);
		console.log(revList);
	},
	addInvoice 		: function(){		
		var invoice_id = this.get("next_inv_id");		
		var last_no = this.get("last_no");

		var monthOf = new Date(this.get("month_of"));
		monthOf.setDate(1);
		monthOf = kendo.toString(monthOf, "yyyy-MM-dd");

		var invoice_no = 0;
		if(last_no.length>7){
			invoice_no = parseInt(last_no.substr(7));

			//Apply invoice no back to 0000 for the new year
			var y = parseInt(last_no.substr(3,2));
			var yof = parseInt(new Date(this.get("month_of")).getFullYear().toString().substr(2,2));			
			if(yof>y){
				invoice_no = 0;
			}					
		}
		
		invoice_no++;		

		var number = "";
		var inv_header = "INV" + kendo.toString(new Date(this.get("month_of")), "yy") 
								+ kendo.toString(new Date(this.get("month_of")), "MM");

		this.distrinctCustomer();
		var disCustomer = this.get("customerIDList");				
		for (var x=0;x<disCustomer.length;x++) {
			var dx = disCustomer[x];
			var total_amount = 0;
			var hasItem = false;
			var dataIndex = 0;
			
			var data = meterRecordDS.data();
	        for (var i = 0; i < data.length; i++) {
	        	var d = data[i];

	        	//Apply exemption
            	var isFree = false;            	
				var exemp_amt =0;
				var exemption_id = d.people.exemption_id;
				var exemp = exemptionDS.get(exemption_id);

				//Exempint free 100%
				if((exemption_id>0) && (exemp.exemption_type=="%") && (exemp.amount==1)){
					isFree = true;	
				}

				if(isFree==false){ //Free
		        	if(d.customer_id==dx){
		        		if(d.check){  //Check									            	
		        			hasItem = true;
		        			dataIndex = i;

							//Apply maintenance
							var maintenance_id = d.people.maintenance_id;
							var maintenances = maintenanceDS.get(maintenance_id);

							//Apply tariff
							var price = 0;
							var tariff_amt = 0;
							var active_usage = d.active_usage;

							var tariff_id = this.getTariffId(d.people.tariff_plan_id, d.month_of);
							var tariffs = tariffDS.get(tariff_id);

							
							//Apply tariff to active usage							
							//Exemption for kWh
							if((exemption_id>0) && (exemp.exemption_type=="kWh")){
								if(active_usage>exemp.amount){
									active_usage -= exemp.amount;
								}			
							}				
								
							//Apply tariff item				
							var dataj = tariffItemDS.data();
							for (var j=0;j<dataj.length;j++){				 
								var dj = dataj[j];
								if((dj.tariff_id==tariff_id) && (active_usage>=dj.usage)){												
									if(dj.is_flat==0){														
										price = dj.price;
										tariff_amt = active_usage * price;																											
									}else{																					
										price = dj.amount;
										tariff_amt = dj.amount;											
									}
									break;						
								}
							}
												
							//Add active item
							this.invoiceItemList.push({
								invoice_id	: invoice_id,
								item_id		: 0,	
								description	: tariffs.name,
								multiplier	: d.multiplier,
								quantity	: active_usage,	  
								unit_price	: price,
								vat			: 0,		  	  
								amount		: tariff_amt,
								meter_record_id : d.meter_record_id,
								meter_id 	: d.meter_id,
								prev_reading: d.prev_reading,
								new_reading : d.new_reading	
							});		
							total_amount += kendo.parseFloat(tariff_amt);
							
							//Add exemption for kWh
							if((exemption_id>0) && (exemp.exemption_type=="kWh") && (exemp.amount >0)){
								if(active_usage>exemp.amount){		
									//Add exemption for kWh
									this.invoiceItemList.push({
										invoice_id	: invoice_id,
										item_id		: 0,									
										description	: exemp.name,
										multiplier	: 0,
										quantity	: 1,	  
										unit_price	: 0,
										vat			: 0,		  	  
										amount		: 0,
										meter_id 	: 0,
										prev_reading: 0,
										new_reading : 0,
										exemption_id: exemption_id
									});							
								}	
							}				

							//Apply tariff item for reactive usage			
							var reactive_tariff_amt = 0;
							var reactive_price = 0;
							var reactive_usage = d.reactive_usage;
												
							var datak = tariffItemDS.data();				
							for (var k=0;k<datak.length;k++){				 
								var dk = datak[k];								
								if((dk.tariff_id==d.tariff_id) && (reactive_usage>=dk.usage)){
									if(dk.is_flat==0){
										reactive_price = dk.price;
										reactive_tariff_amt = reactive_usage * reactive_price;																				
									}else{
										reactive_price = dk.amount;
										reactive_tariff_amt = dk.amount;				
									}
									break;																			
								}	
							}

							//Add reactive item
							if(reactive_tariff_amt>0){
								this.invoiceItemList.push({
									invoice_id	: invoice_id,
									item_id		: 0,	
									description	: 'អំនាន Reactive',
									multiplier	: d.multiplier,
									quantity	: reactive_usage,	  
									unit_price	: reactive_price,
									vat			: 0,		  	  
									amount		: reactive_tariff_amt,
									meter_record_id : d.meter_record_id,
									meter_id 	: 0,
									prev_reading: d.reactive_prev_reading,
									new_reading : d.reactive_new_reading	
								});		
								total_amount += kendo.parseFloat(reactive_tariff_amt);
							}

							//Exemption for %
							if((exemption_id>0) && (exemp.exemption_type=="%") && (exemp.amount >0)){
								exemp_amt = total_amount * kendo.parseFloat(exemp.amount);					
										
								//Add exemption for %					
								this.invoiceItemList.push({
									invoice_id	: invoice_id,
									item_id		: 0,	
									description	: exemp.name,
									multiplier	: 0,
									quantity	: 1,	  
									unit_price	: 0,
									vat			: 0,		  	  
									amount		: (exemp_amt*-1),
									meter_id 	: 0,
									prev_reading: 0,
									new_reading : 0,
									exemption_id: exemption_id
								});
								total_amount -= kendo.parseFloat(exemp_amt);								
							}
							
							//Exemption for Money
							if((exemption_id>0) && (exemp.exemption_type=="៛") && (exemp.amount >0)){
								if(total_amount>exemp.amount){
									exemp_amt = exemp.amount;	
								}else{
									exemp_amt = total_amount;	
								}
								
								//Add exemption for Money
								this.invoiceItemList.push({
									invoice_id	: invoice_id,
									item_id		: 0,	
									description	: exemp.name,
									multiplier	: 0,
									quantity	: 1,	  
									unit_price	: 0,
									vat			: 0,		  	  
									amount		: (exemp_amt*-1),
									meter_id 	: 0,
									prev_reading: 0,
									new_reading : 0,
									exemption_id: exemption_id
								});
								total_amount -= kendo.parseFloat(exemp_amt);				
							}
														
							//Add maintenance
							if((maintenance_id>0) && (maintenances.amount>0)){	
								this.invoiceItemList.push({
									invoice_id	: invoice_id,
									item_id		: 0,	
									description	: maintenances.name,
									multiplier	: 0,
									quantity	: 1,	  
									unit_price	: parseFloat(maintenances.amount),
									vat			: 0,		  	  
									amount		: parseFloat(maintenances.amount),
									meter_id 	: 0,
									prev_reading: 0,
									new_reading : 0,
									maintenance_id: maintenance_id
								});
								total_amount += parseFloat(maintenances.amount);
							}

							//Add meter record id and invoice id to []
							this.meterRecordIDList.push({
								id			: kendo.parseInt(d.meter_record_id),
								invoice_id 	: invoice_id
							});							
						}//if(d.check){
		        	}//if(d.customer_id==dx){
	        	}//if(isFree==false){	        										
			}//for loop meterRecordDS

			if(hasItem){
				var mr = meterRecordDS.at(dataIndex);
				//Add invoice into []        		 		
				number = inv_header + kendo.toString(invoice_no, "00000");								
				this.invoiceList.push({
					number			: number,
					type 			: "eInvoice",
					amount 			: total_amount,	  
					status			: 0,
					biller			: this.get("biller"),	  
					customer_id		: dx,
					address			: mr.people.house_no + ' ' + mr.people.street_no,
					issued_date		: kendo.toString(new Date(this.get("issued_date")), "yyyy-MM-dd"),
					payment_date	: kendo.toString(new Date(this.get("payment_date")), "yyyy-MM-dd"),				
					due_date		: kendo.toString(new Date(this.get("due_date")), "yyyy-MM-dd"),
					month_of 		: monthOf,
					date_read_from	: kendo.toString(new Date(mr.date_read_from), "yyyy-MM-dd"),
					date_read_to	: kendo.toString(new Date(mr.date_read_to), "yyyy-MM-dd"),
					payment_term_id	: this.get("payment_term_id"),	  	  	
					currency_id		: this.get("currency_id"),
					class_id 		: this.get("class_id"),
					transformer_id  : mr.people.transformer_id,
					box_no 			: mr.electricity_boxes.box_no,
					memo			: this.get("memo"),
					company_id 		: mr.people.company_id				
				});

				invoice_id++;			
				invoice_no++;

				//Add new customer balances to []
				var balance = kendo.parseFloat(mr.people.balance) + kendo.parseFloat(total_amount);
				this.customerBalanceList.push({
					id			: kendo.parseInt(mr.people.id),
					balance 	: balance
				});													
				
				//Accounting				
				//AR
				var arList = this.get("receiveableList");
				for (var l=0;l<arList.length;l++) {
					var dl = arList[l];

					if(mr.people.account_receiveable_id==dl.id){
						dl.amt += total_amount;
					}
				}

				//Revenue
				var revList = this.get("revenueList");
				for (var m=0;m<revList.length;m++) {
					var dm = revList[m];

					if(mr.people.revenue_account_id==dm.id){
						dm.amt += total_amount;
					}
				}							
				
			}//if(hasItem){				
		}//for loop disCustomer	  	
		
		this.set("next_inv_id", invoice_id);
		this.set("last_no", number);

		this.createInvoice();
		this.createInvoiceItem();								  	
	},	
	addJournal 		: function(){		
		var d = new Date(this.get("month_of"));	
		var lastD = new Date(d.getFullYear(), d.getMonth() + 1, 0);
		var journalEntries = [];
		
		//A/R
		var arList = this.get("receiveableList");		
		for (var i=0;i<arList.length;i++) {
			var di = arList[i];

			journalEntries.push({				
				account_id	: di.id,				
				dr			: di.amt, 
				cr			: 0,				
				class_id 	: this.get("class_id"),
				memo 		: ""
			});
		}
	
		//Revenue
		var revList = this.get("revenueList");		
		for (var j=0;j<revList.length;j++) {
			var dj = revList[j];

			journalEntries.push({
				account_id	: dj.id,
				dr			: 0, 
				cr			: dj.amt,
				class_id 	: this.get("class_id"),
				memo 		: ""
			});
		}

		//Add new journal to database			
		journalDS.add({	 		
	 		memo		: "វិក្កយបត្រអគ្គីសនី", 
	 		voucher		: "",
	 		class_id	: this.get("class_id"),
	 		budget_id	: 0,
	 		donor_id	: 0,
	 		check_no	: "",
	 		location_id	: 0,
	 		transaction_type: "eInvoice",
	 		people_id 	: 0,
	 		employee_id : this.get('biller'),
	 		invoice_id 	: 0,
	 		payment_id  : 0,
	 		bill_id		: 0,	
	 		date 		: kendo.toString(lastD, "yyyy-MM-dd"), 
	 		receipt_id  : 0,
	 		item_receipt_id : 0,
	 		cashier 	: 0,
	 		journalEntries 	: journalEntries	 			 		
	 	});

	 	journalDS.sync();	 	
	},
	createInvoice : function(){
		var data = this.get("invoiceList");
		$.ajax({
			type: "POST",
			url: ARNY.baseUrl + "api/invoices/invoice_many",			
			data: {data: kendo.stringify(data)},
			dataType: "json",
			success: function (response) {
				//var data = response.d;
				//console.log(response);							  
			}
		});				
	},
	createInvoiceItem : function(){
		var data = this.get("invoiceItemList");
		$.ajax({
			type: "POST",
			url: ARNY.baseUrl + "api/invoice_items/invoice_item_many",			
			data: {data: kendo.stringify(data)},
			dataType: "json",
			success: function (response) {
				//var data = response.d;
				//console.log(response);							  
			}
		});				
	},
	updateMeterRecordInvoiceId : function(){
		var data = this.get("meterRecordIDList");
		$.ajax({
			type: "PUT",
			url: ARNY.baseUrl + "api/meter_records/meter_record_batch",			
			data: {data: kendo.stringify(data)},
			dataType: "json",
			success: function (response) {
				//var data = response.d;
				//console.log(response);			  
			},
			error: function(error) {
				//console.log(error);
			}
		});				
	},
	updateCustomerBalance : function(){
		var data = this.get("customerBalanceList");
		$.ajax({
			type: "PUT",
			url: ARNY.baseUrl + "api/people_api/balance_batch",			
			data: { data: kendo.stringify(data)},
			dataType: "json",
			success: function (response) {
				//var data = response.d;
				//console.log(response);			  
			},
			error: function(error) {
				//console.log(error);
			}
		});				
	},
	btnCreateInvoice: function(){
		var total = parseInt(this.get("totalSelected"));		
		if(total>0){			
			this.addInvoice();
			this.addJournal();		
			this.updateMeterRecordInvoiceId();
			this.updateCustomerBalance();
			
			$("#status").text("កត់ត្រាបានសំរេច").addClass("alert alert-success");
		}		
	},	
	clearControls 	: function() {					
		this.set("transformer_id", "");
		this.set("monthOfSearch", "");	

		this.set("totalSelected",0);
		this.set("total_reading",0);
		this.set("total_active",0);
		this.set("total_reactive",0);

		this.set("invoiceList", []);
		this.set("invoiceItemList", []);
		this.set("journalList", []);
		this.set("meterRecordIDList", []);
		this.set("customerBalanceList", []);
				
		//Remove invoice
		for (var i=0; i< invoiceDS.total(); i++) {
			var di = invoiceDS.at(i);
  			invoiceDS.remove(di);
		}

		//Remove invoice item
		for (var j=0; j< invoiceItemDS.total(); j++) {
			var dj = invoiceItemDS.at(j);
  			invoiceItemDS.remove(dj);
		}

		//Remove journal
		for (var k=0; k< journalDS.total(); k++) {
			var dk = journalDS.at(k);
  			journalDS.remove(dk);
		}
		
		meterRecordDS.filter({
			filters: [
				{ field: "transformer_id", value: 0 }													
			]
		});		
	}
});  
kendo.bind($("#example"), viewModel);

viewModel.pageLoad();

});//End document ready
</script>