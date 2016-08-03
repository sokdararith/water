<div class="widget widget-tabs widget-tabs-double widget-tabs-vertical row-fluid row-merge widget-tabs-gray">

    <!-- Tabs Heading -->
    <div class="widget-head span3 hidden-print">
        <ul>
            <li class="active"><a href="#tab1-1" class="glyphicons user" data-toggle="tab"><i></i><span class="strong">Step 1</span><span>មធ្យោបាយផលិតកម្ម</span></a>
            </li>
            <li><a href="#tab2-1" class="glyphicons calculator" data-toggle="tab"><i></i><span class="strong">Step 2</span><span>ថាមពលផលិត</span></a>
            </li>
            <li><a href="#tab3-1" class="glyphicons credit_card" data-toggle="tab"><i></i><span class="strong">Step 3</span><span>មធ្យោបាយចែកចាយ</span></a>
            </li>
            <li><a href="#tab4-1" class="glyphicons circle_ok" data-toggle="tab"><i></i><span class="strong">Step 4</span><span>ព័ត៌មានលម្អិតតាមតរង់ស្វូ</span></a>
            </li>
            <li><a href="#tab5-1" class="glyphicons circle_ok" data-toggle="tab"><i></i><span class="strong">Step 5</span><span>ព័ត៌មានពំពីអតិថិជនជាអ្នកប្រើប្រាស់ផ្ទាល់</span></a>
            </li>
            <li><a href="#tab6-1" class="glyphicons circle_ok" data-toggle="tab"><i></i><span class="strong">Step 6</span><span>អតិថិជនកាន់អាជ្ញាប័ណ្ណ</span></a>
            </li>
            <li><a href="#tab7-1" class="glyphicons circle_ok" data-toggle="tab"><i></i><span class="strong">Step 7</span><span>ព័ត៌មានការលក់ថាមពលអោយអ្នកប្រើប្រាស់ផ្ទាល់</span></a>
            </li>
            <li><a href="#tab8-1" class="glyphicons circle_ok" data-toggle="tab"><i></i><span class="strong">Step 8</span><span>ព័ត៌មានថាមពលលក់អោយអ្នកកាន់អាជ្ញាប័ណ្ណ</span></a>
            </li>
            <li><a href="#tab9-1" class="glyphicons circle_ok" data-toggle="tab"><i></i><span class="strong">Step 9</span><span>ព័ត៌មានប្រភពទិញថាមពល</span></a>
            </li>
            <li><a href="#tab10-1" class="glyphicons circle_ok" data-toggle="tab"><i></i><span class="strong">Step 10</span><span>ព័ត៌មានអំពីការទិញថាមពល</span></a>
            </li>
            <li><a href="#tab11-1" class="glyphicons circle_ok" data-toggle="tab"><i></i><span class="strong">Step 11</span><span>តំបន់ចែកចាយក្នុងអាជ្ញាប័ណ្ណ</span></a>
            </li>
        </ul>
    </div>
    <!-- // Tabs Heading END -->

    <div class="widget-body span9">
        <div class="tab-content">

            <!-- Tab content -->
            <div class="tab-pane active" id="tab1-1">
                <h4>មធ្យោបាយផលិតកម្ម</h4>
                <div id="generationFacility"></div>
            </div>
            <!-- // Tab content END -->

            <!-- Tab content -->
            <div class="tab-pane" id="tab2-1">
                <h4>dsfds</h4>	
                <div id="generatorRecords"></div>
            </div>
            <!-- // Tab content END -->

            <!-- Tab content -->
            <div class="tab-pane" id="tab3-1">
                <h4>មធ្យោបាយចែកចាយ</h4>
                	<table class="table table-condensed table-hover" id="distribution">
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
						<tbody></tbody>
					</table>
            </div>
            <!-- // Tab content END -->

            <!-- Tab content -->
            <div class="tab-pane" id="tab4-1">
                <h4>ព័ត៌មានលម្អិតតាមតរង់ស្វូ</h4>
                <table id="transformers">
                	<tbody></tbody>
                </table>
            </div>
            <!-- // Tab content END -->

            <!-- Tab content -->
            <div class="tab-pane" id="tab5-1">
                <h4>5 tab</h4>
                <div id="customerSegment"></div>
            </div>
            <!-- // Tab content END -->

			<!-- Tab content -->
            <div class="tab-pane" id="tab6-1">
                <h4 class="printTitle">ព័ត៌មានអំពីអតិថិជនជាអ្នកកាន់អាជ្ញាប័ណ្ណ</h4>
				<table class="table" id="licensees">
					<thead>
						<tr>
							<td>អាជ្ញាប័ណ្ណ</td>
							<td>ឈ្មោះអ្នកកាន់អាជ្ញាប័ណ្ណ</td>
							<td>លេខអតិថិជន</td>
							<td>ទីតាំង</td>
							<td>តង់ស្យុង</td>
							<td>បញ្ជីថ្លៃលក់</td>
							<td>ចំនួនភ្ជាប់</td>
							<td><a href="#/licensees/create" class="menu"><?=$this->lang->line('button_create'); ?></a></td>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
                
            </div>
            <!-- // Tab content END -->

            <!-- Tab content -->
            <div class="tab-pane" id="tab7-1">
                <h4>7 tab</h4>
                
            </div>
            <!-- // Tab content END -->

            <!-- Tab content -->
            <div class="tab-pane" id="tab8-1">
                <h4>8 tab</h4>
                
            </div>
			<!-- // Tab content END -->

            <!-- Tab content -->
            <div class="tab-pane" id="tab9-1">
                <h4>ប្រភពទិញថាមពល</h4>
                <table class="table" id="energySourcePurchased">
					<tbody></tbody>
				</table>
            </div>
            <!-- // Tab content END -->

            <!-- Tab content -->
            <div class="tab-pane" id="tab10-1">
                <h4>ប្រភពទិញថាមពល</h4>
                <table class="table" id="energyPurchased">
					<tbody></tbody>
				</table>
            </div>
            <!-- // Tab content END -->

            <!-- Tab content -->
            <div class="tab-pane" id="tab11-1">
                <h4>11</h4>
                <table class="table">
					<tbody></tbody>
				</table>
            </div>
            <!-- // Tab content END -->
            
        </div>

    </div>
</div>
<!-- template -->
<script type="text/x-kendo-template" id="layoutTmpl">
	<div id="app"></div>
</script>
<script type="text/x-kendo-template" id="distributionTmpl">
	<h2 class="printTitle" style="text-align:center;">ព័ត៌មានអំពីអតិថិជនជាអ្នកកាន់អាជ្ញាប័ណ្ណ</h2>
	<p>hiha</p>
</script>
<script type="text/x-kendo-template" id="powerTmpl">
	<h2 class="printTitle" style="text-align:center;">ព័ត៌មានអំពីអតិថិជនជាអ្នកកាន់អាជ្ញាប័ណ្ណ</h2>
	<p>Power</p>
</script>
<script type="text/x-kendo-template" id="tranTmpl">
	<h2 class="printTitle" style="text-align:center;">ព័ត៌មានអំពីអតិថិជនជាអ្នកកាន់អាជ្ញាប័ណ្ណ</h2>
	<p>transformer</p>
</script>
<script type="text/x-kendo-template" id="licenseeListTmpl">
	<tr>
		<td>#=license_no#</span></td>
		<td>#=licensee_name#</td>
		<td>#=customer.customer_no#</td>
		<td>#=location#</td>
		<td>#=voltage#</td>
		<td>#=price#</td>
		<td>#=connection_no#</td>
		<td>
			<div class="edit-buttons">
                <a class="k-edit-button" href="\\#"><i class="icon-edit"></i></a>
                <a class="k-delete-button" href="\\#"><i class="icon-trash"></i></a>
            </div>
		</td>
	</tr>
</script>
<script type="text/x-kendo-template" id="editLicenseeListTmpl">
	<tr>
		<td><input type="text" data-bind="value: license_no" name="license_no"></span></td>
		<td>#=licensee_name#</td>
		<td>#=customer.name#</td>
		<td>#=location#</td>
		<td>#=voltage#</td>
		<td>#=price#</td>
		<td>#=connection_no#</td>
		<td>
            <div class="edit-buttons">
                <a class="k-update-button" href="\\#"><i class="icon-check"></i></a>
                <a class="k-cancel-button" href="\\#"><i class="icon-remove"></i></a>
            </div>
		</td>
	</tr>
</script>

<script type="text/x-kendo-template" id="distributionListTmpl">
	<tr>
		<td>#=line#</td>
		<td>#=voltage#kV</td>
		<td>#=phases#</td>
		<td>#=line_length#</td>
		<td>#=date_using#</td>
		<td>#=date_stopped#</td>
		<td>
			<div class="edit-buttons">
                <a class="k-edit-button" href="\\#"><i class="icon-edit"></i></a>
                <a class="k-delete-button" href="\\#"><i class="icon-trash"></i></a>
            </div>
		</td>
	</tr>
</script>
<script type="text/x-kendo-template" id="editdistributionListTmpl">
	<tr>
		<td>#=line#</td>
		<td>#=voltage#kV</td>
		<td>#=phases#</td>
		<td>#=line_length#</td>
		<td>#=date_using#</td>
		<td>#=date_stopped#</td>
		<td>
			<div class="edit-buttons">
                <a class="k-update-button" href="\\#"><i class="icon-check"></i></a>
                <a class="k-cancel-button" href="\\#"><i class="icon-remove"></i></a>
            </div>
		</td>
	</tr>
</script>

<script type="text/x-kendo-template" id="transformerListTmpl">
	<tr>
		<td>#=line#</td>
		<td>#=voltage#kV</td>
		<td>#=phases#</td>
		<td>#=line_length#</td>
		<td>#=date_using#</td>
		<td>#=date_stopped#</td>
		<td>
			<div class="edit-buttons">
                <a class="k-edit-button" href="\\#"><i class="icon-edit"></i></a>
                <a class="k-delete-button" href="\\#"><i class="icon-trash"></i></a>
            </div>
		</td>
	</tr>
</script>
<script type="text/x-kendo-template" id="editTransformerListTmpl">
	
</script>

<script type="text/x-kendo-template" id="purchaseListTmpl">
	<tr>
		<td>#=created_at#</td>
		<td>#=vendor.surname# #=vendor.name#</td>
		# var amount = 0; #
		# for(var i=0; i<records.length; i++) { #
			# amount += (records[i].new_reading - records[i].prev_reading); #
		# } #
		<td>#= amount #</td>
		<td>#=price#</td>
		<td>#=kendo.toString((amount*price), 'c2')#</td>
	</tr>
</script>
<!--template end-->

<script>
	var id;
	//datasource
	var transformTransport = {
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
	};
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
	var appVM 		= new kendo.observable({});
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
			router.navigate("/licensees");
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
	$(function(){
		var licenseeListView = $("#licensees>tbody").kendoListView({
			dataSource: licensees,
			template: kendo.template($("#licenseeListTmpl").html()),
			editTemplate: kendo.template($("#editLicenseeListTmpl").html())
		}).data("kendoListView");

		var distributionListView = $("#distribution>tbody").kendoListView({
			dataSource: new kendo.data.DataSource({
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
			}),
			template: kendo.template($("#distributionListTmpl").html()),
			editTemplate: kendo.template($("#editdistributionListTmpl").html())
		}).data("kendoListView");

		var transformerListView = $("#transformers>tbody").kendoGrid({
			dataSource : new kendo.data.DataSource({
				transport: transformTransport,
				group: {
					field: "capacity"
				},
				schema: {
					model: {
						id: "id"
					}
				}
			}),
			columns: [
				{ field: "license.name", title: "អាជ្ញាប័ណ្ណ" },
				{ field: "brand", title: "ម៉ាក" },
				{ field: "transformerNumber", title: "ឈ្មោះ" },
				{ field: "type", title: "ប្រភេទ" }
			]
			//template: kendo.template($("#transformerListTmpl").html())
		}).data('kendoGrid');

		//Vendor
		var energySourcePurchased = $("#energySourcePurchased").kendoGrid({
			dataSource: new kendo.data.DataSource({
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
				schema: {
					model: {
						id: "id"
					},
					data: "vendors",
					total: "count"
				}
			}),
			columns: [
				{ title: "ថ្ងៃចុះកិច្ចព្រមព្រៀង", field: "created_at", width: "120px" },
				{ title: "ប្រភពនៃការទិញ", field: "name", template: "#=surname# #=name#" },
				{ title: "តង់ស្យុង", field: "voltage_id" },
				{ title: "ចំនូនចំនុចតភ្ជាប់", field: "connection", template: "#:connection.length#" },
				{ title: "ថ្លៃទិញ/ឯកតា" }
			]
		}).data("kendoGrid");
		energySourcePurchased.dataSource.filter(
			{ field: "type", operator: "eq", value: "electricity" }
		);

		var energyPurchased = $("#energyPurchased").kendoGrid({
			dataSource: new kendo.data.DataSource({
				transport: transformTransport,
				schema: {
					model: {
						id: "id"
					}
				}
			}),
			columns: [
				{ title: "ថ្ងៃចុះកិច្ចព្រមព្រៀង", width: "120px" },
				{ title: "ប្រភពនៃការទិញ", field: "vendor" },
				{ title: "បរិមាណថាមពលទិញ" },
				{ title: "ថ្លៃទិញ/ឯកតា" },
				{ title: "ថ្លៃទិញសរុប" }
			],
			rowTemplate: kendo.template($("#purchaseListTmpl").html())
		}).data("kendoGrid");

		//customer Segement
		var customerSegment = $("#customerSegment").kendoGrid({
			dataSource: new kendo.data.DataSource({
				transport: {
					read: {
						url: ARNY.baseUrl + "api/electricities/customers",
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
				schema: {
					data: "segment"
				}
			}),
			columns: [
				{ field: "type", title: "ប្រភេទអតិថិជន" },
				{ field: "number", title: "ចំនួន" },
				{ title: "រយ:ពេលផ្គត់ផ្គង់" },
				{ title: "សម្គាល់" }
			]
		}).data("kendoGrid");

		//generationFacility
		var generationFacility = $("#generationFacility").kendoGrid({
			dataSource: new kendo.data.DataSource({
				transport: {
					read: {
						url: ARNY.baseUrl + "api/electricities/generators",
						type: "GET",
						dataType: "json"
					},
					create: {
						url: ARNY.baseUrl + "api/electricities/generators",
						type: "POST",
						dataType: "json"
					},
					update: {
						url: ARNY.baseUrl + "api/electricities/generators",
						type: "PUT",
						dataType: "json"
					},
					destroy: {
						url: ARNY.baseUrl + "api/electricities/generators",
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
			}),
			editable: true,
			toolbar: ['create'],
			columns: [
				{ title: "Class", field: "class_id" },
				{ title: "លេខកូដ", field: "code" },
				{ title: "កំលាំងហ្សេណារ៉ាទ័រ(ឌីណាម៉ូ)", field: "capacity" },
				{ title: "ប្រភេទប្រេង", field: "fule_type" },
				{ title: "ថ្ងៃប្រើប្រាស់", field: "date_started_using" },
				{ title: "ថ្ងៃឈប់ប្រើប្រាស់", field: "date_stopped_using" }
			]
		}).data("kendoGrid");

		var generatorRecords = $("#generatorRecords").kendoGrid({
			dataSource: new kendo.data.DataSource({
				transport: {
					read: {
						url: ARNY.baseUrl + "api/electricities/generator_records",
						type: "GET",
						dataType: "json"
					},
					create: {
						url: ARNY.baseUrl + "api/electricities/generator_records",
						type: "POST",
						dataType: "json"
					},
					update: {
						url: ARNY.baseUrl + "api/electricities/generator_records",
						type: "PUT",
						dataType: "json"
					},
					destroy: {
						url: ARNY.baseUrl + "api/electricities/generator_records",
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
			}),
			editable: true,
			toolbar: ['create'],
			columns: [
				{ title: "Class", field: "class_id" },
				{ title: "លេខកូដ", field: "code" },
				{ title: "កំលាំងហ្សេណារ៉ាទ័រ(ឌីណាម៉ូ)", field: "capacity" },
				{ title: "ប្រភេទប្រេង", field: "fule_type" },
				{ title: "ថ្ងៃប្រើប្រាស់", field: "date_started_using" },
				{ title: "ថ្ងៃឈប់ប្រើប្រាស់", field: "date_stopped_using" }
			]
		}).data("kendoGrid");
	});
</script>
