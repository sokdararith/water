<div class="container">
	<div class="row">
		<div class="span2">Sidebar</div>
		<div class="span10">
			<div id="company-list"></div>
		</div>
	</div>
</div>
<!--template section-->
<script type="text/x-kendo-tmpl" id="template">
	<div id="companies">
		<p>Name: #=name#</p>
		<p>Year: #=year_founded#</p>
		<p>License: #=operation_license#</p>
		<p>Mobile: #=mobile#</p>
		<p>Rep: #=representative#</p>
		<a href="\\#" class="k-edit-button">Edit</a>
	</div>
</script>
<script type="text/x-kendo-tmpl" id="editTemplate">
	<div id="companies">
		<p>Name: <input type="text" data-bind="value: name"></p>
		<p>Year: <input type="text" data-bind="value: year_founded"></p>
		<p>License: #=operation_license#</p>
		<p>Mobile: <input type="text" data-bind="value: mobile"></p>
		<p>Rep: <input type="text" data-bind="value: representative"></p>
		<a href="\\#" class="k-update-button">រក្សាទុក</a>
		<button id="click">click</button>
	</div>
</script>
<!--end of template section-->

<!--script section-->
<script>
	var companyDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/settings/companies",
				type: "GET",
				dataType: "json"
			},
			create: {
				url: ARNY.baseUrl + "api/settings/companies",
				type: "POST",
				dataType: "json"
			},
			update: {
				url: ARNY.baseUrl + "api/settings/companies",
				type: "PUT",
				dataType: "json"
			},
			parameterMap: function(options, operation) {
				if(operation !== "read" && options.models) {
					return { models: kendo.stringify(options.models)};
				}
				return options;
			}
		},
		schema: {
			model: {
				id: "id",
				fields: {
					id: {editable: false, type: "number" }
				}
			}
		}
	});
	$("#editTemplate").find("#companies").find("#click").click(function(){ alert("hi")});
	$(function(){
		$("#company-list").kendoListView({
			dataSource: companyDS,
			template: kendo.template($("#template").html()),
			editTemplate: kendo.template($("#editTemplate").html())
		});
	});
</script>