<div class="widget widget-heading-simple widget-body-gray widget-employees">
			
		<!-- Widget Heading -->
		<!-- <div class="widget-head">
			<h4 class="heading glyphicons usd"><i></i>ទំព័រគណនេយ្យ</h4>
		</div> -->
		<!-- // Widget Heading END -->

		<?php $this->load->view("accounting/sidebar"); ?>
		
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
					<ul class="list unstyled" id="grid" style="height: 510px;"></ul>
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
<script id="layout" type="text/x-kendo-template">
	<div id="acctContent"></div>
</script>
<script id="accountInfo" type="text/x-kendo-template">
	<div id="info"></div>
	<div id="detail"></div>
</script>

<script id="dashboard" type="text/x-kendo-template">
	<div class="row-fluid">
		<div class="span5"></div>
		<div class="span4">Dashboard</div>
	</div>
	
</script>

<script id="acInfo" type="text/x-kendo-template">
	<div class="row-fluid">
		<div class="span6">
			<div style="text-align: right">
				<a href="#" data-bind="click: editBtn"><i class="icon-edit"></i></a> 
				<a href="#" data-bind="click: deleteBtn"><i class="icon-remove"></i></a>
			</div>
			
			<table class="table table-condensed">
				<tr>
					<td>កូដគណនី៖</td>		
					<td>
						<span data-bind="text: current.code"></span> (<span data-bind="text: current.type"></span>)
					</td>
				</tr>
				<tr>
					<td>គណនី៖</td>		
					<td>
						<span data-bind="text: current.name"></span>
					</td>
				</tr>
				<tr>
					<td>ព៌ណនា៖</td>
					<td>
						<span data-bind="text: current.description"></span><span data-bind="text: transactions.transactions"></span>
					</td>
				</tr>
			</table>
		</div>
		<div class="span6">
			<div class="innerAll padding-bottom-none-phone">
				<span class="widget-stats widget-stats-primary widget-stats-4">
					<span class="txt">សមតុល្យ</span>
					<span class="count" data-bind="text: currentBalance"></span>
					<span class="glyphicons refresh"><i></i></span>
					<div class="clearfix"></div>
					<i class="icon-play-circle"></i>
				</span>

			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<input type="text" data-role="datepicker" data-bind="value: startDate" style="width: 123px">-
			<input type="text" data-role="datepicker" data-bind="value: endDate" style="width: 123px">
			<button class="btn btn-warning" data-bind="click: searchTrans"><i class="icon-search"></i></button>
			<table class="table">	
				<tbody data-role="grid" data-bind="source: transactions, events: {change: change}" 
										data-columns="[
											{ title: 'លេខ \#', width: '70px', field: 'date' },
											{ title: 'ព៌ណនា', field: 'memo' },
											{ title: 'Balance', field: 'balance' },
										]"
										data-scrollable="true"
										data-pageable="{pageSize: 11, info: false}"
										data-height="418"
										data-selectable="true">
				</tbody>
			</table>
		</div>
			
		<div class="span6">
			<table class="table">
				<tbody data-role="grid" data-bind="source: selectedRow.detail" data-columns="[
											{ title: 'គណនី', width: '140px', field: 'account.name' },
											{ title: 'Debit', field: 'dr' },
											{ title: 'Credit', field: 'cr' }
										]">
				</tbody>
			</table>
		</div>
	</div>
</script>

<script id="createNew" type="text/x-kendo-template">
	<div class="well">
		<label for="code">Code:(ត្រូវការ)</label>
		<input type="text" data-bind="value: acCode"> <span data-bind="html: errorCode" style="color: red"></span>
		<label for="name">Name:(ត្រូវការ)</label>
		<input type="text" data-bind="value: acName"> <span data-bind="html: errorName" style="color: red"></span>
		<label for="type">Type:(ត្រូវការ)</label>
		<input type="text" data-role="dropdownlist" data-option="Select One" data-bind="source: types, value: acType" data-text-field="name" data-value-field="id" style="width: 220px;"> <span data-bind="html: errorType" style="color: red"></span>
		<label for="description">Description:</label>
		<input type="text" data-bind="value: acDescription">
		<label for="parent">គណនីមេ៖</label>
		<select name="account" id="account" data-role="combobox" data-bind="source: accounts, value: acParent" data-text-field="name" data-value-field="id" style="width: 220px;"></select>
		<span data-bind="text: acParent"></span>
		<button data-bind="click: add" class="btn">កត់ត្រា</button>
	</div>
</script>

<script id="editTmpl" type="text/x-kendo-template">
	<div class="well">
		<label for="code">Code:(ត្រូវការ)</label>
		<input type="text" data-bind="value: acCode"> <span data-bind="html: errorCode" style="color: red"></span>
		<label for="name">Name:(ត្រូវការ)</label>
		<input type="text" data-bind="value: acName"> <span data-bind="html: errorName" style="color: red"></span>
		<label for="type">Type:(ត្រូវការ)</label>
		<input type="text" data-role="dropdownlist" data-option="Select One" data-bind="source: types, value: acType" data-text-field="name" data-value-field="id" style="width: 220px;"> <span data-bind="html: errorType" style="color: red"></span>
		<label for="description">Description:</label>
		<input type="text" data-bind="value: acDescription">
		<label for="parent">គណនីមេ៖</label>
		<select name="account" id="account" data-role="dropdownlist" data-bind="source: accounts, value: acParent" data-text-field="name" data-value-field="id" style="width: 220px;"></select>
		<span data-bind="text: acParent"></span>
		<button data-bind="click: update" class="btn">កត់ត្រា</button>
	</div>
</script>

<script id="asideTmpl" type="text/x-kendo-template">
	<li class="">
		<div class="media innerAll">
			<div class="media-object pull-left thumb hidden-phone"><img data-src="holder.js/51x51/dark" alt="51x51" style="width: 51px; height: 51px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADMAAAAzCAYAAAA6oTAqAAACAUlEQVRoQ+2Yv8upcRjGrxdFDEZKBmWxSIlFIgmRwSbl/6MUNkWUwSgZDAYxKEQMisGP0/c76NTRebl17t5O91PP4nku131dn++9PF+JROKO/+T6kjA/lKSQ+aFgIGSEDEMDcswYSiZZCBlSbQwiIcNQMslCyJBqYxAJGYaSSRZChlQbg0jIMJRMsiCRsVqt8Pv9uN1uMJlMWC6XWCwWeoBwOIzD4YDpdPp0oE+03yUkhXG73cjlcrhcLjrMZDLBcDhEJBKBx+PBfD5Hq9V66v2J9p+E8Xq9iEajqNfrOJ/P+nY6nUilUrBYLJjNZuh0Okgmk3A4HGg0GshkMjidTprYK9rvBn/2nEQmFovB5/M9/q/f72s66ioWi9jtdmi327DZbCiVSjAajfpIVqtVBAKBl7RsYex2uyaw2Wz0sMfjEc1m848w6odQKIRgMIjxeIzBYIB3tO8GIpHJ5/O4Xq/odruaxGq1euzI72TMZjPK5bLeK/V+pVJBPB5/SftuEPU+KYxa8nQ6rf3UkGp3ttvtg8x6vUav10M2m4XL5UKtVkOhUMB+v8doNHpJyxZGGRkMBr0T6ojd7+99e/9E+7eQJDKU1jg0EoajZYqHkKG0xqERMhwtUzyEDKU1Do2Q4WiZ4iFkKK1xaIQMR8sUDyFDaY1DI2Q4WqZ4CBlKaxyaXyM+XIKj6S59AAAAAElFTkSuQmCC"></div>
			<div class="media-body">
				<span class="strong">#=name#</span>
				<span class="muted">លេខកូដ: #=code#</span>
				<span class="muted">ប្រភេទ: #=type#</span>
				
			</div>
		</div>
	</li>
</script>

<script>
	//Account datasource	
	var accountDS = new kendo.data.DataSource({
		transport: {
			read: {
				url : ARNY.baseUrl + "api/accounting_api/account",
				type: "GET",
				dataType: "json"
			},
			create: {
				url : ARNY.baseUrl + "api/accounting_api/account",
				type: "POST",
				dataType: "json"
			},
			update: {
				url : ARNY.baseUrl + "api/accounting_api/account",
				type: "PUT",
				dataType: "json"
			},
			destroy: {
				url : ARNY.baseUrl + "api/accounting_api/account",
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
		requestEnd: function(e) {
		  	if(e.type === "create" || e.type==="update") {
		  		accountModel.set("acCode", "");
				accountModel.set("acName", "");
				accountModel.set("acType", "");
				accountModel.set("acDescription", "");
				accountModel.set("acParent", "");
		  	}
		},
		schema: {
			model: {
				id : "id"
			}		
		}
	});	

	var transactionDS = new kendo.data.DataSource({
		transport: {
			read: {
				url : ARNY.baseUrl + "api/accounting_api/transaction_by",
				type: "GET",
				dataType: "json"
			},
			parameterMap: function(options, operation) {
				if (operation !== "read" && options.models) {
					return {models: kendo.stringify(options.models)};
				}
				if(operation === "read") {
					return { id : accountModel.current.id, 
							 limit: accountModel.get("limit"), 
							 offset: accountModel.get("offSet"),
							 endDate: accountModel.get("endDate"),
							 startDate: accountModel.get("startDate")
						   };
				}	
				return options;
			}
		},
		schema: {
		  	model: {
				id : "id"
		  	},
		  	data: 'results',
		  	total: function(data) {
		  		return data.total;
		  	}
		},
	  	serverFiltering: true,
	  	serverPaging: false,
	  	pageSize: 11
	});

	var typeDS = new kendo.data.DataSource({
		transport: {
			read: {
				url : ARNY.baseUrl + "api/account_types/account_type",
				type: "GET",
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

	var accountModel = kendo.observable({
		transactions 	: "",
		accounts 		: accountDS,
		types 			: typeDS,
		setCurrent 		: function(id) {
			this.set("current", accountDS.get(id));
		},
		currentBalance  : function() {
			return kendo.toString(parseFloat(this.current.balance), "c2");
		},
		selectedRow 	: null,
		acCode 			: "",
		acName 			: "",
		acType 			: "",
		acParent		: "",
		acDescription 	: "",
		validated 		: false,
		errorArray		: [],
		errorCode 		: "",
		errorName 		: "",
		errorType 		: "",
		currentPage 	: "",
		urlFragment 	: function() {
			//return window.location.hash;
			console.log(window.location.href+""+location.hash);
		},
		startDate		: function() {
			var date = new Date();
			var month = date.getMonth()+1;
			var year = date.getFullYear();
			return year+'-'+month+'-01';
		},
		endDate 		: function(){
			return new Date();
		},
		searchTrans 	: function() {
			transactionDS.fetch(function(){
				var data = this.data();
				accountModel.set("transactions", data);
				var d = this.total()/this.get("limit");
				var m = this.total()%this.get("limit");

				accountModel.set("total", this.total());
			});
		},
		prePage 		: function() {
			
		},
		nextPage 		: function() {},
		limit 			: 11,
		offSet 			: 0,
		page 			: 1,
		total 			: "",
		paging 			: function() {
			var d = this.get("total")/this.get("limit");
			var m = this.get("total")%this.get("limit");
			if(d < m) {
				return Math.floor((this.get("total")/this.get("limit"))) + 1;
			}
			
			//console.log(number);
		},
		pagination 		: function() {
			var pagable = '<div class="pagination"><ul>';
			for(var i=0; i < this.get("paging"); i++) {
				pagable += '<li class="active"><span>'+(i+1)+'</span></li>';
			}
			pagable += '<ul></div>'
			return pagable;
		},
		editBtn 		: function(e) {
			e.preventDefault();
			this.set("acCode", this.current.code);
			this.set("acName", this.current.name);
			this.set("acType", this.current.type_id);
			this.set("acDescription", this.current.description);
			this.set("acParent", this.current.parent.id);
			router.navigate("/edit", false);
		},
		deleteBtn		: function(e) {
			e.preventDefault();
			var model = accountDS.get(this.current.id);
			var ask = confirm("តើអ្នត្រូវការលុបគណនី " + model.name + " ម៉ែនទេ?");
			if(ask) {
				accountDS.remove(model);
				accountDS.sync();
			}
			
		},
		validate 		: function() {
			if(this.errorArray.length > 0) {
				this.errorArray.splice(0, this.errorArray.length);
				this.set("errorCode", "");
				this.set("errorName", "");
				this.set("errorType", "");
			}
			if(this.get("acCode") === "") {
				this.errorArray.push({error: 'errorCode', message: '<i class="icon-info-sign"></i> Must provide code'});
			}

			if(this.get("acName") === "") {
				this.errorArray.push({error: 'errorName', message: '<i class="icon-info-sign"></i> Must provide name'});
			}

			if(this.get("acType") === "") {
				this.errorArray.push({error: 'errorType', message: '<i class="icon-info-sign"></i> Must provide type'});
			}

			if(this.errorArray.length === 0) {
				return true;
			} else {
				for(var i=0; i < this.errorArray.length; i++) {
					this.set(this.errorArray[i].error, this.errorArray[i].message);
				}
				return false;
			}
		},
		change 			: function(e) {
			this.set("selectedRow", e.sender.dataItem(e.sender.select()));
		},
		add 			: function() {
			var validated = this.validate();

			if(validated === true) {
				accountDS.add({
					code: this.get("acCode"),
					name: this.get("acName"),
					account_type_id: this.get("acType"),
					description: this.get("acDescription"),
					parent_id: this.get("acParent")
				});
				accountDS.sync();
			}
		},
		update 			: function() {
			var validated = this.validate();

			if(validated === true) {
				var model = accountDS.get(this.current.id);
				model.set("code", this.get("acCode"));
				model.set("name", this.get("acName"));
				model.set("account_type_id", this.get("acType"));
				model.set("description", this.get("acDescription"));
				model.set("parent_id", this.get("acParent"));

				accountDS.sync();
			}
		}
 	});

	//view
	var layout 	= new kendo.Layout("#layout");
	var account = new kendo.Layout("#accountInfo");
	var dashboard= new kendo.View("#dashboard");
	var info 	= new kendo.View("#acInfo", {model:accountModel});
	var create 	= new kendo.View("#createNew", {model:accountModel});
	var edit 	= new kendo.View("#editTmpl", {model:accountModel});

	//router
	var router = new kendo.Router({
		init: function(e) {
			layout.render("#application");
		}
	});

	router.route("/", function(e){
		layout.showIn("#acctContent", dashboard);
	});

	router.route("/new", function(e){
		layout.showIn("#acctContent", create);
	});
	router.route("/edit", function(e){
		layout.showIn("#acctContent", edit);
		accountModel.set("")
	});

	router.route("/:id", function(id) {
		layout.showIn("#acctContent", account);
		account.showIn("#info", info);
		transactionDS.fetch(function(){
			var data = this.data();
			var total= this.total();
		
			accountModel.set("transactions", data);
			accountModel.set("total", total);			
		});		
	});

	router.route("/items", function(){
		console.log("items");
	});

	$(document).ready(function() {
		//Account grid
		router.start();
		var grid = $("#grid").kendoListView({
			dataSource: accountDS,	
			template: kendo.template($("#asideTmpl").html()),
			selectable: true,
			change: function() {
				var model = this.dataSource.getByUid(this.select().data('uid'));
				accountModel.setCurrent(model.id);
				if(accountModel.get("selectedRow")) {
					accountModel.get("selectedRow").set("detail", "");
				}
				if(accountModel.errorArray.length > 0) {
				accountModel.errorArray.splice(0, accountModel.errorArray.length);
				accountModel.set("errorCode", "");
				accountModel.set("errorName", "");
				accountModel.set("errorType", "");
			}
				router.navigate("/"+model.id);
				
			}
		}).data("kendoListView");

		function showDetail() {
			alert("hi");
		}
		$("#search").on("click", function(){
			var field = "";
			// if(transformerModel.get("filterBy") === "license") {
			// 	field = "license.name";
			// } else {
			// 	field = "transformerNumber";
			// }
			accountDS.filter({
				field: "name",
				operator: "contains",
				value: $("#searchField").val()
			});
		});

		$("#addnew").click(function(e){
			router.navigate('/new');
		});

	});<!--End of document.ready-->
</script>