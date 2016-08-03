<div class="row-fluid">    
	<div class="span12">
		<div id="example" class="k-content">
						
			<div class="relativeWrap" data-toggle="source-code" style="overflow: visible;">
				<div class="widget widget-tabs widget-tabs-double widget-tabs-vertical row-fluid row-merge widget-tabs-gray">
				
					<!-- Tabs Heading -->
					<div class="widget-head span2">
						<ul>
							<li class="active"><a href="<?php echo base_url('customer/customer_list'); ?>/" class="glyphicons group"><i></i>បញ្ជីអតិថិជន</a></li>
							<li class=""><a href="<?php echo base_url('customer/aging_summary'); ?>/" class="glyphicons notes_2"><i></i> បំណុលអតិថិជន</a></li>
							<li class=""><a href="<?php echo base_url('customer/low_consumption'); ?>/" class="glyphicons stats"><i></i>ប្រើប្រាស់អប្បបរិមា</a></li>
							<li class=""><a href="<?php echo base_url('customer/electricity_sale'); ?>/" class="glyphicons coins"><i></i>លក់អគ្គីសនី</a></li>
							<li class=""><a href="<?php echo base_url('customer/disconnect_list'); ?>/" class="glyphicons flash"><i></i>តារាងផ្ដាច់ចរន្ត</a></li>
						</ul>
					</div>
					<!-- // Tabs Heading END -->
					
					<div class="widget-body span10">
						<div class="tab-content">
						
							<!-- Tab content -->
							<div class="tab-pane active" id="tab1-1">								
								<h3 align="center">បញ្ជីអតិថិជន</h3>	

								<div id="top" align="right">
									<a href="#bottom">ទៅកាន់ផ្នែកខាងក្រោម &darr;</a>
								</div>

								<div>								
									<select id="company" name="company" data-role="dropdownlist" data-text-field="abbr" data-value-field="id" 
								            data-bind="source: companyList, value: company_id" data-option-label="(--- រើស អាជ្ញាប័ណ្ណ ---)"></select>

								    <select id="transformer" name="transformer" data-role="dropdownlist" data-text-field="transformer_number" data-value-field="id"
					          				data-cascade-from="company" data-bind="source: transformerList, value: transformer_id" data-auto-bind="false" 
					          				data-option-label="(--- រើស ត្រង់ស្វូ ---)"></select>	

									<button type="button" class="btn btn-default" data-bind="click: searchCustomer"><i class="icon-search"></i></button>
								</div>

								<div id="grid"></div>			

								<br>

							    <div id="bottom" align="right">
									<a href="#top">ទៅកាន់ផ្នែកខាងលើ &uarr;</a>
								</div>								
							</div>
							<!-- // Tab content END -->							
							
						</div>						
					</div>

				</div>
			</div>
		</div> <!--end div example-->   
	</div>
</div>

<script>
$(document).ready(function() {

//DataSources
var customerDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/people_api/people_list",
			type: "GET",
			dataType: "json"
		}
	},
	schema: {
        data: "customers", 
        total: "total" 
    },
	serverPaging: true,
	pageSize: 200,			
	serverFiltering: true
});

var companyDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/companies/company",
			type: "GET",
			dataType: "json"
		}
	}		
});

var transformerDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/electricities/transformer_cascading",
			type: "GET",
			dataType: "json"
		}
	},	
	serverFiltering: true
});

$("#grid").kendoGrid({
    dataSource: customerDS,
    groupable: true,
    autoBind: false,
    pageable: true,        
    columns: [ 
    		{ field: "number", title: "លេខកូដ" }, 
    		{ field: "fullname", title: "ឈ្មោះ" }, 
    		{ field: "amperes.ampere", title: "អំពែ" },    		
    		{ field: "people_types.name", title: "ប្រភេទ" },
    		{ field: "classes.name", title: "អាជ្ញាបណ្ណ" },
    		{ field: "balance", title: "សមតុល្យចុងគ្រា", template: "#=kendo.toString(kendo.parseFloat(balance), 'c0')#", 
    			attributes: { style: "text-align: right;"} 
    		}        
    ]
});	

//View model
var viewModel = kendo.observable({
	company_id 		: 0,

	companyList 	: companyDS,
	transformerList : transformerDS,

	searchCustomer 	: function(){		
		var company_id = this.get("company_id");
		if(company_id>0){
			var transformer_id = this.get("transformer_id");
			
			if(transformer_id!=null){
				customerDS.filter({
					filters: [
						{ field: "transformer_id", value: transformer_id.id },
						{ field: "status", value: 1 }				
					]
				});
			}else{
				customerDS.filter({
					filters: [
						{ field: "company_id", value: company_id },
						{ field: "status", value: 1 }				
					]
				});
			}			
		}		
	}	
});  
kendo.bind($("#example"), viewModel);

});//End document ready
</script>