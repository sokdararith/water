
		<?php $this->load->view("accounting/sidebar"); ?>
		<div class="span12">
			<h1>តារាងគណនី</h1>
			<br>
                      
            <button name="addNew" id="addNew" class="btn btn-success" type="button"><i class="icon-plus icon-white"></i> បញ្ចូលគណនីថ្មី</button>
            <br />
            <br />
            
            <div id="grid" class="table table-hover table-striped"></div>            
                  
            
		</div>		


<!-- Account Modal --> 
<div id="myModal">  
  <div id="myBody" class="modal-body">    
    <table>
      <tr>
        <td valign="top">ប្រភេទគណនី <span style="color:red">*</span></td>
        <td><input name="account_type" id="account_type" data-bind="value: account_type_id" required data-required-msg="ត្រូវការ ប្រភេទគណនី" /></td>
      </tr>
      <tr>
        <td valign="top">លេខកូដ <span style="color:red">*</span></td>
        <td><input id="code" name="code" class="k-textbox" data-bind="value: code" placeholder="ឧ. 10100" required validationMessage="ត្រូវការ លេខកូដ" /></td>
      </tr>
      <tr>
        <td valign="top">ឈ្មោះគណនី <span style="color:red">*</span></td>
        <td><input id="name" name="name" class="k-textbox" data-bind="value: name" placeholder="ឧ. សែក" required validationMessage="ត្រូវការ ឈ្មោះគណនី" /></td>
      </tr>
      <tr>
        <td valign="top">ពណ៏នា</td>
        <td><textarea name="description" id="description" class="k-textbox" data-bind="value: description" rows="2"></textarea></td>
      </tr>
      <tr>
        <td valign="top">ចំនុះ</td>
        <td><input name="parent" id="parent" data-bind="value: parent_id" /></td>
      </tr>
    </table>
    
    <br />
    
    <div class="status" align="center"></div>
    
  </div> <!--End div modal-body-->
  <div class="modal-footer">
    <button name="delete" id="delete" class="btn btn-danger"><i class="icon-remove icon-white"></i> លុប</button>
    <button name="close" id="close" class="btn"><i class="icon-ban-circle"></i> បិទ</button>
    <button name="save" id="save" class="btn btn-primary"><i class="icon-hdd icon-white"></i> កត់ត្រា</button>
  </div> <!--End div modal-footer-->
</div> <!--End div myModal-->

<!--Account body-->
<script id="rowTemplate" type="text/x-kendo-template">
	<tr>		
		<td width="70px">
			${code}
		</td>
		<td>
			<div style="cursor:pointer; color:blue;" class="editing" data-id="${id}">${name}</div>					
			<div style="color:gray;font-size:8pt;">${description}</div>
		</td>
		<td width="200px">
			${type}	
		</td>		
	</tr>
</script>

<script>
	
$(document).ready(function() {
	
//View model
var viewModel = kendo.observable({	
	id				: 0,
	code			: "",		
	name			: "",
	account_type_id	: 0,	
	description		: "",
	company_id		: 0,		
	parent_id		: 0	
});
kendo.bind($("#myModal"), viewModel);	

//Account datasource	
var accountDS = new kendo.data.DataSource({
transport: {
	read: {
		url : ARNY.baseUrl + "api/accounts/account",
		type: "GET",
		dataType: "json"
	},
	create: {
		url : ARNY.baseUrl + "api/accounts/account",
		type: "POST",
		dataType: "json"
	},
	update: {
		url : ARNY.baseUrl + "api/accounts/account",
		type: "PUT",
		dataType: "json"
	},
	destroy: {
		url : ARNY.baseUrl + "api/accounts/account",
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
  schema: {
	  model: {
		id : "id"
	  },
	  count: 'count'		
  }
});

//Sub accout datasource
var subAcctDS = new kendo.data.DataSource({
  transport: {
	read: {
		url : ARNY.baseUrl + "api/accounts/account",
		type: "GET",
		dataType: "json"
	}
  }
});

//Account grid
var grid = $("#grid").kendoGrid({
	dataSource: accountDS,	
	columns: [		
		{ field: "code", title:"លេខកូដ", width: "90px" },
		{ field: "name", title:"ឈ្មោះគណនី" },
		{ field: "type", title:"ប្រភេទគណនី", width: "200px" }		
	],
	rowTemplate: kendo.template($("#rowTemplate").html())	
}).data("kendoGrid");

//Add new account
function add_new_account(){
    accountDS.add({	  			
	  code 				: viewModel.get("code"),	  
	  name 				: viewModel.get("name"),							  	  
	  account_type_id	: viewModel.get("account_type_id"),
	  description 		: viewModel.get("description"),
	  parent_id 		: viewModel.get("parent_id"),
	  company_id 		: viewModel.get("company_id"),
	  type				: ""	  	  	    	  
  });  
  accountDS.sync();  
}

//Edit account
function edit_account(id){	
	var acct = accountDS.get(id);
	
	acct.set("code", viewModel.get("code"));
	acct.set("name", viewModel.get("name"));
	acct.set("account_type_id", viewModel.get("account_type_id"));
	acct.set("description", viewModel.get("description"));
	acct.set("parent_id", viewModel.get("parent_id"));
		
	accountDS.sync(); 		
}

//Delete account
function delete_account(){
	var id = viewModel.get("id");
	var acct = accountDS.get(id);				
	accountDS.remove(acct);
	accountDS.sync();		
}

//Clear data
function clear_account(){
	viewModel.set("id", 0);  			
	viewModel.set("code", "");	  
	viewModel.set("name", "");							  	  
	viewModel.set("account_type_id", 0);
	viewModel.set("description", "");
	viewModel.set("parent_id", 0);  
}			
		
//Account type ddl
$("#account_type").kendoDropDownList({
	optionLabel: "(--- ជ្រើសយកមួយ ---)",
	dataTextField: "name",
	dataValueField: "id",
	dataSource: {					
		transport: {
			read: ARNY.baseUrl + "api/account_types/account_type"			
		}
	}
});
		
//Parent combobox
var parentCB = $("#parent").kendoComboBox({
	dataTextField: "name",
	dataValueField: "id",		
	template: '<span class="span1">${code}</span> <span class="span3">${name}</span> <span>${type}</span>',
	dataSource: subAcctDS
}).data("kendoComboBox");		
parentCB.list.width(600);

//Add new account modal
var wnd = $("#myModal").kendoWindow({
	width: "500px",
	title: "About Alvar Aalto",
	modal: true,
	visible: false
}).data("kendoWindow");

//Open modal
$("#addNew").click(function(){
	wnd.center().open();
	$("#delete").hide();
	
	clear_account();
	subAccDS.read();		
});

//Close modal
$("#close").click(function(){
	wnd.close();
});

//Delete button
$("#delete").click(function(){
	if (confirm("Are you sure, you want to DELETE it?")) {			
		delete_account();
		wnd.close();					
    }
    return false;	
});

//Account grid editing mode
$("#grid").on("click", ".editing", function(e) {
	var target = $(e.currentTarget);
    var id = target.data("id");
	
	if(id > 0){ //Edit Mode		
		var acct = accountDS.get(id);
		
		viewModel.set("id", id);
		viewModel.set("code", acct.code);	
		viewModel.set("name", acct.name);							  	  
		viewModel.set("account_type_id", acct.account_type_id);	
		viewModel.set("description", acct.description);
		viewModel.set("parent_id", acct.parent_id);			
	}	
	wnd.center().open();
	$("#delete").show();		
});

//Validator	 
var validator = $("#myBody").kendoValidator().data("kendoValidator"), status = $(".status");
	
//Button Save click
$("#save").click(function(){
	//this.preventDefault;		 
	if (validator.validate()) {
		var id = viewModel.get("id"); 	
		
		if(id > 0){
			edit_account(id);
		}
		else{
			add_new_account();
		}
		
		grid.refresh();
		
		accountDS.read();
					   
		//Close Modal
		wnd.close();
	   
		//Clear data
		clear_account();
	   
		status.text("").addClass("valid");	  
   } else {
		status.text("Oops! សូមពិនិត្យឲ្យបានត្រឹមត្រូវម្ដងទៀត").addClass("invalid");
   }
});
	
});<!--End of document.ready-->



</script>