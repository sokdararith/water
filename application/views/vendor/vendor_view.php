<div class="widget widget-heading-simple widget-body-white widget-employees">
		<div class="widget-body padding-none">	
			<div class="row-fluid row-merge">
				<div class="span3 listWrapper" style="height: 630px;">
					<div class="innerAll">
						<form autocomplete="off" class="form-inline">
							<div class="widget-search separator bottom">
								<button type="button" class="btn btn-default pull-right" id="search"><i class="icon-search"></i></button>
								<div class="overflow-hidden">
									<input type="search" value="" placeholder="ស្វែងរក" id="searchField">
								</div>
							</div>
							<div class="select2-container" style="width: 100%;">
								<div class="overflow-hidden">
									<select name="" id="searchOptions" style="width: 100%;" tabindex="-1">
						                <option value="surname">នាមត្រកូល</option>
						                <option value="name">ឈ្មោះ</option>
						                <option value="company">ក្រុមហ៊ុន</option>
						                <option value="phone">ទូរស័ព្ទ</option>
						                <option value="customer_no">ID</option>
									</select>
								</div>
							</div>
						</form>
					</div>
					<div id="vendorList" class="table table-white table-bordered"></div>
				</div>

				<div class="span9 detailsWrapper">
					<div class="innerAll">
						<div id="application"></div>
						<div id="window"></div>
					</div>
				</div>
			</div>	
		</div>
</div>
<script id="vendorListTmpl" type="text/x-kendo-template">
	<tr data-id="#id#">
		<td>
			<div class="media-body">
				<span class="strong">#=surname# #=name#</span>
			</div>
		</td>
	</tr>
</script>
<script id="appIndex" type="text/x-kendo-template">
	<div id="content"></div>
</script>
<script id="vendor" type="text/x-kendo-template">
	<div class="row-fluid">
		<div class="widget widget-heading-simple widget-body-simple">
			<div class="widget-body">
				<div class="span4">
					<a href="" class="widget-stats widget-stats-gray widget-stats-2">
						<span class="count">20</span>
						<span class="txt">Open Bills</span>
					</a>
				</div>
				<div class="span4">
					<a href="" class="widget-stats widget-stats-gray widget-stats-2">
						<span class="count">20</span>
						<span class="txt">Over Due Bills</span>
					</a>
				</div>
				<div class="span4">
					<a href="" class="widget-stats widget-stats-gray widget-stats-2">
						<span class="count">20</span>
						<span class="txt">Paid last 30 days</span>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="navbar">
		<div class="navbar-inner">
			<ul class="nav">
				<li class="active"><a href="#" data-bind="click: showHome" id="home">ព័តមាន</a></li>
				<li><a href="#" data-bind="click: showInfo" id="eBill">ទិញអគ្គីសនី</a></li>
				<li><a href="#" data-bind="click: showInfo" id="purchase">ទិញសន្និធិ</a></li>
				<li><a href="#" data-bind="click: showInfo" id="expense">ចំណាយ</a></li>
				<li><a href="#" data-bind="click: showInfo" id="payment">ទូទាត់បំណុល</a></li>
				<li><a href="#" data-bind="click: showInfo" id="po">បញ្ជាទិញ</a></li>
			</ul>
			<ul class="nav pull-right">
				<li class="dropdown"><a href="#" data-toggle="dropdown">របាយការណ៍ <i class="caret"></i></a>
					<ul class="dropdown-menu">
						<li><a href="#" data-bind="click: showInfo" id="billHistory">ប្រត្តិប័ត្រការណ៍</a></li>
						<li><a href="#" data-bind="click: showInfo" id="eBillHistory">ទិញថាមពល</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</script>
<script id="paybill" type="text/x-kendo-template">
	<div id="billHead" data-role="validator" class="well">
		<table class="table">
			<tbody>
				<tr>
					<td>គណនីសាច់ប្រាក់:</td>
					<td><input type="text" placeholder="គណនីសាច់ប្រាក់" data-bind="source: cashAccounts, value: cashAccount" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 220px;" required data-required-msg="You need to enter a URL" data-text-msg="This url is invalid"></td>
					<td>លេខសែក:</td>
					<td><input type="text" placeholder="បើប្រើសេកដើម្បីទូទាត់"></td>
				</tr>
				<tr>
					<td>កាលបរិច្ឆេទទូទាត់</td>
					<td><input type="text" placeholder="កាលបរិច្ឆេទ" data-bind="value: date" data-role="datepicker" style="width: 220px;"></td>
					<td>ពិពណ៍នារួម</td>
					<td><input type="text" placeholder="ពិពណ៍នារួម" data-bind="value: payment"></td>
				</tr>
				<tr>
					<td>Class</td>
					<td><input type="text" placeholder="រើសយក license" data-bind="source: classes, value: class_id" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 220px;"></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3" style="text-align: right">ចំនួនដែលត្រូវទូទាត់</td>
					<td><span  style="font-size:30px;" data-bind="text: totalAmount"></span></td>
				</tr>
			</tbody>
		</table>
	</div>
	<table class="table" id="bills">
		<thead>
			<tr>
				<th><i class="icon-ok"></i></th>
				<th width="100">កាលបរិច្ឆេទ</th>
				<th>លេខវិក្កយប័ត្រ</th>
				<th>ប្រភេទប្រត្តិបត្រការ</th>
				<th>ចំណាយជំពាក់</th>
				<th>ចំនួនត្រូវទូទាត់</th>
				<th width="110">សាច់ប្រាក់</th>
			</tr>
		</thead>
		<tbody data-role="listview" data-bind="source: openBills" data-template="billList"></tbody>
	</table>
	<button class="btn" data-bind="click: pay_bill">ទូទាត់បំណុលទាំងនេះ</button>
</script>
<script id="billList" type="text/x-kendo-template">
		<tr data-id="#=id#">
			<td><input type="checkbox" name="bill-#=id#" class="checkBox" data-id="#=id#" data-bind="click: tick"></td>
			<td>
				<span data-bind="text: date" data-format="{dd-MM-yyyy}"></span>
			</td>
			<td>
				#=invoiceNumber#
			</td>
			<td>
				<span data-bind="text: bill_type"></span>
			</td>
			<td>
				<span data-bind="text:amount_billed" data-format="{0,C}"></span>
			</td>
			<td>
				#=kendo.toString(amount_due, "c")#
			</td>
			<td>
				<input type="text" data-bind="value: amount_pay, events: {keypress: onEnter}"  class="amount" style="width: 100px; margin-bottom: 0;" data-format="{0,'c2'}">
			</td>	
		</tr>
</script>
<script id="vendorInfo" type="text/x-kendo-template">

	<div class="navbar" style="margin-top: -42px;z-index: 99999;">
		<div class="navbar-inner">
			<ul class="nav">
				<li><a href="#" data-bind="click: getInfo">Vendor Info</a></li>
				<li><a href="#/paybills" data-bind="click: payBill">Pay Bill</a></li>
				<li><a href="#" data-bind="click: getBillHistory">History</a></li>
			</ul>
			<ul class="nav pull-right">
				<li><a href="#" data-bind="click: getElectric">Electricity</a></li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				    	<i class="icon-plus"></i>&nbsp;Create New
				  	</a>
				  	<ul class="dropdown-menu">
					    <li><a href="#/purchase" data-bind="click: onPurchase">Purchase</a></li>
					    <li><a href="#/expense"  data-bind="click: onExpense">Expense</a></li>
					    <li><a href="#/po"  data-bind="click: onPO">P.O.</a></li>
				  	</ul>
				</li>
			</ul>
		</div>
	</div>
	</div>
	<table class="table">
		<tbody>
			<tr>
				<td width="100">ក្រុមហ៊ុន</td>
				<td><input type="text" data-bind="value: current.company" disabled></td>
			</tr>
			<tr>
				<td>នាមត្រកូល</td>
				<td><input type="text" data-bind="value: current.surname"></td>
			</tr>
			<tr>
				<td>ឈ្មោះ</td>
				<td><input type="text" data-bind="value: current.name"></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input type="text" data-bind="value: current.email"></td>
			</tr>
			<tr>
				<td>Phone</td>
				<td><input type="text" data-bind="value: current.phone"></td>
			</tr>
		</tbody>
	</table>
		<button class="btn btn-primary">កត្រា</button> 
		<button class="btn btn-inverse">អ្នកផ្គត់ផ្គង់ថ្មី</button>
</script>
<script id="purchase" type="text/x-kendo-template">
	<div>
		<div class=btn-group>
			<button class="btn" data-bind="click: paidCash, disabled: isCash">Cash</button>
			<button class="btn" data-bind="click: paidCash, enabled: isCash">Credit</button>
		</div>
		<table class="table" data-bind="invisible: isCash">
			<tbody>
				<tr>
					<td width="120">Vendor:</td><td><input type="text" data-role="combobox" 
														   data-bind="source: vendors, value: vendor"
														   data-text-field="name"
														   data-value-field="id"
														   data-template="vendorName"></td>
					<td>Date:</td><td><input type="text" data-role="datepicker"></td>
				</tr>
				<tr class="credit">
					<td>Account:</td><td></td>
					<td>Due Date:</td><td></td>
				</tr>

				<tr class="credit">
					<td>Payment Term:</td><td></td>
					<td>Invoice No:</td><td></td>
				</tr>
				<tr class="credit">
					<td>Memo:</td><td></td>
					<td>Voucher No:</td><td></td>
				</tr>
				<tr class="credit">
					<td>Class</td><td></td>
					<td>PO</td><td></td>
				</tr>
			</tbody>
		</table>
		<table class="table" data-bind="visible: isCash">
			<tbody>
				<tr>
					<td width="120">Vendor:</td><td><input type="text" data-role="combobox" 
														   data-bind="source: vendors, value: vendor"
														   data-text-field="name"
														   data-value-field="id"
														   data-template="vendorName"></td>
					<td>Date:</td><td><input type="text" data-role="datepicker"></td>
				</tr>
				<tr class="credit">
					<td>Account:</td><td></td>
					<td>Check No:</td><td></td>
				</tr>

				<tr class="credit">
					<td>Payment Method:</td><td></td>
					<td>Invoice No:</td><td></td>
				</tr>
				<tr class="credit">
					<td>Memo:</td><td></td>
					<td>Voucher No:</td><td></td>
				</tr>
				<tr class="credit">
					<td>Class</td><td></td>
					<td>PO</td><td></td>
				</tr>
			</tbody>
		</table>
		<table class="table table-condensed">
			<tbody data-role="grid" data-bind="source: bill.items" data-row-template="cartTmpl" data-columns="[{title: 'ឈ្មោះសន្និធិ', width: '140px'}, {title:'ពិពណ៏នា'}, {title:'តំលៃ', width: '110px'}, {title:'ចំនួន', width: '100px'}, {title:'សរុប', width: '120px'}, {title:'', width: '40px'}]"></tbody>
		</table>
		<i class="icon-plus" data-bind="click: addItem"></i>
	</div>
</script>
<script id="cartTmpl" type="text/x-kendo-template">
	<tr>
		<td><input type="text" placeholder="Select One" data-bind="source: items, value: item_id, events: {change: change}" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 130px;"></td>
		<td><input type="text" placeholder="Description" style="width: 145px;" data-bind="value: description"></td>
		<td><input type="text" style="width: 80px;" data-role="numerictextbox" data-bind="value: cost"></td>
		<td><input type="text" style="width: 60px;" data-bind="value: quantity"></td>
		<td>#cost * quantity#</td>
		<td><i class="icon-trash" data-bind="click: removeItem"></i></td>
	</tr>
</script>
<script id="vendorName" type="text/x-kendo-template">
	<span>#=surname# #=name#</span>
</script>
<script id="vendorHistory" type="text/x-kendo-template">
	<div style="position:relative; top: -40px;">
		<button class="btn pull-right" id="vendorHistoryX">X</button>
		<table class="table" id="bills">
			<thead>
				<tr>
					<th width="100">កាលបរិច្ឆេទ</th>
					<th>ប្រភេទវិក្កយប័ត្រ</th>
					<th>ចំណាយជំពាក់</th>
					<th>ចំនួនត្រូវទូទាត់</th>
					<th>ចំនួនទូទាត់រួច</th>
					<th width="110">ទូទាត់</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="vendorHistoryGrid"></tbody>
		</table>
	</div>
</script>
<script id="billGrid" type="text/x-kendo-template">
	<tr data-bind="events: {dblclick: onChange}" data-id="#:id#">
		<td>
			#=kendo.toString(date, 'dd-MM-yyyy')#
		</td>
		<td>
			<span data-bind="text: bill_type"></span>
		</td>
		<td style="text-align: right">
			#=kendo.toString(parseFloat(amount_billed), "c2")#
		</td>
		<td style="text-align: right">
			#=kendo.toString(amount_due, "c2")#
		</td>
		<td style="text-align: right">
			#=kendo.toString(amount_paid, "c2")#
		</td>	
		<td>
			#= status === "1"? "ទូទាត់រួច":"មិនទាន់ទូទាត់" #
		</td>
		<td width="90">
			# if (status === "1") { #
				<a href="\\#/bill/#=id#">View</a>| Pay
			#} else { #
				<a href="\\#/bill/#=id#">View</a> | <a href="\\#/bill/#=id#/pay">Pay</a>
			# } #
		</td>
	</tr>
</script>
<script id="expense" type="text/x-kendo-template">
	<div class=btn-group>
		<button class="btn" data-bind="click: paidCash, disabled: isCash">Cash</button>
		<button class="btn" data-bind="click: paidCash, enabled: isCash">Credit</button>
	</div>
	<table class="table" data-bind="invisible: isCash">
		<tbody>
			<tr>
				<td width="120">Vendor:</td><td><input type="text" data-role="combobox" 
													   data-bind="source: vendors, value: vendor"
													   data-text-field="name"
													   data-value-field="id"
													   data-template="vendorName"></td>
				<td>Date:</td><td><input type="text" data-role="datepicker"></td>
			</tr>
			<tr class="credit">
				<td>Account:</td><td></td>
				<td>Due Date:</td><td></td>
			</tr>

			<tr class="credit">
				<td>Payment Term:</td><td></td>
				<td>Invoice No:</td><td></td>
			</tr>
			<tr class="credit">
				<td>Memo:</td><td></td>
				<td>Voucher No:</td><td></td>
			</tr>
			<tr class="credit">
				<td>Class</td><td></td>
				<td></td><td></td>
			</tr>
		</tbody>
	</table>
	<table class="table" data-bind="visible: isCash">
		<tbody>
			<tr>
				<td width="120">Vendor:</td><td><input type="text" data-role="combobox" 
													   data-bind="source: vendors, value: vendor"
													   data-text-field="name"
													   data-value-field="id"
													   data-template="vendorName"></td>
				<td>Date:</td><td><input type="text" data-role="datepicker"></td>
			</tr>
			<tr class="credit">
				<td>Account:</td><td></td>
				<td>Check No:</td><td></td>
			</tr>

			<tr class="credit">
				<td>Payment Method:</td><td></td>
				<td>Invoice No:</td><td></td>
			</tr>
			<tr class="credit">
				<td>Memo:</td><td></td>
				<td>Voucher No:</td><td></td>
			</tr>
			<tr class="credit">
				<td>Class</td><td></td>
				<td></td><td></td>
			</tr>
		</tbody>
	</table>
</script>
<script id="po" type="text/x-kendo-template">
	PO
</script>
<script id="electricity" type="text/x-kendo-template">
	Electricity
</script>
<script>
	var banhji = banhji || {};

	banhji.ds = banhji.ds || {};
	banhji.model = banhji.model || {};
	banhji.view = banhji.view || {};

	banhji.lastUri = "";

	banhji.ds.vendor = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/vendors/",
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
		serverFiltering: false,
		schema: {
			model: {
				id: "id"
			},
			data: "vendors",
			total: "count"
		}
	});
	banhji.ds.items = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/inventory_api/item",
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
		serverFiltering: false,
		schema: {
			model: {
				id: "id"
			}
		}
	});

	var cashAccountDS = new kendo.data.DataSource({
	    transport: {
		    read: ARNY.baseUrl + "api/accounting_api/cash_account",
		    type: "GET",
		    dataType: "json"
	    }
    });
	var PaymentTermDS = new kendo.data.DataSource({
        transport: {
	        read: ARNY.baseUrl + "api/accounting_api/payment_term",
	        type: "GET",
	        dataType: "json"
        }
    });
    var transformerDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricities/transformers/",
				type: "GET",
				dataType: "json"
			},
			create: {
				url: ARNY.baseUrl + "api/electricities/transformers/",
				type: "POST",
				dataType: "json"
			},
			update: {
				url: ARNY.baseUrl + "api/electricities/transformers/",
				type: "PUT",
				dataType: "json"
			},
			destroy: {
				url: ARNY.baseUrl + "api/electricities/transformers/",
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
		}
	});
	var transformerRecordDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricities/transformerRecords/",
				type: "GET",
				dataType: "json"
			},
			create: {
				url: ARNY.baseUrl + "api/electricities/transformerRecords/",
				type: "POST",
				dataType: "json"
			},
			update: {
				url: ARNY.baseUrl + "api/electricities/transformerRecords/",
				type: "PUT",
				dataType: "json"
			},
			destroy: {
				url: ARNY.baseUrl + "api/electricities/transformerRecords/",
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
		serverFiltering: true,
		schema: {
			model: {
				id: "id"
			}
		}
	});
	var accountDS = new kendo.data.DataSource({
	    transport: {
		    read: ARNY.baseUrl + "api/accounting_api/account",
		    type: "GET",
		    dataType: "json"
	    }
    });
	var expenseAccountDS = new kendo.data.DataSource({
	    transport: {
		    read: ARNY.baseUrl + "api/accounting_api/expense_account",
		    type: "GET",
		    dataType: "json"
	    }
    });
    var cogsDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/accounting_api/cogs_account/",
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
		schema: {
			model: {
				id: "id"
			}
		}
	});
	var creditAccountDS = new kendo.data.DataSource({
			transport: {
				read: ARNY.baseUrl + "api/accounting_api/liability_account",
				type: "GET",
				dataType: "json"
			}
	    });
    var expenseAccountDS = new kendo.data.DataSource({
			transport: {
				read: ARNY.baseUrl + "api/accounting_api/expense_account",
				type: "GET",
				dataType: "json"
			}
	    });
	banhji.ds.paymentTerm = new kendo.data.DataSource({
        transport: {
	        read: ARNY.baseUrl + "api/accounting_api/payment_term",
	        type: "GET",
	        dataType: "json"
        }
    });
	banhji.ds.bills = new kendo.data.DataSource({
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
				// if( operation === "read" ) {
				// 	return { vendor_id: banhji.vm.vendor.current.id };
				// }
				return options;
			}
		},
		serverFiltering: true,
		filter: [
			{field: 'status', value: 0},
			{field: 'created_at', value: '2014-01-01'}
		],
		schema: {
			model: {
				id: "id",
				fields: {
					id: { editable: false }
				}
			},
			data: "bills"
		},
		error	: function(e) {
			console.log(e.status);
		}
	});
	banhji.ds.journal = new kendo.data.DataSource({
		transport: {
			create: {
				url: ARNY.baseUrl + "api/accounting_api/journals/",
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
				if(billModel.payments.length > 0) {
					billModel.payments.splice(0, billModel.payments.length);
				}
				billModel.bills.read();
				banhji.router.navigate("/");
			}
		}
		//serverFiltering: true,
	});

	var invoiceDS = new kendo.data.DataSource({
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
	  	serverFiltering : true	  	
	});

	var classDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/accounting_api/class_dropdown",
				type: "GET",
				dataType: "json"
			}
		}		
	});

	var poDS = new kendo.data.DataSource({
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

	//Start View Models
	banhji.model.vendor	= kendo.observable({
		vendorList 	: banhji.ds.vendor,
		setCurrent	: function(vendorId) {
			this.set("current", this.vendorList.get(vendorId));
		},
		getInfo 	: function(e) {
			e.preventDefault();
			if(this.get("current")) {
				banhji.router.navigate("#/vendor/" + this.get("current").id, false);
			} else {
				alert("Choose a vendor.");
			}
		},
		onPO      : function(e) {
			e.preventDefault();
			var wnd = $("#window").kendoWindow({
				width: "90%",
				actions: ["Maximize", "Close"],
				title: "Purchase Dialog",
				modal: true,
				animation: false,
				content: ARNY.baseUrl + "popup/#/po"
			}).data("kendoWindow");

			wnd.center().open();
		},
		onPurchase	: function(e) {
			e.preventDefault();
			var wnd = $("#window").kendoWindow({
				width: "90%",
				actions: ["Maximize", "Close"],
				title: "Purchase Dialog",
				modal: true,
				animation: false,
				content: ARNY.baseUrl + "popup/#/purchase"
			}).data("kendoWindow");

			wnd.center().open();
		},
		onExpense	: function(e) {
			e.preventDefault();
			var wnd = $("#window").kendoWindow({
				width: "90%",
				actions: ["Maximize", "Close"],
				title: "Purchase Dialog",
				modal: true,
				animation: false,
				content: ARNY.baseUrl + "popup/#/expense"
			}).data("kendoWindow");

			wnd.center().open();
		},
		getElectric	: function(e) {
			e.preventDefault();
			var wnd = $("#window").kendoWindow({
				width: "90%",
				actions: ["Maximize", "Close"],
				title: "Purchase Dialog",
				modal: true,
				animation: false,
				content: ARNY.baseUrl + "popup/#/electricity"
			}).data("kendoWindow");

			wnd.center().open();
		},
		showHome 		: function(e) {
			banhji.router.navigate("#/vendor/" + this.get("current").id, false);	
		},
		showInfo 		: function(e){
			e.preventDefault();
			var target = $(e.currentTarget);
			var parent = target.parent();
			parent.addClass('active');
			parent.siblings().removeClass('active');
			// var uri = this.get('current').id+'/'+target.attr('id');
			// banhji.router.navigate(uri, false);

			switch(target.attr('id')) {
				case "eBill":
					vendor.showIn("#vendor-content", eBill);
					break;
				case "purchase": 
					vendor.showIn("#vendor-content", purchase);
					break;
				case "expense": 
					vendor.showIn("#vendor-content", expense);
					break;
				case "payment": 
					vendor.showIn("#vendor-content", payment);
					break;
				case "po": 
					vendor.showIn("#vendor-content", po);
					break;
				case "billHistory": 
					vendor.showIn("#vendor-content", billHist);
					bills.filter({
						field: 'vendor_id',
						value: banhji.vm.vendor.current.id
					});
					break;
				case "eBillHistory": 
					vendor.showIn("#vendor-content", transformerH);
					transformerRecordDS.filter({
						field: 'vendor_id',
						value: banhji.vm.vendor.current.id
					});
					break;
			}
		},
		showBtn 		: false,
		change 			: function(e) {
			var uid = $(e.currentTarget).closest("tr").data('id');
			//var billModel = this.vendor.bills.get(uid);
			console.log(uid);
		},
		getBillHistory 	: function(e) {
			e.preventDefault();
			banhji.router.navigate("#/vendor/"+ this.get("current").id +"/bill");
			// banhji.view.layout.showIn("#content", banhji.view.history);
			// $("#vendorHistoryX").on("click", function(){
			// 	//banhji.router.navigate("#/vendor/" + this.get("current").id, false);
			// 	banhji.view.layout.showIn("#content", banhji.view.vendorI);
			// });
			// if(banhji.ds.bills._data.length > 0) {
			// 	$("#vendorHistoryGrid").kendoListView({
			// 		dataSource: banhji.ds.bills.data().toJSON(),
			// 		template: kendo.template($("#billGrid").html()),
			// 		change: onChange
			// 	});
			// } else {
			// 	banhji.ds.bills.fetch(function(){
			// 		$("#vendorHistoryGrid").kendoListView({
			// 			dataSource: banhji.ds.bills.data().toJSON(),
			// 			template: kendo.template($("#billGrid").html()),
			// 			change: onChange
			// 		});
			// 	});
			// }

			// function onChange() {
			// 	alert("change");
			// }
		},
		payBill 		: function(e) {
			e.preventDefault();
			banhji.router.navigate("/vendor/"+this.get("current").id + "/paybill", false);
		}
	});
	banhji.model.journal = kendo.observable({
		datasource 	 : banhji.ds.journal,
		jouralEntries: [],
		memo         : "",
		voucher      : "",
		class_id     : 0,
		budget_id    : 0,
		people_id    : 0,
		employee_id  : <?php echo $this->session->userdata('user_id'); ?>,
		invoice_id   : 0,
		transaction_type: "",
		reset        : function() {
			this.set("memo", "");
			this.set("voucher", "");
			this.set("class_id", 0);
			this.set("budget_id", 0);
			this.set("people_id", 0);
			this.set("invoice_id", 0);
			this.set("transaction_type", "");

			if(this.journalEntries.length > 0) {
				this.journalEntries.splice(0, this.journalEntries.length);
			}
		},
		edit         : function(journalId) {
			var transaction = this.datasource.get(journalId);

			if(transaction.memo !== this.get("memo", "")){
				transaction.set("memo", "");
			}
			if(transaction.voucher !== this.get("voucher", "")){
				transaction.set("voucher", "");
			}
			if(transaction.class_id !== this.get("class_id", "")){
				transaction.set("class_id", 0);
			}
			if(transaction.budget_id !== this.get("budget_id", "")){
				transaction.set("budget_id", 0);
			}
			if(transaction.people_id !== this.get("people_id", "")){
				transaction.set("people_id", 0);
			}
			if(transaction.invoice_id !== this.get("invoice_id", "")){
				transaction.set("invoice_id", 0);
			}
			if(transaction.transaction_type !== this.get("transaction_type", "")){
				transaction.set("transaction_type", "");
			}	

			if(transaction.dirty) {
				this.datasource.sync();
			}
		},
		save         : function() {
			var journal = [{
				journalEntries : journalEntries,
		 		memo: this.get('memo'), 
		 		voucher: this.get('voucher'),
		 		class_id: this.get("class_id"),
		 		budget_id: this.get("budget_id"),
		 		donor_id: this.get("donor_id"),
		 		check_no: this.get('checkNo'),
		 		people_id: this.get("people_id"),
		 		employee_id: this.get("employee_id"),
		 		invoice_id: this.get("invoice_id"),	
		 		date: kendo.toString(this.get("date"), "yyyy-MM-dd"), 
		 		transaction_type: this.get("transaction_type")
			}];

			this.datasource.sync();
		}
	});

	banhji.model.bill = kendo.observable({
		datasource 	: banhji.ds.bills,
		items  		: [],
		vendor 		: "",
		date 		: "",
		due_date 	: "",
		pmt_term 	: "",
		pmt_method 	: "",
		memo 		: "",
		voucher 	: "",
		bill_num 	: "",
		cash_acct 	: "",
		credit_acct : "",
		po_num 		: "",
		bill_type 	: "",
		setCurrent  : function(billId) {
			this.set("current", this.datasource.get(billId));
		},
		addBill 	: function() {
			var bill = [];

			if(bill.length > 0) {
				bill.splice(0,1);
			}

			if(this.totalAmount > 0) {
				bill.push({
					vendor_id 	  : this.vendor,
					date 		  : this.get("date"),
					due_date 	  : this.get("due_date"),
					payment_term  : this.get("pmt_term"),
					payment_method: this.get("pmt_method"),
					amount        : this.totalAmount(),
					bill_type 	  : this.get("bill_type"),
					bill_items    : this.get("items")
				});
			}

			this.datasource.add(bill);
		},
		addItem 	: function(item) {
			this.items.push(item);
		},
		removeItem  : function(e) {
			for (var i = 0; i < this.items.length; i ++) {
	            var current = this.items[i];
	            if (current === e.data) {
	                this.items.splice(i, 1);
	                break;
	            }
	        }
		},
		editBill 	: function(billId) {
			var bill = this.datasource.get(billId);

			if(bill.due_date !== this.get("due_date")) {
				bill.set("due_date", this.get("due_date"));
			}

			if(bill.dirty) {
				this.datasource.sync();
			}
		},
		totalAmount : function() {
			var amount = 0;
			if(this.items.length > 0) {
				$.each(this.items, function(i, item) {
					amount = amount + parseFloat(this.items[i].amount);
				});
			}
			return amount;
		},
		resetBill 	: function() {
			this.set("vendor", "");
			this.set("date", new Date());
			this.set("due_date", "");
			this.set("voucher", "");
			this.set("bill_num", 0);
			this.set("bill_type", "");
			this.set("cash_acct", "");
			this.set("credit_acct", "");
			this.set("po_num", "");
			this.set("memo", "");
			this.set("pmt_term", "");
			this.set("pmt_method", "");

			// reset item array
			if(this.items.length > 0) {
				this.items.splice(0, this.items.length);
			}
		},
		saveBill 	: function() {
			this.datasource.sync();

			this.datasource.bind("requestEnd", function(e){
				var type = e.type;
				if(e.type === "create") {
					e.response.id;
				}
			});
		}
	});

	var billModel = kendo.observable({
		bills 			: banhji.ds.bills,
		openBills 		: [],
		payments 		: [],
		cashAccounts 	: cashAccountDS,
		cashAccount 	: "",
		classes 		: [],
		class_id 		: "",
		paymentMethod 	: [
			{ id: 1, method: "Cash"},
			{ id: 2, method: "Check"},
			{ id: 3, method: "Credit Card"}
		],
		close 		: function(e) {
			e.preventDefault();
			layout.showIn("#info", vendor);
			var uri = "/"+vendorModel.vendor.id;
			banhji.router.navigate(uri, false);
		},
		pmtMethod 		: "",
		pmtMethods 		: "cash",
		date 			: new Date(),
		payment_note	: "",
		payBtn 			: false,
		checkNo 		: "",
		ref 			: "from pay bill page.",
		tick 			: function(e) {
			//console.log($(e.currentTarget).is(":checked"));
			//console.log(e.data);
			var $current = $(e.currentTarget);
			var data 	= e.data;
			var found 	= false;
			if($current.is(":checked") === true) {
				if(this.payments.length > 0) {
					for(var i=0; i < this.payments.length; i++) {
						if(data.id === this.payments[i].bill_id) {
							$current.closest("tr").find(".amount").val(data.amount_due);
							this.payments[i].set("amount_paid", data.amount_due);
							found = true;
							break;
						}
					}
				} 
				if(found === false) {
					$current.closest("tr").find(".amount").val(data.amount_due);
					this.payments.push({
							bill_id: data.id,
						 	amount_paid: data.amount_due,
						 	date: kendo.toString(this.get("date"),"yyyy-MM-dd"),
						 	payment_note: this.get("payment_note")
					});
				}	
			} else {
				$current.closest("tr").find(".amount").val("");
				if(this.payments.length > 0) {
					for(var i=0; i < this.payments.length; i++) {
						if(data.id === this.payments[i].bill_id) {
							this.payments.splice(i, 1);
							break;
						}
					}
				}
			}
		},
		onEnter 		: function(e) {
			var current = $(e.currentTarget);
			var data 	= e.data;
			var found 	= false;
			if(e.which == 13) {
				if(current.closest("tr").find('.amount').val() > data.amount_due) {
					current.closest("tr").find('.amount').val("");
					current.closest("tr").find('.amount').focus();
				} else {
					if(this.payments.length > 0) {
						for(var i=0; i < this.payments.length; i++) {
							if(data.id === this.payments[i].bill_id) {
								this.payments[i].set("amount_paid", current.closest("tr").find('.amount').val());
								current.closest("tr").find(".checkbox").attr('checked');
								found = true;
								break;
							}
						}	
					}

					if(found === false) {
						this.payments.push({
								bill_id: data.id,
							 	amount_paid: current.closest("tr").find('.amount').val(),
							 	date: kendo.toString(this.get("date"),"yyyy-MM-dd"),
							 	payment_note: this.get("payment_note")
						});
						current.closest("tr").find(".checkbox").attr('checked');
					}
				}
			}	
		},
		total 			: function() {
			return this.get("payments").length;
		},
		totalAmount		: function() {
			var total = 0;
				for(var i=0; i<this.get("payments").length; i++) {
					total = parseFloat(total) + parseFloat(this.get("payments")[i].amount_paid);
				}
			return total;
		},
		employee 		: <?php echo $this->session->userdata('user_id'); ?>,
		empty 			: function() {
			
		},
		showDetail  : function(e) {
			if(e.type == 'dblclick') {
				alert("show detial");
			}
			
		},
		pay_bill	: function() {
			var data = bills.data();
			var vendor = vendorDS.get(vendorModel.get("vendor").id);
			if(this.get("cashAccount") === "") {
				alert("Empty");
			} else {
				if(this.get("payments").length > 0) {	
					billPayments.add(this.get("payments"));
					billPayments.sync();

					var journalEntries = [];
					journalEntries.push(
				 	{
				 		account_id: 30, //this logs to account payables should this be saved by the config setting
				 		dr: this.totalAmount(), 
				 		cr: 0, 
				 		memo: this.get('payment_note'), 
				 		class_id: this.get("class_id"),
				 		voucher: this.get('ref'),
				 		people_id: 4, 
				 		check_no: this.get('checkNo'),
				 		date: kendo.toString(this.get("date"), "yyyy-MM-dd"), 
				 		transaction_type: "សងបំណុល"
			 		});
					journalEntries.push({
				 		account_id: this.get("cashAccount"), 
				 		dr: 0, 
				 		cr: this.totalAmount(), 
				 		memo: this.get('payment_note'),
				 		class_id: this.get("class_id"), 
				 		voucher: this.get('ref'),
				 		people_id: 4,
				 		check_no: this.get('checkNo'),
				 		date: kendo.toString(this.get("date"), "yyyy-MM-dd"), 
				 		transaction_type: "សងបំណុល"
					 });
					if(journalEntries.length > 0) {
						journalDS.add({
					 		bill_id: billId,
					 		journalEntries : journalEntries,
					 		memo: this.get('memo'), 
					 		voucher: this.get('ref'),
					 		class_id: this.get("class_id"),
					 		budget_id: 0,
					 		donor_id: 0,
					 		check_no: this.get('checkNo'),
					 		people_id: vendorModel.get("vendor").id,
					 		employee_id: <?php echo $this->session->userdata('user_id'); ?>,
					 		invoice_id: 0,
					 		payment_id: 0,	
					 		date: kendo.toString(this.get("date"), "yyyy-MM-dd"), 
					 		transaction_type: "ទូទាត់បំណុល",
					 		people_id: vendorModel.get("vendor").id,
					 	});
					 	journalEntries.splice(0, journalEntries.length);
					}

					journalDS.sync();
					totalPaid = 0;
					vendor.set("outstanding", (vendor.outstanding - this.totalAmount()));
					for(var i = 0; i < billPayments.data().length; i++) {
						billPayments.remove(billPayments.at(0));
					}
					for(var i =0; i < journalDS.data().length; i++) {
						journalDS.remove(journalDS.at(i));
					}
					this.payments.splice(0, this.payments.length);
					this.set("cashAcct", "");
					this.set("checkNo", "");
					this.set("payment_not", "");
					bills.read();
				}				
			}
			
		}
	});

	banhji.model.purchase = kendo.observable({
		bill        : banhji.model.bill,
		transaction : banhji.model.journal,
		vendors 	: banhji.ds.vendor,
		classes     : "",
		items       : [],
		cash_accts  : banhji.ds.accounts,
		credit_accts: banhji.ds.accounts,
		pmt_terms   : banhji.ds.paymentTerm,
		isCash      : true,
		paidCash    : function(e) {
			if(this.get("isCash")) {
				this.set("isCash", false);
			} else {
				this.set("isCash", true);
			}
			var that = $(e.target);
			that.siblings().disabled;
		},
		pmt_methods : [{type: "Cash"}, {type: "Check"}, {type: "Credit Card"}],
		vendor 		: null,
		cash_acct   : null,
		credit_acct : null,
		class_id    : null,
		pmt_term    : null,
		pmt_method  : null,
		check_num   : null,
		date        : null,
		invoice_num : null,
		due_date    : function(){
			var date;
			if(this.get("paymentTerm") !== "") {	
				var net = parseInt(this.pmt_terms.get(this.get("pmt_term")).net_due_in);
				var due_date = new Date(this.get("date"));
				due_date.setDate(due_date.getDate() + net);
				date = new Date(due_date);
			} else {
				date = new Date();
			}
			return date;
		},
		voucher     : null,
		memo        : null,
		po_id       : null,
		addItem     : function() {
			this.bill.items.push({
				item_id: "", description: "", quantity: 0, cost: 0, price: 0, amount: 0, account_id: 0
			});
		},
		removeItem  : function(e) {
			this.bill.removeItem();
		}
	});

	banhji.model.expense = kendo.observable({
		isCash      : true,
		paidCash    : function(e) {
			if(this.get("isCash")) {
				this.set("isCash", false);
			} else {
				this.set("isCash", true);
			}
			var that = $(e.target);
			that.siblings().disabled;
		},
		vendors 	: banhji.ds.vendor,
		vendor      : ""
	});

	banhji.model.po = kendo.observable({});

	banhji.model.electricity = kendo.observable({});
	
	banhji.view.layout = new kendo.Layout("#appIndex", {model: banhji.model.vendor});
	banhji.view.vendorI= new kendo.View("#vendorInfo", {model: banhji.model.vendor});
	banhji.view.history= new kendo.View("#vendorHistory", {model: banhji.model.vendor});
	banhji.view.purchase = new kendo.View("#purchase", {model: banhji.model.purchase});
	banhji.view.expense = new kendo.View("#expense", {model: banhji.model.expense});
	banhji.view.po = new kendo.View("#po");
	banhji.view.electricity = new kendo.View("#electricity");
	banhji.view.paybill 	= new kendo.View("#paybill", {model: billModel});
	banhji.router = new kendo.Router({
		init: function() {
			banhji.view.layout.render("#application");
		}
	});

	banhji.router.route('/vendor/:vendorId', function(vendorId){
		banhji.view.layout.showIn("#content", banhji.view.vendorI);

		banhji.model.vendor.setCurrent(vendorId);
	});

	banhji.router.route("/bill(/:billId)", function(billId){
		//banhji.view.layout.showIn("#content", banhji.view.purchase);
		if(billId) {
			//fetch existing bill with id
			if(banhji.ds.bills.data().length > 0) {
				console.log("h");
			} else {
				banhji.ds.bills.filter({
					field: "id", value: billId
				});
				var len = banhji.ds.bills.data().length;
				if(len > 0){
					console.log(banhji.ds.bills.data());
				}
			}
			//this.set("vendor", banhji.model.bill.get("current").id);
			// this.set("date", new Date());
			// this.set("due_date",  model.id);
			// this.set("voucher",  model);
			// this.set("bill_num", 0);
			// this.set("bill_type", "");
			// this.set("cash_acct", "");
			// this.set("credit_acct", "");
			// this.set("po_num", "");
			// this.set("memo", "");
			// this.set("pmt_term", "");
			// this.set("pmt_method", "");
			// save changes
			console.log(billId);
		} else {
			// this is new bill enter new data

			// save new bill
			console.log(billId);
		}
		// prepare template if not coming from id
		// layout.showIn("#content", vendor);
		// vendor.showIn("#vendor-content", eBill);
		// $("#eBill").parent().addClass('active');
		// $("#eBill").parent().siblings().removeClass('active');

		// query bill based on provided id
	});

	banhji.router.route("/vendor/:vendorId/bill", function(vendorId){
		banhji.view.layout.showIn("#content", banhji.view.history);
		$("#vendorHistoryX").on("click", function(){
			//banhji.router.navigate("#/vendor/" + this.get("current").id, false);
			banhji.view.layout.showIn("#content", banhji.view.vendorI);
		});
		if(banhji.ds.bills._data.length > 0) {
			$("#vendorHistoryGrid").kendoListView({
				dataSource: banhji.ds.bills.data().toJSON(),
				template: kendo.template($("#billGrid").html()),
				change: onChange
			});
		} else {
			banhji.ds.bills.fetch(function(){
				banhji.ds.bills.filter(
					{ field: "vendor_id", value: vendorId }
				);
				$("#vendorHistoryGrid").kendoListView({
					dataSource: banhji.ds.bills.data().toJSON(),
					template: kendo.template($("#billGrid").html()),
					change: onChange
				});
			});
		}

		function onChange() {
			alert("change");
		}
	});

	banhji.router.route("/purchase(/:billId)", function(billId){
		if(banhji.model.bill.items.length > 0) {
			banhji.model.bill.items.splice(0, banhji.model.bill.items.length);
		}
		banhji.view.layout.showIn("#content", banhji.view.purchase);

		if(billId){
			// console.log("Yahoo!!!");
		} else {

			console.log(banhji.model.vendor.get("current"));
			// banhji.model.bill.set("vendor", banhji.model.vendor.get("current").id);
		}
	});

	banhji.router.route("/expense", function(){
		if(banhji.model.bill.items.length > 0) {
			banhji.model.bill.items.splice(0, banhji.model.bill.items.length);
		}
		banhji.view.layout.showIn("#content", banhji.view.expense);
	});

	banhji.router.route("/po", function(){
		if(banhji.model.bill.items.length > 0) {
			banhji.model.bill.items.splice(0, banhji.model.bill.items.length);
		}
		banhji.view.layout.showIn("#content", banhji.view.po);
	});

	banhji.router.route("/electricity", function(){
		banhji.view.layout.showIn("#content", banhji.view.electricity);
	});

	banhji.router.route("/vendor/:id/paybill", function(id){
		banhji.view.layout.showIn("#content", banhji.view.paybill);
		banhji.ds.bills.fetch(function(){
			var data = this.data();

			if(billModel.get("openBills").length > 0) {
				billModel.get("openBills").splice(0, billModel.get("openBills").length);
			}
			for(var i = 0; i < data.length; i++) {
				if(data[i].vendor_id === id) {
					billModel.get("openBills").push(data[i]);
				}
			}
		});

	});

	$("#search").on('click', function() {
			var field = $("#searchOptions").val();
			var value = $("#searchField").val();
			banhji.ds.vendor.filter(
				{ field: field, operator: 'contains',value: value}
			);
	});
	var vendorGrid = $("#vendorList").kendoGrid({
		dataSource: banhji.ds.vendor,
		selectable: true,
		columns: [
			{ title: "&nbsp;"}
		],
		rowTemplate: kendo.template($("#vendorListTmpl").html()),
		scrollable: true,
		height: 525,
		change: function(){
			var selected = this.select();
			var data = this.dataItem(selected);	

			banhji.model.vendor.setCurrent(data.id);
			// layout.showIn("#content", vendor);
			// $("#home").parent().addClass('active');
			// $("#home").parent().siblings().removeClass('active');
				
			// vendor.showIn("#vendor-content", vendorI);
			banhji.router.navigate("#/vendor/"+ data.id, false);

		}
	}).data("kendoGrid");

	var onRequestEnd = function(e) {
	}

	$(function(){
		banhji.router.start();
	});
</script>