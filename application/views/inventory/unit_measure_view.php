
		<div class="span12">
			<h1>រង្វាស់សន្និធិ <a href="<?php echo base_url();?>inventory/index/" class="pull-right"><i class="icon-home"></i></a></h1>
			<br>
		
			<div id="grid"></div>
		</div>		


<script>
 $(document).ready(function() {
	var baseUrl = "<?php echo base_url(); ?>/";
	
	//Unit Measure datasource
	 var unitMeasureDS = new kendo.data.DataSource({
	 transport: {
		read: {
			url : baseUrl + "api/inventory_api/unit_measure",
			type: "GET",
			dataType: "json"
		},
		create: {
			url : baseUrl + "api/inventory_api/unit_measure",
			type: "POST",
			dataType: "json",
			complete: function(e) {
						$("#grid").data("kendoGrid").dataSource.read(); 
					}
		},
		update: {
			url : baseUrl + "api/inventory_api/unit_measure",
			type: "PUT",
			dataType: "json",
			complete: function(e) {
						$("#grid").data("kendoGrid").dataSource.read(); 
					}
		},
		destroy: {
			url : baseUrl + "api/inventory_api/unit_measure",
			type: "DELETE",
			dataType: "json"
		},
		parameterMap: function(options, operation) {
            if (operation !== "read" && options.models) {
                return {models: kendo.stringify(options.models)};
            }
			
			return options;

        }
	},
	batch: false,
	schema: {
		model: {
			id : "id",
			fields: {									
				type 		: {  type: "string", validation: { required: true } },
				description : {  type: "string" }			
			}
		}		
	}
	
});

//Unit Measure grid
$("#grid").kendoGrid({		
	dataSource: unitMeasureDS,
	sortable: true,
	navigatable: true,		
	toolbar: ["create",{name:"save", text: "កត់ត្រា"}],
	columns: [			
		{ field: "type", title: "រង្វាស់សន្និធិ", width: "150px" },	
		{ field: "description", title: "ពិពណ៏នា" , width: "250px"},			
		{ command: [{ name: "destroy", text: "លុប", template:"<i class='icon-trash k-grid-delete'></i>" }], title: "&nbsp;", width: "190px" }],
	editable: true
});
	
	
});
</script>
<style scoped>
	.k-edit-cell .k-textbox{
		height: 40px;
		padding-top: 3px;
		padding-bottom: 3px;
	}
</style>