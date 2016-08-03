<div class="span12">
	<div id="heading">
		<div class="hidden-print" style="margin-left: 5px;">
			<input type="text" class="date" id="startDate" data-role="datepicker" data-bind="value: startDate">-
			<input type="text" class="date" id="endDate" data-role="datepicker" data-bind="value: endDate"> 
			<button class="btn" id="search">មើលរបយាការណ៍</button>
		</div>
		<div id="detail" style="text-align:center; height: 100px;">
			<h1>របាយការណ៍សន្និធិ</h1>
			សម្រាប់រយពេលពី <span data-bind="text: startDate"></span> ដល់ <span data-bind="text: endDate"></span>
		</div>
	</div>

	<table id="transactions" class="table table-bordered">
		<thead>
			<td style="text-align: center;">សន្និធិ</td>
			<td style="text-align: center;" width="100">សន្និធិសល់</td>
			<td style="text-align: center;" width="100">តំលៃទិញចូល</td>
			<td style="text-align: center;" width="100">តំលៃលក់ចេញ</td>
			<td style="text-align: center;" width="100">ចំនួនលក់ចេញ</td>
			<td style="text-align: center;" width="100">មធ្យមភាគលក់ចេញ</td>
		</thead>
		<tbody></tbody>
	</table>
</div>
<script type="text/x-kendo-template" id="journal">
	<tr>
		<td style="text-align:left;">#= name #</td>
		<td style="text-align:right;">#= kendo.toString(parseInt(quantity), 'n') #</td>
		<td style="text-align:right;">#= kendo.toString(parseInt(cost), 'c2') #</td>
		<td style="text-align:right;">#= kendo.toString(parseInt(price), 'c2') #</td>
		<td style="text-align:right;">#= kendo.toString(sale_qty, 'n') #</td>
		<td style="text-align:right;">#= kendo.toString(avg_price, 'c2') #</td>
	</tr>
</script>
<script>
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

	// var start = $("#startDate").kendoDatePicker({
	// 	value: new Date().getFullYear() +'-'+ (new Date().getMonth() + 1) +'-1',
	// }).data('kendoDatePicker');
	// var end = $("#endDate").kendoDatePicker({
	// 	value: new Date(),
	// }).data('kendoDatePicker');
	var classes = $("#classes").kendoDropDownList({
		 	dataSource: classDS,
		 	dataTextField: "name",
			dataValueField: "id"
		 }).data("kendoDropDownList");
	var inventoryVM = kendo.observable({
		startDate 	: function() {
			var date = new Date().getFullYear() +'-'+ (new Date().getMonth() + 1) +'-1';
			return date;
		},
		endDate		: new Date()
	});
	kendo.bind("#heading", inventoryVM);
	$(document).ready(function() {
		var inventory = new kendo.data.DataSource({
			transport: {
				read: {
					url : ARNY.baseUrl + "api/inventory_api/reports",
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
					id : "id"
			  	},
			  	data: 'results'
			},
		  	serverFiltering: true,
		  	filter: [
		  		{ field: "created_at", value: kendo.toString(inventoryVM.get("startDate"), 'yyyy-MM-dd') },
		  		{ field: "created_at", value: kendo.toString(inventoryVM.get("endDate"), 'yyyy-MM-dd') }
		  	]
		});
		
		var grid = $("#transactions > tbody").kendoListView({
			dataSource: inventory,	
			selectable: true,
			template: kendo.template($("#journal").html())
		}).data("kendoListView");

		$("#search").on('click', function(){
			inventory.query({
				filter: [
					{ value: inventoryVM.get("startDate") }, 
					{ value: inventoryVM.get("endDate") }]
			});
		});

	});<!--End of document.ready-->
</script>