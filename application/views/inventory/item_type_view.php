<div class="container">
	<div class="row">
		<div class="span8">
			<h1>ប្រភេទសន្និធិ</h1>
			<br>
		
			<div id="grid"></div>
		</div>		
	</div>	
</div>

<script>
 $(document).ready(function() {
	var baseUrl = "<?php echo base_url(); ?>/";
	
	//Item Type datasource
	 var itemTypeDS = new kendo.data.DataSource({
	 transport: {
		read: {
			url : baseUrl + "api/inventory_api/item_type",
			type: "GET",
			dataType: "json"
		},
		create: {
			url : baseUrl + "api/inventory_api/item_type",
			type: "POST",
			dataType: "json",
			complete: function(e) {
				//var obj = $.parseJSON(e.responseText);
				//alert(obj.id);
				//alert(id);
				$("#grid").data("kendoGrid").dataSource.read(); 
			}
		},
		update: {
			url : baseUrl + "api/inventory_api/item_type",
			type: "PUT",
			dataType: "json",
			complete: function(e) {
						$("#grid").data("kendoGrid").dataSource.read(); 
					}
		},
		destroy: {
			url : baseUrl + "api/inventory_api/item_type",
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
				name 		: {  type: "string", validation: { required: true } },
				description : {  type: "string" }			
			}
		}		
	}
	
});

//Item type grid
$("#grid").kendoGrid({		
	dataSource: itemTypeDS,
	sortable: true,
	navigatable: true,		
	toolbar: ["create"],
	columns: [			
		{ field: "name", title: "ប្រភេទសន្និធិ", width: "150px" },	
		{ field: "description", title: "ពិពណ៏នា" , width: "250px"},			
		{ command: ["edit", "destroy"], title: "&nbsp;", width: "190px" }],
	editable: "popup"
});
	
	
});
</script>