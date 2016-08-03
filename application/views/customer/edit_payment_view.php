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
								<input id="invoiceNo" type="text" data-bind="value: invoiceNo" placeholder="លេខវិក្កយបត្រ" > 
								<button id="btnSearch" type="button" class="btn btn-default" data-bind="click: search"><i class="icon-search"></i></button>

								<br>

								<table>
									<tr>
										<td>ឈ្មោះ</td>
										<td><span data-bind="text: fullname"></span></td>
									<tr>
									</tr>
										<td>លេខវិក្កយបត្រ</td>
										<td><span data-bind="text: invoice_no"></span></td>
									<tr>
									</tr>
										<td>ទឹកប្រាក់</td>
										<td><span data-bind="text: amount"></span></td>
									</tr>
								</table>

								<br>

								<div id="grid"></div>

								<div class="span2 pull-right">
									<a href="#" class="widget-stats widget-stats-info widget-stats-5" data-bind="click: saveEdit">
										<span class="glyphicons edit"><i></i></span>
										<span class="txt"><span>កែប្រែ</span></span>
										<div class="clearfix"></div>
									</a>
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


<script>
$(document).ready(function() {		
//Datasource
var invoiceDS = new kendo.data.DataSource({
	transport: {
		read: {
			url : ARNY.baseUrl + "api/invoices/invoice_info",
			type: "GET",
			dataType: "json"
		},
		update: {
			url : ARNY.baseUrl + "api/invoices/invoice",
			type: "PUT",
			dataType: "json"
		}
	},
	requestEnd: function(e) {
	    var response = e.response;
	    var type = e.type;
	    if(type==='read' && response.length>0){
	    	var d = response[0];
	    	var fullname = d.customers.surname +' '+ d.customers.name;
	    	var amt = kendo.toString(kendo.parseFloat(d.total_amount), 'c0');

	    	viewModel.set("invoice_id", d.id);
	    	viewModel.set("fullname", fullname);
	    	viewModel.set("invoice_no", d.number);
	    	viewModel.set("amount", amt);

	    	paymentDS.filter({ field: "customer_id", value: d.id });
	    }
	},
	serverFiltering: true	
});

var paymentDS = new kendo.data.DataSource({
	transport: {
		read: {
			url : ARNY.baseUrl + "api/payments/payment_for_edit",
			type: "GET",
			dataType: "json"
		},		
		update: {
			url : ARNY.baseUrl + "api/payments/payment",
			type: "PUT",
			dataType: "json"
		},
		destroy: {
			url : ARNY.baseUrl + "api/payments/payment",
			type: "DELETE",
			dataType: "json"
		},
		parameterMap : function(options, operation) {			
			if (operation != "read") {
                var d = new Date(options.payment_date);
                options.payment_date = kendo.toString(d, "yyyy-MM-dd");
                return options;
            }
            else { return options; }					
		}
	},		
	schema: {
		model: {
			id: "id",
            fields: {
                id      		: { editable: false, nullable: true },                
                amount_paid 	: { type: "number", validation: { required: true } },
                discount 		: { type: "number", validation: { required: true } },
                fine 			: { type: "number", validation: { required: true } },
                payment_date 	: { type: "date", validation: { required: true } }
            }
		}
	},
	serverFiltering: true
});

//Grid
$("#grid").kendoGrid({		
	dataSource: paymentDS,
	autoBind: false,		
	columns: [			
		{ field: "payment_date", title: "កាលបរិច្ឆេទ", format:"{0:dd-MM-yyyy}" },
		{ field: "amount_paid", title: "ទឹកប្រាក់", format:"{0:c0}" },
		{ field: "discount", title: "បញ្ចុះតំលៃ", format:"{0:c0}" },
		{ field: "fine", title: "ពិន័យ", format:"{0:c0}" },
		{ command: ["destroy"], title: "&nbsp;", width: "200px" }
	],
	editable: true
});

//View model
var viewModel = kendo.observable({
	invoiceNo 	: "",
	invoice_id  : 0,
	fullname 	: "",
	amount 		: "",

	search 		: function(){
		var invoiceNo = this.get("invoiceNo");
		invoiceDS.filter({ field: "number", value: invoiceNo });
	},
	saveEdit 		: function(){		
		var amount = this.get("amount");
		var totalPaid = 0;
		for (var i=0;i<paymentDS.total();i++) {
			var d = paymentDS.at(i);
			totalPaid += d.amount_paid;
		}

		if(totalPaid==0){
			this.updateInvoice(0);
		}

		if(totalPaid>=amount){
			this.updateInvoice(1);
		}
		paymentDS.sync();
	},
	updateInvoice : function(status){
		var id = this.get("invoice_id");
		var inv = invoiceDS.get(id);
		inv.set("status", status);

		invoiceDS.sync();		
	}
});  
kendo.bind($("#example"), viewModel);
	
});
</script>