<div class="container">
	<div class="row">
		<div class="span2">Sidebar</div>
		<div class="span10">
			<div id="configList"></div>
		</div>
	</div>
</div>

<script>
var baseUrl 	= "<?php echo base_url(); ?>";
var configList	= new kendo.data.DataSource({
		transport	: {
			read	: {
				url	: baseUrl + "api/settings/config",
				type: "GET",
				dataType: "json"
			},
			create	: {
				url	: baseUrl + "api/settings/config",
				type: "POST",
				dataType: "json"
			},
			update	: {
				url	: baseUrl + "api/settings/config",
				type: "PUT",
				dataType: "json"
			},
			destroy : {
				url	: baseUrl + "api/settings/config",
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
		pageSize: 20,
		schema: {
			model: {
				id: "id",
				fields: {
					id: { editable: false, type: "number"},
					code: { type: "string" },
					name: { type: "string" },
					fiscal_year: { format: "{0:'yyyy-MM-dd"}
				}
			}
		}
});
$(function(){
	var list = $("#configList").kendoListView({
		dataSource: configList,
		template: kendo.template($("#configTmpl").html()),
		editTemplate: kendo.template($("#editConfigTmpl").html())
	}).data("kendoListView");
});

</script>
<script type="text/x-kendo-tmpl" id="configTmpl">
	<div class="config">
		<p>Name: #=name#</p>
		<p>Fiscal Year: #=fiscal_year#</p>
		<p>Base Currency: #=based_currency#</p>
		<div class="edit-buttons">
			<a class="k-button-icontext k-edit-button" href="\\#"><span class="k-icon k-edit"></span></a>
	    </div>
	</div>
</script>
<script type="text/x-kendo-template" id="editConfigTmpl">
	<div class="config">
		<label for="name">Name</label>
		<input type="text" name="name" data-bind="value: name">
		<label for="fiscal">Fiscal Year</label>
		<input type="text" name="fiscal" data-bind="value: fiscal_year" data-type="date" data-role="datepicker">
		<p>Base Currency: #=based_currency#</p>
		<div class="edit-buttons">
            <a class="k-button-icontext k-update-button" href="\\#"><span class="k-icon k-update"></span></a>
            <a class="k-button-icontext k-cancel-button" href="\\#"><span class="k-icon k-cancel"></span></a>
        </div>
	</div>
</script>