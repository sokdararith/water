<div class="widget widget-heading-simple widget-body-gray widget-employees">
			
		<!-- Widget Heading -->
		<!-- <div class="widget-head">
			<h4 class="heading glyphicons usd"><i></i>ទំព័រសន្និធិ</h4>
		</div> -->
		<!-- // Widget Heading END -->

		<?php $this->load->view('inventory/sidebar'); ?>
		
		<div class="widget-body padding-none">	
			<div class="row-fluid row-merge">
				<div class="span3 listWrapper" style="height: 730px;">
					<div class="innerAll">
						<form autocomplete="off" class="form-inline">
							<div class="widget-search separator bottom">
								<button type="button" class="btn btn-default pull-right" id="search"><i class="icon-search"></i></button>
								<div class="overflow-hidden">
									<input type="search" value="" placeholder="ស្វែងរក" id="searchField">
								</div>
							</div>
							<div class="select2-container" style="width: 100%;">
								<div class="overflow-hidden">
									<select name="" id="searchOptions" style="width: 100%;" tabindex="-1">
										<option value="code">លេខកូដ</option>
						                <option value="name">ឈ្មោះ</option>
									</select>
								</div>
							</div>
							<!-- <div class="select2-container" id="s2id_autogen2" style="width: 100%;">
								<a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
									<span>Design</span><abbr class="select2-search-choice-close" style="display:none;"></abbr>   
									<div><b></b></div></a><input class="select2-focusser select2-offscreen" type="text"></div>
									<select style="width: 100%;" class="select2-offscreen" tabindex="-1">
						               <optgroup label="Department">
						                   <option value="design">Design</option>
						                   <option value="development">Development</option>
						               </optgroup>
									</select> -->
						</form>
					</div>
					<span class="results"></span>
					<ul class="list unstyled" id="items" style="height: 510px;"></ul>
				</div>
				<div class="span9 detailsWrapper">
					<div class="innerLR">
						<div class="navbar">
							<div class="navbar-inner">
								<ul class="nav">
									<li><a href="#"><i class="icon-home"></i></a></li>
							        <li>
							            <a href="#/new">
							            	បង្កើតថ្មី
							            </a>
							        </li>
							        <li class="<?php if($this->uri->segment(2) == "journal") { echo "active"; } ?>">
							            <a href="#">
							            	របាយការណ៍
							            </a>
							        </li>
							        <li class="<?php if($this->uri->segment(2) == "journal") { echo "active"; } ?>">
							            <a href="<?php echo base_url('report/vendor_aging_report'); ?>/">
							            	ផ្ទៀងផ្ទាត់និងកែតំរូវ
							            </a>
							        </li>
								</ul>
							</div>
						</div>
					</div>	
					<div class="innerAll">
						<div id="application"></div>
					</div>
					
				</div>
			</div>	
		</div>
</div>
<script id="asideTmpl" type="text/x-kendo-template">
	<li class="">
		<div class="media innerAll">
			<div class="media-object pull-left thumb hidden-phone"><img data-src="holder.js/51x51/dark" alt="51x51" style="width: 51px; height: 51px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADMAAAAzCAYAAAA6oTAqAAACAUlEQVRoQ+2Yv8upcRjGrxdFDEZKBmWxSIlFIgmRwSbl/6MUNkWUwSgZDAYxKEQMisGP0/c76NTRebl17t5O91PP4nku131dn++9PF+JROKO/+T6kjA/lKSQ+aFgIGSEDEMDcswYSiZZCBlSbQwiIcNQMslCyJBqYxAJGYaSSRZChlQbg0jIMJRMsiCRsVqt8Pv9uN1uMJlMWC6XWCwWeoBwOIzD4YDpdPp0oE+03yUkhXG73cjlcrhcLjrMZDLBcDhEJBKBx+PBfD5Hq9V66v2J9p+E8Xq9iEajqNfrOJ/P+nY6nUilUrBYLJjNZuh0Okgmk3A4HGg0GshkMjidTprYK9rvBn/2nEQmFovB5/M9/q/f72s66ioWi9jtdmi327DZbCiVSjAajfpIVqtVBAKBl7RsYex2uyaw2Wz0sMfjEc1m848w6odQKIRgMIjxeIzBYIB3tO8GIpHJ5/O4Xq/odruaxGq1euzI72TMZjPK5bLeK/V+pVJBPB5/SftuEPU+KYxa8nQ6rf3UkGp3ttvtg8x6vUav10M2m4XL5UKtVkOhUMB+v8doNHpJyxZGGRkMBr0T6ojd7+99e/9E+7eQJDKU1jg0EoajZYqHkKG0xqERMhwtUzyEDKU1Do2Q4WiZ4iFkKK1xaIQMR8sUDyFDaY1DI2Q4WqZ4CBlKaxyaXyM+XIKj6S59AAAAAElFTkSuQmCC"></div>
			<div class="media-body">
				<span class="strong">#=name#</span>
				<span class="muted"><i class="icon-shopping-cart"></i> #=kendo.toString(parseFloat(cost), 'c')#</span>
				<span class="muted"><i class="icon-dollar"></i> &nbsp;#=kendo.toString(parseFloat(price), 'c')#</span>
				
			</div>
		</div>
	</li>
</script>
<script type="text/x-kendo-template" id="layoutView">
	<div id="pre_content"><a href="#/edit" class="btn" data-bind="enabled: isEditable"><i class="icon-edit"></i> Edit</a></div>
	<div id="content"></div>
</script>

<script type="text/x-kendo-template" id="itemView">
	<div id="detail">
		<table class="table">
			<tr>
				<td>SKU:</td><td><span data-bind="text: current.item_sku"></span></td>
				<td>ឈ្មេាះ</td><td><span data-bind="text: current.name"></span></td>
			</tr>
			<tr>
				<td>តំលៃ</td><td><span data-bind="text: current.cost"></span></td>
				<td>ពិព៌ណាទិញ</td><td><span data-bind="text: current.purchase_description"></span></td>
			</tr>
			<tr>
				<td>តំលៃ</td><td><span data-bind="text: current.price" data-format="{0: 'c'}"></span></td>
				<td>ពិព៌ណាលក់</td><td><span data-bind="text: current.sale_description"></span></td>
			</tr>
			<tr>
				<td>ប្រភេទ</td><td><span data-bind="text: current.type_name.name"></span></td>
				<td>Account</td><td><span data-bind="text: current.account_name.code"></span>-<span data-bind="text: current.account_name.name"></span></td>
			</tr>
			<tr>
				<td></td><td></td>
				<td>Account</td><td><span data-bind="text: current.income_account.code"></span>-<span data-bind="text: current.income_account.name"></span></td>
			</tr>
			<tr>
				<td></td><td></td>
				<td>Account</td><td><span data-bind="text: current.cogs_account.code"></span>-<span data-bind="text: current.cogs_account.name"></span></td>
			</tr>
		</table>
		<div id="itemList" data-role="grid" 
						   data-bind="source: itemRecords"
						   data-pageable="true"
						   data-editable="ture"
						   data-selectable="true"
						   data-columns="[
						   		{title: 'Description', field: 'description'},
						   		{title: 'Quanity', field: 'quantity'},
						   		{title: 'Cost', field: 'cost'}
						   ]"></div>
	</div>
	<div id="report"></div>
</script>
<script type="text/x-kendo-template" id="itemEditView">
	<div id="newForm" data-role="validator">
		<label for="sku">SKU</label>
		<input type="text" name="sku" data-bind="value: sku" required validationMessage="Please provide the stock keeping unit number">
		<span class="k-invalid-msg" data-for="search"></span>

		<label for="name">Name</label>
		<input type="text" name="name" data-bind="value: name" required validationMessage="Please provide name">
		<span class="k-invalid-msg" data-for="name"></span>

		<label for="measure">Unit of Measure</label>
		<input type="text" name="measure" data-role="combobox" 
										  data-text-field="type" 
										  data-value-field="id" 
										  data-bind="source: measures, value: measure_id" required validationMessage="Please provide measurement">
		<span class="k-invalid-msg" data-for="measure"></span>

		<label for="cost">Cost</label>
		<input type="text" name="cost" data-role="numerictextbox" data-bind="value: cost" required validationMessage="Please provide cost">
		<span class="k-invalid-msg" data-for="cost"></span>

		<label for="price">price</label>
		<input type="text" name="price" data-role="numerictextbox" data-bind="value: price" required validationMessage="Please provide price">
		<span class="k-invalid-msg" data-for="price"></span>

		<label for="sale_descript">Sale Description</label>
		<input type="text" name="sale_descript" data-bind="value: sale_descript" required validationMessage="Please provide sale Description">
		<span class="k-invalid-msg" data-for="sale_descript"></span>

		<label for="purchase_descript">Purchase Description</label>
		<input type="text" name="purchase_descript" data-bind="value: purchase_descript" required validationMessage="Please provide Purchase Description">
		<span class="k-invalid-msg" data-for="purchase_descript"></span>

		<label for="type">Type</label>
		<input type="text" name="type" data-role="combobox" 
									   data-text-field="name" 
									   data-value-field="id" 
									   data-bind="source: types, value: type" required validationMessage="Please provide type">
		<span class="k-invalid-msg" data-for="type"></span>

		<label for="account">General Account</label>
		<input type="text" name="account" data-role="combobox" 
										  data-text-field="name" 
										  data-value-field="id" 
										  data-bind="source: accounts, value: account" required validationMessage="Please provide account">
		<span class="k-invalid-msg" data-for="account"></span>

		<label for="cogs">Cost of Goods Sold</label>
		<input type="text" name="cogs" data-role="combobox" 
									   data-text-field="name" 
									   data-value-field="id" 
									   data-bind="source: accounts, value: cogs_account" required validationMessage="Please provide cost of goods sold">
		<span class="k-invalid-msg" data-for="cogs"></span>

		<label for="income_account">Income Account</label>
		<input type="text" name="income_account" data-role="combobox" 
												 data-text-field="name" 
												 data-value-field="id" 
												 data-bind="source: accounts, value: income_account" required validationMessage="Please provide income account">
		<span class="k-invalid-msg" data-for="income_account"></span>

		<label for="status">Status</label>
		<input type="checkbox" name="status" data-bind="checked: status">
		<span class="k-invalid-msg" data-for="status"></span><br>
		<button class="btn" data-bind="click: update">Update</button>
	</div>
</script>
<script type="text/x-kendo-template" id="itemNewView">
	<div id="newForm" data-role="validator">
		<label for="sku">SKU</label>
		<input type="text" name="sku" data-bind="value: sku" required validationMessage="Please provide the stock keeping unit number">
		<span class="k-invalid-msg" data-for="search"></span>

		<label for="name">Name</label>
		<input type="text" name="name" data-bind="value: name" required validationMessage="Please provide name">
		<span class="k-invalid-msg" data-for="name"></span>

		<label for="measure">Unit of Measure</label>
		<input type="text" name="measure" data-role="combobox" 
										  data-text-field="type" 
										  data-value-field="id" 
										  data-bind="source: measures, value: measure_id" required validationMessage="Please provide measurement">
		<span class="k-invalid-msg" data-for="measure"></span>

		<label for="cost">Cost</label>
		<input type="text" name="cost" data-role="numerictextbox" data-bind="value: cost" required validationMessage="Please provide cost">
		<span class="k-invalid-msg" data-for="cost"></span>

		<label for="price">price</label>
		<input type="text" name="price" data-role="numerictextbox" data-bind="value: price" required validationMessage="Please provide price">
		<span class="k-invalid-msg" data-for="price"></span>

		<label for="sale_descript">Sale Description</label>
		<input type="text" name="sale_descript" data-bind="value: sale_descript" required validationMessage="Please provide sale Description">
		<span class="k-invalid-msg" data-for="sale_descript"></span>

		<label for="purchase_descript">Purchase Description</label>
		<input type="text" name="purchase_descript" data-bind="value: purchase_descript" required validationMessage="Please provide Purchase Description">
		<span class="k-invalid-msg" data-for="purchase_descript"></span>

		<label for="type">Type</label>
		<input type="text" name="type" data-role="combobox" 
									   data-text-field="name" 
									   data-value-field="id" 
									   data-bind="source: types, value: type" required validationMessage="Please provide type">
		<span class="k-invalid-msg" data-for="type"></span>

		<label for="account">General Account</label>
		<input type="text" name="account" data-role="combobox" 
										  data-text-field="name" 
										  data-value-field="id" 
										  data-bind="source: accounts, value: account" required validationMessage="Please provide account">
		<span class="k-invalid-msg" data-for="account"></span>

		<label for="cogs">Cost of Goods Sold</label>
		<input type="text" name="cogs" data-role="combobox" 
									   data-text-field="name" 
									   data-value-field="id" 
									   data-bind="source: accounts, value: cogs_account">
		<span class="k-invalid-msg" data-for="cogs"></span>

		<label for="income_account">Income Account</label>
		<input type="text" name="income_account" data-role="combobox" 
												 data-text-field="name" 
												 data-value-field="id" 
												 data-bind="source: accounts, value: income_account">
		<span class="k-invalid-msg" data-for="income_account"></span>

		<label for="status">Status</label>
		<input type="checkbox" name="status" data-bind="checked: status">
		<span class="k-invalid-msg" data-for="status"></span><br>
		<button class="btn" data-bind="click: record">Record</button>
	</div>
</script>
<script type="text/x-kendo-template" id="itemDeleteView">
	kljlkj
</script>
<script>
var itemBaseUri = ARNY.baseUrl +"api/inventory_api/item";
var itemRecordBaseUri = ARNY.baseUrl +"api/inventory_api/item_Records";
var accountBaseUri = ARNY.baseUrl +"api/accounting_api/account";
var typeBaseUri = ARNY.baseUrl +"api/inventory_api/item_type";
var measureBaseUri = ARNY.baseUrl +"api/inventory_api/unit_measure";
//datasource
var itemsDS = new kendo.data.DataSource({
		transport: {
			read: {
				url : ARNY.baseUrl + "api/inventory_api/item",
				type: "GET",
				dataType: "json",
			},
			create: {
				url : ARNY.baseUrl + "api/inventory_api/item",
				type: "POST",
				dataType: "json"
			},
			update: {
				url : ARNY.baseUrl + "api/inventory_api/item",
				type: "PUT",
				dataType: "json"
			},	
			destroy: {
				url : ARNY.baseUrl + "api/inventory_api/item",
				type: "DELETE",
				dataType: "json"
			},
			
		 		
			parameterMap: function(data, operation) {
	            if (operation !== "read" && data.models) {
	                return {models: kendo.stringify(data.models)};
	            }
				
				return data;

	        }
		},
		batch: false,
		pageSize: 20,
		schema: {
				model: {
				id : "id"
			}		 
		},
		requestEnd: function(e) {
			if(e.type==="create") {
				itemModel.empty();
				alert("Created");
			} else if(e.type==="update") {
				alert("updated")
			}
		}		
	});	

var recordsDS = new kendo.data.DataSource({
	schema: {
		id: "id",
		data: "records",
		total: "total"
	},
	transport: {
		read: {
			url: itemRecordBaseUri,
			dataType: "json",
			type: "GET"
		},
		parameterMap: function(data, operation) {
			if(operation!=="read"||data.models) {
				return { models: data.models };
			}
			return data;
		}
	},
	serverFiltering: true,
	serverPaging: true,
	pageSize: 20
});	

var accountDS = new kendo.data.DataSource({
	schema: {
		id: "id"
	},
	transport: {
		read: {
			url: accountBaseUri,
			dataType: "json",
			type: "GET"
		},
		parameterMap: function(data, operation) {
			if(operation!=="read"||data.models) {
				return { models: data.models };
			}
			return data;
		}
	}
});	

var typeDS = new kendo.data.DataSource({
	schema: {
		id: "id"
	},
	transport: {
		read: {
			url: typeBaseUri,
			dataType: "json",
			type: "GET"
		},
		parameterMap: function(data, operation) {
			if(operation!=="read"||data.models) {
				return { models: data.models };
			}
			return data;
		}
	}
});

var measureDS = new kendo.data.DataSource({
	schema: {
		id: "id"
	},
	transport: {
		read: {
			url: measureBaseUri,
			dataType: "json",
			type: "GET"
		},
		parameterMap: function(data, operation) {
			if(operation!=="read"||data.models) {
				return { models: data.models };
			}
			return data;
		}
	}
});

//Model
var itemModel = kendo.observable({
	itemRecords 	: recordsDS,
	accounts 		: accountDS,
	types 			: typeDS,
	measures 		: measureDS,
	isEditable 		: false,
	setCurrent 		: function(id) {
		this.set("current", itemsDS.get(id));
	},
	sku 			: "",
	name 			: "",
	measure_id  	: "",
	cost 			: "",
	price 			: "",
	sale_descript   : "",
	purchase_descript: "",
	type 			: "",
	account 		: "",
	cogs_account 	: "",
	income_account 	: "",
	status 			: "",
	empty 			: function() {
		this.set("sku", "");
		this.set("name", "");
		this.set("measure_id", "");
		this.set("cost", "");
		this.set("price", "");
		this.set("type", "");this
		this.set("sale_descript", "");
		this.set("purchase_descript", "");
		this.set("account", "");
		this.set("income_account", "");
		this.set("cogs_account", "");
		this.set("status", "");
	},
	record 			: function(e) {
		var validator = $(e.currentTarget).parent();
		var validated = validator.kendoValidator().data("kendoValidator");
		if(validated.validate()){
			itemsDS.add({
				item_sku : this.get("sku"),
				name 	 : this.get("name"),
				unit_measure_id : this.get("measure_id"),
				cost 	 : this.get("cost"),
				price 	 : this.get("price"),
				item_type_id: this.get("type"),
				sale_description : this.get("sale_descript"),
				purchase_description: this.get("purchase_descript"),
				general_account_id : this.get("account"),
				income_account_id : this.get("income_account"),
				cogs_account_id : this.get("cogs_account"),
				status: this.get("status")
			});

			itemsDS.sync();
		}	
	},
	update 			: function(e) {
		var validator = $(e.currentTarget).parent();
		var validated = validator.kendoValidator().data("kendoValidator");
		if(validated.validate()){
			var model = itemsDS.get(this.get("current").id);
			model.set("item_sku", this.get("sku"));
			model.set("name", this.get("name"));
			model.set("unit_measure_id", this.get("measure_id"));
			model.set("cost", this.get("cost"));
			model.set("price", this.get("price"));
			model.set("item_type_id", this.get("type"));
			model.set("sale_description", this.get("sale_descript"));
			model.set("purchase_description", this.get("purchase_descript"));
			model.set("general_account_id", this.get("account"));
			model.set("income_account_id", this.get("income_account"));
			model.set("cogs_account_id", this.get("cogs_account"));
			model.set("status", this.get("status"));

			itemsDS.sync();
		}	
	}
});

var measurementModel = new kendo.observable({

});

//view
var layoutView 	= new kendo.Layout("layoutView", { model: itemModel });
var itemView 	= new kendo.View("itemView", { model: itemModel });
var itemNewView = new kendo.View("itemNewView", { model: itemModel });
var itemEditView= new kendo.View("itemEditView", { model: itemModel });
var itemDeleteView= new kendo.View("itemDeleteView", { model: itemModel });

var itemRouter = new kendo.Router({
	init: function(e) {
		layoutView.render("#application");
	}
});

 itemRouter.route("/item/:id", function(id){
 	layoutView.showIn("#content", itemView);
 	itemModel.setCurrent(id);
 });

itemRouter.route("/edit", function(){
	layoutView.showIn("#content", itemEditView);
	itemModel.set("sku", itemModel.get('current').item_sku);
	itemModel.set("name", itemModel.get('current').name);
	itemModel.set("measure_id", itemModel.get('current').unit_measure_id);
	itemModel.set("cost", itemModel.get('current').cost);
	itemModel.set("price", itemModel.get('current').price);
	itemModel.set("type", itemModel.get('current').item_type_id);
	itemModel.set("sale_descript", itemModel.get('current').sale_description);
	itemModel.set("purchase_descript", itemModel.get('current').purchase_description);
	itemModel.set("account", itemModel.get('current').general_account_id);
	itemModel.set("income_account", itemModel.get('current').income_account_id);
	itemModel.set("cogs_account", itemModel.get('current').cogs_account_id);
	itemModel.set("status", itemModel.get('current').status);
});

itemRouter.route("/new", function(){
	layoutView.showIn("#content", itemNewView);
	itemModel.empty();
});

itemRouter.route("/delete", function(){
	layoutView.showIn("#content", itemDeleteView);
});

$(function(){
	itemRouter.start();
	var itemGrid = $("#items").kendoListView({
		dataSource: itemsDS,
		template: kendo.template($("#asideTmpl").html()),
		selectable: true,
		change: function() {
			var uid = this.select().data('uid');
			var model = this.dataSource.getByUid(uid);
			recordsDS.filter({value: model.id});
			itemRouter.navigate("/item/"+model.id);
			itemModel.set("isEditable", true);
		}
	}).data("kendoListView");
});
</script>