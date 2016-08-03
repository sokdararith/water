<div class="container">
	
    
	<div class="row">
		<div class="span12">
	  		<?php $this->load->view("customer/toolbar_view"); ?>
	  	</div>
		<h1>កំណត់រង្វាស់ប្រព័ន្ធអគ្គីសនី</h1>
		<div class="span4">	
			<div id="gvAmpere"></div>
		</div>
        <div class="span4">	
			<div id="gvVoltage"></div>
		</div>        		
	</div>
    <br />
    <div class="row">
		<div class="span4">
        	<div id="gvPhase"></div>			
		</div>
        <div class="span4">	
			<div id="gvFuse"></div>
		</div>                
	</div>		
</div>

<script>
$(document).ready(function() {
	var baseUrl = "<?php echo base_url(); ?>app.php/";
	
	
// --- AMPERE ---
var ampereDS = new kendo.data.DataSource({
	transport: {
		read: {
			url : baseUrl + "api/electricity_unit_api/ampere",
			type: "GET",
			dataType: "json"
		},
		create: {
			url : baseUrl + "api/electricity_unit_api/ampere",
			type: "POST",
			dataType: "json"
		},
		update: {
			url : baseUrl + "api/electricity_unit_api/ampere",
			type: "PUT",
			dataType: "json"
		},
		destroy: {
			url : baseUrl + "api/electricity_unit_api/ampere",
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
	autoSync: true,	
	schema: {
		model: {
			id : "id",
			fields: {									
				ampere 	: { type: "string", validation: { required: true } }				
			}
		}		
	}	
});

$("#gvAmpere").kendoGrid({		
	dataSource: ampereDS,
	sortable: true,					
	toolbar: [{ name: "create", text: "បន្ថែម អាំងតង់សុីតេថ្មី" }],
	columns: [			
		{ field: "ampere", title: "ចំនួនអាំងតង់សុីតេ" },		
		{ command: [{ name: "destroy", text: "លុប" }], title: "&nbsp;" }],
	editable: {
         update: true, 
         destroy: true, 
         confirmation: "តើលោកអ្នក ពិតជាចង់លុបវាមែនរឺទេ?"
     }
});




// --- PHASE ---
var phaseDS = new kendo.data.DataSource({
	transport: {
		read: {
			url : baseUrl + "api/electricity_unit_api/phase",
			type: "GET",
			dataType: "json"
		},
		create: {
			url : baseUrl + "api/electricity_unit_api/phase",
			type: "POST",
			dataType: "json"
		},
		update: {
			url : baseUrl + "api/electricity_unit_api/phase",
			type: "PUT",
			dataType: "json"
		},
		destroy: {
			url : baseUrl + "api/electricity_unit_api/phase",
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
	autoSync: true,	
	schema: {
		model: {
			id : "id",
			fields: {									
				phase 	: { type: "string", validation: { required: true } }				
			}
		}		
	}	
});

$("#gvPhase").kendoGrid({		
	dataSource: phaseDS,
	sortable: true,					
	toolbar: [{ name: "create", text: "បន្ថែម ហ្វាថ្មី" }],
	columns: [			
		{ field: "phase", title: "ចំនួនហ្វា" },		
		{ command: [{ name: "destroy", text: "លុប" }], title: "&nbsp;" }],
	editable: {
         update: true, 
         destroy: true, 
         confirmation: "តើលោកអ្នក ពិតជាចង់លុបវាមែនរឺទេ?"
     }
});




// --- VOLTAGE ---
var voltageDS = new kendo.data.DataSource({
	transport: {
		read: {
			url : baseUrl + "api/electricity_unit_api/voltage",
			type: "GET",
			dataType: "json"
		},
		create: {
			url : baseUrl + "api/electricity_unit_api/voltage",
			type: "POST",
			dataType: "json"
		},
		update: {
			url : baseUrl + "api/electricity_unit_api/voltage",
			type: "PUT",
			dataType: "json"
		},
		destroy: {
			url : baseUrl + "api/electricity_unit_api/voltage",
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
	autoSync: true,	
	schema: {
		model: {
			id : "id",
			fields: {									
				voltage 	: { type: "string", validation: { required: true } }				
			}
		}		
	}	
});

$("#gvVoltage").kendoGrid({		
	dataSource: voltageDS,
	sortable: true,					
	toolbar: [{ name: "create", text: "បន្ថែម តុងស្យុងថ្មី" }],
	columns: [			
		{ field: "voltage", title: "ចំនួនតុងស្យុង" },		
		{ command: [{ name: "destroy", text: "លុប" }], title: "&nbsp;" }],
	editable: {
         update: true, 
         destroy: true, 
         confirmation: "តើលោកអ្នក ពិតជាចង់លុបវាមែនរឺទេ?"
     }
});



// --- FUSE ---
var fuseDS = new kendo.data.DataSource({
	transport: {
		read: {
			url : baseUrl + "api/electricity_unit_api/fuse",
			type: "GET",
			dataType: "json"
		},
		create: {
			url : baseUrl + "api/electricity_unit_api/fuse",
			type: "POST",
			dataType: "json"
		},
		update: {
			url : baseUrl + "api/electricity_unit_api/fuse",
			type: "PUT",
			dataType: "json"
		},
		destroy: {
			url : baseUrl + "api/electricity_unit_api/fuse",
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
	autoSync: true,	
	schema: {
		model: {
			id : "id",
			fields: {									
				fuse 	: { type: "string", validation: { required: true } }				
			}
		}		
	}	
});

$("#gvFuse").kendoGrid({		
	dataSource: fuseDS,
	sortable: true,					
	toolbar: [{ name: "create", text: "បន្ថែម កុងស្ដង់ថ្មី" }],
	columns: [			
		{ field: "fuse", title: "កុងស្ដង់" },		
		{ command: [{ name: "destroy", text: "លុប" }], title: "&nbsp;" }],
	editable: {
         update: true, 
         destroy: true, 
         confirmation: "តើលោកអ្នក ពិតជាចង់លុបវាមែនរឺទេ?"
     }
});
	
	
});
</script>