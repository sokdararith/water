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
							<li class="active"><a href="<?php echo base_url('customer/electricity_sale'); ?>/" class="glyphicons coins"><i></i>លក់អគ្គីសនី</a></li>
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
									<input data-role="datepicker" data-bind="value: start_date" data-format="dd-MM-yyyy" placeHolder="ចាប់ពី" />
									<input data-role="datepicker" data-bind="value: end_date" data-format="dd-MM-yyyy" placeHolder="ដល់" />				
									<button type="button" class="btn btn-default" data-bind="click: search"><i class="icon-eye-open"></i></button>				
								</div>

								<br>

								<div id="divPrint">
									<div align="center">
										<h3>របាយការណ៍លក់អគ្គីសនី</h3>					
										<span data-bind="text: date_text"></span>
									</div>
									
									<div data-role="grid" data-bind="source: electricitySaleList"
								        data-auto-bind="false" data-row-template="electricitySaleRowTemplate"
								        data-pageable="true"                  
								        data-columns='[			            
								            { title: "ត្រង់ស្វូ", width: 110 },			            
								            { title: "សកម្ម", width: 50 },
								            { title: "អសកម្ម", width: 50 },
								            { title: "បរិ.លក់អគ្គីសនី" },
								            { title: "ប្រើអប្ប.", width: 60 },
								            { title: "ទឹកប្រាក់" },						
								            { title: "ជំពាក់" },
								            { title: "បញ្ចុះតំលៃ", width: 70 },
								            { title: "ពិន័យ", width: 70 },
								            { title: "ទទួលប្រាក់" },
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

<script id="electricitySaleRowTemplate" type="text/x-kendo-tmpl">		
	<tr>		
		<td>#:transformer#</td>
		<td align="right">#:activeCustomer#</td>	
		<td align="right">#:inactiveCustomer#</td>	
		<td align="right">#:kendo.toString(total_consumption, 'n0')# kw</td>		
		<td align="right">#:minimum_usage# kw</td>
		<td align="right">#:kendo.toString(total_amount, 'c0')#</td>		
		<td align="right">#:kendo.toString(total_debt, 'c0')#</td>	
		<td align="right">#:kendo.toString(total_discount, 'c0')#</td>	
		<td align="right">#:kendo.toString(total_fine, 'c0')#</td>		
		<td align="right">#:kendo.toString(total_paid, 'c0')#</td>
		<td align="right">#:kendo.toString(total, 'c0')#</td>									
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

var electricitySaleDS = new kendo.data.DataSource({
  	transport: {	  
	  	read: {
		  	url : ARNY.baseUrl + "api/invoices/electricity_sale",
		  	type: "GET",
		  	dataType: "json"		  
	  	}
  	},  		  	
  	serverFiltering: true  		
});
	
//View model
var viewModel = kendo.observable({
	company_id 		: 0,
	start_date 		: new Date(),
	end_date		: new Date(),

	companyList 		: companyDS,
	
	electricitySaleList : electricitySaleDS,

	date_text : function(){
		var sdate = this.get("start_date");
		var edate = this.get("end_date");
		var txtDate = "";

		if(sdate!=null && edate!=null){			
			txtDate = "ចាប់ពី " + kendo.toString(sdate, "dd-MM-yyyy") + " ដល់ " + kendo.toString(edate, "dd-MM-yyyy"); 
		}

		return txtDate;
	},	
	search 	: function(){
		var company_id = this.get("company_id");
		var sdate = this.get("start_date");
		var edate = this.get("end_date");

		if(sdate==null){
			this.set("start_date", new Date());
		}
		if(edate==null){
			this.set("end_date", new Date());
		} 

		if(company_id>0){
			electricitySaleDS.filter({
				filters: [
					{ field: "start_date", value: kendo.toString(this.get("start_date"), "yyyy-MM-dd") },
					{ field: "end_date", value: kendo.toString(this.get("end_date"), "yyyy-MM-dd") },								
					{ field: "company_id", value: this.get("company_id") }
				]
			});
		}
	}	
});  
kendo.bind($("#example"), viewModel);

});//End document ready
</script>