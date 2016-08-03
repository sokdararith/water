
<div class="container">
	<div class="row">
		<div class="span12">
			<?php $this->load->view('accounting/sidebar'); ?>
		</div>
		<div class="span12">
			<h1>General Journal Entry</h1>
			<br>
			<!-- Select Vendor-->
			<div id="example">
				<div id="validate">
					<div class="well well-small">
	   		 			<table>
							<tr>														
								</td>
								<td>
									Date:
								</td>
								<td valign="top">
									<input id="date" name="date" data-bind="value: date" required data-required-msg="Require Date"/>		 
								</td>								
								<td width="50">
								<td>
									Voucher Number:
								</td>
								<td>
									<input id="voucher" type="text" name="voucher" class="span2" data-bind="value: voucher"/>
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

 	//View model Cash
 	var viewModel = kendo.observable({
		id					: 0,
		account_id          : "",
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
		date				: ""
		
     			
 	});  
 	kendo.bind($("#example"), viewModel);

 	//Validator	 
 	var validator = $("#validate").kendoValidator().data("kendoValidator"),
 	message = $(".status");

  	//Set today for cash bill date
  	var today = GetToday();
 	viewModel.set("date", today);
  
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
					dr 				: {  type: "number", validation: { required: true }  },	
					cr    			: {  type: "number"		},
					balance  		: {  type: "number", validation: { required: true }  },
					memo         	: {  type: "string", validation: { required: true }  },					
					voucher			: {  type: "string"  	},
					class_id    	: {  type: "number", defaultValue: 0	},
					budget_id		: {  type: "number", defaultValue: 0 	},
					donor_id       	: {  type: "number", defaultValue: 0	},
					location_id     : {  type: "number", defaultValue: 0	},
					transaction_type     : {  type: "string" },	
					people_id     	: {  type: "number", defaultValue: 0	},
					employee_id     : {  type: "number", defaultValue: 0	},				
					invoice_id    	: {  type: "number", defaultValue: 0	},	
					payment_id    	: {  type: "number", defaultValue: 0	},	
					receipt_id    	: {  type: "number", defaultValue: 0	},
					item_receipt_id : {  type: "number", defaultValue: 0	}
						
				}
			}		 
		}
	   
	});
	
		
	 
 	//Journal item Datasource
	var journal_itemDS = new kendo.data.DataSource({
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
 			
			 update: {
				 url : baseUrl + "api/accounting_api/journal",
				 type: "PUT",
		 		dataType: "json"
	 		 },
			 destroy: {
				  url : baseUrl + "api/accounting_api/journal",
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
			  aggregate: [ { field: "dr", aggregate: "sum" },
			               { field: "cr", aggregate: "sum" }],
  	 		  batch: false,	                            
 	 		  schema: {							                  
				 model: {
					 id : "id",
					 fields: {	
						 account_id		: {  type: "number", validation: { required: true }	},			
						 dr 			: {  type: "number", validation: { required: true,  min: 0}  },	
						 cr    			: {  type: "number", validation: { required: true,  min: 0}  },						
						 memo         	: {  type: "string", validation: { required: true }  },					
						 voucher		: {  type: "string"  	},
						 class_id    	: {  type: "number", defaultValue: 0	},
						 budget_id		: {  type: "number", defaultValue: 0 	},
						 donor_id       : {  type: "number", defaultValue: 0	},
						 location_id    : {  type: "number", defaultValue: 0	},					
						 people_id     	: {  type: "number", defaultValue: 0	},
						 employee_id    : {  type: "number", defaultValue: 0	},						
						 account_name	: {	 defaultValue: {id: 0, name: ""} },	
						 class_name		: {	 defaultValue: {id: 0, name: ""} },
						 budget_name	: {	 defaultValue: {id: 0, name: ""} },
						 donor_name		: {	 defaultValue: {id: 0, name: ""} },
						 location_name	: {	 defaultValue: {id: 0, name: ""} },	
						 people_name	: {	 defaultValue: {id: 0, name: ""} },	
						 employee_name	: {	 defaultValue: {id: 0, name: ""} }	
						   
				}
			}		 
		}
	   
	}); 
	 

  	var journal_grid =  $("#grid").kendoGrid({
  	         dataSource: journal_itemDS,
  	         navigatable: true,
  	         height: 400,
			 autoBind: false,
			 columnMenu: true,
  	         toolbar: ["create"],
  	         columns: [
			 		  { command: [{ name: "destroy", template: "<a type='image' class='k-grid-delete'><i class='icon-trash icon-black'></i></a>" }], title: "&nbsp;", width: "30px" },
  	                  { field: "account_name", title: "Account", width: 200, menu: false, editor: account_ComboBox, template: "#= account_name.name#", footerTemplate: "Total Count: " },
  					  { field: "dr", title: "Debit", format: "{0:c}", width: 130, menu: false, footerTemplate: "Dr: #=sum#" },
  	                  { field: "cr", title: "Credit", format: "{0:c}", width: 130, menu: false, footerTemplate: "Cr: #=sum#" },
  	                  { field: "memo", title: "Memo", width: 160, menu: false, },
  					  { field: "people_name", title: "V/C Name", width: 120, editor: people_ComboBox, template: "#= people_name.name#"},
  					  { field: "employee_name", title: "Staff Name", width: 120, editor: employee_ComboBox, template: "#= employee_name.name#"},
					  { field: "class_name", title: "Class", width: 120, editor: class_ComboBox, template: "#= class_name.name#"},
					  { field: "budget_name", title: "Budget", width: 120, editor: budget_ComboBox, template: "#= budget_name.name#" },
					  { field: "donor_name", title: "Donor", width: 120, editor: donor_ComboBox, template: "#= donor_name.name#" },
					  { field: "location_name", title: "Location", width: 120, editor: location_ComboBox, template: "#= location_name.name#" }], 			
					   	                  
  	         editable: true,
			 save: function(data){
				 //Define item_id
				 if (data.values.account_name){
					 var account_id = data.values.account_name.id;
					 data.model.set("account_id", account_id);									 
				 }				 
				 journal_grid.refresh();	  
		 	}
			
		 
     }).data("kendoGrid");
	 
	  //Hide columns
	  journal_grid.hideColumn("employee_name");
	  journal_grid.hideColumn("budget_name");
	  journal_grid.hideColumn("donor_name");
	  journal_grid.hideColumn("location_name");
	 
	  //Add two journal item grid rows
	  //Add_Row();
	  journal_grid.addRow();
	  
	  
      //Save button click
      $("#add").click(function() {
          this.preventDefault;		 
		
		var rows = journal_itemDS.total();

		if( rows >= 2 ) {
			if (validator.validate()) {
			    if (Validate_Total()){
			    	if(Validate_Fields(journal_itemDS).length == 0) {
			    		add_new_journal_entry();
   						$('#successModal').modal('show');
			    	} else {
			    		message.text("សូមពិនិត្រ Dr និង Cr ឡើងវិញ។").addClass("invalid");
			    	}		
			    }else{
			    	message.text("សូមពិនិត្រ Dr និង Cr ម្ដងទៀត.").addClass("invalid");
			    }			 
   				
   		  	} else {
   		 		message.text("Oops! There is invalid data in the form.").addClass("invalid");
   	 	   	}
		} else {
			message.text("តំរូវអោយមានជួរពីរ").addClass("invalid");
		}
   		  	
			
      });
	 
   	//Add new journal entry
   	function add_new_journal_entry() {
		
		 //Loop Datasource
		 var rows = journal_itemDS.total();
		 for (var i = 0; i<rows; i++){
			 
			 var journal_item = journal_itemDS.at(i);
			 
	   		 journalDS.add({	   						
				account_id		: journal_item.account_id,			
				dr 				: journal_item.dr,	
				cr    			: journal_item.cr,
				balance  		: 0,
				memo         	: journal_item.memo,					
				voucher			: viewModel.get("voucher"),
				class_id    	: journal_item.class_id,
				budget_id		: journal_item.budget_id,
				donor_id       	: journal_item.donor_id,
				location_id     : journal_item.location_id,
				transaction_type  : "General Journal",	
				people_id     	: journal_item.people_id,
				employee_id     : journal_item.employee_id,				
				invoice_id    	: journal_item.invoice_id,	
				payment_id    	: journal_item.payment_id,	
				receipt_id    	: journal_item.receipt_id,
				item_receipt_id : journal_item.item_receipt_id,
				date			: kendo.toString(viewModel.get("date"), "yyyy-MM-dd"),
	   		});
						 
				
			
		 }
  		  	journalDS.sync();			
  	};

	//Validate Total Debit = Credit
	function Validate_Total(){
	
	 	var rows = journal_itemDS.total();
		var total_credit = 0;
	 	var total_debit = 0;
	 
		for (var i = 0; i<rows; i++){
			 var journal_item = journal_itemDS.at(i);
			 
			 total_debit += journal_item.dr;
			 total_credit += journal_item.cr;						
				
	 	}
		
		if (total_debit == total_credit)
		{
			return true;
		}
		else{
			return false;
		}
	}

	//Check if both Dr. and Cr. fields are entered
	function Validate_Fields(dataSource) {
		var rows = dataSource.total();
		var errors = [];
		for( var i=0; i < rows; i++) {
			if (dataSource.at(i).dr == dataSource.at(i).cr) {
				errors.push(i++);
			}
		}
		return errors;
	}
	
    $("#clear").click(function() {
   	 	Clear_Input();	
    });

   	//Clear Input
   	function Clear_Input(){
			 
   	 	//Reset View Model
   		viewModel.set("id", 0);
   		viewModel.set("account_id", "");
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

     		//Empty Grid
    	 	var empty_arr = [];
    		journalDS.data(empty_arr);
		    journal_itemDS.data(empty_arr);
     		journal_grid.refresh();
		  				
   		   	//Add_Row();
   		   	journal_grid.addNew();
   	}
	
	//Add two rows to journal item grid
	function Add_Row(){
	
		journal_content.push({account_id: ""}, {account_id: ""});	
  	  
	}	
  
});	//End of document ready 

 //Account ckb
function account_ComboBox(container, options) {
  	var baseUrl = "<?php echo base_url(); ?>";
 	$('<input required data-text-field="name" data-value-field="id"  data-bind="value:' + options.field + '"/>')
	        
        .appendTo(container)
        .kendoComboBox({
		 autoBind: false,
		 suggest: true,
         dataSource: {
         transport: {
               read: baseUrl + "api/accounting_api/account",
         }
      }
		  
   });
 }   

//People ckb
function people_ComboBox(container, options) {
   	var baseUrl = "<?php echo base_url(); ?>";
  	$('<input required data-text-field="name" data-value-field="id"  data-bind="value:' + options.field + '"/>')
	        
         .appendTo(container)
         .kendoComboBox({
 		  autoBind: false,
 		  suggest: true,
		  template: '<table>' +
		  			 	'<tr>' +
							'<td><span class="span3">${data.name}</span><span>${data.type}</span></td>' +
						'</tr>' +
					'</table>',
		                                   
          dataSource: {
          transport: {
                read: baseUrl + "api/people_api/people_dropdown",
          }
		 
       }
		  
    }).data("kendoComboBox").list.width(400);
} 

//Employee ckb
function employee_ComboBox(container, options) {
	var baseUrl = "<?php echo base_url(); ?>";
	$('<input required data-text-field="name" data-value-field="id"  data-bind="value:' + options.field + '"/>')
	        
      .appendTo(container)
      .kendoComboBox({
	   autoBind: false,
	   suggest: true,
	   template: '<table>' +
	  			 	'<tr>' +
						'<td><span class="span3">${data.name}</span><span>${data.type}</span></td>' +
					'</tr>' +
				 '</table>',
		                                   
       dataSource: {
       transport: {
             read: baseUrl + "api/staff_api/employee_dropdown",
       }
		 
    }
		  
 }).data("kendoComboBox").list.width(400);
 
}


//Class ckb
function class_ComboBox(container, options) {
	var baseUrl = "<?php echo base_url(); ?>";
	$('<input required data-text-field="name" data-value-field="id"  data-bind="value:' + options.field + '"/>')
	        
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

//Budget ckb
function budget_ComboBox(container, options) {
	var baseUrl = "<?php echo base_url(); ?>";
	$('<input required data-text-field="name" data-value-field="id"  data-bind="value:' + options.field + '"/>')
	        
      .appendTo(container)
      .kendoComboBox({
	   autoBind: false,
	   suggest: true,	              
       dataSource: {
       transport: {
             read: baseUrl + "api/accounting_api/budget_dropdown",
       }
		 
    }
		  
 }).data("kendoComboBox").list.width(200);
 
}

//Donor ckb
function donor_ComboBox(container, options) {
	var baseUrl = "<?php echo base_url(); ?>";
	$('<input required data-text-field="name" data-value-field="id"  data-bind="value:' + options.field + '"/>')
	        
      .appendTo(container)
      .kendoComboBox({
	   autoBind: false,
	   suggest: true,	              
       dataSource: {
       transport: {
             read: baseUrl + "api/accounting_api/donor_dropdown",
       }
		 
    }
		  
 }).data("kendoComboBox").list.width(200);
 
}

//Location ckb
function location_ComboBox(container, options) {
	var baseUrl = "<?php echo base_url(); ?>";
	$('<input required data-text-field="name" data-value-field="id"  data-bind="value:' + options.field + '"/>')
	        
      .appendTo(container)
      .kendoComboBox({
	   autoBind: false,
	   suggest: true,	              
       dataSource: {
       transport: {
             read: baseUrl + "api/accounting_api/location_dropdown",
       }
		 
    }
		  
 }).data("kendoComboBox").list.width(200);
 
}
</script>  