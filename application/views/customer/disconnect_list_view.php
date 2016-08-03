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
							<li class=""><a href="<?php echo base_url('customer/low_consumption'); ?>/" class="glyphicons stats"><i></i>ប្រើប្រាស់អប្បបរិមា</a></li>
							<li class=""><a href="<?php echo base_url('customer/electricity_sale'); ?>/" class="glyphicons coins"><i></i>លក់អគ្គីសនី</a></li>
							<li class="active"><a href="<?php echo base_url('customer/disconnect_list'); ?>/" class="glyphicons flash"><i></i>តារាងផ្ដាច់ចរន្ត</a></li>
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
									<input data-role="numerictextbox" data-format=">= # ថ្ងៃ" data-min="1" data-bind="value: over_due_day" placeHolder="ចំនួនថ្ងៃផុតកំណត់">
									<button type="button" class="btn btn-default" data-bind="click: search"><i class="icon-eye-open"></i></button>				
								</div>

								<div id="divAging">
									<div align="center">
										<h3>តារាងផ្ដាច់ចរន្ត</h3>
										ចំនួនថ្ងៃផុតកំណត់លើសចាប់ពី  
										<span data-bind="text: over_due_day"></span> ថ្ងៃ
									</div>
									
									<div data-role="grid" data-bind="source: disconnectList"
								        data-auto-bind="false" data-row-template="disconnectRowTemplate"
								        data-pageable="true"                  
								        data-columns='[
								        	{ title: "#វិក្កយបត្រ", width: 110 },			            
								            { title: "លេខកូដ" },
								            { title: "ឈ្មោះ" },								            	                     
								            { title: "ថ្ងៃចេញវិក្កយបត្រ" },
								            { title: "ថ្ងៃផុតកំណត់" },
								            { title: "ចំនួនថ្ងលើស" },
								            { title: "ទឹកប្រាក់" },
								            { title: "ប្រាក់បង់រូច" },
								            { title: "សមតុល្យ" }			                              	                    
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

<script id="disconnectRowTemplate" type="text/x-kendo-tmpl">		
	<tr>
		<td>#:number#</td>		
		<td>#:number#</td>
		<td>#:surname# #:name#</td>				
		<td>#:kendo.toString(new Date(issued_date), 'dd-MM-yyyy')#</td>
		<td>#:kendo.toString(new Date(due_date), 'dd-MM-yyyy')#</td>
		<td align="right">#:over_due_day# ថ្ងៃ</td>
		<td align="right">#:kendo.toString(kendo.parseFloat(total_amount), 'c0')#</td>
		<td align="right">#:kendo.toString(kendo.parseFloat(total_paid), 'c0')#</td>
		<td align="right">#:kendo.toString(kendo.parseFloat(total), 'c0')#</td>							
    </tr>   
</script>


<!-- Scripts -->
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

var disconnectDS = new kendo.data.DataSource({
  	transport: {	  
	  	read: {
		  	url : ARNY.baseUrl + "api/invoices/disconnect_list",
		  	type: "GET",
		  	dataType: "json"		  
	  	}
  	},  	
  	serverFiltering: true  		
});

//View model
var viewModel = kendo.observable({
	company_id 		: 0,
	over_due_day 	: null,

	companyList 		: companyDS,
	disconnectList 	: disconnectDS,
		
	search 			: function(){
		var company_id = this.get("company_id");
		var over_due_day = this.get("over_due_day");								
		if(company_id>0 && over_due_day!=null){
			disconnectDS.filter({
				filters: [
					{ field: "over_due_day", value: this.get("over_due_day") },
					{ field: "company_id", value: this.get("company_id") }
				]
			});
		}					
	}	
});  
kendo.bind($("#example"), viewModel);

});//End document ready
</script>