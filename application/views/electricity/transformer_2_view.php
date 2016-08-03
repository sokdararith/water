<div class="widget widget-heading-simple widget-body-gray widget-employees">
			
		<!-- Widget Heading -->
		<!-- <div class="widget-head">
			<h4 class="heading glyphicons user"><i></i>ទំព័រអគ្គីសនី</h4>
		</div> -->
		<!-- // Widget Heading END -->

		<?php $this->load->view("electricity/sidebar"); ?>
		
		<div class="widget-body padding-none">	
			<div class="row-fluid row-merge">
				<div class="span3 listWrapper" style="height: 730px;">
					<div class="innerAll">
						<form autocomplete="off" class="form-inline">
							<div class="widget-search separator bottom">
								<button type="button" class="btn btn-default pull-right" id="search"><i class="icon-search"></i></button>
								<div class="overflow-hidden">
									<input type="search" value="" placeholder="ស្វែងរកត្រងស្វូ" id="searchField">
								</div>
							</div>
							<div class="select2-container" style="width: 100%;">
								<div class="overflow-hidden">
									<select name="" id="searchOptions" style="width: 100%;" tabindex="-1">
										<option value="class_id">Class</option>
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
					<ul class="list unstyled" id="transformers" style="height: 510px;"></ul>
				</div>
				<div class="span9 detailsWrapper">
					<div class="innerLR">
						<div class="navbar">
							<div class="navbar-inner">
								<ul class="nav">
									<li><a href="#/create">ថែមត្រង់ស្វូថ្មី</a></li>									
								</ul>
							</div>
						</div>
					</div>	
					<div class="innerAll" id="main-contents">
						<div id="application"></div>
					</div>
					
				</div>
			</div>	
		</div>
</div>
<script src='https://maps.googleapis.com/maps/api/js?sensor=false'></script>
<script src="<?php echo base_url(JS."kendo.map.js");?>"></script>
<script type="text/x-kendo-tmpl" id="marker-tmpl">
  <p>#:transformerNumber#</p>
</script>
<script id="transformerList" type="text/x-kendo-template">
	<li class="">
		<div class="media innerAll">
			<div class="media-object pull-left thumb hidden-phone"><img data-src="holder.js/51x51/dark" alt="51x51" style="width: 51px; height: 51px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADMAAAAzCAYAAAA6oTAqAAACAUlEQVRoQ+2Yv8upcRjGrxdFDEZKBmWxSIlFIgmRwSbl/6MUNkWUwSgZDAYxKEQMisGP0/c76NTRebl17t5O91PP4nku131dn++9PF+JROKO/+T6kjA/lKSQ+aFgIGSEDEMDcswYSiZZCBlSbQwiIcNQMslCyJBqYxAJGYaSSRZChlQbg0jIMJRMsiCRsVqt8Pv9uN1uMJlMWC6XWCwWeoBwOIzD4YDpdPp0oE+03yUkhXG73cjlcrhcLjrMZDLBcDhEJBKBx+PBfD5Hq9V66v2J9p+E8Xq9iEajqNfrOJ/P+nY6nUilUrBYLJjNZuh0Okgmk3A4HGg0GshkMjidTprYK9rvBn/2nEQmFovB5/M9/q/f72s66ioWi9jtdmi327DZbCiVSjAajfpIVqtVBAKBl7RsYex2uyaw2Wz0sMfjEc1m848w6odQKIRgMIjxeIzBYIB3tO8GIpHJ5/O4Xq/odruaxGq1euzI72TMZjPK5bLeK/V+pVJBPB5/SftuEPU+KYxa8nQ6rf3UkGp3ttvtg8x6vUav10M2m4XL5UKtVkOhUMB+v8doNHpJyxZGGRkMBr0T6ojd7+99e/9E+7eQJDKU1jg0EoajZYqHkKG0xqERMhwtUzyEDKU1Do2Q4WiZ4iFkKK1xaIQMR8sUDyFDaY1DI2Q4WqZ4CBlKaxyaXyM+XIKj6S59AAAAAElFTkSuQmCC"></div>
			<div class="media-body">
				<span class="strong">#=transformerNumber#</span>
				<span class="muted">#=license.name#</span>
				<span class="muted"></span>
				
			</div>
		</div>
	</li>
</script>

<script id="layout" type="text/x-kendo-template">
	<div class="menu" style="text-align: right; margin-bottom: 5px;">
			<div>
				<a class="btn" href="#"><i class="icon-home"></i></a>
				<button class="btn" data-bind="click: viewBtn, disabled: isDisabled"><i class="icon-eye-open"></i> របាយការណ៍ទិញថាមពល</button>
			  	<button class="btn" data-bind="click: updateBtn, disabled: isDisabled"><i class="icon-edit"></i> កែប្រែ</button>
			  	<button class="btn" data-bind="click: deleteBtn, disabled: isDisabled"><i class="icon-trash"></i> លុប</button>
			</div>
	</div>	
	<div id="info"></div>
	<div id="detail"></div>
</script>
<script id="blank" type="text/x-kendo-template">
	<div></div>
</script>
<script id="createView" type="text/x-kendo-template">
	<div class="well" id="create">
		<div class="row">
			<div class="span4">
				<label for="license">អាជ្ញាប័ណ្ណ៖ (ត្រូវការ)</label>
				<input type="text" id="license" name="license" data-role="dropdownlist" 
															   data-bind="source: classes, value: license" 
															   data-text-field="name" 
															   data-value-field="id" 
															   placeholder="Select One" 
															   style="width:220px;margin-bottom:11px;" required 
															   data-required-msg="YOu need this!">
				<label for="license">អ្នកផ្គត់ផ្គង់៖ (ត្រូវការ)</label>
				<input type="text" id="license" name="license" data-role="dropdownlist" 
															   data-bind="source: vendors, value: vendor" 
															   data-text-field="name" 
															   data-value-field="id" 
															   placeholder="Select One" 
															   style="width:220px;margin-bottom:11px;" required 
															   data-required-msg="YOu need this!">
				<label for="transformer">ឈ្មោះត្រងស្វូ៖ (ត្រូវការ)</label>
				<input type="text" data-bind="value: transformer">
				<label for="tranformerType">ប្រភេទ៖ (ត្រូវការ)</label>
				<input type="text" data-bind="value: transformerType">
				<label for="brand">ម៉ាក៖ (ត្រូវការ)</label>
				<input type="text" data-bind="value: brand">
			</div>
			<div class="span1"></div>
			<div class="span4">
				<label for="capacity">អនុភាព៖ (ត្រូវការ)</label>
				<input type="text" data-bind="value: capacity">
				<label for="location">ទីតាំង៖ (ត្រូវការ)</label>
				<input type="text" data-bind="value: location">
				<label for="latitute">រយះបណ្ដោយ៖</label>
				<input type="text" data-bind="value: latitute">
				<label for="longtitute">រយះទទឹង៖</label>
				<input type="text" data-bind="value: longtitute">
			</div>
		</div>
	</div>
	<div class="table" data-role="grid" data-bind="source: attributes.items" data-row-template="attributeList" 
		data-columns="[{title: 'ព៌ណនា៖'},{title: 'អនុភាព៖'},{title: 'ប្រភេទ៖'},{title: 'ចំនួន៖'}]">
	</div>
	<p></p>
	<button class="btn btn-primary" data-bind="click: record, visible: isCreating">Record</button>
	<button class="btn btn-primary" data-bind="click: update, invisible: isCreating">Update</button>&nbsp;
	<button class="btn" data-bind="click: reset">Reset</button>
	
</script>
<script id="attributeList" type="text/x-kendo-template">
	<tr>
		<td>#=discription#</td>
		<td><input type="text" data-bind="value: capacity" placeholder="50KVA" style="width: 140px;"></td>
		<td><input type="text" data-bind="value: type" style="width: 140px;"></td>
		<td><input type="text" data-bind="value: unit" style="width: 140px;"></td>
	</tr>
</script>
<script id="informationView" type="text/x-kendo-template">
	<div class="title">
		<div class="row-fluid">
			<div class="span4">
				<h4 class="text-primary">ត្រងស្វូ <i data-bind="text: current.transformerNumber"></i></h4>	
				<ul>
					<li>ម៉ាក <span data-bind="text: current.brand"></span></li>
					<li>ប្រភេទ <span data-bind="text: current.type"></span></li>
					<li>អនុភាព <span data-bind="text: current.capacity"></span> KVA</li>
					<li>តំបន់ <span data-bind="text: current.location"></span></li>
				</ul>
			</div>
			<div class="span8">
				<div class="row-fluid">
					<div class="span4">
						<h5 class="strong">Reports</h5>
						<a href="" class="btn btn-primary btn-small btn-block"><i class="icon-download-alt icon-fixed-width"></i> June</a>
						<a href="" class="btn btn-default btn-small btn-block"><i class="icon-download-alt icon-fixed-width"></i> May</a>
						<a href="" class="btn btn-default btn-small btn-block"><i class="icon-download-alt icon-fixed-width"></i> April</a>
						<div class="separator bottom"></div>
					</div>
					<div class="span7 offset1">
						<div class="chart" data-role="chart" data-bind="source:current.saleHistory"
											  data-legend="{position: 'bottom'}"
											  data-series="[
											  				{ type: 'line', field: 'usage', name: 'ការប្រើប្រាស់ប្រចាំខែ'},
											  				{ type: 'column', field: 'usage', name: 'ការប្រើប្រាស់ប្រចាំខែ'}
											  			   ]"
											  data-category-Axis="{field: 'month', labels: {rotation: 0}}"
											  data-value-Axis="{labels: {format: '0'}, 
											  					min:0, max: 1000, 
											  					majorUnit: 200,
											  					majorGridLines: { width: 1 }
											  					}"
											  data-tooltip="{visible: true, format: 'NO'}">
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>
</script>
<script id="detailView" type="text/x-kendo-template">
	<table class="table table-primary">
		<thead>
			<tr class="info">
				<th>ព៌ណនា</th>
				<th>អនុភាព</th>
				<th>ប្រភេទ</th>
				<th>ចំនួន</th>
			</tr>
		</thead>
		<tbody data-role="listview" data-bind="source: current.attributes" data-template="list">
		</tbody>
	</table>
</script>

<script type="text/x-kendo-template" id="list">
	<tr>
		<td>#=discription#</td>
		<td>#=capacity#</td>
		<td>#=type#</td>
		<td>#=unit#</td>
	</tr>
</script>

<script>
	var validation = $("createView").kendoValidator().data("kendoValidator");
	//1. Datasources
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

	var classDS = new kendo.data.DataSource({
    	transport: {
             read: {
             	url: ARNY.baseUrl + "api/accounting_api/class_dropdown",
             	type: "GET",
             	dataType: "json"
             }
       }
    });
    $.getJSON(ARNY.baseUrl + "api/accounting_api/class_dropdown", function(data) {
	 	$.each(data, function(key, val) {
	    	transformerModel.classes.push({id: val.id, name: val.name});
		});	
	});

	//2. Models
	var attributeModel = kendo.observable({
		items 			: [
				{ id: 0, discription: "Transformer Base", capacity: "", type: "", unit: "" },
				{ id: 0, discription: "Lightning Arrester", capacity: "", type: "", unit: "" },
				{ id: 0, discription: "MV Cable Connector", capacity: "", type: "", unit: "" },
				{ id: 0, discription: "Fuse Cut Out", capacity: "", type: "", unit: "" },
				{ id: 0, discription: "Support", capacity: "", type: "", unit: "" },
				{ id: 0, discription: "Current/Transformer Intensity", capacity: "", type: "", unit: "" },
				{ id: 0, discription: "Analog Meter", capacity: "", type: "", unit: "" },
				{ id: 0, discription: "BT Fuse", capacity: "", type: "", unit: "" },
				{ id: 0, discription: "PVC Sheath Cable", capacity: "", type: "", unit: "" },
				{ id: 0, discription: "Customer LV Wire 1", capacity: "", type: "", unit: "" },
				{ id: 0, discription: "Customer LV Wire 2", capacity: "", type: "", unit: "" },
				{ id: 0, discription: "Lightning Protective Cable", capacity: "", type: "", unit: "" },
				{ id: 0, discription: "Ground Wire", capacity: "", type: "", unit: "" },
				{ id: 0, discription: "Earth Rod", capacity: "", type: "", unit: "" },
				{ id: 0, discription: "Clam", capacity: "", type: "", unit: "" },
				{ id: 0, discription: "Distribution Box", capacity: "", type: "", unit: "" },
				{ id: 0, discription: "P.G Clam", capacity: "", type: "", unit: "" },
				{ id: 0, discription: "កូស Connector 1", capacity: "", type: "", unit: "" },
				{ id: 0, discription: "កូស Connector 2", capacity: "", type: "", unit: "" },
				{ id: 0, discription: "ទុយោ PVC", capacity: "", type: "", unit: "" }
		],
		reset 			: function(e) {
			for(var i=0; i < this.items.length; i++) {
				this.items[i].set("capacity", "");
				this.items[i].set("type", "");
				this.items[i].set("unit", "");
			}
			// if(this.items.length > 0) {
			// 	this.items.splice(0, this.items.length);
			// }
		}
	});

	var transformerModel = kendo.observable({
		classes 		: [],
		attributes 		: attributeModel,
		vendors			: new kendo.data.DataSource({
			transport: {
				read: {
					url: ARNY.baseUrl + "api/vendors/",
					type: "GET",
					dataType: "json"
				},
				parameterMap : function(options, operation) {
					if( operation !== "read" && options.models ) {
						return { models: kendo.stringigy(options.models) };
					}
					return options;
				}
			},
			pageSize: 30,
			serverFiltering: false,
			schema: {
				model: {
					id: "id"
				},
				data: "vendors",
				total: "count"
			}
		}),
		vendor 			: "",
		setTransformer 	: function(transformerID) {
			this.set("current", transformerDS.get(transformerID));
		},
		isCreating 		: true,
		isDisabled		: true,
		filterBy 		: "license",
		createBtn 		: function(e) {
			e.preventDefault();
			router.navigate("/create", false);
			this.set("isCreating", true);
			this.set("transformer", "");
			this.set("transformerType", "");
			this.set("capacity", "");
			this.set("location", "");
			this.set("latitute", "");
			this.set("longtitute", "");
			this.set("brand", "");
			this.set("license", "");
			this.attributes.reset();
		},
		updateBtn 		: function(e) {
			e.preventDefault();
			router.navigate("/"+this.current.id+"/update", false);
			this.set("isCreating", false);
			this.set("transformer", this.current.transformerNumber);
			this.set("transformerType", this.current.type);
			this.set("capacity", this.current.capacity);
			this.set("location", this.current.location);
			this.set("latitute", this.current.latitute);
			this.set("longtitute", this.current.longtitute);
			this.set("brand", this.current.brand);
			this.set("license", this.current.license);
			for(var i=0; i < this.attributes.items.length; i++) {
				this.attributes.items[i].set("id", this.current.attributes[i].id);
				this.attributes.items[i].set("capacity", this.current.attributes[i].capacity);
				this.attributes.items[i].set("type", this.current.attributes[i].type);
				this.attributes.items[i].set("unit", this.current.attributes[i].unit);
			}
		},
		deleteBtn 		: function(e) {
			var transformer = transformerDS.get(this.current.id);
			var ask = confirm("តើអ្នកពិតជាត្រូវការលុបត្រងស្វូេនះម៉ែនទ?");

			if(ask === true) {
				transformerDS.remove(transformer);
				transformerDS.sync();
			} else {

			}
		},
		mapBtn 			: function(e) {
			
		},
		viewBtn 		: function(e) {
			e.preventDefault();
			router.navigate("/"+this.current.id+"/view", false);
		},
		transformer 	: "",
		transformerType : "",
		location 		: "",
		latitute 		: "",
		longtitute 		: "",
		capacity 		: "",
		brand 			: "",
		license 		: "",
		validated 		: true,
		record 			: function(e) {
			if(this.get("validated") === true) {
				this.sync();
			}
		},
		update 			: function(e) {
			var transformer = transformerDS.get(this.current.id);
			transformer.set("license", this.get("license"));
			transformer.set("transformerNumber", this.get("transformer"));
			transformer.set("type", this.get("transformerType"));
			transformer.set("capacity", this.get("capacity"));
			transformer.set("brand", this.get("brand"));
			transformer.set("attributes", this.get("attributes").items);
			transformer.set("latitute", this.get("latitute"));
			transformer.set("location", this.get("location"));
			transformer.set("longtitute", this.get("longtitute"));
			transformerDS.sync();
		},
		reset 			: function(e) {
			this.set("transformer", "");
			this.set("transformerType", "");
			this.set("capacity", "");
			this.set("location", "");
			this.set("latitute", "");
			this.set("longtitute", "");
			this.set("brand", "");
			this.set("license", "");
			this.attributes.reset();
		},
		sync 			: function(e) {
			transformerDS.add({
				license 			: this.get("license"),
				transformerNumber	: this.get("transformer"),
				capacity 			: this.get("capacity"),
				type 				: this.get("transformerType"),
				brand 				: this.get("brand"),
				attributes 			: this.get("attributes").items,
				latitute 			: this.get("latitute"),
				location			: this.get("location"),
				longtitute 			: this.get("longtitute")
			});
			transformerDS.sync();
		} 
	});


	//3. Layout and Views
	var layout = new kendo.Layout("#layout", {model: transformerModel});
	var infoView = new kendo.View("#informationView", {model: transformerModel});
	var detailView = new kendo.View("#detailView", {model: transformerModel});
	var createView = new kendo.View("#createView", {model: transformerModel});
	var blankView = new kendo.View("#blank");

	//4. Router
	var router = new kendo.Router({
		init: function() {
			layout.render("#application");
		}
	});

	router.route("/", function(){
		layout.showIn("#info", blankView);
		layout.showIn("#detail", blankView);
	});

	router.route("/create", function(){
		layout.showIn("#info", createView);
		layout.showIn("#detail", blankView);
	});

	router.route("/:id/update", function(id){
		layout.showIn("#info", createView);
		layout.showIn("#detail", blankView);
		transformerModel.setTransformer(id);
	});

	router.route("/:id", function(id){
		layout.showIn("#info", infoView);
		layout.showIn("#detail", detailView);
		transformerModel.setTransformer(id);
	});

	router.route("/:id/view", function(id){
		layout.showIn("#info", infoView);
		layout.showIn("#detail", detailView);
		transformerModel.setTransformer(id);
	});

	//5. document ready
	$(function(){
		router.start();

		$("#transformers").kendoListView({
			dataSource : transformerDS,
			template: kendo.template($("#transformerList").html()),
			selectable: true,
			change: function(e) {
				var uid = this.select().data('uid');
				var transformer = this.dataSource.getByUid(uid);
				router.navigate("/"+transformer.id +"/view", false);
				transformerModel.set("isDisabled", false);
			}
		});
		$("#addnew").click(function(){
			router.navigate('/create', false);
			transformerModel.set("isCreating", true);
			transformerModel.set("transformer", "");
			transformerModel.set("transformerType", "");
			transformerModel.set("capacity", "");
			transformerModel.set("location", "");
			transformerModel.set("latitute", "");
			transformerModel.set("longtitute", "");
			transformerModel.set("brand", "");
			transformerModel.set("license", "");
			transformerModel.attributes.reset();
		});
		$("#search").on("click", function(){
			var field = "";
			if(transformerModel.get("filterBy") === "license") {
				field = "license.name";
			} else {
				field = "transformerNumber";
			}
			transformerDS.filter({
				field: field,
				operator: "contains",
				value: $("#searchField").val()
			});
		});
		$("#license").click(function(e){
			e.preventDefault();
			transformerModel.set("filterBy", "license");
		});
		$("#name").click(function(e){
			e.preventDefault();
			transformerModel.set("filterBy", "name");
		});

		$("#newTransformer").on("click", function(event) {
			this.preventDefault;
			//append div to main-content
			$("#main-contents").append("<div id='dialog'></div>");
			var wnd = $("#dialog").kendoWindow({
				width: 300,
				height: 400,
				modal: true,
				visibility: false,
				title: "ថែមត្រង់ស្វូថ្មី"
			}).data("kendoWindow");

			wnd.center().open();
		});
	});
</script>
<style scoped>
 .k-chart {
 	height: 200px;
 }
</style>