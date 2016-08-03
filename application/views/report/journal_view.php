<div class="span12">
	<div class="hidden-print" style="margin-left: 5px;">
		<input type="text" class="date" id="startDate">-
		<input type="text" class="date" id="endDate"> 
		<input type="text" id="classes" placeholder="រើសមួយ..." value=""> 
		<button class="btn" id="search">មើលរបយាការណ៍</button>
	</div>
	<div id="detail" style="text-align:center; height: 100px;">
		<h1>របាយការណ៍ទិន្នានុប្បវត្តិ</h1>
		សម្រាប់រយពេលពី <span data-bind="text: startDate"></span> ដល់ <span data-bind="text: endDate"></span>
	</div>
	
	<table id="transactions" class="table">
		<thead>
			<td>Class</td>
			<td>ប្រភេទប្រតិបត្តិការ</td>
			<td>កាលបរិច្ឆេទ</td>
			<td>ពិពណ៍នា</td>
			<td>គណនី</td>
			<td>ឥណពន្ធ (Dr.)</td>
			<td>ឥណទាន (Cr.)</td>
		</thead>
		<tbody></tbody>
	</table>
</div>
<script type="text/x-kendo-template" id="journal">
	<tr>
		<td>#= classes.name #</td>
		<td>#: type #</td>
		<td>#: createdDate#</td>
		<td>
			# for(var i = 0; i<detail.length; i++) { # 
				#: detail[i].memo # <br>
			# } #
		</td>
		<td>
			# for(var i = 0; i<detail.length; i++) { # 
				#: detail[i].account.code # &mdash; #: detail[i].account.name # <br>
			# } #	
		</td>
		<td style="text-align: right">
			# var x = 0; #
			# for(var i = 0; i<detail.length; i++) { # 
				# if(detail[i].dr > 0.00) { #
					# x += parseFloat(detail[i].dr); #
					#:kendo.toString(parseFloat(detail[i].dr), 'c2') #
				# } # <br>
			# } #
			<div style="border-top: 1px solid black">
			<strong>#: kendo.toString(x, 'c2') #</strong>
			</div>
		</td>
		<td style="text-align: right">
			# var x = 0; #
			# for(var i = 0; i<detail.length; i++) { # 
				# if(detail[i].cr > 0.00) { #
					# x += parseFloat(detail[i].cr); #
					#:kendo.toString(parseFloat(detail[i].cr), 'c') #
				# } # <br>
			# } #
			<div style="border-top: 1px solid black">
			<strong>#: kendo.toString(x, 'c2') #</strong>
			</div>	
		</td>
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

	var start = $("#startDate").kendoDatePicker({
		value: new Date().getFullYear() +'-'+ (new Date().getMonth() + 1) +'-1',
	}).data('kendoDatePicker');
	var end = $("#endDate").kendoDatePicker({
		value: new Date(),
	}).data('kendoDatePicker');
	var classes = $("#classes").kendoDropDownList({
		 	dataSource: classDS,
		 	dataTextField: "name",
			dataValueField: "id"
		 }).data("kendoDropDownList");
	$(document).ready(function() {
		var transactionDS = new kendo.data.DataSource({
			transport: {
				read: {
					url : ARNY.baseUrl + "api/accounting_api/transaction_by",
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
					id : "transID"
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
		

		var transactionsVM = kendo.observable({
			setCurrent 		: function(id) {
				this.set("current", transactionDS.get(id));
			},
			validated 		: false,
			pageSize 		: function() {
				return transactionDS.pageSize();
			},
			skip 			: function() {
				if(transactionDS.page() === 1) {
					return 0;
				} else {
					return (transactionDS.page() * transactionDS.pageSize());
				}
			},
			errorArray		: [],
			errorCode 		: "",
			errorName 		: "",
			errorType 		: "",
			classes 		: classDS,		
			startDate		: function() {
				var date = new Date();
				var month = date.getMonth()+1;
				var year = date.getFullYear();
				return year+'-'+month+'-01';
			},
			endDate 		: function(){
				return kendo.toString(end.value(), 'dd-MM-yyyy');
			},
			searchTrans 	: function() {
				transactionDS.fetch(function(){
					var data = this.data();
					accountModel.set("transactions", data);
					var d = this.total()/this.get("limit");
					var m = this.total()%this.get("limit");

					accountModel.set("total", this.total());
				});
			},
			editBtn 		: function(e) {
				e.preventDefault();
				this.set("acCode", this.current.code);
				this.set("acName", this.current.name);
				this.set("acType", this.current.type_id);
				this.set("acDescription", this.current.description);
				this.set("acParent", this.current.parent.id);
				router.navigate("/edit", false);
			},
			deleteBtn		: function(e) {
				e.preventDefault();
				var model = accountDS.get(this.current.id);
				var ask = confirm("តើអ្នត្រូវការលុបគណនី " + model.name + " ម៉ែនទេ?");
				if(ask) {
					accountDS.remove(model);
					accountDS.sync();
				}
				
			},
			change 			: function(e) {
				this.set("selectedRow", e.sender.dataItem(e.sender.select()));
			},
			add 			: function() {
				var validated = this.validate();

				if(validated === true) {
					accountDS.add({
						code: this.get("acCode"),
						name: this.get("acName"),
						account_type_id: this.get("acType"),
						description: this.get("acDescription"),
						parent_id: this.get("acParent")
					});
					accountDS.sync();
				}
			},
			update 			: function() {
				var validated = this.validate();

				if(validated === true) {
					var model = accountDS.get(this.current.id);
					model.set("code", this.get("acCode"));
					model.set("name", this.get("acName"));
					model.set("account_type_id", this.get("acType"));
					model.set("description", this.get("acDescription"));
					model.set("parent_id", this.get("acParent"));

					accountDS.sync();
				}
			}
	 	});
		//Account grid
		kendo.bind($("#detail"), transactionsVM);
		var grid = $("#transactions > tbody").kendoListView({
			dataSource: transactionDS,	
			selectable: true,
			template: kendo.template($("#journal").html())
		}).data("kendoListView");

		$(".container").on('click', '#search', function(){
			transactionDS.query({
				filter: [{ value: start.value() }, { value: end.value() }, {value: classes.value()}]
			});
		});

	});<!--End of document.ready-->
</script>