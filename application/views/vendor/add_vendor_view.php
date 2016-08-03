<div class="row-fluid">
	<div class="span12">
		<div id="example" class="k-content">
			<?php $this->load->view('vendor/toolbar_view'); ?>
						
			<div class="box-generic">			    	            
	            <table width="100%" cellpadding="5" cellspacing="5">
	            	<tr>
	            		<td>អាជ្ញាបណ្ណ <span style="color:red">*</span></td>
	              		<td><select id="company" name="company" data-role="dropdownlist" data-text-field="abbr" data-value-field="id" 
	              					data-bind="source: companyList, value: company_id" data-option-label="(--- ជ្រើសរើស ---)"
	              					required data-required-msg="ត្រូវការ អាជ្ញាបណ្ណ"></select></td>
	            	</tr>
	            	<tr>
	            		<td>ថ្ងៃចុះឈ្មោះ <span style="color:red">*</span></td>
		              	<td><input id="registered_date" name="registered_date" data-role="datepicker" data-bind="value: registered_date" data-format="dd-MM-yyyy" required data-required-msg="ត្រូវការ ថ្ងៃចុះឈ្មោះ" /></td>				            
	            	</tr>
	            	<tr>
	            		<td>លេខកូដ <span style="color:red">*</span></td>
		              	<td>
		              		<input id="customer_no" name="customer_no" class="k-textbox" data-bind="value: customer_no, events: { change: checkExistingNumber }" required data-required-msg="ត្រូវការ លេខកូដ" />
		              		<span data-bind="text: msgCustomerNo" style="color: red;"></span>
		              	</td>
	            	</tr>
	            	<tr>
		              	<td>ឈ្មោះ <span style="color:red">*</span></td>
		              	<td><input id="name" name="name" class="k-textbox" data-bind="value: name" required data-required-msg="ត្រូវការ នាម" /></td>
		            </tr>
	            	<tr> 	
		              	<td>ប្រភេទអ្នកផ្គត់ផ្គង់ <span style="color:red">*</span></td>
		              	<td><select id="customerType" name="customerType" data-role="dropdownlist" data-text-field="name" data-value-field="id" 
		                			data-bind="source: customerTypeList, value: people_type_id" data-option-label="(--- ជ្រើសរើស ---)"
		                			required data-required-msg="ត្រូវការ ប្រភេទអតិថិជន"></select></td>
		            </tr>
	            	<tr>
		              	<td>លេខទូរស័ព្ទ</td>
		              	<td><input id="phone" class="k-textbox" data-bind="value: phone" /></td>
					</tr>
	            	<tr>	
						<td>អីុម៉ែល</td>
		              	<td><input name="email" id="email" type="email" data-bind="value: email" placeholder="e.g. name@email.com" style="width: 150px" data-email-msg="អីុម៉ែលនេះមិនត្រឹមត្រូវទេ" /></td>			              					              	
		            </tr>
	            	<tr>
		              	<td>លេខគណនី</td>
		              	<td><input id="bank_account" class="k-textbox" data-bind="value: bank_account" /></td>
		            </tr>
		            <tr>  	
		              	<td>latitute</td>
		              	<td><input data-role="numerictextbox" data-bind="value: latitute"></td>				              	
		            </tr>	            	
	            	<tr>  	
		              	<td>longtitute</td>
		              	<td><input data-role="numerictextbox" data-bind="value: longtitute"></td>				              	
		            </tr>
		            <tr>
		              	<td>zip code:</td>
		              	<td><input id="zipcode" class="k-textbox" data-bind="value: zip_code" /></td>
		            </tr>
	            	<tr valign="top">		            
		              	<td>អាសយដ្ឋាន</td>
		              	<td><textarea name="address" id="address" cols="" rows="2" data-bind="value: address"></textarea></td>				            			              	
		            </tr>
		            <tr valign="top">
		              	<td>អាស័យដ្ឋានដឹកជញ្ជូន</td>
		              	<td><textarea name="shiptTo" id="shiptTo" cols="" rows="2" data-bind="value: ship_to"></textarea></td>
		            </tr>	            	
		        </table>			    
			</div>	             	
	      
	      	<div>
	      		<div class="status"></div>	      	 
	          	<button id="add" class="btn btn-primary" data-bind="click: btnAddCustomerClick"><i class="icon-hdd icon-white"></i> កត់ត្រា</button>                                         
	      	</div>	

      	</div> <!--End div example-->
	</div>
</div>

<script>
$(document).ready(function() {

//DataSources
var peopleDS = new kendo.data.DataSource({
	transport: {
		create: {
			url: ARNY.baseUrl + "api/people_api/people",
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
	}	
});

var customerTypeDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/people_api/people_type",
			type: "GET",
			dataType: "json"
		}
	},
	serverFiltering: true,				
	filter: { field: "parent_id", value: 2 } //vendor type id is 2
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

//View model
var viewModel = kendo.observable({	
	people_type_id	: 0,
	
	name			: "",	
	phone			: "",
	email			: "",	
	
	memo			: "",			
	bank_account	: "",
		
	address			: "",
	zip_code 		: "",
		
	latitute 		: "",
	longtitute 		: "",
		
	status			: 1, //Active		
	registered_date	: new Date(),
	company_id 		: 0,

	isExistingNumber: false,			
			
	customerTypeList: customerTypeDS,
	companyList		: companyDS,
	
	checkExistingNumber : function(){
		var customerNo = this.get("customer_no");
		if(customerNo.length>4){
			$.ajax({
				type: "GET",
	            url : ARNY.baseUrl + "api/people_api/check_existing_customer_no",	            
	            data: {
					customer_no	: customerNo				
				},
				dataType: "json",
	            success : function(response){
	            	viewModel.set("isExistingNumber", response);
	                if(response){	                	
	                	viewModel.set("msgCustomerNo", "លេខកូដនេះបានប្រើប្រាស់រូចហើយ");
	                }else{	                	
	                	viewModel.set("msgCustomerNo", "");
	                }
	            }
	        });
        }
	},
	btnAddCustomerClick : function(e){
		e.preventDefault();
        if(validator.validate() && this.get("isExistingNumber")==false){
        	this.addCustomer();
            status.text("កត់ត្រាបានសំរេច")
	            .removeClass("alert alert-error")
	            .addClass("alert alert-success");
        }else{
            status.text("សូមត្រួតពិនិត្រឪ្យបានត្រឹមត្រូវម្ដងទៀត")
                .removeClass("alert alert-success")
	            .addClass("alert alert-error");
        }
	},	
	addCustomer		: function(){
		peopleDS.add({
			people_type_id	: this.get("people_type_id"),
			customer_no     : this.get("customer_no"),			
			name			: this.get("name"),			
			phone			: this.get("phone"),	
			email			: this.get("email"),	
						
			memo			: this.get("memo"),				
			bank_account	: this.get("bank_account"),
			zip_code 		: this.get("zip_code"),
			address 		: this.get("address"),
			ship_to 		: this.get("ship_to"),			

			latitute 		: this.get("latitute"),	
			longtitute 		: this.get("longtitute"),			
			
			status			: this.get("status"),					
			registered_date	: kendo.toString(new Date(this.get("registered_date")), "yyyy-MM-dd"),
			company_id 		: this.get("company_id")			
		});
		
		peopleDS.sync();		
	}	
});  
kendo.bind($("#example"), viewModel);

var validator = $("#example").kendoValidator().data("kendoValidator"),
                    status = $(".status");

});//End document ready
</script>