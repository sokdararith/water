		<div class="span12">
			<h1>Item Adjustment <a href="<?php echo base_url();?>inventory/index/" class="pull-right"><i class="icon-home"></i></a></h1>
			<br>
			<!-- Select Adjustment Info-->
			<div id="example">
				<div id="validate">
					<div class="well well-small">
	   		 			<table>
							<tr>														
								</td>
								<td>
									Adjustment Date:*
								</td>
								<td width="300">
									<input id="date" name="date" data-bind="value: date" required data-required-msg="Require Adjustment Date"/>		 
									
								</td>								
								
								<td>
									Ref No:
								</td>
								<td>
									<input id="voucher"  name="voucher" class="k-textbox span2" data-bind="value: voucher"/>
								</td>
							</tr>
							<tr>														
								</td>
								<td>
									
								</td>
								<td width="300">
									
									 <span class="k-invalid-msg" data-for="date"></span>
								</td>								
								
								<td>
									
								</td>
								<td>
									
								</td>
							</tr>
							<tr>														
								<td>
									Expense Account:*
								</td>
								<td width="300">
									<input id="expense_account_id" name="expense_account_id" data-bind="value: expense_account_id" required data-required-msg="Require Adjustment Account (Expense)"/>		 
								
								</td>								
								
								<td>
									Class:
								</td>
								<td>
									<input id="class" name="class"  data-bind="value: class"/>
								</td>
							</tr>
							<tr>														
								<td>
									
								</td>
								<td width="300">
									 <span class="k-invalid-msg" data-for="expense_account_id"></span>
								</td>								
								
								<td>
									
								</td>
								<td>
									
								</td>
							</tr>
							<tr>														
								<td>
									Income Account:*
								</td>
								<td width="300">
									<input id="income_account_id" name="income_account_id" data-bind="value: income_account_id" required data-required-msg="Require Adjustment Account (Income)"/>		 
									
								</td>								
								
								<td>
									Memo:
								</td>
								<td>
									<input id="memo" name="memo" class="k-textbox span3" data-bind="value: memo">
								</td>
							</tr>
							<tr>														
								<td>
									
								</td>
								<td width="300">
										 
									 <span class="k-invalid-msg" data-for="income_account_id"></span>
								</td>								
								
								<td>
									
								</td>
								<td>
									
								</td>
							</tr>
						</table>			
					</div>
				    <div class="status" align="center"></div>		
					
			  		<div id="grid"></div>
			  	    <div align="right">
						<br>
			   			<button id="add" class="btn btn-primary" type="button" ><i class="icon-hdd icon-white"></i> កត់ត្រា</button><span> </span><button id="clear" class="btn " type="submit" ><i class="icon-remove-circle icon-black"> </i> មោឃភាព</button>
			   	 		<br>
					</div>
				</div>
		   </div>				
		</div>		

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
 
 <script>
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

//Close successfull message
 $("#close").click(function() {
	 $('#successModal').modal('hide');
	     
 });
			
$(document).ready(function() {
	var baseUrl = "<?php echo base_url(); ?>";
	
	//Order date
	$("#date").kendoDatePicker();
	
	//Account Adjustment cmb (Expense)
	 $("#expense_account_id").kendoComboBox({
		dataTextField: "name",
		dataValueField: "id",
		suggest: true,
		dataSource: {					
			transport: {
				read: baseUrl + "api/accounting_api/account",
				type: "GET",
				dataType: "json"
			}
	
		}
		 
	});
	
	//Account Adjustment cmb (Income)
	 $("#income_account_id").kendoComboBox({
		dataTextField: "name",
		dataValueField: "id",
		suggest: true,
		dataSource: {					
			transport: {
				read: baseUrl + "api/accounting_api/account",
				type: "GET",
				dataType: "json"
			}
	
		}
		 
	});

	//Class cmb
	 $("#class").kendoComboBox({
		dataTextField: "name",
		dataValueField: "id",
		suggest: true,
		dataSource: {					
			transport: {
				read: baseUrl + "api/accounting_api/class_dropdown",
				type: "GET",
				dataType: "json"
			}
	
		}
		 
	});
	
 	//View model for account
 	var viewModel = kendo.observable({
		id					: 0,
		expense_account_id  : "",
		income_account_id	: "",
		dr					: 0,
 		cr   				: 0,		
 		balance				: 0,
 		memo				: "",		
 	    voucher				: "", 	  
 		class_id			: 0,
 		budget_id			: 0,
 		donor_id			: 0,
		location_id			: 0,
		transaction_type	: "",
		people_id			: 0,
		employee_id			: 0,
		invoice_id			: 0,
		payment_id			: 0,
		receipt_id			: 0,
		item_receipt_id		: 0,
		date				: GetToday(),
		new_quantity		: "",
		
     			
 	});  
 	kendo.bind($("#example"), viewModel);

 	//Validator	 
 	var validator = $("#validate").kendoValidator().data("kendoValidator"),
 	message = $(".status");

 	//Journal Datasource
	 var journalDS = new kendo.data.DataSource({
	 transport: {
		 read: {
			 url : baseUrl + "api/accounting_api/journal",
			 type: "GET",
			 dataType: "json"
		 },
		 create: {
			 url : baseUrl + "api/accounting_api/journal",
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
			     account_id		: {  type: "number", validation: { required: true }	},			
				 dr 			: {  type: "number", validation: { required: true }  },	
				 cr    			: {  type: "number"		},
				 balance  		: {  type: "number", validation: { required: true }  },
				 memo         	: {  type: "string", validation: { required: true }  },					
				 voucher		: {  type: "string"  	},
				 class_id    	: {  type: "number", defaultValue: 0	},
				 budget_id		: {  type: "number", defaultValue: 0 	},
				 donor_id       : {  type: "number", defaultValue: 0	},
				 location_id    : {  type: "number", defaultValue: 0	},
				 transaction_type     : {  type: "string" },	
				 people_id     	: {  type: "number", defaultValue: 0	},
				 employee_id    : {  type: "number", defaultValue: 0	},				
				 invoice_id    	: {  type: "number", defaultValue: 0	},	
				 payment_id    	: {  type: "number", defaultValue: 0	},	
				 receipt_id    	: {  type: "number", defaultValue: 0	},
				 item_receipt_id : {  type: "number", defaultValue: 0	},
				  
						
				}
			}		 
		}
	   
	});
	
	//Item datasource
	 var itemDS = new kendo.data.DataSource({
	 transport: {
		read: {
			url : baseUrl + "api/inventory_api/item",
			type: "GET",
			dataType: "json"
		},
		create: {
			url : baseUrl + "api/inventory_api/item",
			type: "POST",
			dataType: "json",
			complete: function(e) {
						$("#grid").data("kendoGrid").dataSource.read(); 
					}
		},
		update: {
			url : baseUrl + "api/inventory_api/item",
			type: "PUT",
			dataType: "json",
			complete: function(e) {
						$("#grid").data("kendoGrid").dataSource.read(); 
					}
		},	
		destroy: {
			url : baseUrl + "api/inventory_api/item",
			type: "DELETE",
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
				item_sku 				: {  type: "string" },
				name 					: {  type: "string", editable: false },	
				item_type_id			: {  type: "number" },
				unit_measure_id			: {  type: "number" },
				cost         			: {  type: "number"  },
				quantity       			: {  type: "number", editable: false  },
				price					: {  type: "number" },				
				general_account_id   	: {  type: "number" },
				cogs_account_id    		: {  type: "number" },
				income_account_id   	: {  type: "number" },
				purchase_description	: {  type: "string", editable: false  },
				sale_description		: {  type: "string" },
				status					: {  type: "boolean" },
				account_name			: {   },
				type_name				: {   },
				measure_type			: {  type: "string"  },
				new_quantity			: {  type: "number", validation: { min: 0 }  },
				adjustment_outcome		: {  type: "string", defaultValue: ""  }							
								
			}
		}		 
	}
	
});		
		
	//Item Update datasource
	 var item_updateDS = new kendo.data.DataSource({
	 transport: {
		
		update: {
			url : baseUrl + "api/inventory_api/item",
			type: "PUT",
			dataType: "json",
			complete: function(e) {
						$("#grid").data("kendoGrid").dataSource.read(); 
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
				item_sku 				: {  type: "string" },
				name 					: {  type: "string" },	
				item_type_id			: {  type: "number" },
				unit_measure_id			: {  type: "number" },
				cost         			: {  type: "number" },
				quantity       			: {  type: "number" },
				price					: {  type: "number" },				
				general_account_id   	: {  type: "number" },
				cogs_account_id    		: {  type: "number" },
				income_account_id   	: {  type: "number" },
				purchase_description	: {  type: "string" },
				sale_description		: {  type: "string" },
				status					: {  type: "boolean" }										
								
			}
		}		 
	}
	
});		
	
	
//Item grid
var item_grid = $("#grid").kendoGrid({		
	dataSource: itemDS,
	sortable: true,
	navigatable: true,
	selectable: true,
	
	columns: [						
		{ field: "name", title: "ឈ្មោះ" , width: "230px"},	
		{ field: "purchase_description", title: "ពិពណ៏នា", width: "250px" },		
		{ field: "quantity", title: "ចំនួន" , width: "100px"},
		{ field: "new_quantity", title: "ចំនួនថ្មី" , width: "100px" },		
		{ field: "adjustment_outcome", title: "ចំណេញ/ខាត" , width: "100px" }],
	 editable: true,
	 save: function(data){
					 
		 if (data.values.new_quantity){
			 
			 var quantity = data.model.get("quantity");
			 var new_quantity = data.values.new_quantity;
					 
			 if (quantity > new_quantity){
				 data.model.set("adjustment_outcome", "Loss");
			 }
			 else if (quantity < new_quantity){
			 	 data.model.set("adjustment_outcome", "Gain");
			 }			
			 else{
			 	 data.model.set("adjustment_outcome", "Equal");
			 }			 								 
		 }
		 else if  (data.values.new_quantity == 0){
			 data.model.set("adjustment_outcome", "Loss");
		 }				 
		
 	}
	
}).data("kendoGrid");

//Save button click
$("#add").click(function() {
    this.preventDefault;		 
	
  if (validator.validate()) {
	   
 		make_adjustment();
 		$('#successModal').modal('show');	   	
   				
  } else {
 		message.text("Oops! There is invalid data in the form.").addClass("invalid");
   }
			
});	

//Update item for ajustment and add new adjustment journal
function make_adjustment() {
		
	 var income_amount = 0;
	 var expense_amount = 0;
	 var inventory_debit = 0;
	 var inventory_credit = 0;
		 
	 //Loop Datasource
	 var rows = itemDS.total();
	 for (var i = 0; i<rows; i++){
			 
		 var item = itemDS.at(i);
			 
		 if (item.adjustment_outcome != "Equal" || item.adjustment_outcome != ""){
			 //make adjustment
			 var qty = 0;
			 if (item.adjustment_outcome == "Gain"){
					 
			 	 qty = item.new_quantity - item.quantity
					 
				 income_amount += item.cost * qty
				 inventory_debit += item.cost * qty
					 
			 }
			 else if (item.adjustment_outcome == "Loss"){
				 	 
				 qty = item.quantity - item.new_quantity;	
				  
				 expense_amount += item.cost * qty
				 inventory_credit += item.cost * qty
			 }				 	 
		 
		 }
	 }//End for loop
	 
	 alert(income_amount);	 
	 //if income_amount has value then post this income journal
	 if (income_amount > 0){
	 	Add_Journal_Datasource(viewModel.get("income_account_id"), 0, income_amount);
	 }
		 
	 //if expense_amount has value then post this expense journal
	 if (expense_amount > 0){
	 	Add_Journal_Datasource(viewModel.get("expense_account_id"), expense_amount, 0);
	 }
		 
	 //if inventory_debit has value then post this inventory journal
	 if (inventory_debit > 0){
	 	Add_Journal_Datasource(5, inventory_debit, 0);
	 }
		 
	  //if inventory_credit has value then post this inventory journal
	 if (inventory_credit > 0){
	 	Add_Journal_Datasource(5, 0, inventory_credit);
	 }
  		 
	 itemDS.sync();
	 journalDS.sync();			
};
	
function Add_Journal_Datasource(account_id, dr, cr)	{
	journalDS.add({	   						
		account_id		: account_id,			
		dr 				: dr,	
		cr    			: cr,
		balance  		: 0,
		memo         	: viewModel.get("memo"),					
		voucher			: viewModel.get("voucher"),
		class_id    	: viewModel.get("class_id"),
		budget_id		: viewModel.get("budget_id"),
		donor_id       	: viewModel.get("donor_id"),
		location_id     : viewModel.get("location_id"),
		transaction_type  : "Item Adjustment",	
		people_id     	: viewModel.get("people_id"),
		employee_id     : viewModel.get("employee_id"),				
		invoice_id    	: viewModel.get("invoice_id"),	
		payment_id    	: viewModel.get("payment_id"),	
		receipt_id    	: viewModel.get("receipt_id"),
		item_receipt_id : viewModel.get("item_receipt_id"),
		date			: kendo.toString(viewModel.get("date"), "yyyy-MM-dd"),
	});
}

$("#clear").click(function() {
 	Clear_Input();	
});

	//Clear Input
	function Clear_Input(){
			 
	 	//Reset View Model
		viewModel.set("id", 0);
		viewModel.set("expense_account_id", "");
		viewModel.set("income_account_id", "");
		viewModel.set("dr", 0);
		viewModel.set("cr", 0);
		viewModel.set("balance", 0);
		viewModel.set("memo", "");
		viewModel.set("date", GetToday());
		viewModel.set("voucher", "");
		viewModel.set("class_id", 0); 
		viewModel.set("budget_id", 0); 
		viewModel.set("donor_id", 0); 
		viewModel.set("location_id", 0); 
		viewModel.set("transaction_type",""); 
		viewModel.set("people_id", 0); 
		viewModel.set("employee_id", 0); 
		viewModel.set("new_quantity", "");
  		
		itemDS.read();
  		item_grid.refresh();
				  
	}
	
  
});	//End of document ready 


   	
	
</script>