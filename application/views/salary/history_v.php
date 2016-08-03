<div class="container">
	<div class="row">
		<div class="span12">
			<div id="salary"></div>
		</div>
	</div>
</div>
<script>
	var baseUrl = "<?php echo base_url(); ?>api/";
	var salaries 	= new kendo.data.DataSource({
		transport	: {
			create	: {
				url	: baseUrl + "salaries/index",
				type: "POST",
				dataType: "json"
			},
			read	: {
				url	: baseUrl + "salaries/index",
				type: "GET",
				dataType: "json"
			},
			update	: {
				url	: baseUrl + "salaries/index",
				type: "PUT",
				dataType: "json"
			},
			destroy	: {
				url	: baseUrl + "salaries/index",
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
					id 				: { editable: false },
					staff 			: { editable: false }
				}
			}
		}
});

	jQuery(document).ready(function($) {
		// Stuff to do as soon as the DOM is ready;
		$("#salary").kendoGrid({
			dataSource: salaries,
			columns: [
				{ title: "បុគ្គលិក", field: "staff.firstname", template:'<a href="<?php echo base_url(); ?>/">#=staff.last_name# #=staff.first_name#</a>' },
				{ title: "ប្រាក់ខែ", field: "gross_salary" },
				{ title: "ពន្ធ", field: "tax" },
				{ title: "Benefit", field: "benefit" },
				{ title: "Net", field: "net" }
			]
		}).data("kendoGrid");
	});
</script>