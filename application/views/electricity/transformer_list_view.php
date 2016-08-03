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
				<th>លេខត្រងស្វូ</th>
				<th>អនុភាព</th>
				<th>ប្រភេទ</th>
				<th>ឈ្មោះ</th>
				<th>ប្រភព</th>
				<th>ចំនួន</th>
				<th>ផ្សេងៗ</th>
				<th width="35"></th>
			</tr>
		</thead>
		<tbody data-role="listview" data-bind="source: lines" data-template="list">
		</tbody>
	</table>
</script>
<script type="text/x-kendo-template" id="list">
	<tr class="info">
		<td><strong>#=transformerNumber#</strong></td>
		<td>#=capacity#</td>
		<td></td>
		<td>#=brand#</td>
		<td></td>
		<td></td>
		<td>#=location#</td>
		<td></td>
	</tr>
	#for(var i=0; i< attributes.length; i++) { #
	<tr>
		<td>&nbsp;&nbsp;&nbsp;#=attributes[i].discription#</td>
		<td>#=attributes[i].capacity#</td>
		<td>#=attributes[i].type#</td>
		<td></td>
		<td></td>
		<td>#=attributes[i].unit#</td>
		<td></td>
		<td>
			<a href="\\#/edit/#:id#"><i class="icon-edit"></i></a>
			<a href="\\#" data-bind="click: del" id="#:id#"><i class="icon-trash"></i></a>
		</td>
	</tr>
	# } #
</script>
<script type="text/x-kendo-template" id="create">
	<div id="createForm" style="margin-top: 20px;">
		<label for="transformer_number">លេខត្រងស្វូ៖</label>
		<input type="text"  data-bind="value: transformer_number">
		<label for="latitute">រយ:បណ្ដោយ៖</label>
		<input type="text" data-bind="value: latitute">
		<label for="longtitute">រយ:ទទឹង៖</label>
		<input type="text" data-bind="value: longtitute">
		<label for="capacity">កំលាំង៖</label>
		<input type="text" data-bind="value: capacity">
		
		<div>
			<button data-bind="click: create"><?=$this->lang->line('button_create'); ?></button>
			<button data-bind="click: cancel"><?=$this->lang->line('button_cancel'); ?></button>
		</div>
	</div>
</script>
<script type="text/x-kendo-template" id="edit">
	<div id="editForm" style="margin-top: 20px;">
		<label for="transformer_number">លេខត្រងស្វូ៖</label>
		<input type="text"  data-bind="value: transformer_number">
		<label for="latitute">រយ:បណ្ដោយ៖</label>
		<input type="text" data-bind="value: latitute">
		<label for="longtitute">រយ:ទទឹង៖</label>
		<input type="text" data-bind="value: longtitute">
		<label for="capacity">កំលាំង៖</label>
		<input type="text" data-bind="value: capacity">
		
		<div>
			<button data-bind="click: update"><?=$this->lang->line('button_update'); ?></button>
			<button data-bind="click: cancel">Cancel</button>
		</div>
	</div>
</script>

<script>	
	var transformerDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricities/transformers/",
				type: "GET",
				dataType: "json"
			},
			create: {
				url: ARNY.baseUrl + "api/electricities/transformers/",
				type: "POST",
				dataType: "json"
			},
			update: {
				url: ARNY.baseUrl + "api/electricities/transformers/",
				type: "PUT",
				dataType: "json"
			},
			destroy: {
				url: ARNY.baseUrl + "api/electricities/transformers/",
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
		lines : transformerDS,
		setCurrent: function(itemID) {
			this.set("current", transformerDS.get(itemID));
			this.set("transformer_number", this.get('current').transformer_number);
			this.set("latitute", this.get('current').latitute);
			this.set("longtitute", this.get('current').longtitute);
			this.set("capacity", this.get('current').capacity);

		},
		transformer_number: "",
		latitute: "0",
		longtitute: "0",
		capacity: "0",
		create: function() {
			transformerDS.add({ 
				company_id: "<?php echo $this->session->userdata('company_id'); ?>",
				transformer_number: this.get("transformer_number"),
				latitute: this.get("latitute"),
				longtitute: this.get("longtitute"),
				capacity: this.get('capacity')
			});
			transformerDS.sync();
			router.navigate("/");
		},
		update: function() {
			var model = transformerDS.get(this.get("id"));

			model.set("transformer_number", this.get("transformer_number"));
			model.set("latitute", this.get("latitute"));
			model.set("longtitute", this.get("longtitute"));
			model.set("capacity", this.get("capacity"));
			
			transformerDS.sync();
			router.navigate("/");
		},
		del: function(item) {
			var id = item.currentTarget.id
			var model = transformerDS.get(id);
			transformerDS.remove(model);
			transformerDS.sync();
		},
		cancel : function() {
			router.navigate("/");
			this.set("transformer_number", "");
			this.set("latitute", 0.0000);
			this.set("longtitute", 0.0000);
			this.set("capacity", 0);
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
		transformerDS.fetch(function() {
			line.setCurrent(itemID);
			line.set("id", itemID);
		});
		
	});

	$(function (){
		router.start();
	});
</script>