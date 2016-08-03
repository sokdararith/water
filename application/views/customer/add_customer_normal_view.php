<div class="row-fluid">
	<div class="span12">
		<div id="example" class="k-content">

			<h1><i class="icon-spinner icon-spin icon-large"></i> ចុះឈ្មោះអតិថិជនថ្មី <span>អតិថិជនធម្មតា</span></h1>
			
			<div class="widget widget-tabs widget-tabs-gray widget-tabs-vertical row-fluid row-merge margin-none widget-body-white">
	
				<!-- Widget heading -->
				<div class="widget-head span2">
					<ul>						
						<li><a class="glyphicons electricity" href="<?php echo base_url(); ?>customer/add_customer/"><i></i>អតិថិជនអគ្គីសនី</a></li>	
						<li class="active"><a class="glyphicons user" href="#normal-customer" data-toggle="tab"><i></i>អតិថិជនធម្មតា</a></li>						
					</ul>
				</div>
				<!-- // Widget heading END -->
				
				<div class="widget-body span10">
					<div class="tab-content">
						
						<!-- // CUSTOMER -->
						<div class="tab-pane active" id="electricity-customer">						
							
							<div class="row-fluid">									
								<div class="span2">
			              			<label for="number">លេខកូដ <span style="color:red">*</span></label>
			              			<input id="number" name="number" class="k-textbox" 
				              				data-bind="value: number, events: { change: checkExistingNumber }" 
				              				placeholder="e.g. AB0001" required data-required-msg="ត្រូវការ លេខកូដ" />
				              		<span data-bind="text: msgCustomerNo" style="color: red;"></span>			              		
			              		</div>
			              		<div class="span2">
				              		<label for="surname">គោត្តនាម <span style="color:red">*</span></label>
				              		<input id="surname" name="surname" class="k-textbox" data-bind="value: surname" 
						              		placeholder="ត្រកូល" required data-required-msg="ត្រូវការ គោត្តនាម" />								
								</div>
								<div class="span2">
						            <label for="name">នាម <span style="color:red">*</span></label>
						            <input id="name" name="name" class="k-textbox" data-bind="value: name" 
						              		placeholder="ឈ្មោះ" required data-required-msg="ត្រូវការ នាម" />
					            </div>
					            <div class="span2">
					            	<label for="customerType">ប្រភេទអតិថិជន <span style="color:red">*</span></label>
						            <select id="customerType" name="customerType" data-role="dropdownlist" data-text-field="name" data-value-field="id" 
				                			data-bind="source: customerTypeList, value: people_type_id" data-option-label="(--- ជ្រើសរើស ---)"
				                			required data-required-msg="ត្រូវការ ប្រភេទអតិថិជន"></select>
					            </div>
					            <div class="span2">
					            	<label for="registered_date">ថ្ងៃចុះឈ្មោះ <span style="color:red">*</span></label>
						            <input id="registered_date" name="registered_date" data-role="datepicker" 
			            					data-bind="value: registered_date" data-format="dd-MM-yyyy" 
			            					placeholder="ថ្ងែ-ខែ-ឆ្នាំ" required data-required-msg="ត្រូវការ ថ្ងៃចុះឈ្មោះ" />
					            </div>															
							</div>

							<div class="separator line bottom"></div>									
							
							<div class="row-fluid">
								<div class="span2">
			            			<label for="company">អាជ្ញាបណ្ណ <span style="color:red">*</span></label>									 
									<select id="company" name="company" data-role="dropdownlist" data-text-field="abbr" data-value-field="id" 
			              					data-bind="source: companyList, value: company_id, events:{ change: change}" data-option-label="(--- ជ្រើសរើស ---)"
			              					required data-required-msg="ត្រូវការ អាជ្ញាបណ្ណ"></select>										
			              		</div>
					            <div class="span2">
						            <label for="currencyCBB">រូបិយ​ប័ណ្ណ <span style="color:red">*</span></label>
						            <input id="currencyCBB" name="currencyCBB" data-bind="value: currency_code" placeholder="(--- ជ្រើសរើស ---)" 
						            		required data-required-msg="ត្រូវការ រូបិយ​ប័ណ្ណ"/>
						        </div>
					            <div class="span2">
						            <label for="ar">គណនីអតិថិជន <span style="color:red">*</span></label>
						            <select id="ar" name="ar" data-role="dropdownlist" data-text-field="name" data-value-field="id" 
				            				data-bind="source: accountList, value: account_receiveable_id" data-option-label="(--- ជ្រើសរើស ---)"
				            				required data-required-msg="ត្រូវការ គណនីចំណូល"></select>
				            	</div>
					            <div class="span2">
						            <label for="revenueAccount">គណនីចំណូល <span style="color:red">*</span></label>
						            <select id="revenueAccount" name="revenueAccount" data-role="dropdownlist" data-text-field="name" data-value-field="id" 
				            				data-bind="source: revenueAccountList, value: revenue_account_id" data-option-label="(--- ជ្រើសរើស ---)"
				            				required data-required-msg="ត្រូវការ គណនីចំណូល"></select>
			            		</div>
			            		<div class="span2">
			            			<label for="vatNo">លេខ VAT</label>
			            			<div class="input-prepend">
										<span class="add-on glyphicons vimeo"><i></i></span>
										<input type="text" id="vatNo" class="input-large" data-bind="value: vat_no" 
												placeholder="e.g. 01234567897" style="width:120px">
									</div>
			            		</div>
							</div>												
							
							<!-- // Inner Tabs -->
							<div class="row-fluid">								
								<div class="box-generic">
								    <!-- Tabs Heading -->
								    <div class="tabsbar tabsbar-2">
								        <ul class="row-fluid row-merge">								            
								            <li class="span3 glyphicons home active"><a href="#tab2-4" data-toggle="tab"><i></i> <span>អាសយដ្ឋាន</span></a>
								            </li>
								            <li class="span3 glyphicons circle_info"><a href="#tab3-4" data-toggle="tab"><i></i> <span>ពត័មានផ្សេងៗ</span></a>
								            </li>								            
								        </ul>
								    </div>
								    <!-- // Tabs Heading END -->

								    <div class="tab-content">								        

								        <!-- ADDRESS Tab content -->
								        <div class="tab-pane active" id="tab2-4">
							            	<table width="100%" cellpadding="5" cellspacing="5">
												<tr valign="top">													
													<td>
														<div class="input-prepend">
															<span class="add-on glyphicons phone"><i></i></span>
															<input type="tel" id="inputPhone" class="input-large" placeholder="លេខទូរស័ព្ទ" data-bind="value: phone">
														</div>
													</td>													
													<td>
														<div class="input-prepend">
															<span class="add-on glyphicons globe_af"><i></i></span>
															<input type="text" id="inputZipCode" class="input-large" placeholder="zip code" data-bind="value: zip_code">
														</div>
													</td>
													<td>ខេត្ត/រាជធានី</td>
													<td>
														<select id="province" name="province" data-role="dropdownlist" data-text-field="name" data-value-field="id" 
				              									data-bind="source: provinceList, value: province_id" data-option-label="(--- ជ្រើសរើស ---)"></select>
													</td>
												</tr>
												<tr valign="top">													
													<td>
														<div class="input-prepend">
															<span class="add-on glyphicons envelope"><i></i></span>
															<input type="email" id="inputEmail" class="input-large" placeholder="អីុម៉ែល" data-bind="value: email">
														</div>
													</td>													
													<td>
														<div class="input-prepend">
															<span class="add-on glyphicons home"><i></i></span>
															<input type="text" id="inputAddress" class="input-large" placeholder="អាសយដ្ឋាន ១" data-bind="value: address">
														</div>
													</td>
													<td>ស្រុក/ខណ្ឌ</td>
													<td>
														<select id="district" name="district" data-role="dropdownlist" data-text-field="name" data-value-field="id" data-auto-bind="false" 
				              									data-cascade-from="province" data-bind="source: districtList, value: district_id" data-option-label="(--- ជ្រើសរើស ---)"></select>
													</td>
												</tr>
												<tr valign="top">													
													<td>
														<div class="input-prepend">
															<span class="add-on glyphicons google_maps"><i></i></span>
															<input type="tel" id="inputPhone" class="input-large" placeholder="latitute" data-bind="value: latitute">
														</div>
													</td>													
													<td>
														<div class="input-prepend">
															<span class="add-on glyphicons building"><i></i></span>
															<input type="text" id="inputAddress2" class="input-large" placeholder="អាសយដ្ឋាន ២" data-bind="value: address2">
														</div>														
													</td>
													<td>ឃុំ/សង្កាត់</td>
													<td>
														<select id="commune" data-role="dropdownlist" data-text-field="name" data-value-field="id" data-auto-bind="false"
				              									data-cascade-from="district" data-bind="source: communeList, value: commune_id" data-option-label="(--- ជ្រើសរើស ---)"></select>
													</td>											
												</tr>
												<tr valign="top">													
													<td>
														<div class="input-prepend">
															<span class="add-on glyphicons pinboard"><i></i></span>
															<input type="tel" id="inputPhone" class="input-large" placeholder="longtitute" data-bind="value: longtitute">
														</div>
													</td>													
													<td>
														<div class="input-prepend">
															<span class="add-on glyphicons truck"><i></i></span>
															<input type="text" id="inputShipTo" class="input-large" placeholder="អាស័យដ្ឋានដឹកជញ្ជូន" data-bind="value: ship_to">
														</div>	
													</td>
													<td>ភូមិ/ក្រុម</td>
													<td>
														<select id="village" data-role="dropdownlist" data-text-field="name" data-value-field="id" data-auto-bind="false"
				              									data-cascade-from="commune" data-bind="source: villageList, value: village_id" data-option-label="(--- ជ្រើសរើស ---)"></select>
													</td>
												</tr>																							
											</table>
								        </div>
								        <!-- // Tab content END -->

								        <!-- OTHER INFOMATION Tab content -->
								        <div class="tab-pane" id="tab3-4">
							            	<table width="100%" cellpadding="5" cellspacing="5">						            	
									            <tr>
									              	<td>ភេទ</td>
									              	<td><select data-role="dropdownlist" data-bind="source: genders, value: gender"></select></td>
									              	<td>លេខអត្តសញ្ញាណប័ណ្ណ</td>
									              	<td><input id="card_number" class="k-textbox" data-bind="value: card_number" placeholder="e.g. 123456789" /></td>
									            </tr>
									            <tr>
									            	<td>ថ្ងៃកំណើត</td>
									              	<td><input id="dob" data-role="datepicker" data-bind="value: dob" data-format="dd-MM-yyyy" placeholder="ថ្ងែ-ខែ-ឆ្នាំ" /></td>									              	
									              	<td>សមាជិកគ្រួសារ</td>
									              	<td><input id="family_member" class="k-textbox" data-bind="value: family_member" placeholder="e.g. 3" /></td>
									            </tr>
									            <tr valign="top">
									              	<td>ទីកន្លែងកំណើត</td>
									              	<td><input id="pob" class="k-textbox" data-bind="value: pob" placeholder="e.g. ផ្ទះ ផ្លូវ ភូមិ សង្កាត់ ខណ្ឌ" />
									              	<td>មុខរបរ</td>
									              	<td><input id="job" class="k-textbox" data-bind="value: job" placeholder="e.g. គ្រូបង្រៀន" /></td>
									            </tr>
									            <tr>
									            	<td>សំគាល់</td>
									              	<td><input class="k-textbox" data-bind="value: memo" placeholder="..." /></td>									              	
									              	<td>ក្រុមហ៊ុន</td>
									              	<td><input class="k-textbox" data-bind="value: company" placeholder="e.g. PCG & Partner" /></td>									              	
									            </tr>									            								            			            
									        </table>
							        	</div>
								        <!-- // Tab content END -->								        

								    </div>
								</div>
							</div>							
							
							<!-- Form actions -->
							<div class="form-actions" style="margin: 0;" align="center">
								<div class="status"></div>
								<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok" data-bind="click: btnAddCustomerClick"><i></i> កត់ត្រា</button>
							</div>
							<!-- // Form actions END -->
						
						</div>

					</div>				
				</div>
				      	
			</div>

      	</div> <!--End div example-->
	</div>
</div>

<script>
$(document).ready(function() {

//DataSources
var customerDS = new kendo.data.DataSource({
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
	filter: { field: "parent_id", value: 1 } //customer type id is 1
});

var currencyDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/currencies/index",
			type: "GET",
			dataType: "json"
		}
	}		
});

var accountDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/accounts/account",
			type: "GET",
			dataType: "json"
		}
	},
	filter: { field: "account_type_id", value: 7 },
	serverFiltering: true
});

var revenueAccountDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/accounts/account",
			type: "GET",
			dataType: "json"
		}
	},
	filter: { field: "account_type_id", value: 15 },
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

var provinceDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/provinces/province",
			type: "GET",
			dataType: "json"
		}
	},
	serverFiltering: true
});

var districtDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/districts/district",
			type: "GET",
			dataType: "json"
		}
	},
	serverFiltering: true
});

var communeDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/communes/commune",
			type: "GET",
			dataType: "json"
		}
	},
	serverFiltering: true
});

var villageDS = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/villages/village",
			type: "GET",
			dataType: "json"
		}
	},
	serverFiltering: true
});

//View model
var viewModel = kendo.observable({	
	people_type_id	: 0,
	number 	: "",		
	genders			: ["ប", "ស"],		  	  
	gender			: "ប",
		
	province_id		: 0,
	district_id		: 0,
	commune_id		: 0,
	village_id		: 0,
		
	registered_date	: new Date(),

	currency_code 			: "",
	account_receiveable_id 	: 0,
	revenue_account_id 		: 0,	
	company_id 				: 0,			
	
	isExistingNumber: false,
		
	customerTypeList: customerTypeDS,
	companyList		: companyDS,	
	currencyList 	: currencyDS,
	accountList 	: accountDS,
	revenueAccountList: revenueAccountDS,

	provinceList 	: provinceDS,
	districtList 	: districtDS,
	communeList	 	: communeDS,
	villageList 	: villageDS,
	
	checkExistingNumber : function(){
		var customerNo = this.get("number");
		if(customerNo.length>4){
			$.ajax({
				type: "GET",
	            url : ARNY.baseUrl + "api/people_api/check_existing_customer_no",	            
	            data: {
					number	: customerNo				
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
	change 				: function(e){				
		var company_id = this.get("company_id");		
		var customerNo = this.get("number");					
		if(company_id>0 && customerNo==""){
			$.ajax({
				type: "GET",
	            url : ARNY.baseUrl + "api/people_api/last_no",	            
	            data: {
					company_id	: company_id				
				},
				dataType: "json",
	            success : function(response){
	            	var lastNo = response.number;
	            	
	            	var no = 0;
	            	if(lastNo.length>4){
						no = parseInt(lastNo.substr(lastNo.length-4, lastNo.length));					
					}
					no++;
					var heading = e.sender._current.context.innerText;
					
					var cusNo = heading + kendo.toString(no, "0000");	

	            	viewModel.set("number", cusNo);
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
		customerDS.add({
			people_type_id	: this.get("people_type_id"),
			customer_type 	: "normal",
			number		: this.get("number"),			
			surname			: this.get("surname"),	
			name			: this.get("name"),				  	  
			gender			: this.get("gender"),	
			dob				: kendo.toString(new Date(this.get("dob")), "yyyy-MM-dd"),
			pob				: this.get("pob"),	
			phone			: this.get("phone"),	
			email			: this.get("email"),	
			
			family_member	: this.get("family_member"),	
			memo			: this.get("memo"),	
			image_url		: this.get("image_url"),			
			card_number		: this.get("card_number"),			
			job				: this.get("job"),			
			company			: this.get("company"),					
			
			ship_to			: this.get("ship_to"),			
			address			: this.get("address"),
			address2		: this.get("address2"),	
			zip_code 		: this.get("zip_code"),
								
			province_id		: this.get("province_id"),	
			district_id		: this.get("district_id"),	
			commune_id		: this.get("commune_id"),	
			village_id		: this.get("village_id"),	

			latitute 		: this.get("latitute"),	
			longtitute 		: this.get("longtitute"),	
						
			status			: 1,				
			registered_date	: kendo.toString(new Date(this.get("registered_date")), "yyyy-MM-dd"),
			
			currency_code 			: this.get("currency_code"),
			vat_no 					: this.get("vat_no"),
			account_receiveable_id	: this.get("account_receiveable_id"),
			revenue_account_id		: this.get("revenue_account_id"),
			company_id 				: this.get("company_id")			
		});
		
		customerDS.sync();		
	}	
});  
kendo.bind($("#example"), viewModel);

var validator = $("#example").kendoValidator().data("kendoValidator"),
                    status = $(".status");

var currencyCBB = $("#currencyCBB").kendoComboBox({
	dataTextField: "code",
	dataValueField: "code",	
	template: '<span class="span1">${code}</span> <span class="span2">${country_currency}</span>',
	dataSource: currencyDS
}).data("kendoComboBox");
currencyCBB.list.width(300);


});//End document ready
</script>