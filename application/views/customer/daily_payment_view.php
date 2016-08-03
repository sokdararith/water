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
								<div>
									<input data-role="datepicker" data-bind="value: payment_date_from" data-format="dd-MM-yyyy" placeHolder="ចាប់ពី" />
									<input data-role="datepicker" data-bind="value: payment_date_to" data-format="dd-MM-yyyy" placeHolder="ដល់" />
									<button type="button" class="btn btn-default" data-bind="click: searchPayment"><i class="icon-search"></i></button>
								</div>

								<div align="center">
									<h4>របាយការណ៍ទទួលប្រាក់</h4>
									ថ្ងៃទី
									<span data-bind="text: payment_date_from_str"></span>																	
									<span data-bind="text: payment_date_to_str"></span>
									<br>									
									ដោយ
									<span data-bind="text: cashier_name"></span>									
								</div>

								<br>

								<div data-role="grid" data-bind="source: paymentList"
									data-pageable="true"
						            data-auto-bind="false" data-row-template="paymentRowTemplate"                  
						            data-columns='[	                
						                { title: "ថ្ងៃបង់ប្រាក់" },	                     
						                { title: "លេខកូដ" },
						                { title: "ឈ្មោះ" },						                
						                { title: "លេខវិក្កយបត្រ" },
						                { title: "ទឹកប្រាក់" },	                    	                     
						                { title: "ប្រាក់ទទួលបាន" }	                    	                    
						                ]'>
								</div>

								<br>
			
								<div class="row-fluid">				
									<div class="span4 offset8">
										<div class="innerAll padding-bottom-none-phone">
											<a href="#" class="widget-stats widget-stats-primary widget-stats-4">
												<span class="txt">សរុប</span>
												<span class="count"><span data-bind="text: totalPaid" style="font-size: 35px;"></span></span>
												<span class="glyphicons coins"><i></i></span>
												<div class="clearfix"></div>
												<i class="icon-play-circle"></i>
											</a>
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

<!-- Payment row template -->
<script id="paymentRowTemplate" type="text/x-kendo-tmpl">		
	<tr>					
		<td>#:kendo.toString(new Date(payment_date), "dd-MM-yyyy")#</td>
		<td>#:customers.number#</td>		
		<td>#:customers.surname# #:customers.name#</td>		
		<td>#:invoices.number#</td>				
		<td align="right">#:kendo.toString(kendo.parseFloat(total_amount), "c0")#</td>
		<td align="right">#:kendo.toString(kendo.parseFloat(amount_paid), "c0")#</td>				
    </tr>   
</script>

<!-- Scripts -->
<script>
$(document).ready(function() {

var paymentDS = new kendo.data.DataSource({
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
	    	viewModel.set('totalPaid', kendo.toString(total, 'c0'));
	    }
	},
	pageSize: 50,	
	serverFiltering: true
});

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
	payment_date_from	: new Date(),
	payment_date_to  	: "",

	payment_date_from_str	: function(){
		var strDate = "";
		var date = Date.parse(this.get("payment_date_from"));		
		if(isNaN(date)==false){		
			strDate = kendo.toString(this.get("payment_date_from"), "dd-MM-yyyy");
		}	
		return strDate;	
	},
	payment_date_to_str  	: function(){
		var strDate = "";
		var date = Date.parse(this.get("payment_date_to"));		
		if(isNaN(date)==false){		
			strDate = " ដល់ " + kendo.toString(this.get("payment_date_to"), "dd-MM-yyyy");
		}	
		return strDate;	
	},
	cashier 			: <?php echo $this->session->userdata('user_id'); ?>,
	cashier_name 		: "<?php echo $this->session->userdata('username'); ?>",
	totalPaid			: kendo.toString(0, 'c0'),			
	
	paymentList 		: paymentDS,
		
	searchPayment 		: function(){
		var paymentDateFrom = kendo.toString(new Date(this.get("payment_date_from")), "yyyy-MM-dd");		
			
		var paymentDateTo = paymentDateFrom;
		var date = Date.parse(this.get("payment_date_to"));	
		if(isNaN(date)==false){		
			paymentDateTo = kendo.toString(new Date(this.get("payment_date_to")), "yyyy-MM-dd");
		}

		paymentDS.filter({
			filters: [
				{ field: "payment_date >=", value: paymentDateFrom },
				{ field: "payment_date <=", value: paymentDateTo },
				{ field: "cashier", value: this.get('cashier') }				
			]
		});
	}	
});  
kendo.bind($("#example"), viewModel);

}); //End document ready
</script>