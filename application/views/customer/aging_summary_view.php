<div class="row-fluid">    
	<div class="span12">
		<div id="example" class="k-content">
			
			<div class="relativeWrap" data-toggle="source-code" style="overflow: visible;">
				<div class="widget widget-tabs widget-tabs-double widget-tabs-vertical row-fluid row-merge widget-tabs-gray">
				
					<!-- Tabs Heading -->
					<div class="widget-head span2">
						<ul>
							<li class=""><a href="<?php echo base_url('customer/customer_list'); ?>/" class="glyphicons group"><i></i>បញ្ជីអតិថិជន</a></li>
							<li class="active"><a href="<?php echo base_url('customer/aging_summary'); ?>/" class="glyphicons notes_2"><i></i> បំណុលអតិថិជន</a></li>
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
								<div>
									<input data-role="datepicker" data-bind="value: issued_date" data-format="dd-MM-yyyy" placeHolder="កាលបរិច្ឆេទ" />
									<select data-role="combobox" data-text-field="abbr" data-value-field="id" data-bind="source: companyList, value: company_id" placeHolder="អាជ្ញាបណ្ណ"></select>
									<button type="button" class="btn btn-default" data-bind="click: searchAging"><i class="icon-eye-open"></i></button>				
								</div>

								<div id="divAging">
									<div align="center">
										<h3>របាយការណ៍បំណុលអតិថិជន</h3>
										គិតត្រឹម
										<span data-bind="text: issued_date_text"></span>
									</div>
									
									<div data-role="grid" data-bind="source: agingList"
								        data-auto-bind="false" data-row-template="agingRowTemplate"
								        data-pageable="true"                  
								        data-columns='[			            
								            { title: "លេខកូដ" },
								            { title: "ឈ្មោះ" },
								            { title: "បច្ចុប្បន្ន" },	                     
								            { title: "១-៣០ថ្ងៃ" },
								            { title: "៣១-៦០ថ្ងៃ" },
								            { title: "៦១-៩០ថ្ងៃ" },
								            { title: "លើសពី ៩០ថ្ងៃ" },
								            { title: "សរុប" }                    	                    
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

<script id="agingRowTemplate" type="text/x-kendo-tmpl">		
	<tr>		
		<td>#:number#</td>
		<td>#:fullname#</td>		
		<td align="right">#:kendo.toString(kendo.parseFloat(current), 'c0')#</td>		
		<td align="right">#:kendo.toString(kendo.parseFloat(within30), 'c0')#</td>
		<td align="right">#:kendo.toString(kendo.parseFloat(within60), 'c0')#</td>
		<td align="right">#:kendo.toString(kendo.parseFloat(within90), 'c0')#</td>
		<td align="right">#:kendo.toString(kendo.parseFloat(over90), 'c0')#</td>
		<td align="right">
			#:kendo.toString(kendo.parseFloat(current) +
							kendo.parseFloat(within30) +
							kendo.parseFloat(within60) +
							kendo.parseFloat(within90) +
							kendo.parseFloat(over90), 'c0')#
		</td>					
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

var agingDS = new kendo.data.DataSource({
  	transport: {	  
	  	read: {
		  	url : ARNY.baseUrl + "api/invoices/aging_batch",
		  	type: "GET",
		  	dataType: "json"		  
	  	}
  	},
  	schema: {		
		data: "people",
		total: "total"
	},
  	serverPaging: true,  		
  	pageSize: 50,
  	serverFiltering: true  		
});
	
//View model
var viewModel = kendo.observable({
	class_id 		: null,
	issued_date 	: new Date(),

	companyList 	: companyDS,
	agingList 		: agingDS,

	issued_date_text : function(){
		return kendo.toString(this.get("issued_date"), "dd-MM-yyyy");
	},
	autoIncreaseNo 		: function(){
		$(".sno").each(function(index,element){                 
		   $(element).text(index + 1); 
		});
	},
	searchAging 	: function(){
		var para = [];

		var company_id = this.get("company_id");
		if(company_id!=null){
			para.push({
				field: "company_id", value: company_id.id
			});
		}		
		
		if(this.get("issued_date")==null){
			this.set("issued_date", new Date());
		}
		para.push({
			field: "issued_date", value: kendo.toString(this.get("issued_date"), "yyyy-MM-dd")
		});
		
		if(para.length>0){
			agingDS.filter(para);
		}					
	}	
});  
kendo.bind($("#example"), viewModel);

});//End document ready
</script>