
		<div class="span8 offset2" id="main-container">
			<input type="date" value="" id="as_of_date" class="date">
			<input type="text" id="classes" placeholder="រើសមួយ..." value=""> 
			<button data-bind="click: get_income" class="btn">មើលរបយាការណ៍</button>
			<h3 style="text-align:center">របាយការណ៍តារាងតុល្យការ</h3>
			<p style="text-align:center" id="dateTime">សម្រាប់ថ្ងៃ <span data-bind="text: date"></span></p>
			<table class="table" id="income">
				<thead>
					<tr>
						<th width="400">ទ្រព្យសកម្ម Assets</th>
						<th style="text-align: center">ចំនួន</th>
					</tr>
				</thead>
				<tbody data-role="listview" data-bind="source: assets" data-template="assetTmpl"></tbody>
				<tfoot>
					<tr class="info">
						<td style="text-align: right">សរុបទ្រព្យសកម្ម:</td>
						<td style="text-align: right"><strong><span data-bind="text: assetTotal"></span></strong></td>
					</tr>
				</tfoot>
			</table>

			<table class="table" id="listview">
				<thead>
					<tr>
						<th width="400">ទ្រព្យអកម្ម Liability</th>
						<th style="text-align: center">ចំនួន</th>
					</tr>
				</thead>
				<tbody data-role="listview" data-bind="source: liability" data-template="liabilityTmpl"></tbody>
				<tfoot>
					<tr>
						<td style="text-align: right">សរុបទ្រព្យអកម្ម:</td>
						<td style="text-align: right"><span data-bind="text: expenseTotal"></span></td>
					</tr>
				</tfoot>
			</table>

			<table class="table" id="listview">
				<thead>
					<tr>
						<th width="400">ទ្រព្យម្ចាស់មូលធន Equity</th>
						<th style="text-align: center">ចំនួន</th>
					</tr>
				</thead>
				<tbody data-role="listview" data-bind="source: equity" data-template="equityTmpl"></tbody>
				<tfoot>
					<tr>
						<td style="text-align: right">សរុបទ្រព្យម្ចាស់មូលធន:</td>
						<td style="text-align: right"><span data-bind="text: equityTotal"></span></td>
					</tr>
				</tfoot>
			</table>
			<table class="table">
				<tbody>
					<tr>
						<td width="400" style="text-align: right">សរុបទ្រព្យអកម្ម និង ទ្រព្យម្ចាស់មូលធន</td>
						<td style="text-align: right"><strong><span data-bind="text: net"></span></strong></td>
					</tr>
				</tbody>
			</table>
			
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
<script type="text/x-kendo-tmpl" id="assetTmpl">	
	<tr>
		<td>#=name#</td>
		<td style="text-align: right">#=kendo.toString(parseFloat(amount), 'c2')#</td>
	</tr>
</script>
<script type="text/x-kendo-tmpl" id="liabilityTmpl">	
	<tr>
		<td>#=name#</td>
		<td style="text-align: right">#=kendo.toString(parseFloat(amount), 'c2')#</td>
	</tr>
</script>
<script type="text/x-kendo-tmpl" id="equityTmpl">	
	<tr>
		<td>#=name#</td>
		<td style="text-align: right">${kendo.toString(parseFloat(amount), 'c2')}</td>
	</tr>
</script>
<script>
	var day = new Date();
	var myDate = $("#as_of_date").kendoDatePicker({
		value: new Date(),
		format: "dd-MM-yyyy",
		change: function(e) {
			var today = kendo.toString(day, 'yyyy-MM-dd');
			viewModel.set("date", kendo.toString(this.value(),'dd-MM-yyyy'));
			//viewModel.get

		}
	}).data("kendoDatePicker");
	myDate.value(day);
	var reportAging = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/reports/balance_sheet/",
				type: "GET",
				dataType: "json"
			},
			parameterMap : function(options, operation) {
				if( operation !== "read" && options.models ) {
					return { models: kendo.stringigy(options.models) };
				}
				if( operation === "read") {
					return {    //from: kendo.toString($("#as_of_date").val(), 'yyyy-MM-dd'),	
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
	var classes = $("#classes").kendoDropDownList({
	 	dataSource: classDS,
	 	dataTextField: "name",
		dataValueField: "id",
		index: 0,
		change: function(e) {
			reportAging.read();
		}
	 }).data("kendoDropDownList");
	var viewModel = kendo.observable({
		assets: [],
		liability: [],
		equity: [],
		assetTotal: 0,
		expenseTotal: 0,
		equityTotal: 0,
		net: "",
		date: function() {
			return kendo.toString(new Date(), 'dd-MM-yyyy');
		},
		get_income: function(e) {
			
			var source = reportAging.data();
			var assetTotal=0, expenseTotal=0, equityTotal=0;
			if(this.assets.length > 0) {
				this.set("incomeTotal", 0);
				this.assets.splice(0, this.assets.length);
			}
			if(this.liability.length > 0) {
				this.set("expenseTotal", 0);
				this.liability.splice(0, this.liability.length);
			}
			if(this.equity.length > 0) {
				this.set("equityTotal", 0);
				this.equity.splice(0, this.equity.length);
			}
			this.set("net", 0);
			if( source.length > 0) {
				if(source[0].asset != null) {
					for( var i = 0; i < source[0].asset.length; i++) {
						this.assets.push({
							code: source[0].asset[i].account_code, 
							name: source[0].asset[i].account_name,
							amount: source[0].asset[i].balance
						});
						assetTotal += parseFloat(source[0].asset[i].balance);
					}
				}
				
				if(source[1].liability != null) {
					for( var i = 0; i < source[1].liability.length; i++) {
						this.liability.push({
							code: source[1].liability[i].account_code, 
							name: source[1].liability[i].account_name,
							amount: source[1].liability[i].balance
						});
						expenseTotal += parseFloat(source[1].liability[i].balance)
					}	
				}
				if(source[2].equity != null) {
					for( var i = 0; i < source[2].equity.length; i++) {
						this.equity.push({
							code: source[2].equity[i].account_code, 
							name: source[2].equity[i].account_name,
							amount: source[2].equity[i].balance
						});
						equityTotal += parseFloat(source[2].equity[i].balance)
					}	
				}	
			}
			this.set("assetTotal", kendo.toString(assetTotal, "c2"));
			this.set("expenseTotal", kendo.toString(expenseTotal, "c2"));
			this.set("equityTotal", kendo.toString(equityTotal, "c2"));
			this.set("net", kendo.toString((expenseTotal+equityTotal), "c"));
		},
		refresh: function() {
			reportAging.read();
			this.get_income();
		}
	});
	kendo.bind($("#main-container"), viewModel);
	$(function() {
		reportAging.read();
		(function() {
			viewModel.refresh();
		}());
		
		
	});
</script>