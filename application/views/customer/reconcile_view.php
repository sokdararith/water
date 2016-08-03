<div class="row-fluid">    
	<div class="span12">
		
		<div id="example" class="k-content">
			
			<div class="relativeWrap" data-toggle="source-code" style="overflow: visible;">
				<div class="widget widget-tabs widget-tabs-double widget-tabs-vertical row-fluid row-merge widget-tabs-gray">
				
					<!-- Tabs Heading -->
					<div class="widget-head span2">
						<?php $this->load->view('customer/cashierbar'); ?>
					</div>
					<!-- // Tabs Heading END -->
					
					<div class="widget-body span10">
						<div class="tab-content">
						
							<!-- Tab content -->
							<div class="tab-pane active" id="tab1-1">
								<div align="center">
									<h4>របាយការណ៍ផ្ទៀងផ្ទាត់ និង ផ្ទេរសាច់ប្រាក់</h4>
									ថ្ងៃទី
									<span data-bind="text: today"></span>
									<br>
									ដោយ
									<span data-bind="text: cashier_name"></span>
								</div>

								<div data-role="grid" data-bind="source: denominationList" data-editable="true"						
						            data-row-template="denominationRowTemplate"                  
						            data-columns='[	                
						                { title: "ប្រាក់", width: 65 },	                
						                { title: "ចំនួនប្រាក់ដុល្លា" },
						                { title: "ចំនួនប្រាក់រៀល" },	                    	                     
						                { title: "ទឹកប្រាក់ជាដុល្លា" },
						                { title: "ទឹកប្រាក់ជារៀល" },
						                { title: "ចំ.ប្រាក់ដុល្លាផ្ទេរ" },
						                { title: "ចំ.ប្រាក់រៀលផ្ទេរ" },	                    	                     
						                { title: "ប្រាក់ជាដុល្លាផ្ទេរ" },
						                { title: "ប្រាក់ជារៀលផ្ទេរ" }	                    	                    
						                ]'>
								</div>

								<br>

								<div class="row-fluid">
									<!-- Reconcile -->
									<div class="span6">
										<h4 class="heading">ផ្ទៀងផ្ទាត់</h4>

										<table class="table table-condensed">
											<tr>
												<td>ប្រាក់ទទួលបាន</td>
												<td></td>											
												<td align="right"><span class="count" data-bind="text: totalReceive"></span></td>												
											</tr>
											<tr>
												<td>ប្រាក់នៅសល់ពីមុន</td>
												<td></td>											
												<td align="right" style="border-bottom: 1px solid black;"><span class="count" data-bind="text: prevRemain"></span></td>												
											</tr>
											<tr>
												<td>សមតុល្យសាច់ប្រាក់(ក)</td>
												<td></td>												
												<td align="right"><span class="count" data-bind="text: totalCash"></span></td>
											</tr>

											<!-- Reconcile -->
											<tr>
												<td>ប្រាក់ជាដុល្លា</td>
												<td>
													$<span class="count" data-bind="text: totalD"></span> x
													<input data-role="numerictextbox" data-format="c0" data-min="0" data-bind="value: rate"  style="width:70px;">
												</td>
												<td align="right"><span class="count" data-bind="text: totalDtoR"></span></td>												
											</tr>
											<tr>
												<td>ប្រាក់ជារៀល</td>
												<td></td>
												<td align="right" style="border-bottom: 1px solid black;"><span class="count" data-bind="text: totalR"></span></td>												
											</tr>
											<tr>
												<td>សាច់ប្រាក់ទទួលជាក់ស្ដែងសរុប(ខ)</td>
												<td></td>												
												<td align="right"><span class="count" data-bind="text: totalDR"></span></td>
											</tr>
											<tr id="reconcileBalance">
												<td>ផ្ទៀងផ្ទាត់(ក-ខ)</td>
												<td></td>												
												<td align="right"><span class="count" data-bind="text: reconcileBalance"></span></td>
											</tr>																				
										</table>
									</div>

									<!-- Transfer -->
									<div class="span6">
										<div class="heading">
											<h4>
												ផ្ទេរសាច់ប្រាក់
												<span class="btn btn-mini btn-primary btn-icon glyphicons share" data-bind="click: transferAll"><i></i> ផ្ទេរទាំងអស់</span>
											</h4>											
										</div>
										
										<table class="table table-condensed">
											<tr>
												<td>ប្រាក់ផ្ទេរជាដុល្លា</td>
												<td>
													$<span class="count" data-bind="text: totalDT"></span> x
													<input data-role="numerictextbox" data-format="c0" data-min="0" data-bind="value: rate"  style="width:70px;">												
												</td>
												<td align="right"><span class="count" data-bind="text: totalDTtoRT"></span></td>												
											</tr>
											<tr>
												<td>ប្រាក់ផ្ទេរជារៀល</td>
												<td></td>
												<td align="right" style="border-bottom: 1px solid black;"><span class="count" data-bind="text: totalRT"></span></td>												
											</tr>
											<tr>
												<td>ប្រាក់ផ្ទេរសរុប</td>
												<td></td>												
												<td align="right"><span class="count" data-bind="text: totalTransferCash"></span></td>
											</tr>
											<tr>
												<td>សាច់ប្រាក់ចុងគ្រា</td>
												<td></td>												
												<td align="right"><span class="count" data-bind="text: transferBalance"></span></td>
											</tr>
											<tr>
												<td>ផ្ទេរទៅគណនីណាមួយ</td>
												<td>
													<select data-role="combobox" data-text-field="name" data-value-field="id" data-bind="source: accountList, value: transfer_account_id"></select>
												</td>
												<td></td>
											</tr>
										</table>
										
										<div align="right">
											<span class="btn btn-success btn-icon glyphicons hdd" data-bind="click: btnAddReconcile"><i></i>កត់ត្រាផ្ទៀងផ្ទាត់ និង ផ្ទេរសាច់ប្រាក់</span>											
										</div>																			
									</div>									
								</div>
								
							</div>
							<!-- // Tab content END -->

						</div>	
					</div>						
				</div>
			</div>			

		</div> <!--end div example-->            
	</div> <!--End div span12-->		
</div> <!--End div row-fluid -->    

<!-- Denomination row template -->
<script id="denominationRowTemplate" type="text/x-kendo-tmpl">		
	<tr align="right">				
		<td>#:kendo.toString(kendo.parseFloat(denomination), "n0")#</td>
		<td>
			<input data-role="numerictextbox" data-format="n0" data-min="0" style="width:90px;"
				data-bind="value: qty_usd, events: {change : change}" #: denomination>100 ? disabled="disabled" : "" # >
		</td>
		<td>
			<input data-role="numerictextbox" data-format="n0" data-min="0" style="width:90px;"
				data-bind="value: qty_khr, events: {change : change}" #: denomination<100 ? disabled="disabled" : "" # >
		</td>
		<td>$#:kendo.toString(denomination * qty_usd,'n0')#</td>
		<td>#:kendo.toString(denomination * qty_khr,'c0')#</td>

		<td bgcolor="silver">
			<input data-role="numerictextbox" data-format="n0" data-min="0" style="width:90px;"
				data-bind="value: qty_usd_transfer, events: {change : change}" #: denomination>100 ? disabled="disabled" : "" # >
		</td>
		<td bgcolor="silver">
			<input data-role="numerictextbox" data-format="n0" data-min="0" style="width:90px;"
				data-bind="value: qty_khr_transfer, events: {change : change}" #: denomination<100 ? disabled="disabled" : "" # >
		</td>
		<td bgcolor="silver">$#:kendo.toString(denomination * qty_usd_transfer,'n0')#</td>
		<td bgcolor="silver">#:kendo.toString(denomination * qty_khr_transfer,'c0')#</td>					
    </tr>   
</script>

<!-- Scripts -->
<script>
$(document).ready(function() {

var receivePaymentDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/payments/payment",
			type: "GET",
			dataType: "json"
		}
	},		
	schema: {
		model: {
			id: "id"
		}		
	},
	requestEnd: function(e) {
	    var response = e.response;
	    var type = e.type;
	    if(type==='read'){
	    	var total = 0;
	    	for (var i=0; i< response.length; i++) {
	    		total += kendo.parseFloat(response[i].amount_paid);
	    	}
	    	viewModel.set('totalReceive', kendo.toString(total, 'c0'));
	    }
	},		
	serverFiltering: true
});	

var reconcileDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/reconciles/reconcile",
			type: "GET",
			dataType: "json"
		},
		create: {
            url: ARNY.baseUrl + "api/reconciles/reconcile",
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
			id: "id"
		}		
	},
	requestEnd: function(e) {
	    var response = e.response[0];
	    var type = e.type;
	    if(type==='read'){
	    	var totalRemain = response.reconcile_amount - response.transfer_amount;
	    	viewModel.set('prevRemain', kendo.toString(totalRemain, 'c0'));
	    }
	},
	serverPaging: true,
	pageSize: 1,		
	serverFiltering: true
});

var accountDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/accounts/account",
			type: "GET",
			dataType: "json"
		}
	},
	filter:[ 
		{ field: "account_type_id", value: 6 }		
	]
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
	cash_in_till_id 		: 85,	
	transfer_account_id 	: 2,

	today 				: kendo.toString(new Date(), "dd-MM-yyyy"),
		
	cashier 			: <?php echo $this->session->userdata('user_id'); ?>,
	cashier_name 		: "<?php echo $this->session->userdata('username'); ?>",
	
	totalReceive 		: kendo.toString(0, 'c0'),
	prevRemain 			: kendo.toString(0, 'c0'),	
	totalCash 			: function(){
		var tc = kendo.parseFloat(this.get('totalReceive')) + kendo.parseFloat(this.get('prevRemain'));
		return kendo.toString(tc, 'c0');
	},
	reconcileBalance 	: function(){		
		var reBal = kendo.parseFloat(this.totalCash()) - kendo.parseFloat(this.totalDR());				
		if(reBal==0){			
			$("#reconcileBalance").removeClass("alert alert-error");
			$("#reconcileBalance").addClass("alert alert-success");
		}else{
			$("#reconcileBalance").removeClass("alert alert-success");
			$("#reconcileBalance").addClass("alert alert-error");			
		}
		return kendo.toString(reBal,'c0');
	},
	transferBalance 	: function(){
		var tranBal = kendo.parseFloat(this.totalDR()) - kendo.parseFloat(this.totalTransferCash());
		return kendo.toString(tranBal, 'c0');
	},

	rate 				: 4000,

	totalD				: "0.00",	
	totalR				: kendo.toString(0, 'c0'),	
	totalDtoR 			: function(){
		var rate = kendo.parseFloat(this.get("rate"));
		var td = kendo.parseFloat(this.get("totalD"));
		var tdtor = td * rate;
		return kendo.toString(tdtor, 'c0');
	},
	totalDR 	 		: function(){		
		var tdr = kendo.parseFloat(this.totalDtoR()) + kendo.parseFloat(this.get("totalR"));
		return kendo.toString(tdr, 'c0');
	},

	totalDT 			: "0.00",
	totalRT 			: kendo.toString(0, 'c0'),
	totalDTtoRT			: function(){
		var rate = kendo.parseFloat(this.get("rate"));
		var tdt = kendo.parseFloat(this.get("totalDT"));
		var tdttort = tdt * rate;
		return kendo.toString(tdttort, 'c0');
	},
	totalTransferCash 	: function(){		
		var tc = kendo.parseFloat(this.totalDTtoRT()) + kendo.parseFloat(this.get("totalRT"));
		return kendo.toString(tc, 'c0');
	},
		
	accountList 		: accountDS,
	reconcileItemList 	: [],

	denominationList 	: [
		{ 'denomination':1, 'qty_khr':'', 'qty_usd':'', 'qty_khr_transfer':'', 'qty_usd_transfer': '' },
		{ 'denomination':2, 'qty_khr':'', 'qty_usd':'', 'qty_khr_transfer':'', 'qty_usd_transfer': '' },
		{ 'denomination':5, 'qty_khr':'', 'qty_usd':'', 'qty_khr_transfer':'', 'qty_usd_transfer': '' },
		{ 'denomination':10, 'qty_khr':'', 'qty_usd':'', 'qty_khr_transfer':'', 'qty_usd_transfer': '' },
		{ 'denomination':20, 'qty_khr':'', 'qty_usd':'', 'qty_khr_transfer':'', 'qty_usd_transfer': '' },
		{ 'denomination':50, 'qty_khr':'', 'qty_usd':'', 'qty_khr_transfer':'', 'qty_usd_transfer': '' },
		{ 'denomination':100, 'qty_khr':'', 'qty_usd':'', 'qty_khr_transfer':'', 'qty_usd_transfer': '' },
		{ 'denomination':500, 'qty_khr':'', 'qty_usd':'', 'qty_khr_transfer':'', 'qty_usd_transfer': '' },
		{ 'denomination':1000, 'qty_khr':'', 'qty_usd':'', 'qty_khr_transfer':'', 'qty_usd_transfer': '' },
		{ 'denomination':2000, 'qty_khr':'', 'qty_usd':'', 'qty_khr_transfer':'', 'qty_usd_transfer': '' },
		{ 'denomination':5000, 'qty_khr':'', 'qty_usd':'', 'qty_khr_transfer':'', 'qty_usd_transfer': '' },
		{ 'denomination':10000, 'qty_khr':'', 'qty_usd':'', 'qty_khr_transfer':'', 'qty_usd_transfer': '' },
		{ 'denomination':20000, 'qty_khr':'', 'qty_usd':'', 'qty_khr_transfer':'', 'qty_usd_transfer': '' },
		{ 'denomination':50000, 'qty_khr':'', 'qty_usd':'', 'qty_khr_transfer':'', 'qty_usd_transfer': '' },
		{ 'denomination':100000, 'qty_khr':'', 'qty_usd':'', 'qty_khr_transfer':'', 'qty_usd_transfer': '' }
	],

	pageLoad 			: function(){
		var today = this.get("today");

		reconcileDS.filter({
			filters: [
				{ field: "reconciled_date <", value: today },
				{ field: "cashier", value: this.get('cashier') }				
			]
		});

		receivePaymentDS.filter({
			filters: [
				{ field: "payment_date", value: today },
				{ field: "cashier", value: this.get('cashier') }				
			]
		});		

		this.change();
	},
	searchPayment 		: function(){
		var paymentDateFrom = kendo.toString(new Date(this.get("payment_date_from")), "yyyy-MM-dd");		
			
		var paymentDateTo = paymentDateFrom;
		var date = Date.parse(this.get("payment_date_to"));	
		if(isNaN(date)==false){		
			paymentDateTo = kendo.toString(new Date(this.get("payment_date_to")), "yyyy-MM-dd");
		}		
	},
	change				: function(){
		var totalD = 0;
		var totalR = 0;
		var totalDT = 0;
		var totalRT = 0;

		for(var i=0; i < this.denominationList.length; i++){
			var data = this.denominationList[i];
			var dem = kendo.parseFloat(data.denomination);

	    	totalD += kendo.parseFloat(data.qty_usd) * dem;
	    	totalR += kendo.parseFloat(data.qty_khr) * dem;

	    	totalDT += kendo.parseFloat(data.qty_usd_transfer) * dem;
	    	totalRT += kendo.parseFloat(data.qty_khr_transfer) * dem;	    	
		}

		this.set('totalD', kendo.toString(totalD, 'n0'));
		this.set('totalR', kendo.toString(totalR, 'c0'));

		this.set('totalDT', kendo.toString(totalDT, 'n0'));
		this.set('totalRT', kendo.toString(totalRT, 'c0'));		  	 	
	},	
	transferAll 		: function(){
		for(var i=0; i < this.denominationList.length; i++){
			var data = this.denominationList[i];			
			if(data.qty_usd>0){
				data.set('qty_usd_transfer', data.qty_usd);
			}

			if(data.qty_khr>0){
				data.set('qty_khr_transfer', data.qty_khr);
			}	    	   	
		}
		this.change();
	},
	btnAddReconcile 	: function(){
		this.addReconcile();
		this.addJournal();
		this.clearDatasource();
	},
	addReconcile 		: function(){
		for(var i=0; i < this.denominationList.length; i++){
			var data = this.denominationList[i];
						
			if(data.qty_usd>0 || data.qty_khr>0 || data.qty_usd_transfer>0 || data.qty_khr_transfer>0){
				this.reconcileItemList.push({
					'denomination' 		: data.denomination,					
					'qty_usd' 			: data.qty_usd,
					'qty_khr' 			: data.qty_khr,
					'qty_usd_transfer' 	: data.qty_usd_transfer,
					'qty_khr_transfer' 	: data.qty_khr_transfer,
					'reconcile_id'		: 0
				});
			}
				    		    	
		}

		reconcileDS.add({
			cashier 			: this.get('cashier'),					 
			reconciled_date 	: kendo.toString(new Date(), 'yyyy-MM-dd'),					
			rate				: this.get('rate'),
			reconcile_amount	: kendo.parseFloat(this.totalDR()),
			transfer_amount		: kendo.parseFloat(this.totalTransferCash()),
			transfer_account_id : this.get('transfer_account_id'),

			reconcileItems 		: this.get('reconcileItemList')
		});

		reconcileDS.sync();		
	},
	addJournal 			: function(){
		var journalEntries = [];

		//Transfer account on Dr
		journalEntries.push({
	 		account_id 	: this.get("transfer_account_id"),	 		
	 		dr 			: kendo.parseFloat(this.totalTransferCash()), 
	 		cr 			: 0,
	 		class_id  	: 0,
	 		memo 		: ""	 		
		});

		//Cash in till on Cr
		journalEntries.push({
	 		account_id 	: this.get("cash_in_till_id"),	 		
	 		dr 			: 0, 
	 		cr 			: kendo.parseFloat(this.totalTransferCash()),
	 		class_id  	: 0,
	 		memo 		: ""	 		
		});

		//Add journal to datasource
		journalDS.add({	 		
	 		journalEntries : journalEntries,
	 		memo		: "ផ្ទៀងផ្ទាត់ និង ផ្ទេរសាច់ប្រាក់", 
	 		voucher		: "",
	 		class_id	: 0,
	 		budget_id	: 0,
	 		donor_id	: 0,
	 		check_no	: "",
	 		people_id	: 0,
	 		employee_id	: 0,
	 		invoice_id	: 0,
	 		payment_id	: 0,
	 		bill_id		: 0,	
	 		date 		: kendo.toString(new Date(), "yyyy-MM-dd"),
	 		cashier     : this.get("cashier"), 
	 		transaction_type: "Reconcile"	 			 		
	 	});	 	

	  	journalDS.sync();
	},
	clearDatasource 	: function(){    	
		this.set("reconcileItemList", []);

		totalD			: "0.00";	
		totalR			: kendo.toString(0, 'c0');	
		totalDtoR 		: kendo.toString(0, 'c0');
		totalDR 	 	: kendo.toString(0, 'c0');

		totalDT 		: "0.00";
		totalRT 		: kendo.toString(0, 'c0');
		totalDTtoRT		: kendo.toString(0, 'c0');
		totalTransferCash : kendo.toString(0, 'c0');

		//Remove reconcile
		for (var i=0; i< reconcileDS.total(); i++) {
			var di = reconcileDS.at(i);
  			reconcileDS.remove(di);
		}

		//Remove journal
		for (var j=0; j< journalDS.total(); j++) {
			var dj = journalDS.at(j);
  			journalDS.remove(dj);
		}
		
		this.pageLoad();
    }	
});  
kendo.bind($("#example"), viewModel);

viewModel.pageLoad();

}); //End document ready
</script>