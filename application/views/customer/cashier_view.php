<div class="row-fluid">
	<div class="span12">
		
		<div id="example">
			<div class="span3">				
		      	<div class="innerAll">
					<form autocomplete="off" class="form-inline">
						<div class="widget-search separator bottom">
							<button id="btnSearch" type="button" class="btn btn-default pull-right" data-bind="click: customerSearch"><i class="icon-search"></i></button>
							<div class="overflow-hidden">
								<input id="txtSearch" type="text" placeholder="លេខកូដអតិថិជន..." data-bind="value: searchField">
							</div>
						</div>						
					</form>
				</div>							
		      					
				<h5><i class="icon-info-sign"></i> ពត៌មានសង្ខេបអតិថិជន</h5>				
				<table width="100%" style="background-color:#98AFC7;">
					<tr>
						<td colspan="2">
							<i class="icon-user icon-li icon-fixed-width"></i> <span data-bind="text: full"></span>
						</td>						
					</tr>
					<tr>
						<td>
							<i class="icon-group icon-li icon-fixed-width"></i> <span data-bind="text: customer.typeName"></span>
						</td>
						<td>
							<i class="icon-envelope icon-li icon-fixed-width"></i> <span data-bind="text: customer.email"></span>
						</td>
					</tr>
					<tr>
						<td>
							<i class="icon-phone icon-li icon-fixed-width"></i> <span data-bind="text: customer.phone"></span>
						</td>
						<td>
							<i class="icon-refresh icon-li icon-fixed-width"></i> <span data-bind="text: customer.round_settle"></span> ខែម្ដង
						</td>						
					</tr>
					<tr>
						<td>
							<i class="icon-adn icon-li icon-fixed-width"></i> <span data-bind="text: customer.ampere"></span>
						</td>					
						<td>							
							<i class="icon-money icon-li icon-fixed-width"></i> <span data-bind="text: customer.tariff"></span>
						</td>
					</tr>
					<tr>
						<td>							
							<i class="icon-code-fork icon-li icon-fixed-width"></i> <span data-bind="text: customer.phase"></span>
						</td>
						<td>
							<i class="icon-level-down icon-li icon-fixed-width"></i> <span data-bind="text: customer.exemption"></span>
						</td>
					</tr>
					<tr>
						<td>
							<i class="icon-bolt icon-li icon-fixed-width"></i> <span data-bind="text: customer.voltage"></span>
						</td>
						<td>							
							<i class="icon-stethoscope icon-li icon-fixed-width"></i> <span data-bind="text: customer.maintenance"></span>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<i class="icon-home icon-li icon-fixed-width"></i> <span data-bind="text: address"></span>
						</td>						
					</tr>
				</table>

				<br>			
				
				<h5><i class="icon-list"></i> ប្រតិបត្តិការ</h5>
				
				<div id="transactionGrid" data-role="grid" data-bind="source: statementCollectionList"
		            data-row-template="transactionRowTemplate" data-pageable="true" data-auto-bind="false"                  
		            data-columns='[{ title: "កាលបរិច្ឆេទ", width: 80 }, 
		                { title: "ប្រភេទ", width: 80 },	                     
		                { title: "ទឹិកប្រាក់" }	                    
		                ]'>
				</div>
			
			</div> <!-- End span3 -->

			<div class="span9">
				<div class="row-fluid">
					<div class="span4">
						<div class="innerAll padding-bottom-none-phone">
							<a href="#" class="widget-stats widget-stats-gray widget-stats-4"> 
								<span class="txt">អតិថិជន</span>
								<span class="count" data-bind="text: total_customer"></span>
								<span class="glyphicons user"><i></i></span>
								<div class="clearfix"></div>
								<i class="icon-play-circle"></i> 
							</a>
						</div>
					</div>

					<div class="span4">
						<div class="innerAll padding-bottom-none-phone">
							<a href="#" class="widget-stats widget-stats-primary widget-stats-4">
								<span class="txt">បង់ប្រាក់</span>
								<span class="count"><span data-bind="text: total_payment" style="font-size: 35px;"></span></span>
								<span class="glyphicons coins"><i></i></span>
								<div class="clearfix"></div>
								<i class="icon-play-circle"></i>
							</a>
						</div>
					</div>

					<div class="span4">
						<div class="innerAll padding-bottom-none-phone">
							<a href="<?php echo base_url(); ?>customer/daily_payment" class="widget-stats widget-stats-inverse widget-stats-5">
								<span class="glyphicons notes"><i></i></span>
								<span class="txt">របាយការណ៍<span>ផ្ទៀងផ្ទាត់</span></span>
								<div class="clearfix"></div>
							</a>
						</div>
					</div>				

				</div> <!-- End row-fluid -->
				
				<br>

				<div class="pull-right">		          	
		          	<p>
		              	ថ្ងៃទទួលប្រាក់
		              	<input data-role="datepicker" data-bind="value: payment_date" data-format="dd-MM-yyyy" />
		              	<br>
			          	ប្រាក់ត្រូវបង់
		          	</p>		          	

		          	<div align="right">		          		
		          		<span style="color: white; font-size: 30px; background-color:maroon; border:0px solid black; padding: 5px;" data-bind="text: total"></span>		          			          		
		          	</div>		          	
		        </div>

				<div>
					<table>
						<tr>
		                    <td>វីធីបង់ប្រាក់</td>
		                  	<td><select data-role="combobox" data-text-field="name" data-value-field="id" data-bind="source: paymentMethodList, value: payment_method_id"></select></td>
		                <tr>
						<tr>
			                <td>លេខកូដសែក</td>
			                <td><input id="check_no" class="k-textbox" data-bind="value: check_no" /></td>
			            <tr>
			            <tr>
							<td>គណនីសាច់ប្រាក់</td>
							<td><select data-role="combobox" data-text-field="name" data-value-field="id" data-bind="source: accountList, value: deposit_to"></select></td>
						</tr>
					</table>
				</div>
				
				<br><br>

				<div data-role="grid" data-bind="source: invoiceList"
		            data-auto-bind="false" data-row-template="invoiceRowTemplate"                  
		            data-columns='[{ title: "", width: 30 },	                 	
		                { title: "ល.រ", width: 40 },
		                { title: "ថ្ងៃចេញវិក្កយបត្រ" },	                     
		                { title: "ឈ្មោះ" },
		                { title: "# វិក្កយបត្រ" },
		                { title: "ទឹកប្រាក់" },	                    	                     
		                { title: "ទទួលប្រាក់" }	                    	                    
		                ]'>
				</div>
				
				<br>

				<div class="pull-right">
					<table>
						<tr>
							<td>ទឹកប្រាក់ត្រូវបង់:</td>
							<td align="right"><span data-bind="text: total"></span></td>
						</tr>
						<tr>
							<td>បញ្ចុះតំលៃ:</td>
							<td><input data-role="numerictextbox" data-format="c0" data-bind="value: discount, events: {change : change}" /></td>
						</tr>
						<tr>
							<td>ទឹកប្រាក់ពិន័យ:</td>							
							<td><input data-role="numerictextbox" data-format="c0" data-bind="value: fine, events: {change : change}" /></td>
						</tr>
						<tr>
							<td>ទឹកប្រាក់ទទួលបាន:</td>
							<td align="right"><span data-bind="text: pay_amount"></span></td>
						</tr>
						<tr>
							<td>នៅសល់:</td>
							<td align="right"><span data-bind="text: remain"></span></td>
						</tr>
					</table>
				</div>
				
				<div class="span4">
					<div class="innerAll padding-bottom-none-phone">
						<a data-bind="click: addPayment" class="widget-stats widget-stats-info widget-stats-4">
							<span class="txt">ទឹកប្រាក់ទទួលបាន</span>
							<span class="count" style="font-size: 35px;" data-bind="text: pay_amount"></span>
							<span class="glyphicons cart_in"><i></i></span>
							<div class="clearfix"></div>
							<i class="icon-play-circle"></i>
						</a>
					</div>
				</div>				

			</div> <!-- End span9 -->
		</div> <!-- End example -->	

	</div>
</div>	


<!-- Transaction row template -->
<script id="transactionRowTemplate" type="text/x-kendo-tmpl">
    <tr>        
        <td>#:kendo.toString(new Date(issued_date), "dd-MM-yyyy")#</td>
        <td>#:type#</td>
        <td>#:kendo.toString(kendo.parseFloat(amount), 'c0')#</td>        
   	</tr>
</script>

<!-- Invoice row template -->
<script id="invoiceRowTemplate" type="text/x-kendo-tmpl">		
	<tr id="rowGrid-#:id#">
		<td><input type="checkbox" data-bind="checked: isPay" onClick="checkPay(this, #:id#)"></td>
		<td class="sno">1</td>			
		<td>#:kendo.toString(new Date(issued_date), "dd-MM-yyyy")#</td>		
		<td>#:fullname#</td>
		<td>#:number#</td>				
		<td align="right">#:kendo.toString(total, "c0")#</td>
		<td>
			<input data-role="numerictextbox" data-format="c0" data-bind="value: pay_amount, events: {change : change}" style="width: 120px;">
			<i class="icon-trash" data-bind="events: { click: remove "></i>			
		</td>				
    </tr>   
</script>

<!-- Scripts -->
<script>
//DataSource
var customerDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/people_api/customer_search",
			type: "GET",
			dataType: "json"
		}
	},
  	requestEnd: function(e) {
  		var response = e.response;
    	var type = e.type;	    			   
	    if(type==="read" && response.length>0){	    	
	    	viewModel.set("customer", response[0]);		    	
	    	viewModel.loadData();	    	
	    }
  	},		
	schema: {
		model: {
			id: "id"
		}		
	},
	serverPaging: true,
	pageSize: 10,
	serverFiltering: true
});

var statementCollectionDS = new kendo.data.DataSource({
  	transport: {	  
	  	read: {
		  	url : ARNY.baseUrl + "api/invoices/statement_collection",
		  	type: "GET",
		  	dataType: "json"		  
	  	}
  	},
  	sort: { field: "issued_date", dir: "desc" },  	
  	pageSize: 5,
  	serverFiltering: true
});

var paymentMethodDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/payment_methods/payment_method",
			type: "GET",
			dataType: "json"
		}
	}
});

var accountDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/accounts/account",
			type: "GET",
			dataType: "json"
		}
	}
});

var invoiceDS = new kendo.data.DataSource({
  	transport: {
	  	read: {
		  	url : ARNY.baseUrl + "api/invoices/invoice_payment",		  
		  	type: "GET",
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
	    if(type==="read" && response.length>0){
	    	viewModel.set("invoices", response);
	    	viewModel.addInvoiceList();	    	
	    }
  	},  	
  	serverFiltering: true
});

var paymentDS = new kendo.data.DataSource({
  	transport: {  		
	  	create: {
		  	url : ARNY.baseUrl + "api/payments/payment_batch",		  
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
  	},
  	requestEnd: function(e) {
  		var response = e.response;
    	var type = e.type;	    			   
	    if(type==="create"){	    	
	    	viewModel.clearPayment();
	    	viewModel.clearDatasource();
	    	payment_for_cashier();  	
	    }
  	}
});
	
//View model
var viewModel = kendo.observable({
	//Account id
	cash_id 				: 2,
	account_receiveable_id 	: 3,

	customer_url		: ARNY.baseUrl + "uploads/logo/customer_icon.gif",
	riel_url			: ARNY.baseUrl + "uploads/logo/riel.jpg",

	total_customer 		: 0,
	total_payment 		: kendo.toString(0,"c0"),	

	//Payment
	discount 			: 0,
	fine 				: 0,
	payment_date		: new Date(),
	payment_method_id	: 1,
	check_no			: "",
	deposit_to			: 2,
	payment_note		: "",
	cashier				: <?php echo $this->session->userdata('user_id'); ?>,	
	
	//Others
	customer 			: null,
	invoices 			: null,		
	pay_amount  		: kendo.toString(0,"c0"),
	remain				: kendo.toString(0,"c0"),
		
	total 				: kendo.toString(0,"c0"),
	
	paymentMethodList 	: paymentMethodDS,
	accountList 		: accountDS,

	statementCollectionList: statementCollectionDS,
	invoiceList 		: [],
	paymentList 		: [],
	customerBalanceList	: [],

	//Searcher
	searchField 			: "",
	customerSearch 		: function(e){
		if(this.get("searchField") !== "") {
			var txtSearch = this.get("searchField");						
			customerDS.filter({ field: "searchField", value: txtSearch });			
			this.set("searchField", "");
			//$('#btnPay').focus();		 			
		}
	},	
	loadData 	 		: function(){
		var cus = this.get("customer");
		var full = cus.number + ' ' + cus.fullname;
		this.set("full", full);

		var address = cus.house_no + ' ' + cus.street_no;
		this.set("address", address);

		statementCollectionDS.filter({ field: "customer_id", value: cus.id });
		invoiceDS.filter({
			filters: [
				{ field: "customer_id", value: cus.id },				
				{ field: "status", value: 0 }				
			]
		});	
	},	
	addInvoiceList 		: function(){		
    	var total = kendo.parseFloat(this.get("total"));
    	var tpay = kendo.parseFloat(this.get("pay_amount"));
    	var invs = this.get("invoices");
    	var fullname = this.get("customer").surname + " " + this.get("customer").name;
    	
		for (var i=0; i< invs.length; i++) {
		    var data = invs[i];
		    
    		var isExisting = false;    		
    		for (var j=0;j<this.invoiceList.length;j++) {
    			var dj = this.invoiceList[j];
    			if(data.id==dj.id){
    				isExisting = true;
    				break;
    			}
    		}

    		if(isExisting==false){
    			total += parseFloat(data.total);
    			tpay += parseFloat(data.total);
    			
				this.invoiceList.push({				
					id 				: data.id,
					isPay 			: true,				
					issued_date 		: data.issued_date,
					fullname 		: fullname,
					number			: data.number,				
					total 			: data.total,
					pay_amount 		: data.total,
					customer_id 	: this.get("customer").id,
					balance 		: this.get("customer").balance 
				});

				if(i>0){
					$("#rowGrid-"+data.id).addClass("alert alert-error");
				}
			}
		}
		var remain = total - tpay;
		    	
    	this.set("pay_amount", kendo.toString(tpay, "c0"));    	
    	this.set("total", kendo.toString(total, "c0"));
    	this.set("remain", kendo.toString(remain,"c0"));
    	
    	this.autoIncreaseNo();
	},
	autoIncreaseNo 		: function(){
		$(".sno").each(function(index,element){                 
		   $(element).text(index + 1); 
		});
	},
	change				: function(){		
		var total = 0;		
	    var tpay = 0;	    
		for(var i=0; i < this.invoiceList.length; i++){
			var data = this.invoiceList[i];
			total += kendo.parseFloat(data.total);
	    	tpay += kendo.parseFloat(data.pay_amount);	
		}
		this.set("total", kendo.toString(total, "c0"));    	   	    	
    	this.set("pay_amount", kendo.toString(tpay, "c0"));
    	var remain = (total + kendo.parseFloat(this.get("fine"))) - (tpay + kendo.parseFloat(this.get("discount")));
    	this.set("remain", kendo.toString(remain, "c0"));

    	this.autoIncreaseNo();    	
	},	
	remove 				: function(e){
		if (confirm("តើលោកអ្នកពិតជាចង់លុបមែនឬទេ?")) {        
	        var item = e.data;
	        var index = this.get("invoiceList").indexOf(item);        
	        this.get("invoiceList").splice(index, 1);
	        this.change();
    	}
    },
	addPayment 	 		: function(){
		if(kendo.parseFloat(this.get("pay_amount"))>0){				
			var ids = new Array();
			var arr = new Array();

			for (var i=0; i<this.invoiceList.length; i++){
				var data = this.invoiceList[i];
				
				if(data.pay_amount > 0){				
					if(data.pay_amount >= data.total){
						ids.push(data.id);
					}
											
					//Add new invoice payment
					this.paymentList.push({
						invoice_id 			: data.id,								
						amount_paid 		: data.pay_amount,
						discount 			: 0,
						fine 				: 0,			
						payment_date		: kendo.toString(this.get("payment_date"), "yyyy-MM-dd"),
						payment_method_id	: this.get("payment_method_id"),
						check_no 			: this.get("check_no"),							  	  
						deposit_to 			: this.get("deposit_to"),
						payment_note		: this.get("payment_note"),
						cashier				: this.get("cashier"),
						customer_id			: data.customer_id													
					});

					//Add new customer balances to []
					var balance = 0;										
					var index = jQuery.inArray(data.customer_id, arr);					
					if(index > -1){ //If a customer has two invoices											
						balance = kendo.parseFloat(this.customerBalanceList[index].balance) - kendo.parseFloat(data.pay_amount);
						this.customerBalanceList[index].set("balance", balance);
					}else{
						arr.push(data.customer_id);
						balance = kendo.parseFloat(data.balance) - kendo.parseFloat(data.pay_amount);
						this.customerBalanceList.push({
							id			: kendo.parseInt(data.customer_id),
							balance 	: balance
						});	
					}
					

				}		
			}

			//Add payments to database
			if(this.get("paymentList").length>0){
				paymentDS.add(this.get("paymentList"));
				paymentDS.sync();

				this.updateCustomerBalance();
				this.addJournal();
												
				$(".status").text("").removeClass("alert alert-error");
				$(".status").text("កត់ត្រាបានសំរេច").addClass("alert alert-success");
			}		
			
			//Update invoice status
			if(ids.length>0){
				$.ajax({
					type: "PUT",
					url: ARNY.baseUrl + "api/invoices/invoice_batch",				
					data: {ids: kendo.stringify(ids)},
					dataType: "json",
					success: function (response) {
						//var data = response.d;			  
					}
				});
			}			
		}else{
			alert("ពុំមានការបង់ប្រាក់ទេ");
		}		
	},
	addJournal 			: function(){				
		var journalEntries = [];
					
		//Add new journal to database	
		for (var i=0;i<2;i++){
			var acct_id = 0;
			var dr = 0;
			var cr = 0;

			if(i==0){
				acct_id = this.get("cash_id");
				dr = kendo.parseFloat(this.get("pay_amount"));
			}else{
				acct_id = this.get("account_receiveable_id");
				cr = kendo.parseFloat(this.get("pay_amount"));
			}
			
			journalEntries.push({
		 		account_id 	: acct_id,	 		
		 		dr 			: dr, 
		 		cr 			: cr,
		 		class_id  	: 0,
		 		memo 		: ""	 		
			});		
		}

		journalDS.add({	 		
	 		journalEntries : journalEntries,
	 		memo: "ចំណូលពី​ការលក់អគ្គីសនី", 
	 		voucher: "",
	 		class_id: 0,
	 		budget_id: 0,
	 		donor_id: 0,
	 		check_no: "",
	 		people_id: 0,
	 		employee_id: <?php echo $this->session->userdata('user_id'); ?>,
	 		invoice_id: 0,
	 		payment_id: 0,
	 		bill_id: 0,	
	 		date: kendo.toString(this.get("payment_date"), "yyyy-MM-dd"), 
	 		transaction_type: "Payment"	 			 		
	 	});	 	

	 	journalDS.sync();	 	
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
	clearPayment 		: function(){		
		this.set("check_no", "");				
		this.set("total", kendo.toString(0,"c0"));
		this.set("discount", 0);
		this.set("fine", 0);		
		this.set("pay_amount", kendo.toString(0,"c0"));
		this.set("remain", kendo.toString(0,"c0"));		
	},
	clearDatasource 	: function() {
		this.set("invoiceList", []);
		this.set("paymentList", []);
		this.set("customerBalanceList", []);

		//Remove payment
		for (var i=0; i< paymentDS.total(); i++) {
			var dataItem = paymentDS.at(i);
  			paymentDS.remove(dataItem);
		}

		//Remove journal
		for (var j=0; j< journalDS.total(); j++) {
			var dataItem = journalDS.at(j);
  			journalDS.remove(dataItem);
		}
	}
});  
kendo.bind($("#example"), viewModel);

$("#txtSearch").keypress(function(e) {			
	var keycode = e.keyCode ? e.keyCode : e.which;	
   	if(keycode === 13) {
   		e.preventDefault();
   		viewModel.set("searchField", $(this).val());    
    	viewModel.customerSearch();
    }          
});

//Check to pay
function checkPay(e, id){	
	for (var i=0; i< viewModel.invoiceList.length; i++) {
		var data = viewModel.invoiceList[i];
		if(data.id==id){
			if($(e).is(":checked")) {
		 		data.set("pay_amount", data.total);
		 	}else{
		 		data.set("pay_amount", 0);
			}
			break;
		}	
	}
	viewModel.change();		
}

//Payment for cashier
function payment_for_cashier(){
	var d = new Date();
	$.ajax({
		type: "GET",
		url: ARNY.baseUrl + "api/payments/payment_for_cashier",				
		data: {cashier: viewModel.get("cashier"), payment_date: kendo.toString(d, "yyyy-MM-dd")},
		dataType: "json",
		success: function (response) {
			viewModel.set("total_customer", kendo.toString(kendo.parseInt(response.total_customer), '##,#'));
			viewModel.set("total_payment", kendo.toString(kendo.parseFloat(response.total_payment), 'c0'));
		}
	});
}

$(function(){
	$('#txtSearch').focus();
	payment_for_cashier();
});		

</script>


