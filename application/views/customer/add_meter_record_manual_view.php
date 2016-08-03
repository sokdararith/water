<div class="row-fluid">    
	<div class="span12">
		<div id="example" class="k-content">
						
			<div>
				<input id="meterNo" type="text" data-bind="value: meter_no" placeholder="លេខកុងទ័រ" > 
				<button id="btnSearch" type="button" class="btn btn-default" data-bind="click: search"><i class="icon-search"></i></button>
			</div>
						
			<table cellpadding="5" cellspacing="5">
                <tr>
                  	<td>អតិថិជន</td>
                  	<td><span data-bind="text: meter.id"></span></td>                  	
                </tr>                
                <tr>
                  	<td>លេខកូដកុងទ័រ</td>                    
                  	<td><span data-bind="text: meter.meter_no"></span></td>
                </tr>                
                <tr>                             
                  	<td>ប្រអប់</td>	                  	
                  	<td><span data-bind="text: meter.electricity_boxes.box_no"></span></td>                                    
                </tr>                
          	</table>

          	<div id="meterRecord" data-role="grid" data-bind="source: readingList"
	            data-row-template="readingRowTemplate" data-pageable="true" 
	            data-auto-bind="false"                
	            data-columns='[{ "title": "ប្រចាំខែ", width: 100 }, 
	                    { "title": "អំនានចាស់ R"}, 
	                    { "title": "អំនានថ្មី R" }, 
	                    { "title": "ជំុថ្មីR" },
	                    { "title": "អំនានចាស់" },
	                    { "title": "អំនានថ្មី" },
	                    { "title": "ជំុថ្មី" }]'>
			</div> 

		</div> <!--end div example-->            
	</div> <!--End div span12-->		
</div> <!--End div row-fluid-->

<script id="readingRowTemplate" type="text/x-kendo-template">	
	<tr>
		<td>#:kendo.toString(new Date(month_of), "dd-MM-yyyy")#</td>
		<td>#:reactive_prev_reading#</td>
		<td>#:reactive_new_reading#</td>
		<td><input type="checkbox" #: new_round==1 ? checked="checked" : "" # disabled="disabled" /></td>
		<td>#:prev_reading#</td>
		<td>#:new_reading#</td>
		<td><input type="checkbox" #: reactive_new_round==1 ? checked="checked" : "" # disabled="disabled" /></td>							
	</tr>
</script>

<script>
$(document).ready(function() {		
//Datasource
var meterDS = new kendo.data.DataSource({
	transport: {
		read: {
			url : ARNY.baseUrl + "api/meters/meter",
			type: "GET",
			dataType: "json"
		}
	},
	requestEnd: function(e) {
	    var response = e.response;
	    var type = e.type;
	    if(type==='read'){
	    	if(response.length>0){
	    		viewModel.set("meter", response[0]);
	    		viewModel.loadReading(response[0].id);
	    	}else{
	    		viewModel.set("meter", null);
	    		viewModel.clearReading();
	    	}	    	
	    }
	},	
	serverFiltering: true	
});

var meterRecordDS = new kendo.data.DataSource({
	transport: {
		read: {
			url : ARNY.baseUrl + "api/meter_records/meter_record",
			type: "GET",
			dataType: "json"
		},
		create: {
			url : ARNY.baseUrl + "api/meter_records/meter_record",
			type: "POST",
			dataType: "json"
		},		
		parameterMap: function(options, operation) {
		  	if (operation !== "read" && options.models) {			  
			  	return {models: kendo.stringify(options.models)};
		  	}		  
		  	return options;  
	  	}
	},		
	schema: {
		model: {
			id: "id"
		}
	},			
	serverFiltering: true
});

//View model
var viewModel = kendo.observable({	
	meter_no 	: "512095",
	meter 		: null,

	readingList : meterRecordDS,

	search 		: function(){
		var meter_no = this.get("meter_no");
		meterDS.filter({ field: "meter_no", value: meter_no });		
	},
	loadReading : function(meter_id){		
		meterRecordDS.filter({ field: "meter_id", value: 1 });
	},
	clearReading : function(){		
		for (var i=0; i< meterRecordDS.total(); i++) {
			var dataItem = meterRecordDS.at(i);
  			meterRecordDS.remove(dataItem);
		}
	}	
});  
kendo.bind($("#example"), viewModel);
	
});//End document ready
</script>