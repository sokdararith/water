<div class="row-fluid">
	<div class="span12">
		<div id="example" class="k-content">			
			<h4 align="center">បង្កាន់ដៃលក់</h4>

			<div class="row-fluid">				
				<div class="span8">
					<table cellpadding="2" cellspacing="2">
						<tr>				
							<td>លេខបង្កាន់ដៃលក់</td>
							<td><input class="k-textbox" data-bind="value: number" style="width:138px;" readonly /></td>
						</tr>
						<tr>
							<td>កាលបរិច្ឆេទ</td>
							<td><input data-role="datepicker" data-bind="value: issued_date" data-format="dd-MM-yyyy" /></td>
						</tr>					         
						<tr>
			                <td>Class</td>
			              	<td><select data-role="combobox" data-text-field="name" data-value-field="id" data-bind="source: classList, value: class_id"></select></td>
			            <tr>            
						<tr>
							<td colspan="2">
								អាសយដ្ឋាន
								<br>
								<textarea id="memo" cols="0" rows="2" class="k-textbox" style="width:250px" data-bind="value: address"></textarea>
							</td>
						</tr>
					</table>
				</div>

				<div class="span4">			
					<table cellpadding="2" cellspacing="2">					
						<tr>
			                <td>វីធីបង់ប្រាក់</td>
			              	<td><select data-role="dropdownlist" data-text-field="name" data-value-field="id" data-bind="source: paymentMethodList, value: payment_method_id" data-option-label="(--- ជ្រើសរើស ---)"></select></td>
			            <tr>
						<tr>
			                <td>លេខកូដសែក</td>
			                <td><input id="check_no" class="k-textbox" data-bind="value: check_no" /></td>
			            <tr>
			            <tr>
							<td>គណនីសាច់ប្រាក់</td>
							<td><select data-role="combobox" data-text-field="name" data-value-field="id" data-bind="source: cashAccountList, value: cash_account_id"></select></td>
						</tr>					
						<tr>
			            	<td>លេខបញ្ជាលក់</td>				
							<td><select data-role="dropdownlist" data-text-field="number" data-value-field="id" data-auto-bind="false" data-bind="source: soList, value: so_id, events:{ change: soChange}" data-option-label="(--- ជ្រើសរើស ---)"></select></td>
						</tr>
						<tr>
			            	<td>លេខសម្រង់តំម្លៃ</td>				
							<td><select data-role="dropdownlist" data-text-field="number" data-value-field="id" data-auto-bind="false" data-bind="source: estimateList, value: estimate_id, events:{ change: estimateChange}" data-option-label="(--- ជ្រើសរើស ---)"></select></td>
						</tr>
						<tr>
			            	<td>លេខលិខិតដឺកជញ្ជូន</td>				
							<td><select data-role="dropdownlist" data-text-field="number" data-value-field="id" data-auto-bind="false" data-bind="source: gdnList, value: gdn_id, events:{ change: gdnChange}" data-option-label="(--- ជ្រើសរើស ---)"></select></td>
						</tr>
					</table>           		          	
			    </div>			    			
			</div>			

			<div data-role="grid" data-bind="source: receiptItemList"
		        data-auto-bind="false" data-row-template="receiptRowTemplate"                  
		        data-columns='[{ title: "", width: 20 },
		        	{ title: "ល.រ", width: 35 },
		            { title: "ទំនិញ", width: 150 },	                     
		            { title: "ពណ៌នា", width: 200 },
		            { title: "ចំនួន", width: 85 },
		            { title: "តំលៃ", width: 115 },		            
		            { title: "ទឹកប្រាក់", width: 80 },
		            { title: "vat", width: 30 }	                    	                    
		            ]'>
			</div>
			<button class="btn btn-inverse" data-bind="click: addNewRow"><i class="icon-plus icon-white"></i></button>
			
			<div class="row-fluid">				
				<div class="span8">
					សំគាល់:
					<br>
					<textarea id="memo" cols="0" rows="2" class="k-textbox" style="width:250px" data-bind="value: memo" placeholder="សំគាល់ 1 (សំរាប់អតិថិជន)"></textarea>
					<textarea id="memo2" cols="0" rows="2" class="k-textbox" style="width:250px" data-bind="value: memo2" placeholder="សំគាល់ 2 (សំរាប់ផ្ទៃក្នុង)"></textarea>
				</div>

				<div class="span4">
					<table width="100%">
						<tr align="right">
							<td>សរុបរង:</td>
							<td width="50%"><span data-bind="text: sub_total"></span></td>
						</tr>
						<tr align="right">
							<td align="top">
								<select data-role="combobox" data-text-field="name" data-value-field="id" 
										data-bind="source: vatList, value: vat_id, events: {change: change}" placeholder="VAT" style="width:90px"></select>								
							</td>
							<td><span data-bind="text: vat"></span></td>
						</tr>
						<tr align="right">
							<td>សរុប:</td>
							<td bgcolor="#00BFFF"><span data-bind="text: total"></span></td>
						</tr>						
					</table>
				</div>													
			</div>

			<br>

			<div class="row-fluid">				
				<div class="span12" align="right">
					<span class="btn btn-primary btn-icon glyphicons print" data-bind="click: linkPrint, visible: isUpdate"><i></i> បោះពុម្ព</span>
					<span class="btn btn-primary btn-icon glyphicons cart_in" data-bind="click: createReceipt"><i></i> រៀបចំវិក្កយបត្រ</span>
				</div>
			</div>		
		</div><!--End div example-->
	</div><!--End div span12-->
</div><!--End div row-fluid-->

<script id="receiptRowTemplate" type="text/x-kendo-tmpl">		
	<tr>		
		<td>
			<i class="icon-trash" data-bind="events: { click: removeRow "></i>			
		</td>
		<td class="sno">1</td>
		<td>
			<select data-role="combobox" data-text-field="name" data-value-field="id" 
					data-bind="source: itemList, value: item_id, events: {change : itemChange}" style="width:200px">
			</select>
		</td>		
		<td>
			<input type="text" data-bind="value: description" style="margin-bottom: 0;" />
		</td>
		<td>
			<input data-role="numerictextbox" data-format="n0" data-bind="value: quantity, events: {change : change}" 
					style="width: 80px;" />
		</td>				
		<td>
			<input data-role="numerictextbox" data-format="c" data-bind="value: unit_price, events: {change : change}" 
					style="width: 110px;" />
		</td>		
		<td align="right">
			#:kendo.toString(kendo.parseFloat(quantity)*(kendo.parseFloat(unit_price)), "c")#			
		</td>
		<td>
			<input type="checkbox" data-bind="checked: vat, events: {change : change}" />			
		</td>		
    </tr>   
</script>

<script>
	var banhji = banhji || {};
	banhji.ds = banhji.ds || {};
	banhji.vm = banhji.vm || {};

	banhji.customer_id = "<?php echo $this->uri->segment(3); ?>" || 0;
	banhji.invoice_id = "<?php echo $this->uri->segment(4); ?>" || 0;
	
	banhji.ds.company = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/companies/company",
				type: "GET",
				dataType: "json"
			}			
		},
		serverFiltering: true
	});
	
	banhji.ds.customer = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/people_api/people",
				type: "GET",
				dataType: "json"
			},
			update: {
				url: ARNY.baseUrl + "api/people_api/people",
				type: "PUT",
				dataType: "json"
			}
		},		
		schema: {
			model: {
				id: "id"
			}
		},
		filter: { field: "id", value: banhji.customer_id },	
		serverFiltering: true
	});		

	banhji.ds.cashAccount = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/accounts/account",
				type: "GET",
				dataType: "json"
			}
		},
		filter: { field: "account_type_id", value: 6 },
		serverFiltering: true
	});

	banhji.ds.currencyRate = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/currency_rates/currency_rate",
				type: "GET",
				dataType: "json"
			}
		},
		filter: { field: "status", value: 1 },
		serverFiltering: true		
	});

	banhji.ds.paymentMethod = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/payment_methods/payment_method",
				type: "GET",
				dataType: "json"
			}
		}
	});

	banhji.ds.item = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/inventory_api/item_dropdown",
				type: "GET",
				dataType: "json"
			}
		}
	});

	banhji.ds.vat = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/inventory_api/items",
				type: "GET",
				dataType: "json"
			}
		},
		filter: { field: "item_type_id", value: 6 },
		serverFiltering: true
	});

	banhji.ds.classDS = new kendo.data.DataSource({
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

	banhji.ds.invoice = new kendo.data.DataSource({
	  	transport: {
		  	read: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
			  	type: "GET",
			  	dataType: "json"
		  	},
		  	create: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
			  	type: "POST",
			  	dataType: "json"
		  	},
		  	update: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
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
	  	},
	  	requestEnd: function(e) {
		    var response = e.response;
		    var type = e.type;
		    if(type==='read'){
		    	invoiceModel.set("invoiceEdit", response);
		    	invoiceModel.loadInvoiceEdit();
		    }
		},	  	
	  	serverFiltering : true	  	
	});

	banhji.ds.invoiceItem = new kendo.data.DataSource({
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
	  	},
	  	batch: true	  		  	
	});

	banhji.ds.estimate = new kendo.data.DataSource({
	  	transport: {
		  	read: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
			  	type: "GET",
			  	dataType: "json"
		  	},
		  	update: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
			  	type: "PUT",
			  	dataType: "json"
		  	}
	  	},	  		  	
	  	serverFiltering : true	  	
	});

	banhji.ds.gdn = new kendo.data.DataSource({
	  	transport: {
		  	read: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
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
	  	serverFiltering : true	  	
	});

	banhji.ds.so = new kendo.data.DataSource({
	  	transport: {
		  	read: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
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
	  	serverFiltering : true	  	
	});

	banhji.ds.journal = new kendo.data.DataSource({
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

	banhji.vm.receipt = kendo.observable({
		next_inv_id 	 	: "<?php echo $next_inv_id;?>",		
		last_receipt_no 	: "<?php echo $last_receipt_no;?>",						
		biller				: <?php echo $this->session->userdata('user_id'); ?>,	
		
		address				: "",		  	  
		issued_date			: new Date(),		
		payment_method_id   : 1,
		cash_account_id 	: "",
		memo				: "",
		memo2 				: "",
		class_id			: "",		
		estimate_id 		: 0,
		gdn_id 				: 0,
		so_id				: 0,	
		vat_id				: "",						
		deposit_amount  	: 0,
		customer_rate_to_company_rate : 1,

		// sub_total			: kendo.toString(0,"c0"),			
		// vat 				: kendo.toString(0,"c0"),	
		// total				: kendo.toString(0,"c0"),					    
				
		receiptItemList 	: [],
		itemList 			: [],

		vatList 			: banhji.ds.vat,
		estimateList 		: banhji.ds.estimate,
		gdnList 			: banhji.ds.gdn,
		soList 				: banhji.ds.so,
		paymentMethodList	: banhji.ds.paymentMethod,
		cashAccountList 	: banhji.ds.cashAccount,
		currencyList		: banhji.ds.currency,
		classList 			: banhji.ds.classDS,
						
		pageLoad 			: function(){
			banhji.ds.customer.filter({ field: "id", value: banhji.customer_id });
			
			banhji.ds.estimate.filter({
				filters: [
					{ field: "customer_id", value: banhji.customer_id },
					{ field: "status", value: 0 },
					{ field: "type", value: "Estimate" }
				]
			});

			banhji.ds.gdn.filter({
				filters: [
					{ field: "customer_id", value: banhji.customer_id },
					{ field: "status", value: 0 },
					{ field: "type", value: "GDN" }
				]
			});

			banhji.ds.so.filter({
				filters: [
					{ field: "customer_id", value: banhji.customer_id },
					{ field: "status", value: 0 },
					{ field: "type", value: "SO" }
				]
			});

			banhji.ds.currencyRate.fetch();
		
			this.setReceiptNumber();
			this.setItemSource();
			this.loadCustomer();			
			this.addNewRow();
		},							
	    setItemSource 		: function(){	    		    	
			banhji.ds.item.fetch(function(){
			  	var d = this.data();			  	
			  	$.each(d, function(index, data) {		    				    		
		    		banhji.vm.receipt.itemList.push({
		    			id 		: data.id,
		    			name 	: data.item_sku +' '+ data.name	    			
		    		});
		    	});
			});				    			  	    	
	    },	    	    
	    setReceiptNumber 	: function(){
	    	var last_receipt_no = this.get("last_receipt_no");		
			var invoice_no = 0;
			if(last_receipt_no.length>6){
				invoice_no = parseInt(last_receipt_no.substr(6));			
			}
			invoice_no++;

			var str_inv_no = "SR" + kendo.toString(new Date(this.get("issued_date")), "yy") + kendo.toString(new Date(this.get("issued_date")), "MM");
			var inv_no = str_inv_no + kendo.toString(invoice_no, "00000");

			this.set("number", inv_no);
	    },
	    loadCustomer 		: function(){
	    	var self = this;			
			banhji.ds.customer.fetch(function(){
			  	var d = this.data()[0];
			  	self.set("customer", d);		  	
			  	self.set("address", d.address);
			  	
			  	banhji.ds.company.filter({ field: "id", value: d.company_id });
			  	kendo.culture(d.currencies.sub_code);			  	  			  	
			});															    			  	    	
	    },	    
		autoIncreaseNo 		: function(){
			$(".sno").each(function(index,element){                 
			   $(element).text(index + 1); 
			});
		},
		addNewRow 			: function(){
			this.receiptItemList.push({
				'invoice_id' 	: 0,
				'item_id' 		: "",
				'description' 	: "",				
				'quantity' 		: 1,
				'unit_price' 	: 0,								
				'amount' 		: 0,
				'rate'			: 0,
				'vat' 			: false				
			});
			this.autoIncreaseNo();			
		},
		removeRow 			: function(e){
			var item = e.data;
	        var index = this.get("receiptItemList").indexOf(item);        
	        this.get("receiptItemList").splice(index, 1);
	        this.change();
		},		
		change				: function(){			
			var subTotal = 0;
			var vat = 0;
			var vatAmount = 0;

			var vat_id = this.get("vat_id");			
			if(vat_id>0 || vat_id!=""){				
				var vatItem = banhji.ds.vat.get(vat_id);
				vatAmount = vatItem.price;
			}

			$.each(this.get("receiptItemList"), function(index, data) {				
				var amt = data.quantity * data.unit_price;
				subTotal += amt;

				if(data.vat && vatAmount>0){
					vat += amt * vatAmount;						
				}
	        });

	        var total = subTotal + vat;			

	        this.set("sub_total", kendo.toString(subTotal, "c"));
	        this.set("vat", kendo.toString(vat, "c"));			
			this.set("total", kendo.toString(total, "c"));
			
	    	this.autoIncreaseNo();    	
		},
		itemChange 			: function(e){
			var data = e.data;
	        var rate = 1;
	        var item = banhji.ds.item.get(data.item_id);
	        var customerCode = this.get("customer").currency_code;

	        if(item.currency_code!==customerCode){
	        	var customerCodeRate = this.getCurrencyRateByCode(customerCode);
	        	var itemCodeRate = this.getCurrencyRateByCode(item.currency_code);

	        	if(itemCodeRate>0 && customerCodeRate>0){
	        		rate = itemCodeRate/customerCodeRate;
	        	}
	        }	        
	        
    		data.set("description", item.name);
	        data.set("unit_price", item.price/rate);
	        	        
	        this.change();	                	        	
		},
		getCurrencyRateByCode 	: function(code){
			var rate = 0;			
			$.each(banhji.ds.currencyRate.data(), function(index, value){	        	
	        	if(code===value.code){	        		
	        		rate = value.rate;
	        		return false;
	        	}	        	
	        });
			
	        return kendo.parseFloat(rate);
		},		
		estimateChange 		: function(e){
			var d = e.sender;
			var id = kendo.parseInt(d._selectedValue);
			this.set("receiptItemList", []);			
			if(id>0 || id!=null){
			 	var d = estimateDS.get(id);			
			 	var items = d.invoice_items;

			 	$.each(items, function(index, data) {			 		
			 		this.receiptItemList.push({
						'invoice_id' 	: data.invoice_id,
						'item_id' 		: data.item_id,
						'description' 	: data.description,				
						'quantity' 		: data.quantity,
						'unit_price' 	: data.unit_price,						
						'amount' 		: data.amount,
						'vat' 			: data.vat				
					});			
			 	});

			 	this.set("estimate_id", id);
			 	this.set("gdn_id", 0);
			 	this.set("so_id", 0);

			 	this.change();
			 	this.autoIncreaseNo();				
			}else{
				this.set("total", kendo.toString(0,"c0"));
			}				
		},
		gdnChange 			: function(e){
			var d = e.sender;
			var id = kendo.parseInt(d._selectedValue);
			this.set("receiptItemList", []);			
			if(id>0 || id!=null){
			 	var d = gdnDS.get(id);			
			 	var items = d.invoice_items;

			 	$.each(items, function(index, data) {			 		
			 		this.receiptItemList.push({
						'invoice_id' 	: data.invoice_id,
						'item_id' 		: data.item_id,
						'description' 	: data.description,				
						'quantity' 		: data.quantity,
						'unit_price' 	: data.unit_price,						
						'amount' 		: data.amount,
						'vat' 			: data.vat				
					});			
			 	});

			 	this.set("estimate_id", 0);
			 	this.set("gdn_id", id);
			 	this.set("so_id", 0);

			 	this.change();
			 	this.autoIncreaseNo();				
			}else{
				this.set("total", kendo.toString(0,"c0"));
			}				
		},
		soChange 			: function(e){
			var d = e.sender;
			var id = kendo.parseInt(d._selectedValue);
			this.set("receiptItemList", []);			
			if(id>0 || id!=null){
			 	var d = soDS.get(id);			
			 	var items = d.invoice_items;

			 	$.each(items, function(index, data) {			 		
			 		this.receiptItemList.push({
						'invoice_id' 	: data.invoice_id,
						'item_id' 		: data.item_id,
						'description' 	: data.description,				
						'quantity' 		: data.quantity,
						'unit_price' 	: data.unit_price,						
						'amount' 		: data.amount,
						'vat' 			: data.vat,
						'so_id'			: data.so_id										
					});			
			 	});

			 	this.set("estimate_id", 0);
			 	this.set("gdn_id", 0);
			 	this.set("so_id", id);

			 	this.change();
			 	this.autoIncreaseNo();				
			}else{
				this.set("total", kendo.toString(0,"c0"));
			}				
		},		
	    createReceipt 		: function(){
	    	//Exchange rate
			var rate = 1;
			var company = banhji.ds.company.at(0);
			var customer = this.get("customer");

	        if(company.based_currency!==customer.currency_code){
	        	var companyCodeRate = this.getCurrencyRateByCode(company.based_currency);
	        	var customerCodeRate = this.getCurrencyRateByCode(customer.currency_code);

	        	if(customerCodeRate>0 && companyCodeRate>0){
	        		rate = companyCodeRate/customerCodeRate;
	        	}	
	        }

	        this.set("customer_rate_to_company_rate", rate);

	        //Modify rate in invoice item
	        $.each(this.get("receiptItemList") ,function(index, data){
	        	data.set("rate", rate);
	        });

	        //Add invoice to datasource	
	    	banhji.ds.invoice.add({
	    		'number' 			: this.get("number"),
			   	'type'				: "Receipt",
			   	'status' 			: 0,
			   	'vat'				: this.get("vat"),			   	
			   	'amount'			: kendo.parseFloat(this.get("total")),
			   	'rate'				: rate,
			   	'vat_id'			: this.get("vat_id"),
			   	'biller' 			: this.get("biller"),
			   	'customer_id' 		: banhji.customer_id,			   	
			   	'address' 			: this.get("address"),
			   	'issued_date' 		: kendo.toString(this.get("issued_date"),"yyyy-MM-dd"),
			   	'estimate_id' 		: this.get("estimate_id"),
				'gdn_id' 			: this.get("gdn_id"),			   	
			   	'class_id' 			: this.get("class_id"),
			   	'memo' 				: this.get("memo"),
			   	'memo2'				: this.get("memo2"),
			   	'company_id'		: this.get("customer").company_id,
			   	
			   	'invoice_items'		: this.get("receiptItemList")
	    	});
	    				
	    	banhji.ds.invoice.sync();
	    		    	
	    	this.addJournal();	    	
	    	this.updateEstimate();
		    this.updateGDN();	    		    	
	    },	    	  
	    addJournal 			: function(){				
			var journalEntries = [];		
			
			var saleList = {};			
			var inventoryList = {};
			var cogsList = {};
			var witdrawList = {};
			var depositAmount = 0;
			var rate = this.get("customer_rate_to_company_rate");
						

			var self = this;
			$.each(this.get("receiptItemList"), function(index, data){								
				var item = banhji.ds.item.get(data.item_id);
				var amt = (data.quantity*data.unit_price)*rate;						

				//Add sale list
				var incomeID = kendo.parseInt(item.income_account_id);											
				if(incomeID>0){
					if(saleList[incomeID]===undefined){
						saleList[incomeID]={"id": incomeID, "amt": amt};						
					}else{											
						if(saleList[incomeID].id===incomeID){
							saleList[incomeID].amt += amt;
						}else{
							saleList[incomeID]={"id": incomeID, "amt": amt};
						}
					}
				}								

				switch(kendo.parseInt(item.item_type_id)){		        
					case 1: //Inventory
						//Exchange rate from item rate to company rate
						var rate_from_item_to_company = 1;				        
				        var companyCode = banhji.ds.company.at(0).based_currency;

				        if(item.currency_code!==companyCode){
				        	var companyCodeRate = self.getCurrencyRateByCode(companyCode);
				        	var itemCodeRate = self.getCurrencyRateByCode(item.currency_code);

				        	if(itemCodeRate>0 && companyCodeRate>0){
				        		rate_from_item_to_company = itemCodeRate/companyCodeRate;
				        	}
				        }

						//Add cogs list						
						var itemCost = data.quantity*(item.cost/rate_from_item_to_company);

						//Add cogs list
						var cogsID = kendo.parseInt(item.cogs_account_id);
						if(cogsList[cogsID]===undefined){
							cogsList[cogsID]={"id": cogsID, "amt": itemCost};						
						}else{											
							if(cogsList[cogsID].id===cogsID){
								cogsList[cogsID].amt += itemCost;
							}else{
								cogsList[cogsID]={"id": cogsID, "amt": itemCost};
							}
						}						

						//Add inventory list
						var inventoryID = kendo.parseInt(item.general_account_id);
						if(inventoryList[inventoryID]===undefined){
							inventoryList[inventoryID]={"id": inventoryID, "amt": itemCost};						
						}else{											
							if(inventoryList[inventoryID].id===inventoryID){
								inventoryList[inventoryID].amt += itemCost;
							}else{
								inventoryList[inventoryID]={"id": inventoryID, "amt": itemCost};
							}
						}										

					  	break;
					case 5: //Customer Deposit
						depositAmount += amt;
						var depositID = kendo.parseInt(item.general_account_id);

						if(amt>0){ //Deposit														
							if(saleList[depositID]===undefined){
								saleList[depositID]={"id": depositID, "amt": amt};						
							}else{											
								if(saleList[depositID].id===depositID){
									saleList[depositID].amt += amt;
								}else{
									saleList[depositID]={"id": depositID, "amt": amt};
								}
							}																			
						}else{ //Witdraw												
							if(witdrawList[depositID]===undefined){
								witdrawList[depositID]={"id": depositID, "amt": amt*-1};						
							}else{											
								if(witdrawList[depositID].id===depositID){
									witdrawList[depositID].amt += (amt*-1);
								}else{
									witdrawList[depositID]={"id": depositID, "amt": amt*-1};
								}
							}														
						}												

					  	break;					
					default:
				  	//default here
				} //End Swtich
			});//End Foreach Loop

			//VAT
			var vatID = this.get("vat_id");			
			if(vatID>0 || vatID!==""){
				var vats = banhji.ds.vat.get(vatID);
				var vatOutID = vats.income_account_id;
				
				if(vatOutID>0){
					var vatAmt = kendo.parseFloat(this.get("vat"))*rate;
					if(saleList[vatOutID]===undefined){
						saleList[vatOutID]={"id": vatOutID, "amt": vatAmt};						
					}else{											
						if(saleList[vatOutID].id===vatOutID){
							saleList[vatOutID].amt += vatAmt;
						}else{
							saleList[vatOutID]={"id": vatOutID, "amt": vatAmt};
						}
					}
				}
			}			
			
			//Sale list	to journal		
			if(!jQuery.isEmptyObject(saleList)){								
				//Sum cash
				var cash = 0;				
				$.each(saleList, function(index, value){					
					cash += value.amt;					
				});				

				//Cash on Dr							
				journalEntries.push({
			 		account_id 	: this.get("cash_account_id"),	 		
			 		dr 			: cash, 
			 		cr 			: 0,
			 		class_id  	: this.get("class_id"),
			 		memo 		: this.get("memo")	 		
				});

				//Sale accounts on Cr
				$.each(saleList, function(index, value){
					journalEntries.push({
				 		account_id 	: value.id,	 		
				 		dr 			: 0, 
				 		cr 			: value.amt,
				 		class_id  	: self.get("class_id"),
				 		memo 		: self.get("memo")	 		
					});
				});
			}

			//Inventory to journal
			//COGS on Dr 			
			if(!jQuery.isEmptyObject(cogsList)){							
				$.each(cogsList, function(index, value){				
					journalEntries.push({
				 		account_id 	: value.id,	 		
				 		dr 			: value.amt, 
				 		cr 			: 0,
				 		class_id  	: self.get("class_id"),
				 		memo 		: self.get("memo")	 		
					});	
				});							
			}
			//Inventory on Cr
			if(!jQuery.isEmptyObject(inventoryList)){
				$.each(inventoryList, function(index, value){					
					journalEntries.push({
				 		account_id 	: value.id,	 		
				 		dr 			: 0, 
				 		cr 			: value.amt,
				 		class_id  	: self.get("class_id"),
				 		memo 		: self.get("memo")	 		
					});
				});
			}
			
			//Witdraw to journal
			if(!jQuery.isEmptyObject(witdrawList)){
				//Deposit on Dr
				$.each(witdrawList, function(index, value){
					journalEntries.push({
				 		account_id 	: value.id,	 		
				 		dr 			: value.amt, 
				 		cr 			: 0,
				 		class_id  	: self.get("class_id"),
				 		memo 		: self.get("memo")	 		
					});
				});

				var wCash = 0;
				$.each(witdrawList, function(index, value){					
					wCash += value.amt;
				});

				//Cash on Cr							
				journalEntries.push({
			 		account_id 	: this.get("cash_account_id"),	 		
			 		dr 			: 0, 
			 		cr 			: wCash,
			 		class_id  	: this.get("class_id"),
			 		memo 		: this.get("memo")	 		
				});				
			}
			//Calcualte customer deposit
			if(depositAmount>0){				
				var deposit = kendo.parseFloat(customerModel.get("customer").deposit_amount) + kendo.parseFloat(depositAmount);
				this.set("deposit_amount", deposit);
			}
			
			//Add journal to datasource
			banhji.ds.journal.add({	 		
		 		journalEntries : journalEntries,
		 		memo: "បង្កាន់ដៃលក់ជាសាច់ប្រាក់", 
		 		voucher: "",
		 		class_id: this.get("class_id"),
		 		budget_id: 0,
		 		donor_id: 0,
		 		check_no: "",
		 		people_id: banhji.customer_id,
		 		employee_id: this.get("biller"),
		 		invoice_id: this.get("next_inv_id"),
		 		payment_id: 0,
		 		bill_id: 0,	
		 		date: kendo.toString(this.get("issued_date"), "yyyy-MM-dd"), 
		 		transaction_type: "Receipt"	 			 		
		 	});
		 			 	
		 	banhji.ds.journal.sync();
		  	this.updateCustomerDeposit();
			this.clearReceipt();	 	
		},				
		updateEstimate		: function(){
			var id = this.get("estimate_id");
			
			if(id>0){
				var d = estimateDS.get(id);
				d.set("status", 1);
				banhji.ds.estimate.sync();
			}								
		},
		updateGDN			: function(){
			var id = this.get("gdn_id");
			
			if(id>0){
				var d = gdnDS.get(id);
				d.set("status", 1);
				banhji.ds.gdn.sync();
			}								
		},
		updateCustomerDeposit : function(){			
			var amount = this.get("deposit_amount");
			if(amount>0){
				$.ajax({
					type: "PUT",
					url: ARNY.baseUrl + "api/people_api/deposit",			
					data: { id: banhji.customer_id, amount: amount },
					dataType: "json",
					success: function (response) {
						//var data = response.d;			  
					}
				});
			}				
		},
	    clearReceipt 		: function(){
	    	var next_inv_id = kendo.parseInt(this.get("next_inv_id"))+1;
	    	this.set("next_inv_id", next_inv_id);	    	
	    	this.set("last_receipt_no", this.get("number"));

	    	this.set("so_id", 0);
			this.set("estimate_id", 0);
			this.set("gdn_id", 0);			
	    	
			this.set("receiptItemList", []);

			this.set("memo", "");
			this.set("sub_total", kendo.toString(0,"c0"));
			this.set("vat_id", "");
			this.set("vat",kendo.toString(0,"c0"));	
			this.set("total", kendo.toString(0,"c0"));
			
			//Remove invoice DS
			$.each(banhji.ds.invoice, function(index, data) {					
	  			banhji.ds.invoice.remove(data);
			});			

			//Remove journal DS
			$.each(banhji.ds.journal, function(index, data) {				
	  			banhji.ds.journal.remove(data);
			});

			this.pageLoad();
	    }
	});
	kendo.bind($("#example"), banhji.vm.receipt);

	$(function() {		
	    banhji.vm.receipt.pageLoad();
	});

</script>