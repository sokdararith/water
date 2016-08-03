<div class="container">
	<div class="row">
		<div id="content" class="span12">
			<?php $this->load->view('hr/toolbar'); ?>
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
				}
			}
	});

	var credentials = new kendo.data.DataSource({
			transport	: {
				read	: {
					url	: baseUrl + "api/credentials",
					type: "GET",
					dataType: "json"
				},
				create	: {
					url	: baseUrl + "api/credentials",
					type: "POST",
					dataType: "json"
				},
				update	: {
					url	: baseUrl + "api/credentials",
					type: "PUT",
					dataType: "json"
				},
				destroy : {
					url	: baseUrl + "api/credentials",
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
			pageSize: 10,
			schema: {
				model: {
					id: "id",
					fields: {
						id: {editable: false},
						staff_id: {editable: true, nullable: true },
						role_id: {editable: true, nullable: true, type: "string"},
						username: {editable: true, type: "string"},
						password: {editable: true, type: "password"}
					}
				}
			}
	});
	var grid = $("#cardList").kendoGrid({
			dataSource: credentials,
			pageable: true,
			toolbar: ["create", "save", "cancel"],
			columns: [
				{ title: "Assign To", field: "staff_id", editor: staffList, width: "150px" },
				{ title: "role", field: "role_id", width: "50px" },
				{ title: "username", field: "username", width: "200px" },
				{ title: "password", type: "password", field: "password", hidden: false }
			],
			columnMenu: true,
			resizable: true,
			editable: true
	}).data("kendoGrid");

	function staffList(container, options) {
		$('<input required data-text-field="first_name" data-value-field="id" data-bind="value:' + options.field + '"/>')
		.appendTo(container)
		.kendoComboBox({
			autoBind : false,
			dataSource: staff
		});
	}
});

</script>