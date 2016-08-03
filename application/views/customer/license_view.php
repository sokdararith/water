<div class="row-fluid">    
	<div class="span12">
		<div id="example" class="k-content">
			
			<div class="relativeWrap" data-toggle="source-code" style="overflow: visible;">
				<div class="widget widget-tabs widget-tabs-double widget-tabs-vertical row-fluid row-merge widget-tabs-gray">
				
					<!-- Tabs Heading -->
					<div class="widget-head span2">
						<?php $this->load->view('customer/settingbar'); ?>
					</div>
					<!-- // Tabs Heading END -->
					
					<div class="widget-body span10">
						<div class="tab-content">						
							<!-- Tab content -->
							<div class="tab-pane active" id="tab1-1">								
								<div id="divCustomerType">
									<h3>អាជ្ញាប័ណ្ណ</h3>

									<div id="grid"></div>
								</div>						
							</div>
							<!-- // Tab content END -->							
						</div>						
					</div>

				</div>
			</div>			

		</div> <!--end div example-->            
	</div> <!--End div span12-->		
</div> <!--End div row-fluid-->
	

<script>
$(document).ready(function() {
		
//Datasource
var classDS = new kendo.data.DataSource({
	transport: {
		read: {
			url : ARNY.baseUrl + "api/classes/class",
			type: "GET",
			dataType: "json"
		},
		create: {
			url : ARNY.baseUrl + "api/classes/class",
			type: "POST",
			dataType: "json"
		},
		update: {
			url : ARNY.baseUrl + "api/classes/class",
			type: "PUT",
			dataType: "json"
		},
		destroy: {
			url : ARNY.baseUrl + "api/classes/class",
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
	requestEnd: function(e) {
	    var response = e.response;
	    var type = e.type;
	    if(type!='read'){
	    	classDS.read();
	    }
	},	
	schema: {
		model: {
			id: "id",
            fields: {
                id      	: { editable: false, nullable: true },                
                name 		: { type: "string", validation: { required: true } },
                description : { type: "string" },
                type 		: { type: "string", defaultValue: "Class" }                               
            }
		}
	},
	filter: { field: "type", value: "Class" },
	serverFiltering: true
});

//Grid
$("#grid").kendoGrid({		
	dataSource: classDS,		
	toolbar: ["create"],	
	columns: [			
		{ field: "name", title: "អាជ្ញាប័ណ្ណ" },
		{ field: "description", title: "ពណ៌នា" },			
		{ command: ["edit", "destroy"], title: "&nbsp;", width: "210px" }],
	editable: "popup"
});
	
});
</script>