<div class="row-fluid">    
	<div class="span12">
		<div id="example" class="k-content">
			
			<div class="relativeWrap" data-toggle="source-code" style="overflow: visible;">
				<div class="widget widget-tabs widget-tabs-double widget-tabs-vertical row-fluid row-merge widget-tabs-gray">
				
					<!-- Tabs Heading -->
					<div class="widget-head span2">
						<ul>
							<li class=""><a href="<?php echo base_url('customer/customer_list'); ?>/" class="glyphicons group"><i></i>បញ្ជីអតិថិជន</a></li>
							<li class=""><a href="<?php echo base_url('customer/aging_summary'); ?>/" class="glyphicons notes_2"><i></i> បំណុលអតិថិជន</a></li>
							<li class="active"><a href="<?php echo base_url('customer/low_consumption'); ?>/" class="glyphicons stats"><i></i>ប្រើប្រាស់អប្បបរិមា</a></li>
							<li class=""><a href="<?php echo base_url('customer/electricity_sale'); ?>/" class="glyphicons coins"><i></i>លក់អគ្គីសនី</a></li>
							<li class=""><a href="<?php echo base_url('customer/disconnect_list'); ?>/" class="glyphicons flash"><i></i>តារាងផ្ដាច់ចរន្ត</a></li>
						</ul>
					</div>
					<!-- // Tabs Heading END -->
					
					<div class="widget-body span10">
						<div class="tab-content">						
							<!-- Tab content -->
							<div class="tab-pane active" id="tab1-1">								
								<div>
									<select id="company" name="company" data-role="dropdownlist" data-text-field="abbr" data-value-field="id" 
								            data-bind="source: companyList, value: company_id" data-option-label="(--- រើស អាជ្ញាប័ណ្ណ ---)"></select>

								    <select id="transformer" name="transformer" data-role="dropdownlist" data-text-field="transformer_number" data-value-field="id"
					          				data-cascade-from="company" data-bind="source: transformerList, value: transformer_id" data-auto-bind="false" 
					          				data-option-label="(--- រើស ត្រង់ស្វូ ---)"></select>
									
									<input data-role="datepicker" data-bind="value: reading_date" data-format="dd-MM-yyyy" placeHolder="កាលបរិច្ឆេទ" />
									<input data-role="numerictextbox" data-format="<= # kw" data-min="0" data-bind="value: usage" placeHolder="ថាមពល">
									<button type="button" class="btn btn-default" data-bind="click: search"><i class="icon-eye-open"></i></button>				
								</div>

								<br>

								<div id="divConsumption">
									<div align="center">
										<h3>របាយការណ៍អតិថិជនប្រើប្រាស់ថាមពលជាអប្បបរិមា</h3>
										គិតត្រឹម
										<span data-bind="text: reading_date_text"></span>
									</div>
									
									<div data-role="grid" data-bind="source: consumptionList"
								        data-auto-bind="false" data-row-template="consumptionRowTemplate"
								        data-pageable="true"                  
								        data-columns='[			            
								            { title: "លេខកូដ" },
								            { title: "ឈ្មោះ" },
								            { title: "កុងទ័រ" },
								            { title: "៣ ខែមុន" }	,
								            { title: "២ ខែមុន" },
								            { title: "១ ខែមុន" },
								            { title: "បច្ចុប្បន្ន" }			            		                             	                    
								        ]'>
									</div>				

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

<script id="consumptionRowTemplate" type="text/x-kendo-tmpl">		
	<tr>		
		<td>#:customers.number#</td>
		<td>#:customers.surname# #:customers.name#</td>	
		<td>#:meter#</td>	
		<td align="right">#:month3#</td>		
		<td align="right">#:month2#</td>
		<td align="right">#:month1#</td>
		<td align="right">#:current#</td>							
    </tr>   
</script>

<script>
$(document).ready(function() {
//DataSource
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

var consumptionDS = new kendo.data.DataSource({
  	transport: {	  
	  	read: {
		  	url : ARNY.baseUrl + "api/meter_records/low_consumption",
		  	type: "GET",
		  	dataType: "json"		  
	  	}
  	},  		  	
  	serverFiltering: true  		
});
	
//View model
var viewModel = kendo.observable({
	company_id 		: 0,
	transformer_id 	: 0,
	reading_date 	: new Date(),

	usage 			: 5,

	companyList 		: companyDS,
	transformerList : transformerDS,
	consumptionList : consumptionDS,

	reading_date_text : function(){
		return kendo.toString(this.get("reading_date"), "dd-MM-yyyy");
	},	
	search 	: function(){
		var readingDate = this.get("reading_date");
		if(readingDate==null){
			this.set("reading_date", new Date());
		}

		var transformer_id = this.get("transformer_id");
		if(transformer_id>0){
			consumptionDS.filter({
				filters: [
					{ field: "reading_date", value: kendo.toString(this.get("reading_date"), "yyyy-MM-dd") },
					{ field: "usage", value: this.get("usage") },				
					{ field: "transformer_id", value: this.get("transformer_id") }
				]
			});
		}
	}	
});  
kendo.bind($("#example"), viewModel);

});//End document ready
</script>