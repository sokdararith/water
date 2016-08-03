<div class="container">
	<div class="row">
		<div id="aside" class="span3">
			<?php $this->load->view('/hr/hrAside_view'); ?>
		</div>
		<div id="content" class="span9">

			<div id="cardList"></div>

		</div>
	</div>
</div><!--Container-->
<script>
$(function() {
	var baseUrl = "<?php echo base_url(); ?>";
	$(".panel").kendoPanelBar({
		expandMode: "single"
	});

	var staff	= new kendo.data.DataSource({
					transport	: {
						read	: {
							url	: baseUrl + "api/employees",
							type: "GET",
							dataType: "json"
						},
						create	: {
							url	: baseUrl + "api/employees",
							type: "POST",
							dataType: "json"
						},
						update	: {
							url	: baseUrl + "api/employees",
							type: "PUT",
							dataType: "json"
						},
						destroy : {
							url	: baseUrl + "api/employees",
							type: "DELETE",
							dataType: "json"
						},
						parameterMap : function(options, operation) {
							if( operation !== "read" && options.models ) {
								return {
									models: kendo.stringigy(options.models)
								};
							}
							return options;
						}
					},
					schema: {
						model: {
							id: "id",
							fields: {
								code				: { type: "string" },
								company_id			: { type: "number" },
								national_id			: { type: "string" },
								nationality			: { type: "string" },
								first_name			: { type: "string" },
								last_name			: { type: "string" },
								email				: { type: "string" },
								phone				: { type: "string" },
								image_url			: { type: "string" },
								dob					: { type: "date" },
								gender				: { type: "string" },
								marital_status		: { type: "string" },
								address				: { type: "string" },
								login_credential_id	: { type: "number" },
								line_manager_id		: { type: "number" },
								job_id				: { type: "number" },
								department_id		: { type: "number" },
								hired_at			: { type: "date" }
							}
						}
					}
		});
	var grid = $("#cardList").kendoGrid({
			dataSource: staff,
			pageable: true,
			toolbar: ["create", "save", "cancel"],
			columns: [
				{ title: "Staff_ID", field: "code", width: "100px" },
				{ title: "First Name", field: "first_name", width: "50px" },
				{ title: "last_name", field: "last_name", width: "200px" },
				{ title: "line_mananger", field: "line_manager_id", editor: lineMan },
				{ title: "department", field: "department_id" }
			],
			columnMenu: true,
			resizable: true,
			editable: true
	}).data("kendoGrid");

	function lineMan(container, options) {
		$('<input required data-text-field="first_name" data-value-field="id" data-bind="value:' + options.field + '"/>')
		.appendTo(container)
		.kendoComboBox({
			autoBind : false,
			dataSource: staff
		});
	}

});
</script>