<div class="span12">
	<div class="hidden-print" style="margin-left: 5px;">
		<input type="text" class="date" id="startDate">-
		<input type="text" class="date" id="endDate"> 
		<input type="text" id="classes" placeholder="រើសមួយ..." value=""> 
		<button class="btn" id="search">មើលរបាយការណ៍</button>
	</div>
	<div id="detail" style="text-align:center; height: 100px;">
		<h1>របាយការណ៍លំអិតតាមគណនី</h1>
		ចាប់ពី៖ <span data-bind="text: startDate"></span> ដល់ <span data-bind="text: endDate"></span>
	</div>
	
	<table id="transactions" class="table">
		<thead>
			<th width="150">ប្រភេទប្រតិបត្តិការ</th>
			<th>កាលបរិច្ឆេទ</th>
			<th width="300">ពិពណ៍នា</th>
			<th>ឥណពន្ធ Dr.</th>
			<th>ឥណទាន Cr.</th>
			<th>សមតុល្យ</th>
		</thead>
		<tbody></tbody>
	</table>
</div>
<script type="text/x-kendo-template" id="journal">
	<tr>
		<td colspan="6">គណនី #: ledger.code #&mdash;#:ledger.name#</td>
	</tr>
	#var totalDr = 0, totalCr = 0;#
	#if( transactions !== null ) {#
		#for(var i= 0; i< transactions.length; i++) {#
			# totalDr += parseFloat(transactions[i].dr); #
			# totalCr += parseFloat(transactions[i].cr); #
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;#: transactions[i].tranDescription#</td>
				<td>#= transactions[i].date #</td>
				<td>#= transactions[i].memo #</td>
				<td style="text-align: right">#= kendo.toString(parseFloat(transactions[i].dr), "c2") #</td>
				<td style="text-align: right">#= kendo.toString(parseFloat(transactions[i].cr), 'c2') #</td>
				<td style="text-align: right">#= kendo.toString(parseFloat(transactions[i].balance), 'c2') #</td>
			</tr>
		#}#
		<tr class="error">
			<td></td>
			<td></td>
			<td>សរុប</td>
			<td style="text-align: right">#=kendo.toString(totalDr, "c2")#</td>
			<td style="text-align: right">#=kendo.toString(totalCr, "c2")#</td>
			<td style="text-align: right">#= kendo.toString(parseFloat(transactions[transactions.length-1].balance), 'c2') #</td>
		</tr>
	#}#
	
</script>
<script>
	var start = $("#startDate").kendoDatePicker({
		value: new Date().getFullYear() +'-'+ (new Date().getMonth() + 1) +'-1',
		change: function() {
			transactionsVM.set("startDate", kendo.toString(this.value(), 'dd-MM-yyyy'));
		}
	}).data('kendoDatePicker');
	var end = $("#endDate").kendoDatePicker({
		value: new Date(),
		change: function() {
			transactionsVM.set("endDate", kendo.toString(this.value(), 'dd-MM-yyyy'));
		}
	}).data('kendoDatePicker');
	//Account datasource	
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
		index: 0
	 }).data("kendoDropDownList");

	var transactionsVM = kendo.observable({
		setCurrent 		: function(id) {
			this.set("current", transactionDS.get(id));
		},		
		startDate		: function() {
			return kendo.toString(start.value(), 'dd-MM-yyyy');
		},
		endDate 		: function(){
			return kendo.toString(end.value(), 'dd-MM-yyyy');
		}
 	});
	$(document).ready(function() {
		var transactionDS = new kendo.data.DataSource({
			transport: {
				read: {
					url : ARNY.baseUrl + "api/accounting_api/general_ledgers",
					type: "GET",
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
					id : "transID",
					fields: [

					]
			  	},
			  	data: 'results',
			  	total: function(data) {
			  		return data.total;
			  	}
			},
		  	serverFiltering: true,
		  	serverPaging: true,
		  	pageSize: 20,
		  	filter: [
		  		{ field: "createdDate", value: start.value() },
		  		{ field: "createdDate", value: end.value() },
		  		{ field: "class_id", value: classes.value() }
		  	]
		});
		//Account grid
		kendo.bind($("#detail"), transactionsVM);
		var grid = $("#transactions > tbody").kendoListView({
			dataSource: transactionDS,	
			//selectable: true,
			template: kendo.template($("#journal").html())
		}).data("kendoListView");

		$(".container").on('click', '#search', function(){
			transactionDS.query({
				filter: [{ value: start.value() }, { value: end.value() }, { value: classes.value() }]
			});

		});

	});<!--End of document.ready-->
</script>