<div class="row-fluid">    
	<div class="span12">
		<div id="example" class="k-content">
			
			<div>
				<input data-role="datepicker" data-bind="value: start_date" data-format="dd-MM-yyyy" placeHolder="ចាប់ពី" />
				<input data-role="datepicker" data-bind="value: end_date" data-format="dd-MM-yyyy" placeHolder="ដល់" />
				<input type="text" data-bind="value: so_no" style="width:135px" placeholder="លេខបញ្ជាលក់មិនទាន់រៀបចំ">				
				<button type="button" class="btn btn-default" data-bind="click: search"><i class="icon-search"></i></button>
			</div>

			<br>

			<div>
				<div data-role="grid" data-bind="source: soList, events: { change: soChange }"
			        data-auto-bind="false" data-row-template="soListRowTemplate"
			        data-pageable="true" data-selectable="true"                 
			        data-columns='[			            			            
			            { title: "លេខកូដ" },
			            { title: "កាលបរិច្ឆេទ" },
			            { title: "ថ្ងៃរំពឹងទុក" },
			            { title: "អតិថិជន" },
			            { title: "ចំនួន" },
			            { title: "នៅខ្វះ" },						
			            { title: "លិ.ដឹកជញ្ជូន" },
			            { title: "វិក្កយបត្រ" }			            
			        ]'>
				</div>

				<table width="200px">
					<tr>
						<td>ចំនួនការម៉ង់សរុប</td>
						​​<td align="right"><span data-bind="text: total_quantity"></span></td>
					</tr>
					<tr style="color:red">
						<td>ចំនួននៅខ្វះសរុប</td>
						​​<td align="right"><span data-bind="text: total_remain"></span></td>
					</tr>
				</table>				
			</div>

			<br>

			<div class="row-fluid">
				<div class="span3">
					<br>
					<div data-role="grid" data-bind="source: orderList"
				        data-auto-bind="false" data-row-template="orderListRowTemplate"				                         
				        data-columns='[				            
				            { title: "មុខទំនិញ" },
				            { title: "ចំនួន", width:60 }				            			            
				        ]'>
					</div>
				</div>
				
				<div class="span9">
					<div class="box-generic">

					    <!-- Tabs Heading -->
					    <div class="tabsbar tabsbar-2">
					        <ul class="row-fluid row-merge">
					            <li class="span3 glyphicons cargo active"><a href="#tab1-4" data-toggle="tab"><i></i> លិខិតដឹកជញ្ជូន</a>
					            </li>
					            <li class="span3 glyphicons calculator"><a href="#tab2-4" data-toggle="tab"><i></i> <span>វិក្កយបត្រ</span></a>
					            </li>					            
					        </ul>
					    </div>
					    <!-- // Tabs Heading END -->

					    <div class="tab-content">

					        <!-- Tab content -->
					        <div class="tab-pane active" id="tab1-4">
					        	<div class="pull-right">		
									<table>
										<tr>
											<td>
												លេខលិខិតដឹកជញ្ជូន
											</td>
											<td>
												<input class="k-textbox" data-bind="value: gdnNumber" style="width:138px;" readonly />
											</td>
										</tr>										
										<tr>
											<td>
												កាលបរិច្ឆេទ
											</td>
											<td>
												<input data-role="datepicker" data-bind="value: issued_date" data-format="dd-MM-yyyy" />
											</td>
										</tr>					
									</table>							         		          	
							    </div>

								<div>
									អាសយដ្ឋាន
									<br>
									<textarea id="address" cols="0" rows="2" data-bind="value: address"></textarea>								
								</div>
								
								<br>

								<div data-role="grid" data-bind="source: invoiceItemList"
							        data-auto-bind="false" data-row-template="gdnRowTemplate"                  
							        data-columns='[{ title: "#", width: 35 }, 
							            { title: "ទំនិញ", width: 200 },	                     
							            { title: "ពណ៌នា", width: 200 },
							            { title: "ចំនួន", width: 100 }		            	                    	                    
							            ]'>
								</div>
								<button class="btn btn-inverse" data-bind="click: addNewRow"><i class="icon-plus icon-white"></i></button>
								
								<br>

								<div class="pull-right">
									<button id="add" class="btn btn-primary" data-bind="click: createGDN"><i class="icon-hdd icon-white"></i> កត់ត្រា</button> 					
								</div>

								<div>
									<table>
										<tr>
											<td>
												សំគាល់:
												<br>
												<textarea id="memo" cols="0" rows="2" data-bind="value: memo"></textarea>
											</td>
										</tr>			
									</table>
								</div>	
					        </div>
					        <!-- // Tab content END -->

					        <!-- Tab content -->
					        <div class="tab-pane" id="tab2-4">					        	
								<div class="pull-right">
									<table cellpadding="2" cellspacing="2">
										<tr>				
											<td>លេខវិក្ក​យបត្រ</td>
											<td><input class="k-textbox" data-bind="value: number" style="width:140px;" readonly /></td>
										</tr>			
										<tr>
											<td>ថ្ងៃចេញវិក្កយបត្រ</td>
											<td><input data-role="datepicker" data-bind="value: issued_date" data-format="dd-MM-yyyy" /></td>
										</tr>
										<tr>
											<td>ថ្ងៃបង់ប្រាក់</td>
											<td><input data-role="datepicker" data-bind="value: due_date" data-format="dd-MM-yyyy" /></td>
										</tr>
										<tr>
							                <td>កាលកំណត់</td>
							              	<td><select data-role="dropdownlist" data-text-field="term" data-value-field="id" data-bind="source: paymentTermList, value: payment_term_id"></select></td>
							            </tr> 						
									</table>           		          	
							    </div>

								<div>				
									<table cellpadding="2" cellspacing="2">
										<tr>
							            	<td>
							            		<button type="button" class="btn btn-default" data-bind="click: linkPrint, visible: isUpdate"><i class="icon-print"></i> បោះពុម្ព</button>
							            	</td>
							            	<td></td>
							            </tr>            
										<tr>
							                <td>រូបិយ​ប័ណ្ណ</td>
							              	<td><select data-role="dropdownlist" data-text-field="code" data-value-field="id" data-bind="source: currencyList, value: currency_id"></select></td>
							            </tr>			                     
										<tr>
							                <td>Class</td>
							              	<td><select data-role="combobox" data-text-field="name" data-value-field="id" data-bind="source: classList, value: class_id"></select></td>
							            </tr>            
										<tr>
											<td colspan="2">
												អាសយដ្ឋាន
												<br>
												<textarea id="address" cols="0" rows="2" data-bind="value: address"></textarea>
											</td>
										</tr>
									</table>
								</div>
								
								<br>

								<div data-role="grid" data-bind="source: invoiceItemList"
							        data-auto-bind="false" data-row-template="invoiceRowTemplate"                  
							        data-columns='[{ title: "#", width: 35 }, 
							            { title: "ទំនិញ", width: 175 },	                     
							            { title: "ពណ៌នា", width: 200 },
							            { title: "ចំនួន", width: 95 },
							            { title: "តំលៃ", width: 115 },	                    	                     
							            { title: "VAT", width: 80 },
							            { title: "ទឹកប្រាក់" }	                    	                    
							            ]'>
								</div>
								<button class="btn btn-inverse" data-bind="click: addNewRow"><i class="icon-plus icon-white"></i></button>
								
								<br>

								<div class="pull-right">												
									<div class="innerAll padding-bottom-none-phone">
										<a data-bind="click: btnCreateInvoice" class="widget-stats widget-stats-primary widget-stats-4">
											<span class="txt">សរុប</span>
											<span class="count" style="font-size: 35px;" data-bind="text: total"></span>
											<span class="glyphicons cart_in"><i></i></span>
											<div class="clearfix"></div>
											<i class="icon-play-circle"></i>
										</a>
									</div>										
								</div>

								<div>
									<table>
										<tr>
											<td>
												សំគាល់:
												<br>
												<textarea id="memo" cols="0" rows="2" data-bind="value: memo"></textarea>
											</td>
										</tr>			
									</table>
								</div>								    	
					        </div>
					        <!-- // Tab content END -->					        

					    </div>
					</div>
				</div>
			</div>			

		</div> <!--end div example-->            
	</div> <!--End div span12-->		
</div> <!--End div row-fluid-->

<!-- Order list -->
<script id="orderListRowTemplate" type="text/x-kendo-tmpl">		
	<tr>		
		<td>#:item.name#</td>
		<td>#:qty#</td>													
    </tr>   
</script>

<!-- SO list -->
<script id="soListRowTemplate" type="text/x-kendo-tmpl">		
	<tr>		
		<td>#:number#</td>
		<td>#:issued_date#</td>	
		<td>#:expected_date#</td>	
		<td>#:people.surname# #:people.name#</td>		
		<td>#:qty#</td>
		<td>#:remain#</td>		
		<td>
			#if(gdn.id!=null){#
				#:gdn.number#
			#}else{#
				"មិនទាន់រៀបចំ"
			#}#
		</td>	
		<td>
			#if(remain==0){#
				"រៀបចំរួច"
			#}else if(remain===qty){#
				"មិនទាន់រៀបចំ"
			#}else{#
				"រៀបចំបានខ្លះ"
			#}#
		</td>										
    </tr>   
</script>

<!-- GDN -->
<script id="gdnRowTemplate" type="text/x-kendo-tmpl">		
	<tr>		
		<td class="sno">1</td>
		<td>
			<select data-role="combobox" data-text-field="name" data-value-field="id" 
					data-bind="source: itemList, value: item_id, events:{ change: itemChange }" style="width: 200px" #:so_id>0?disabled="disabled":""#>
			</select>
		</td>		
		<td>
			<input type="text" data-bind="value: description" style="margin-bottom: 0;" />
		</td>
		<td>
			<input data-role="numerictextbox" data-format="n0" data-bind="value: quantity" style="width: 140px" />
		</td>				
    </tr>   
</script>

<!-- Invoice Item List -->
<script id="invoiceRowTemplate" type="text/x-kendo-tmpl">		
	<tr>		
		<td class="sno">1</td>
		<td>
			<select data-role="combobox" data-text-field="name" data-value-field="id" data-suggest="true"
					data-bind="source: itemList, value: item_id, events: {change : itemChange}" #:so_id>0?disabled="disabled":""# >
			</select>
		</td>		
		<td>
			<input type="text" data-bind="value: description" style="margin-bottom: 0;" />
		</td>
		<td>
			<input data-role="numerictextbox" data-format="n0" data-bind="value: quantity, events: {change : change}"
				style="width: 80px" />
		</td>				
		<td>
			<input data-role="numerictextbox" data-format="c0" data-bind="value: unit_price, events: {change : change}" 
				style="width: 100px" />
		</td>
		<td>
			<input data-role="numerictextbox" data-format="p0" 
					data-min="0"
					data-max="1"
					data-step="0.01"
					data-bind="value: vat, events: {change : change}" 
					style="width: 65px;" />
		</td>
		<td align="right">
			#:kendo.toString(kendo.parseFloat(amount), 'c0')#
			<i class="icon-trash" data-bind="events: { click: removeRow "></i>
		</td>		
    </tr>   
</script>

<script>
$(document).ready(function(){

var soDS = new kendo.data.DataSource({
  	transport: {
	  	read: {
		  	url : ARNY.baseUrl + "api/invoices/so_fulfillment",		  
		  	type: "GET",
		  	dataType: "json"
	  	},
	  	update: {
		  	url : ARNY.baseUrl + "api/invoices/invoice",		  
		  	type: "PUT",
		  	dataType: "json"
	  	}
  	},
  	schema: {
	  	model: {
		  	id : "id"
	  	}		
  	},
  	requestEnd: function(e) { 
		var response = e.response; 
		var type = e.type; 
		if(type==="read"){
			var qty = 0;
			var remain = 0;
			for (var i=0;i<response.length;i++) {
				var d = response[i];
				qty += d.qty;
				remain += d.remain;				
			}
			viewModel.set("total_quantity", qty);
			viewModel.set("total_remain", remain);			
		}
	},		  		  	
  	serverFiltering : true	  	
});

var orderDS = new kendo.data.DataSource({
  	transport: {
	  	read: {
		  	url : ARNY.baseUrl + "api/invoices/order_list",		  
		  	type: "GET",
		  	dataType: "json"
	  	}
  	},  		  			  		  	
  	serverFiltering : true	  	
});

var invoiceDS = new kendo.data.DataSource({
  	transport: {	  	
	  	create: {
		  	url : ARNY.baseUrl + "api/invoices/invoice",		  
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
	  	read: {
		  	url : ARNY.baseUrl + "api/invoice_items/invoice_item",		  
		  	type: "GET",
		  	dataType: "json"
	  	}	  	
  	},
  	requestEnd: function(e) { 
		var response = e.response; 
		var type = e.type; 
		if(type==="read"){
			var total = 0;			
			for (var i=0;i<response.length;i++) {
				var d = response[i];
				total += kendo.parseFloat(d.amount);
				viewModel.invoiceItemList.push({
					'invoice_id' 	: 0,
					'item_id' 		: d.item_id,
					'description' 	: d.description,				
					'quantity' 		: d.quantity,
					'unit_price' 	: d.unit_price,
					'vat' 			: d.vat,
					'amount' 		: d.amount,
					'so_id'			: viewModel.get("so_id")				
				});
			}
			viewModel.set("soItemList", response);
			viewModel.set("total", kendo.toString(total, "c0"));			
			viewModel.autoIncreaseNo();	
		}
	},    
  	serverFiltering : true	  		  	
});

var itemDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/inventory_api/item_dropdown",
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

var paymentTermDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/payment_terms/payment_term",
			type: "GET",
			dataType: "json"
		}
	}		
});

var currencyDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/currencies/index",
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
  	schema: {
	 	model: {
		  	id : "id"
	  	}		
  	}
});

//View model
var viewModel = kendo.observable({	
	start_date 		: new Date(),
	end_date		: new Date(),

	account_receiveable_id 	: 4,

	next_inv_id 	 	: "<?php echo $next_inv_id;?>",
	last_invoice_no 	: "<?php echo $last_invoice_no;?>",
	last_gdn_no 		: "<?php echo $last_gdn_no;?>",

	selectedRow 		: null,
	so_no 				: "",

	invoice_id 			: 0,	
	number 				: "",	
	status				: 0,
	biller				: <?php echo $this->session->userdata('user_id'); ?>,	
	customer_id			: 0,
	address				: "",		  	  
	issued_date			: new Date(),
	due_date			: "",
	so_id 				: 0,
	payment_term_id		: "",	
	currency_id			: 1,
	memo				: "",
	class_id			: "",

	total_quantity 		: 0,
	total_remain 		: 0,
	total 				: kendo.toString(0,"c0"),

	soList 			: soDS,
	orderList 		: orderDS,
	paymentTermList	: paymentTermDS,
	currencyList	: currencyDS,
	classList 		: classDS,

	invoiceItemList : [],
	soItemList 		: [],
	itemList 		: [],
	customerBalanceList : [],

	counter 		: 0,
	
	pageLoad 			: function(){		
		this.setDueDate();			
		this.setInvoiceNumber();
		this.setGDNNumber();				
		this.addNewRow();		
	},
	search 	: function(){			
		var sdate = this.get("start_date");
		var edate = this.get("end_date");
		var soNo = this.get("so_no");

		if(sdate==null){
			this.set("start_date", new Date());
		}
		if(edate==null){
			this.set("end_date", new Date());
		}

		if(soNo!=""){
			soDS.filter({
				filters: [
					{ field: "type", value: "SO" },
					{ field: "status !=", value: 1 },					
					{ field: "number", value: soNo }				
				]
			});
		}else{		
			soDS.filter({
				filters: [
					{ field: "type", value: "SO" },
					{ field: "status !=", value: 1 },
					{ field: "issued_date >=", value: kendo.toString(this.get("start_date"), "yyyy-MM-dd") },
					{ field: "issued_date <=", value: kendo.toString(this.get("end_date"), "yyyy-MM-dd") }				
				]
			});
		}

		orderDS.filter({
			filters: [
				{ field: "type", value: "SO" },
				{ field: "status !=", value: 1 },
				{ field: "issued_date >=", value: kendo.toString(this.get("start_date"), "yyyy-MM-dd") },
				{ field: "issued_date <=", value: kendo.toString(this.get("end_date"), "yyyy-MM-dd") }				
			]
		});

		if(kendo.parseInt(this.get("counter"))==0){
			this.setItemSource();
		}		
		this.set("counter", this.get("counter")+1);		
	},
	setDueDate 			: function(){
		var duedate = new Date();
		duedate.setDate(duedate.getDate()+7);
		this.set("due_date", duedate);
	},
	setItemSource 		: function(){	    				  	
	  	for (var i=0; i< itemDS.total(); i++) {
    		var data = itemDS.data();

    		this.itemList.push({
    			id 		: data[i].id,
    			name 	: data[i].item_sku +' '+ data[i].name	    			
    		});
    	}	    	
    },	
    setInvoiceNumber 	: function(){
  		var last_invoice_no = this.get("last_invoice_no");		
		var invoice_no = 0;
		if(last_invoice_no.length>7){
			invoice_no = parseInt(last_invoice_no.substr(7));						
		}
		invoice_no++;

		var str_inv_no = "INV" + kendo.toString(new Date(this.get("issued_date")), "yy") + kendo.toString(new Date(this.get("issued_date")), "MM");
		var inv_no = str_inv_no + kendo.toString(invoice_no, "00000");

		this.set("number", inv_no);				
    },
    setGDNNumber 		: function(){
    	var last_no = this.get("last_gdn_no");		
		var no = 0;
		if(last_no.length>7){
			no = parseInt(last_no.substr(7));			
		}
		no++;

		var str_no = "GDN" + kendo.toString(new Date(this.get("issued_date")), "yy") + kendo.toString(new Date(this.get("issued_date")), "MM");
		var number = str_no + kendo.toString(no, "00000");

		this.set("gdnNumber", number);
    },
	autoIncreaseNo 		: function(){
		$(".sno").each(function(index,element){                 
		   $(element).text(index + 1); 
		});
	},
	addNewRow 			: function(){
		this.invoiceItemList.push({
			'invoice_id' 	: 0,
			'item_id' 		: "",
			'description' 	: "",				
			'quantity' 		: 1,
			'unit_price' 	: 0,
			'vat' 			: 0,
			'amount' 		: 0,
			'so_id'			: 0				
		});		
		this.autoIncreaseNo();			
	},
	removeRow 			: function(e){
		var item = e.data;
        var index = this.get("invoiceItemList").indexOf(item);        
        this.get("invoiceItemList").splice(index, 1);
        this.change();
	},
	change				: function(){			
		var total = 0;		
		$.each(this.get("invoiceItemList"), function(index, data) {				
			var amt = data.quantity * data.unit_price;
			var vat = amt * data.vat;
			var tamt = amt + vat;								        	
            
            data.set("amount", tamt);
            total += tamt;
        });
		this.set("total", kendo.toString(total,"c0"));
    	this.autoIncreaseNo();    	
	},
	itemChange 			: function(e){
		var d = e.data;
		var arr =  this.get("invoiceItemList");			
        var index = arr.indexOf(d);
        var data = arr[index];
        var item = itemDS.get(d.item_id);	        
		
        data.set("description", item.name);
        data.set("unit_price", item.price);
        data.set("vat", item.vat);
        
        this.change();	        	        	
	},
	soChange: function(eventArgs) {
		this.set("selectedRow", eventArgs.sender.dataItem(eventArgs.sender.select()));
		var d = this.get("selectedRow");
	    var id = d.id;

	    this.set("customer_id", d.people.id);
	    this.set("so_id", id);
	    this.set("balance", d.people.balance);
	    this.set("address", d.people.address);
	    this.set("company_id", d.people.company_id);
	    this.set("invoiceItemList", []);

	    invoiceItemDS.filter( { field: "invoice_id", value: id });
	       
	},
	btnCreateInvoice 	: function(){		
		this.addInvoice();
		this.updateCustomerBalance();
	    this.addJournal();				
	},		
    addInvoice 			: function(){
    	if(kendo.parseFloat(this.get("total"))>0){
    		//Add invoice to datasource	
	    	invoiceDS.add({
	    		'number' 			: this.get("number"),
			   	'type'				: "Invoice",				   	
			   	'status' 			: this.get("status"),
			   	'amount'			: kendo.parseFloat(this.get("total")),
			   	'biller' 			: this.get("biller"),
			   	'customer_id' 		: this.get("customer_id"),			   	
			   	'address' 			: this.get("address"),
			   	'issued_date' 		: kendo.toString(new Date(this.get("issued_date")),"yyyy-MM-dd"),
			   	'due_date' 			: kendo.toString(new Date(this.get("due_date")),"yyyy-MM-dd"),			   	
			   	'so_id' 			: this.get("so_id"),
			   	'payment_term_id'	: this.get("payment_term_id"),
			   	'currency_id' 		: this.get("currency_id"),
			   	'class_id' 			: this.get("class_id"),
			   	'memo' 				: this.get("memo"),
			   	'company_id'		: this.get("company_id"),

			   	'invoice_items'		: this.get("invoiceItemList")
	    	});

	    	//Add new customer balances to []
			var balance = kendo.parseFloat(this.get("balance")) + kendo.parseFloat(this.get("total"));
			this.customerBalanceList.push({
				id			: kendo.parseInt(this.get("customer_id")),
				balance 	: balance
			});
						
	    	invoiceDS.sync();	    	
	    	this.updateSO();		    			    	
    	}        	    		    	
    },
    createGDN 		: function(){    	
        //Add invoice to datasource	
    	invoiceDS.add({
    		'number' 			: this.get("gdnNumber"),
		   	'type'				: "GDN",
		   	'status' 			: this.get("status"),
		   	'amount'			: kendo.parseFloat(this.get("total")),
		   	'biller' 			: this.get("biller"),
		   	'customer_id' 		: this.get("customer_id"),			   	
		   	'address' 			: this.get("address"),
		   	'issued_date' 		: kendo.toString(this.get("issued_date"),"yyyy-MM-dd"),			   	
		   	'memo' 				: this.get("memo"),
		   	'so_id'				: this.get("so_id"),
		   	'company_id'		: this.get("company_id"),
		   	
		   	'invoice_items'		: this.get("invoiceItemList")
    	});
    	invoiceDS.sync();
    	this.clearInvoice();	    	
    },	    
    addJournal 			: function(){				
		var journalEntries = [];
		var has_inventory = false;			

		//Income account	
		for (var i=0;i<this.invoiceItemList.length;i++){				
			//A/R
			if(i==0){					
				journalEntries.push({
			 		account_id 	: this.get("account_receiveable_id"),	 		
			 		dr 			: kendo.parseFloat(this.get("total")), 
			 		cr 			: 0,
			 		class_id  	: this.get("class_id"),
			 		memo 		: ""	 		
				});
			}

			//Sale account
			var data = this.invoiceItemList[i];
			var item = itemDS.get(data.item_id);

			if(item.item_type_id==1){
				has_inventory = true;
			}
											
			journalEntries.push({
		 		account_id 	: item.income_account_id,	 		
		 		dr 			: 0, 
		 		cr 			: data.amount,
		 		class_id  	: this.get("class_id"),
		 		memo 		: data.description	 		
			});		
		}

		//Inventory account
		if(has_inventory){
			var total_inventory = 0;
			var cogs_id = 0;
			//COGS
			for (var j=0;j<this.invoiceItemList.length;j++){																
				var d = this.invoiceItemList[j];
				var it = itemDS.get(d.item_id);
				if(it.item_type_id==1){
					cogs_id = it.cogs_account_id;
					total_inventory += (it.cost*d.quantity);
				}
			}
			journalEntries.push({
		 		account_id 	: cogs_id,	 		
		 		dr 			: total_inventory, 
		 		cr 			: 0,
		 		class_id  	: this.get("class_id"),
		 		memo 		: ""	 		
			});

			//Inventory account
			for (var k=0;k<this.invoiceItemList.length;k++){
				var data = this.invoiceItemList[k];
				var item = itemDS.get(data.item_id);

				if(item.item_type_id==1){
					journalEntries.push({
				 		account_id 	: item.general_account_id,	 		
				 		dr 			: 0, 
				 		cr 			: (item.cost*data.quantity),
				 		class_id  	: this.get("class_id"),
				 		memo 		: data.description	 		
					});	
				}
			}						
			
		}
		
		//Add journal to datasource
		journalDS.add({	 		
	 		journalEntries : journalEntries,
	 		memo: "ចំណូលពី​ការលក់", 
	 		voucher: "",
	 		class_id: this.get("class_id"),
	 		budget_id: 0,
	 		donor_id: 0,
	 		check_no: "",
	 		people_id: this.get("customer_id"),
	 		employee_id: this.get("biller"),
	 		invoice_id: this.get("next_inv_id"),
	 		payment_id: 0,
	 		bill_id: 0,	
	 		date: kendo.toString(this.get("issued_date"), "yyyy-MM-dd"), 
	 		transaction_type: "Invoice"	 			 		
	 	});	 	

	  	journalDS.sync();
		this.clearInvoice();	 	
	},
	updateSO			: function(){		
		//SO 
		var tso = 0;
		var so = this.get("soItemList");
		for (var i=0;i<so.length;i++) {
			var itso = so[i];
			tso += itso.quantity;
		}

		//Invoice
		var tinv = 0;
		var inv = this.get("invoiceItemList");
		for (var i=0;i<inv.length;i++) {
			var it = inv[i];
			if(it.so_id>0){
				tinv += it.quantity;
			}			
		}

		//Status for SO
		var status = 0;
		if(tso==tinv){
			status = 1;
		}else if(tinv>0){
			status = 2;
		}
		
		var id = this.get("so_id");
		if(id>0){			
			var d = soDS.get(id);						
			d.set("status", status);
			soDS.sync();
		}								
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
			}
		});				
	},
	clearInvoice 		: function(){
		var next_inv_id = kendo.parseInt(this.get("next_inv_id"))+1;
		this.set("next_inv_id", next_inv_id);
		this.set("last_invoice_no", this.get("number"));
		this.set("last_gdn_no", this.get("gdnNumber"));
			    	
		this.set("invoiceItemList", []);
		this.set("customerBalanceList", []);

		this.set("memo", "");
		this.set("total", kendo.toString(0,"c0"));

		//Remove invoice
		for (var i=0; i< invoiceDS.total(); i++) {
			var dataItem = invoiceDS.at(i);
				invoiceDS.remove(dataItem);
		}

		//Remove journal
		for (var j=0; j< journalDS.total(); j++) {
			var dataItem = journalDS.at(j);
				journalDS.remove(dataItem);
		}

		//Clear SO and Order
		soDS.filter( { field: "id", value: 0 });
		orderDS.filter( { field: "id", value: 0 });			
	}	
});  
kendo.bind($("#example"), viewModel);

viewModel.pageLoad();
itemDS.read();

}); //End document ready
</script>