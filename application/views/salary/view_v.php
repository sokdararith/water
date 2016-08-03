<div class="container">
	<div class="row">
		<div class="span12">
			<?php $this->load->view('hr/toolbar'); ?>
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
					staff 			: { editable: true , nullable: false, validation: {required: true} },
					gross_salary	: { editable: true, nullable: false, type: "number", validation: {required: true}},
					dependents		: { editalbe: true, nullable: true, type: "number" },
					benefit 		: { editable: true, nullable: true, type: "number" }
				}
			}
		},
		pageSize: 20
});

	jQuery(document).ready(function($) {
		// Stuff to do as soon as the DOM is ready;
		$("#salary").kendoGrid({
			dataSource: salaries,
			toolbar: [
				{ name:"create", text: "ថែមថ្មី"}, 
				{ name:"save", text:"កតត្រាទុក"}, 
				{ name:"cancel", text: "មោឃះ"}
			],
			columns: [
				{ title: "បុគ្គលិក", field: "staff", template: "#=staff.first_name# #=staff.last_name#", editor: employeeDDE },
				{ title: "ប្រាក់ខែ", field: "gross_salary", format: "{0:c}" },
				{ title: "ក្រោមបន្ទុក", field: "dependents" },
				{ title: "Benefit", field: "benefit" },
				{ title: "&nbsp;"}
			],
			pageable: true,
			height: "500px",
			editable: true
		}).data("kendoGrid");
	});
	function employeeDDE(container, options) {
        $('<input data-text-field="first_name" data-value-field="id" data-bind="value:' + options.field + '"/>')
            .appendTo(container)
            .kendoComboBox({
                autoBind: false,
                dataSource: {
                    type: "json",
                    transport: {
                        read: baseUrl + "employees"
                    }
                }
            });
    }
</script>