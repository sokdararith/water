
	<div id="application"></div>

<script type="text/x-kendo-template" id="layoutTmpl">
	<h2 class="printTitle">ព័ត៌មានអំពីអតិថិជនជាអ្នកកាន់អាជ្ញាប័ណ្ណ</h2>
	<div id="app"></div>
</script>
<script type="text/x-kendo-template" id="indexTmpl">
	<a href="#/create" class="hidePrint"><?=$this->lang->line('button_create'); ?></a>
	<table class="table">
		<thead>
			<tr>
				<td>អាជ្ញាប័ណ្ណ</td>
				<td>ឈ្មោះអ្នកកាន់អាជ្ញាប័ណ្ណ</td>
				<td>លេខអតិថិជន</td>
				<td>ទីតាំង</td>
				<td>តង់ស្យុង</td>
				<td>បញ្ជីថ្លៃលក់</td>
				<td>ចំនួនភ្ជាប់</td>
				<td></td>
			</tr>
		</thead>
		<tbody data-role="listview" data-bind="source: licensees" data-template="listTmpl"></tbody>
	</table>
</script>
<script type="text/x-kendo-template" id="listTmpl">
	<tr>
		<td><span data-bind="text: license_no"></span></td>
		<td><span data-bind="text: licensee_name"></span></td>
		<td><span data-bind="text: customer.name"></span></td>
		<td><span data-bind="text: location"></span></td>
		<td><span data-bind="text: voltage"></span></td>
		<td><span data-bind="text: price"></span></td>
		<td><span data-bind="text: connection_no"></span></td>
		<td><a href="\\#/edit/#:id#"><i class="icon-edit"></i></a>&nbsp;<a href="\\#" onClick="destroy(#:id#)"><i class="icon-trash"></i></a></td>
	</tr>
</script>
<script type="text/x-kendo-template" id="createTmpl">
	<div id="createNew" data-role="validator">
		<label for="">អាជ្ញាប័ណ្ណ:</label>
		<input type="text" name="lincese" data-bind="value: license_no" required data-required-msg="Choose License Number">
		<label for="customer">Customer:</label>
		<input type="text" name="customer" data-bind="source: customers, value: customer_id" data-role="combobox" data-value-field="id" data-text-field="name">
		<label for="">ឈ្មោះអ្នកកាន់អាជ្ញាប័ណ្ណ:</label>
		<input type="text" name="lincese" data-bind="value: licensee_name">
		<label for="">Voltage:</label>
		<input type="text" name="voltage" data-bind="value: designated_voltage">
		<label for="">Price:</label>
		<input type="text" name="price" data-bind="value: price">
		<label for="">location:</label>
		<input type="text" name="location" data-bind="value: location">
		<label for="">number of connection:</label>
		<input type="text" name="connection_no" data-bind="value: connection_no" data-role="numerictextbox"><br>
		<button class="btn-primary" data-bind="click: save">Save</button>
		<button class="btn-primary" data-bind="click: cancel">Cancel</button>
	</div>
	
</script>
<script type="text/x-kendo-template" id="editTmpl">
	<label for="">អាជ្ញាប័ណ្ណ:</label>
	<input type="text" name="lincese" data-bind="value: license_no">
	<label for="customer">Customer:</label>
	<input type="text" name="customer" data-bind="source: customers, value: customer_id" data-role="combobox" data-value-field="id" data-text-field="name">
	<label for="">ឈ្មោះអ្នកកាន់អាជ្ញាប័ណ្ណ:</label>
	<input type="text" name="lincese" data-bind="value: licensee_name">
	<label for="">Voltage:</label>
	<input type="text" name="voltage" data-bind="value: designated_voltage">
	<label for="">Price:</label>
	<input type="text" name="price" data-bind="value: price">
	<label for="">location:</label>
	<input type="text" name="location" data-bind="value: location">
	<label for="">number of connection:</label>
	<input type="text" name="connection_no" data-bind="value: connection_no" data-role="numerictextbox"><br>
	<button class="btn-primary" data-bind="click: update">Save</button>
	<button class="btn-primary" data-bind="click: cancel">Cancel</button>
</script>
<script>
var id;
//datasource
var licensees = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/customer_api/resellers/",
			type: "GET",
			dataType: "json"
		},
		create: {
			url: ARNY.baseUrl + "api/customer_api/resellers/",
			type: "POST",
			dataType: "json"
		},
		update: {
			url: ARNY.baseUrl + "api/customer_api/resellers/",
			type: "PUT",
			dataType: "json"
		},
		destroy: {
			url: ARNY.baseUrl + "api/customer_api/resellers/",
			type: "DELETE",
			dataType: "json"
		},
		parameterMap : function(options, operation) {
			if( operation !== "read" && options.models ) {
				return { models: kendo.stringigy(options.models) };
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
var customers = new kendo.data.DataSource({
	transport: {
		read: {
			url: ARNY.baseUrl + "api/customer_api/customer/",
			type: "GET",
			dataType: "json"
		},
		parameterMap : function(options, operation) {
			if( operation !== "read" && options.models ) {
				return { models: kendo.stringigy(options.models) };
			}
			return options;
		}
	}
});
function destroy(id) {
	var model = licensees.get(id);
	var conformed_action = confirm("<?=$this->lang->line('message_confirm_delete'); ?>");
	if(conformed_action==true) {
		licensees.remove(model);
		licensees.sync();
	}
}
var licenseeModel = kendo.observable({
	customers: customers,
	licensees: licensees,
	license_no: "",
	licensee_name: "",
	customer: [],
	location: "",
	voltage: 0,
	price: 0.00,
	connection_no: 0,
	setCurrent: function(itemID){
		this.set("current", licensees.get(itemID));
		id = itemID;
	},
	save: function() {

		if( licenseeModel.get('license_no')===""  && licenseeModel.get('licensee_name')==="" ) {
			alert("Need license");
		} else {
			licensees.add({
				license_no: licenseeModel.get('license_no'),
				licensee_name: licenseeModel.get('licensee_name'),
				customer: licenseeModel.get('customer_id'),
				location: licenseeModel.get("location"),
				voltage: licenseeModel.get('designated_voltage'),
				price: licenseeModel.get('price'),
				connection_no: licenseeModel.get('connection_no')
			});
			licensees.sync();
			router.navigate("/");
		}
		
	},
	update: function() {
		var model = licensees.get(licenseeModel.get("id"));
		model.set("license_no",licenseeModel.get('license_no'));
		model.set("customer",licenseeModel.get('customer_id'));
		model.set("licensee_name",licenseeModel.get('licensee_name'));
		model.set("location",licenseeModel.get('location'));
		model.set("voltage",licenseeModel.get('designated_voltage'));
		model.set("price",licenseeModel.get('price'));
		model.set("connection_no",licenseeModel.get('connection_no'));
		licensees.sync();
		router.navigate("/");
		this.set("license_no", "");
		this.set("licensee_name", "");
		this.set("customer_id", "");
		this.set("designated_voltage", 0);
		this.set("price", 0.00);
		this.set("location", "");
		this.set("connection_no", 0);
	},
	cancel: function() {
		this.set("license_no", "");
		this.set("licensee_name", "");
		this.set("customer_id", "");
		this.set("designated_voltage", 0);
		this.set("price", 0.00);
		this.set("location", "");
		this.set("connection_no", 0);
		router.navigate("/");
	},
	destroy: function(id) {
		var model = licensees.get(id);
		var conformed_action = confirm("<?=$this->lang->line('button_create'); ?>");
		if(conformed_action) {
			licensees.remove(model);
			licensees.sync();
		}

	}
});
//view/layout
var layout 		= new kendo.Layout("#layoutTmpl");
var indexView 	= new kendo.View("#indexTmpl", { model: licenseeModel });
var createView 	= new kendo.View("#createTmpl", { model: licenseeModel });
var editView 	= new kendo.View("#editTmpl", { model: licenseeModel });

//declare router
var router = new kendo.Router({
	init: function() {
		layout.render("#application");
	}
});
//routing url
router.route("/", function(){
	layout.showIn("#app", indexView);
});

router.route("/edit/:id", function(itemID){
	layout.showIn("#app", editView);
	licensees.fetch(function(){
		licenseeModel.setCurrent(itemID);
		var model = licensees.get(itemID);
		licenseeModel.set("id", model.id);
		licenseeModel.set("customer", model.customer);
		licenseeModel.set("license_no", model.license_no);
		licenseeModel.set("licensee_name", model.licensee_name);
		licenseeModel.set("designated_voltage", model.designated_voltage);
		licenseeModel.set("location", model.location);
		licenseeModel.set("connection_no", model.connection_no);
		licenseeModel.set("customer_id", model.customer.id);
	});
	
})

router.route("/create", function(){
	layout.showIn("#app", createView);
}); 
$(function(){
	router.start();
});
</script>
<style scoped>
	input.k-input {
		width: 500px;
	}
</style>