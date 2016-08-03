
		<div class="span12">
			<?php $this->load->view('inventory/sidebar'); ?>
		</div>
		<div class="span12">
			<h1 style="text-align:center;">េសវាកម្ម សន្និធិ និងអចលនទ្រព្យ</h1>
			<br>
			
			<form class="navbar-search pull-left">
			
  			<br>
			<!-- Button to trigger add new modal -->
		
 		   	 <button id="openSaveNewWindow" class="btn btn-primary" type="button"><i class="icon-pencil icon-white"></i> បង្កើតឈ្មោះថ្មី</button>
			 <button id="openEditWindow" class="btn btn-primary" disabled="disabled" type="button"><i class="icon-edit icon-white"></i> កែប្រែ</button>
			<!-- Add New Modal and Edit Model -->			 	
  		 											 
					 <div id="window">
	  		 			
		 			 <div id="example" class="k-content">
	   		 				
			   <div id="item">
  				<table>
  					<tr align="top">
  						<td width="100" valign="top"><span>ជ្រើសរើសប្រភេទ:</span></td>
  						<td width="180" valign="top"><input type="text" id="item_type_id" name="item_type_id" data-bind="value: item_type_id"  placeholder="---ជ្រើសរើសយកមួយ---" required data-required-msg="ត្រូវការ ្របភេទ" ></td>			  
  				 				
  						<td width="80" valign="top"><span>លេខកូដ sku:</span><span style="color:red">*</span></td>
  						<td valign="top"><input type="text" id="item_sku" name="item_sku" data-bind="value: item_sku" class="span2" required validationMessage="ត្រូវការ លេខកូដ sku" ></td>
  						<td width="90" valign="top"><span>ឈ្មោះ:</span><span style="color:red">*</span></td>
  						<td width="200" valign="top"><input type="text" id="item_name" name="item_name" data-bind="value: name" class="span3" required validationMessage="ត្រូវការ ឈ្មោះ"  ></td>
  					</tr>
  					<tr>
  						<td valign="top"><span>គណនី:</span><span style="color:red">*</span></td>
  						<td valign="top"><input type="text" id="general_account_id" name="general_account_id" data-bind="value: general_account_id" placeholder="---ជ្រើសរើសយកមួយ---" required validationMessage="ត្រូវការ គណនី"  ></td>
						<td valign="top"><span>គណនី COGS/Expense:</span></td>
						<td valign="top"><input type="text" id="cogs_account_id" name="cogs_account_id" data-bind="value: cogs_account_id" placeholder="---ជ្រើសរើសយកមួយ---"  ></td>
						<td valign="top"><span>គណនី Income:</span></td>
						<td valign="top"><input type="text" id="income_account_id" name="income_account_id" data-bind="value: income_account_id" placeholder="---ជ្រើសរើសយកមួយ---"  ></td>
  					</tr>		
  					<tr>
  						<td><span id="unit_measure_title" >រង្វាស់:</span></td>
  						<td><span id="unit_measure_input" ><input type="text" id="unit_measure_id" name="unit_measure_id" data-bind="value: unit_measure_id"  placeholder="---ជ្រើសរើសយកមួយ---" ></span></td>
  						<td><span id="quantity_title" >ចំនួន:</span></td>
  						<td><span id="quantity_input" ><input type="number" id="quantity" name="quantity" data-bind="value: quantity" min="0" value="0" ></span></td>
  					</tr>	
  					
  					<tr>
  						<td><span>ពិពណ៏នាទិញចូល:</span></td>
  						<td><textarea id="purchase_description" name="purchase_description" rows="3" data-bind="value: purchase_description"></textarea></td>
  						<td><span>ពិពណ៏នាលក់ចេញ:</span></td>
  						<td><textarea id="sale_description" name="sale_description" rows="3" data-bind="value: sale_description"></textarea></td>
  					</tr>
  					<tr>
  						<td> ថ្លៃដើម:</td>
  						<td><input type="number" id="cost" name="cost" min="0" value="0" data-bind="value: cost"></td>
  						<td>តំលៃ:</td>
  						<td><input type="number" id="price" name="price" min="0" value="0" data-bind="value: price"></td>
						<td></td>
						<td > <label class="checkbox"><input type="checkbox" id="status" name="status" data-bind="checked: status"/> Active</label></td>
  					</tr>
					<tr>
						<td><span id="phase_title" style="display: none;">Phase:</span></td>
						<td><span id="phase_input" style="display: none;"><input type="text" id="phase" name="phase" data-bind="value: phase" placeholder="---ជ្រើសរើសយកមួយ---"  ></span></td>
						<td><span id="ampere_title" style="display: none;">Ampere:</span></td>
						<td><span id="ampere_input" style="display: none;"><input type="text" id="ampere" name="ampere" data-bind="value: ampere" placeholder="---ជ្រើសរើសយកមួយ---"  ></span></td>						
					</tr>
					<tr>
						<td><span id="fuse_title" style="display: none;">Fuse:</span></td>
						<td><span id="fuse_input" style="display: none;"><input type="text" id="fuse" name="fuse" data-bind="value: fuse" placeholder="---ជ្រើសរើសយកមួយ---"  ></span></td>
						<td><span id="voltage_title" style="display: none;">voltage:</span></td>
						<td><span id="voltage_input" style="display: none;"><input type="text" id="voltage" name="voltage" data-bind="value: voltage" placeholder="---ជ្រើសរើសយកមួយ---"  ></span></td>						
					</tr>
					<tr>
						<td></td>
						<td><button id="add" class="btn btn-primary" type="button" ><i class="icon-hdd icon-white"></i> កត់ត្រា</button><button id="edit" class="btn btn-primary" type="button" ><i class="icon-edit icon-white"></i> កែប្រែ</button><span> </span><button id="close" class="btn " type="submit" ><i class="icon-remove-circle icon-black"> </i> បិទ</button></td>						
					</tr> 
																 
  			   </table>
			   <div class="status" align="center"></div>
			   
		      </div>
			   </div>
		    </div>
		 	<!--End of Add New Modal and Edit Model -->
			   
  			<div id="grid"></div>			   
			</form>		
									
		</div>		


<script>

 $(document).ready(function() {
	var baseUrl = "<?php echo base_url(); ?>";
	var selected_item;
	var wopen;
	
	
 	//View model
 	var viewModel = kendo.observable({
		id					: 0,
 		item_sku			: "",		
 		name				: "",
 		item_type_id		: 1,		
 	    unit_measure_id		: 0, 	  
 		cost				: 0,
 		quantity			: 0,
 		price				: 0,
 		general_account_id	: 0,
 		cogs_account_id		: 0,
 		income_account_id	: 0,
 		purchase_description: "N/A",
 		sale_description	: "N/A",
		phase				: "",
		ampere				: "",
		fuse				: "",
		voltage				: "",
 		status				: true,		
 		account_name		: "",				
 		type_name			: "",
 		measure_type		: ""
	
 		
 	});  
 	kendo.bind($("#example"), viewModel);
	
	//set current culture to "km-KH" = khmer
	kendo.culture("km-KH");


	//Amount
	$("#price").kendoNumericTextBox({
		format: "c"
	});
	
	//Cost
	$("#cost").kendoNumericTextBox({
	    format: "c"
	});

	//Quantity
	$("#quantity").kendoNumericTextBox({
   
	});
	
	//Item type ddl
	  $("#item_type_id").kendoDropDownList({
		dataTextField: "name",
		dataValueField: "id",
		index: 0,
		dataSource: {					
			transport: {
				read: baseUrl + "api/inventory_api/item_type",
				type: "GET",
				dataType: "json"
			}

	
		},
		change: function(e) {
		        // handle event
				if (this.value() === '1')
				{
					//Show unit_measure and quantity
				
					$("#unit_measure_title").show();
					$("#unit_measure_input").show();
					$("#quantity_title").show();
					$("#quantity_input").show();
					
					$("#phase_title").hide();
					$("#phase_input").hide();
					$("#ampere_title").hide();
					$("#ampere_input").hide();
					$("#fuse_title").hide();
					$("#fuse_input").hide();
					$("#voltage_title").hide();
					$("#voltage_input").hide();
				}
				else if (this.value() === '5' || this.value() === '6'){
					$("#phase_title").show();
					$("#phase_input").show();
					$("#ampere_title").show();
					$("#ampere_input").show();
					$("#fuse_title").show();
					$("#fuse_input").show();
					$("#voltage_title").show();
					$("#voltage_input").show();
					
					//hide unit_measure and quantity
					$("#unit_measure_title").hide();
					$("#unit_measure_input").hide();
					$("#quantity_title").hide();
					$("#quantity_input").hide();
					
				} //Meter = 5 Breaker = 6
				else
				{
				
					//hide unit_measure and quantity
					$("#unit_measure_title").hide();
					$("#unit_measure_input").hide();
					$("#quantity_title").hide();
					$("#quantity_input").hide();
					
					$("#phase_title").hide();
					$("#phase_input").hide();
					$("#ampere_title").hide();
					$("#ampere_input").hide();
					$("#fuse_title").hide();
					$("#fuse_input").hide();
					$("#voltage_title").hide();
					$("#voltage_input").hide();
				
				}
			
		}
		 
	});

	//Unit Measure cmd
	 $("#unit_measure_id").kendoComboBox({
		dataTextField: "type",
		dataValueField: "id",
		suggest: true,
		dataSource: {					
			transport: {
				read: baseUrl + "api/inventory_api/unit_measure",
				type: "GET",
				dataType: "json"
			}
	
		}
		 
	});

	//Account General cmb
	 $("#general_account_id").kendoComboBox({
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

	//Account COGS/Expense cmb
	 $("#cogs_account_id").kendoComboBox({
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

	//Account Income cmb
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
	
	//Phase DDl
	 $("#phase").kendoComboBox({
		dataTextField: "phase",
		dataValueField: "id",
		suggest: true,
		dataSource: {					
			transport: {
				read: baseUrl + "api/electricity_unit_api/phase",
				type: "GET",
				dataType: "json"
			}
	
		}
		 
	});
	
	//Ampere DDl
	 $("#ampere").kendoComboBox({
	
		dataTextField: "ampere",
		dataValueField: "id",
		suggest: true,
		dataSource: {					
			transport: {
				read: baseUrl + "api/electricity_unit_api/ampere",
				type: "GET",
				dataType: "json"
			}
	
		}
		 
	});
	
	//fuse DDl
	 $("#fuse").kendoComboBox({
		
		dataTextField: "fuse",
		dataValueField: "id",
		suggest: true,
		dataSource: {					
			transport: {
				read: baseUrl + "api/electricity_unit_api/fuse",
				type: "GET",
				dataType: "json"
			}
	
		}
		 
	});
	
	//voltage DDl
	 $("#voltage").kendoComboBox({
	
		dataTextField: "voltage",
		dataValueField: "id",
		suggest: true,
		dataSource: {					
			transport: {
				read: baseUrl + "api/electricity_unit_api/voltage",
				type: "GET",
				dataType: "json"
			}
	
		}
		 
	});
	
	 $("#window").kendoWindow({
	     actions: ["Refresh", "Maximize", "Minimize", "Close"],
	     draggable: true,
	     modal: true,
	     resizable: true,
		 visible: false,
	     title: "បញ្ចូលពត័មាន",
	     width: "950",
		 refresh: onRefresh
	 });
	 
   	 		
  	//Validator	 
  	var validator = $("#item").kendoValidator().data("kendoValidator"),
  	message = $(".status");
 
	$("#openSaveNewWindow").click(function(){
		wopen = "new_item";
		onRefresh();
		$("#openEditWindow").attr('disabled', true);
		$("#edit").hide();
		$("#add").show();
	    var win = $("#window").data("kendoWindow");
	    win.center();
	    win.open();
	});

	$("#openEditWindow").click(function(){
	    var win = $("#window").data("kendoWindow");
		wopen = "edit_item";
		$("#edit").show();
		$("#add").hide();
	    win.center();
	    win.open();
	});

	function onRefresh($param){
		
		if (wopen == "new_item")
		{
		   	//set viewModel
			viewModel.set("id", 0);
			viewModel.set("item_sku", "");
			viewModel.set("name", "");
			viewModel.set("item_type_id", 1);
			viewModel.set("unit_measure_id",0);
			viewModel.set("cost", 0);
			viewModel.set("quantity", 0);
			viewModel.set("price", 0);
			viewModel.set("general_account_id", 0);
			viewModel.set("cogs_account_id", 0);
			viewModel.set("income_account_id", 0);
			viewModel.set("purchase_description", "");
			viewModel.set("sale_description", "");
			viewModel.set("phase", "");
			viewModel.set("ampere", "");
			viewModel.set("fuse", "");
			viewModel.set("voltage", "");
			
			if (viewModel.get("status") == "false"){
				viewModel.set("status", "true");
			}
				
			var type = $("#item_type_id").data("kendoDropDownList");
			var general_account_id = $("#general_account_id").data("kendoComboBox");
			var cogs_account_id = $("#cogs_account_id").data("kendoComboBox");
			var income_account_id = $("#income_account_id").data("kendoComboBox");
			var measure = $("#unit_measure_id").data("kendoComboBox");
			var price = $("#price").data("kendoNumericTextBox");
			var cost = $("#cost").data("kendoNumericTextBox");
			var quantity = $("#quantity").data("kendoNumericTextBox");
	
			// set the value of the combobox.
			type.value("1"); //looks for item which has value "1"
			general_account_id.text("");
			cogs_account_id.text("");
			income_account_id.text("");
			measure.text("");			
		}
		
		if (wopen == "edit_item")
		{
		   	//set viewModel
			viewModel.set("id", selected_item.id);
			viewModel.set("item_sku", selected_item.item_sku);
			viewModel.set("name", selected_item.name);
			viewModel.set("item_type_id", selected_item.item_type_id);
			viewModel.set("unit_measure_id", selected_item.unit_measure_id);
			viewModel.set("cost", selected_item.cost);
			viewModel.set("quantity", selected_item.quantity);
			viewModel.set("price", selected_item.price);
			viewModel.set("general_account_id", selected_item.general_account_id);
			viewModel.set("cogs_account_id", selected_item.cogs_account_id);
			viewModel.set("income_account_id", selected_item.income_account_id);
			viewModel.set("purchase_description", selected_item.purchase_description);
			viewModel.set("sale_description", selected_item.sale_description);
			viewModel.set("phase", selected_item.phase);
			viewModel.set("ampere", selected_item.ampere);
			viewModel.set("fuse", selected_item.fuse);
			viewModel.set("voltage", selected_item.voltage);
			viewModel.set("status", selected_item.status);
			
			
			if (selected_item.item_type_id === 1)
			{
				//Show unit_measure and quantity
				
				$("#unit_measure_title").show();
				$("#unit_measure_input").show();
				$("#quantity_title").show();
				$("#quantity_input").show();
					
				$("#phase_title").hide();
				$("#phase_input").hide();
				$("#ampere_title").hide();
				$("#ampere_input").hide();
				$("#fuse_title").hide();
				$("#fuse_input").hide();
				$("#voltage_title").hide();
				$("#voltage_input").hide();
			}
			else if (selected_item.item_type_id === 5 || selected_item.item_type_id === 6){
				$("#phase_title").show();
				$("#phase_input").show();
				$("#ampere_title").show();
				$("#ampere_input").show();
				$("#fuse_title").show();
				$("#fuse_input").show();
				$("#voltage_title").show();
				$("#voltage_input").show();
					
				//hide unit_measure and quantity
				$("#unit_measure_title").hide();
				$("#unit_measure_input").hide();
				$("#quantity_title").hide();
				$("#quantity_input").hide();
					
			} //Meter = 5 Breaker = 6
			else
			{
				
				//hide unit_measure and quantity
				$("#unit_measure_title").hide();
				$("#unit_measure_input").hide();
				$("#quantity_title").hide();
				$("#quantity_input").hide();
					
				$("#phase_title").hide();
				$("#phase_input").hide();
				$("#ampere_title").hide();
				$("#ampere_input").hide();
				$("#fuse_title").hide();
				$("#fuse_input").hide();
				$("#voltage_title").hide();
				$("#voltage_input").hide();
				
			}
		}
	   
		
	};
	
	//Save button click
    $("#add").click(function() {
	     this.preventDefault;		 
		 if (validator.validate()) {			 
			 add_new_item();
			 message.text("Your item has been added!").addClass("valid");
		 } else {
			 message.text("Oops! There is invalid data in the form.").addClass("invalid");
		 }
			
     });
	 
 	//Edit button click
     $("#edit").click(function() {
 	     this.preventDefault;		 
 		 if (validator.validate()) {			 
 			 edit_item();
 			 message.text("Your item has been modified!").addClass("valid");
 		 } else {
 			 message.text("Oops! There is invalid data in the form.").addClass("invalid");
 		 }
			
      });
	 
 	//Close button click
     $("#close").click(function() {
 	     		
	     var win = $("#window").data("kendoWindow");
	     win.close();
		
      });
 
	//Item datasource
	 var itemDS = new kendo.data.DataSource({
	 transport: {
		read: {
			url : baseUrl + "api/inventory_api/item",
			type: "GET",
			dataType: "json",
			data: {
				status: 'all'
			}
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
				phase					: {	 type: "string" },
				ampere					: {	 type: "string" },
				fuse					: {	 type: "string" },
				voltage					: {	 type: "string" },
				status					: {  type: "boolean"},
				account_name			: {   },
				type_name				: {   },
				measure_type			: {  type: "string"  }
							
								
			}
		}		 
	}
	
});

//Item grid
$("#grid").kendoGrid({		
	dataSource: itemDS,
	sortable: true,
	navigatable: true,
	selectable: true,
	
	columns: [		
		{ field: "item_sku", title: "លេខកូដ sku" , width: "80px"},		
		{ field: "name", title: "ឈ្មោះ" , width: "100px"},	
		{ field: "purchase_description", title: "ពិពណ៏នា", width: "150px" },	
		{ field: "item_type_id", title: "ប្រភេទ",  width: "120px", template: "#= type_name.name #" },
		{ field: "general_account_id", title: "គណនី", width: "150px", template: "#= account_name.name #"},	
		{ field: "quantity", title: "ចំនួន" , width: "50px"},
		{ field: "price", title: "តំលៃ" , width: "100px", format: "{0:c}" },
		{ field: "status", title: "ប្រើការ" , width: "50px" },
		{ command: [{ name: "destroy", text: "លុប", template:"<i class='icon-trash k-grid-delete'></i>" }], title: "&nbsp;", width: "100px" }],
		change: function(){
		
			var id = this.select().data().uid;
			selected_item = this.dataSource.getByUid(id);
			$("#openEditWindow").attr('disabled', false);
			   
		   	//set viewModel
			viewModel.set("id", selected_item.id);
			viewModel.set("item_sku", selected_item.item_sku);
			viewModel.set("name", selected_item.name);
			viewModel.set("item_type_id", selected_item.item_type_id);
			viewModel.set("unit_measure_id", selected_item.unit_measure_id);
			viewModel.set("cost", selected_item.cost);
			viewModel.set("quantity", selected_item.quantity);
			viewModel.set("price", selected_item.price);
			viewModel.set("general_account_id", selected_item.general_account_id);
			viewModel.set("cogs_account_id", selected_item.cogs_account_id);
			viewModel.set("income_account_id", selected_item.income_account_id);
			viewModel.set("purchase_description", selected_item.purchase_description);
			viewModel.set("sale_description", selected_item.sale_description);
			viewModel.set("phase", selected_item.phase);
			viewModel.set("ampere", selected_item.ampere);
			viewModel.set("fuse", selected_item.fuse);
			viewModel.set("voltage", selected_item.voltage);
			viewModel.set("status", selected_item.status);
			
			if (selected_item.item_type_id === 1)
			{
				//Show unit_measure and quantity
				
				$("#unit_measure_title").show();
				$("#unit_measure_input").show();
				$("#quantity_title").show();
				$("#quantity_input").show();
					
				$("#phase_title").hide();
				$("#phase_input").hide();
				$("#ampere_title").hide();
				$("#ampere_input").hide();
				$("#fuse_title").hide();
				$("#fuse_input").hide();
				$("#voltage_title").hide();
				$("#voltage_input").hide();
			}
			else if (selected_item.item_type_id === 5 || selected_item.item_type_id === 6){
				$("#phase_title").show();
				$("#phase_input").show();
				$("#ampere_title").show();
				$("#ampere_input").show();
				$("#fuse_title").show();
				$("#fuse_input").show();
				$("#voltage_title").show();
				$("#voltage_input").show();
					
				//hide unit_measure and quantity
				$("#unit_measure_title").hide();
				$("#unit_measure_input").hide();
				$("#quantity_title").hide();
				$("#quantity_input").hide();
					
			} //Meter = 5 Breaker = 6
			else
			{
				
				//hide unit_measure and quantity
				$("#unit_measure_title").hide();
				$("#unit_measure_input").hide();
				$("#quantity_title").hide();
				$("#quantity_input").hide();
					
				$("#phase_title").hide();
				$("#phase_input").hide();
				$("#ampere_title").hide();
				$("#ampere_input").hide();
				$("#fuse_title").hide();
				$("#fuse_input").hide();
				$("#voltage_title").hide();
				$("#voltage_input").hide();
				
			}
		},
		editable: "popup"
	
});

			   


//Add new item
function add_new_item() {
itemDS.add({
	item_sku				: viewModel.get("item_sku"),		
	name					: viewModel.get("name"),		
	item_type_id			: viewModel.get("item_type_id"),			
    unit_measure_id			: viewModel.get("unit_measure_id"),  
	cost					: viewModel.get("cost"),	
	quantity				: viewModel.get("quantity"),	
	price					: viewModel.get("price"),	
	general_account_id		: viewModel.get("general_account_id"),		
	cogs_account_id			: viewModel.get("cogs_account_id"),	
	income_account_id		: viewModel.get("income_account_id"),	
	purchase_description	: viewModel.get("purchase_description"),	
	sale_description		: viewModel.get("sale_description"),
	phase					: viewModel.set("phase", selected_item.phase),
	ampere					: viewModel.set("ampere", selected_item.ampere),
	fuse					: viewModel.set("fuse", selected_item.fuse),
	voltage					: viewModel.set("voltage", selected_item.voltage),	
	status					: viewModel.get("status"),	
	type_name				: "",
	account_name			: ""
});
itemDS.sync();

}

//Edit item
function edit_item(){
	var item = itemDS.get(selected_item.id);
	
	item.set("item_sku", viewModel.get("item_sku"));
	item.set("name", viewModel.get("name"));
	item.set("item_type_id", viewModel.get("item_type_id"));
	item.set("unit_measure_id", viewModel.get("unit_measure_id"));
	item.set("cost", viewModel.get("cost"));
	item.set("quantity", viewModel.get("quantity"));
	item.set("price", viewModel.get("price"));
	item.set("general_account_id", viewModel.get("general_account_id"));
	item.set("cogs_account_id", viewModel.get("cogs_account_id"));
	item.set("income_account_id", viewModel.get("income_account_id"));
	item.set("purchase_description", viewModel.get("purchase_description"));
	item.set("sale_description", viewModel.get("sale_description"));
	item.set("phase", viewModel.get("phase"));
	item.set("ampere", viewModel.get("ampere"));
	item.set("fuse", viewModel.get("fuse"));
	item.set("voltage", viewModel.get("voltage"));
	item.set("status", viewModel.get("status"));
	itemDS.sync(); 	
	
}


});

</script>

