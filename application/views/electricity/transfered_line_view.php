<div class="container">
	<div class="row">
		<div class="span2">
			<?php $this->load->view('electricity/sidebar_view'); ?>
		</div>
		<div class="span10">
			<div id="application"></div>
		</div>
	</div>
</div>
<script type="text/x-kendo-template" id="layout">
	<div>
		<a href="#">List</a></li>
		<a href="#/create"><?=$this->lang->line('button_create'); ?></a>
	</div>
	<div id="app"></div>
</script>
<script type="text/x-kendo-template" id="index">
	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th width="120">មធ្យោបាយចែកចាយ</th>
				<th>តង់ស្យុងផ្គត់ផ្គង់(kV)</th>
				<th>ចំនួនហ្វា</th>
				<th>ប្រវែងខ្សែ(សៀគ្វីម៉ែត្រ)</th>
				<th>ថ្ងៃចាប់ផ្ដើមប្រើ</th>
				<th>ថ្ងៃឈប់ប្រើ</th>
				<th width="35"></th>
			</tr>
		</thead>
		<tbody data-role="listview" data-bind="source: lines" data-template="list">
		</tbody>
	</table>
</script>
<script type="text/x-kendo-template" id="list">
	<tr>
		<td><span data-bind="text: line"></span></td>
		<td><span data-bind="text: voltage"></span> kV</td>
		<td><span data-bind="text: phases"></span></td>
		<td><span data-bind="text: line_length"></span></td>
		<td><span data-bind="text: date_using"></span></td>
		<td><span data-bind="text: date_stopped"></span></td>
		<td>
			<a href="\\#/edit/#:id#"><i class="icon-edit"></i></a>
			<a href="\\#" data-bind="click: del" id="#:id#"><i class="icon-trash"></i></a>
		</td>
	</tr>
</script>
<script type="text/x-kendo-template" id="create">
	<div id="createForm" style="margin-top: 20px;">
		<label for="method">មធ្យោបាយចែកចាយ៖</label>
		<input type="text" data-role="dropdownlist" data-bind="source: line_types, value: method" data-text-field="type" data-value-field="type">
		<label for="voltage">តង់ស្យុងផ្គត់ផ្គង់(kV)៖</label>
		<input type="text" data-bind="value: voltage" data-role="numerictextbox">
		<label for="phase">ចំនួនហ្វា៖</label>
		<input type="text"  data-role="combobox" data-bind="source: phases, value: phase" data-text-field="phase" data-value-field="phase">
		<label for="length">ប្រវែងខ្សែ(សៀគ្វីម៉ែត្រ)៖</label>
		<input type="text" data-bind="value: length" data-role="numerictextbox">
		<label for="date_using">ថ្ងៃចាប់ផ្ដើមប្រើ៖</label>
		<input type="text" data-bind="value: date_using" data-role="datepicker">
		<label for="date_stopped">ថ្ងៃឈប់ប្រើ៖</label>
		<input type="text" data-bind="value: date_stopped" data-role="datepicker">
		<div>
			<button data-bind="click: create"><?=$this->lang->line('button_create'); ?></button>
			<button data-bind="click: cancel"><?=$this->lang->line('button_cancel'); ?></button>
		</div>
	</div>
</script>
<script type="text/x-kendo-template" id="edit">
	<div id="editForm" style="margin-top: 20px;">
		<label for="method">មធ្យោបាយចែកចាយ៖</label>
		<input type="text" data-role="dropdownlist" data-bind="source: line_types, value: method" data-text-field="type" data-value-field="type">
		<label for="voltage">តង់ស្យុងផ្គត់ផ្គង់(kV)៖</label>
		<input type="text" data-bind="value: voltage" data-role="numerictextbox">
		<label for="phase">ចំនួនហ្វា៖</label>
		<input type="text"  data-role="combobox" data-bind="source: phases, value: phase" data-text-field="phase" data-value-field="phase">
		<label for="length">ប្រវែងខ្សែ(សៀគ្វីម៉ែត្រ)៖</label>
		<input type="text" data-bind="value: length" data-role="numerictextbox">
		<label for="date_using">ថ្ងៃចាប់ផ្ដើមប្រើ៖</label>
		<input type="text" data-bind="value: date_using" data-role="datepicker">
		<label for="date_stopped">ថ្ងៃឈប់ប្រើ៖</label>
		<input type="text" data-bind="value: date_stopped" data-role="datepicker"><br>
		<div>
			<button data-bind="click: update"><?=$this->lang->line('button_update'); ?></button>
			<button data-bind="click: cancel">Cancel</button>
		</div>
	</div>
</script>

<script>	
	var distributionDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricities/distributions/",
				type: "GET",
				dataType: "json"
			},
			create: {
				url: ARNY.baseUrl + "api/electricities/distributions/",
				type: "POST",
				dataType: "json"
			},
			update: {
				url: ARNY.baseUrl + "api/electricities/distributions/",
				type: "PUT",
				dataType: "json"
			},
			destroy: {
				url: ARNY.baseUrl + "api/electricities/distributions/",
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
	//viewmodels
	var line = kendo.observable({
		lines : distributionDS,
		line_types : [
			{ id: 1, type: "ខ្សែបណ្ដាញតង់ស្យុងទាប់" },
			{ id: 2, type: "ខ្សែបណ្ដាញតង់ស្យុងមធ្យម" },
			{ id: 3, type: "ខ្សែបណ្ដាញតង់ស្យុងខ្ពស់" },
			{ id: 4, type: "ខ្សែបណ្ដាញមិនទាន់ស្រប តាមស្តង់ដាបច្ចេកទេស" }
		],
		phases  : [
			{id: 1, phase: 1},
			{id: 2, phase: 3}
		],
		setCurrent: function(itemID) {
			this.set("current", distributionDS.get(itemID));
			this.set("method", this.get('current').line);
			this.set("voltage", this.get('current').voltage);
			this.set("phase", this.get('current').phases);
			this.set("length", this.get('current').line_length);
			this.set("date_using", this.get('current').date_using);
			this.set("date_stopped", this.get('current').date_stopped);

		},
		method: "ខ្សែបណ្ដាញតង់ស្យុងទាប់",
		voltage: "0",
		phase: 1,
		length: "0",
		date_using: "",
		date_stopped: "",
		create: function() {
			distributionDS.add({ 
				company_id: "<?php echo $this->session->userdata('company_id'); ?>",
				line: this.get("method"),
				voltage: this.get("voltage"),
				phases: this.get("phase"),
				line_length: this.get('length'),
				date_using: kendo.toString(this.get("date_using"), 'yyyy-MM-dd'),
				date_stopped: kendo.toString(this.get("date_stopped"), 'yyyy-MM-dd') 
			});
			distributionDS.sync();
			router.navigate("/");
		},
		update: function() {
			var model = distributionDS.get(this.get("id"));

			model.set("line", this.get("method"));
			model.set("voltage", this.get("voltage"));
			model.set("phases", this.get("phase"));
			model.set("line_length", this.get("line_length"));
			model.set("date_using", kendo.toString(this.get("date_using"), 'yyyy-MM-dd'));
			model.set("date_stopped", kendo.toString(this.get("date_stopped"), 'yyyy-MM-dd'));
			
			distributionDS.sync();
			router.navigate("/");
		},
		del: function(item) {
			var id = item.currentTarget.id
			var model = distributionDS.get(id);
			distributionDS.remove(model);
			distributionDS.sync();
		},
		cancel : function() {
			router.navigate("/");
			this.set("method", "ខ្សែបណ្ដាញតង់ស្យុងទាប់");
			this.set("phase", 1);
			this.set("length", 0.00);
			this.set("voltage", 0);
			this.set("date_using", "");
			this.set("date_stopped", "");
		}
	});

	//layout/view
	var layout 	= new kendo.Layout("#layout");
	var index  	= new kendo.View("#index", { model: line });
	var edit  	= new kendo.View("#edit", { model: line });
	var create 	= new kendo.View("#create", { model: line });

	var router = new kendo.Router({
		init: function() {
			layout.render("#application");
		}
	});
	router.route("/", function(){
		layout.showIn("#app", index);
		line.set("method", "ខ្សែបណ្ដាញតង់ស្យុងទាប់");
		line.set("phase", 1);
		line.set("length", 0.00);
		line.set("voltage", 0);
		line.set("date_using", "");
		line.set("date_stopped", "");
	});
	router.route("/create", function(){
		layout.showIn("#app", create);
	});
	router.route("/edit/:id", function(itemID){
		layout.showIn("#app", edit);
		distributionDS.fetch(function() {
			line.setCurrent(itemID);
			line.set("id", itemID);
		});
		
	});

	$(function (){
		router.start();
	});
</script>