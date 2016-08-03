<div class="container">
	<div class="row">
		<div class="span12">
			<?php $this->load->view("inventory/sidebar"); ?>
		</div>
		<div class="span12">
			<h1>Item Receipt</h1>
			<br>
			<div class="thumbnail">	
				<button id="show_cash" class="btn" type="button" disabled ><i class="icon-pencil"></i> Cash</button><span> </span>
				<button id="show_credit" class="btn" type="button" ><i class="icon-pencil"> </i> Credit</button>
				<button id="show_item_receipt_list" class="btn" type="button" ><i class="icon-list"> </i> Item Receipt List</button>
				<button id="show_edit_item_receipt" class="btn" type="button" disabled><i class="icon-edit"> </i> Edit Item Receipt</button>
			</div>
			<br>	 			 	
			<!--Cash Content -->
			<div id="cash">
				<div id="cash_validate">
				 	 <table>
						<tr>
							<td></td>
							<td>
								<!--Receipt Info -->
								<div class="well well-small">
									<table>
										<tr valign="top">
											<td width="80">អ្នកផ្គត់ផ្គង់:</td>
											<td><input id="cash_vendor" name="cash_vendor" data-bind="value: vendor_id"  placeholder="(--- ជ្រើសយកមួយ ---)" required data-required-msg="ត្រូវការ អ្នកផ្គត់ផ្គង់">
												<br>
												<span class="k-invalid-msg" data-for="cash_vendor"></span>
											</td>
											<td></td>
											<td><h2>Cash</h2></td>
										</tr>														
										<tr valign="top">
											<td></td>
											<td><label id="paid" style="font-size: 6em; color: white; display: none;" >Paid</label></td>												
											<td>ថ្ងៃចេញវិក្កយប័ត្រ:</td>
											<td>
												<input type="text" id="cash_bill_date" name="cash_bill_date" data-bind="value: bill_date" required data-required-msg="ត្រូវការ ថ្ងៃចេញវិក្កយប័ត្រ"/>
												<br>
												<span class="k-invalid-msg" data-for="cash_bill_date"></span>
											</td>
										</tr>					
										<tr valign="top" >
											<td></td>	
											<td></td>			
											<td>លេខ ref.</td>
											<td>
												<input type="text" id="cash_ref_no" name="cash_ref_no" data-bind="value: ref_no" class="k-textbox" required data-required-msg="ត្រូវការ លេខ ref."/>
												<br>
												<span class="k-invalid-msg" data-for="cash_ref_no"></span>
											</td>
										</tr>
										<tr valign="top">
											<td><span id="discount_date_title" style="display: none;" >ថ្ងៃបញ្ចុះតំលៃ:</span></td>
											<td>
												<span id="discount_date_input" style="display: none;" ><input id="cash_discount_date" name="cash_discount_date" data-bind="value: discount_date" /></span>
											</td>
											<td>ចំនួនត្រូវបង់:</td>
											<td>
												<input type="number"  min="0" value="0" id="cash_amount_due" name="cash_amount_due" data-bind="value: total" required data-required-msg="ត្រូវការ ចំនួនត្រូវបង់" disabled/>
												<br>
												<span class="k-invalid-msg" data-for="cash_amount_due"></span>
											</td>
										</tr>
										<tr valign="top">
											<td>ទម្រង់បង់ប្រាក់:</td>
											<td>
												<input id="payment_term_id" name="payment_term_id" data-bind="value: payment_term_id" required data-required-msg="ត្រូវការ ទម្រង់បង់ប្រាក់"/>	
												<br>
												<span class="k-invalid-msg" data-for="cash_term"></span>
											</td>
											<td>ថ្ងៃត្រូវបង់:</td>
											<td>
												<input id="cash_due_date" name="cash_due_date" data-bind="value: due_date" />
											</td>
										</tr>
																													
									</table>
								</div>
							</td>
							<td valign="top">
								<div class="alert alert-error">
									<table>
										<tr>
											<td valign="top">គណនីសាច់ប្រាក់:</td>
											<td >
												<input id="cash_account" name="cash_account" data-bind="value: account_id"  placeholder="(--- ជ្រើសយកមួយ ---)" required data-required-msg="ត្រូវការ គណនីបង់ប្រាក់"/>
												<br>   
												<span class="k-invalid-msg" data-for="cash_account"></span>		  
											</td>	
										</tr>
									</table>
								</div>
							</td>
						</tr>
					 </table>								
				
					<!--End Receipt Info -->
						
					<div id="cash_grid"></div>
					<br>
					<div class="cash_status" align="center"></div>		
					<div align="right">
						<button id="cash_add" class="btn btn-primary" type="button" ><i class="icon-hdd icon-white"></i> កត់ត្រា</button><span> </span><button id="cash_clear" class="btn " type="submit" ><i class="icon-remove-circle icon-black"> </i> មោឃភាព</button>
					</div>			 
					
				</div>
			</div>
			<!--End Cash Content -->
			
			<!--Credit Content -->
			<div id="credit" style="display: none;">
				<div id="credit_validate">
				  		<!--Receipt Info -->
				   	 	<table>
				   	   		<tr>
				   				<td></td>
				   				<td>
				   					<div class="well well-small">
				   						<table>
				   							<tr valign="top">
				   								<td width="80">អ្នកផ្គត់ផ្គង់:</td>
				   								<td><input id="credit_vendor" name="credit_vendor"  data-bind="value: vendor_id"  placeholder="(--- ជ្រើសយកមួយ ---)" required data-required-msg="ត្រូវការ អ្នកផ្គត់ផ្គង់" >
												<br>
													<span class="k-invalid-msg" data-for="credit_vendor"></span>	
				   								</td>
				   								<td></td>
				   								<td><h2>Credit</h2></td>
				   							</tr>														
				   							<tr valign="top">
				   								<td></td>
				   								<td></td>												
				   								<td>ថ្ងៃចេញវិក្កយប័ត្រ:</td>
				   								<td>
				   									<input id="credit_bill_date" name="credit_bill_date" data-bind="value: bill_date" required data-required-msg="ត្រូវការ ថ្ងៃចេញវិក្កយប័ត្រ"/>	
													<br>
													<span class="k-invalid-msg" data-for="credit_bill_date"></span>	
				   								</td>
				   							</tr>					
				   							<tr valign="top">
				   								<td></td>	
				   								<td></td>			
				   								<td>លេខ ref.</td>
				   								<td>
				   									<input type="text" id="credit_ref_no" name="credit_ref_no" data-bind="value: ref_no" class="k-textbox" required data-required-msg="ត្រូវការ លេខ ref."/>
													<br>
													<span class="k-invalid-msg" data-for="credit_ref_no"></span>	
				   								</td>
				   							</tr>
				   							<tr valign="top">
				   								<td></td>
				   								<td></td>
				   								<td>ចំនួនត្រូវបង់:</td>
				   								<td>
				   									<input type="number"  min="0" value="0" id="credit_amount" name="credit_amount"  data-bind="value: total" required data-required-msg="ត្រូវការ ចំនួនត្រូវបង់" disabled/>
													<br>
													<span class="k-invalid-msg" data-for="credit_amount"></span>
				   								</td>
				   							</tr>
				   						</table>  														  	  										 	
				  					</div>
				   				</td>
								<td valign="top">
									<div class="alert alert-error">
										<table>
											<tr>
												<td valign="top">គណនីជំពាក់:</td>
												<td >
													<input id="credit_account"  name="credit_account" data-bind="value: account_id" placeholder="(--- ជ្រើសយកមួយ ---)" required data-required-msg="ត្រូវការ គណនីជំពាក់"/>
													<br>   
													<span class="k-invalid-msg" data-for="credit_account"></span>		  
												</td>	
											</tr>
										</table>
									</div>
								</td>
				   			</tr>
				      	</table>
				        <!--End Receipt Info -->
			  		<div id="credit_grid"></div>
					<br>
					<div class="credit_status" align="center"></div>
					
					<div align="right">
				  	  	<button id="credit_add" class="btn btn-primary" type="button" ><i class="icon-hdd icon-white"></i> កត់ត្រា</button><span> </span><button id="credit_clear" class="btn " type="submit" ><i class="icon-remove-circle icon-black"> </i> មោឃភាព</button>
			   	 	</div>
				</div> 
			</div>	 
			<!--End Credit Content -->
			
			<!--Item List Content -->
			<div id="item_receipt_list" style="display: none;">
				<div id="item_receipt_list_grid"></div>			
			</div>
			<!--End Item List Content -->
			
	</div>
	
	<!-- Item Receipt Update -->
			
	<div id="UpdateModal" class="modal hide fade" style="width: 80%; margin-left:-40%">
		<div  class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		 	<h2>Update Cash Receipt</h2>
		</div>
		<div id="update_modal_content" class="modal-body">		   	 	
		    <!-- Update Cash Item Receipt-->
			<div id="update_cash" style="display: none; width: 100%;">
				<div id="update_cash_validate">
 					<!--<div class="current-state">
 			     		   <h4>Current view model state:</h4>
 			     	 	  <pre>
 			   	 	 	  {
								id: <span data-bind="text: id"></span>,
 			       	 			vendor: <span data-bind="text: vendor"></span>,
 			      	  	        bill_date: <span data-bind="text: bill_date"></span>,
 			       	 		    ref_no: <span data-bind="text: ref_no"></span>,
 			       	 			discount_date: <span data-bind="text: discount_date"></span>,
 			       	 			total: <span data-bind="text: total"></span>,
 			       	 			due_date: <span data-bind="text: due_date"></span>,
 			       	 			term: <span data-bind="text: term"></span>,
								account_id: <span data-bind="text: account_id"></span>
				 			      			 	
 			   	 			}
 			        		</pre>
 		    			</div>-->			
		    			<table>
							<tr>
								<td></td>
								<td>
									<!--Receipt Info -->
									<div class="well well-small">
										<table>
											<tr valign="top">
												<td width="80">អ្នកផ្គត់ផ្គង់:</td>
												<td><input id="update_cash_vendor" name="update_cash_vendor" data-bind="value: vendor_id"  placeholder="(--- ជ្រើសយកមួយ ---)" required data-required-msg="ត្រូវការ អ្នកផ្គត់ផ្គង់">
													<br>
													<span class="k-invalid-msg" data-for="update_cash_vendor"></span>
												</td>
												<td></td>
												<td><h2>Cash</h2></td>
											</tr>														
											<tr valign="top">
												<td></td>
												<td><label id="paid" style="font-size: 6em; color: white; display: none;" >Paid</label></td>												
												<td>ថ្ងៃចេញវិក្កយប័ត្រ:</td>
												<td>
													<input type="text" id="update_cash_bill_date" name="update_cash_bill_date" data-bind="value: bill_date" required data-required-msg="ត្រូវការ ថ្ងៃចេញវិក្កយប័ត្រ"/>
													<br>
													<span class="k-invalid-msg" data-for="update_cash_bill_date"></span>
												</td>
											</tr>					
											<tr valign="top" >
												<td></td>	
												<td></td>			
												<td>លេខ ref.</td>
												<td>
													<input type="text" id="update_cash_ref_no" name="update_cash_ref_no" data-bind="value: ref_no" class="k-textbox" required data-required-msg="ត្រូវការ លេខ ref."/>
													<br>
													<span class="k-invalid-msg" data-for="update_cash_ref_no"></span>
												</td>
											</tr>
											<tr valign="top">
												<td><span id="update_discount_date_title" style="display: none;" >ថ្ងៃបញ្ចុះតំលៃ:</span></td>
												<td>
													<span id="update_discount_date_input" style="display: none;" ><input id="update_cash_discount_date" name="update_cash_discount_date" data-bind="value: discount_date" /></span>
												</td>
												<td>ចំនួនត្រូវបង់:</td>
												<td>
													<input type="number"  min="0" value="0" id="update_cash_amount_due" name="update_cash_amount_due" data-bind="value: total" required data-required-msg="ត្រូវការ ចំនួនត្រូវបង់" disabled/>
													<br>
													<span class="k-invalid-msg" data-for="update_cash_amount_due"></span>
												</td>
											</tr>
											<tr valign="top">
												<td>ទម្រង់បង់ប្រាក់:</td>
												<td>
													<input id="update_payment_term_id" name="update_payment_term_id" data-bind="value: payment_term_id" required data-required-msg="ត្រូវការ ទម្រង់បង់ប្រាក់"/>	
													<br>
													<span class="k-invalid-msg" data-for="update_payment_term_id"></span>
												</td>
												<td>ថ្ងៃត្រូវបង់:</td>
												<td>
													<input id="update_cash_due_date" name="update_cash_due_date" data-bind="value: due_date" />
												</td>
											</tr>
																													
										</table>
									</div>
								</td>
								<td valign="top">
									<div class="alert alert-error">
										<table>
											<tr>
												<td valign="top">គណនីសាច់ប្រាក់:</td>
												<td >
													<input id="update_cash_account" name="update_cash_account" data-bind="value: account_id"  placeholder="(--- ជ្រើសយកមួយ ---)" required data-required-msg="ត្រូវការ គណនីបង់ប្រាក់"/>
													<br>   
													<span class="k-invalid-msg" data-for="update_cash_account"></span>		  
												</td>	
											</tr>
										</table>
									</div>
								</td>
							</tr>
		   	 			</table>
								 
						<!--End Receipt Info -->
						
						<div id="update_cash_grid"></div>
						<br>
						<div class="update_cash_status" align="center"></div>		
						<div align="right">
							<button id="update_cash_btn" class="btn btn-primary" type="button" ><i class="icon-edit icon-white"></i> កែប្រែ</button><span> </span><button id="cash_close" class="btn " type="submit" ><i class="icon-remove-circle icon-black"> </i> បិទ</button>
						</div>			 
					</div>
				</div>
			</div> 			 		
			<!-- End Update Cash Item Receipt -->
			<!-- Update Credit Item Receipt -->
			<div id="update_credit" style="display: none; width: 98%; margin:0 0 1% 1%">
				<div id="update_credit_validate">
 					<!--<div class="current-state">
 			       	 		<h4>Current view model state:</h4>
 			       	 		<pre>
 			   	 			{
								id: <span data-bind="text: id"></span>,
 			   		 			vendor: <span data-bind="text: vendor"></span>,
 			    				bill_date: <span data-bind="text: bill_date"></span>,
 			    				ref_no: <span data-bind="text: ref_no"></span>,
 			    				discount_date: <span data-bind="text: discount_date"></span>,
 			    				total: <span data-bind="text: total"></span>,
 			     	   			due_date: <span data-bind="text: due_date"></span>,
 			     				term: <span data-bind="text: term"></span>,
								account_id: <span data-bind="text: account_id"></span>
				 			      			 	
 			  	  			 }
 			       	 	   </pre>
 		    			 </div>-->			
						<!--Receipt Info -->
   	 	 		  	   <table>
   	   				   	   <tr>
   						  	  	<td></td>
   						   	 	<td>
   							 	   <div class="well well-small">
   								 	 <table>
   										  <tr valign="top">
   											   	<td width="80">អ្នកផ្គត់ផ្គង់:</td>
   										 	  	<td><input id="update_credit_vendor" name="update_credit_vendor"  data-bind="value: vendor_id"  placeholder="(--- ជ្រើសយកមួយ ---)" required data-required-msg="ត្រូវការ អ្នកផ្គត់ផ្គង់" >
												    <br>
											  	 	<span class="k-invalid-msg" data-for="update_credit_vendor"></span>	
   												</td>
   												<td></td>
   												<td><h2>Credit</h2></td>
   											</tr>														
   											<tr valign="top">
   												<td></td>
   												<td></td>												
   												<td>ថ្ងៃចេញវិក្កយប័ត្រ:</td>
   												<td>
   													<input id="update_credit_bill_date" name="update_credit_bill_date" data-bind="value: bill_date" required data-required-msg="ត្រូវការ ថ្ងៃចេញវិក្កយប័ត្រ"/>	
													<br>
													<span class="k-invalid-msg" data-for="update_credit_bill_date"></span>	
   												</td>
   											</tr>					
   											<tr valign="top">
   												<td></td>	
   												<td></td>			
   												<td>លេខ ref.</td>
   												<td>
   													<input type="text" id="update_credit_ref_no" name="update_credit_ref_no" data-bind="value: ref_no" class="k-textbox" required data-required-msg="ត្រូវការ លេខ ref."/>
													<br>
													<span class="k-invalid-msg" data-for="update_credit_ref_no"></span>	
   												</td>
   											</tr>
   											<tr valign="top">
   												<td></td>
   												<td></td>
   												<td>ចំនួនត្រូវបង់:</td>
   												<td>
   													<input type="number"  min="0" value="0" id="update_credit_amount" name="update_credit_amount"  data-bind="value: total" required data-required-msg="ត្រូវការ ចំនួនត្រូវបង់" disabled/>
													<br>
													<span class="k-invalid-msg" data-for="update_credit_amount"></span>
   												</td>
   											</tr>
   									   </table> 														  	  										
  									</div>
   								</td>
								<td valign="top">
									<div class="alert alert-error">
										<table>
											<tr>
												<td valign="top">គណនីជំពាក់:</td>
												<td >
													<input id="update_credit_account"  name="update_credit_account" data-bind="value: account_id" placeholder="(--- ជ្រើសយកមួយ ---)" required data-required-msg="ត្រូវការ គណនីជំពាក់"/>
													<br>   
													<span class="k-invalid-msg" data-for="update_credit_account"></span>		  
												</td>	
											</tr>
										</table>
									</div>
						 	    </td>
   					  		 </tr> 
      	  	        	</table>
       
						<!--End Receipt Info -->
   	 					<div id="update_credit_grid" width="80%"></div>
  	  					<br>
						<div class="update_credit_status" align="center"></div>
					
  	    				<div align="right">
   							<button id="update_credit_btn" class="btn btn-primary" type="button" ><i class="icon-edit icon-white"></i> កែប្រែ</button><span> </span><button id="credit_close" class="btn " type="submit" ><i class="icon-remove-circle icon-black"> </i> បិទ</button>
   	 					</div>
					</div>
				<!-- End Update Credit Item Receipt -->
			</div> 
			<!-- End Item Receipt Update -->
		</div>
			
	</div>
</div>

<br>
<!-- Success Modal Start -->
<div id="successModal" class="modal hide fade">
  	<div class="modal-header">
   	 	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    	<h3>Message</h3>
  	</div>
  	<div class="modal-body">
   	 	<p>Receipt has been created successfully.</p>
  	</div>
  	<div class="modal-footer">
  	  	<a href="#" id="close" class="btn">Close</a>
  	</div>
</div>
 <!-- Success Modal End -->

  <style>

    #update_modal_content .modal-body
    {
       max-height: 70%;
       overflow-y: scroll;
    }
  </style>
  
<script>

	//Get empty text for null and undefined
	function GetText(original_text){
 	   	if(original_text == null || original_text == undefined || original_text == '01/01/1970'){
	 		 return "";
	  	}
 	 	else{
			 return original_text;
 		}
	}

	//Get Today
	function GetToday(){
		//Get Today Date
		var currentTime = new Date();
 	    var day = currentTime.getDate();
 	    var month = currentTime.getMonth();
		var year = currentTime.getFullYear();

  	  	if (day < 10){
  		  	day = "0" + day;
  	  	}

  	  	if (month < 10){
  		  	month = "0" + month;
  	  	}

  	  	var today_date = year + "-" + month + "-" + day;
	  
  	  	return today_date;
	}

	//Add Days to date
	function AddDays(date, number_day){
	
		date.setDate(date.getDate() + number_day);
				
		var day = date.getDate();
		var month = date.getMonth() + 1;
		var year = date.getFullYear();

   	 	if (day < 10){
   		 	day = "0" + day;
    	}

   	 	if (month < 10){
  			month = "0" + month;
    	} 
	
		return year + "-" + month + "-" + day;
	}	
    
	//Calculate
	function calculate_amount(cost, quantity)
	{
		var amount = cost * quantity
					
		return amount
	}

	//Get Discount Date
	function GetDiscountDate(date, number_day){
	
		//Add days to get discount date	
		var discount_date = AddDays(date, number_day);
		
		return discount_date;
		
	}

	//Get Due Date
	function GetDueDate(date, number_day){
		//Add days to get due date
		var due_date = AddDays(date, number_day);
		
		return due_date;		
		
	}
  
	//Close successfull message
 	$("#close").click(function() {
		 $('#successModal').modal('hide');
	     
 	});
 
	//Show item receipt list Click
 	$("#show_item_receipt_list").click(function() {
	  
 		 $('#show_cash').attr("disabled", "disabled");
  		 $('#cash').hide(); 
  		 $('#credit').hide(); 
	  	 $('#item_receipt_list').show(); 
    	 $('#show_cash').button("enable"); 
   	  	 $('#show_credit').button("enable"); 
         $('#show_edit_item_receipt').button("enable"); 
		
  	});
  
	$(document).ready(function() {
	
		var baseUrl = "<?php echo base_url(); ?>";
        var receipt_id;
        var payment_term;

        //Show Cash Click
        $("#show_cash").click(function() {

        $('#show_cash').attr("disabled", "disabled");
        $('#show_credit').button("enable");
        $('#cash').show();
        $('#credit').hide();
        $('#item_receipt_list').hide();
        $('#show_edit_item_receipt').attr("disabled", "disabled");
        });

        //Show Credit Click
        $("#show_credit").click(function() {

        $('#show_cash').button("enable");
        $('#show_credit').attr("disabled", "disabled");
        $('#cash').hide();
        $('#credit').show();
        $('#item_receipt_list').hide();
        $('#show_edit_item_receipt').attr("disabled", "disabled");
        
        if (credit_item_recordDS.total() == 0){
        credit_grid.addRow();
        }

        });

        //Get Vendor DataSource
        var VendorDataSource = new kendo.data.DataSource({
        transport: {
        read: baseUrl + "api/people_api/vendor_dropdown",
        type: "GET",
        dataType: "json"
        }
        });

        //Get Payment Term DataSource
        var PaymentTermDataSource = new kendo.data.DataSource({
        transport: {
        read: baseUrl + "api/accounting_api/payment_term",
        type: "GET",
        dataType: "json"
        }
        });

        //Get Cash Account DataSource
        var CashAccountDataSource = new kendo.data.DataSource({
        transport: {
        read: baseUrl + "api/accounting_api/cash_account",
        type: "GET",
        dataType: "json"
        }
        });
        var itemDataSource = new kendo.data.DataSource({
        transport: {
        read: {
        url : baseUrl + "api/inventory_api/item",
        type: "GET",
        dataType: "json",
        data: {
        status: 'active'
        }
        }
        }
        });

        /* ------------------ Cash Start ------------------*/


        //Vendor DDl
        $("#cash_vendor").kendoComboBox({

        dataTextField: "name",
        dataValueField: "id",
        suggest: true,
        template: '<table>' +
	  			 		'<tr>' +
							'<td><span class="span3">${data.name}</span><span>${data.type}</span></td>' +
						'</tr>' +
				 	  '</table>',
		                        
			dataSource: VendorDataSource,
				 
	  	}).data("kendoComboBox").list.width(400);
	  
  	  
	 	 //Bill date for cash
	 	 $("#cash_bill_date").kendoDatePicker({
	  	
	  	  	change: function(e) {
  				var date = CashviewModel.get("bill_date");
  				date = new Date(date);
			
				if ($("#payment_term_id").data("kendoDropDownList").text() != "(--- ជ្រើសយកមួយ ---)"){
					var payment_term = PaymentTermDataSource.get($("#payment_term_id").data("kendoDropDownList").value());			
							
					// get the text of the dropdownlist.
					var discount = parseInt(payment_term.discount_percentage);
					var net_due_in = parseInt(payment_term.net_due_in);
					var discount_paid_within = parseInt(payment_term.discount_paid_within);
			
					if (discount > 0)
					{
						//Show discount date
						$("#discount_date_input").show();
						$("#discount_date_title").show();
						
						var discount_date = GetDiscountDate(date, discount_paid_within);
						CashviewModel.set("due_date", GetDueDate(date, net_due_in));	
					
						CashviewModel.set("discount_date", discount_date);
						$("#cash_discount_date").val(discount_date);
						
				
					}
					else
					{
				 	   $("#discount_date_input").hide();
				  	   $("#discount_date_title").hide();
				  	   $("#cash_discount_date").val("");
				  
			  
				   	if (net_due_in > 0)
				   	{
					   CashviewModel.set("due_date", GetDueDate(date, net_due_in));	
				  	}
			  
				 }
				
			  }
  			
   	 	    }
		
	     });    
	  	  
	  	//Due date for cash
	  	$("#cash_due_date").kendoDatePicker();
	  
	 	//Discount date for cash
 	 	$("#cash_discount_date").kendoDatePicker();
	  
	  	//amount total for cash
	  	$("#cash_amount_due").kendoNumericTextBox({
	     	 format: "c",
	 	
	  	});
	 	  
	  	//Term ddl for cash
	  	$("#payment_term_id").kendoDropDownList({
	  		optionLabel: "(--- ជ្រើសយកមួយ ---)",
			dataTextField: "term",
	    	dataValueField: "id",
			index: 0,	  	
	  		dataSource: PaymentTermDataSource,
			change:function(){
			
				var date = CashviewModel.get("bill_date");
				date = new Date(date);
			
				if ($("#payment_term_id").data("kendoDropDownList").text() != "(--- ជ្រើសយកមួយ ---)"){
					payment_term = this.dataSource.get(this.value());			
					
					// get the text of the dropdownlist.
					var discount = parseInt(payment_term.discount_percentage);
					var net_due_in = parseInt(payment_term.net_due_in);
					var discount_paid_within = parseInt(payment_term.discount_paid_within);
				
					if (discount > 0)
					{
						//Show discount date
						$("#discount_date_input").show();
						$("#discount_date_title").show();
					
						var discount_date = GetDiscountDate(date, discount_paid_within);
						CashviewModel.set("due_date", GetDueDate(date, net_due_in));	
					
						CashviewModel.set("discount_date", discount_date);
						$("#cash_discount_date").val(discount_date);
					}
					else
					{
				  	  $("#discount_date_input").hide();
				 	  $("#discount_date_title").hide();
				  	  $("#cash_discount_date").val("");
				 
				  	 if (net_due_in > 0)
				   	 {
					  	CashviewModel.set("due_date", GetDueDate(date, net_due_in));	
				   	 }
			  
				  }
				
			   }
			
		    }
				  			 
	    });
	 	  
	 	//Cash Account ddl 
	 	$("#cash_account").kendoComboBox({
			dataTextField: "name",
	   	 	dataValueField: "id",
			suggest: true,
			dataSource: CashAccountDataSource	
			 
	  	});
	  
     	//View model Cash
     	var CashviewModel = kendo.observable({
    		id					: 0,
			account_id          : "",
      receipt_type    : "Item",
			bill_type				: "Cash",
     		vendor_id  			: "",		
     		ref_no				: "",
     		payment_term_id		: 0,		
     	    total				: 0, 	  
     		bill_date			: "",
     		due_date			: "",
     		discount_date		: ""
     			
     	});  
     	kendo.bind($("#cash"), CashviewModel);
	  
	 	//Validator	 
	 	var cash_validator = $("#cash_validate").kendoValidator().data("kendoValidator"),
	 	cash_message = $(".cash_status");
	 
	 
	    //Set today for cash bill date
	  	var ctoday = GetToday();
	  	CashviewModel.set("bill_date", ctoday);
	 
  	 	 //Receipt Datasource
  	 	 var cash_item_receiptDS = new kendo.data.DataSource({
  	 		 transport: {
   	 			
  	 			 create: {
  	 				 url : baseUrl + "api/inventory_api/item_receipt",
  	 				 type: "POST",
  	 				 dataType: "json",
					 complete: function(e) {
						 //Get created item receipt id 
						 //var obj = $.parseJSON(e.responseText);
					
						 //receipt_id = obj.id;
						 //Add item record to database 
			 			 cash_item_recordDS.sync();
					
						 //Clear Input
						 Clear_Cash_Input();
					 }
	 			
  	 			 },
  	 	
  	 		 	parameterMap: function(options, operation) {
  	             	if (operation !== "read" && options.models) {
        return {models: kendo.stringify(options.models)};
        }

        return options;

        }
        },
        batch: false,
        schema: {
        model: {
        id : "id",
        fields: {
        account_id  	: {  type: "number" },
        receipt_type  : { type: "string" },
        bill_type			: {  type: "string" },
        vendor_id		: {  type: "number" },
        ref_no 			: {  type: "string" },
        payment_term_id	: {  type: "number" },
        total  			: {  type: "number" },
        bill_date  		: {  type: "date"   },
        due_date   		: {  type: "date"   },
        discount_date	: {  type: "date"   }

        }
        }
        }

        });


        //Save button click
        $("#cash_add").click(function() {
        this.preventDefault;

        if (cash_validator.validate()) {
        add_new_item_receipt_for_cash();
        $('#successModal').modal('show');

        }
        else {
        cash_message.text("Oops! There is invalid data in the form.").addClass("invalid");
        }

        });


        //Add new item receipt
        function add_new_item_receipt_for_cash() {
        cash_item_receiptDS.add({
        account_id			: CashviewModel.get("account_id"),
        receipt_type  : CashviewModel.get("receipt_type"),
        bill_type				: CashviewModel.get("bill_type"),
        vendor_id			: CashviewModel.get("vendor_id"),
        ref_no				: CashviewModel.get("ref_no"),
        payment_term_id		: CashviewModel.get("payment_term_id"),
        total				: CashviewModel.get("total"),
        bill_date			: kendo.toString(CashviewModel.get("bill_date"), "yyyy-MM-dd"),
        due_date			: kendo.toString(CashviewModel.get("due_date"), "yyyy-MM-dd"),
        discount_date		: kendo.toString(CashviewModel.get("discount_date"), "yyyy-MM-dd")

        });
        cash_item_receiptDS.sync();

        };


        //Item Record Datasource
        var cash_item_recordDS = new kendo.data.DataSource({
        transport: {

        create: {
        url : baseUrl + "api/inventory_api/item_record",
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
    		 batch: false,	                            
		 	 schema: {
				model: {
					id : "id",
					fields: {	
						item_receipt_id	: {  type: "number"},			
						item_id 		: {  type: "number", validation: { required: true }, defaultValue: 1  },	
						description    	: {  type: "string" },
						unit_number  	: {  type: "string"  },
						cost         	: {  type: "number", validation: { required: true, min: 0 }, defaultValue: 0 },
						quantity       	: {  type: "number", validation: { required: true, min: 1 }, defaultValue: 1 },
						amount			: {  type: "number"  },
						item_name    	: {  defaultValue: {id: 0, name: ""} },
						avg_cost		: {  type: "number", defaultValue: 0 }
										
							
					}
				}		 
			 }
	   
		});
	 
	 
   	 	var cash_grid =  $("#cash_grid").kendoGrid({
   	         dataSource: cash_item_recordDS,
   	         navigatable: true,
   	         height: 400,
			 autoBind: false,
   	         toolbar: ["create"],
   	         columns: [
   	                  { field: "item_name", title: "ឈ្មោះ", width: 150, editor: item_ComboBox, template: "#= item_name.name#" },
   					  { field: "description", title: "ពណ៏នា", width: 150 },
   	                  { field: "unit_number", title: "លេខសំគាល់", width: 80 },
   	                  { field: "cost", title: "តំលៃ", format: "{0:c}", width: 90 },
   					  { field: "quantity", title: "ចំនួន", width: 50 },
   					  { field: "amount", title: "តំលៃសរុប", format: "{0:c}", width: 120, 
					 	 editor: function(cont, options) {
					   			$("<span>" + options.model.amount + "</span>").appendTo(cont);
					 	 },
				  	  },
					 
   	                  { command: [{ name: "destroy", text: "លុប" }], title: "&nbsp;", width: "70px" }],
   	         editable: true,
			 save: function(data){
				 //Define item_id
				 if (data.values.item_name){
					 var item_id = data.values.item_name.id;
					 data.model.set("item_id", item_id);
					 data.model.set("description", data.values.item_name.purchase_description);
					 
				 }				 
						 
				 //Calculation
				if (data.values.cost){
					 var amount = calculate_amount(data.values.cost, data.model.quantity);
					 data.model.set("amount", amount);
				
					 //Get Total 
					 var rows = cash_item_recordDS.total();
					 var total = 0;
					 for (var i = 0; i<rows; i++){
						 var item_record = cash_item_recordDS.at(i);
						 total += item_record.amount;
						 
				
					 }
					 
					 CashviewModel.set("total", total);
					 
					
			    }
				else if (data.values.quantity){
					var amount = calculate_amount(data.model.cost, data.values.quantity);
					 data.model.set("amount", amount);
					 
					 //Get Total
					 var rows = cash_item_recordDS.total();
					 var total = 0;
					 for (var i = 0; i<rows; i++){
						 var item_record = cash_item_recordDS.at(i);
						 total += item_record.amount;
						 
					 }
					 
					 CashviewModel.set("total", total);	
				}
			 },
			 remove: function(data) {
										 
		 		CashviewModel.set("total", CashviewModel.get("total") - data.model.get("amount"));
				        
			 }
       	}).data("kendoGrid");
	 
		cash_grid.addRow();  	  
		
		
		 //Clear Input
		 function Clear_Cash_Input(){
			 
			 //Reset Cash View Model
			CashviewModel.set("id", 0);
			CashviewModel.set("account_id", "");
			CashviewModel.set("vendor_id", 0);
			CashviewModel.set("ref_no", "");
			CashviewModel.set("payment_term_id", 0);
			CashviewModel.set("total", 0);
			CashviewModel.set("bill_date", GetToday());
			CashviewModel.set("due_date", "");
			CashviewModel.set("discount_date", ""); 
     		
			//Hide discount date
		   $("#discount_date_input").hide();
		   $("#discount_date_title").hide();
			
		   //Empty Cash Grid
		   var empty_arr = [];
		   cash_item_recordDS.data(empty_arr);
		   
		   $("#cash_grid").data("kendoGrid").refresh();
		  		 
			cash_grid.addRow();  	 
		 }
	  
	 	 /* -------------------- Cash End ---------------------*/
	 
	  
	  
	  	/* --- .......................................................................................... --- */
	  
	  
	  
	  	/* --------------------- Credit Start -------------------*/
   	 
	    //Credit Account DataSource
	    var CreditAccountDataSource = new kendo.data.DataSource({
			transport: {
				read: baseUrl + "api/accounting_api/liability_account",
				type: "GET",
				dataType: "json"
			}
	    });
	  
		//Vendor CMB
   		$("#credit_vendor").kendoComboBox({	
   			dataTextField: "name",
   			dataValueField: "id",		
   			suggest: true,
   	    	template: '<table>' +
   	  			 		'<tr>' +
   							'<td><span class="span3">${data.name}</span><span>${data.type}</span></td>' +
   						'</tr>' +
   				  	  '</table>',
		                        
   			dataSource: VendorDataSource,
		 
   	  	}).data("kendoComboBox").list.width(400);
 	   
	  	//amount total for credit
	 	$("#credit_amount").kendoNumericTextBox({
	      	format: "c"
	 	});
	  
	  	//Credit Account CMB 
	 	$("#credit_account").kendoComboBox({
  	  		dataTextField: "name",
  	    	dataValueField: "id",
			suggest: true,
  	 		dataSource: CreditAccountDataSource	 	
		 
	  	});
	
	 	//Bill date for credit
	  	$("#credit_bill_date").kendoDatePicker();
	  
   		//View model Credit
   		var CreditviewModel = kendo.observable({
  			id				: 0,
			account_id      : "",
      receipt_type    : "Item",
			bill_type			: "Credit",
   			vendor_id 		: "",		
   			ref_no			: "",
   			payment_term_id	: 0,		
   	        total			: 0, 	  
   			bill_date		: "",
   			due_date		: "",
   			discount_date	: "",
   			account_id		: "" 		
   		});  
   		kendo.bind($("#credit"), CreditviewModel);
	
			
		//Validator	 
		var credit_validator = $("#credit_validate").kendoValidator().data("kendoValidator"),
		credit_message = $(".credit_status");
	  
		//Set Credit Bill Date
		CreditviewModel.set("bill_date", ctoday);
	
		
	 	//Receipt Datasource
	 	var credit_item_receiptDS = new kendo.data.DataSource({
	 	 	transport: {
 	 		
	 			create: {
	 				url : baseUrl + "api/inventory_api/item_receipt",
	 				type: "POST",
	 				dataType: "json",
					complete: function(e) {
						//Get created item receipt id 
						//var obj = $.parseJSON(e.responseText);
					
						//receipt_id = obj.id;
						//Add item record to database 
		 				credit_item_recordDS.sync();
					
						//Clear Input
						Clear_Credit_Input();
					}
	 			
	 			  },
	 			 	
	 		parameterMap: function(options, operation) {
	            	 if (operation !== "read" && options.models) {
	               	  	return {models: kendo.stringify(options.models)};
	            	 }
			
	 				 return options;

	         	}
	 		},
	    	batch: false,	                            
			schema: {
				model: {
					id : "id",
					fields: {	
						account_id  	: {  type: "number" },
            receipt_type  : { type: "string" },
						bill_type			: {  type: "string" },				
						vendor_id		: {  type: "number" },
						ref_no 			: {  type: "string" },	
						payment_term_id	: {  type: "number" },
						total  			: {  type: "number" },
						bill_date  		: {  type: "date"   },
						due_date   		: {  type: "date"   },
				    	discount_date	: {  type: "date"   }															
								
					}
				}		 
		 	}
	   
	 	});
	
	
  	 	//Item Record Datasource
   		var credit_item_recordDS = new kendo.data.DataSource({
  		 	transport: {
 			
  				 create: {
  						url : baseUrl + "api/inventory_api/item_record",
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
        batch: false,
        schema: {
        model: {
        id : "id",
        fields: {

        item_receipt_id	: {  type: "number" },
        item_id 		: {  type: "number", validation: { required: true }, defaultValue: 1  },
        description    	: {  type: "string" },
        unit_number  	: {  type: "string"  },
        cost         	: {  type: "number", validation: { required: true, min: 0 }  },
        quantity       	: {  type: "number", validation: { required: true, min: 1 }  },
        amount			: {  type: "number", validation: { required: true, min: 0 }  },
        item_name    	: {  defaultValue: {id: 0, name: ""} }


        }
        }
        }

        });

        //Save button click
        $("#credit_add").click(function() {
        this.preventDefault;

        if (credit_validator.validate()) {

        add_new_item_receipt_for_credit();
        $('#successModal').modal('show');

        } else {
        credit_message.text("Oops! There is invalid data in the form.").addClass("invalid");
        }

        });


        //Add new item receipt
        function add_new_item_receipt_for_credit() {
        credit_item_receiptDS.add({
        account_id			: CreditviewModel.get("account_id"),
        receipt_type    : CreditviewModel.get("receipt_type"),
        bill_type				: CreditviewModel.get("bill_type"),
        vendor_id			: CreditviewModel.get("vendor_id"),
        ref_no				: CreditviewModel.get("ref_no"),
        payment_term_id		: CreditviewModel.get("payment_term_id"),
        total				: CreditviewModel.get("total"),
        bill_date			: kendo.toString(CreditviewModel.get("bill_date"), "yyyy-MM-dd"),
        due_date			: kendo.toString(CreditviewModel.get("due_date"), "yyyy-MM-dd"),
        discount_date		: kendo.toString(CreditviewModel.get("discount_date"), "yyyy-MM-dd")

        });
        credit_item_receiptDS.sync();

        };


        var credit_grid = $("#credit_grid").kendoGrid({
        dataSource: credit_item_recordDS,
        autoBind: false,
        height: 400,
        navigation: true,
        toolbar: ["create"],
        columns: [
        { field: "item_name", title: "ឈ្មោះ", width: 150 , editor: item_ComboBox, template: "#= item_name.name#"},
        { field: "description", title: "ពណ៏នា", width: 150 },
        { field: "unit_number", title: "លេខសំគាល់", width: 80 },
        { field: "cost", title: "តំលៃ", format: "{0:c}", width: 90 },
        { field: "quantity", title: "ចំនួន", width: 50 },
        { field: "amount", title: "តំលៃសរុប", format: "{0:c}", width: 120,
        editor: function(cont, options) {
        $("<span>" + options.model.amount + "</span>").appendTo(cont);
			 			},
			  	   },
                   { command: [{ name: "destroy", text: "លុប" }], title: "&nbsp;", width: "70px" }],
                 editable: true,
				 save: function(data){
					 //Define item_id
					 if (data.values.item_name){
						 var item_id = data.values.item_name.id;
						 data.model.set("item_id", item_id);
						 data.model.set("description", data.values.item_name.purchase_description);
					 
					 }				 
						 
					 //Calculation
					if (data.values.cost){
						 var amount = calculate_amount(data.values.cost, data.model.quantity);
						 data.model.set("amount", amount);
				
						 //Get Total 
						 var rows = credit_item_recordDS.total();
						 var total = 0;
						 for (var i = 0; i<rows; i++){
							 var item_record = credit_item_recordDS.at(i);
							 total += item_record.amount;
						 
						 }
					 
						 CreditviewModel.set("total", total);	
				    }
					else if (data.values.quantity){
						var amount = calculate_amount(data.model.cost, data.values.quantity);
						 data.model.set("amount", amount);
					 
						 //Get Total
						 var rows = credit_item_recordDS.total();
						 var total = 0;
						 for (var i = 0; i<rows; i++){
							 var item_record = credit_item_recordDS.at(i);
							 total += item_record.amount;
						 
						 }
					 
						 CreditviewModel.set("total", total);	
					}
				 }
    	}).data("kendoGrid");
  	 	     	
					 
   		 //Clear Input
   		 function Clear_Credit_Input(){
			 
   			 //Reset Credit View Model
   			CreditviewModel.set("id", 0);
   			CreditviewModel.set("account_id", "");
   			CreditviewModel.set("vendor_id", 0);
   			CreditviewModel.set("ref_no", "");
   			CreditviewModel.set("payment_term_id", 0);
   			CreditviewModel.set("total", 0);
   			CreditviewModel.set("bill_date", GetToday());
   			CreditviewModel.set("due_date", "");
   			CreditviewModel.set("discount_date", ""); 
     		
   					
   		   //Empty Credit Grid
   		   var empty_arr = [];
   		   credit_item_recordDS.data(empty_arr);
		   
   		   $("#credit_grid").data("kendoGrid").refresh();
		  		 
		   credit_grid.addRow();
   		 }
	
	 	
		/* -------------------- Credit End --------------------- */
	 
	 
	 	/* -------------------- Update Cash Item Receipt Start ----------------------*/
 		
		//Update Cash Vendor CMB
		$("#update_cash_vendor").kendoComboBox({	
			dataTextField: "name",
			dataValueField: "id",		
			suggest: true,
   		 	template: '<table>' +
  			 			'<tr>' +
							'<td><span class="span3">${data.name}</span><span>${data.type}</span></td>' +
						'</tr>' +
			  		  '</table>',
		                        
			dataSource: VendorDataSource,
		 
  	  	}).data("kendoComboBox").list.width(400);
		
  	 	//Update Bill date for cash
  	    $("#update_cash_bill_date").kendoDatePicker({
	  	
  	  	  		change: function(e) {
    				var date = UpdateCashviewModel.get("bill_date");
    				date = new Date(date);
			
  					if ($("#update_payment_term_id").data("kendoDropDownList").text() != "(--- ជ្រើសយកមួយ ---)"){
						var payment_term = PaymentTermDataSource.get($("#update_payment_term_id").data("kendoDropDownList").value());	
						
						
  						// get the text of the dropdownlist.
  						var discount = parseInt(payment_term.discount_percentage);
  						var net_due_in = parseInt(payment_term.net_due_in);
  						var discount_paid_within = parseInt(payment_term.discount_paid_within);
			
  						if (discount > 0)
  						{
  							//Show discount date
  							$("#update_discount_date_input").show();
  							$("#update_discount_date_title").show();
  							
	  						var discount_date = GetDiscountDate(date, discount_paid_within);
	  						UpdateCashviewModel.set("due_date", GetDueDate(date, net_due_in));	
					
	  						UpdateCashviewModel.set("discount_date", discount_date);
	  						$("#update_cash_discount_date").val(discount_date);
  							
				
  						}
  						else
  						{
  				  		  	$("#update_discount_date_input").hide();
  				   		 	$("#update_discount_date_title").hide();
  				   		 	$("#update_cash_discount_date").val("");
				  			  
  				   			if (net_due_in > 0)
  				   	 		{
  					 	   	 	UpdateCashviewModel.set("due_date", GetDueDate(date, net_due_in));	
  				  	  		}
			  
  						}
				
  				 	}
  			
     	 	 	}
		
  	  	});  
		
  	 	//Update due date for cash
  	 	$("#update_cash_due_date").kendoDatePicker();
	  
  	  	//Update discount date for cash
   	  	$("#update_cash_discount_date").kendoDatePicker();
	  
  	  	//Update amount total for cash
  	  	$("#update_cash_amount_due").kendoNumericTextBox({
  	      	format: "c",
	 	
  	  	}); 
		
  	    //Update Term ddl for cash
  		$("#update_payment_term_id").kendoDropDownList({
  	  		optionLabel: "(--- ជ្រើសយកមួយ ---)",
  			dataTextField: "term",
  	    	dataValueField: "id",
  			index: 0,	  	
  	  		dataSource: PaymentTermDataSource,
  			change:function(){
			
  				var date = UpdateCashviewModel.get("bill_date");
  				date = new Date(date);
			
  				if ($("#update_payment_term_id").data("kendoDropDownList").text() != "(--- ជ្រើសយកមួយ ---)"){
  					payment_term = this.dataSource.get(this.value());			
			
  					// get the text of the dropdownlist.
  					var discount = parseInt(payment_term.discount_percentage);
  					var net_due_in = parseInt(payment_term.net_due_in);
  					var discount_paid_within = parseInt(payment_term.discount_paid_within);
			
  					if (discount > 0)
  					{
  						//Show discount date
  						$("#update_discount_date_input").show();
  						$("#update_discount_date_title").show();
					
  						var discount_date = GetDiscountDate(date, discount_paid_within);
  						UpdateCashviewModel.set("due_date", GetDueDate(date, net_due_in));	
					
  						UpdateCashviewModel.set("discount_date", discount_date);
  						$("#update_cash_discount_date").val(discount_date);
					
				
  					}
  					else
  					{
  				  	  	$("#update_discount_date_input").hide();
  				  	  	$("#update_discount_date_title").hide();
  				 	   	$("#update_cash_discount_date").val("");
				 
  				 	   	if (net_due_in > 0)
  				  	  	{
  							UpdateCashviewModel.set("due_date", GetDueDate(date, net_due_in));	
  				   	 	}
			  
  					}
				
  				}
			
  			}
				  			 
  	  	});
	 	   
  		//Update Cash Account Cmb 
  	 	$("#update_cash_account").kendoComboBox({
  			dataTextField: "name",
  	   	 	dataValueField: "id",
  			suggest: true,
  			dataSource: CashAccountDataSource	
				 
  	 	});	  
	  
    	//Update Cash View model 
    	var UpdateCashviewModel = kendo.observable({
   			id					: 0,
  			account_id          : "",
        receipt_type  : "Item",
  			bill_type				: "Cash",
    		vendor_id  			: "",		
    		ref_no				: "",
    		payment_term_id		: 0,		
    	    total				: 0, 	  
    		bill_date			: "",
    		due_date			: "",
    		discount_date		: ""
     			
    	});  
    	kendo.bind($("#update_cash"), UpdateCashviewModel);
	  
   		//Cash Validator	 
   		var update_cash_validator = $("#update_cash_validate").kendoValidator().data("kendoValidator"),
   	 	update_cash_message = $(".update_cash_status");
		
   		//Update Cash Item Record Datasource
    	var update_cash_item_recordDS = new kendo.data.DataSource({
   		 	 transport: {
 			
   			 		read: {
   				 			url : baseUrl + "api/inventory_api/item_record",
   							type: "GET",
   				 	   	 	dataType: "json"
 							
   		     		}, 
   			 		update: {
   				 			url : baseUrl + "api/inventory_api/item_record",
   							type: "PUT",
   				 	   	 	dataType: "json"
 							
   		     		}, 
   			 		destroy: {
   				 			url : baseUrl + "api/inventory_api/item_record",
   							type: "DELETE",
   				 	   	 	dataType: "json"
 							
   		     		}, 
 			 			
   			 	    parameterMap: function(options, operation) {
         			   		if (operation !== "read" && options.models) {
          			  				return {models: kendo.stringify(options.models)};
        			   		}
   				   		 	if (operation === "read"){
   					  		  		return {item_receipt_id : UpdateCashviewModel.get("id")};
   				   			}
							return options;			
				  
        			}
   		 	 },
      	 	 batch: false,	                            
   	 		 schema: {
   				 	model: {
   						id : "id",
   						fields: {	
   							item_receipt_id	: {  type: "number"},			
   							item_id 		: {  type: "number", validation: { required: true }, defaultValue: 1  },	
   							description    	: {  type: "string" },
   							unit_number  	: {  type: "string"  },
   							cost         	: {  type: "number", validation: { required: true, min: 0 }, defaultValue: 0 },
   							quantity       	: {  type: "number", validation: { required: true, min: 1 }, defaultValue: 1 },
   							amount			: {  type: "number"  },
   							item_name    	: {  defaultValue: {id: 0, name: ""} },
   							avg_cost		: {  type: "number", defaultValue: 0 }
										
							
   						}
   					}		 
   			 }
	   
   		});
		
		//Update Cash Grid
     	var update_cash_grid =  $("#update_cash_grid").kendoGrid({
     	         dataSource: update_cash_item_recordDS,
     	         navigatable: true,  	         
   				 autoBind: false,
     	         toolbar: ["create"],
     	         columns: [
     	                  { field: "item_name", title: "ឈ្មោះ", width: 150, editor: item_ComboBox, template: "#= item_name.name#" },
     					  { field: "description", title: "ពណ៏នា", width: 150 },
     	                  { field: "unit_number", title: "លេខសំគាល់", width: 80 },
     	                  { field: "cost", title: "តំលៃ", format: "{0:c}", width: 90 },
     					  { field: "quantity", title: "ចំនួន", width: 50 },
     					  { field: "amount", title: "តំលៃសរុប", format: "{0:c}", width: 120, 
   				 			 	editor: function(cont, options) {
   				   					$("<span>" + options.model.amount + "</span>").appendTo(cont);
   				 				},
   			  	 	  	  },
					 
     	                  { command: [{ name: "destroy", text: "លុប" }], title: "&nbsp;", width: "70px" }],
     	         editable: true,
   			 	 save: function(data){
   					 //Define item_id
   					 if (data.values.item_name){
   						 var item_id = data.values.item_name.id;
   					 	 data.model.set("item_id", item_id);
   					 	 data.model.set("description", data.values.item_name.purchase_description);
					 
   				 	 }				 
						 
   					 //Calculation
   					 if (data.values.cost){
   						 var amount = calculate_amount(data.values.cost, data.model.quantity);
   					 	 data.model.set("amount", amount);
				
   						 //Get Total 
   				 		 var rows = update_cash_item_recordDS.total();
   				 		 var total = 0;
   				  	   	 for (var i = 0; i<rows; i++){
   							 var item_record = update_cash_item_recordDS.at(i);
   							 total += item_record.amount;
						 
				
   				 		 }
					 
   				 		UpdateCashviewModel.set("total", total);
					 					
   		    		 }
   					 else if (data.values.quantity){
   						 var amount = calculate_amount(data.model.cost, data.values.quantity);
   						 data.model.set("amount", amount);
					 
   						 //Get Total
   						 var rows = update_cash_item_recordDS.total();
   						 var total = 0;
   						 for (var i = 0; i<rows; i++){
   							 var item_record = update_cash_item_recordDS.at(i);
   					 		 total += item_record.amount;
						 
   				 		 }
					 
   						 UpdateCashviewModel.set("total", total);	
   					 }
   		 		 },
				 remove: function(data) {
										 
			 		UpdateCashviewModel.set("total", UpdateCashviewModel.get("total") - data.model.get("amount"));
				        
				 }
        }).data("kendoGrid");
		 
  	    //Update Cash button click
     	$("#update_cash_btn").click(function() {
  	     	this.preventDefault;		 
			
  		 	if (update_cash_validator.validate()) {			 
  				 edit_cash_item_receipt();
				 
			 	 update_cash_item_recordDS.sync();
				 
  			 	 update_cash_message.text("Your item receipt has been modified!").addClass("valid");
				 
	   	   	    			 
			} else {
  			 	 update_cash_message.text("Oops! There is invalid data in the form.").addClass("invalid");
  		 	}
			
     	});
		 
		//Edit Cash item Receipt
		function edit_cash_item_receipt(){
						 
	 		var item_receipt = update_item_receiptDS.get(UpdateCashviewModel.get("id"));
			var bill_date = $("#update_cash_bill_date").val();
	
	 		item_receipt.set("account_id", UpdateCashviewModel.get("account_id"));
	 		item_receipt.set("vendor_id", UpdateCashviewModel.get("vendor_id"));
	 		item_receipt.set("ref_no", UpdateCashviewModel.get("ref_no"));
	 		item_receipt.set("payment_term_id", UpdateCashviewModel.get("payment_term_id"));
	 		item_receipt.set("total", UpdateCashviewModel.get("total"));
	 		item_receipt.set("bill_date", UpdateCashviewModel.get("bill_date"));
	 		item_receipt.set("due_date", UpdateCashviewModel.get("due_date"));
	 		item_receipt.set("discount_date",UpdateCashviewModel.get("discount_date"));
		 	
	 		update_item_receiptDS.sync(); 	
						
		}  
		
		//Close Cash Modal  	
		$("#cash_close").click(function (){
   	   	   $("#UpdateModal").modal('hide');
		});
		
		
	 	/* -------------------- Update Cash Item Receipt End ------------------------*/
	 	
		/* -------------------- Update Credit Item Receipt Start --------------------*/
    	 
		 //Update Credit Vendor CMB
      	 $("#update_credit_vendor").kendoComboBox({	
       		dataTextField: "name",
       		dataValueField: "id",		
       		suggest: true,
       	    template: '<table>' +
       	  			 	'<tr>' +
       						'<td><span class="span3">${data.name}</span><span>${data.type}</span></td>' +
       					'</tr>' +
       				  '</table>',
		                        
       		dataSource: VendorDataSource,
		 
         }).data("kendoComboBox").list.width(400);
		 
	     //Update amount total for credit
	     $("#update_credit_amount").kendoNumericTextBox({
	         format: "c"
	     });
	  
	     //Update Credit Account CMB 
	     $("#update_credit_account").kendoComboBox({
	   	  	dataTextField: "name",
	   	    dataValueField: "id",
	   	 	suggest: true,
	   	 	dataSource: CreditAccountDataSource	 	
		 
	     });
		 
	     //Update Bill date for credit
	     $("#update_credit_bill_date").kendoDatePicker();
  
	     //Update Credit View model 
	     var UpdateCreditviewModel = kendo.observable({
	    		id					: 0,
	   			account_id          : "",
          receipt_type  : "Item",
	   			bill_type				: "Credit",
	     		vendor_id  			: "",		
	     		ref_no				: "",
	     		payment_term_id		: 0,		
	     	    total				: 0, 	  
	     		bill_date			: "",
	     		due_date			: "",
	     		discount_date		: ""
     			
	     });  
	     kendo.bind($("#update_credit"), UpdateCreditviewModel);
	
	     //Credit Validator	 
	     var update_credit_validator = $("#update_credit_validate").kendoValidator().data("kendoValidator"),
	     update_credit_message = $(".update_credit_status");
		 
		 
		 //Update Credit Item Record Datasource
		 var update_credit_item_recordDS = new kendo.data.DataSource({
			 transport: {
 			
				 read: {
					 url : baseUrl + "api/inventory_api/item_record",
					 type: "GET",
					 dataType: "json"
 							
			     }, 
 			 	 Update: {
 			 	 	 url : baseUrl + "api/inventory_api/item_record",
					 type: "PUT",
					 dataType: "json"
					 
 			 	 },	
			 	 destroy: {
				 	 url : baseUrl + "api/inventory_api/item_record",
					 type: "DELETE",
				 	 dataType: "json"
 							
		     	 }, 
 			 		
				 parameterMap: function(options, operation) {
		     			if (operation !== "read" && options.models) {
						  
		      			  	return {models: kendo.stringify(options.models)};
		    			}
					    if (operation === "read"){
						   return {item_receipt_id : UpdateCreditviewModel.get("id")};
					    }	
						return options;		
				  
		    	 }
			 },
		  	 batch: false,	                            
		 	 schema: {
					model: {
						id : "id",
						fields: {	
							item_receipt_id	: {  type: "number"},			
							item_id 		: {  type: "number", validation: { required: true }, defaultValue: 1  },	
							description    	: {  type: "string" },
							unit_number  	: {  type: "string"  },
							cost         	: {  type: "number", validation: { required: true, min: 0 }, defaultValue: 0 },
							quantity       	: {  type: "number", validation: { required: true, min: 1 }, defaultValue: 1 },
							amount			: {  type: "number"  },
							item_name    	: {  defaultValue: {id: 0, name: ""} },
							avg_cost		: {  type: "number", defaultValue: 0 }
										
							
						}
					}		 
			 }
	   
		 });
		 
		 //Update Credit Grid
   	  	 var update_credit_grid = $("#update_credit_grid").kendoGrid({
             dataSource: update_credit_item_recordDS,
             autoBind: false,	  	
   	  	  	 navigation: true,		  
             toolbar: ["create"],
             columns: [
                    	{ field: "item_name.name", title: "ឈ្មោះ", width: 150 , editor: item_ComboBox, template: "#= item_name.name#"},
    				 	{ field: "description", title: "ពណ៏នា", width: 150 },
                  	  	{ field: "unit_number", title: "លេខសំគាល់", width: 80 },
                  	  	{ field: "cost", title: "តំលៃ", format: "{0:c}", width: 90 },
    					{ field: "quantity", title: "ចំនួន", width: 50 },
    					{ field: "amount", title: "តំលៃសរុប", format: "{0:c}", width: 120,
   		 		 			editor: function(cont, options) {
   		   						$("<span>" + options.model.amount + "</span>").appendTo(cont);
   		 					},
   		  	 	   	 	},
                    	{ command: [{ name: "destroy", text: "លុប" }], title: "&nbsp;", width: "70px" }],
             editable: true,
   			 save: function(data){
   					 //Define item_id
   					 if (data.values.item_name.name){
   						 var item_id = data.values.item_name.id;
   						 data.model.set("item_id", item_id);
   						 data.model.set("description", data.values.item_name.purchase_description);
					 
   				 	 }				 
						 
   					 //Calculation
   					 if (data.values.cost){
   						 var amount = calculate_amount(data.values.cost, data.model.quantity);
   						 data.model.set("amount", amount);
				
   						 //Get Total 
   						 var rows = update_credit_item_recordDS.total();
   						 var total = 0;
   						 for (var i = 0; i<rows; i++){
   							 var item_record = update_credit_item_recordDS.at(i);
   							 total += item_record.amount;
						 
   						 }
					 
   					 	 UpdateCreditviewModel.set("total", total);	
   			   	 	 }
   					 else if (data.values.quantity){
   						 var amount = calculate_amount(data.model.cost, data.values.quantity);
   						 data.model.set("amount", amount);
					 
   						 //Get Total
   						 var rows = update_credit_item_recordDS.total();
   						 var total = 0;
   						 for (var i = 0; i<rows; i++){
   							 var item_record = update_credit_item_recordDS.at(i);
   							 total += item_record.amount;
						 
   					 	 }
					 
   					 	 UpdateCreditviewModel.set("total", total);	
   					 }
   			 }
      	 }).data("kendoGrid"); 
		 
	  	 //Update Credit button click
	     $("#update_credit_btn").click(function() {
	  	     this.preventDefault;		 
	  		 if (update_credit_validator.validate()) {			 
	  			
				 edit_credit_item_receipt();
				 
				 update_credit_item_recordDS.sync();
	  			
				 update_credit_message.text("Your item receipt has been modified!").addClass("valid");
			
	   	   	  				 
	  		 } else {
	  			 update_credit_message.text("Oops! There is invalid data in the form.").addClass("invalid");
	  		 }
			
	     });
		 
		 //Edit Credit item Receipt
		 function edit_credit_item_receipt(){
						 
		 	var item_receipt = update_item_receiptDS.get(UpdateCreditviewModel.get("id"));
	
		 	item_receipt.set("account_id", UpdateCreditviewModel.get("account_id"));
		 	item_receipt.set("vendor_id", UpdateCreditviewModel.get("vendor_id"));
		 	item_receipt.set("ref_no", UpdateCreditviewModel.get("ref_no"));
		 	item_receipt.set("payment_term_id", UpdateCreditviewModel.get("payment_term_id"));
		 	item_receipt.set("total", UpdateCreditviewModel.get("total"));
		 	item_receipt.set("bill_date", UpdateCreditviewModel.get("bill_date"));
		 	item_receipt.set("due_date", "");
		 	item_receipt.set("discount_date", "");
		 	
		 	update_item_receiptDS.sync(); 	
								
		 } 
		 
 		//Close Credit Modal  	
 		$("#credit_close").click(function (){
    	   	  $("#UpdateModal").modal('hide');
 		});
		
			  
		/* -------------------- Update Credit Item Receipt End ----------------------*/
		
		/* -------------------- Item Receipt List Start -------------------------- */
	 	
		 	  	  
	    //Update Receipt Datasource
	    var update_item_receiptDS = new kendo.data.DataSource({
	  		 transport: {
	 	 			read: {
	 	 				url : baseUrl + "api/inventory_api/item_receipt",
	 	 				type: "GET",
	 	 				dataType: "json"
	 	 			},		
	 	   	 		update: {
	 					url : baseUrl + "api/inventory_api/item_receipt",
	 					type: "PUT",
	 	    			dataType: "json"
  				
	 	    		},	 	
	  				destroy: {
	  					url : baseUrl + "api/inventory_api/item_receipt",
	  					type: "DELETE",
	  					dataType: "json"
	  				},			
	  				parameterMap: function(options, operation) {
	             		 if (operation !== "read" && options.models) {
                        return {models: kendo.stringify(options.models)};
                   }

                   if (operation === "read"){
                      return {receipt_type : "Item"};
                   }

                    return options;

        }
        },
        batch: false,
        schema: {
        model: {
        id : "id",

        fields: {
        account_id  	: {  type: "number" },
        receipt_type  : { type: "string" },
        bill_type			: {  type: "string" },
        vendor_id		: {  type: "number" },
        ref_no 			: {  type: "string" },
        payment_term_id	: {  type: "number" },
        total  			: {  type: "number" },
        bill_date  		: {  type: "date"   },
        due_date   		: {  type: "date"   },
        discount_date	: {  type: "date"   },
        vendor			: {  },
        payment_term	: {  },
        account_name	: {  }

        }
        }
        }

        });

        //Item Receipt List Grid
        var item_receipt_list_grid = $("#item_receipt_list_grid").kendoGrid({
        dataSource: update_item_receiptDS,
        autoBind: true,
        navigation: true,
        columnMenu: true,
        selectable: true,
        pagesize: 20,
        columns: [

        { field: "ref_no", title: "Ref No.", width: 90 },
        { field: "vendor_id", title: "Vendor", width: 190 , template: "#= vendor.company#", menu: false},
        { field: "bill_type", title: "Type", width: 70, menu: false },
        { field: "account_id", title: "Account", width: 190, template: "#= account_name.name#" },
        { field: "payment_term_id", title: "Payment Term", width: 150, template: "#= GetText(payment_term.term)#", menu: false },
        { field: "total", title: "Total", format: "{0:c}", width: 130},
        { field: "bill_date", title: "Bill Date", width: 100, template: '#= GetText(kendo.toString(bill_date,"dd/MM/yyyy")) #', menu: false},
        { field: "discount_date", title: "Discount Date", width: 120, template: '#= GetText(kendo.toString(discount_date,"dd/MM/yyyy")) #'},
        { field: "due_date", title: "Due Date", width: 100, template: '#= GetText(kendo.toString(due_date,"dd/MM/yyyy")) #'}],

        change: function(){

        var id = this.select().data().uid;
        selected_item = this.dataSource.getByUid(id);
        $("#show_edit_item_receipt").attr('disabled', false);


        if (selected_item.bill_type == "Cash"){
        //View Cash Update Modal
        $("#update_cash").show();
        $("#update_credit").hide();


        //Set Update Cash View Model
        UpdateCashviewModel.set("id", selected_item.id);
        UpdateCashviewModel.set("account_id", selected_item.account_id);
        UpdateCashviewModel.set("vendor_id", selected_item.vendor_id);
        UpdateCashviewModel.set("ref_no", selected_item.ref_no);
        UpdateCashviewModel.set("payment_term_id", selected_item.payment_term_id);
        UpdateCashviewModel.set("total", selected_item.total);
        UpdateCashviewModel.set("bill_date", selected_item.bill_date);
        UpdateCashviewModel.set("due_date", selected_item.due_date);
        UpdateCashviewModel.set("discount_date", selected_item.discount_date);

        //Show discount date
        if (selected_item.discount_date != null){
        $("#update_discount_date_input").show();
        $("#update_discount_date_title").show();
        }

        update_cash_message.text("").addClass("valid");

        update_cash_item_recordDS.read();
        update_cash_grid.refresh();
        }
        else if (selected_item.bill_type == "Credit"){
        //View Credit Update Modal
        $("#update_cash").hide();
        $("#update_credit").show();

        //Set Update Cash View Model
        UpdateCreditviewModel.set("id", selected_item.id);
        UpdateCreditviewModel.set("account_id", selected_item.account_id);
        UpdateCreditviewModel.set("vendor_id", selected_item.vendor_id);
        UpdateCreditviewModel.set("ref_no", selected_item.ref_no);
        UpdateCreditviewModel.set("payment_term_id", "");
        UpdateCreditviewModel.set("total", selected_item.total);
        UpdateCreditviewModel.set("bill_date", selected_item.bill_date);
        UpdateCreditviewModel.set("due_date", "");
        UpdateCreditviewModel.set("discount_date", "");

        update_credit_message.text("").addClass("valid");

        update_credit_item_recordDS.read();
        update_credit_grid.refresh();

        }

        },
        editable: false,

        }).data("kendoGrid");

        //Show edit item receipt Click
        $("#show_edit_item_receipt").click(function() {
        this.preventDefault;

        $("#UpdateModal").modal('show');

        });



        /* ------------------- Item Receipt List End -------------------------- */


        //Item cmb
        function item_ComboBox(container, options) {
        var baseUrl = "<?php echo base_url(); ?>";
  	 		$('<input required data-text-field="name" data-value-field="id"  data-bind="value:' + options.field + '"/>')
	        
  	        .appendTo(container)
  	        .kendoComboBox({
				 autoBind: false,
			 	 suggest: true,
  	         	 dataSource: itemDataSource,
		  
  	   		});
    	}
	
	
		
	});
</script>
