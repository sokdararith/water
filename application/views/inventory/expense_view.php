<div class="container">
	<div class="row">
		<div class="span12">
			<?php $this->load->view("vendor/sidebar"); ?>
		</div>
		<div class="span12">
			<h1>Expense</h1>
			<br>
			<div class="thumbnail">	
				<button id="show_cash" class="btn" type="button" disabled ><i class="icon-pencil"></i> Cash</button><span> </span>
				<button id="show_credit" class="btn" type="button" ><i class="icon-pencil"> </i> Credit</button>
				<button id="show_expense_list" class="btn" type="button" ><i class="icon-list"> </i> Expense List</button>
				<button id="show_expense" class="btn" type="button" disabled><i class="icon-edit"> </i> Show Expense</button>
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
												<input type="text" id="cash_ref_no" name="cash_ref_no" data-bind="value: ref_no" style="width: 160px; margin-bottom: -5xp" required data-required-msg="ត្រូវការ លេខ ref."/>
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
											<td></td>
											<td>
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
										<tr>
											<td valign="top">លេខសែក:</td>
											<td >
												<input type="text" id="check_no" name="check_no" data-bind="value: check_no" placeholder="លេខសែក" style="width: 160px; margin-bottom: -5xp">
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
				   									<input type="text" id="credit_ref_no" name="credit_ref_no" data-bind="value: ref_no" style="width: 160px; margin-bottom: -5xp" required data-required-msg="ត្រូវការ លេខ ref."/>
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
			
			<!--Expense List Content -->
			<div id="expense_list" style="display: none;">
				<div id="expense_list_grid"></div>			
			</div>
			<!--End Item List Content -->
			
	</div>
	
	<!-- Show Expense -->
			
	<div id="ShowExpenseModal" class="modal hide fade" style="width: 80%; margin-left:-40%">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		 	<h2>Expense Detail</h2>
		</div>
		<div id="show_modal_content" class="modal-body" style="max-height: 70%; overflow-y: scroll;">		   	 	
		    <!-- Cash Expense Detail-->
			<div id="cash_expense" style="display: none; width: 100%;">
				<div id="show_cash_validate">			
		    			<table>
							<tr>
								<td></td>
								<td>
									<!--Receipt Info -->
									<div class="well well-small">
										<table>
											<tr valign="top">
												<td width="80">អ្នកផ្គត់ផ្គង់:</td>
												<td><input id="show_cash_vendor" name="show_cash_vendor" data-bind="value: vendor_id"  placeholder="(--- ជ្រើសយកមួយ ---)" required data-required-msg="ត្រូវការ អ្នកផ្គត់ផ្គង់">
													<br>
													<span class="k-invalid-msg" data-for="show_cash_vendor"></span>
												</td>
												<td></td>
												<td><h2>Cash</h2></td>
											</tr>														
											<tr valign="top">
												<td></td>
												<td><label id="paid" style="font-size: 6em; color: white; display: none;" >Paid</label></td>												
												<td>ថ្ងៃចេញវិក្កយប័ត្រ:</td>
												<td>
													<input type="text" id="show_cash_bill_date" name="show_cash_bill_date" data-bind="value: bill_date" required data-required-msg="ត្រូវការ ថ្ងៃចេញវិក្កយប័ត្រ"/>
													<br>
													<span class="k-invalid-msg" data-for="show_cash_bill_date"></span>
												</td>
											</tr>					
											<tr valign="top" >
												<td></td>	
												<td></td>			
												<td>លេខ ref.</td>
												<td>
													<input type="text" id="show_cash_ref_no" name="show_cash_ref_no" data-bind="value: ref_no" class="k-textbox" required data-required-msg="ត្រូវការ លេខ ref."/>
													<br>
													<span class="k-invalid-msg" data-for="show_cash_ref_no"></span>
												</td>
											</tr>
											<tr valign="top">
												<td><span id="show_discount_date_title" style="display: none;" >ថ្ងៃបញ្ចុះតំលៃ:</span></td>
												<td>
													<span id="show_discount_date_input" style="display: none;" ><input id="show_cash_discount_date" name="show_cash_discount_date" data-bind="value: discount_date" /></span>
												</td>
												<td>ចំនួនត្រូវបង់:</td>
												<td>
													<input type="number"  min="0" value="0" id="show_cash_amount_due" name="show_cash_amount_due" data-bind="value: total" required data-required-msg="ត្រូវការ ចំនួនត្រូវបង់" disabled/>
													<br>
													<span class="k-invalid-msg" data-for="show_cash_amount_due"></span>
												</td>
											</tr>
											<tr valign="top">
												<td>ទម្រង់បង់ប្រាក់:</td>
												<td>
													<input id="show_payment_term_id" name="show_payment_term_id" data-bind="value: payment_term_id" required data-required-msg="ត្រូវការ ទម្រង់បង់ប្រាក់"/>	
													<br>
													<span class="k-invalid-msg" data-for="show_payment_term_id"></span>
												</td>
												<td>ថ្ងៃត្រូវបង់:</td>
												<td>
													<input id="show_cash_due_date" name="show_cash_due_date" data-bind="value: due_date" />
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
													<input id="show_cash_account" name="show_cash_account" data-bind="value: account_id"  placeholder="(--- ជ្រើសយកមួយ ---)" required data-required-msg="ត្រូវការ គណនីបង់ប្រាក់"/>
													<br>   
													<span class="k-invalid-msg" data-for="show_cash_account"></span>		  
												</td>	
											</tr>
										</table>
									</div>
								</td>
							</tr>
		   	 			</table>
								 
						<!--End Receipt Info -->
						
						<div id="show_cash_grid"></div>
						<br>
						<div class="show_cash_status" align="center"></div>		
						<div align="right">
							<button id="show_cash_btn" class="btn btn-primary" type="button" ><i class="icon-edit icon-white"></i> កែប្រែ</button><span> </span>
							<button id="cash_close" class="btn " type="submit" ><i class="icon-remove-circle icon-black"> </i> បិទ</button>
						</div>			 
					</div>
				</div>
			</div> 			 		
			<!-- End Cash Expense Detail -->
			<!-- Credit Expense Detail -->
			<div id="credit_expense" style="display: none; width: 98%; margin:0 0 1% 1%">
				<div id="show_credit_validate">
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
   										 	  	<td><input id="show_credit_vendor" name="show_credit_vendor"  data-bind="value: vendor_id"  placeholder="(--- ជ្រើសយកមួយ ---)" required data-required-msg="ត្រូវការ អ្នកផ្គត់ផ្គង់" >
												    <br>
											  	 	<span class="k-invalid-msg" data-for="show_credit_vendor"></span>	
   												</td>
   												<td></td>
   												<td><h2>Credit</h2></td>
   											</tr>														
   											<tr valign="top">
   												<td></td>
   												<td></td>												
   												<td>ថ្ងៃចេញវិក្កយប័ត្រ:</td>
   												<td>
   													<input id="show_credit_bill_date" name="show_credit_bill_date" data-bind="value: bill_date" required data-required-msg="ត្រូវការ ថ្ងៃចេញវិក្កយប័ត្រ"/>	
													<br>
													<span class="k-invalid-msg" data-for="show_credit_bill_date"></span>	
   												</td>
   											</tr>					
   											<tr valign="top">
   												<td></td>	
   												<td></td>			
   												<td>លេខ ref.</td>
   												<td>
   													<input type="text" id="show_credit_ref_no" name="show_credit_ref_no" data-bind="value: ref_no" class="k-textbox" required data-required-msg="ត្រូវការ លេខ ref."/>
													<br>
													<span class="k-invalid-msg" data-for="show_credit_ref_no"></span>	
   												</td>
   											</tr>
   											<tr valign="top">
   												<td></td>
   												<td></td>
   												<td>ចំនួនត្រូវបង់:</td>
   												<td>
   													<input type="number"  min="0" value="0" id="show_credit_amount" name="show_credit_amount"  data-bind="value: total" required data-required-msg="ត្រូវការ ចំនួនត្រូវបង់" disabled/>
													<br>
													<span class="k-invalid-msg" data-for="show_credit_amount"></span>
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
													<input id="show_credit_account"  name="show_credit_account" data-bind="value: account_id" placeholder="(--- ជ្រើសយកមួយ ---)" required data-required-msg="ត្រូវការ គណនីជំពាក់"/>
													<br>   
													<span class="k-invalid-msg" data-for="show_credit_account"></span>		  
												</td>	
											</tr>
										</table>
									</div>
						 	    </td>
   					  		 </tr> 
      	  	        	</table>
       
						<!--End Receipt Info -->
   	 					<div id="show_credit_grid" width="80%"></div>
  	  					<br>
						<div class="show_credit_status" align="center"></div>
					
  	    				<div align="right">
   							<button id="show_credit_btn" class="btn btn-primary" type="button" ><i class="icon-edit icon-white"></i> កែប្រែ</button><span> </span><button id="credit_close" class="btn " type="submit" ><i class="icon-remove-circle icon-black"> </i> បិទ</button>
   	 					</div>
					</div>
				<!-- End Credit Expense Detail -->
			</div> 
			<!-- End Credit Expense Detail -->
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
   	 	<p>Expense has been created successfully.</p>
  	</div>
  	<div class="modal-footer">
  	  	<a href="#" id="close" class="btn">Close</a>
  	</div>
</div>
 <!-- Success Modal End -->

  <style>

    #show_modal_content .modal-body
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
 
	//Show Expense list Click
 	$("#show_expense_list").click(function() {
	  
 		 $('#show_cash').attr("disabled", "disabled");
  		 $('#cash').hide(); 
  		 $('#credit').hide(); 
	  	 $('#expense_list').show(); 
    	 $('#show_cash').button("enable"); 
   	  	 $('#show_credit').button("enable"); 
		 $('#show_expense').button("enable");
		
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
	        $('#expense_list').hide();
	        $('#show_expense').attr("disabled", "disabled");
        });

        //Show Credit Click
        $("#show_credit").click(function() {

	        $('#show_cash').button("enable");
	        $('#show_credit').attr("disabled", "disabled");
	        $('#cash').hide();
	        $('#credit').show();
	        $('#expense_list').hide();
	        $('#show_expense').attr("disabled", "disabled");

	        if (credit_expense_recordDS.total() == 0){
	        	credit_grid.addRow();
	        }

        });

        //Get Vendor DataSource
        var VendorDataSource = new kendo.data.DataSource({
	        transport: {
		        read: {
		        	url: baseUrl + "api/people_api/vendor_dropdown",
		        	type: "GET",
		        	dataType: "json"
		    	}
	        }
        });

        //Get Customer DataSource
        var CustomerDataSource = new kendo.data.DataSource({
        transport: {
        read: baseUrl + "api/people_api/customer_dropdown",
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
        var accountDataSource = new kendo.data.DataSource({
        transport: {
        read: {
        url : baseUrl + "api/accounting_api/account",
        type: "GET",
        dataType: "json"

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
      		receipt_type    	: "Expense",
			bill_type			: "Cash",
     		vendor_id  			: "",		
     		ref_no				: "",
     		check_no 			: "",
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
						 
						 //Add item record to database 
			 			 cash_expense_recordDS.sync();
					
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
                				receipt_type  	: { type: "string" },
								bill_type		: {  type: "string" },				
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
		
	 
 		//Expense Record Datasource
  		var cash_expense_recordDS = new kendo.data.DataSource({
 			transport: {
 			
 			 	create: {
 				 	url : baseUrl + "api/accounting_api/expense_record",
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
        account_id 		: {  type: "number", validation: { required: true }, defaultValue: 1  },
        memo    		: {  type: "string" },
        amount			: {  type: "number"  },
        class_id    : { type: "number"  },
        customer_id :  { type: "number" },
        customer    	: {  defaultValue: {id: 0, name: ""} },
        classes			: {  defaultValue: {id: 0, name: ""} },
        expense_account	: {  defaultValue: {id: 0, name: ""} }

        }
        }
        }

        });


        var cash_grid =  $("#cash_grid").kendoGrid({
        dataSource: cash_expense_recordDS,
        navigatable: true,
        height: 400,
        autoBind: false,
        toolbar: ["create"],
        columns: [
        { field: "expense_account", title: "Account", width: 150, editor: expense_ComboBox, template: "#= expense_account.name#" },
        { field: "memo", title: "Memo", width: 150 },
        { field: "amount", title: "Amount",format: "{0:c}", width: 120 },
        { field: "customer", title: "Customer", width: 130, editor: customer_ComboBox, template: "#= customer.name#" },
        { field: "classes", title: "Class", width: 130, editor: class_ComboBox, template: "#= classes.name#" },

        { command: [{ name: "destroy", text: "លុប" }], title: "&nbsp;", width: "70px" }],
        editable: true,
        save: function(data){

        //Define item_id
        if (data.values.expense_account){
        var expense_id = data.values.expense_account.id;
        data.model.set("account_id", expense_id);

        }
        //Define customer_id
        if (data.values.customer){
        var customer_id = data.values.customer.id;
        data.model.set("customer_id", customer_id);
        }

        //Define class_id
        if (data.values.classes){
        var class_id = data.values.classes.id;
        data.model.set("class_id", class_id);
        }

        //Calculation
        if (data.values.amount){
        var amount = data.values.amount;
        data.model.set("amount", amount);
        //Get Total
        var rows = cash_expense_recordDS.total();
        var total = 0;
        for (var i = 0; i<rows; i++){
						 var expense_record = cash_expense_recordDS.at(i);
						 total += expense_record.amount;
						 
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
		   cash_expense_recordDS.data(empty_arr);
		   
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
      receipt_type    : "Expense",
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
						
						//Add item record to database 
		 				credit_expense_recordDS.sync();
					
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
	
	
  	 	//Expense Record Datasource
   		var credit_expense_recordDS = new kendo.data.DataSource({
  		 	transport: {
 			
  				 create: {
  						url : baseUrl + "api/accounting_api/expense_record",
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
        account_id 		: {  type: "number", validation: { required: true }, defaultValue: 1  },
        memo    		: {  type: "string" },
        amount			: {  type: "number"  },
        class_id    : { type: "number"  },
        customer_id :  { type: "number" },
        customer    	: {  defaultValue: {id: 0, name: ""} },
        classes			: {  defaultValue: {id: 0, name: ""} },
        expense_account	: {  defaultValue: {id: 0, name: ""} }


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
        receipt_type  : CreditviewModel.get("receipt_type"),
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
        dataSource: credit_expense_recordDS,
        autoBind: false,
        height: 400,
        navigation: true,
        toolbar: ["create"],
        columns: [
        { field: "expense_account", title: "Account", width: 150, editor: expense_ComboBox, template: "#= expense_account.name#" },
        { field: "memo", title: "Memo", width: 150 },
        { field: "amount", title: "Amount",format: "{0:c}", width: 120 },
        { field: "customer", title: "Customer", width: 130, editor: customer_ComboBox, template: "#= customer.name#" },
        { field: "classes", title: "Class", width: 130, editor: class_ComboBox, template: "#= classes.name#" },
        { command: [{ name: "destroy", text: "លុប" }], title: "&nbsp;", width: "70px" }],
        editable: true,
        save: function(data){
        //Define expense_id
        if (data.values.expense_account){
        var expense_id = data.values.expense_account.id;
        data.model.set("account_id", expense_id);

        }

        //Define customer_id
        if (data.values.customer){
        var customer_id = data.values.customer.id;
        data.model.set("customer_id", customer_id);
        }

        //Define class_id
        if (data.values.classes){
        var class_id = data.values.classes.id;
        data.model.set("class_id", class_id);
        }
        
        //Calculation
        if (data.values.amount){
        var amount = data.values.amount;
        data.model.set("amount", amount);
        //Get Total
        var rows = credit_expense_recordDS.total();
        var total = 0;
        for (var i = 0; i<rows; i++){
							 var expense_record = credit_expense_recordDS.at(i);
							 total += expense_record.amount;
						 
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
   		   credit_expense_recordDS.data(empty_arr);
		   
   		   $("#credit_grid").data("kendoGrid").refresh();
		  		 
		   credit_grid.addRow();
   		 }
	
	 	
		/* -------------------- Credit End --------------------- */
	 
	 
	 	/* -------------------- Show Cash Expense Start ----------------------*/
 		
		//Show Cash Vendor CMB
		$("#show_cash_vendor").kendoComboBox({	
			dataTextField: "name",
			dataValueField: "id",		
			suggest: true,
   		 	template: '<table>' +
  			 			'<tr>' +
							'<td><span class="span3">${name}</span><span>${type}</span></td>' +
						'</tr>' +
			  		  '</table>',
		                        
			dataSource: VendorDataSource,
		 
  	  	}).data("kendoComboBox").list.width(400);
		
  	 	//Show Bill date for cash
  	    $("#show_cash_bill_date").kendoDatePicker({
	  	
  	  	  		change: function(e) {
    				var date = ShowCashviewModel.get("bill_date");
    				date = new Date(date);
			
  					if ($("#show_payment_term_id").data("kendoDropDownList").text() != "(--- ជ្រើសយកមួយ ---)"){
						var payment_term = PaymentTermDataSource.get($("#show_payment_term_id").data("kendoDropDownList").value());	
						
						
  						// get the text of the dropdownlist.
  						var discount = parseInt(payment_term.discount_percentage);
  						var net_due_in = parseInt(payment_term.net_due_in);
  						var discount_paid_within = parseInt(payment_term.discount_paid_within);
			
  						if (discount > 0)
  						{
  							//Show discount date
  							$("#show_discount_date_input").show();
  							$("#show_discount_date_title").show();
  							
	  						var discount_date = GetDiscountDate(date, discount_paid_within);
	  						ShowCashviewModel.set("due_date", GetDueDate(date, net_due_in));	
					
	  						ShowCashviewModel.set("discount_date", discount_date);
	  						$("#show_cash_discount_date").val(discount_date);
  							
				
  						}
  						else
  						{
  				  		  	$("#show_discount_date_input").hide();
  				   		 	$("#show_discount_date_title").hide();
  				   		 	$("#show_cash_discount_date").val("");
				  			  
  				   			if (net_due_in > 0)
  				   	 		{
  					 	   	 	ShowCashviewModel.set("due_date", GetDueDate(date, net_due_in));	
  				  	  		}
			  
  						}
				
  				 	}
  			
     	 	 	}
		
  	  	});  
		
  	 	//show due date for cash
  	 	$("#show_cash_due_date").kendoDatePicker();
	  
  	  	//Show discount date for cash
   	  	$("#update_cash_discount_date").kendoDatePicker();
	  
  	  	//Show amount total for cash
  	  	$("#show_cash_amount_due").kendoNumericTextBox({
  	      	format: "c",
	 	
  	  	}); 
		
  	    //Show Term ddl for cash
  		$("#show_payment_term_id").kendoDropDownList({
  	  		optionLabel: "(--- ជ្រើសយកមួយ ---)",
  			dataTextField: "term",
  	    	dataValueField: "id",
  			index: 0,	  	
  	  		dataSource: PaymentTermDataSource,
  			change:function(){
			
  				var date = ShowCashviewModel.get("bill_date");
  				date = new Date(date);
			
  				if ($("#show_payment_term_id").data("kendoDropDownList").text() != "(--- ជ្រើសយកមួយ ---)"){
  					payment_term = this.dataSource.get(this.value());			
			
  					// get the text of the dropdownlist.
  					var discount = parseInt(payment_term.discount_percentage);
  					var net_due_in = parseInt(payment_term.net_due_in);
  					var discount_paid_within = parseInt(payment_term.discount_paid_within);
			
  					if (discount > 0)
  					{
  						//Show discount date
  						$("#show_discount_date_input").show();
  						$("#show_discount_date_title").show();
					
  						var discount_date = GetDiscountDate(date, discount_paid_within);
  						ShowCashviewModel.set("due_date", GetDueDate(date, net_due_in));	
					
  						ShowCashviewModel.set("discount_date", discount_date);
  						$("#show_cash_discount_date").val(discount_date);
					
				
  					}
  					else
  					{
  				  	  	$("#show_discount_date_input").hide();
  				  	  	$("#show_discount_date_title").hide();
  				 	   	$("#show_cash_discount_date").val("");
				 
  				 	   	if (net_due_in > 0)
  				  	  	{
  							ShowCashviewModel.set("due_date", GetDueDate(date, net_due_in));	
  				   	 	}
			  
  					}
				
  				}
			
  			}
				  			 
  	  	});
	 	   
  		//Show Cash Account Cmb 
  	 	$("#show_cash_account").kendoComboBox({
  			dataTextField: "name",
  	   	 	dataValueField: "id",
  			suggest: true,
  			dataSource: CashAccountDataSource	
				 
  	 	});	  
	  
    	//Show Cash View model 
    	var ShowCashviewModel = kendo.observable({
   			id					: 0,
  			account_id          : "",
        	receipt_type    	: "Expense",
  			bill_type			: "Cash",
    		vendor_id  			: "",
    		check_no 			: 0,		
    		ref_no				: "",
    		payment_term_id		: 0,		
    	    total				: 0, 	  
    		bill_date			: "",
    		due_date			: "",
    		discount_date		: ""
     			
    	});  
    	kendo.bind($("#cash_expense"), ShowCashviewModel);
	  
   		//Cash Validator	 
   		var show_cash_validator = $("#show_cash_validate").kendoValidator().data("kendoValidator"),
   	 	show_cash_message = $(".show_cash_status");
		
   		//Show Cash Expense Datasource
    	var show_cash_expense_recordDS = new kendo.data.DataSource({
   		 	transport: {
   			 		read: {
   				 			url : baseUrl + "api/accounting_api/expense_record",
   							type: "GET",
   				 	   	 	dataType: "json"		
   		     		}, 
   			 		update: {
   				 			url : baseUrl + "api/accounting_api/expense_record",
   							type: "PUT",
   				 	   	 	dataType: "json"		
   		     		}, 
   			 		destroy: {
   				 			url : baseUrl + "api/accounting_api/expense_record",
   							type: "DELETE",
   				 	   	 	dataType: "json"		
   		     		},	
   			 	    parameterMap: function(options, operation) {
         			   		if (operation !== "read" && options.models) {
        						return {models: kendo.stringify(options.models)};
        					}
        					if (operation === "read"){
        						return {item_receipt_id : ShowCashviewModel.get("id")};
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
				        account_id 		: {  type: "number", validation: { required: true }, defaultValue: 1  },
				        memo    		: {  type: "string" },
				        amount			: {  type: "number"  },
				        class_id    	: { type: "number"  },
				        customer_id 	:  { type: "number" },
				        customer    	: {  defaultValue: {id: 0, name: ""} },
				        classes			: {  defaultValue: {id: 0, name: ""} },
				        expense_account	: {  defaultValue: {id: 0, name: ""} }
        			}
        		}
        	}
        });
		
        //Show Cash Grid
        var show_cash_grid =  $("#show_cash_grid").kendoGrid({
	        dataSource: show_cash_expense_recordDS,
	        autoBind: false,
	        toolbar: ["create"],
	        columns: [
		        { field: "expense_account", title: "Account", width: 150, editor: expense_ComboBox, template: "#= expense_account.name#" },
		        { field: "memo", title: "Memo", width: 150 },
		        { field: "amount", title: "Amount",format: "{0:c}", width: 120 },
		        { field: "customer", title: "Customer", width: 130, editor: customer_ComboBox, template: "#= customer.name#" },
		        { field: "classes", title: "Class", width: 130, editor: class_ComboBox, template: "#= classes.name#" },
		        { command: [{ name: "destroy", text: "លុប" }], title: "&nbsp;", width: "70px" }
	        ],
	        editable: true,
	        save: function(data) {
		        //Define expense_id
		        if (data.values.expense_account){
			        var expense_id = data.values.expense_account.id;
			        data.model.set("account_id", expense_id);
		        }

		        //Define customer_id
		        if (data.values.customer){
			        var customer_id = data.values.customer.id;
			        data.model.set("customer_id", customer_id);
		        }

		        //Define class_id
		        if (data.values.classes){
			        var class_id = data.values.classes.id;
			        data.model.set("class_id", class_id);
		        }
	        
		        //Calculation
		        if (data.values.amount){
			        var amount = data.values.amount;
			        data.model.set("amount", amount);
			        //Get Total
			        var rows = show_cash_expense_recordDS.total();
			        var total = 0;
			        for (var i = 0; i<rows; i++){
						var expense_record = show_cash_expense_recordDS.at(i);
						total += expense_record.amount;
				 	}
			 		ShowCashviewModel.set("total", total);				
	    		}
				 
	 		},
			remove: function(data) {						 
		 		ShowCashviewModel.set("total", ShowCashviewModel.get("total") - data.model.get("amount"));       
			}
        }).data("kendoGrid");
		 
  	  			
		//Close Cash Modal  	
		$("#cash_close").click(function (){
   	   	   $("#ShowExpenseModal").modal('hide');
		});
		
		
	 	/* -------------------- Show Cash Expense End ------------------------*/
	 	
		/* -------------------- Show Credit Expense Start --------------------*/
    	 
		 //Show Credit Vendor CMB
      	 $("#show_credit_vendor").kendoComboBox({	
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
		 
	     //Show amount total for credit
	     $("#show_credit_amount").kendoNumericTextBox({
	         format: "c"
	     });
	  
	     //Show Credit Account CMB 
	     $("#show_credit_account").kendoComboBox({
	   	  	dataTextField: "name",
	   	    dataValueField: "id",
	   	 	suggest: true,
	   	 	dataSource: CreditAccountDataSource	 	
		 
	     });
		 
	     //Show Bill date for credit
	     $("#show_credit_bill_date").kendoDatePicker();
  
	     //Show Credit View model 
	     var ShowCreditviewModel = kendo.observable({
	    		id					: 0,
	   			account_id          : "",
          receipt_type    : "Expense",
	   			bill_type				: "Credit",
	     		vendor_id  			: "",		
	     		ref_no				: "",
	     		payment_term_id		: 0,		
	     	    total				: 0, 	  
	     		bill_date			: "",
	     		due_date			: "",
	     		discount_date		: ""
     			
	     });  
	     kendo.bind($("#credit_expense"), ShowCreditviewModel);
	
	     //Credit Validator	 
	     var show_credit_validator = $("#show_credit_validate").kendoValidator().data("kendoValidator"),
	     show_credit_message = $(".show_credit_status");
		 
		 
		 //Show Credit Item Record Datasource
		 var show_credit_expense_recordDS = new kendo.data.DataSource({
			 transport: {
 			
				 read: {
					 url : baseUrl + "api/accounting_api/expense_record",
					 type: "GET",
					 dataType: "json"
 							
			     }, 
 			 	 Update: {
 			 	 	 url : baseUrl + "api/accounting_api/expense_record",
					 type: "PUT",
					 dataType: "json"
					 
 			 	 },	
			 	 destroy: {
				 	 url : baseUrl + "api/accounting_api/expense_record",
					 type: "DELETE",
				 	 dataType: "json"
 							
		     	 }, 
 			 		
				 parameterMap: function(options, operation) {
		     			if (operation !== "read" && options.models) {

        return {models: kendo.stringify(options.models)};
        }
        if (operation === "read"){
        return {item_receipt_id : ShowCreditviewModel.get("id")};
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
        account_id 		: {  type: "number", validation: { required: true }, defaultValue: 1  },
        memo    		: {  type: "string" },
        amount			: {  type: "number"  },
        class_id    : { type: "number"  },
        customer_id :  { type: "number" },
        customer    	: {  defaultValue: {id: 0, name: ""} },
        classes			: {  defaultValue: {id: 0, name: ""} },
        expense_account	: {  defaultValue: {id: 0, name: ""} }


        }
        }
        }

        });

        //Show Credit Grid
        var show_credit_grid = $("#show_credit_grid").kendoGrid({
        dataSource: show_credit_expense_recordDS,
        autoBind: false,
        navigation: true,
        toolbar: ["create"],
        columns: [
        { field: "expense_account", title: "Account", width: 150, editor: expense_ComboBox, template: "#= expense_account.name#" },
        { field: "memo", title: "Memo", width: 150 },
        { field: "amount", title: "Amount",format: "{0:c}", width: 120 },
        { field: "customer", title: "Customer", width: 130, editor: customer_ComboBox, template: "#= customer.name#" },
        { field: "classes", title: "Class", width: 130, editor: class_ComboBox, template: "#= classes.name#" },

        { command: [{ name: "destroy", text: "លុប" }], title: "&nbsp;", width: "70px" }],
        editable: true,
        save: function(data){
        //Define expense_id
        if (data.values.expense_account.name){
        var expense_id = data.values.expense_account.id;
        data.model.set("account_id", expense_id);

        }
        
        //Define customer_id
        if (data.values.customer){
        var customer_id = data.values.customer.id;
        data.model.set("customer_id", customer_id);
        }

        //Define class_id
        if (data.values.classes){
        var class_id = data.values.classes.id;
        data.model.set("class_id", class_id);
        }

        //Calculation
        if (data.values.amount){
        var amount = data.values.amount;
        data.model.set("amount", amount);
        //Get Total
        var rows = show_credit_expense_recordDS.total();
        var total = 0;
        for (var i = 0; i<rows; i++){
   							 var expense_record = show_credit_expense_recordDS.at(i);
   							 total += expense_record.amount;
						 
   						 }
					 
   					 	 ShowCreditviewModel.set("total", total);	
   			   	 	 }
   					
   			 }
      	 }).data("kendoGrid"); 
		  			
		//save from modal
		$("#show_cash_btn").click(function() {
			alert("hi");//cash_item_receiptDS.sync();
		}); 
 		//Close Credit Modal  	
 		$("#credit_close").click(function (){
    	   	  $("#ShowExpenseModal").modal('hide');
 		});
		
			  
		/* -------------------- Show Credit Expense End ----------------------*/
		
		/* -------------------- Expense List Start -------------------------- */
	 	
		 	  	  
	    //Expense Datasource
	    var show_item_receiptDS = new kendo.data.DataSource({
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
        					return {receipt_type : "Expense"};
        				}
        				return options;

        			}			
        	},
	        batch: false,
	        schema: {
		        model: {
			        id : "id"
		        }
	    	}
        });
        //Item Receipt List Grid
        var item_receipt_list_grid = $("#expense_list_grid").kendoGrid({
	        dataSource: show_item_receiptDS,
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
		        { field: "due_date", title: "Due Date", width: 100, template: '#= GetText(kendo.toString(due_date,"dd/MM/yyyy")) #'}
		    ],

	        change: function(){
		        var id = this.select().data().uid;
		        selected_item = this.dataSource.getByUid(id);
		        $("#show_expense").attr('disabled', false);

		        if (selected_item.bill_type == "Cash"){
			        //View Cash Update Modal
			        $("#cash_expense").show();
			        $("#credit_expense").hide();

			        //Set Update Cash View Model
			        ShowCashviewModel.set("id", selected_item.id);
			        ShowCashviewModel.set("account_id", selected_item.account_id);
			        ShowCashviewModel.set("vendor_id", selected_item.vendor_id);
			        ShowCashviewModel.set("ref_no", selected_item.ref_no);
			        ShowCashviewModel.set("payment_term_id", selected_item.payment_term_id);
			        ShowCashviewModel.set("total", selected_item.total);
			        ShowCashviewModel.set("bill_date", selected_item.bill_date);
			        ShowCashviewModel.set("due_date", selected_item.due_date);
			        ShowCashviewModel.set("discount_date", selected_item.discount_date);

		        	//Show discount date
			        if (selected_item.discount_date != null){
				        $("#show_discount_date_input").show();
				        $("#show_discount_date_title").show();
			        }

			        show_cash_message.text("").addClass("valid");

			        //show_cash_expense_recordDS.read();
			        //show_cash_grid.refresh();
		        }
		        else if (selected_item.bill_type == "Credit"){
			        //View Credit Update Modal
			        $("#cash_expense").hide();
			        $("#credit_expense").show();

			        //Set Update Cash View Model
			        ShowCreditviewModel.set("id", selected_item.id);
			        ShowCreditviewModel.set("account_id", selected_item.account_id);
			        ShowCreditviewModel.set("vendor_id", selected_item.vendor_id);
			        ShowCreditviewModel.set("ref_no", selected_item.ref_no);
			        ShowCreditviewModel.set("payment_term_id", "");
			        ShowCreditviewModel.set("total", selected_item.total);
			        ShowCreditviewModel.set("bill_date", selected_item.bill_date);
			        ShowCreditviewModel.set("due_date", "");
			        ShowCreditviewModel.set("discount_date", "");

			        show_credit_message.text("").addClass("valid");

			        //show_credit_expense_recordDS.read();
			        //show_credit_grid.refresh();

		        }

	        }
        }).data("kendoGrid");
		$("#expense_list_grid").on('dblclick', 'tbody>tr', function() { $("#ShowExpenseModal").modal('show'); });

        //Show Expense Click
        $("#show_expense").click(function() {
        this.preventDefault;

        $("#ShowExpenseModal").modal('show');

        });



        /* ------------------- Item Receipt List End -------------------------- */


        //Expense Account cmb
        function expense_ComboBox(container, options) {
        var baseUrl = "<?php echo base_url(); ?>";
  	 		$('<input required data-text-field="name" data-value-field="id"  data-bind="value:' + options.field + '"/>')

        .appendTo(container)
        .kendoComboBox({
        autoBind: false,
        suggest: true,
        dataSource: accountDataSource,

        });
        }

        //Customer cmb
        function customer_ComboBox(container, options) {
        var baseUrl = "<?php echo base_url(); ?>";
        $('<input required="" data-text-field="name" data-value-field="id"  data-bind="value:' + options.field + '"/>')

        .appendTo(container)
        .kendoComboBox({
        autoBind: false,
        suggest: true,
        dataSource: CustomerDataSource,

        });
        }
        //Class ckb
        function class_ComboBox(container, options) {
        var baseUrl = "<?php echo base_url(); ?>";
        $('<input required="" data-text-field="name" data-value-field="id"  data-bind="value:' + options.field + '"/>')

        .appendTo(container)
        .kendoComboBox({
        autoBind: false,
        suggest: true,
        dataSource: {
        transport: {
        read: baseUrl + "api/accounting_api/class_dropdown",
        }

        }

        }).data("kendoComboBox").list.width(200);

        }

        });
      </script>
