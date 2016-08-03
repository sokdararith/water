<div class="container">
	<div class="row">
		<div class="span12">
			<?php $this->load->view('vendor/toolbar_view'); ?>
		</div>
		<div class="span12">
			<div id="application"></div>
		</div>
	</div>
	
</div>
<script type="text/x-kendo-template" id="appIndex">
	<div class="row">
		<div id="list" class="span3"></div>
		<div id="detail" class="span9"></div>
		<div id="show"></div>
	</div>	
</script>
<script id="vendorList" type="text/x-kendo-template">
	<table class="table table-hover">
		<tbody id="vendors" data-bind="source: vendorList" data-role="listview" data-template="vendorIndex"></tbody>
	</table>
	<div data-role="pager" data-bind="source: vendorList" data-info="false"></div>
</script>
<script id="vendorIndex" type="text/x-kendo-template">
	<tr>
		<td>
			<a href="\\#/vendor/#:id#" class="vendorlist"><span data-bind="text: name"></span></a>
		</td>
	</tr>
</script>
<script id="content" type="text/x-kendo-template">
	<div id="info"></div>
</script>
<script id="billList" type="text/x-kendo-template">
	<div class="navbar">
		<div class="navbar-inner">
			<p class="navbar-text">Bills Payment vendor: <span data-bind="text: vendor.name"></span></p>
		</div>
	</div>
	<div class="row">
		<div class="span4">
			<label for="date">Payment Date:</label>
			<input type="text" data-role="datepicker" data-bind="value: date" data-format="{0:dd-MM-yyyy}" placeholder="dd-mm-yyyy">
			<label for="payment_method">Payment Method:</label>
			<input type="radio" name="payment_method" value="cash" data-bind="click: payChecked, checked: pmtMethods"> Cash
			<input type="radio" name="payment_method" value="check" data-bind="click: payChecked, checked: pmtMethods"> Check
			<label for="cashAccount">Cash Account:</label>
			<input type="text" name="cashAccount" data-role="dropdownlist" data-bind="source: cashAccounts, value: creditAC" data-autoBind="false" data-text-field="name" data-value-field="id">
			<label for="checkNo" data-bind="visible: showCheck">Check No.:</label>
			<input type="text" name="checkNo" data-bind="visible: showCheck, value: checkNo" style="width: 160px;">
		</div>
		<div class="span1"></div>
		<div class="span4">
			<span data-bind="text: checkNo"></span>
			<h2 style="text-align: right"><span data-bind="text: totalAmount"></span></h2>
			<label for="payment_note">Note:</label>
			<textarea data-bind="value: payment_note" style="width: 95%"></textarea>
		</div>
	</div>
	<hr>
	<table class="table table-condensed table-hover" id="billingList">
		<thead>
			<tr>
				<th><i class="icon-ok"></i></th>
				<th width="100">Date</th>
				<th>Type</th>
				<th>Amount Billed</th>
				<th>Amount Due</th>
				<th width="110">Amount Pay</th>
			</tr>
		</thead>
		<tbody data-role="listview" data-bind="source:bills" data-template="billGrid" data-auto-bind="false"></tbody>
	</table>
	<button class="btn" data-bind="click: pay_bill, enabled: payBtn">Paybill</button>
</script>
<script id="billTemplate" type="text/x-kendo-template">
	# var usage = new_reading - prev_reading #
	# var amount = (usage*multiplier) * tariff #
	<tr>
		<td>
			<span data-bind="text: transformer.transformer_number"></span>
		</td>
		<td>
			<span data-bind="text: new_reading"></span>
		</td>
		<td>
			<span data-bind="text: prev_reading"></span>
		</td>
		<td>
			#: usage #
		</td>
		<td>
			<span data-bind="text: multiplier"></span>
		</td>
		<td>
			<span data-bind="text: tariff"></span>
		</td>
		<td>
			#: amount #
		</td>
	</tr>
</script>
<script id="billGrid" type="text/x-kendo-template">
	# if(bills.data().length > 0) { #
		<tr data-id="#=id#">
			<td><input type="checkbox" name="bill-#=id#" class="checkBox" data-id="#=id#" onClick="chkPay(this);"></td>
			<td>
				<span data-bind="text: date" data-format="{dd-MM-yyyy}"></span>
			</td>
			<td>
				<span data-bind="text: bill_type"></span>
			</td>
			<td>
				#=kendo.toString(amount_billed, "c")#
			</td>
			<td>
				#=kendo.toString(amount_due, "c")#
			</td>
			<td>
				<input type="text" data-bind="value: amount_pay"  class="amount" style="width: 100px; margin-bottom: 0;" onChange="amountChange(this);">
			</td>	
		</tr>
	# } else { #
		<tr>
			<td colspan="7">You have not bill for this customer. Create <a href="<?php echo base_url();?>accounting/electricity_bill/vendor/">bill</span></a></td>
		</tr>
	# } #
</script>

<script>
    var totalPaid = 0;
	var vendorDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/people_api/vendors/",
				type: "GET",
				dataType: "json"
			},
			parameterMap : function(options, operation) {
				if( operation !== "read" && options.models ) {
					return { models: kendo.stringigy(options.models) };
				}
				return options;
			}
		},
		pageSize: 30,
		schema: {
			model: {
				id: "id"
			}
		}
	});

	var journalDS = new kendo.data.DataSource({
		transport: {
			create: {
				url: ARNY.baseUrl + "api/accounting_api/add_journal/",
				type: "POST",
				dataType: "json"
			},
			parameterMap : function(options, operation) {
				if( operation !== "read" && options.models ) {
					return { models: kendo.stringigy(options.models) };
				}
				return options;
			}
		},
		schema: {
			model: {
				id: "id"
			}
		}
	});
	//Get Cash Account DataSource
    var CashAccountDataSource = new kendo.data.DataSource({
	    transport: {
		    read: ARNY.baseUrl + "api/accounting_api/cash_account",
		    type: "GET",
		    dataType: "json"
	    }
    });

	var bills = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricities/bills/",
				type: "GET",
				dataType: "json"
			},
			create: {
				url: ARNY.baseUrl + "api/electricities/bills/",
				type: "POST",
				dataType: "json"
			},
			update: {
				url: ARNY.baseUrl + "api/electricities/bills/",
				type: "PUT",
				dataType: "json"
			},
			destroy: {
				url: ARNY.baseUrl + "api/electricities/bills/",
				type: "DELETE",
				dataType: "json"
			},
			parameterMap : function(options, operation) {
				if( operation !== "read" && options.models ) {
					return { models: kendo.stringigy(options.models) };
				}
				if( operation === "read") {
					return { vendor_id : billModel.get("vendor").id, status: 0 };
				}
				return options;
			}
		},
		schema: {
			model: {
				id: "id"
			}
		},
		//serverFiltering: true,
		requestEnd: function(e) {
			var type = e.type;
			
			if(type==="create") {
				billModel.set("billID", e.response.id)
			}
		},
		error	: function(e) {
			console.log(e.status);
		}

	});
	var billPayments = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricities/bill_payments/",
				type: "GET",
				dataType: "json"
			},
			create: {
				url: ARNY.baseUrl + "api/electricities/bill_payments/",
				type: "POST",
				dataType: "json"
			},
			update: {
				url: ARNY.baseUrl + "api/electricities/bill_payments/",
				type: "PUT",
				dataType: "json"
			},
			destroy: {
				url: ARNY.baseUrl + "api/electricities/bill_payments/",
				type: "DELETE",
				dataType: "json"
			},
			parameterMap : function(options, operation) {
				if( operation !== "read" && options.models ) {
					return { models: kendo.stringigy(options.models) };
				}
				return options;
			}
		},
		schema: {
			model: {
				id: "id"
			}
		},
		requestEnd: function(e){
			if(e.type === "create") {
				router.navigate("/");
			}
		}
		//serverFiltering: true,
	});
	var vendorModel	= kendo.observable({
		vendorList 	: vendorDS,
		bills 		: billModel,
	});
	var billModel	= kendo.observable({
		setVendor 		: function(vendorID) {
			this.set("vendor", vendorDS.get(vendorID));
		},
		bills 			: bills,
		cashAccounts 	: CashAccountDataSource,
		payments		: [],
		pmtMethods 		: "cash",
		date 			: new Date(),
		payment_note	: "",
		payBtn 			: false,
		creditAC 		: 1,
		showCheck 		: false,
		payChecked     	: function() {
			if(this.get("pmtMethods")=="check") {
				this.set("showCheck", true);
			} else {
				this.set("showCheck", false);
			}
		},
		checkNo 		: "",
		ref 			: "from pay bill page.",
		total 			: function() {
			return this.get("payments").length;
		},
		totalAmount		: function() {
			var total = 0;
			if(this.get("payments").length > 0) {
				for(var i=0; i<this.get("payments").length; i++) {
					total = parseFloat(total) + parseFloat(this.get("payments")[i].amount_paid);
				}
				totalPaid = total;
			}
			return kendo.toString(total, "c");
		},
		employee 		: <?php echo $this->session->userdata('user_id'); ?>,
		showDetail  : function(e) {
			if(e.type == 'dblclick') {
				alert("show detial");
			}
			
		},
		pay_bill	: function() {
			var data = bills.data();
			if(this.get("payments").length > 0) {	
				billPayments.add(this.get("payments"));
				billPayments.sync();

				journalDS.add(
			 	{
			 		account_id: this.get("creditAC"), 
			 		dr: 0, 
			 		cr: totalPaid, 
			 		memo: this.get('payment_note'), 
			 		voucher: this.get('ref'),
			 		people_id: 4, 
			 		check_no: this.get('checkNo'),
			 		date: kendo.toString(this.get("date"), "yyyy-MM-dd"), 
			 		transaction_type: "pmtbill"
		 		});
				journalDS.add({
			 		account_id: 9, 
			 		dr: totalPaid, 
			 		cr: 0, 
			 		memo: this.get('payment_note'), 
			 		voucher: this.get('ref'),
			 		people_id: 4,
			 		check_no: this.get('checkNo'),
			 		date: kendo.toString(this.get("date"), "yyyy-MM-dd"), 
			 		transaction_type: "pmtbill"
				 });
				journalDS.sync();
				totalPaid = 0;
			}	
		},
	});


	//view/layout
	var layout 		= new kendo.Layout("#appIndex");
	var vendors 	= new kendo.View("#vendorList", {model: vendorModel});
	var content 	= new kendo.View("#content");
	var billList 	= new kendo.View("#billList", {model: billModel});
	var enterBill 	= new kendo.View("#enterBill", {model: billModel});

	
	//route
	var router = new kendo.Router({
		init: function() {
			layout.render("#application");
		}
	});

	router.route("/", function(){
		layout.showIn("#list", vendors);
		layout.showIn("#detail", content);
	});

	router.route("/vendor/:id", function(vendorID) {
		layout.showIn("#detail", billList);
		billModel.setVendor(vendorID);
		bills.read();
		billModel.set("amount_total", 0);
		if(billModel.get("payments").length > 0) {
			for(var i=0; i < billModel.get("payments").length; i++) {
				billModel.get("payments").splice(i, billModel.get("payments").length);
				billPayments.remove(billPayments.at(i));
			}
		}
	});

	router.route("/bill_detail/:id", function(billID) {
		layout.showIn("#detail", billItems);
		itemModel.set("bill_id", billID);
		// vendorModel.set("vendor_id", vendorID);
		itemModel.get("itemList").query({
			filter: [
				{
					value: billID
				}
			]
		});
	});

	router.route("/enterbill", function() {
		layout.showIn("#detail", enterBill);
	});
	function chkPay(e) {
		var index = $(e).closest("tr").index();
		var chkbox= $(e).closest("tr").find('td').find(".amount");
		if($(e).is(":checked")) {
			 var data = bills.data();
			 chkbox.val(data[index].amount_due);
			 var value = chkbox.val();
			 billModel.get("payments").push({
			 	bill_id: data[index].id,
			 	amount_paid: value,
			 	date: kendo.toString(billModel.get("date"),"yyyy-MM-dd"),
			 	payment_note: billModel.get("payment_note")
			 });
			 billModel.set("payBtn", true);
		} else {
			var amount = chkbox.val();
			billModel.get("payments").splice(index, 4);	
			chkbox.val(0);
			billModel.set("payBtn", false);	
		}
	}
	function amountChange(e) {
		var data = bills.data();
		var index = $(e).closest("tr").index();
		var tick = $(e).closest("tr").find('td').find(".checkBox");
		var chkbox= $(e).closest("tr").find('td').find(".amount");
		var value = chkbox.val();

		if(value > 0) {
			if(value > data[index].amount_due) {
				//alert("changed");
				chkbox.val("0");
				billModel.get("payments").splice(index, 4);
				//billModel.set("payBtn", false);
			} else {
				if(billModel.get("payments").length > 0) {
					billModel.get("payments").splice(index, 4);
				 	billModel.get("payments").push({
						bill_id: data[index].id,
					 	amount_paid: value,
					 	date: kendo.toString(billModel.get("date"),"yyyy-MM-dd"),
					 	payment_note: billModel.get("payment_note")
					});
				} else {
				 	billModel.get("payments").push({
						bill_id: data[index].id,
					 	amount_paid: value,
					 	date: kendo.toString(billModel.get("date"),"yyyy-MM-dd"),
					 	payment_note: billModel.get("payment_note")
					});
				}
				if(tick.is(":checked")) {
					tick.attr("checked", "checked");
				} 
				billModel.set("payBtn", true);
			}	
		}
	}
	function dblClick(e) {

	}
	$(function(){
		router.start();
	});
</script>
<style scoped>
	.infoLabel {
		width: 400px;
	}
	.vendorlist {
		display: block;
		
	}
	.vendorlist:hover {
		text-decoration: none;
	}
</style>