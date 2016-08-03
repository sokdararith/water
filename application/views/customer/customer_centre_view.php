<div class="widget widget-heading-simple widget-body-gray widget-employees">			
	<!-- Widget Heading -->
	<!-- <div class="widget-head">		
	</div> -->
	<!-- // Widget Heading END -->	
	
	<div class="widget-body padding-none">	
		<div class="row-fluid row-merge">
			<div class="span3 listWrapper" style="height: 630px;">
				<div class="innerAll">
					<form autocomplete="off" class="form-inline">
						<div class="widget-search separator bottom">
							<button id="search" type="button" class="btn btn-default pull-right"><i class="icon-search"></i></button>
							<div class="overflow-hidden">
								<input id="searchField" type="search" value="" placeholder="ស្វែងរកអតិថិជន">
							</div>
						</div>
						<div class="select2-container" style="width: 100%;">
							<div class="overflow-hidden">								
								<input id="searchByArea" placeholder="តំបន់" style="width: 100%" />
							</div>
						</div>
					</form>
				</div>
				<span class="results"></span>
				<ul class="list unstyled" id="customerList" style="height: 560px;"></ul>
			</div>

			<div class="span9">
				<div class="innerAll">
					<div id="application"></div>
				</div>				
			</div>
		</div>	
	</div>
</div>

<!-- APPLICATION INDEX -->
<script id="appIndex" type="text/x-kendo-template">	
	<div id="info"></div>
	<div id="content"></div>
</script>
<script id="dashBoardView" type="text/x-kendo-template">
	<div class="row-fluid row-merge border-top">

		<div class="span6">
			<div class="innerAll padding-bottom-none-phone">
				<a href="" class="widget-stats widget-stats-gray widget-stats-4">
					<span class="txt">អតិថិជនមិនទាន់បង់</span>
					<span class="count" style="font-size: 30px;" data-bind="text: total_customer"></span>
					<span class="glyphicons user"><i></i></span>
					<div class="clearfix"></div>
					<i class="icon-play-circle"></i>
				</a>
			</div>
		</div>		
		<div class="span6">
			<div class="innerAll padding-bottom-none-phone">
				<a href="" class="widget-stats widget-stats-primary widget-stats-4">
					<span class="txt">បំណុលសរុប</span>
					<span class="count" style="font-size: 30px;" data-bind="text: total_debt"></span>
					<span class="glyphicons refresh"><i></i></span>
					<div class="clearfix"></div>
					<i class="icon-play-circle"></i>
				</a>
			</div>
		</div>		
	</div>

	<select id="company" name="company" data-role="dropdownlist" data-text-field="abbr" data-value-field="id" 
								            data-bind="source: companyList, value: company_id, events: {change: change}" data-option-label="(--- រើស អាជ្ញាប័ណ្ណ ---)"></select>
	
	<div class="chart" data-role="chart" data-bind="source: monthlySaleList"
		data-auto-bind="false"
	  	data-legend="{position: 'bottom'}"
	  	data-series="[			  				
		  				{ type: 'line', field: 'amt' },
		  				{ type: 'column', field: 'amt' }
	  			   	]"			  	
	  	data-category-Axis="{ field: 'strDate',			  						   
	  						  labels: { rotation: 0
	  								  } 
							}"
	  	data-value-Axis="{ labels: {format: '0'}, 
		  					min:0, max: 50000000, 
		  					majorUnit: 10000000,
		  					majorGridLines: { width: 1 }
	  					}"	  	
	  	data-tooltip="{ visible: true, format:'No' }">
	</div>	
</script>

<!-- Customer view -->
<script id="customerListTmpl" type="text/x-kendo-template">
	<li class="">
		<div class="media innerAll">
			<div class="media-object pull-left thumb hidden-phone"><img data-src="holder.js/51x51/dark" alt="51x51" style="width: 51px; height: 51px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADMAAAAzCAYAAAA6oTAqAAACAUlEQVRoQ+2Yv8upcRjGrxdFDEZKBmWxSIlFIgmRwSbl/6MUNkWUwSgZDAYxKEQMisGP0/c76NTRebl17t5O91PP4nku131dn++9PF+JROKO/+T6kjA/lKSQ+aFgIGSEDEMDcswYSiZZCBlSbQwiIcNQMslCyJBqYxAJGYaSSRZChlQbg0jIMJRMsiCRsVqt8Pv9uN1uMJlMWC6XWCwWeoBwOIzD4YDpdPp0oE+03yUkhXG73cjlcrhcLjrMZDLBcDhEJBKBx+PBfD5Hq9V66v2J9p+E8Xq9iEajqNfrOJ/P+nY6nUilUrBYLJjNZuh0Okgmk3A4HGg0GshkMjidTprYK9rvBn/2nEQmFovB5/M9/q/f72s66ioWi9jtdmi327DZbCiVSjAajfpIVqtVBAKBl7RsYex2uyaw2Wz0sMfjEc1m848w6odQKIRgMIjxeIzBYIB3tO8GIpHJ5/O4Xq/odruaxGq1euzI72TMZjPK5bLeK/V+pVJBPB5/SftuEPU+KYxa8nQ6rf3UkGp3ttvtg8x6vUav10M2m4XL5UKtVkOhUMB+v8doNHpJyxZGGRkMBr0T6ojd7+99e/9E+7eQJDKU1jg0EoajZYqHkKG0xqERMhwtUzyEDKU1Do2Q4WiZ4iFkKK1xaIQMR8sUDyFDaY1DI2Q4WqZ4CBlKaxyaXyM+XIKj6S59AAAAAElFTkSuQmCC"></div>
			<div class="media-body">
				<span class="strong">#=fullname#</span>
				<span class="muted">#=number#</span>
				<span class="muted">#=people_types.name# (#=amperes.ampere#)</span>
				
			</div>
		</div>
	</li>
</script>
<script id="customerSumamryView" type="text/x-kendo-template">
	<div class="row-fluid">		
				
		<div class="span4">
			<h4 class="text-primary" data-bind="text: customer.fullIdName"></h4>				
			
			<div class="innerAll padding-bottom-none-phone">
				<a href="" class="widget-stats widget-stats-primary widget-stats-4">
					<span class="txt">សមតុល្យ</span>
					<span class="count" style="font-size: 35px;" data-bind="text: balance"></span>
					<span class="glyphicons coins"><i></i></span>
					<div class="clearfix"></div>
					<i class="icon-play-circle"></i>
				</a>
			</div>
		</div>
		
		<div class="span4">			
			<div class="chart" data-role="chart" data-bind="source: usageList"
				data-auto-bind="false"
			  	data-legend="{position: 'bottom'}"
			  	data-series="[			  				
				  				{ type: 'line', field: 'active_usage' },
				  				{ type: 'column', field: 'active_usage' }
			  			   	]"			  	
			  	data-category-Axis="{ field: 'strDate',			  						   
			  						  labels: { rotation: 0
			  								  } 
									}"
			  	data-value-Axis="{ labels: {format: '0'}, 
				  					min:0, max: 200, 
				  					majorUnit: 100,
				  					majorGridLines: { width: 1 }
			  					}"
			  	data-chart-area="{ height: 180 }"
			  	data-tooltip="{ visible: true, format: 'NO' }">
			</div>
		</div>

		<div class="span4">
															
		</div>

		<div class="row-fluid">
			<div class="span12">
				<div class="innerLR">
					<div class="navbar">
						<div class="navbar-inner">
							<ul class="nav">
								<li id="homeActive" class="active"><a data-bind="click: gotoCustomerView" data-toggle="tab"><i class="icon-home"></i></a></li>																		  
							  	<li><a data-bind="click: gotoEditCustomerView" data-toggle="tab">ពត័មាន</a></li>							  	
							  	<li><a data-bind="click: gotoInvoiceView" data-toggle="tab">វិក្កយបត្រ</a></li>
							  	<li><a data-bind="click: gotoReceiptView" data-toggle="tab">បង្កាន់ដៃលក់</a></li>
							  	<li><a data-bind="click: gotoSOView" data-toggle="tab">បញ្ជាលក់</a></li>
							  	<li><a data-bind="click: gotoEstimateView" data-toggle="tab">សម្រង់តម្លៃ</a></li>
							  	<li><a data-bind="click: gotoGDNView" data-toggle="tab">លិខិតដឹកជញ្ជូន</a></li>							  	
							  	<li><a data-bind="click: gotoStatementView" data-toggle="tab">តុល្យបញ្ជី</a></li>
							  								  
			  					<li class="dropdown">			  		
							    	<a class="dropdown-toggle" data-toggle="dropdown" href="">
								      	<span><i class="icon-lightbulb"></i> ផ្នែកអគ្គីសនី</span>
					 					<span class="caret"></span>
							    	</a>
							    	<ul class="dropdown-menu">
							    		<li><a data-bind="click: gotoMeterView">កុងទ័រ</a></li>
										<li><a data-bind="click: gotoAddMeterRecordView">អំនានកុងទ័រ</a></li>
										<li><a data-bind="click: gotoNoticeView">លិខិតរំលឹក</a></li>			      	
							    	</ul>
							  	</li>
							  	
							  	<li class="dropdown">			  		
							    	<a class="dropdown-toggle" data-toggle="dropdown" href="">
								      	<span><i class="icon-tint"></i> ផ្នែកទឹក</span>
					 					<span class="caret"></span>
							    	</a>
							    	<ul class="dropdown-menu">
							    		<li><a >កុងទ័រ</a></li>
										<li><a >អំនានកុងទ័រ</a></li>								      	
							    	</ul>
							  	</li>	        
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>	
</script>
<script id="customerView" type="text/x-kendo-template">
	<div class="row-fluid">
		<div class="span12">
			<div data-role="grid" data-bind="source: statementCollectionList, events: { change: change }"
		        data-row-template="statementCollectionRowTemplate" 
		        data-pageable="true" data-selectable="true" 
		        data-auto-bind="false"              
		        data-columns="[{ 'title': 'កាលបរិច្ឆេទ' }, 
		            { 'title': 'ប្រភេទ' },	                     
		            { 'title': 'លេខកូដ' },	                                      
		            { 'title': 'ទឹិកប្រាក់' },
		            { 'title': 'ស្ថានភាព' }                    
		            ]">
			</div>
		</div>
	</div>	
</script>
<script id="statementCollectionRowTemplate" type="text/x-kendo-tmpl">
    <tr>        
        <td>#:kendo.toString(new Date(issued_date), "dd-MM-yyyy")#</td>
        <td>#:typeName#</td>
        <td>#:number#</td>
        <td align="right">#:kendo.toString(kendo.parseFloat(amount), 'c0')#</td>
        <td>#:status#</td>         
   	</tr>
</script>
<script id="editElectricityCustomerView" type="text/x-kendo-template">
	<div class="row-fluid">
		<div class="span12">
			<div id="example" class="k-content">

					<div id="editElectricityCustomer">						
						<div class="row-fluid">									
							<div class="span3">
		              			<label for="number">លេខកូដ <span style="color:red">*</span></label>
		              			<input id="number" name="number" class="k-textbox" 
			              				data-bind="value: number, events: { change: checkExistingNumber }" 
			              				placeholder="e.g. AB0001" required data-required-msg="ត្រូវការ លេខកូដ" />
			              		<span data-bind="text: msgCustomerNo" style="color: red;"></span>			              		
		              		</div>
		              		<div class="span3">
			              		<label for="surname">គោត្តនាម <span style="color:red">*</span></label>
			              		<input id="surname" name="surname" class="k-textbox" data-bind="value: surname" 
					              		placeholder="ត្រកូល" required data-required-msg="ត្រូវការ គោត្តនាម" />								
							</div>
							<div class="span3">
					            <label for="name">នាម <span style="color:red">*</span></label>
					            <input id="name" name="name" class="k-textbox" data-bind="value: name" 
					              		placeholder="ឈ្មោះ" required data-required-msg="ត្រូវការ នាម" />
				            </div>
				            <div class="span3">
				            	<label for="customerType">ប្រភេទអតិថិជន <span style="color:red">*</span></label>
					            <select id="customerType" name="customerType" data-role="dropdownlist" data-text-field="name" data-value-field="id" 
			                			data-bind="source: customerTypeList, value: people_type_id" data-option-label="(--- ជ្រើសរើស ---)"
			                			required data-required-msg="ត្រូវការ ប្រភេទអតិថិជន"></select>
				            </div>				            				            															
						</div>

						<div class="separator line bottom"></div>									
						
						<div class="row-fluid">				            
				            <div class="span3">
					            <label for="ar">គណនីអតិថិជន <span style="color:red">*</span></label>
					            <select id="ar" name="ar" data-role="dropdownlist" data-text-field="name" data-value-field="id" 
			            				data-bind="source: accountList, value: account_receiveable_id" data-option-label="(--- ជ្រើសរើស ---)"
			            				required data-required-msg="ត្រូវការ គណនីចំណូល"></select>
			            	</div>

				            <div class="span3">
					            <label for="revenueAccount">គណនីចំណូល <span style="color:red">*</span></label>
					            <select id="revenueAccount" name="revenueAccount" data-role="dropdownlist" data-text-field="name" data-value-field="id" 
			            				data-bind="source: revenueAccountList, value: revenue_account_id" data-option-label="(--- ជ្រើសរើស ---)"
			            				required data-required-msg="ត្រូវការ គណនីចំណូល"></select>
		            		</div>

		            		<div class="span3">
		            			<label for="vatNo">លេខ VAT</label>
		            			<div class="input-prepend">
									<span class="add-on glyphicons vimeo"><i></i></span>
									<input type="text" id="vatNo" class="input-large" data-bind="value: vat_no" 
											placeholder="e.g. 01234567897" style="width:120px">
								</div>								
		            		</div>

		            		<div class="span3">
					            <label for="currencyCBB">រូបិយ​ប័ណ្ណ <span style="color:red">*</span></label>
					            <input id="currencyCBB" name="currencyCBB" data-role="combobox"
					            		data-text-field="code"
                   						data-value-field="code" 
					            		data-bind="source: currencyList, value: currency_code"					            							            		
					            		data-placeholder="(--- ជ្រើសរើស ---)" 
					            		required data-required-msg="ត្រូវការ រូបិយ​ប័ណ្ណ" />
					        </div>
						</div>

						<div class="separator line bottom"></div>

						<div class="row-fluid">
							<div class="span3">
		            			<label for="company">អាជ្ញាបណ្ណ <span style="color:red">*</span></label>									 
								<select id="company" name="company" data-role="dropdownlist" data-text-field="abbr" data-value-field="id" 
		              					data-bind="source: companyList, value: company_id" data-option-label="(--- ជ្រើសរើស ---)"
		              					required data-required-msg="ត្រូវការ អាជ្ញាបណ្ណ"></select>										
		              		</div>

		              		<div class="span3">
				            	<label for="registered_date">ថ្ងៃចុះឈ្មោះ <span style="color:red">*</span></label>
					            <input id="registered_date" name="registered_date" data-role="datepicker" 
		            					data-bind="value: registered_date" data-format="dd-MM-yyyy" 
		            					placeholder="ថ្ងែ-ខែ-ឆ្នាំ" required data-required-msg="ត្រូវការ ថ្ងៃចុះឈ្មោះ" />
				            </div>

							<div class="span3">
								<label for="status">ស្ថានភាព <span style="color:red">*</span></label>
					            <input id="status" name="status" data-role="dropdownlist"
					            		data-text-field="name"
                   						data-value-field="id" 
					            		data-bind="source: statusList, value: status"					            							            		
					            		data-option-label="(--- ជ្រើសរើស ---)" 
					            		required data-required-msg="ត្រូវការ ស្ថានភាព" />
				            </div>

				            <div class="span2">
				            	<span class="label label-inverse"><i class="icon-money"></i> ប្រាក់កក់</span>
				            	<span class="btn btn-block btn-inverse" data-bind="text: deposit_amount"></span>				            	
							</div>				
						</div>												
						
						<!-- // Inner Tabs -->
						<div class="row-fluid">								
							<div class="box-generic">
							    <!-- // Tabs Heading -->
							    <div class="tabsbar tabsbar-2">
							        <ul class="row-fluid row-merge">
							            <li class="span3 glyphicons electricity active"><a href="#tab1-4" data-toggle="tab"><i></i> <span>ពត័មានភ្ជាប់ចរន្តថ្មី</span></a>
							            </li>
							            <li class="span3 glyphicons home"><a href="#tab2-4" data-toggle="tab"><i></i> <span>អាសយដ្ឋាន</span></a>
							            </li>
							            <li class="span3 glyphicons circle_info"><a href="#tab3-4" data-toggle="tab"><i></i> <span>ពត័មានផ្សេងៗ</span></a>
							            </li>								            
							        </ul>
							    </div>
							    <!-- // Tabs Heading END -->

							    <div class="tab-content">

							        <!-- // ELECTRICITY INFORMATION Tab content -->
							        <div class="tab-pane active" id="tab1-4">
						            	<table width="100%" cellpadding="5" cellspacing="5">							            
								            <tr>
								            	<td width="150px">តំបន់ <span style="color:red">*</span></td>
												<td>
													<select id="transformer" name="transformer" data-role="dropdownlist" data-text-field="transformer_number" data-value-field="id"
								              				data-bind="source: transformerList, value: transformer_id" data-auto-bind="false" 
								              				data-option-label="(--- ជ្រើសរើស ---)" required data-required-msg="ត្រូវការ តំបន់"></select>
												</td>
												<td>ផែនការតំលៃលក់ <span style="color:red">*</span></td>
								                <td><select id="tariff_plan" name="tariff_plan" data-role="dropdownlist" data-text-field="name" data-value-field="id" 
								                			data-bind="source: tariffPlanList, value: tariff_plan_id" data-option-label="(--- ជ្រើសរើស ---)"
								                			required data-required-msg="ត្រូវការ ផែនការតំលៃលក់"></select></td>									            										                								                						                
								            </tr>
								            <tr>
								            	<td>អាំងតង់សុីតេ <span style="color:red">*</span></td>		                    
								                <td><select id="ampere" name="ampere" data-role="dropdownlist" data-text-field="ampere" data-value-field="id" 
								                			data-bind="source: ampereList, value: ampere_id" data-option-label="(--- ជ្រើសរើស ---)"
								                			required data-required-msg="ត្រូវការ អាំងតង់សុីតេ"></select></td>									            	
								                <td>បញ្ចុះតំលៃ</td>		                    
								                <td><select id="exemption" name="exemption" data-role="dropdownlist" data-text-field="name" data-value-field="id" 
								                			data-bind="source: exemptionList, value: exemption_id" data-option-label="(--- ជ្រើសរើស ---)"></select></td>							                						                
								            </tr>
								            <tr>
								            	<td>ចំនួនហ្វា <span style="color:red">*</span></td>		                    
								                <td><select id="phase" name="phase" data-role="dropdownlist" data-text-field="phase" data-value-field="id" 
								                			data-bind="source: phaseList, value: phase_id" data-option-label="(--- ជ្រើសរើស ---)"
								                			required data-required-msg="ត្រូវការ ចំនួនហ្វា"></select></td>									            					            	
								            	<td>ថែទាំ</td>		                    
								                <td><select id="maintenance" name="maintenance" data-role="dropdownlist" data-text-field="name" data-value-field="id" 
								                			data-bind="source: maintenanceList, value: maintenance_id" data-option-label="(--- ជ្រើសរើស ---)"></select></td>								            	
								            </tr>
								            <tr>
								            	<td>តុងស្យុង <span style="color:red">*</span></td>		                    
								                <td><select id="voltage" name="voltage" data-role="dropdownlist" data-text-field="voltage" data-value-field="id" 
								                			data-bind="source: voltageList, value: voltage_id" data-option-label="(--- ជ្រើសរើស ---)"
								                			required data-required-msg="ត្រូវការ តុងស្យុង"></select></td>				            	
								            	<td></td>
								            	<td></td>
								            </tr>
								        </table> 
						        	</div>
							        <!-- // Tab content END -->

							        <!-- // ADDRESS Tab content -->
							        <div class="tab-pane" id="tab2-4">
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

							        <!-- // OTHER INFOMATION Tab content -->
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
						
						<!-- // Form actions -->						
						<div id="msgStatus"></div>								
						<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok" data-bind="click: btnAddCustomerClick"><i></i> កត់ត្រា</button>						
						<!-- // Form actions END -->
					
					</div>									

			</div> <!-- // End div example-->            
		</div> <!-- // End div span12-->		
	</div> <!-- // End div row-fluid-->	
</script>
<script id="editNormalCustomerView" type="text/x-kendo-template">
	<div class="row-fluid">
		<div class="span12">
			<div id="example" class="k-content">

					<div id="editNormalCustomer">						
						<div class="row-fluid">									
							<div class="span3">
		              			<label for="number">លេខកូដ <span style="color:red">*</span></label>
		              			<input id="number" name="number" class="k-textbox" 
			              				data-bind="value: number, events: { change: checkExistingNumber }" 
			              				placeholder="e.g. AB0001" required data-required-msg="ត្រូវការ លេខកូដ" />
			              		<span data-bind="text: msgCustomerNo" style="color: red;"></span>			              		
		              		</div>
		              		<div class="span3">
			              		<label for="surname">គោត្តនាម <span style="color:red">*</span></label>
			              		<input id="surname" name="surname" class="k-textbox" data-bind="value: surname" 
					              		placeholder="ត្រកូល" required data-required-msg="ត្រូវការ គោត្តនាម" />								
							</div>
							<div class="span3">
					            <label for="name">នាម <span style="color:red">*</span></label>
					            <input id="name" name="name" class="k-textbox" data-bind="value: name" 
					              		placeholder="ឈ្មោះ" required data-required-msg="ត្រូវការ នាម" />
				            </div>
				            <div class="span3">
				            	<label for="customerType">ប្រភេទអតិថិជន <span style="color:red">*</span></label>
					            <select id="customerType" name="customerType" data-role="dropdownlist" data-text-field="name" data-value-field="id" 
			                			data-bind="source: customerTypeList, value: people_type_id" data-option-label="(--- ជ្រើសរើស ---)"
			                			required data-required-msg="ត្រូវការ ប្រភេទអតិថិជន"></select>
				            </div>				            				            															
						</div>

						<div class="separator line bottom"></div>									
						
						<div class="row-fluid">							
				            <div class="span3">
					            <label for="currencyCBB">រូបិយ​ប័ណ្ណ <span style="color:red">*</span></label>
					            <input id="currencyCBB" name="currencyCBB" data-role="combobox"
					            		data-text-field="code"
                   						data-value-field="code" 
					            		data-bind="source: currencyList, value: currency_code"					            							            		
					            		data-placeholder="(--- ជ្រើសរើស ---)" 
					            		required data-required-msg="ត្រូវការ រូបិយ​ប័ណ្ណ" />
					        </div>
				            <div class="span3">
					            <label for="ar">គណនីអតិថិជន <span style="color:red">*</span></label>
					            <select id="ar" name="ar" data-role="dropdownlist" data-text-field="name" data-value-field="id" 
			            				data-bind="source: accountList, value: account_receiveable_id" data-option-label="(--- ជ្រើសរើស ---)"
			            				required data-required-msg="ត្រូវការ គណនីចំណូល"></select>
			            	</div>
				            <div class="span3">
					            <label for="revenueAccount">គណនីចំណូល <span style="color:red">*</span></label>
					            <select id="revenueAccount" name="revenueAccount" data-role="dropdownlist" data-text-field="name" data-value-field="id" 
			            				data-bind="source: revenueAccountList, value: revenue_account_id" data-option-label="(--- ជ្រើសរើស ---)"
			            				required data-required-msg="ត្រូវការ គណនីចំណូល"></select>
		            		</div>
		            		<div class="span3">
		            			<label for="vatNo">លេខ VAT</label>
		            			<div class="input-prepend">
									<span class="add-on glyphicons vimeo"><i></i></span>
									<input type="text" id="vatNo" class="input-large" data-bind="value: vat_no" 
											placeholder="e.g. 01234567897" style="width:120px">
								</div>
		            		</div>
						</div>

						<div class="separator line bottom"></div>

						<div class="row-fluid">									
							<div class="span3">
		            			<label for="company">អាជ្ញាបណ្ណ <span style="color:red">*</span></label>									 
								<select id="company" name="company" data-role="dropdownlist" data-text-field="abbr" data-value-field="id" 
		              					data-bind="source: companyList, value: company_id" data-option-label="(--- ជ្រើសរើស ---)"
		              					required data-required-msg="ត្រូវការ អាជ្ញាបណ្ណ"></select>										
		              		</div>

		              		<div class="span3">
				            	<label for="registered_date">ថ្ងៃចុះឈ្មោះ <span style="color:red">*</span></label>
					            <input id="registered_date" name="registered_date" data-role="datepicker" 
		            					data-bind="value: registered_date" data-format="dd-MM-yyyy" 
		            					placeholder="ថ្ងែ-ខែ-ឆ្នាំ" required data-required-msg="ត្រូវការ ថ្ងៃចុះឈ្មោះ" />
				            </div>

		              		<div class="span3">
					            <label for="status">ស្ថានភាព <span style="color:red">*</span></label>
					            <input id="status" name="status" data-role="dropdownlist"
					            		data-text-field="name"
                   						data-value-field="id" 
					            		data-bind="source: statusList, value: status"					            							            		
					            		data-option-label="(--- ជ្រើសរើស ---)" 
					            		required data-required-msg="ត្រូវការ ស្ថានភាព" />
					        </div>
						</div>												
						
						<!-- // Inner Tabs -->
						<div class="row-fluid">								
							<div class="box-generic">
							    <!-- // Tabs Heading -->
							    <div class="tabsbar tabsbar-2">
							        <ul class="row-fluid row-merge">							            
							            <li class="span3 glyphicons home active"><a href="#tab1-2" data-toggle="tab"><i></i> <span>អាសយដ្ឋាន</span></a>
							            </li>
							            <li class="span3 glyphicons circle_info"><a href="#tab2-2" data-toggle="tab"><i></i> <span>ពត័មានផ្សេងៗ</span></a>
							            </li>								            
							        </ul>
							    </div>
							    <!-- // Tabs Heading END -->

							    <div class="tab-content">							        

							        <!-- // ADDRESS Tab content -->
							        <div class="tab-pane active" id="tab1-2">
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

							        <!-- // OTHER INFOMATION Tab content -->
							        <div class="tab-pane" id="tab2-2">
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
						
						<!-- // Form actions -->						
						<div id="msgStatus"></div>								
						<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok" data-bind="click: btnAddCustomerClick"><i></i> កត់ត្រា</button>						
						<!-- // Form actions END -->
					
					</div>									

			</div> <!-- // End div example-->            
		</div> <!-- // End div span12-->		
	</div> <!-- // End div row-fluid-->	
</script>


<!-- Meter view -->
<script id="meterView" type="text/x-kendo-template">	
	<div class="row-fluid">
		<div class="span12">
			<h4 align="center">កុងទ័រ</h4>

			<div id="meter-window" data-role="window" data-visible="false" data-modal="true" data-resizable="false" data-iframe="true" data-min-width="600px" data-height="400px">
		    	<table cellpadding="5" cellspacing="5">
	                <tr>
	                  	<td>អតិថិជន</td>
	                  	<td><span data-bind="text: fullIdName"></span></td>                 
	                  	<td>ថ្ងៃប្រើប្រាស់</td>	                  	
	                  	<td><input data-role="datepicker" data-bind="value: date_used" data-format="dd-MM-yyyy" /></td> 
	                </tr>
	                <tr>
	                  	<td>ប្រភេទ</td>
	                  	<td><select data-role="combobox" data-text-field="name" data-value-field="id" data-bind="source: meterItemList, value: item_id"></select></td> 
	                  	<td>កុងទ័របំរុងនៃ</td>
	                  	<td><select data-role="combobox" data-text-field="meter_no" data-value-field="id" data-bind="source: parentMeterList, value: parent_id"></select></td>	                  	                             
	                </tr>
	                <tr>
	                  	<td>លេខកូដកុងទ័រ</span></td>                    
	                  	<td><input class="k-textbox" data-bind="value: meter_no" /></td>                             
	                  	<td>មេគុណ</td>
	                  	<td><input data-role="numerictextbox" data-bind="value: multiplier" data-format="#" min="1" step="100" /></td>                                   
	                </tr>
	                <tr>             
	                  <td>សំណគំរបខ្សែ</td>
	                  	<td><select data-role="dropdownlist" data-text-field="name" data-value-field="value" data-bind="source: hasOrNot, value: cover_sealed"></select></td>	                  	  	             
	                  	<td>ស្ថានភាព</td>
	                  	<td><select data-role="dropdownlist" data-text-field="name" data-value-field="value" data-bind="source: statuses, value: status"></select></td>                                    
	                </tr>
	                <tr>             
	                  	<td>សំណត្រចៀក</td>
	                  	<td><select data-role="dropdownlist" data-text-field="name" data-value-field="value" data-bind="source: hasOrNot, value: ear_sealed"></select></td>	                  	  	
	                  	<td></td>
	                  	<td><input type="checkbox" data-bind="checked: hasTariff, click: clearTariff" /> មានអំនាន Reactive</td>                                   
	                </tr>
	                <tr>
	                	<td>ចំនួនខ្ទង់នាឡិកា</td>
	                	<td><input data-role="numerictextbox" data-bind="value: max_digit" data-format="n0" min="0" placeholder="ឧ.10000" /></td>                  	
	                  	<td>តំលៃ</td>
	                  	<td><select data-role="combobox" data-text-field="name" data-value-field="id" data-bind="source: tariffList, enabled: hasTariff, value: tariff_id"></select></td>	                  	                        
	                </tr>
	                <tr>
	                  	<td>ត្រង់ស្វូ</td>
	                  	<td><select data-role="combobox" data-text-field="transformer_number" data-value-field="id" data-bind="source: transformerList, value: transformer_id"></select></td>	                  	
	                  	<td rowspan="2" valign="top">កំណត់សំគាល់</td>
	                  	<td rowspan="2" valign="top"><textarea name="memo" id="address" cols="" rows="2" data-bind="value: memo"></textarea></td>
	                </tr>
	                <tr>
	               	  	<td>ប្រអប់</td>
	                  	<td><select data-role="combobox" data-text-field="box_no" data-value-field="id" data-bind="source: electricityBoxList, value: electricity_box_id"></select></td>
	                  	<td></td>
	                  	<td></td>
	                </tr>
	          	</table>
	          	
	          	<br>

	          	<div align="center">
	          		<button class="btn btn-primary" data-bind="click: meterSaveClick"><i class="icon-hdd icon-white"></i> កត់ត្រា</button>                                  
	                <button class="btn" data-bind="click: closeMeterWindow"><i class="icon-off"></i> បិទ</button>
	                <button class="btn btn-danger" data-bind="visible: isEditMode, click: deleteMeter"><i class="icon-trash icon-white"></i> លុប</button>
	          	</div>
		    </div>

			<button class="btn btn-inverse" data-bind="click: btnAddNewMeterClick"><i class="icon-plus icon-white"></i></button>
			<br>
			<div id="meterGrid" data-role="grid" data-bind="source: meterList, events: { change: meterGridChange }"
	            data-selectable="true" data-row-template="meterRowTemplate"                  
	            data-columns='[{ "title": "កាលបរិច្ឆេទ", width: 90 }, 
	                    { "title": "#កុងទ័រ", width: 90}, 
	                    { "title": "ប្រភេទ" }, 
	                    { "title": "បំរុងនៃ" },
	                    { "title": "ប្រអប់", width: 90 },
	                    { "title": "ត្រ.", width: 35 },
	                    { "title": "គំរ.", width: 35 },
	                    { "title": "ស្ថានភាព", width: 90 }]'>
			</div>    		

			<br><br>			
			
			<div id="breaker-window" data-role="window" data-visible="false" data-modal="true" data-resizable="false" data-iframe="true" data-min-width="300px" data-height="250px">
		    	<table cellpadding="5" cellspacing="5">
	                <tr>
	                  	<td>អតិថិជន</td>
	                  	<td><span data-bind="text: fullIdName"></span></td>
	                </tr>
	                <tr>                 
	                  	<td>ថ្ងៃប្រើប្រាស់</td>	                  	
	                  	<td><input data-role="datepicker" data-bind="value: date_used_brker" data-format="dd-MM-yyyy" /></td> 
	                </tr>
	                <tr>
	                  	<td>ប្រភេទ</td>
	                  	<td><select data-role="combobox" data-text-field="name" data-value-field="id" data-bind="source: breakerItemList, value: item_id_brker"></select></td> 
	                </tr>
	                <tr>
	                  	<td>ឈ្មោះឌីស្យុងទ័រ</span></td>                    
	                  	<td><input class="k-textbox" data-bind="value: name_brker" /></td>	                  	
	                </tr>
	                <tr>	                  
	                  	<td>ស្ថានភាព</td>
	                  	<td><select data-role="dropdownlist" data-text-field="name" data-value-field="value" data-bind="source: statuses, value: status_brker"></select></td>                                    
	                </tr>	                
	          	</table>
	          	
	          	<br>

	          	<div align="center">
	          		<button class="btn btn-primary" data-bind="click: breakerSaveClick"><i class="icon-hdd icon-white"></i> កត់ត្រា</button>                                  
	                <button class="btn" data-bind="click: closeBreakerWindow"><i class="icon-off"></i> បិទ</button>
	                <button class="btn btn-danger" data-bind="visible: isEditModeBrker, click: deleteBreaker"><i class="icon-trash icon-white"></i> លុប</button>
	          	</div>
		    </div>
		    		
			<button class="btn btn-inverse" data-bind="click: btnAddNewBreakerClick"><i class="icon-plus icon-white"></i></button>
			<br>
			<div id="brkerGrid" data-role="grid" data-bind="source: breakerList, events: { change: breakerGridChange }"
	            data-selectable="True" data-row-template="brkerRowTemplate"                  
	            data-columns='[{ "title": "កាលបរិច្ឆេទ" }, 
	                    { "title": "ឈ្មោះឌីស្យុងទ័រ"}, 
	                    { "title": "ប្រភេទ" },                        
	                    { "title": "ស្ថានភាព" }]'>
			</div>			
		</div>
	</div>		
</script>
<script id="meterRowTemplate" type="text/x-kendo-template">	
	<tr>
		<td>
			#if(date_used!="0000-00-00"){#
				#:kendo.toString(new Date(date_used), "dd-MM-yyyy")#
			#}#
		</td>
		<td>#:meter_no#</td>
		<td>#:items.name#</td>
		<td>
			#if(parents.meter_no!=null){#
				#:parents.meter_no#
			#}#
		</td>		
		<td>
			#if(electricity_boxes.box_no!=null){#
				#:electricity_boxes.box_no#
			#}#
		</td>
		<td><input type="checkbox" #: ear_sealed==1 ? checked="checked" : "" # disabled="disabled" /></td>
		<td><input type="checkbox" #: cover_sealed==1 ? checked="checked" : "" # disabled="disabled" /></td>
		<td>#:status==1 ? "ប្រើប្រាស់" : "ឈប់ប្រើ"#</td>		
	</tr>
</script>
<script id="brkerRowTemplate" type="text/x-kendo-template">	
	<tr>
		<td>#:kendo.toString(new Date(date_used), "dd-MM-yyyy")#</td>
		<td>#:name#</td>
		<td>#:items.name#</td>		
		<td>#:status==1 ? "ប្រើប្រាស់" : "ឈប់ប្រើ"#</td>		
	</tr>
</script>


<!-- Meter record view -->
<script id="addMeterRecordView" type="text/x-kendo-template">
	<div class="row-fluid">
		<div class="span12">
			<h4 align="center">អំនានកុងទ័រ</h4>

			<div id="meterRecord-window" data-role="window" data-visible="false" data-modal="true" data-resizable="false" data-iframe="true" data-min-width="600px" data-height="400px">
		    	<table cellpadding="5" cellspacing="5">
	                <tr>
	                  	<td>អំនានចាស់</td>
	                  	<td><span data-bind="text: editData.meter_records.prev_reading"></span></td>
	                  	<td>អំនានចាស់ Reactive</td>
	                  	<td><span data-bind="text: editData.meter_records.reactive_prev_reading"></span></td>	                  	                 
	                </tr>	                
	                <tr>
	                  	<td>អំនានថ្មី</span></td>                    
	                  	<td><input class="k-textbox" data-bind="value: new_reading, events: { change: editChange }" /></td>
	                  	<td>អំនានថ្មី Reactive</span></td>                    
	                  	<td><input class="k-textbox" data-bind="value: reactive_new_reading, enabled: hasReactive, events: { change: editChange }" /></td>	                  	                                  
	                </tr>
	                <tr>
	                	<td></td>
	                	<td><input type="checkbox" data-bind="checked: new_round, events: { change: editChange }"> ជំុថ្មី</td>
	                	<td></td>
	                	<td><input type="checkbox" data-bind="checked: reactive_new_round, enabled: hasReactive, events: { change: editChange }"> ជំុថ្មី</td>
	                </tr>
	                <tr>
	                	<td>សរុប</td>
	                	<td><span data-bind="text: active_usage"></span></td>
	                	<td>សរុប Reactive</td>
	                	<td><span data-bind="text: reactive_usage"></span></td>
	                </tr>	                
	          	</table>

	          	<table data-bind="visible: isVisible" cellpadding="5" cellspacing="5">
					<tr>
			            <td>ប្រចាំខែ</td>            
			            <td><input data-role="datepicker" data-bind="value: month_of" data-start="year" data-depth="year" data-format="MM-yyyy" /></td>			            		            
			      	</tr>		          	
			      	<tr>		            
			            <td>ថ្ងៃចេញវិក្កយបត្រ</td>            
			            <td><input data-role="datepicker" data-bind="value: issued_date" data-format="dd-MM-yyyy" /></td>			            
			      	</tr>			      	
			      	<tr>		            
			            <td>ថ្ងៃបង់ប្រាក់</td>
			            <td><input data-role="datepicker" data-bind="value: payment_date" data-format="dd-MM-yyyy" /></td>
			      	</tr>
			      	<tr>		            
			            <td>ថ្ងៃផុតកំណត់</td>
			            <td><input data-role="datepicker" data-bind="value: due_date" data-format="dd-MM-yyyy" /></td>
			      	</tr>		          	
			    </table>
	          	
	          	<br>

	          	<div align="center">
	          		<button class="btn btn-primary" data-bind="click: saveEditClick"><i class="icon-hdd icon-white"></i> កែប្រែ</button>                                  
	                <button class="btn" data-bind="click: closeWindow"><i class="icon-off"></i> បិទ</button>	                
	          	</div>
		    </div>			

			<div id="addMeterRecordGrid" data-role="grid" data-bind="source: meterReadingList"
                data-editable="true" data-row-template="addMeterRecordRowTemplate"                  
                data-columns='[
                	{ "title": "ប្រចាំខែ", width: 70 },
                	{ "title": "ប្រអប់", width: "80px" }, 
                    { "title": "#កុងទ័រ", width: "80px"},                    	                
	                { "title": "ជំុ(R)", width: 40 },
	                { "title": "អំ.ចាស់(R)", width: 70 },
	                { "title": "អំ.ថ្មី(R)", width: 80 },
	                { "title": "សរុប" },
	                { "title": "ជំុថ្មី", width: 40 },
	                { "title": "អំ.ចាស់", width: 70 },
	                { "title": "អំ.ថ្មី", width: 80 },
					{ "title": "សរុប" },
                    { "title": "", width: "25px" }]'>
			</div>

	        <br />

	        <div class="AddMeterRecordStatus" align="center"></div>
	        
	        <div class="pull-right">
	        	<table cellspacing="5" cellpadding="5">
		          	<tr>		            
			            <td align="right">ថាមពលប្រើប្រាស់សរុប:</td>            
			            <td align="right"><span data-bind="text: total_active"></span></td>
		          	</tr>
		          	<tr>		            
			            <td align="right">ថាមពល Reactive សរុប:</td>            
			            <td align="right" width="90px"><span data-bind="text: total_reactive"></span></td>
		          	</tr>
		          	<tr>
		          		<td></td>
		          		<td align="right">
		          			<button class="btn btn-primary" data-bind="click: addMeterRecord"><i class="icon-hdd icon-white"></i> កត់ត្រា</button>     
		          		</td>
		          	</tr>
		        </table>
	        </div>

	        <div>
		        <table>
		          <tr>
		            <td>ប្រចាំខែ</td>
		            <td><input data-role="datepicker" data-bind="value: month_of" data-start="year" data-depth="year" data-format="MM-yyyy" /></td>
		            <td></td>
		            <td></td>		            
		          </tr>
		          <tr>
		            <td>ថ្ងៃអានចាប់ពី</td>
		            <td><input data-role="datepicker" data-bind="value: date_read_from" data-format="dd-MM-yyyy" /></td>
		            <td>ដល់</td>
		            <td><input data-role="datepicker" data-bind="value: date_read_to" data-format="dd-MM-yyyy" /></td>		            
		          </tr>
		          <tr>
		            <td>អ្នកអាន</td>
		            <td>
		            	<select data-role="combobox" data-text-field="fullname" data-value-field="id" data-bind="source: readerList, value: reader_id"></select>
		            	<span id="reader"></span>
		            </td>
		            <td></td>
		            <td></td>		            
		          </tr>
		        </table>
	        </div>    			
		</div>
	</div>	
</script>
<script id="addMeterRecordRowTemplate" type="text/x-kendo-tmpl">
	<tr id="rowGrid-#:id#">					
		<td>
			#if(meter_records.month_of!=null){#
				#:kendo.toString(new Date(meter_records.month_of), "MM-yyyy")#				
			#}#
			<span id="msgD-#:id#"></span>
		</td>
		<td>#: electricity_boxes.box_no #</td>
		<td>#: meter_no #</td>
		<td align="center">
		   <input type="checkbox" data-bind="checked: rcheckNewRound, events: { change: change }" #: tariff_id==0 ? disabled="disabled" : "" # />
		</td>
		<td>
			<input data-role="numerictextbox" data-format="n0" data-min="0" 
		   		data-bind="value: reactive_prev_reading, events: { change: change }" style="width: 80px;" #: tariff_id==0 || meter_records.reactive_new_reading!=null ? disabled="disabled" : "" # />
		</td>
		<td>
		   <input data-role="numerictextbox" data-format="n0" data-min="0" style="width:70px;"
		   		data-bind="value: reactive_new_reading, events: { change: change }" style="width: 80px;" #: tariff_id==0 ? disabled="disabled" : "" # />		   		   
		</td>
		<td>
			#if(reactive_new_reading!==""){#
				#if(rcheckNewRound){#
					#:kendo.parseInt(reactive_new_reading) + kendo.parseInt(max_digit) - kendo.parseInt(reactive_prev_reading)#
				#}else{#
					#:kendo.parseInt(reactive_new_reading) - kendo.parseInt(reactive_prev_reading)#
				#}#
			#}#
			<span id="msgR-#:id#"></span>
		</td>
		<td align="center">
		   <input type="checkbox" data-bind="checked: checkNewRound, events: { change: change }" />
		</td>		
		<td>
			<input data-role="numerictextbox" data-format="n0" data-min="0" 
		   		data-bind="value: prev_reading, events: { change: change }" style="width: 80px;" #: meter_records.new_reading!=null ? disabled="disabled" : "" # />
		</td>
		<td>
		   <input class="txt-#:id#" data-role="numerictextbox" data-format="n0" data-min="0" style="width:70px;"
		   		data-bind="value: new_reading, events: { change: change }" style="width: 80px;" />		   		   			
		</td>
		<td>
			#if(new_reading!==""){#
				#if(checkNewRound){#
					#:kendo.parseInt(new_reading) + kendo.parseInt(max_digit) - kendo.parseInt(prev_reading)#
				#}else{#
					#:kendo.parseInt(new_reading) - kendo.parseInt(prev_reading)#
				#}#
			#}#
			<span id="msg-#:id#"></span>
		</td>
		<td align="center"><i class="icon-edit" data-bind="click: editReadingClick"></i></td>
    </tr>
</script>


<!-- Invoice -->
<script id="invoiceView" type="text/x-kendo-template">
	<div class="row-fluid">
		<div class="span12">
			<h4 align="center">វិក្កយបត្រ</h4>
			
			<div class="row-fluid">
				<div class="span4">				
					<table cellpadding="2" cellspacing="2">					          
						<tr>				
							<td>លេខវិក្ក​យបត្រ</td>
							<td><input class="k-textbox" data-bind="value: number" style="width:140px;" readonly /></td>
						</tr>
						<tr>
							<td>ថ្ងៃចេញវិក្កយបត្រ</td>
							<td><input data-role="datepicker" data-bind="value: issued_date" data-format="dd-MM-yyyy" /></td>
						</tr>		                      
						<tr>
			                <td>Class</td>
			              	<td><select data-role="combobox" data-text-field="name" data-value-field="id" data-bind="source: classList, value: class_id"></select></td>
			            </tr>            
						<tr>
							<td colspan="2">
								អាសយដ្ឋាន
								<br>
								<textarea id="memo" cols="0" rows="2" class="k-textbox" style="width:250px" data-bind="value: address"></textarea>
							</td>
						</tr>
					</table>
				</div>

			    <div class="span4">
			    	<div align="center">
			    		<span class="glyphicons standard circle_ok" data-bind="visible: paid"><i></i> ទូទាត់រួច</span>				    	
			    	</div>
			    </div>

				<div class="span4">
					<table cellpadding="2" cellspacing="2">	
						<tr>
			                <td>កាលកំណត់</td>
			              	<td><select data-role="dropdownlist" data-text-field="term" data-value-field="id" data-bind="source: paymentTermList, value: payment_term_id" data-option-label="(--- ជ្រើសរើស ---)"></select></td>
			            </tr>				
						<tr>
							<td>ថ្ងៃបង់ប្រាក់</td>
							<td><input data-role="datepicker" data-bind="value: due_date" data-format="dd-MM-yyyy" /></td>
						</tr>					
			            <tr>
			            	<td>លេខបញ្ជាលក់</td>				
							<td><select data-role="dropdownlist" data-text-field="number" data-value-field="id" data-auto-bind="false" data-bind="source: soList, value: so_id, events:{ change: soChange}" data-option-label="(--- ជ្រើសរើស ---)"></select></td>
						</tr>
						<tr>
			            	<td>លេខសម្រង់តំម្លៃ</td>				
							<td><select data-role="dropdownlist" data-text-field="number" data-value-field="id" data-auto-bind="false" data-bind="source: estimateList, value: estimate_id, events:{ change: estimateChange}" data-option-label="(--- ជ្រើសរើស ---)"></select></td>
						</tr>
						<tr>
			            	<td>លេខលិខិតដឺកជញ្ជូន</td>				
							<td><select data-role="dropdownlist" data-text-field="number" data-value-field="id" data-auto-bind="false" data-bind="source: gdnList, value: gdn_id, events:{ change: gdnChange}" data-option-label="(--- ជ្រើសរើស ---)"></select></td>
						</tr>
					</table>           		          	
			    </div>
			</div>
						
			<div data-role="grid" data-bind="source: invoiceItemList"
		        data-auto-bind="false" data-row-template="invoiceRowTemplate"                  
		        data-columns='[{ title: "#", width: 35 }, 
		            { title: "ទំនិញ", width: 175 },	                     
		            { title: "ពណ៌នា", width: 200 },
		            { title: "ចំនួន", width: 95 },
		            { title: "តំលៃ", width: 115 },	                    	                     
		            { title: "VAT", width: 80 },
		            { title: "ទឹកប្រាក់" }	                    	                    
		            ]'>
			</div>
			<button class="btn btn-inverse" data-bind="click: addNewRow"><i class="icon-plus icon-white"></i></button>
			
			<br>
			
			<div class="row-fluid">				
				<div class="span8">
					សំគាល់:
					<br>
					<textarea id="memo" cols="0" rows="4" class="k-textbox" style="width:300px" data-bind="value: memo"></textarea>
				</div>

				<div class="span4">
					<table width="100%">
						<tr align="right">
							<td>សរុបរង:</td>
							<td width="50%"><span data-bind="text: sub_total"></span></td>
						</tr>
						<tr align="right">
							<td><select data-role="combobox" data-text-field="name" data-value-field="id" 
										data-bind="source: vatList, value: vat_id" placeholder="VAT" style="width:140px"></select></td>
							<td><span data-bind="text: vat"></span></td>
						</tr>
						<tr align="right">
							<td>សរុប:</td>
							<td><span data-bind="text: vat"></span></td>
						</tr>
						<tr align="right">
							<td>សរុបតាមអតិថិជនរូបិយបណ្ណ:</td>
							<td><span data-bind="text: vat"></span></td>
						</tr>
					</table>
				</div>													
			</div>

			<div class="row-fluid">				
				<div class="span12" align="right">
					<span class="btn btn-primary btn-icon glyphicons print" data-bind="click: linkPrint, visible: isUpdate"><i></i> បោះពុម្ព</span>
					<span class="btn btn-primary btn-icon glyphicons cart_in" data-bind="click: btnCreateInvoice"><i></i> កត់ត្រា</span>
				</div>
			</div>

		</div>
	</div>	
</script>
<script id="invoiceRowTemplate" type="text/x-kendo-tmpl">		
	<tr>		
		<td class="sno">1</td>
		<td>
			<select data-role="combobox" data-text-field="name" data-value-field="id" data-suggest="true"
					data-bind="source: itemList, value: item_id, events: {change : itemChange}">
			</select>
		</td>		
		<td>
			<input type="text" data-bind="value: description" style="margin-bottom: 0;" />
		</td>
		<td>
			<input data-role="numerictextbox" data-format="n0" data-bind="value: quantity, events: {change : change}"
				style="width: 80px" />
		</td>				
		<td>
			<input class="price" data-role="numerictextbox" data-format="c0" data-bind="value: unit_price, events: {change : change}" 
				style="width: 100px" />
		</td>
		<td>
			<input data-role="numerictextbox" data-format="p0" 
					data-min="0"
					data-max="1"
					data-step="0.01"
					data-bind="value: vat, events: {change : change}" 
					style="width: 65px;" />
		</td>
		<td align="right">
			#:kendo.toString(kendo.parseFloat(amount), 'c0')#
			<i class="icon-trash" data-bind="events: { click: removeRow "></i>
		</td>		
    </tr>   
</script>


<!-- Sale Receipt -->
<script id="receiptView" type="text/x-kendo-template">
	<div class="row-fluid">
		<div class="span12">
			<h4 align="center">បង្កាន់ដៃលក់</h4>

			<div class="row-fluid">				
				<div class="span8">
					<table cellpadding="2" cellspacing="2">
						<tr>				
							<td>លេខបង្កាន់ដៃលក់</td>
							<td><input class="k-textbox" data-bind="value: number" style="width:138px;" readonly /></td>
						</tr>
						<tr>
							<td>កាលបរិច្ឆេទ</td>
							<td><input data-role="datepicker" data-bind="value: issued_date" data-format="dd-MM-yyyy" /></td>
						</tr>					         
						<tr>
			                <td>Class</td>
			              	<td><select data-role="combobox" data-text-field="name" data-value-field="id" data-bind="source: classList, value: class_id"></select></td>
			            <tr>            
						<tr>
							<td colspan="2">
								អាសយដ្ឋាន
								<br>
								<textarea id="memo" cols="0" rows="2" class="k-textbox" style="width:250px" data-bind="value: address"></textarea>
							</td>
						</tr>
					</table>
				</div>

				<div class="span4">			
					<table cellpadding="2" cellspacing="2">					
						<tr>
			                <td>វីធីបង់ប្រាក់</td>
			              	<td><select data-role="dropdownlist" data-text-field="name" data-value-field="id" data-bind="source: paymentMethodList, value: payment_method_id" data-option-label="(--- ជ្រើសរើស ---)"></select></td>
			            <tr>
						<tr>
			                <td>លេខកូដសែក</td>
			                <td><input id="check_no" class="k-textbox" data-bind="value: check_no" /></td>
			            <tr>
			            <tr>
							<td>គណនីសាច់ប្រាក់</td>
							<td><select data-role="combobox" data-text-field="name" data-value-field="id" data-bind="source: cashAccountList, value: cash_account_id"></select></td>
						</tr>					
						<tr>
			            	<td>លេខបញ្ជាលក់</td>				
							<td><select data-role="dropdownlist" data-text-field="number" data-value-field="id" data-auto-bind="false" data-bind="source: soList, value: so_id, events:{ change: soChange}" data-option-label="(--- ជ្រើសរើស ---)"></select></td>
						</tr>
						<tr>
			            	<td>លេខសម្រង់តំម្លៃ</td>				
							<td><select data-role="dropdownlist" data-text-field="number" data-value-field="id" data-auto-bind="false" data-bind="source: estimateList, value: estimate_id, events:{ change: estimateChange}" data-option-label="(--- ជ្រើសរើស ---)"></select></td>
						</tr>
						<tr>
			            	<td>លេខលិខិតដឺកជញ្ជូន</td>				
							<td><select data-role="dropdownlist" data-text-field="number" data-value-field="id" data-auto-bind="false" data-bind="source: gdnList, value: gdn_id, events:{ change: gdnChange}" data-option-label="(--- ជ្រើសរើស ---)"></select></td>
						</tr>
					</table>           		          	
			    </div>			    			
			</div>			

			<div data-role="grid" data-bind="source: receiptItemList"
		        data-auto-bind="false" data-row-template="receiptRowTemplate"                  
		        data-columns='[{ title: "", width: 20 },
		        	{ title: "ល.រ", width: 35 },
		            { title: "ទំនិញ", width: 150 },	                     
		            { title: "ពណ៌នា", width: 200 },
		            { title: "ចំនួន", width: 95 },
		            { title: "តំលៃ", width: 115 },		            
		            { title: "ទឹកប្រាក់", width: 90 },
		            { title: "vat", width: 30 }	                    	                    
		            ]'>
			</div>
			<button class="btn btn-inverse" data-bind="click: addNewRow"><i class="icon-plus icon-white"></i></button>
			
			<div class="row-fluid">				
				<div class="span8">
					សំគាល់:
					<br>
					<textarea id="memo" cols="0" rows="4" class="k-textbox" style="width:300px" data-bind="value: memo"></textarea>
				</div>

				<div class="span4">
					<table width="100%">
						<tr align="right">
							<td>សរុបរង:</td>
							<td width="50%"><span data-bind="text: sub_total"></span></td>
						</tr>
						<tr align="right">
							<td><select data-role="combobox" data-text-field="name" data-value-field="id" 
										data-bind="source: vatList, value: vat_id" placeholder="VAT" style="width:140px"></select></td>
							<td><span data-bind="text: vat"></span></td>
						</tr>
						<tr align="right">
							<td>សរុប:</td>
							<td bgcolor="#00BFFF"><span data-bind="text: total"></span></td>
						</tr>
						<tr align="right">
							<td>អត្រាប្ដូរប្រាក់:</td>
							<td><span data-bind="text: rate"></span></td>
						</tr>
						<tr align="right">
							<td>សរុបតាមអតិថិជនរូបិយបណ្ណ:</td>
							<td bgcolor="#AEB404"><span data-bind="text: total_in_customer_currency"></span></td>
						</tr>
					</table>
				</div>													
			</div>

			<br>

			<div class="row-fluid">				
				<div class="span12" align="right">
					<span class="btn btn-primary btn-icon glyphicons print" data-bind="click: linkPrint, visible: isUpdate"><i></i> បោះពុម្ព</span>
					<span class="btn btn-primary btn-icon glyphicons cart_in" data-bind="click: btnCreateInvoice"><i></i> រៀបចំវិក្កយបត្រ</span>
				</div>
			</div>

		</div>
	</div>		
</script>
<script id="receiptRowTemplate" type="text/x-kendo-tmpl">		
	<tr>		
		<td>
			<i class="icon-trash" data-bind="events: { click: removeRow "></i>			
		</td>
		<td class="sno">1</td>
		<td>
			<select data-role="combobox" data-text-field="name" data-value-field="id" 
					data-bind="source: itemList, value: item_id, events: {change : itemChange}">
			</select>
		</td>		
		<td>
			<input type="text" data-bind="value: description" style="margin-bottom: 0;" />
		</td>
		<td>
			<input data-role="numerictextbox" data-format="n0" data-bind="value: quantity, events: {change : change}" 
					style="width: 80px;" />
		</td>				
		<td>
			<input data-role="numerictextbox" data-format="c0" data-bind="value: unit_price, events: {change : change}" 
					style="width: 100px;" />
		</td>		
		<td align="right">
			#:kendo.toString(kendo.parseFloat(quantity)*(kendo.parseFloat(unit_price)*kendo.parseFloat(rate)), 'c0')#			
		</td>
		<td>
			<input type="checkbox" data-bind="checked: vat" />			
		</td>		
    </tr>   
</script>


<!-- Sale Order -->
<script id="soView" type="text/x-kendo-template">
	<div class="row-fluid">
		<div class="span12">
			<h4 align="center">បញ្ជាលក់</h4>
			
			<div class="row-fluid">
				<div class="span8">
					អាសយដ្ឋាន
					<br>
					<textarea id="memo" cols="0" rows="2" class="k-textbox" style="width:250px" data-bind="value: address"></textarea>								
				</div>

				<div class="span4">							
					<table>
						<tr>
							<td>
								លេខបញ្ជាលក់
							</td>
							<td>
								<input class="k-textbox" data-bind="value: number" style="width:138px;" readonly />
							</td>
						</tr>
						<tr>
							<td>
								កាលបរិច្ឆេទ
							</td>
							<td>
								<input data-role="datepicker" data-bind="value: issued_date" data-format="dd-MM-yyyy" />
							</td>
						</tr>
						<tr>
							<td>
								ថ្ងៃរំពឹងទុក
							</td>
							<td>
								<input data-role="datepicker" data-bind="value: expected_date" data-format="dd-MM-yyyy" />
							</td>
						</tr>					
					</table>
				</div>
		    </div>			
			
			<br>

			<div data-role="grid" data-bind="source: soItemList"
		        data-auto-bind="false" data-row-template="soRowTemplate"                  
		        data-columns='[{ title: "#", width: 35 }, 
		            { title: "ទំនិញ", width: 175 },	                     
		            { title: "ពណ៌នា", width: 100 },
		            { title: "ចំនួន", width: 85 },
		            { title: "តំលៃ", width: 105 },            
		            { title: "ទឹកប្រាក់" }		            	                    	                    
		            ]'>
			</div>
			<button class="btn btn-inverse" data-bind="click: addNewRow"><i class="icon-plus icon-white"></i></button>
			
			<div class="row-fluid">
				<div class="span8">
					អាសយដ្ឋាន
					<br>
					<textarea id="memo" cols="0" rows="4" class="k-textbox" style="width:300px" data-bind="value: memo"></textarea>								
				</div>

				<div class="span4">
					<div class="innerAll padding-bottom-none-phone">
						<a data-bind="click: createSO" class="widget-stats widget-stats-primary widget-stats-4">
							<span class="txt">សរុប</span>
							<span class="count" style="font-size: 35px;" data-bind="text: total"></span>
							<span class="glyphicons cart_in"><i></i></span>
							<div class="clearfix"></div>
							<i class="icon-play-circle"></i>
						</a>
					</div>					
				</div>			
			</div>

		</div>
	</div>		
</script>
<script id="soRowTemplate" type="text/x-kendo-tmpl">		
	<tr>		
		<td class="sno">1</td>
		<td>
			<select data-role="combobox" data-text-field="name" data-value-field="id" 
					data-bind="source: itemList, value: item_id, events: {change : itemChange}">
			</select>
		</td>		
		<td>
			<input type="text" data-bind="value: description" style="margin-bottom: 0;" />
		</td>
		<td>
			<input data-role="numerictextbox" data-format="n0" data-bind="value: quantity, events: {change : change}" 
					style="width: 70px;" />
		</td>
		<td>
			<input data-role="numerictextbox" data-format="c0" data-bind="value: unit_price, events: {change : change}" 
					style="width: 90px;" />
		</td>				
		<td align="right">
			#:kendo.toString(kendo.parseFloat(amount), 'c0')#
			<i class="icon-trash" data-bind="events: { click: removeRow "></i>
		</td>		
    </tr>   
</script>


<!-- Estimate -->
<script id="estimateView" type="text/x-kendo-template">
	<div class="row-fluid">
		<div class="span12">
			<h4 align="center">សម្រង់តម្លៃ</h4>
			
			<div class="row-fluid">
				<div class="span8">
					អាសយដ្ឋាន
					<br>
					<textarea id="memo" cols="0" rows="2" class="k-textbox" style="width:250px" data-bind="value: address"></textarea>								
				</div>

				<div class="span4">							
					<table>
						<tr>
							<td>
								លេខសម្រង់តម្លៃ
							</td>
							<td>
								<input class="k-textbox" data-bind="value: number" style="width:138px;" readonly />
							</td>
						</tr>
						<tr>
							<td>
								កាលបរិច្ឆេទ
							</td>
							<td>
								<input data-role="datepicker" data-bind="value: issued_date" data-format="dd-MM-yyyy" />
							</td>
						</tr>										
					</table>
				</div>
		    </div>				
			
			<br>

			<div data-role="grid" data-bind="source: estimateItemList"
		        data-auto-bind="false" data-row-template="estimateRowTemplate"                  
		        data-columns='[{ title: "#", width: 35 }, 
		            { title: "ទំនិញ", width: 175 },	                     
		            { title: "ពណ៌នា", width: 100 },
		            { title: "ចំនួន", width: 85 },
		            { title: "តំលៃ", width: 105 },            
		            { title: "ទឹកប្រាក់" },
		            { title: "Markup", width: 95 },
		            { title: "សរុប" }	                    	                    
		            ]'>
			</div>
			<button class="btn btn-inverse" data-bind="click: addNewRow"><i class="icon-plus icon-white"></i></button>
			
			<div class="row-fluid">
				<div class="span8">
					អាសយដ្ឋាន
					<br>
					<textarea id="memo" cols="0" rows="4" class="k-textbox" style="width:300px" data-bind="value: memo"></textarea>								
				</div>

				<div class="span4">
					<div class="innerAll padding-bottom-none-phone">
						<a data-bind="click: createEstimate" class="widget-stats widget-stats-primary widget-stats-4">
							<span class="txt">សរុប</span>
							<span class="count" style="font-size: 35px;" data-bind="text: total"></span>
							<span class="glyphicons cart_in"><i></i></span>
							<div class="clearfix"></div>
							<i class="icon-play-circle"></i>
						</a>
					</div>					
				</div>
			</div>

		</div>
	</div>		
</script>
<script id="estimateRowTemplate" type="text/x-kendo-tmpl">		
	<tr>		
		<td class="sno">1</td>
		<td>
			<select data-role="combobox" data-text-field="name" data-value-field="id" 
					data-bind="source: itemList, value: item_id, events: {change : itemChange}">
			</select>
		</td>		
		<td>
			<input type="text" data-bind="value: description" style="margin-bottom: 0;" />
		</td>
		<td>
			<input data-role="numerictextbox" data-format="n0" data-bind="value: quantity, events: {change : change}" 
					style="width: 70px;" />
		</td>
		<td>
			<input data-role="numerictextbox" data-format="c0" data-bind="value: unit_price, events: {change : change}" 
					style="width: 90px;" />
		</td>				
		<td align="right">
			#:kendo.toString(kendo.parseFloat(amount), 'c0')#			
		</td>
		<td>
			<input data-role="numerictextbox" data-format="c0" data-bind="value: markup, events: {change : change}" 
					style="width: 85px;" />
		</td>
		<td align="right">
			#:kendo.toString(kendo.parseFloat(amount) + kendo.parseFloat(markup), 'c0')#
			<i class="icon-trash" data-bind="events: { click: removeRow "></i>
		</td>		
    </tr>   
</script>


<!-- Goods Delivery Note -->
<script id="gdnView" type="text/x-kendo-template">
	<div class="row-fluid">
		<div class="span12">
			<h4 align="center">លិខិតដឹកជញ្ជូន</h4>
			
			<div class="row-fluid">
				<div class="span8">
					អាសយដ្ឋាន
					<br>
					<textarea id="memo" cols="0" rows="2" class="k-textbox" style="width:250px" data-bind="value: address"></textarea>								
				</div>

				<div class="span4">			
					<table>
						<tr>
							<td>
								លេខលិខិតដឹកជញ្ជូន
							</td>
							<td>
								<input class="k-textbox" data-bind="value: number" style="width:138px;" readonly />
							</td>
						</tr>
						<tr>
							<td>
								លេខរួម
							</td>
							<td>
								<input class="k-textbox" data-bind="value: batch_no" style="width:138px;" />
							</td>
						</tr>
						<tr>
							<td>
								កាលបរិច្ឆេទ
							</td>
							<td>
								<input data-role="datepicker" data-bind="value: issued_date" data-format="dd-MM-yyyy" />
							</td>
						</tr>					
					</table>
				</div>							         		          	
		    </div>			
			
			<br>

			<div data-role="grid" data-bind="source: gdnItemList"
		        data-auto-bind="false" data-row-template="gdnRowTemplate"                  
		        data-columns='[{ title: "#", width: 35 }, 
		            { title: "ទំនិញ", width: 200 },	                     
		            { title: "ពណ៌នា", width: 200 },
		            { title: "ចំនួន", width: 100 }		            	                    	                    
		            ]'>
			</div>
			<button class="btn btn-inverse" data-bind="click: addNewRow"><i class="icon-plus icon-white"></i></button>
			
			<div class="row-fluid">
				<div class="span8">
					អាសយដ្ឋាន
					<br>
					<textarea id="memo" cols="0" rows="4" class="k-textbox" style="width:300px" data-bind="value: memo"></textarea>								
				</div>

				<div class="span4" align="right">			
					<button id="add" class="btn btn-primary" data-bind="click: createGDN"><i class="icon-hdd icon-white"></i> កត់ត្រា</button> 					
				</div>			
			</div>

		</div>
	</div>		
</script>
<script id="gdnRowTemplate" type="text/x-kendo-tmpl">		
	<tr>		
		<td class="sno">1</td>
		<td>
			<select data-role="combobox" data-text-field="name" data-value-field="id" 
					data-bind="source: itemList, value: item_id, events:{ change: itemChange }" style="width: 200px">
			</select>
		</td>		
		<td>
			<input type="text" data-bind="value: description" style="margin-bottom: 0;" />
		</td>
		<td>
			<input data-role="numerictextbox" data-format="n0" data-bind="value: quantity" style="width: 140px" />
		</td>				
    </tr>   
</script>


<!-- Notice -->
<script id="noticeView" type="text/x-kendo-template">
	<div class="row-fluid">
		<div class="span12">
			
			<div class="widget widget-tabs widget-tabs-double widget-tabs-gray">
			
				<!-- Tabs Heading -->
				<div class="widget-head">
					<ul>
						<li class="active"><a href="#tab1-2" class="glyphicons calculator" data-toggle="tab"><i></i><span class="strong">ជំហានទី ១</span><span>រកថាមពលមធ្យម</span></a></li>
						<li><a href="#tab2-2" class="glyphicons notes" data-toggle="tab"><i></i><span class="strong">ជំហានទី ២</span><span>បង្កើតលិខិតរំលឹក</span></a></li>						
					</ul>
				</div>
				<!-- // Tabs Heading END -->
				
				<div class="widget-body">
					<div class="tab-content">					
						<!-- // Tab content -->
						<div class="tab-pane active" id="tab1-2">
							<div>											
								<select data-role="combobox" data-text-field="meter_no" data-value-field="id" 
									data-bind="source: meterList, value: meter, events: {change : meterChange}" placeHolder="កុងទ៍រ"></select>				
							</div>
							
							<div class="row-fluid">
								<div class="span6">
									<div data-role="grid" data-bind="source: readingList"
							            data-auto-bind="false" data-row-template="readingRowTemplate"                  
							            data-columns='[	                 	
							                { title: "", width: 30 },
							                { title: "ថ្ងៃអាន" },
							                { title: "ដល់" },	                     
							                { title: "អំនានសរុប" }							                                    	                    
							                ]'>
									</div>									
								</div>

								<div class="span6">
									<table width="100%">
										<tr>
											<td>ថាមពលមធ្យម</td>
											<td>
												<span data-bind="text: totalReading"></span> Kw
												/
												<span data-bind="text: selectedReading"></span>
												=
												<span data-bind="text: avg"></span> Kw
											</td>											
										</tr>
										<tr>
											<td>ថាមពលប្រើប្រាស់ក្នុងមួយថ្ងៃ</td>
											<td>
												<span data-bind="text: avg"></span> Kw
												/ 30 ថ្ងៃ =												
												<span data-bind="text: usage_per_day"></span> Kw
											</td>											
										</tr>
									</table>

									<span class="btn btn-primary btn-icon glyphicons refresh" data-bind="click: reset"><i></i>លុបចោល</span>
									
								</div>
							</div>
						</div>
						<!-- // Tab content END -->
						
						<!-- // Tab content -->
						<div class="tab-pane" id="tab2-2">
							<h4 align="center">លិខិតដឹកជញ្ជូន</h4>

							<div class="row-fluid">
								<div class="span8">
									<table cellpadding="2" cellspacing="2">										        
										<tr>
							                <td>Class</td>
							              	<td><select data-role="combobox" data-text-field="name" data-value-field="id" data-bind="source: classList, value: class_id"></select></td>
							            <tr>            
										<tr>
											<td colspan="2">
												ទីតាំង
												<br>
												<textarea id="address" cols="0" rows="2" class="k-textbox" style="width:250px" data-bind="value: address"></textarea>
											</td>
										</tr>
									</table>
								</div>	

								<div class="span4">							
									<table cellpadding="2" cellspacing="2">
										<tr>				
											<td>លេខវិក្ក​យបត្រ	</td>
											<td><input class="k-textbox" data-bind="value: number" style="width:140px;" readonly /></td>
										</tr>			
										<tr>
											<td>ថ្ងៃចេញលិខិតរំលឹក</td>
											<td><input data-role="datepicker" data-bind="value: issued_date" data-format="dd-MM-yyyy" /></td>
										</tr>
										<tr>
							                <td>កាលកំណត់</td>
							              	<td><select data-role="combobox" data-text-field="term" data-value-field="id" data-bind="source: paymentTermList, value: payment_term_id"></select></td>
							            <tr>
										<tr>
											<td>ថ្ងៃបង់ប្រាក់</td>
											<td><input data-role="datepicker" data-bind="value: due_date" data-format="dd-MM-yyyy" /></td>
										</tr>																            
									</table>
								</div>           		          	
						    </div>													

							<div data-role="grid" data-bind="source: noticeItemList"
						        data-auto-bind="false" data-row-template="noticeRowTemplate"                  
						        data-columns='[						        	
						            { title: "អំនានប្រចាំខែ", width: 135 },	                     
						            { title: "ចំនួនថ្ងៃ", width: 85 },
						            { title: "Kw/ថ្ងៃ", width: 55 },
						            { title: "ថាមពល", width: 60 },						            
						            { title: "តំលៃរាយ" },
						            { title: "ទឹកប្រាក់" },
						            { title: "ប្រាក់បង់រូច" },
						            { title: "ទឹកប្រាក់សរុប" }	                    	                    
						        ]'>
							</div>							
							<button class="btn btn-inverse" data-bind="click: addNewRow"><i class="icon-plus icon-white"></i></button>
							
							<div class="row-fluid">
								<div class="span8">
									អាសយដ្ឋាន
									<br>
									<textarea id="memo" cols="0" rows="4" class="k-textbox" style="width:300px" data-bind="value: memo"></textarea>								
								</div>

								<div class="span4">			
									<div class="innerAll padding-bottom-none-phone">
										<a data-bind="click: createNotice" class="widget-stats widget-stats-primary widget-stats-4">
											<span class="txt">សរុប</span>
											<span class="count" style="font-size: 35px;" data-bind="text: total"></span>
											<span class="glyphicons cart_in"><i></i></span>
											<div class="clearfix"></div>
											<i class="icon-play-circle"></i>
										</a>
									</div>	 					
								</div>			
							</div>

						</div>
						<!-- // Tab content END -->
						
					</div>					
				</div>
			</div>			

		</div>	
	</div>		
</script>
<script id="readingRowTemplate" type="text/x-kendo-tmpl">		
	<tr>
		<td><input type="checkbox" data-bind="checked: isCheck, events: {change : checkboxChange}"></td>				
		<td>#:kendo.toString(date_read_from, 'dd-MM-yyyy')#</td>		
		<td>#:kendo.toString(date_read_to, 'dd-MM-yyyy')#</td>		
		<td>#:active_usage#</td>				
    </tr>   
</script>
<script id="noticeRowTemplate" type="text/x-kendo-tmpl">		
	<tr>				
		<td>
			<input data-role="datepicker" data-bind="value: month_of, events: {change : monthOfChange}" 
				data-start="year" data-depth="year"	data-format="MM-yyyy" style="width:120px;" />
		</td>		
		<td>
			<input data-role="numerictextbox" data-format="n0" data-min="0" data-max="30" 
				data-bind="value: days" style="width: 70px;">
		</td>
		<td align="right">#:usage_per_day#</td>
		<td align="right">#:kendo.parseInt(days*usage_per_day)#</td>
		<td align="right">#:kendo.toString(unit_price, 'c0')#</td>
		<td align="right">#:kendo.toString((kendo.parseInt(days*usage_per_day))*unit_price, 'c0')#</td>
		<td align="right">#:kendo.toString(amount_paid, 'c0')#</td>		
		<td align="right">
			#:kendo.toString(((kendo.parseInt(days*usage_per_day))*unit_price)-amount_paid, 'c0')#
			<i class="icon-trash" data-bind="events: { click: removeRow "></i>
		</td>					
    </tr>   
</script>


<!-- Statement -->
<script id="statementView" type="text/x-kendo-template">
	<div class="row-fluid">    
		<div class="span12">
			<div id="example" class="k-content">
				<div>
					<input data-role="datepicker" data-format="dd-MM-yyyy" data-bind="value: statement_date" placeholder="កាលបរិច្ឆេទ" />
					<br>
					<input data-role="datepicker" data-format="dd-MM-yyyy" data-bind="value: start_date" placeholder="ចាប់ពី" />
					<input data-role="datepicker" data-format="dd-MM-yyyy" data-bind="value: end_date" placeholder="ដល់" />
					<button type="button" class="btn btn-default" data-bind="click: loadStatement"><i class="icon-eye-open"></i></button>
					<button type="button" class="btn btn-default" data-bind="click: printStatement"><i class="icon-print"></i></button>					
				</div>				

				<div id="divStatement">
					<h3 align="center">តុល្យបញ្ជី</h3>
			        
		        	<div class="pull-right">		          	
			          	<p>
			              	កាលបរិច្ឆេទ
			              	<span data-bind="text: statement_date_text"></span>
			              	<br>
				          	ប្រាក់ត្រូវបង់
			          	</p>		          	

			          	<div align="right">		          		
			          		<span style="color: white; font-size: 30px; background-color:maroon; border:0px solid black; padding: 5px;" data-bind="text: amount_due"></span>		          			          		
			          	</div>		          	
			        </div>

			        <div>
			        	ឈ្មោះ 
			        	<span data-bind="text: fullname"></span>
			        	<br>
			          	អាសយដ្ឋាន
			          	<br>
			          	<textarea name="address" id="address" cols="" rows="3" data-bind="text: address"></textarea>
			        </div>

			        <div data-role="grid" data-bind="source: statementList"
				        data-auto-bind="false" data-row-template="statementRowTemplate"                  
				        data-columns='[						        	
				            { title: "កាលបរិច្ឆេទ" },	                     
				            { title: "បរិយាយ" },
				            { title: "ទឹកប្រាក់" },
				            { title: "សមតុល្យ" }                    	                    
				        ]'>
					</div>

					<br>

					<div data-role="grid" data-bind="source: agingList"
				        data-auto-bind="false" data-row-template="agingRowTemplate"                  
				        data-columns='[						        	
				            { title: "បច្ចុប្បន្ន" },	                     
				            { title: "១-៣០ថ្ងៃ" },
				            { title: "៣១-៦០ថ្ងៃ" },
				            { title: "៦១-៩០ថ្ងៃ" },
				            { title: "លើសពី ៩០ថ្ងៃ" },
				            { title: "ទឹកប្រាក់ត្រូវបង់" }                    	                    
				        ]'>
					</div>			        

				</div>

			</div>           
		</div> 		
	</div> 		
</script>
<script id="statementRowTemplate" type="text/x-kendo-tmpl">		
	<tr>		
		<td>#:kendo.toString(new Date(issued_date), 'dd-MM-yyyy')#</td>
		<td>#:description#</td>
		<td align="right">#:kendo.toString(kendo.parseFloat(amount), 'c0')#</td>		
		<td align="right">
			#:kendo.toString(kendo.parseFloat(balance), 'c0')#			
		</td>					
    </tr>   
</script>
<script id="agingRowTemplate" type="text/x-kendo-tmpl">		
	<tr>		
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
	//Global variables
	var meter_type_id = 1;
	var breaker_type_id = 2;

	//DataSources	
	var monthlySaleDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/invoices/monthly_sale",
				type: "GET",
				dataType: "json"
			}
		},
		serverFiltering: true
	});

	var customerDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/people_api/customer_search",
				type: "GET",
				dataType: "json"
			},
			update: {
				url: ARNY.baseUrl + "api/people_api/people",
				type: "PUT",
				dataType: "json"
			}
		},		
		schema: {
			model: {
				id: "id"
			}
		},
		serverPaging: true,		
		pageSize: 100,
		serverFiltering: true
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

	var statementCollectionDS = new kendo.data.DataSource({
	  	transport: {	  
		  	read: {
			  	url : ARNY.baseUrl + "api/invoices/statement_collection",
			  	type: "GET",
			  	dataType: "json"		  
		  	}
	  	},	  	
	  	pageSize: 10,		
		serverFiltering: true
	});

	var statementDS = new kendo.data.DataSource({
	  	transport: {	  
		  	read: {
			  	url : ARNY.baseUrl + "api/invoices/statement",
			  	type: "GET",
			  	dataType: "json"		  
		  	},
		  	parameterMap: function(options, operation) {			   
		   		if (operation === "read") {			  
			  		return { 
				  		customer_id	: statementModel.get("customer_id"),
						start_date	: kendo.toString(statementModel.get("start_date"), "yyyy-MM-dd"),
						end_date	: kendo.toString(statementModel.get("end_date"), "yyyy-MM-dd")
				  	};
		   		}
		 		return options;  
			}
	  	},
	  	requestEnd: function(e) {
		    var response = e.response;
		    var type = e.type;
		    if(type==='read'){
		    	if(response.length>0){
		    		var lastIndex = response.length-1;
		    		var d = response[lastIndex];

		    		statementModel.set("amount_due", kendo.toString(d.balance, 'c0'));
		    	}
		    }
		}	
	});

	var agingDS = new kendo.data.DataSource({
	  	transport: {	  
		  	read: {
			  	url : ARNY.baseUrl + "api/invoices/aging",
			  	type: "GET",
			  	dataType: "json"		  
		  	},
		  	parameterMap: function(options, operation) {			   
		   		if (operation === "read") {			  
			  		return { 
				  		customer_id	: statementModel.get("customer_id"),
						start_date	: kendo.toString(statementModel.get("start_date"), "yyyy-MM-dd"),
						end_date	: kendo.toString(statementModel.get("end_date"), "yyyy-MM-dd")
				  	};
		   		}
		 		return options;  
			}
	  	}	  		
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

	var cashAccountDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/accounts/account",
				type: "GET",
				dataType: "json"
			}
		},
		filter: { field: "account_type_id", value: 6 },
		serverFiltering: true
	});

	var tariffPlanDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/tariff_plans/tariff_plan",
				type: "GET",
				dataType: "json"
			}
		}
	});

	var planItemDS = new kendo.data.DataSource({
	  	transport: {	  
		  	read: {
			  	url : ARNY.baseUrl + "api/plan_items/plan_item",
			  	type: "GET",
			  	dataType: "json"
		  	}
	  	},  
	  	sort: { field: "start_date", dir: "desc" }
	});

	var tariffDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/tariffs/tariff",
				type: "GET",
				dataType: "json"
			}
		}
	});

	var tariffItemDS = new kendo.data.DataSource({
	  	transport: {	  
		  	read: {
			  	url : ARNY.baseUrl + "api/tariff_items/tariff_item",
			  	type: "GET",
			  	dataType: "json"
		  	}
	  	},  
	  	sort: { field: "usage", dir: "desc" },
  		serverSorting: true  
	});

	var exemptionDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/exemptions/exemption",
				type: "GET",
				dataType: "json"
			}
		}
	});

	var maintenanceDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/maintenances/maintenance",
				type: "GET",
				dataType: "json"
			}
		}
	});

	var ampereDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricity_unit_api/ampere",
				type: "GET",
				dataType: "json"
			}
		}
	});

	var phaseDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricity_unit_api/phase",
				type: "GET",
				dataType: "json"
			}
		}
	});

	var voltageDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricity_unit_api/voltage",
				type: "GET",
				dataType: "json"
			}
		}
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

	var classDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/classes/class",
				type: "GET",
				dataType: "json"
			}
		},
		filter: { field: "type", value: "Class" },
		serverFiltering: true		
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

	var transformerSearchDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricities/transformer_cascading",
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

	var electricityBoxDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricity_boxes/electricity_box",
				type: "GET",
				dataType: "json"
			}
		},
		serverFiltering: true
	});

	var electricityPoleDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricity_poles/electricity_pole",
				type: "GET",
				dataType: "json"
			}
		},
		serverFiltering: true
	});

	var meterDS = new kendo.data.DataSource({
		transport: {	
	  	  	read:  {
			  	url: ARNY.baseUrl + "api/meters/meter",
			  	type: "GET",
			  	dataType: "json"
		  	},
		  	update: {
			  	url: ARNY.baseUrl + "api/meters/meter",
			  	type: "PUT",
			  	dataType: "json"
		  	},
		  	destroy: {
			  	url: ARNY.baseUrl + "api/meters/meter",
			  	type: "DELETE",
			  	dataType: "json"
		  	},  
		  	create: {
			  	url: ARNY.baseUrl + "api/meters/meter",
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
		requestEnd : function(e){
			var type = e.type;
			if(type==="create" || type==="update"){  				
  				meterDS.read();				
  			}  			
		},  
		schema: {
			model: {
				id : "id"		 
			}		
		},
		serverFiltering: true
	});

	var breakerDS = new kendo.data.DataSource({
		transport: {
		  	read:  {
			  	url: ARNY.baseUrl + "api/breakers/breaker",
			  	type: "GET",
			  	dataType: "json"
		  	},
		  	update: {
			  	url: ARNY.baseUrl + "api/breakers/breaker",
			  	type: "PUT",
			  	dataType: "json"
		  	},
		  	destroy: {
			  	url: ARNY.baseUrl + "api/breakers/breaker",
			  	type: "DELETE",
			  	dataType: "json"
		  	},	  
		  	create: {
			  	url : ARNY.baseUrl + "api/breakers/breaker",
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
		requestEnd : function(e){
			if(e.type==="create" || e.type==="update"){
  				breakerDS.read();
  			}
		},  
	  	schema: {
		  	model: {
			  	id : "id"
		  	}		
	  	},
		serverFiltering: true
	});

	var meterItemDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/inventory_api/item_by",
				type: "GET",
				dataType: "json"
			}
		},
		serverFiltering: true,				
		filter:	{ field: "parent_id", value: meter_type_id }
	});

	var breakerItemDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/inventory_api/item_by",
				type: "GET",
				dataType: "json"
			}
		},
		serverFiltering: true,				
		filter: { field: "parent_id", value: breaker_type_id }
	});

	var parentMeterDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/meters/meter",
				type: "GET",
				dataType: "json"
			}
		},
		serverFiltering: true		
	});

	var meterReadingDS = new kendo.data.DataSource({
	  	transport: {	
	  	  	read:  {
			  	url: ARNY.baseUrl + "api/meters/meter_reading",
			  	type: "GET",
			  	dataType: "json"
		  	}
	  	},	  	
	  	serverFiltering: true
	});

	var meterRecordDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/meter_records/meter_record",
				type: "GET",
				dataType: "json"
			},
			update: {
			  	url: ARNY.baseUrl + "api/meter_records/meter_record",
			  	type: "PUT",
			  	dataType: "json"
		  	},
		  	create: {
			  	url: ARNY.baseUrl + "api/meter_records/meter_record_batch",
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
	  	requestEnd: function(e) {
		    var response = e.response;
		    var type = e.type;
		    
		    if(type==="create"){
		    	meterReadingDS.read();
		    }
	  	}, 
	  	schema: {
		  	model: {
			  	id : "id"
		  	}		
	  	},
	  	sort: { field: "date_read_from", dir: "desc" },
	  	serverPaging: true,	  	
		pageSize: 12,
		serverFiltering: true		
	});

	var usageDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/meter_records/usage",
				type: "GET",
				dataType: "json"
			}
		},	  		  	
		serverFiltering: true		
	});

	var readerDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/employees/index",
				type: "GET",
				dataType: "json"
			}
		},
		schema: {
			data: "employees",
			total: "total"
		}		
	});
	
	var paymentTermDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/payment_terms/payment_term",
				type: "GET",
				dataType: "json"
			}
		}		
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

	var currencyRateDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/currency_rates/currency_rate",
				type: "GET",
				dataType: "json"
			}
		}		
	});

	var paymentMethodDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/payment_methods/payment_method",
				type: "GET",
				dataType: "json"
			}
		}
	});
	
	var itemDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/inventory_api/item_dropdown",
				type: "GET",
				dataType: "json"
			}
		}
	});

	var vatDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/inventory_api/items",
				type: "GET",
				dataType: "json"
			}
		},
		filter: { field: "item_type_id", value: 6 },
		serverFiltering: true
	});
	
	var invoiceDS = new kendo.data.DataSource({
	  	transport: {
		  	read: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
			  	type: "GET",
			  	dataType: "json"
		  	},
		  	create: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
			  	type: "POST",
			  	dataType: "json"
		  	},
		  	update: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
			  	type: "PUT",
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
			  	id : "id"
		  	}		
	  	},
	  	requestEnd: function(e) {
		    var response = e.response;
		    var type = e.type;
		    if(type==='read'){
		    	invoiceModel.set("invoiceEdit", response);
		    	invoiceModel.loadInvoiceEdit();
		    }
		},	  	
	  	serverFiltering : true	  	
	});

	var invoiceItemDS = new kendo.data.DataSource({
	  	transport: {		  	
		  	create: {
			  	url : ARNY.baseUrl + "api/invoice_items/invoice_item_batch",		  
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
			  	id : "id"
		  	}		
	  	},
	  	batch: true	  		  	
	});
	
	var estimateDS = new kendo.data.DataSource({
	  	transport: {
		  	read: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
			  	type: "GET",
			  	dataType: "json"
		  	},
		  	update: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
			  	type: "PUT",
			  	dataType: "json"
		  	}
	  	},	  		  	
	  	serverFiltering : true	  	
	});

	var gdnDS = new kendo.data.DataSource({
	  	transport: {
		  	read: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
			  	type: "GET",
			  	dataType: "json"
		  	},
		  	update: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
			  	type: "PUT",
			  	dataType: "json"
		  	}
	  	},
	  	schema: {
		  	model: {
			  	id : "id"
		  	}		
	  	},		  		  	
	  	serverFiltering : true	  	
	});

	var soDS = new kendo.data.DataSource({
	  	transport: {
		  	read: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
			  	type: "GET",
			  	dataType: "json"
		  	},
		  	update: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
			  	type: "PUT",
			  	dataType: "json"
		  	}
	  	},
	  	schema: {
		  	model: {
			  	id : "id"
		  	}		
	  	},		  		  	
	  	serverFiltering : true	  	
	});

	var paymentDS = new kendo.data.DataSource({
	  	transport: {  		
		  	create: {
			  	url : ARNY.baseUrl + "api/payments/payment",		  
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
			  	id : "id"
		  	}		
	  	}  	
	});

	var journalDS = new kendo.data.DataSource({
	  	transport: {	  
		    create: {
			  	url : ARNY.baseUrl + "api/accounting_api/journals",
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
			  	id : "id"
		  	}		
	  	}
	});
	
	
	//View Models
	var dashBoardModel	= kendo.observable({
		company_id 			: 1,
		
		companyList 		: companyDS,
		monthlySaleList   	: monthlySaleDS,		
		
		pageLoad 	: function(){
			this.change();
		},
		change 		: function(){
			var company_id = this.get("company_id");

			if(company_id>0){				
				monthlySaleDS.filter({ field: "company_id", value: company_id });

				$.ajax({
					type: "GET",
		            url : ARNY.baseUrl + "api/invoices/customer_dashboard",	            
		            data: {
						company_id	: company_id				
					},
					dataType: "json",
		            success : function(response){
		            	var acus = kendo.toString(response.active_customer, 'n0');
		            	var upcus = kendo.toString(response.unpaid_customer, 'n0');
		            	var strtcus = upcus +'/'+ acus + ' នាក់';
		            	
		            	dashBoardModel.set("total_customer", strtcus);
		            	dashBoardModel.set("total_debt", kendo.toString(response.total_debt, 'c0'));
		            }
		        });
			}
		}
	});

	var customerModel	= kendo.observable({
		customer_id 	: 0,
		transformer_id  : null,
		deposit_amount 	: kendo.toString(0,'c0'),			
		balance 		: kendo.toString(0,'c0'),				
		
		genders	 		: ["ប", "ស"],	  	  
		gender	 		: "ប",

		isEdit 			: false,
		isExistingNumber: false,
		customer 		: null,
		selectedRow 	: null,

		statusList 		: [
			{"id":"0", "name":"ឈប់ប្រើប្រាស់"},
			{"id":"1", "name":"កំពុងប្រើប្រាស់"},
			{"id":"2", "name":"ផ្អាក់ប្រើប្រាស់"}
		],
		
		customerTypeList: customerTypeDS,
		companyList		: companyDS,
		transformerList : transformerDS,
		provinceList 	: provinceDS,
		districtList 	: districtDS,
		communeList	 	: communeDS,
		villageList 	: villageDS,

		tariffPlanList 	: tariffPlanDS,
		exemptionList 	: exemptionDS,
		maintenanceList : maintenanceDS,

		ampereList		: ampereDS,
		phaseList		: phaseDS,
		voltageList 	: voltageDS,

		currencyList 	: currencyDS,
		accountList 	: accountDS,
		revenueAccountList : revenueAccountDS,

		usageList 		: usageDS,
		statementCollectionList: statementCollectionDS,		

		pageLoad		: function(id) {
			var cus = customerDS.get(id);

			this.set("customer_id", id);
			this.set("customer", cus);						
			this.set("balance", kendo.toString(kendo.parseFloat(cus.balance), 'c0'));
			
			statementCollectionDS.filter({ field: "customer_id", value: id });
			
			usageDS.filter({
				filters: [
					{ field: "customer_id", value: id },
					{ field: "status", value: 1 },
					{ field: "parent_id", value: 0 }
				]
			});
		},
		pageLoadEdit : function(id){			
			var cus = this.get("customer");

			this.set("people_type_id", cus.people_type_id);
			this.set("number", cus.number);
			this.set("customer_no_origin", cus.number);
			this.set("surname", cus.surname);
			this.set("name", cus.name);				  	  
			this.set("gender", cus.gender);
			this.set("dob", new Date(cus.dob));
			this.set("pob", cus.pob);
			this.set("phone", cus.phone);
			this.set("email", cus.email);
			this.set("family_member", cus.family_member);
			this.set("memo", cus.memo);
			this.set("image_url", cus.image_url);
			this.set("card_number", cus.card_number);
			this.set("job", cus.job);
			this.set("company", cus.company);
			this.set("bank_account", cus.bank_account);
			this.set("deposit_amount", kendo.toString(kendo.parseFloat(cus.deposit_amount), "c0"));			
			
			this.set("zip_code", cus.zip_code);
			this.set("address", cus.address);
			this.set("address2", cus.address2);
			this.set("ship_to", cus.ship_to);
			
			this.set("transformer_id", cus.transformer_id);						
			this.set("province_id", cus.province_id);
			this.set("district_id", cus.district_id);
			this.set("commune_id", cus.commune_id);
			this.set("village_id", cus.village_id);
			this.set("latitute", cus.latitute);
			this.set("longtitute", cus.longtitute);

			this.set("ampere_id", cus.ampere_id);
			this.set("phase_id", cus.phase_id);
			this.set("voltage_id", cus.voltage_id);

			this.set("tariff_plan_id", cus.tariff_plan_id);
			this.set("maintenance_id", cus.maintenance_id);
			this.set("exemption_id", cus.exemption_id);
			this.set("round_settle", cus.round_settle);

			this.set("status", cus.status);
			this.set("registered_date", new Date(cus.registered_date));

			this.set("currency_code", cus.currency_code);
			this.set("vat_no", cus.vat_no);
			this.set("account_receiveable_id", cus.account_receiveable_id);
			this.set("revenue_account_id", cus.revenue_account_id);
			
			this.set("company_id", cus.company_id);										
		},

		//Links		
		gotoMapView			: function() {
			var uri = "#/" + this.get("customer_id").id + "/map/" + this.get("customer").latitute + "/" +this.get("customer").longtitute;
			router.navigate(uri);
		},		
		gotoDashBoardView 	: function() {			
			var uri = "";
			router.navigate(uri);
		},
		gotoCustomerView 	: function() {			
			var uri = "#/" + this.get("customer_id");
			router.navigate(uri);
		},		
		gotoEditCustomerView		: function() {
			var type = this.get("customer").customer_type;
			if(type==="electricity"){
				var uri = "#/" + this.get("customer_id") + "/editElectricityCustomer";
				router.navigate(uri);
			}else if(type==="normal"){
				var uri = "#/" + this.get("customer_id") + "/editNormalCustomer";
				router.navigate(uri);
			}			
		},
		gotoMeterView		: function() {			
			var uri = "#/" + this.get("customer_id") + "/meter";
			router.navigate(uri);
		},
		gotoInvoiceView		: function() {			
			var uri = "#/" + this.get("customer_id") + "/0/invoice";
			router.navigate(uri);
		},
		gotoReceiptView		: function() {			
			var uri = "#/" + this.get("customer_id") + "/receipt";
			router.navigate(uri);
		},
		gotoEstimateView	: function() {			
			var uri = "#/" + this.get("customer_id") + "/estimate";
			router.navigate(uri);
		},
		gotoSOView	: function() {			
			var uri = "#/" + this.get("customer_id") + "/so";
			router.navigate(uri);
		},
		gotoGDNView	: function() {			
			var uri = "#/" + this.get("customer_id") + "/gdn";
			router.navigate(uri);
		},
		gotoNoticeView		: function() {			
			var uri = "#/" + this.get("customer_id") + "/notice";
			router.navigate(uri);
		},
		gotoStatementView	: function() {			
			var uri = "#/" + this.get("customer_id") + "/statement";
			router.navigate(uri);
		},		
		gotoAddMeterRecordView		: function() {			
			var uri = "#/" + this.get("customer_id") + "/meterRecord";
			router.navigate(uri);
		},

		//Statment Collegetion Navigations
		change: function(eventArgs) {
	        this.set("selectedRow", eventArgs.sender.dataItem(eventArgs.sender.select()));
	        var id = this.get("selectedRow").id;
	        var no = this.get("selectedRow").number;
	       
	        switch(this.get("selectedRow").type){
	        case "Estimate", "Receipt", "GDN", "SO":
			  	window.open(ARNY.baseUrl + 'customer/invoice_preview/' + id,'_blank',false);
			  	break;
			case "Invoice":
				var uri = "#/" + this.get("customer_id") +"/"+ id +"/invoice";
				router.navigate(uri);			  	
			  	break;
			case "eInvoice":
			  	window.open(ARNY.baseUrl + 'customer/print_invoice/' + no,false);
			  	break;			
			case "Notice":
			  	window.open(ARNY.baseUrl + 'customer/notice_form/' + id,'_blank',false);
			  	break;
			default:
			  	
			}
	    },

	    //Add edit customer
	    checkExistingNumber : function(){
			var customerNo = this.get("number");
			var customerNoOrigin = this.get("customer_no_origin");

			if((customerNo.length>4) && (number!==customerNoOrigin)){
				$.ajax({
					type: "GET",
		            url : ARNY.baseUrl + "api/people_api/check_existing_customer_no",	            
		            data: {
						number	: customerNo				
					},
					dataType: "json",
		            success : function(response){
		            	customerModel.set("isExistingNumber", response);
		                if(response){	                	
		                	customerModel.set("msgCustomerNo", "លេខកូដនេះបានប្រើប្រាស់រូចហើយ");
		                }else{	                	
		                	customerModel.set("msgCustomerNo", "");
		                }
		            }
		        });
	        }
		},
		btnAddCustomerClick : function(e){
			e.preventDefault();			
			var validator = $(e.currentTarget).parent();
			var validated = validator.kendoValidator().data("kendoValidator");

			var status = $(e.currentTarget).parent().find("#msgStatus");
			var isExistingNumber = this.get("isExistingNumber");

	        if(validated.validate() && isExistingNumber==false){
	        	this.editCustomer();
	            status.text("ែកប្រែបានសំរេច")
	                .removeClass("alert alert-warning")
	                .addClass("alert alert-success");
	        }else{
	            status.text("សូមត្រួតពិនិត្រឪ្យបានត្រឹមត្រូវម្ដងទៀត")
	                .removeClass("alert alert-success")
	                .addClass("alert alert-warning");
	        }
		},	
		editCustomer		: function(){
			var id = this.get("customer_id");
			var cus = customerDS.get(id);

			cus.set("people_type_id", this.get("people_type_id"));
			cus.set("number", this.get("number"));
			cus.set("surname", this.get("surname"));
			cus.set("name", this.get("name"));				  	  
			cus.set("gender", this.get("gender"));
			cus.set("dob", kendo.toString(this.get("dob"), 'yyyy-MM-dd'));
			cus.set("pob", this.get("pob"));
			cus.set("phone", this.get("phone"));
			cus.set("email", this.get("email"));
			cus.set("family_member", this.get("family_member"));
			cus.set("memo", this.get("memo"));
			cus.set("image_url", this.get("image_url"));
			cus.set("card_number", this.get("card_number"));
			cus.set("job", this.get("job"));
			cus.set("company", this.get("company"));
			cus.set("bank_account", this.get("bank_account"));
			
			cus.set("zip_code", this.get("zip_code"));			
			cus.set("address", this.get("address"));
			cus.set("address2", this.get("address2"));
			cus.set("ship_to", this.get("ship_to"));

			cus.set("province_id", this.get("province_id"));
			cus.set("district_id", this.get("district_id"));
			cus.set("commune_id", this.get("commune_id"));
			cus.set("village_id", this.get("village_id"));

			cus.set("latitute", this.get("latitute"));
			cus.set("longtitute", this.get("longtitute"));

			cus.set("status", this.get("status"));
			cus.set("registered_date", kendo.toString(this.get("registered_date"), 'yyyy-MM-dd'));

			cus.set("currency_code", this.get("currency_code"));
			cus.set("vat_no", this.get("vat_no"));
			cus.set("account_receiveable_id", this.get("account_receiveable_id"));
			cus.set("revenue_account_id", this.get("revenue_account_id"));			

			cus.set("company_id", this.get("company_id"));

			//Electricity Customer
			var type = cus.customer_type;
			if(type==="electricity" || type==="water"){						
				cus.set("transformer_id", this.get("transformer_id"));				

				cus.set("ampere_id", this.get("ampere_id"));
				cus.set("phase_id", this.get("phase_id"));
				cus.set("voltage_id", this.get("voltage_id"));

				cus.set("tariff_plan_id", this.get("tariff_plan_id"));
				cus.set("maintenance_id", this.get("maintenance_id"));
				cus.set("exemption_id", this.get("exemption_id"));
				cus.set("round_settle", this.get("round_settle"));
			}
			
			customerDS.sync();		
		}
	});
	
	var meterModel	= kendo.observable({
		customer_id 		: 0,
		meter_id			: 0,
		meter_no			: "",
		multiplier			: 1,
		max_digit 			: "",		
		status				: 1,//Active	
		ear_sealed			: 1,
		cover_sealed		: 1,	
		tariff_id			: "",
		memo				: "",

		fullIdName 			: "",	
		
		item_id				: "",
		electricity_box_id	: "",
		date_used			: new Date(),	
		parent_id 			: "",

		transformer_id				: "",	
		electricity_pole_id	: "",

		statuses			: [
	        { name: "ប្រើប្រាស់", value: "1" },
	        { name: "ឈប់ប្រើ", value: "0" }	        
	    ],
		hasOrNot			: [
	        { name: "មាន", value: "1" },
	        { name: "គ្មាន", value: "0" }	        
	    ],
							
		//Breaker
		breaker_id			: 0,
		name_brker			: "",
		status_brker		: 1,//Active
		item_id_brker		: "",	
		date_used_brker		: new Date(),
		
		hasTariff			: false,
		isEditMode 			: false,
		isEditModeBrker		: false,

		selectedRow			: null,
		selectedRowBrker	: null,
			
		meterList			: meterDS,
		meterItemList 		: meterItemDS,
		parentMeterList		: parentMeterDS,
		
		breakerList 		: breakerDS,
		breakerItemList 	: breakerItemDS,
		
		tariffList 			: tariffDS,
		transformerList 	: transformerDS,
		electricityBoxList 	: electricityBoxDS,
		electricityPoleList : electricityPoleDS,
			
		pageLoad 			: function(id){
			this.set("customer_id", id);									
			parentMeterDS.filter({
				filters: [
					{ field: "customer_id", value: id },
					{ field: "parent_id", value: 0 },
					{ field: "status", value: 1 }					
				]
			});
			breakerDS.filter({ field: "customer_id", value: id });

			this.set("fullIdName", customerModel.get("customer").fullIdName);
		},		
		clearTariff 		: function(){
      		this.set("tariff_id", "");
      	},

		//Meter				
      	openMeterWindow		: function(){
         	var window = $("#meter-window").data("kendoWindow");
          	window.title("កុងទ័រ");          	
          	window.center().open();
      	},
      	closeMeterWindow 	: function(){
      		var window = $("#meter-window").data("kendoWindow");          	         	
          	window.center().close();
      	},      	
      	btnAddNewMeterClick : function(){
      		this.set("isEditMode", false)
      		this.clearMeter();
      		this.openMeterWindow();
      	},
      	meterSaveClick 		: function(){
      		if(this.get("isEditMode")){
      			this.updateMeter();
      		}else{
      			this.addMeter();
      		}
      		this.closeMeterWindow();
      	},
      	addMeter 			: function(){
      		meterDS.add({				
				type				: "electricity",
				meter_no			: this.get("meter_no"),
				multiplier			: this.get("multiplier"),
				max_digit			: this.get("max_digit"),		
				status				: this.get("status"),	
				ear_sealed			: this.get("ear_sealed"),
				cover_sealed		: this.get("cover_sealed"),	
				tariff_id			: this.get("tariff_id"),
				memo				: this.get("memo"),	
				customer_id			: this.get("customer_id"),
				item_id				: this.get("item_id"),
				transformer_id		: this.get("transformer_id"),
				electricity_box_id	: this.get("electricity_box_id"),
				date_used			: kendo.toString(new Date(this.get("date_used")), "yyyy-MM-dd"),	
				parent_id 			: this.get("parent_id"),

				items				: "",
			   	electricity_boxes	: "",			   			   	
			   	parents				: ""
			});
			
			meterDS.sync();
			this.removeMeter();								
      	},
      	updateMeter 		: function(){
      		var meter_id = this.get("meter_id");      		
			var meter = meterDS.get(meter_id);
			
			meter.set("meter_no", this.get("meter_no"));
			meter.set("multiplier", this.get("multiplier"));
			meter.set("max_digit", this.get("max_digit"));
			meter.set("status", this.get("status"));			
			meter.set("ear_sealed", this.get("ear_sealed"));
			meter.set("cover_sealed", this.get("cover_sealed"));
			meter.set("tariff_id", this.get("tariff_id"));
			meter.set("memo", this.get("memo"));
			meter.set("customer_id", this.get("customer_id"));						  	  
			meter.set("item_id", this.get("item_id"));
			meter.set("transformer_id", this.get("transformer_id"));	
			meter.set("electricity_box_id", this.get("electricity_box_id"));	
			meter.set("date_used", kendo.toString(new Date(this.get("date_used")), "yyyy-MM-dd"));
			meter.set("parent_id",	this.get("parent_id"));
				
			meterDS.sync();						
      	},
      	deleteMeter 		: function(){
      		if (confirm("តើលោកអ្នកពិតជាចង់លុបទិន្នន័យនេះមែនឬទេ?")) {
      			var meter_id = this.get("meter_id");
      			var meter = meterDS.get(meter_id);
  				meterDS.remove(meter);
	            meterDS.sync();
	            this.closeMeterWindow();	            
	        }
      	},
      	meterGridChange		: function(eventArgs) {
        	this.set("selectedRow", eventArgs.sender.dataItem(eventArgs.sender.select()));

        	this.set("isEditMode", true);
        	this.set("meter_id", this.get("selectedRow").id);

        	this.set("meter_no", this.get("selectedRow").meter_no);
			this.set("multiplier", this.get("selectedRow").multiplier);
			this.set("max_digit", this.get("selectedRow").max_digit);
			this.set("status", this.get("selectedRow").status);			
			this.set("ear_sealed", this.get("selectedRow").ear_sealed);
			this.set("cover_sealed", this.get("selectedRow").cover_sealed);
			this.set("tariff_id", this.get("selectedRow").tariff_id);
			this.set("memo", this.get("selectedRow").memo);
			//this.set("customer_id", this.get("selectedRow").customer_id);						  	  
			this.set("item_id", this.get("selectedRow").item_id);
			this.set("transformer_id", this.get("selectedRow").transformer_id);	
			this.set("electricity_box_id", this.get("selectedRow").electricity_box_id);	
			this.set("date_used", new Date(this.get("selectedRow").date_used));
			this.set("parent_id", this.get("selectedRow").parent_id);

			this.set("electricity_pole_id", this.get("selectedRow").electricity_boxes.electricity_pole_id);
			if(this.get("selectedRow").tariff_id>0){
				this.set("hasTariff", true);
			}else{
				this.set("hasTariff", false);
			}			

			this.openMeterWindow();
    	},
    	clearMeter 			: function(){
    		this.set("meter_no", "");
			this.set("multiplier", 1);
			this.set("max_digit", "");
			this.set("status", 1);			
			this.set("ear_sealed", 1);
			this.set("cover_sealed", 1);
			this.set("tariff_id", "");
			this.set("memo", "");									  	  
			this.set("item_id", "");
			this.set("transformer_id", "");	
			this.set("electricity_box_id", "");	
			this.set("date_used", new Date());
			this.set("parent_id", "");

			this.set("electricity_pole_id", "");
			this.set("hasTariff", false);									
    	},
    	removeMeter 		: function(){      		      			    	
			//Remove meter records
			for (var i=0; i< meterDS.total(); i++) {
				var dataItem = meterDS.at(i);
	  			meterDS.remove(dataItem);
			}			
	    },  

    	//Breaker
    	openBreakerWindow	: function(e){
         	var window = $("#breaker-window").data("kendoWindow");
          	window.title("ឌីស្យុងទ័រ");          	
          	window.center().open();
      	},
      	closeBreakerWindow 	: function(){
      		var window = $("#breaker-window").data("kendoWindow");          	         	
          	window.center().close();
      	},      	
      	btnAddNewBreakerClick: function(){
      		this.set("isEditModeBrker", false)
      		this.clearBreaker();
      		this.openBreakerWindow();
      	},
      	breakerSaveClick 	: function(){
      		if(this.get("isEditModeBrker")){
      			this.updateBreaker();
      		}else{
      			this.addBreaker();
      		}
      		this.closeBreakerWindow();
      	},
      	addBreaker			: function(){
      		breakerDS.add({				
				name			: this.get("name_brker"),						
				status			: this.get("status_brker"),				
				customer_id		: this.get("customer_id"),
				item_id			: this.get("item_id_brker"),				
				date_used		: kendo.toString(new Date(this.get("date_used_brker")), "yyyy-MM-dd"),
				items 			: ""
			});
			
			breakerDS.sync();
			this.removeBreaker();					
      	},
      	updateBreaker		: function(){
      		var breaker_id = this.get("breaker_id");      		
			var breaker = breakerDS.get(breaker_id);
			
			breaker.set("name", this.get("name_brker"));			
			breaker.set("status", this.get("status_brker"));			
			breaker.set("customer_id", this.get("customer_id"));						  	  
			breaker.set("item_id", this.get("item_id_brker"));			
			breaker.set("date_used", kendo.toString(new Date(this.get("date_used_brker")), "yyyy-MM-dd"));
							
			breakerDS.sync();					
      	},
      	deleteBreaker 		: function(){
      		if (confirm("តើលោកអ្នកពិតជាចង់លុបទិន្នន័យនេះមែនឬទេ?")) {
      			var breaker_id = this.get("breaker_id");
      			var breaker = breakerDS.get(breaker_id);
  				breakerDS.remove(breaker);
	            breakerDS.sync();
	            this.closeBreakerWindow();	            
	        }
      	},
      	breakerGridChange		: function(eventArgs) {
        	this.set("selectedRowBrker", eventArgs.sender.dataItem(eventArgs.sender.select()));

        	this.set("isEditModeBrker", true);
        	this.set("breaker_id", this.get("selectedRowBrker").id);

        	this.set("name_brker", this.get("selectedRowBrker").name);			
			this.set("status_brker", this.get("selectedRowBrker").status);								  	  
			this.set("item_id_brker", this.get("selectedRowBrker").item_id);			
			this.set("date_used_brker", new Date(this.get("selectedRowBrker").date_used));
			
			this.openBreakerWindow();
    	},
    	clearBreaker 			: function(){
    		this.set("name_brker", "");			
			this.set("status_brker", 1);										  	  
			this.set("item_id_brker", "");			
			this.set("date_used_brker", new Date());								
    	},
    	removeBreaker		: function(){      		      			    	
			//Remove meter records
			for (var i=0; i< breakerDS.total(); i++) {
				var dataItem = breakerDS.at(i);
	  			breakerDS.remove(dataItem);
			}			
	    }, 
	});
	
	var meterRecordModel = kendo.observable({		
		reader_id		: "",
		month_of 		: new Date(),
		date_read_from	: new Date(),
		date_read_to	: new Date(),
		total_active	: 0,
		total_reactive	: 0,
		
		meterRecords  	: [],
		meterReadingList: meterReadingDS,			
		readerList 		: readerDS,

		//Edit
		editData			: null,
		max_digit 			: 0,
	
		invoice_id 			: 0,		
		new_reading 		: 0,
		new_round 			: false,		

		hasReactive 		: false,		
		reactive_new_reading: 0,
		reactive_new_round 	: false,

		active_usage 		: 0,
		reactive_usage 		: 0,

		//Edit invoice
		isVisible 			: false,
		next_inv_id			: 0,
		last_invoice_no 	: "",
		customerBalanceList : [],
		invoiceItemList 	: [],
		biller 				: <?php echo $this->session->userdata('user_id'); ?>,
		issued_date			: new Date(),
		payment_date 		: new Date(),
		due_date 			: "",		

		pageLoad 			: function(id){			
			meterReadingDS.filter({
				filters: [
					{ field: "customer_id", value: id },
					{ field: "status", value: 1 }					
				]
			});

			planItemDS.read();
			tariffDS.read();
			tariffItemDS.read();
			maintenanceDS.read();
			exemptionDS.read();				
		},
		setDueDate			: function(){
			var duedate = new Date();
			duedate.setDate(duedate.getDate()+7);
			this.set("due_date", duedate);
		},	      	
      	change 				: function(e){      		
      		var d = e.data;
  			var totalActive = 0;
  			var totalReactive = 0;  			
  			var totalUnread = this.get("total_meter");
  			
			for(var i=0; i < meterReadingDS.total(); i++) {
				var data = meterReadingDS.at(i);
				
				if(data.new_reading!==""){					
					var newRound = 0;
					if(data.checkNewRound){
						newRound = data.max_digit;						
					}
					totalActive += (kendo.parseInt(data.new_reading) + kendo.parseInt(newRound)) - kendo.parseInt(data.prev_reading);
										
				}

				if(data.reactive_new_reading!==""){					
					var reactiveNewRound = 0;
					if(data.rcheckNewRound){
						reactiveNewRound = data.max_digit;
					}										
					totalReactive += (kendo.parseInt(data.reactive_new_reading) + kendo.parseInt(reactiveNewRound)) - kendo.parseInt(data.reactive_prev_reading);					
				}					
			}			

			this.set("total_active", totalActive);
			this.set("total_reactive", totalReactive);									
      	},
      	validation 			: function() {
			var result = true;																					
			for(var i=0; i < meterReadingDS.total(); i++) {
				var data = meterReadingDS.at(i);
				var r = true;
				
				//Validate on new reading
				var active_usage = 0;				
				if(data.new_reading!==""){					
					//Validate on date
					var dateReadTo = kendo.toString(new Date(this.get("date_read_to")), "yyyy-MM-dd");					
					var monthOf = new Date(this.get("month_of"));
					monthOf.setDate(1);
					monthOf = kendo.toString(monthOf, "yyyy-MM-dd");																
					if(monthOf <= data.meter_records.month_of){
						result = false;
						r = false;						
						$("#msgD-"+data.id).text("!");
					}else{
						$("#msgD-"+data.id).text("");
					}
					
					var newRound = 0;
					if(data.checkNewRound){
						newRound = data.max_digit;
					}
					active_usage = (parseInt(data.new_reading) + newRound) - data.prev_reading;											
				}
				if(active_usage<0){
					result = false;
					r = false;
					$("#msg-"+data.id).text("!");						
				}else{
					$("#msg-"+data.id).text("");
				}

				//Validate on reactive new reading
				var reactive_usage = 0;
				if(data.reactive_new_reading!==""){
					var reactiveNewRound = 0;
					if(data.rcheckNewRound){
						reactiveNewRound = data.max_digit;
					}
					reactive_usage = (parseInt(data.reactive_new_reading) + reactiveNewRound) - data.reactive_prev_reading;						
				}

				if(reactive_usage<0){
					result = false;
					r = false;
					$("#msgR-"+data.id).text("!");						
				}else{
					$("#msgR-"+data.id).text("");
				}
				
				//Highlight invalid input each rows
				if(r==false){
					$("#rowGrid-"+data.id).addClass("alert alert-error");
				}else{
					$("#rowGrid-"+data.id).removeClass("alert alert-error");
				}																
			}

			//Validate on reader
			if(!(this.get("reader_id")>0)){
				result = false;				
				$("#reader").text("!").addClass("alert alert-error");					
			}else{
				$("#reader").text("").removeClass("alert alert-error");
			}			
		
			return result;
		},
      	addMeterRecord 		: function(){
      		if(this.validation()){
      			var dateReadTo = kendo.toString(this.get("date_read_to"), "yyyy-MM-dd");
      			var monthOf = new Date(this.get("month_of"));
				monthOf.setDate(1);
				monthOf = kendo.toString(monthOf, "yyyy-MM-dd");

      			for(var i=0; i < meterReadingDS.total(); i++) {
					var data = meterReadingDS.at(i);
					
					if(data.new_reading!==""){
						var newRound = 0;
						if(data.checkNewRound){
							newRound = data.max_digit;
						}
						var rnewRound = 0;
						if(data.rcheckNewRound){
							rnewRound = data.max_digit;
						}

						this.meterRecords.push({				
							meter_id				: data.id,
						   	prev_reading			: data.prev_reading,
						   	new_reading 			: data.new_reading,
						   	new_round				: newRound,
						   	reactive_prev_reading	: data.reactive_prev_reading,								   
						   	reactive_new_reading	: data.reactive_new_reading,
						   	reactive_new_round		: rnewRound,		   
						   	is_backup_reading 		: data.parent_id>0 ? 1 : 0,
						   	month_of 				: monthOf,
						   	date_read_from			: kendo.toString(this.get("date_read_from"), "yyyy-MM-dd"),						   
						   	date_read_to			: kendo.toString(this.get("date_read_to"), "yyyy-MM-dd"),
						   	reader 					: this.get("reader_id"),
						   	invoice_id				: 0 //No invoice yet					   	
						});
					}
				}	

				if(this.get("meterRecords").length>0){
					meterRecordDS.add(this.get("meterRecords"));
					meterRecordDS.sync();

					this.clearMeterRecord();
					
					$(".AddMeterRecordStatus").text("").removeClass("alert alert-error");
					$(".AddMeterRecordStatus").text("កត់ត្រាបានសំរេច").addClass("alert alert-success");
				}				
			}else{
				$(".AddMeterRecordStatus").text("សូមត្រួតពិនិត្រឪ្យបានត្រឺមត្រូវម្ដងទៀត").addClass("alert alert-error");
			}
      	},
      	openWindow			: function(){
         	var window = $("#meterRecord-window").data("kendoWindow");
          	window.title("កំនែអំនាន");          	
          	window.center().open();
      	},
      	closeWindow 		: function(){
      		var window = $("#meterRecord-window").data("kendoWindow");          	         	
          	window.center().close();
      	},
      	clearMeterRecord 		: function(){
      		this.set("meterRecords", []);

			//Remove meter records
			for (var i=0; i< meterRecordDS.total(); i++) {
				var dataItem = meterRecordDS.at(i);
	  			meterRecordDS.remove(dataItem);
			}			
	    },      	
      	
      	//Edit reading
      	editReadingClick 	: function(e){
      		var d = e.data;

      		this.set("editData", d);
      		this.set("invoice_id", d.meter_records.invoice_id);

      		this.set("max_digit", d.max_digit);

      		this.set("new_reading", d.meter_records.new_reading);
      		this.set("reactive_new_reading", d.meter_records.reactive_new_reading);     		
      		      		
      		if(d.meter_records.new_round==0){
      			this.set("new_round", false);
      		}else{
      			this.set("new_round", true);
      		}
      		      				
      		if(d.meter_records.reactive_new_round==0){
      			this.set("reactive_new_round", false);
      		}else{
      			this.set("reactive_new_round", true);
      		}

      		if(d.tariff_id>0){
      			this.set("hasReactive", true);
      		}else{
      			this.set("hasReactive", false);
      		}

      		if(d.meter_records.invoice_id>0){
      			this.set("isVisible", true);
      			this.setDueDate();
      			invoiceDS.filter({ field: "id", value: d.meter_records.invoice_id });
      			this.getNextInvoiceID();
      			this.set("customerBalanceList", []);
      			this.set("invoiceItemList", []);			
      		}else{
      			this.set("isVisible", false);
      		}

      		this.editChange();
      		this.openWindow();
      	},
      	editChange 			: function(){
      		var d = this.get("editData").meter_records;

      		var maxDigit = this.get("max_digit");

      		var newReading = this.get("new_reading");
      		var rNewReading = this.get("reactive_new_reading");  

      		var newRound = this.get("new_round");      		
      		var rNewRound = this.get("reactive_new_round");

      		var newRoundValue = 0;
      		if(newRound){
      			newRoundValue = maxDigit;
      		}
      		var activeUsage = kendo.parseInt(newReading) + kendo.parseInt(newRoundValue) - kendo.parseInt(d.prev_reading);

      		var rNewRoundValue = 0;
      		if(rNewRound){
      			rNewRoundValue = maxDigit;
      		}
      		var reactiveUsage = kendo.parseInt(rNewReading) + kendo.parseInt(rNewRoundValue) - kendo.parseInt(d.reactive_prev_reading);

      		this.set("active_usage", activeUsage);
      		this.set("reactive_usage", reactiveUsage);
      	},      	
      	saveEditClick 		: function(){
      		var activeUsage = kendo.parseInt(this.get("active_usage"));
      		var reactiveUsage = kendo.parseInt(this.get("reactive_usage"));
      		var maxDigit = this.get("max_digit");

      		if(activeUsage>=0 && reactiveUsage >=0){
      			var d = this.get("editData").meter_records;
	      		var id = d.id;
	      		var invoiceId = kendo.parseInt(d.invoice_id);	      		
	      		if(invoiceId>0){
	      			invoiceId = this.get("next_inv_id");
	      		}

	      		var newRound = 0;
	      		if(this.get("new_round")){
	      			newRound = maxDigit;
	      		}

	      		var rnewRound = 0;
	      		if(this.get("reactive_new_round")){
	      			rnewRound = maxDigit;
	      		}

	      		var data = [];
	      		data.push({
	      			'new_reading' 			: this.get("new_reading"),
	      			'new_round'	  			: newRound,
	      			'reactive_new_reading' 	: this.get("reactive_new_reading"),
	      			'reactive_new_round'	: rnewRound,
	      			'invoice_id'  			: invoiceId
	      		});

	      		$.ajax({
					type: "PUT",
					url: ARNY.baseUrl + "api/meter_records/meter_record_reading",
					data: {
						id 	: id,
						data: kendo.stringify(data)
					},
					dataType: "json",
					success: function (response) {
						//var data = response.d;								  
					}
				});
	      		this.modifyInvoice();
				meterReadingDS.fetch();
				this.closeWindow();				
      		}
      	},
      	modifyInvoice 		: function(){
      		var invoiceId = kendo.parseInt(this.get("invoice_id"));      		
      		if(invoiceId>0){      			
      			this.addInvoice();      			      			
      		}
      	},
      	getNextInvoiceID	: function(){
			$.ajax({
				type: "GET",
				url: ARNY.baseUrl + "api/invoices/invoice_next_id",			
				data: {type: 'Invoice'},
				dataType: "json",
				success: function (response) {
					//var data = response.d;
					meterRecordModel.set("next_inv_id", response.id);		
					meterRecordModel.set("last_invoice_no", response.last_no);			  
				}
			});
		},
      	getTariffId  		: function(tariff_plan_id, month_of){
			var tariff_id = 0;						
			var data = planItemDS.data();			
	        for (var i = 0; i < data.length; i++) {
	            var d = data[i];
	            if((d.tariff_plan_id==tariff_plan_id) && (month_of>=d.start_date)){
	            	tariff_id = d.tariff_id;
	            	break;
	            }
	        }
	        return tariff_id;		
		},				
		addInvoice 			: function(){
			var d = this.get("editData");			
			var invoice_id = this.get("next_inv_id");		
			var last_invoice_no = this.get("last_invoice_no");

			var newReading = this.get("new_reading");
      		var reactiveNewReading = this.get("reactive_new_reading"); 

			var activeUsage = kendo.parseInt(this.get("active_usage"));
      		var reactiveUsage = kendo.parseInt(this.get("reactive_usage"));

      		var newR = kendo.parseInt(this.get("active_usage"));
      		var reactiveUsage = kendo.parseInt(this.get("reactive_usage"));

			var monthOf = this.get("month_of");
			var fullMonthOf = new Date(monthOf);
			fullMonthOf.setDate(1);
			fullMonthOf = kendo.toString(fullMonthOf, "yyyy-MM-dd");

			var invoice_no = 0;
			if(last_invoice_no.length>7){
				invoice_no = parseInt(last_invoice_no.substr(7));

				//Apply invoice no back to 0000 for the new year
				var y = parseInt(last_invoice_no.substr(3,2));
				var yof = parseInt(new Date(monthOf).getFullYear().toString().substr(2,2));			
				if(yof>y){
					invoice_no = 0;
				}					
			}			
			invoice_no++;		

			var str_inv_no = "INV" + kendo.toString(new Date(monthOf), "yy") 
									+ kendo.toString(new Date(monthOf), "MM");
		  	    		 		 		
			var inv_no = str_inv_no + kendo.toString(invoice_no, "00000");			
			
			var total_amount = 0;
			            	
        	//Apply exemption
        	var isFree = false;            	
			var exemp_amt =0;
			var exemption_id = d.people.exemption_id;
			var exemp = exemptionDS.get(exemption_id);

			//Exempint free 100%
			if((exemption_id>0) && (exemp.exemption_type=="%") && (exemp.amount==1)){
				isFree = true;	
			}

			if(isFree==false){
				//Apply maintenance
				var maintenance_id = d.people.maintenance_id;
				var maintenances = maintenanceDS.get(maintenance_id);

				//Apply tariff
				var price = 0;
				var tariff_amt = 0;
				var active_usage = d.active_usage;

				var tariff_id = this.getTariffId(d.people.tariff_plan_id, d.meter_records.month_of);				
				var tariffs = tariffDS.get(tariff_id);
				
				//Apply tariff to active usage							
				//Exemption for kWh
				if((exemption_id>0) && (exemp.exemption_type=="kWh")){
					if(active_usage>exemp.amount){
						active_usage -= exemp.amount;
					}			
				}				
					
				//Apply tariff item				
				var dataj = tariffItemDS.data();
				for (var j=0;j<dataj.length;j++){				 
					var dj = dataj[j];
					if((dj.tariff_id==tariff_id) && (active_usage>=dj.usage)){												
						if(dj.is_flat==0){														
							price = dj.price;
							tariff_amt = active_usage * price;																											
						}else{																					
							price = dj.amount;
							tariff_amt = dj.amount;											
						}
						break;						
					}
				}
									
				//Add active item
				this.invoiceItemList.push({
					invoice_id	: invoice_id,
					item_id		: 0,	
					description	: tariffs.name,
					multiplier	: d.multiplier,
					quantity	: active_usage,	  
					unit_price	: price,
					vat			: 0,		  	  
					amount		: tariff_amt,
					meter_id 	: d.meter_id,
					prev_reading: d.prev_reading,
					new_reading : d.new_reading	
				});		
				total_amount += tariff_amt;
				
				//Add exemption for kWh
				if((exemption_id>0) && (exemp.exemption_type=="kWh") && (exemp.amount >0)){
					if(active_usage>exemp.amount){		
						//Add exemption for kWh
						this.invoiceItemList.push({
							invoice_id	: invoice_id,
							item_id		: 0,									
							description	: exemp.name,
							multiplier	: 0,
							quantity	: 1,	  
							unit_price	: 0,
							vat			: 0,		  	  
							amount		: 0,
							meter_id 	: 0,
							prev_reading: 0,
							new_reading : 0,
							exemption_id: exemption_id
						});							
					}	
				}				

				//Apply tariff item for reactive usage			
				var reactive_tariff_amt = 0;
				var reactive_price = 0;
				var reactive_usage = d.reactive_usage;
									
				var datak = tariffItemDS.data();				
				for (var k=0;k<datak.length;k++){				 
					var dk = datak[k];								
					if((dk.tariff_id==d.tariff_id) && (reactive_usage>=dk.usage)){
						if(dk.is_flat==0){
							reactive_price = dk.price;
							reactive_tariff_amt = reactive_usage * reactive_price;																				
						}else{
							reactive_price = dk.amount;
							reactive_tariff_amt = dk.amount;				
						}
						break;																			
					}	
				}

				//Add reactive item
				if(reactive_tariff_amt>0){
					this.invoiceItemList.push({
						invoice_id	: invoice_id,
						item_id		: 0,	
						description	: 'អំនាន Reactive',
						multiplier	: d.multiplier,
						quantity	: reactive_usage,	  
						unit_price	: reactive_price,
						vat			: 0,		  	  
						amount		: reactive_tariff_amt,
						meter_id 	: 0,
						prev_reading: d.reactive_prev_reading,
						new_reading : d.reactive_new_reading	
					});		
					total_amount += reactive_tariff_amt;
				}

				//Exemption for %
				if((exemption_id>0) && (exemp.exemption_type=="%") && (exemp.amount >0)){
					exemp_amt = total_amount * exemp.amount;					
							
					//Add exemption for %					
					this.invoiceItemList.push({
						invoice_id	: invoice_id,
						item_id		: 0,	
						description	: exemp.name,
						multiplier	: 0,
						quantity	: 1,	  
						unit_price	: 0,
						vat			: 0,		  	  
						amount		: (exemp_amt*-1),
						meter_id 	: 0,
						prev_reading: 0,
						new_reading : 0,
						exemption_id: exemption_id
					});
					total_amount -= exemp_amt;								
				}
				
				//Exemption for Money
				if((exemption_id>0) && (exemp.exemption_type=="៛") && (exemp.amount >0)){
					if(total_amount>exemp.amount){
						exemp_amt = exemp.amount;	
					}else{
						exemp_amt = total_amount;	
					}
					
					//Add exemption for Money
					this.invoiceItemList.push({
						invoice_id	: invoice_id,
						item_id		: 0,	
						description	: exemp.name,
						multiplier	: 0,
						quantity	: 1,	  
						unit_price	: 0,
						vat			: 0,		  	  
						amount		: (exemp_amt*-1),
						meter_id 	: 0,
						prev_reading: 0,
						new_reading : 0,
						exemption_id: exemption_id
					});
					total_amount -= exemp_amt;				
				}
											
				//Add maintenance
				if((maintenance_id>0) && (maintenances.amount>0)){	
					this.invoiceItemList.push({
						invoice_id	: invoice_id,
						item_id		: 0,	
						description	: maintenances.name,
						multiplier	: 0,
						quantity	: 1,	  
						unit_price	: parseFloat(maintenances.amount),
						vat			: 0,		  	  
						amount		: parseFloat(maintenances.amount),
						meter_id 	: 0,
						prev_reading: 0,
						new_reading : 0,
						maintenance_id: maintenance_id
					});
					total_amount += parseFloat(maintenances.amount);
				}

				//Add invoice into []        		 		
				var inv_no = str_inv_no + kendo.toString(invoice_no, "00000");								
				invoiceDS.add({
					number			: inv_no,
					type 			: "eInvoice",
					amount 			: total_amount,	  
					status			: this.get("status"),
					biller			: this.get("biller"),	  
					customer_id		: d.people.id,
					address			: d.people.house_no + ' ' + d.people.street_no,
					issued_date		: kendo.toString(new Date(this.get("issued_date")), "yyyy-MM-dd"),
					payment_date	: kendo.toString(new Date(this.get("payment_date")), "yyyy-MM-dd"),				
					due_date		: kendo.toString(new Date(this.get("due_date")), "yyyy-MM-dd"),
					month_of 		: monthOf,
					date_read_from	: kendo.toString(new Date(d.date_read_from), "yyyy-MM-dd"),
					date_read_to	: kendo.toString(new Date(d.date_read_to), "yyyy-MM-dd"),
					payment_term_id	: this.get("payment_term_id"),	  	  	
					currency_code	: this.get("currency_code"),
					class_id 		: this.get("class_id"),
					transformer_id  : d.people.transformer_id,
					box_no 			: d.electricity_boxes.box_no,
					memo			: this.get("memo"),
					company_id 		: d.people.company_id				
				});				

				invoice_id++;			
				invoice_no++;
			}
						
			//Add new customer balances to []
			var invEdit = invoiceDS.at(0);
			var balance = kendo.parseFloat(d.people.balance) + kendo.parseFloat(total_amount) - kendo.parseFloat(invEdit.total_amount);
			this.customerBalanceList.push({
				id			: kendo.parseInt(d.people.id),
				balance 	: balance
			});

			customerModel.set("balance", kendo.toString(balance, 'c0'));

			invoiceDS.sync();
			this.updateCustomerBalance();
			this.updateInvoiceStatus();							  	
		},
		updateCustomerBalance : function(){
			var data = this.get("customerBalanceList");
			$.ajax({
				type: "PUT",
				url: ARNY.baseUrl + "api/people_api/balance_batch",			
				data: { data: kendo.stringify(data)},
				dataType: "json",
				success: function (response) {
					//var data = response.d;			  
				}
			});				
		},
		updateInvoiceStatus : function(){
			var id = this.get("invoice_id");
			$.ajax({
				type: "PUT",
				url: ARNY.baseUrl + "api/invoices/invoice_inactive",			
				data: { id: id },
				dataType: "json",
				success: function (response) {
					//var data = response.d;			  
				}
			});				
		}
	});
	
	var invoiceModel = kendo.observable({
		next_inv_id 	 	: "<?php echo $next_inv_id;?>",
		last_invoice_no 	: "<?php echo $last_invoice_no;?>",		
		
		invoice_id 			: 0,	
		number 				: "",
		type 				: "Invoice",
		status				: 0,
		biller				: <?php echo $this->session->userdata('user_id'); ?>,	
		customer_id			: 0,
		address				: "",		  	  
		issued_date			: new Date(),
		due_date			: "",
		estimate_id 		: 0,
		gdn_id 				: 0,
		so_id				: 0,		
		payment_term_id		: 0,		
		memo				: "",
		class_id			: "",

		isUpdate 			: false,
		paid 				: false,
		total 				: kendo.toString(0,"c0"),
		invoiceEdit 		: null,					    
		
		invoiceItemList 	: [],
		itemList 			: [],
		customerBalanceList : [],

		estimateList 		: estimateDS,
		gdnList 			: gdnDS,
		soList 				: soDS,
		paymentTermList		: paymentTermDS,
		currencyList		: currencyDS,
		classList 			: classDS,
		vatList 			: vatDS,
		
		pageLoad 			: function(id, inv_id){
			kendo.culture("de-DE");

			this.set("customer_id", id);
			this.set("address", customerModel.get("customer").address);
			this.set("so_id", 0);
			this.set("total", kendo.toString(0,"c0"));
			this.set("invoiceItemList", []);
			this.set("itemList", []);
			this.setDueDate();
			this.setItemSource();

			estimateDS.filter({
				filters: [
					{ field: "customer_id", value: id },
					{ field: "status", value: 0 },
					{ field: "type", value: "Estimate" }
				]
			});

			gdnDS.filter({
				filters: [
					{ field: "customer_id", value: id },
					{ field: "status", value: 0 },
					{ field: "type", value: "GDN" }
				]
			});

			soDS.filter({
				filters: [
					{ field: "customer_id", value: id },
					{ field: "status", value: 0 },
					{ field: "type", value: "SO" }
				]
			});

			if(inv_id>0){
				this.set("isUpdate", true);
				invoiceDS.filter({ field: "id", value: inv_id });
			}else{
				this.set("isUpdate", false);							
				this.setInvoiceNumber();				
				this.addNewRow();
			}
		},
		setDueDate 			: function(){
			var duedate = new Date();
			duedate.setDate(duedate.getDate()+7);
			this.set("due_date", duedate);
		},		
		loadInvoiceEdit		: function(){			  	
		  	var d = this.get("invoiceEdit")[0];

		  	this.set("invoice_id", d.id);
		  	this.set("number", d.number);				
			this.set("status", d.status);
			this.set("biller", d.biller);	
			this.set("customer_id", d.customer_id);
			this.set("address", d.address);	  	  
			this.set("issued_date", new Date(d.issued_date));
			this.set("due_date", new Date(d.due_date));			
			this.set("estimate_id", d.estimate_id);
			this.set("gdn_id", d.gdn_id);
			this.set("payment_term_id", d.payment_term_id);			
			this.set("memo", d.memo);
			this.set("class_id", d.class_id);
			this.set("total", d.total);

			//Status
			if(d.status==1){
				this.set("paid", true);
			}else{
				this.set("paid", false);
			}

			var items = d.invoice_items;
			for (var i=0;i<items.length;i++) {
		 		var it = items[i];
		 		this.invoiceItemList.push({
					'invoice_id' 	: it.invoice_id,
					'item_id' 		: it.item_id,
					'description' 	: it.description,				
					'quantity' 		: it.quantity,
					'unit_price' 	: it.unit_price,
					'vat' 			: it.vat,
					'amount' 		: it.amount				
				});			
		 	}
		 	this.autoIncreaseNo();		
		},		
		setItemSource 		: function(){	    				  	
		  	for (var i=0; i< itemDS.total(); i++) {
	    		var data = itemDS.data();

	    		this.itemList.push({
	    			id 		: data[i].id,
	    			name 	: data[i].item_sku +' '+ data[i].name	    			
	    		});
	    	}	    	
	    },	    
	    setInvoiceNumber 	: function(){
	  		var last_invoice_no = this.get("last_invoice_no");		
			var invoice_no = 0;
			if(last_invoice_no.length>7){
				invoice_no = parseInt(last_invoice_no.substr(7));						
			}
			invoice_no++;

			var str_inv_no = "INV" + kendo.toString(new Date(this.get("issued_date")), "yy") + kendo.toString(new Date(this.get("issued_date")), "MM");
			var inv_no = str_inv_no + kendo.toString(invoice_no, "00000");

			this.set("number", inv_no);				
	    },
		autoIncreaseNo 		: function(){
			$(".sno").each(function(index,element){                 
			   $(element).text(index + 1); 
			});
		},
		linkPrint 			: function(){
			window.location.href = ARNY.baseUrl + "customer/invoice_preview/" + this.get("invoice_id");
		},
		addNewRow 			: function(){
			this.invoiceItemList.push({
				'invoice_id' 	: 0,
				'item_id' 		: "",
				'description' 	: "",				
				'quantity' 		: 1,
				'unit_price' 	: 0,
				'vat' 			: 0,
				'amount' 		: 0,
				'so_id'			: 0				
			});
			this.autoIncreaseNo();			
		},
		removeRow 			: function(e){
			var item = e.data;
	        var index = this.get("invoiceItemList").indexOf(item);        
	        this.get("invoiceItemList").splice(index, 1);
	        this.change();
		},
		change				: function(){			
			var total = 0;		
			$.each(this.get("invoiceItemList"), function(index, data) {				
				var amt = data.quantity * data.unit_price;
				var vat = amt * data.vat;
				var tamt = amt + vat;								        	
	            
	            data.set("amount", tamt);
	            total += tamt;
	        });
			this.set("total", kendo.toString(total,"c0"));
	    	this.autoIncreaseNo();    	
		},
		itemChange 			: function(e){
			var d = e.data;
			var arr =  this.get("invoiceItemList");			
	        var index = arr.indexOf(d);
	        var data = arr[index];
	        var item = itemDS.get(d.item_id);	        
			
	        data.set("description", item.name);
	        data.set("unit_price", item.price);
	        data.set("vat", item.vat);
	        
	        this.change();	        	        	
		},
		estimateChange 		: function(e){
			var d = e.sender;
			var id = kendo.parseInt(d._selectedValue);
			this.set("invoiceItemList", []);			
			if(id>0 || id!=null){
			 	var d = estimateDS.get(id);			
			 	var items = d.invoice_items;

			 	for (var i=0;i<items.length;i++) {
			 		var it = items[i];
			 		this.invoiceItemList.push({
						'invoice_id' 	: it.invoice_id,
						'item_id' 		: it.item_id,
						'description' 	: it.description,				
						'quantity' 		: it.quantity,
						'unit_price' 	: it.unit_price,
						'vat' 			: it.vat,
						'amount' 		: it.amount				
					});			
			 	}			 	
			 	this.set("estimate_id", id);
			 	this.set("gdn_id", 0);
			 	this.set("so_id", 0);

			 	this.change();
			 	this.autoIncreaseNo();				
			}else{
				this.set("total", kendo.toString(0,"c0"));
			}			
		},
		gdnChange 			: function(e){
			var d = e.sender;
			var id = kendo.parseInt(d._selectedValue);
			this.set("invoiceItemList", []);			
			if(id>0 || id!=null){
			 	var d = gdnDS.get(id);			
			 	var items = d.invoice_items;

			 	for (var i=0;i<items.length;i++) {
			 		var it = items[i];
			 		this.invoiceItemList.push({
						'invoice_id' 	: it.invoice_id,
						'item_id' 		: it.item_id,
						'description' 	: it.description,				
						'quantity' 		: it.quantity,
						'unit_price' 	: it.unit_price,
						'vat' 			: it.vat,
						'amount' 		: it.amount				
					});			
			 	}
			 	this.set("estimate_id", 0);
			 	this.set("gdn_id", id);
			 	this.set("so_id", 0);

			 	this.change();
			 	this.autoIncreaseNo();				
			}else{
				this.set("total", kendo.toString(0,"c0"));
			}			
		},
		soChange 			: function(e){
			var d = e.sender;
			var id = kendo.parseInt(d._selectedValue);
			this.set("invoiceItemList", []);			
			if(id>0 || id!=null){
			 	var d = soDS.get(id);			
			 	var items = d.invoice_items;

			 	for (var i=0;i<items.length;i++) {
			 		var it = items[i];
			 		this.invoiceItemList.push({
						'invoice_id' 	: it.invoice_id,
						'item_id' 		: it.item_id,
						'description' 	: it.description,				
						'quantity' 		: it.quantity,
						'unit_price' 	: it.unit_price,
						'vat' 			: it.vat,
						'amount' 		: it.amount,
						'so_id'			: id				
					});
			 	}
			 	this.set("estimate_id", 0);
			 	this.set("gdn_id", 0);
			 	this.set("so_id", id);

			 	this.change();
			 	this.autoIncreaseNo();				
			}else{
				this.set("total", kendo.toString(0,"c0"));
			}				
		},
		btnCreateInvoice 	: function(){
			if(this.get("isUpdate")){
				this.updateInvoice();
			}else{
				this.addInvoice();
				this.updateCustomerBalance();
			    this.addJournal();
			}			
		},		
	    addInvoice 			: function(){
	    	if(kendo.parseFloat(this.get("total"))>0){
	    		//Add invoice to datasource	
		    	invoiceDS.add({
		    		'number' 			: this.get("number"),
				   	'type'				: this.get("type"),				   	
				   	'status' 			: this.get("status"),
				   	'amount'			: kendo.parseFloat(this.get("total")),
				   	'biller' 			: this.get("biller"),
				   	'customer_id' 		: this.get("customer_id"),			   	
				   	'address' 			: this.get("address"),
				   	'issued_date' 		: kendo.toString(new Date(this.get("issued_date")),"yyyy-MM-dd"),
				   	'due_date' 			: kendo.toString(new Date(this.get("due_date")),"yyyy-MM-dd"),			   	
				   	'estimate_id' 		: this.get("estimate_id"),
				   	'gdn_id' 			: this.get("gdn_id"),
				   	'so_id' 			: this.get("so_id"),
				   	'payment_term_id'	: this.get("payment_term_id"),				   	
				   	'class_id' 			: this.get("class_id"),
				   	'memo' 				: this.get("memo"),
				   	'company_id'		: customerModel.get("customer").company_id,

				   	'invoice_items'		: this.get("invoiceItemList")
		    	});

		    	//Add new customer balances to []
				var balance = kendo.parseFloat(customerModel.get("balance")) + kendo.parseFloat(this.get("total"));
				this.customerBalanceList.push({
					id			: kendo.parseInt(this.get("customer_id")),
					balance 	: balance
				});

				customerModel.set("balance", kendo.toString(balance, 'c0'));				
		    	invoiceDS.sync();
		    	customerDS.fetch();

		    	this.updateEstimate();
		    	this.updateGDN();
		    	this.updateSO();		    			    	
	    	}        	    		    	
	    },	    
	    addJournal 			: function(){				
			var journalEntries = [];		
			
			var saleList = {};			
			var inventoryList = {};
			var cogsList = {};
			
			$.each(this.get("receiptItemList"), function(index, data){								
				var item = itemDS.get(data.item_id);
				var amt = kendo.parseFloat(data.amount);
				
				//Add sale list
				var incomeID = kendo.parseInt(item.income_account_id);
											
				if(incomeID>0){
					if(saleList[incomeID]===undefined){
						saleList[incomeID]={"id": incomeID, "amt": amt};						
					}else{											
						if(saleList[incomeID].id===incomeID){
							saleList[incomeID].amt += amt;
						}else{
							saleList[incomeID]={"id": incomeID, "amt": amt};
						}
					}					
				}

				switch(kendo.parseInt(item.item_type_id)){		        
					case 1: //Inventory
						//Add cogs list						
						var itemCost = (kendo.parseFloat(item.cost)*kendo.parseFloat(data.quantity));

						//Add cogs list
						var cogsID = kendo.parseInt(item.cogs_account_id);
						if(cogsList[cogsID]===undefined){
							cogsList[cogsID]={"id": cogsID, "amt": itemCost};						
						}else{											
							if(cogsList[cogsID].id===cogsID){
								cogsList[cogsID].amt += itemCost;
							}else{
								cogsList[cogsID]={"id": cogsID, "amt": itemCost};
							}
						}						

						//Add inventory list
						var inventoryID = kendo.parseInt(item.general_account_id);
						if(inventoryList[inventoryID]===undefined){
							inventoryList[inventoryID]={"id": inventoryID, "amt": itemCost};						
						}else{											
							if(inventoryList[inventoryID].id===inventoryID){
								inventoryList[inventoryID].amt += itemCost;
							}else{
								inventoryList[inventoryID]={"id": inventoryID, "amt": itemCost};
							}
						}										

					  	break;								
					default:
				  	//default here
				} //End Swtich
			});//End Foreach Loop			
			
			//Sale list	to journal		
			if(!jQuery.isEmptyObject(saleList)){								
				//Sum cash
				var cash = 0;				
				$.each(saleList, function(index, value){					
					cash += value.amt;					
				});				

				//Cash on Dr							
				journalEntries.push({
			 		account_id 	: receiptModel.get("cash_account_id"),	 		
			 		dr 			: cash, 
			 		cr 			: 0,
			 		class_id  	: receiptModel.get("class_id"),
			 		memo 		: receiptModel.get("memo")	 		
				});

				//Sale accounts on Cr
				$.each(saleList, function(index, value){
					journalEntries.push({
				 		account_id 	: value.id,	 		
				 		dr 			: 0, 
				 		cr 			: value.amt,
				 		class_id  	: receiptModel.get("class_id"),
				 		memo 		: receiptModel.get("memo")	 		
					});
				});
			}

			//Inventory to journal
			//COGS on Dr 			
			if(!jQuery.isEmptyObject(cogsList)){							
				$.each(cogsList, function(index, value){				
					journalEntries.push({
				 		account_id 	: value.id,	 		
				 		dr 			: value.amt, 
				 		cr 			: 0,
				 		class_id  	: receiptModel.get("class_id"),
				 		memo 		: receiptModel.get("memo")	 		
					});	
				});							
			}
			//Inventory on Cr
			if(!jQuery.isEmptyObject(inventoryList)){
				$.each(inventoryList, function(index, value){					
					journalEntries.push({
				 		account_id 	: value.id,	 		
				 		dr 			: 0, 
				 		cr 			: value.amt,
				 		class_id  	: receiptModel.get("class_id"),
				 		memo 		: receiptModel.get("memo")	 		
					});
				});
			}			
						
			//Add journal to datasource
			journalDS.add({	 		
		 		journalEntries : journalEntries,
		 		memo: "វិក្កយបត្រ", 
		 		voucher: "",
		 		class_id: this.get("class_id"),
		 		budget_id: 0,
		 		donor_id: 0,
		 		check_no: "",
		 		people_id: this.get("customer_id"),
		 		employee_id: this.get("biller"),
		 		invoice_id: this.get("next_inv_id"),
		 		payment_id: 0,
		 		bill_id: 0,	
		 		date: kendo.toString(this.get("issued_date"), "yyyy-MM-dd"), 
		 		transaction_type: "Invoice"	 			 		
		 	});
		 	
		 	journalDS.sync();		  	
			this.clearInvoice();	 	
		},
		updateInvoice 		: function(){
			var d = invoiceDS.get(this.get("invoice_id"));

		  	d.set("number", this.get("number"));
			d.set("status", this.get("status"));
			d.set("biller", this.get("biller"));
			d.set("customer_id", this.get("customer_id"));
			d.set("address", this.get("address"));	  	  
			d.set("issued_date", kendo.toString(new Date(this.get("issued_date")),"yyyy-MM-dd"));
			d.set("due_date", kendo.toString(new Date(this.get("due_date")),"yyyy-MM-dd"));
			d.set("estimate_id", this.get("estimate_id"));
			d.set("gdn_id", this.get("gdn_id"));
			d.set("payment_term_id", this.get("payment_term_id"));			
			d.set("memo", this.get("memo"));
			d.set("class_id", this.get("class_id"));
			
			this.deleteInvoiceItem(this.get("invoice_id"));
			
			invoiceDS.sync();
			this.addInvoiceItemEdit(d.id);					
		},
		updateEstimate		: function(){
			var id = this.get("estimate_id");
			
			if(id>0){
				var d = estimateDS.get(id);
				d.set("status", 1);
				estimateDS.sync();
			}								
		},
		updateGDN			: function(){
			var id = this.get("gdn_id");
			
			if(id>0){
				var d = gdnDS.get(id);
				d.set("status", 1);
				gdnDS.sync();
			}								
		},
		updateSO			: function(){
			var id = this.get("so_id");
			
			if(id>0){
				var d = soDS.get(id);
				d.set("status", 1);
				soDS.sync();
			}								
		},
		addInvoiceItemEdit 	: function(invoice_id){
			var data = this.get("invoiceItemList");
			for (var i=0;i<data.length;i++) {
				var d = data[i];
				d.invoice_id = invoice_id;
			}
			$.ajax({
				type: "POST",
	            url : ARNY.baseUrl + "api/invoice_items/invoice_item_many",	            
	            data: {data: kendo.stringify(data)},
				dataType: "json",
	            success : function(response){
	            	
	            }
	        });
		},
		updateCustomerBalance : function(){
			var data = this.get("customerBalanceList");
			$.ajax({
				type: "PUT",
				url: ARNY.baseUrl + "api/people_api/balance_batch",			
				data: { data: kendo.stringify(data)},
				dataType: "json",
				success: function (response) {
					//var data = response.d;			  
				}
			});				
		},		
		deleteInvoiceItem 	: function(invoice_id){
			$.ajax({
				type: "DELETE",
	            url : ARNY.baseUrl + "api/invoice_items/invoice_item_by",	            
	            data: {
					id	: invoice_id				
				},
				dataType: "json",
	            success : function(response){
	            	
	            }
	        });
		},
	    clearInvoice 		: function(){
	    	var next_inv_id = kendo.parseInt(this.get("next_inv_id"))+1;
	    	this.set("next_inv_id", next_inv_id);
	    	this.set("last_invoice_no", this.get("number"));
	    	
	    	this.set("estimate_id", 0);
	    	this.set("gdn_id", 0);
	    	this.set("so_id", 0);
	    	
			this.set("invoiceItemList", []);
			this.set("customerBalanceList", []);

			this.set("memo", "");
			this.set("total", kendo.toString(0,"c0"));

			//Remove invoice
			for (var i=0; i< invoiceDS.total(); i++) {
				var dataItem = invoiceDS.at(i);
	  			invoiceDS.remove(dataItem);
			}

			//Remove journal
			for (var j=0; j< journalDS.total(); j++) {
				var dataItem = journalDS.at(j);
	  			journalDS.remove(dataItem);
			}

			this.pageLoad();
	    }
	});
	
	var receiptModel = kendo.observable({
		next_inv_id 	 	: "<?php echo $next_inv_id;?>",		
		last_receipt_no 	: "<?php echo $last_receipt_no;?>",
		
		//Receipt
		number 				: "",
		type 				: "Receipt",
		status				: 1,
		biller				: <?php echo $this->session->userdata('user_id'); ?>,	
		customer_id			: 0,
		address				: "",		  	  
		issued_date			: new Date(),		
		payment_method_id   : 1,
		cash_account_id 	: "",
		memo				: "",
		class_id			: "",
		estimate_id 		: 0,
		gdn_id 				: 0,
		so_id				: 0,			

		sub_total 			: kendo.toString(0,"c0"),		
		total 				: kendo.toString(0,"c0"),				
		total_in_customer_currency : kendo.toString(0,"c0"),
		deposit_amount  	: 0,					    
		
		receiptItemList 	: [],
		itemList 			: [],

		vatList 			: vatDS,
		estimateList 		: estimateDS,
		gdnList 			: gdnDS,
		soList 				: soDS,
		paymentMethodList	: paymentMethodDS,
		cashAccountList 	: cashAccountDS,
		currencyList		: currencyDS,
		classList 			: classDS,		
		
		pageLoad 			: function(id){			
			this.set("customer_id", id);
			this.set("so_id", 0);
			this.set("estimate_id", 0);
			this.set("gdn_id", 0);
			this.set("vat_id", "");
						
			this.set("subTotal", kendo.toString(0,"c0"));
			this.set("vat", kendo.toString(0,"c0"));
			this.set("total", kendo.toString(0,"c0"));
			this.set("total_in_customer_currency", kendo.toString(0,"c0"));
			
			this.set("receiptItemList", []);
			this.set("itemList", []);

			estimateDS.filter({
				filters: [
					{ field: "customer_id", value: id },
					{ field: "status", value: 0 },
					{ field: "type", value: "Estimate" }
				]
			});

			gdnDS.filter({
				filters: [
					{ field: "customer_id", value: id },
					{ field: "status", value: 0 },
					{ field: "type", value: "GDN" }
				]
			});

			soDS.filter({
				filters: [
					{ field: "customer_id", value: id },
					{ field: "status", value: 0 },
					{ field: "type", value: "SO" }
				]
			});

			this.set("address", customerModel.get("customer").address);			
			this.setReceiptNumber();
			this.setItemSource();
			this.addNewRow();
		},
		vat 				: function(){
			var vat = 0;
			var vatItem = 0;


			return kendo.toString(vat, "c0");
		},
		rate 				: function(){
			var rate = 0;

			return kendo.toString(rate, "c0");
		},		
	    setItemSource 		: function(){	    				  	
		  	for (var i=0; i< itemDS.total(); i++) {
	    		var data = itemDS.data();

	    		this.itemList.push({
	    			id 		: data[i].id,
	    			name 	: data[i].item_sku +' '+ data[i].name	    			
	    		});
	    	}	    	
	    },	    
	    setReceiptNumber 	: function(){
	    	var last_receipt_no = this.get("last_receipt_no");		
			var invoice_no = 0;
			if(last_receipt_no.length>6){
				invoice_no = parseInt(last_receipt_no.substr(6));			
			}
			invoice_no++;

			var str_inv_no = "SR" + kendo.toString(new Date(this.get("issued_date")), "yy") + kendo.toString(new Date(this.get("issued_date")), "MM");
			var inv_no = str_inv_no + kendo.toString(invoice_no, "00000");

			this.set("number", inv_no);
	    },
		autoIncreaseNo 		: function(){
			$(".sno").each(function(index,element){                 
			   $(element).text(index + 1); 
			});
		},
		addNewRow 			: function(){
			this.receiptItemList.push({
				'invoice_id' 	: 0,
				'item_id' 		: "",
				'description' 	: "",				
				'quantity' 		: 1,
				'unit_price' 	: 0,
				'rate'			: kendo.parseFloat(this.get("rate")),				
				'amount' 		: 0,
				'vat' 			: false				
			});
			this.autoIncreaseNo();			
		},
		removeRow 			: function(e){
			var item = e.data;
	        var index = this.get("receiptItemList").indexOf(item);        
	        this.get("receiptItemList").splice(index, 1);
	        this.change();
		},
		change				: function(){			
			var subTotal = 0;		
			$.each(this.get("receiptItemList"), function(index, data) {				
				var amt = (data.quantity * data.unit_price);
					            
	            data.set("amount", amt);
	            subTotal += tamt;
	        });			

			var total = (subTotal + kendo.parseFloat(this.get("fine"))) - kendo.parseFloat(this.get("discount"));

			this.set("sub_total", kendo.toString(subTotal,"c0"));
			this.set("total", kendo.toString(total,"c0"));

	    	this.autoIncreaseNo();    	
		},
		itemChange 			: function(e){
			var d = e.data;
			var arr =  this.get("receiptItemList");			
	        var index = arr.indexOf(d);
	        var data = arr[index];
	        var item = itemDS.get(d.item_id);
	        
    		data.set("description", item.name);
	        data.set("unit_price", item.price);
	        	        
	        this.change();	                	        	
		},
		estimateChange 		: function(e){
			var d = e.sender;
			var id = kendo.parseInt(d._selectedValue);
			this.set("receiptItemList", []);			
			if(id>0 || id!=null){
			 	var d = estimateDS.get(id);			
			 	var items = d.invoice_items;

			 	for (var i=0;i<items.length;i++) {
			 		var it = items[i];
			 		this.receiptItemList.push({
						'invoice_id' 	: it.invoice_id,
						'item_id' 		: it.item_id,
						'description' 	: it.description,				
						'quantity' 		: it.quantity,
						'unit_price' 	: it.unit_price,
						'vat' 			: it.vat,
						'amount' 		: it.amount				
					});			
			 	}			 	
			 	this.set("estimate_id", id);
			 	this.set("gdn_id", 0);
			 	this.set("so_id", 0);

			 	this.change();
			 	this.autoIncreaseNo();				
			}else{
				this.set("total", kendo.toString(0,"c0"));
			}				
		},
		gdnChange 			: function(e){
			var d = e.sender;
			var id = kendo.parseInt(d._selectedValue);
			this.set("receiptItemList", []);			
			if(id>0 || id!=null){
			 	var d = gdnDS.get(id);			
			 	var items = d.invoice_items;

			 	for (var i=0;i<items.length;i++) {
			 		var it = items[i];
			 		this.receiptItemList.push({
						'invoice_id' 	: it.invoice_id,
						'item_id' 		: it.item_id,
						'description' 	: it.description,				
						'quantity' 		: it.quantity,
						'unit_price' 	: it.unit_price,
						'vat' 			: it.vat,
						'amount' 		: it.amount				
					});			
			 	}
			 	this.set("estimate_id", 0);
			 	this.set("gdn_id", id);
			 	this.set("so_id", 0);

			 	this.change();
			 	this.autoIncreaseNo();				
			}else{
				this.set("total", kendo.toString(0,"c0"));
			}				
		},
		soChange 			: function(e){
			var d = e.sender;
			var id = kendo.parseInt(d._selectedValue);
			this.set("receiptItemList", []);			
			if(id>0 || id!=null){
			 	var d = soDS.get(id);			
			 	var items = d.invoice_items;

			 	for (var i=0;i<items.length;i++) {
			 		var it = items[i];
			 		this.receiptItemList.push({
						'invoice_id' 	: it.invoice_id,
						'item_id' 		: it.item_id,
						'description' 	: it.description,				
						'quantity' 		: it.quantity,
						'unit_price' 	: it.unit_price,
						'vat' 			: it.vat,
						'amount' 		: it.amount,
						'so_id'			: it.so_id				
					});			
			 	}
			 	this.set("estimate_id", 0);
			 	this.set("gdn_id", 0);
			 	this.set("so_id", id);

			 	this.change();
			 	this.autoIncreaseNo();				
			}else{
				this.set("total", kendo.toString(0,"c0"));
			}				
		},		
	    createReceipt 		: function(){	    	
	        //Add invoice to datasource	
	    	invoiceDS.add({
	    		'number' 			: this.get("number"),
			   	'type'				: "Receipt",
			   	'status' 			: 0,			   	
			   	'amount'			: kendo.parseFloat(this.get("total")),
			   	'biller' 			: this.get("biller"),
			   	'customer_id' 		: this.get("customer_id"),			   	
			   	'address' 			: this.get("address"),
			   	'issued_date' 		: kendo.toString(this.get("issued_date"),"yyyy-MM-dd"),
			   	'estimate_id' 		: this.get("estimate_id"),
				'gdn_id' 			: this.get("gdn_id"),			   	
			   	'class_id' 			: this.get("class_id"),
			   	'memo' 				: this.get("memo"),
			   	'company_id'		: customerModel.get("customer").company_id,

			   	'invoice_items'		: this.get("receiptItemList")
	    	});
	    	invoiceDS.sync();
	    	
	    	this.addJournal();	    	
	    	this.updateEstimate();
		    this.updateGDN();	    		    	
	    },	    	  
	    addJournal 			: function(){				
			var journalEntries = [];		
			
			var saleList = {};			
			var inventoryList = {};
			var cogsList = {};
			var witdrawList = {};
			var depositAmount = 0;

			$.each(this.get("receiptItemList"), function(index, data){								
				var item = itemDS.get(data.item_id);
				var amt = kendo.parseFloat(data.amount);
				
				//Add sale list
				var incomeID = kendo.parseInt(item.income_account_id);
											
				if(incomeID>0){
					if(saleList[incomeID]===undefined){
						saleList[incomeID]={"id": incomeID, "amt": amt};						
					}else{											
						if(saleList[incomeID].id===incomeID){
							saleList[incomeID].amt += amt;
						}else{
							saleList[incomeID]={"id": incomeID, "amt": amt};
						}
					}					
				}

				switch(kendo.parseInt(item.item_type_id)){		        
					case 1: //Inventory
						//Add cogs list						
						var itemCost = (kendo.parseFloat(item.cost)*kendo.parseFloat(data.quantity));

						//Add cogs list
						var cogsID = kendo.parseInt(item.cogs_account_id);
						if(cogsList[cogsID]===undefined){
							cogsList[cogsID]={"id": cogsID, "amt": itemCost};						
						}else{											
							if(cogsList[cogsID].id===cogsID){
								cogsList[cogsID].amt += itemCost;
							}else{
								cogsList[cogsID]={"id": cogsID, "amt": itemCost};
							}
						}						

						//Add inventory list
						var inventoryID = kendo.parseInt(item.general_account_id);
						if(inventoryList[inventoryID]===undefined){
							inventoryList[inventoryID]={"id": inventoryID, "amt": itemCost};						
						}else{											
							if(inventoryList[inventoryID].id===inventoryID){
								inventoryList[inventoryID].amt += itemCost;
							}else{
								inventoryList[inventoryID]={"id": inventoryID, "amt": itemCost};
							}
						}										

					  	break;
					case 5: //Customer Deposit
						depositAmount += amt;
						var depositID = kendo.parseInt(item.general_account_id);

						if(amt>0){ //Deposit														
							if(saleList[depositID]===undefined){
								saleList[depositID]={"id": depositID, "amt": amt};						
							}else{											
								if(saleList[depositID].id===depositID){
									saleList[depositID].amt += amt;
								}else{
									saleList[depositID]={"id": depositID, "amt": amt};
								}
							}																			
						}else{ //Witdraw												
							if(witdrawList[depositID]===undefined){
								witdrawList[depositID]={"id": depositID, "amt": amt*-1};						
							}else{											
								if(witdrawList[depositID].id===depositID){
									witdrawList[depositID].amt += (amt*-1);
								}else{
									witdrawList[depositID]={"id": depositID, "amt": amt*-1};
								}
							}														
						}												

					  	break;				
					default:
				  	//default here
				} //End Swtich
			});//End Foreach Loop			
			
			//Sale list	to journal		
			if(!jQuery.isEmptyObject(saleList)){								
				//Sum cash
				var cash = 0;				
				$.each(saleList, function(index, value){					
					cash += value.amt;					
				});				

				//Cash on Dr							
				journalEntries.push({
			 		account_id 	: receiptModel.get("cash_account_id"),	 		
			 		dr 			: cash, 
			 		cr 			: 0,
			 		class_id  	: receiptModel.get("class_id"),
			 		memo 		: receiptModel.get("memo")	 		
				});

				//Sale accounts on Cr
				$.each(saleList, function(index, value){
					journalEntries.push({
				 		account_id 	: value.id,	 		
				 		dr 			: 0, 
				 		cr 			: value.amt,
				 		class_id  	: receiptModel.get("class_id"),
				 		memo 		: receiptModel.get("memo")	 		
					});
				});
			}

			//Inventory to journal
			//COGS on Dr 			
			if(!jQuery.isEmptyObject(cogsList)){							
				$.each(cogsList, function(index, value){				
					journalEntries.push({
				 		account_id 	: value.id,	 		
				 		dr 			: value.amt, 
				 		cr 			: 0,
				 		class_id  	: receiptModel.get("class_id"),
				 		memo 		: receiptModel.get("memo")	 		
					});	
				});							
			}
			//Inventory on Cr
			if(!jQuery.isEmptyObject(inventoryList)){
				$.each(inventoryList, function(index, value){					
					journalEntries.push({
				 		account_id 	: value.id,	 		
				 		dr 			: 0, 
				 		cr 			: value.amt,
				 		class_id  	: receiptModel.get("class_id"),
				 		memo 		: receiptModel.get("memo")	 		
					});
				});
			}
			
			//Witdraw to journal
			if(!jQuery.isEmptyObject(witdrawList)){
				//Deposit on Dr
				$.each(witdrawList, function(index, value){
					journalEntries.push({
				 		account_id 	: value.id,	 		
				 		dr 			: value.amt, 
				 		cr 			: 0,
				 		class_id  	: receiptModel.get("class_id"),
				 		memo 		: receiptModel.get("memo")	 		
					});
				});

				var wCash = 0;
				$.each(witdrawList, function(index, value){					
					wCash += value.amt;
				});

				//Cash on Cr							
				journalEntries.push({
			 		account_id 	: this.get("cash_account_id"),	 		
			 		dr 			: 0, 
			 		cr 			: wCash,
			 		class_id  	: receiptModel.get("class_id"),
			 		memo 		: receiptModel.get("memo")	 		
				});				
			}
			//Calcualte customer deposit
			if(depositAmount>0){				
				var deposit = kendo.parseFloat(customerModel.get("customer").deposit_amount) + kendo.parseFloat(depositAmount);
				this.set("deposit_amount", deposit);
			}
			
			//Add journal to datasource
			journalDS.add({	 		
		 		journalEntries : journalEntries,
		 		memo: "បង្កាន់ដៃលក់ជាសាច់ប្រាក់", 
		 		voucher: "",
		 		class_id: this.get("class_id"),
		 		budget_id: 0,
		 		donor_id: 0,
		 		check_no: "",
		 		people_id: this.get("customer_id"),
		 		employee_id: this.get("biller"),
		 		invoice_id: this.get("next_inv_id"),
		 		payment_id: 0,
		 		bill_id: 0,	
		 		date: kendo.toString(this.get("issued_date"), "yyyy-MM-dd"), 
		 		transaction_type: "Receipt"	 			 		
		 	});
		 	
		 	journalDS.sync();
		  	this.updateCustomerDeposit();
			this.clearReceipt();	 	
		},				
		updateEstimate		: function(){
			var id = this.get("estimate_id");
			
			if(id>0){
				var d = estimateDS.get(id);
				d.set("status", 1);
				estimateDS.sync();
			}								
		},
		updateGDN			: function(){
			var id = this.get("gdn_id");
			
			if(id>0){
				var d = gdnDS.get(id);
				d.set("status", 1);
				gdnDS.sync();
			}								
		},
		updateCustomerDeposit : function(){
			var id = this.get("customer_id");
			var amount = this.get("deposit_amount");
			if(amount>0){
				$.ajax({
					type: "PUT",
					url: ARNY.baseUrl + "api/people_api/deposit",			
					data: { id: id, amount: amount },
					dataType: "json",
					success: function (response) {
						//var data = response.d;			  
					}
				});
			}				
		},
	    clearReceipt 		: function(){
	    	var next_inv_id = kendo.parseInt(this.get("next_inv_id"))+1;
	    	this.set("next_inv_id", next_inv_id);	    	
	    	this.set("last_receipt_no", this.get("number"));
	    	
	    	this.set("estimate_id", 0);
	    	this.set("gdn_id", 0);
	    	this.set("so_id", 0);
			this.set("receiptItemList", []);

			this.set("memo", "");
			this.set("sub_total", kendo.toString(0,"c0"));
			this.set("total", kendo.toString(0,"c0"));

			//Remove invoice
			for (var i=0; i< invoiceDS.total(); i++) {
				var dataItem = invoiceDS.at(i);
	  			invoiceDS.remove(dataItem);
			}

			//Remove payment
			for (var j=0; j< paymentDS.total(); j++) {
				var dataItem = paymentDS.at(j);
	  			paymentDS.remove(dataItem);
			}

			//Remove journal
			for (var k=0; k< journalDS.total(); k++) {
				var dataItem = journalDS.at(k);
	  			journalDS.remove(dataItem);
			}

			this.pageLoad();
	    }
	});	

	var soModel = kendo.observable({
		last_no 			: "<?php echo $last_so_no;?>",
		
		number 				: "",
		type 				: "SO",
		status				: 0,
		biller				: <?php echo $this->session->userdata('user_id'); ?>,	
		customer_id			: 0,
		address				: "",		  	  
		issued_date			: new Date(),		
		memo				: "",		

		total 				: kendo.toString(0,"c0"),					    
		
		soItemList 			: [],
		itemList 			: [],						
		
		pageLoad 			: function(id){			
			this.set("customer_id", id);
			this.set("total", kendo.toString(0,"c0"));
			this.set("soItemList", []);
			this.set("itemList", []);

			this.set("address", customerModel.get("customer").address);
			this.setExpectedDate();			
			this.setNumber();
			this.setItemSource();
			this.addNewRow();
		},
		setExpectedDate 			: function(){
			var exdate = new Date();
			exdate.setDate(exdate.getDate()+1);
			this.set("expected_date", exdate);
		},		
	    setItemSource 		: function(){	    				  	
		  	for (var i=0; i< itemDS.total(); i++) {
	    		var data = itemDS.data();

	    		this.itemList.push({
	    			id 		: data[i].id,
	    			name 	: data[i].item_sku +' '+ data[i].name	    			
	    		});
	    	}	    	
	    },	    
	    setNumber 		: function(){
	    	var last_no = this.get("last_no");		
			var no = 0;
			if(last_no.length>6){
				no = parseInt(last_no.substr(6));			
			}
			no++;

			var str_no = "SO" + kendo.toString(new Date(this.get("issued_date")), "yy") + kendo.toString(new Date(this.get("issued_date")), "MM");
			var number = str_no + kendo.toString(no, "00000");

			this.set("number", number);
	    },
		autoIncreaseNo 		: function(){
			$(".sno").each(function(index,element){                 
			   $(element).text(index + 1); 
			});
		},
		addNewRow 			: function(){
			this.soItemList.push({
				'invoice_id' 	: 0,
				'item_id' 		: "",
				'description' 	: "",				
				'quantity' 		: 1,
				'unit_price' 	: 0,				
				'amount' 		: 0										
			});
			this.autoIncreaseNo();			
		},
		removeRow 			: function(e){
			var item = e.data;
	        var index = this.get("soItemList").indexOf(item);        
	        this.get("soItemList").splice(index, 1);
	        this.change();
		},
		change				: function(){			
			var total = 0;		
			$.each(this.get("soItemList"), function(index, data) {				
				var amt = data.quantity * data.unit_price;
									            
	            data.set("amount", amt);	            
	            total += amt;
	        });			

			this.set("total", kendo.toString(total,"c0"));

	    	this.autoIncreaseNo();    	
		},
		itemChange 			: function(e){
			var d = e.data;
			var arr =  this.get("soItemList");			
	        var index = arr.indexOf(d);
	        var data = arr[index];
	        var item = itemDS.get(d.item_id);	        
			
	        data.set("description", item.name);
	        data.set("unit_price", item.price);
	        	        
	        this.change();	        	        	
		},		
	    createSO 		: function(){
	        //Add invoice to datasource	
	    	invoiceDS.add({
	    		'number' 			: this.get("number"),
			   	'type'				: this.get("type"),
			   	'status' 			: this.get("status"),
			   	'amount' 			: kendo.parseFloat(this.get("total")),
			   	'biller' 			: this.get("biller"),
			   	'customer_id' 		: this.get("customer_id"),			   	
			   	'address' 			: this.get("address"),
			   	'issued_date' 		: kendo.toString(this.get("issued_date"),"yyyy-MM-dd"),
			   	'expected_date' 	: kendo.toString(this.get("expected_date"),"yyyy-MM-dd"),				   	
			   	'memo' 				: this.get("memo"),
			   	'company_id'		: customerModel.get("customer").company_id,
			   	
			   	'invoice_items'		: this.get("soItemList")
	    	});
	    	invoiceDS.sync();
	    	this.clearDatasource();	    	
	    },	    
	    clearDatasource 		: function(){	    	
			this.set("soItemList", []);
			this.set("last_no", this.get("number"));
			
			//Remove invoice
			for (var i=0; i< invoiceDS.total(); i++) {
				var dataItem = invoiceDS.at(i);
	  			invoiceDS.remove(dataItem);
			}

			this.pageLoad();			
	    }
	});

	var estimateModel = kendo.observable({
		last_estimate_no 	: "<?php echo $last_estimate_no;?>",
		
		number 				: "",
		type 				: "Estimate",
		status				: 0,
		biller				: <?php echo $this->session->userdata('user_id'); ?>,	
		customer_id			: 0,
		address				: "",		  	  
		issued_date			: new Date(),		
		memo				: "",		

		total : kendo.toString(0,"c0"),					    
		
		estimateItemList 	: [],
		itemList 			: [],						
		
		pageLoad 			: function(id){
			this.set("customer_id", id);
			this.set("total", kendo.toString(0,"c0"));
			this.set("estimateItemList", []);
			this.set("itemList", []);

			this.set("address", customerModel.get("customer").address);			
			this.setEstimateNumber();
			this.setItemSource();
			this.addNewRow();
		},		
	    setItemSource 		: function(){	    				  	
		  	for (var i=0; i< itemDS.total(); i++) {
	    		var data = itemDS.data();

	    		this.itemList.push({
	    			id 		: data[i].id,
	    			name 	: data[i].item_sku +' '+ data[i].name	    			
	    		});
	    	}	    	
	    },	    
	    setEstimateNumber 		: function(){
	    	var last_estimate_no = this.get("last_estimate_no");		
			var estimate_no = 0;
			if(last_estimate_no.length>6){
				estimate_no = parseInt(last_estimate_no.substr(6));			
			}
			estimate_no++;

			var str_no = "QO" + kendo.toString(new Date(this.get("issued_date")), "yy") + kendo.toString(new Date(this.get("issued_date")), "MM");
			var est_no = str_no + kendo.toString(estimate_no, "00000");

			this.set("number", est_no);
	    },
		autoIncreaseNo 		: function(){
			$(".sno").each(function(index,element){                 
			   $(element).text(index + 1); 
			});
		},
		addNewRow 			: function(){
			this.estimateItemList.push({
				'invoice_id' 	: 0,
				'item_id' 		: "",
				'description' 	: "",				
				'quantity' 		: 1,
				'unit_price' 	: 0,				
				'amount' 		: 0,
				'markup'		: 0							
			});
			this.autoIncreaseNo();			
		},
		removeRow 			: function(e){
			var item = e.data;
	        var index = this.get("estimateItemList").indexOf(item);        
	        this.get("estimateItemList").splice(index, 1);
	        this.change();
		},
		change				: function(){			
			var total = 0;		
			$.each(this.get("estimateItemList"), function(index, data) {				
				var amt = data.quantity * data.unit_price;
				var t = amt + data.markup;				
					            
	            data.set("amount", amt);	            
	            total += t;
	        });			

			this.set("total", kendo.toString(total,"c0"));

	    	this.autoIncreaseNo();    	
		},
		itemChange 			: function(e){
			var d = e.data;
			var arr =  this.get("estimateItemList");			
	        var index = arr.indexOf(d);
	        var data = arr[index];
	        var item = itemDS.get(d.item_id);	        
			
	        data.set("description", item.name);
	        data.set("unit_price", item.price);
	        	        
	        this.change();	        	        	
		},		
	    createEstimate 		: function(){
	        //Add invoice to datasource	
	    	invoiceDS.add({
	    		'number' 			: this.get("number"),
			   	'type'				: this.get("type"),
			   	'status' 			: this.get("status"),
			   	'amount' 			: kendo.parseFloat(this.get("total")),
			   	'biller' 			: this.get("biller"),
			   	'customer_id' 		: this.get("customer_id"),			   	
			   	'address' 			: this.get("address"),
			   	'issued_date' 		: kendo.toString(this.get("issued_date"),"yyyy-MM-dd"),			   	
			   	'memo' 				: this.get("memo"),
			   	'company_id'		: customerModel.get("customer").company_id,
			   	
			   	'invoice_items'		: this.get("estimateItemList")
	    	});
	    	invoiceDS.sync();
	    	this.clearDatasource();	    	
	    },	    
	    clearDatasource 		: function(){	    	
			this.set("estimateItemList", []);
			this.set("last_estimate_no", this.get("number"));
			
			//Remove invoice
			for (var i=0; i< invoiceDS.total(); i++) {
				var dataItem = invoiceDS.at(i);
	  			invoiceDS.remove(dataItem);
			}

			this.pageLoad();			
	    }
	});

	var gdnModel = kendo.observable({
		last_no 			: "<?php echo $last_gdn_no;?>",
		
		number 				: "",
		batch_no			: "",
		type 				: "GDN",
		status				: 0,
		biller				: <?php echo $this->session->userdata('user_id'); ?>,	
		customer_id			: 0,
		address				: "",		  	  
		issued_date			: new Date(),		
		memo				: "",		

		total 				: kendo.toString(0,"c0"),					    
		
		gdnItemList 		: [],
		itemList 			: [],						
		
		pageLoad 			: function(id){
			this.set("customer_id", id);
			this.set("gdnItemList", []);
			this.set("itemList", []);

			this.set("address", customerModel.get("address"));			
			this.setNumber();
			this.setBatchNo();
			this.setItemSource();
			this.addNewRow();
		},		
	    setItemSource 		: function(){	    				  	
		  	for (var i=0; i< itemDS.total(); i++) {
	    		var data = itemDS.data();

	    		this.itemList.push({
	    			id 		: data[i].id,
	    			name 	: data[i].item_sku +' '+ data[i].name	    			
	    		});
	    	}	    	
	    },	    
	    setNumber 		: function(){
	    	var last_no = this.get("last_no");		
			var no = 0;
			if(last_no.length>7){
				no = parseInt(last_no.substr(7));			
			}
			no++;

			var str_no = "GDN" + kendo.toString(new Date(this.get("issued_date")), "yy") + kendo.toString(new Date(this.get("issued_date")), "MM");
			var number = str_no + kendo.toString(no, "00000");

			this.set("number", number);
	    },
	    setBatchNo	: function(){	    	
			var str_no = kendo.toString(new Date(), "yy") + kendo.toString(new Date(), "MM") + + kendo.toString(new Date(), "dd");
			
			this.set("batch_no", str_no);
	    },
		autoIncreaseNo 		: function(){
			$(".sno").each(function(index,element){                 
			   $(element).text(index + 1); 
			});
		},
		addNewRow 			: function(){
			this.gdnItemList.push({
				'invoice_id' 	: 0,
				'item_id' 		: "",
				'description' 	: "",				
				'quantity' 		: 1,
				'unit_price' 	: 0														
			});
			this.autoIncreaseNo();			
		},
		removeRow 			: function(e){
			var item = e.data;
	        var index = this.get("gdnItemList").indexOf(item);        
	        this.get("gdnItemList").splice(index, 1);
	        this.change();
		},		
		itemChange 			: function(e){
			var d = e.data;
			var arr =  this.get("gdnItemList");			
	        var index = arr.indexOf(d);
	        var data = arr[index];
	        var item = itemDS.get(d.item_id);	        
			
	        data.set("description", item.name);
	        data.set("unit_price", item.price);	                       	        	        	
		},		
	    createGDN 		: function(){
	    	var amount = 0;
	    	for (var i=0; i< this.gdnItemList.length; i++) {
	    		var d = this.gdnItemList[i];
	    		amount += (d.quantity * d.unit_price);
	    		d.set("amount", amount);	    		
	    	}	    	

	        //Add invoice to datasource	
	    	invoiceDS.add({
	    		'number' 			: this.get("number"),
			   	'type'				: this.get("type"),
			   	'status' 			: this.get("status"),
			   	'amount'			: amount,
			   	'biller' 			: this.get("biller"),
			   	'customer_id' 		: this.get("customer_id"),			   	
			   	'address' 			: this.get("address"),
			   	'issued_date' 		: kendo.toString(this.get("issued_date"),"yyyy-MM-dd"),			   	
			   	'memo' 				: this.get("memo"),
			   	'batch_no' 			: this.get("batch_no"),
			   	'company_id'		: customerModel.get("customer").company_id,

			   	'invoice_items'		: this.get("gdnItemList")
	    	});
	    	invoiceDS.sync();
	    	this.clearDatasource();	    	
	    },	    
	    clearDatasource 		: function(){	    	
			this.set("gdnItemList", []);
			this.set("last_no", this.get("number"));
			
			//Remove invoice
			for (var i=0; i< invoiceDS.total(); i++) {
				var dataItem = invoiceDS.at(i);
	  			invoiceDS.remove(dataItem);
			}

			this.pageLoad();			
	    }
	});
	
	var noticeModel = kendo.observable({
		last_notice_no 		: "<?php echo $last_notice_no;?>",			
		number 				: "",
		
		status				: 0,
		biller				: <?php echo $this->session->userdata('user_id'); ?>,			
		address				: "",		  	  
		issued_date			: new Date(),
		due_date			: "",		
		payment_term_id		: "",		
		memo				: "",
		class_id			: "",		
								
		avg 				: 0,
		usage_per_day		: 0,		
		totalReading 		: 0,
		selectedReading		: 0,
		
		noticeItemList 		: [],
		selectedReadingList	: [],
		invoiceList 		: [],
		averageRecordList 	: [],
		invoiceIdList		: [],

		paymentTermList		: paymentTermDS,
		currencyList		: currencyDS,
		classList 			: classDS,
		meterList 			: meterDS,
		readingList 		: meterRecordDS,				
		
		pageLoad 			: function(id){
			var cus = customerDS.get(id);

			this.set("address", cus.address);
			this.set("customer_id", id);			
			this.set("noticeItemList", []);

			this.setDueDate();
			this.setNoticeNumber();
			planItemDS.read();			
			tariffItemDS.read();						
		},		
		setNoticeNumber 	: function(){
	    	var last_notice_no = this.get("last_notice_no");		
			var notice_no = 0;
			if(last_notice_no.length>8){
				notice_no = parseInt(last_notice_no.substr(8));						
			}
			notice_no++;

			var str_inv_no = "ESINV" + kendo.toString(new Date(this.get("issued_date")), "yy") + kendo.toString(new Date(this.get("issued_date")), "MM");
			var inv_no = str_inv_no + kendo.toString(notice_no, "000");

			this.set("number", inv_no);
	    },
	    total 				: function(){
			var total = 0;	
			$.each(this.get("noticeItemList"), function(index, data) {
				var amt = ((kendo.parseInt(data.days*data.usage_per_day))*data.unit_price)-data.amount_paid;				
	            total+=amt;	            
	        });
	        return kendo.toString(total, 'c0');	
		},
	    setDueDate 			: function(){
	    	var duedate = new Date();
			duedate.setDate(duedate.getDate()+7);
			this.set("due_date", duedate);			
	    },
	    reset 				: function(){
			this.set("totalReading", 0);
			this.set("avg", 0);
			this.set("selectedReading", 0);
			this.set("usage_per_day", 0);

			var d = meterRecordDS.data();
			if(d.length>0){
				$.each(d, function(index, data) {						           
		            data.set("isCheck", false);	            
		        });	
			}

			this.avgChange();
		},		
	    getTariffId  		: function(tariff_plan_id, month_of){	    	
			var tariff_id = 0;						
			var data = planItemDS.data();						
	        for (var i = 0; i < data.length; i++) {
	            var d = data[i];	            
	            if((d.tariff_plan_id==tariff_plan_id) && (month_of>=d.start_date)){
	            	tariff_id = d.tariff_id;
	            	break;
	            }
	        }
	        return tariff_id;		
		},	      
		addNewRow 			: function(){
			var meter = this.get("meter");

			this.noticeItemList.push({				
				'invoice_id' 	: 0,
				'meter_id'		: meter.id,
				'month_of'		: "",
				'description'	: "",
				'days' 			: 0,				
				'usage_per_day' : this.get("usage_per_day"),				
				'unit_price'	: 0,				
				'amount_paid' 	: 0,
				'amount'		: 0						
			});						
		},
		removeRow 			: function(e){
			var item = e.data;
	        var index = this.get("noticeItemList").indexOf(item);        
	        this.get("noticeItemList").splice(index, 1);	        
		},		
		meterChange 		: function(){
			var meter = this.get("meter");
			var address = meter.electricity_boxes.box_no + ' ' + meter.meter_no;
			this.set("address", address); 
			
			meterRecordDS.filter({ field: "meter_id", value: meter.id });
		},
		gridChange 			: function(eventArgs) {
	        var data = eventArgs.sender.dataItem(eventArgs.sender.select());
	        this.selectedReadingList.push(data.active_usage);
	    },	    
		avgChange			: function(){			
			var usage_per_day = this.get("usage_per_day");
			var arr = this.get("noticeItemList");
			if(arr.length>0){
				$.each(arr, function(index, data) {				
		            data.set("usage_per_day", usage_per_day);	            
		        });	
			}			    	
		},
		monthOfChange 		: function(e){		
			var d = e.data;
			var meter = this.get("meter");
			var cus = customerModel.get("customer");

			var fullMonthOf = new Date(d.month_of);
			fullMonthOf.setDate(1);
			fullMonthOf = kendo.toString(fullMonthOf, "yyyy-MM-dd");

			d.set("description", "ថាមពលត្រូវរំលឹកសំរាប់ខែ " + kendo.toString(new Date(d.month_of), "MM-yyyy"));

			var tariff_id = this.getTariffId(cus.tariff_plan_id, fullMonthOf);			
			var active_usage = kendo.parseInt(d.days*d.usage_per_day);
			
			//Apply tariff item
			var price = 0;
			var dataj = tariffItemDS.data();
			for (var j=0;j<dataj.length;j++){				 
				var dj = dataj[j];								
				if((dj.tariff_id==tariff_id) && (active_usage>=dj.usage)){
					if(dj.is_flat==0){
						price = dj.price;																									
					}else{												
						price = dj.amount;										
					}
				}
			}

			d.set("unit_price", price);
		
			$.ajax({
				type: "GET",
				url: ARNY.baseUrl + "api/invoice_items/by_meter_id_month_of",
				data: {
					meter_id 	: meter.id,
					month_of 	: fullMonthOf
				},
				dataType: "json",
				success: function (response) {
					//var data = response.d;
					d.set("amount_paid", response);											  
				}
			});        	        	        	
		},
		checkboxChange 		: function(){			
			var total = 0;
			var counter = 0;
			for (var i=0;i< meterRecordDS.total(); i++) {
				var d = meterRecordDS.at(i);
				
				if(d.isCheck){
					total += d.active_usage;
					counter++;
				}
			}

			var avgNum = total/counter;
			var avg = Math.ceil(avgNum * 100) / 100;

			var num = avg/30;
			var usage_per_day = Math.ceil(num * 100) / 100;
			
			this.set("totalReading", total);
			this.set("avg", avg);
			this.set("selectedReading", counter);
			this.set("usage_per_day", usage_per_day);

			this.avgChange();
		},		
	    createNotice 		: function(){	    	
	    	var arr = this.get("noticeItemList");
			if(arr.length>0){
				//Change date format
				$.each(arr, function(index, data) {
					//Month Of
					var fullMonthOf = new Date(data.month_of);
					fullMonthOf.setDate(1);
					fullMonthOf = kendo.toString(fullMonthOf, "yyyy-MM-dd");				
		            data.set("month_of", fullMonthOf);

		            //Amount
		            var amt = ((kendo.parseInt(data.days*data.usage_per_day))*data.unit_price)-data.amount_paid;
		            data.set("amount", amt);
		        });

		        //Add average record to []
		        for (var i=0; i< meterRecordDS.total(); i++) {
		    		var d = meterRecordDS.at(i);					
		            this.get("averageRecordList").push({
			    		notice_id		: 0,
			    		meter_record_id : d.id
			    	});

			    	if(d.invoice_id>0){
			    		this.get("invoiceIdList").push(d.invoice_id);
			    	}           
		        }

		        //Add invoice to datasource	
		    	invoiceDS.add({
		    		'number'			: this.get("number"),
		    		'type'				: "Notice",
		    		'customer_id' 		: this.get("customer_id"),
		    		'address'  			: this.get("address"),			   	
				   	'biller' 	 		: this.get("biller"),
				   	'issued_date' 		: kendo.toString(this.get("issued_date"),'yyyy-MM-dd'),
				   	'due_date'			: kendo.toString(new Date(this.get("due_date")),'yyyy-MM-dd'),
				   	'payment_term_id'	: this.get("payment_term_id"),				   	
				   	'class_id' 			: this.get("class_id"),
				   	'memo'				: this.get("memo"),

				   	'invoice_items'		: this.get("noticeItemList"),
				   	'average_records'	: this.get("averageRecordList")
		    	});
		    	invoiceDS.sync();
		    	this.clearDatasource();
		    	this.updateInvoiceStatus3();	
			}	        	    	
	    },
	    updateInvoiceStatus3 : function(){
			var ids = this.get("invoiceIdList");
			if(ids.length>0){
				$.ajax({
					type: "PUT",
					url: ARNY.baseUrl + "api/invoices/status3",			
					data: {ids: kendo.stringify(ids)},
					dataType: "json",
					success: function (response) {
						//var data = response.d;			  
					}
				});
			}							
		},	    	    
	    clearDatasource 	: function(){	    	
			this.set("noticeItemList", []);
			this.set("averageRecordList", []);

			//Remove invoice
			for (var i=0; i< invoiceDS.total(); i++) {
				var dataItem = invoiceDS.at(i);
	  			invoiceDS.remove(dataItem);
			}						
	    }
	});

	var statementModel = kendo.observable({
		amount_due 		: kendo.toString(0, 'c0'),

		statementList 	: statementDS,
		agingList 		: agingDS,
		
		pageLoad 		: function(id){
			var cus = customerDS.get(id);
			var fullname = cus.surname + ' ' + cus.name;
			var fullIdName = cus.number + ' ' + fullname;
			var address = cus.house_no + ' ' + cus.street_no;

			this.set("customer_id", id);			
			this.set("fullname", fullname);
			this.set("fullIdName", fullIdName);
			this.set("address", address);
						
		},
		statement_date_text : function(){
			return kendo.toString(this.get("statement_date"), "dd-MM-yyyy");
		},
		loadStatement 		: function(){
			statementDS.read();
			agingDS.read();
		},
		printStatement 		: function(){
			$("#divStatement").print();
		}
	});

	//View & layout
	var layout 				= new kendo.Layout("#appIndex");
	var dashBoardView		= new kendo.View("#dashBoardView", {model: dashBoardModel});
	var customerSummaryView	= new kendo.View("#customerSumamryView", {model: customerModel});
	var customerView		= new kendo.View("#customerView", {model: customerModel});
	var editElectricityCustomerView	= new kendo.View("#editElectricityCustomerView", {model: customerModel});
	var editNormalCustomerView	= new kendo.View("#editNormalCustomerView", {model: customerModel});	
	var meterView 			= new kendo.View("#meterView", { model: meterModel });
	var addMeterRecordView 	= new kendo.View("#addMeterRecordView", { model: meterRecordModel });
	var invoiceView 		= new kendo.View("#invoiceView", { model: invoiceModel });
	var receiptView 		= new kendo.View("#receiptView", { model: receiptModel });
	var estimateView 		= new kendo.View("#estimateView", { model: estimateModel });
	var soView 		 		= new kendo.View("#soView", { model: soModel });
	var gdnView 			= new kendo.View("#gdnView", { model: gdnModel });
	var noticeView 			= new kendo.View("#noticeView", { model: noticeModel });
	var statementView 		= new kendo.View("#statementView", { model: statementModel });
				
	//Route
	var router = new kendo.Router({
		init: function() {
			layout.render("#application");
		}
	});

	router.route("/", function(){		
		layout.showIn("#content", dashBoardView);
		dashBoardModel.pageLoad();					
	});

	router.route("/:id", function(id) {			
		layout.showIn("#info", customerSummaryView);
		layout.showIn("#content", customerView);
		customerModel.pageLoad(id);		
	});

	router.route("/:id/meter", function(id){		
		meterModel.pageLoad(id);
		layout.showIn("#content", meterView);		
	});

	router.route("/:id/editElectricityCustomer", function(id){		
		customerModel.pageLoadEdit(id);
		layout.showIn("#content", editElectricityCustomerView);		
	});

	router.route("/:id/editNormalCustomer", function(id){		
		customerModel.pageLoadEdit(id);
		layout.showIn("#content", editNormalCustomerView);		
	});

	router.route("/:id/meterRecord", function(id){
		meterRecordModel.pageLoad(id);		
		layout.showIn("#content", addMeterRecordView);					
	});

	router.route("/:id/:inv_id/invoice", function(id,inv_id){
		invoiceModel.pageLoad(id, inv_id);		
		layout.showIn("#content", invoiceView);					
	});

	router.route("/:id/receipt", function(id){
		receiptModel.pageLoad(id);		
		layout.showIn("#content", receiptView);					
	});

	router.route("/:id/estimate", function(id){
		estimateModel.pageLoad(id);		
		layout.showIn("#content", estimateView);					
	});

	router.route("/:id/so", function(id){
		soModel.pageLoad(id);		
		layout.showIn("#content", soView);					
	});

	router.route("/:id/gdn", function(id){
		gdnModel.pageLoad(id);		
		layout.showIn("#content", gdnView);					
	});

	router.route("/:id/notice", function(id){
		noticeModel.pageLoad(id);		
		layout.showIn("#content", noticeView);					
	});

	router.route("/:id/statement", function(id){
		statementModel.pageLoad(id);		
		layout.showIn("#content", statementView);					
	});

	$(function(){
		itemDS.read();

		$("#searchByArea").kendoComboBox({
            dataTextField: "transformer_number",
            dataValueField: "id",
            dataSource: transformerSearchDS,
            autoBind: false,
            filter: "contains",
            suggest: true            
        });

        function customerSearch(){
        	var txtSearch = $("#searchField").val();
			var transformer_id = $("#searchByArea").val();
			var para = Array();

			if(txtSearch!=""){
				para.push({
					field: "searchField", value: txtSearch					
				});
			}

			if(transformer_id!=""){
				para.push({
					field: "transformer_id", value: transformer_id					
				});
			}

			customerDS.filter(para);

			//Clear search
			$("#searchField").val("");
			var search = $("#searchByArea").data("kendoComboBox");
			search.value("");
        }

		$("#search").on('click', function() {
			customerSearch();				
		});

		$("#searchField").keyup(function(e) {
			var keycode = e.keyCode ? e.keyCode : e.which;

			//Press Enter
		   	if(keycode === 13) {    
		    	customerSearch();
		    }          
		});		

		//Customer list view
		$("#customerList").kendoListView({
			dataSource: customerDS,
			selectable: true,
			template: kendo.template($("#customerListTmpl").html()),
			change: function(e) {
				e.preventDefault();								
				var uid = this.select().data('uid');
				var data = this.dataSource.getByUid(uid);						
				var uri = "#/"+data.id;							
				router.navigate(uri);

				customerModel.set("deposit_amount", kendo.toString(kendo.parseFloat(data.deposit_amount), 'c0'));

				meterDS.filter({ field: "customer_id", value: data.id });																	
			}
		});

		router.start();
	});
</script>