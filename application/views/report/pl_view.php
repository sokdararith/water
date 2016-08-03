<div class="container">
	<div class="row">
		<div class="span12">
			
			
		</div>
		<div class="span10 offset1">
			<input type="date" value="" id="from_date" class="date">
			- <input type="date" value="" id="as_of_date" class="date">
			<input type="text" id="classes" placeholder="រើសមួយ..." value=""> 
			<button data-bind="click: refresh" class="btn">មើលរបយាការណ៍</button>
			<h3 style="text-align:center">របាយការណ៍លទ្ធផល</h3>
			<p style="text-align:center" id="dateTime">សម្រាប់រយពេលពី <span data-bind="text: from"></span> ដល់ <span data-bind="text: date"></span></p>
			<table class="table" id="income">
				<thead>
					<tr>
						<th width="400">ចំណូល</th>
						<th>ចំនួន</th>
					</tr>
				</thead>
				<tbody data-role="listview" data-bind="source: incomes" data-template="incomeTmpl"></tbody>
				<tfoot>
					<tr>
						<td style="text-align: right">សរុបចំណូល:</td>
						<td style="text-align: right"><span data-bind="text: incomeTotal"></span></td>
					</tr>
				</tfoot>
			</table>

			<table class="table" id="listview">
				<thead>
					<tr>
						<th width="400">ចំណាយ</th>
						<th>ចំនួន</th>
					</tr>
				</thead>
				<tbody data-role="listview" data-bind="source: expense" data-template="expenseTmpl"></tbody>
				<tfoot>
					<tr>
						<td style="text-align: right">សរុបចំណាយ</td>
						<td style="text-align: right"><span data-bind="text: expenseTotal"></span></td>
					</tr>
				</tfoot>
			</table>
			<table class="table">
				<tbody>
					<tr>
						<td width="400">ចំណេញ (ខាត) សុទ្ធ</td>
						<td style="text-align: right"><span data-bind="text: net"></span></td>
					</tr>
				</tbody>
			</table>
			
		</div>
	</div>
</div>
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">មានបញ្ហា!</h3>
	</div>
	<div class="modal-body">
		<p>កាលបរិច្ឍេតមិនតអាចធំជាងថ្ងាំនេះទេ!</p>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">បិទ</button>
	</div>
</div>
<script type="text/x-kendo-tmpl" id="incomeTmpl">	
	<tr>
		<td>#=name#</td>
		<td style="text-align: right">#=kendo.toString(parseFloat(amount), 'c2')#</td>
	</tr>
</script>
<script type="text/x-kendo-tmpl" id="expenseTmpl">	
	<tr>
		<td>#=name#</td>
		<td style="text-align: right">#=kendo.toString(parseFloat(amount), 'c2')#</td>
	</tr>
</script>
<script>
	var today = new Date();
	var from = $("#from_date").kendoDatePicker({
		value: new Date(),
		format: "dd-MM-yyyy",
		change: function(e) {
			if(kendo.toString(today, 'dd-MM-yyyy') < $("#as_of_date").val()){
				alert("date cannot be greater than today.")
			} else {
				reportAging.read();
				//viewModel.get_income();	
			}
		}
	}).data("kendoDatePicker");
	$("#as_of_date").kendoDatePicker({
		value: new Date(),
		format: "dd-MM-yyyy",
		change: function(e) {
			if(kendo.toString(today, 'dd-MM-yyyy') < $("#as_of_date").val()){
				$("#myModal").modal('toggle');
				this.value(today);
			} else {
				//reportAging.read();
				viewModel.get_income();	
			}
		}
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
	var classes = $("#classes").kendoDropDownList({
	 	dataSource: classDS,
	 	dataTextField: "name",
		dataValueField: "id",
		index: 0,
		change: function(e) {
			reportAging.read();
		}
	 }).data("kendoDropDownList");
	var reportAging = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/reports/profit_loss/",
				type: "GET",
				dataType: "json"
			},
			parameterMap : function(options, operation) {
				if( operation !== "read" && options.models ) {
					return { models: kendo.stringigy(options.models) };
				}
				if( operation === "read") {
					return { 	from : kendo.toString($("#from_date").val(), 'yyyy-MM-dd'), 
								to: kendo.toString($("#as_of_date").val(), 'yyyy-MM-dd'),
								class_id: classes.value() 
							};
				}
				return options;
			}
		},
		serverFiltering: false,
		requestEnd: function(e) {
			var type = e.type;
			
			if(type==="create") {
				if(e.response.type === "expense") {
					//expenseModel.sync(e.response.bill.id);
				} else {
					//purchaseModel.sync(e.response.bill.id);
				}	
			}
		},
		error	: function(e) {
			//console.log(e.status);
		}
	});

	reportAging.read();
	var viewModel = kendo.observable({
		incomes: [],
		expense: [],
		incomeTotal: 0,
		expenseTotal: 0,
		net: "",
		from : function() {
			return kendo.toString(from.value(), 'dd-MM-yyyy');
		},
		date: function() {
			return kendo.toString(new Date(), 'dd-MM-yyyy');
		},
		get_income: function(e) {
			var source = reportAging.data();
			var incomeTotal=0, expenseTotal=0;
			if(this.incomes.length > 0) {
				this.set("incomeTotal", 0);
				this.incomes.splice(0, this.incomes.length);
			}
			if(this.expense.length > 0) {
				this.set("expenseTotal", 0);
				this.expense.splice(0, this.expense.length);
			}
			if( source.length > 0) {
				for(var i=0;i<source.length;i++) {
					//console.log(source[i]=="");
					if(source[0]!="") {
						if(source[0].income.length > 0) {
							for( var i = 0; i < source[0].income.length; i++) {
								this.incomes.push({
									code: source[0].income[i].account_code, 
									name: source[0].income[i].account_name,
									amount: source[0].income[i].balance
								});
								incomeTotal += parseFloat(source[0].income[i].balance);
							}
						}
					}
					if(source[1]!="") {
						if(source[1].expense.length > 0) {
							for( var i = 0; i < source[1].expense.length; i++) {
								this.expense.push({
									code: source[1].expense[i].account_code, 
									name: source[1].expense[i].account_name,
									amount: source[1].expense[i].balance
								});
								expenseTotal += parseFloat(source[1].expense[i].balance);
							}	
						}
					}		
				}
			}
			this.set("incomeTotal", kendo.toString(incomeTotal, "c"));
			this.set("expenseTotal", kendo.toString(expenseTotal, "c"));
			this.set("net", kendo.toString((incomeTotal - expenseTotal), "c"));
		},
		refresh: function() {
			//reportAging.read();
			this.get_income();
		}
	});
	
	kendo.bind($(".container"), viewModel);
	
	$(function() {
		viewModel.get_income();
		
		$("#listview tbody").kendoListView({
			dataSource: viewModel.get("expense"),
			template: kendo.template($("#expenseTmpl").html())
		});
	});
</script>