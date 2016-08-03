<div class="row-fluid">    
	<div class="span12">
		<div id="example" class="k-content">			

			<div id="content">
				<input type="date" value="" id="as_of_date">
				<input type="text" id="classes" placeholder="រើសមួយ..." value=""> 
				<button class="btn" id="search">មើលរបយាការណ៍</button>
				<h3 style="text-align:center">របាយការណ៍បំណុលអ្នកផ្គត់ផ្គង់តាមលក្ខខណ្ឌ័ទូទាត់</h3>
				<p style="text-align:center" id="dateTime">គិតត្រឹម <span data-bind="text: date"></span></p>
				<table class="table" id="listview">
					<thead>
						<tr>
							<th width="300"></th>
							<th style="text-align: center">បច្ចុប្បន្ន</th>
							<th style="text-align: center">1-30</th>
							<th style="text-align: center">31-60</th>
							<th style="text-align: center">61-90</th>
							<th style="text-align: center">> 90</th>
							<th style="text-align: center">សមតុល្យសរុប</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			
		</div> <!--end div example-->            
	</div> <!--End div span12-->		
</div> <!--End div row-fluid-->


<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Modal header</h3>
  </div>
  <div class="modal-body" style="height: 300px;">
    <div id="billDetail" class="table"></div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">បិទ</button>
  </div>
</div>
<script type="text/x-kendo-tmpl" id="aging_summary_report">
	<tr data-id="#:vendor_id#">
		<td>#=vendor_name#</td>
		<td style="text-align: right">#=kendo.toString(aging_report.current, 'c2')#</td>
		<td style="text-align: right">#=kendo.toString(aging_report.in_thirty, 'c2')#</td>
		<td style="text-align: right">#=kendo.toString(aging_report.in_sixty, 'c2')#</td>
		<td style="text-align: right">#=kendo.toString(aging_report.in_ninety, 'c2')#</td>
		<td style="text-align: right">#=kendo.toString(aging_report.over_ninety, 'c2')#</td>
		<td style="text-align: right">#=kendo.toString((aging_report.current+aging_report.in_thirty+aging_report.in_sixty+aging_report.in_ninety+aging_report.over_ninety), 'c2')#</td>
	</tr>
</script>
<script>
	var reportAging = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/reports/vendor_aging_summaries/",
				type: "GET",
				dataType: "json"
			},
			parameterMap : function(options, operation) {
				if( operation !== "read" && options.models ) {
					return { models: kendo.stringigy(options.models) };
				}
				if( operation === "read") {
					return { as_of : kendo.toString($("#as_of_date").val(), 'yyyy-MM-dd'), class_id: classes.value() };
				}
				return options;
			}
		},
		schema: {
			model: {
				id: "id"
			},
			data: "vendors",
			count: "count"
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
			console.log(e.status);
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
					return { vendor_id : viewModel.get("vendor_id"), status : 0 };
				}
				return options;
			}
		},
		schema: {
			model: {
				id: "id"
			}
		},
		pageSize: 20,
		serverFiltering: false,
		requestEnd: function(e) {
			var type = e.type;
			
			if(type==="create") {
				if(e.response.type === "expense") {
					expenseModel.sync(e.response.bill.id);
				} else if(e.response.type === "purchase") {
					purchaseModel.sync(e.response.bill.id);
				} else if (e.response.type === "ebill") {
					eBillModel.sync(e.response.bill.id);
					//console.log(e.response.type);
				}	
			}
		},
		error	: function(e) {
			console.log(e.status);
		}
	});
	var viewModel = kendo.observable({
		date: function() {
			return kendo.toString(new Date(), 'dd-MM-yyyy');
		},
		vendor_id: ""
	});

	var today = new Date();
	$("#as_of_date").kendoDatePicker({
		value: new Date(),
		format: "dd-MM-yyyy",
		// change: function(e) {
		// 	if(kendo.toString(today, 'dd-MM-yyyy') < $("#as_of_date").val()){
		// 		//alert("date cannot be greater than today.")
		// 		//$("#myModal").modal('toggle');
		// 		//this.value(today);
		// 	} else {
		// 		reportAging.read();	
		// 	}
			
		// 	//alert($("#as_of_date").val());	
		// }
	});

	var classes = $("#classes").kendoDropDownList({
	 	dataSource: classDS,
	 	dataTextField: "name",
		dataValueField: "id",
		index: 0
	 }).data("kendoDropDownList");
	kendo.bind($(".container"), viewModel);
	$(function() {
		$("#listview tbody").kendoListView({
			dataSource: reportAging,
			template: kendo.template($("#aging_summary_report").html())
		});

		$("#content").on("dblclick", "#listview >tbody >tr", function(e) {
			// var vendorID = 
			viewModel.set("vendor_id", $(e.currentTarget).data("id"));
			console.log(viewModel.get("vendor_id"));
			$("#billDetail").kendoGrid({
				dataSource: bills,
				columns: [
					{ title: "វិក្ក័យប័ត្រ", field: "invoiceNumber" },
					{ title: "Amount Billed", field: "amount_billed", template:"#=kendo.toString(parseFloat(amount_billed), 'c2')#" },
					{ title: "Amount Due", field: "amount_due", template:"#=kendo.toString(parseFloat(amount_due), 'c2')#" },
					{ title: "Amount Paid", field: "amount_paid", template:"#=kendo.toString(parseFloat(amount_paid), 'c2')#" },
					{ title: "Due Date", field: "dueDate" }
				],
				height: 250,
				pageable: true
			}).data("kendoGrid");
			$('#myModal').modal('show')
		});
	});
	$("#search").on("click", function(e){
		viewModel.set("date", $("#as_of_date").val());
		reportAging.read();
	});
</script>