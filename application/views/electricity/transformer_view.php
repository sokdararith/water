<div class="container">
	<div class="row">
		<div class="span2">
			<?php $this->load->view("electricity/sidebar_view"); ?>
		</div>
		<div class="span10">
			<div class="well">
				<div id="navbar">
					<div class="pull-left">
				    	<input type="text" data-role="datepicker" class="search-query" placeholder="ចាបពី" id="from">
				    	- <input type="text" data-role="datepicker" class="search-query" placeholder="ដល់" id="to">
				    	<a href="#/new" class="btn" id="search">ស្វែងរក</a> 
					</div>
					<div class="pull-right">
						<a href="#/new" class="btn" data-bind="click: addNew">ថែមថ្មី</a> 
					</div>
				</div>
			</div><!--well-->
			<div id="grid"></div>
		</div>
		<div id="window">
			<table class="table">
				<tr>
					<td>កាលបរិច្ឆេទ៖</td>
					<td><input type="text" data-role="datepicker" id="myDate"></td>
				</tr>
				<tr>
					<td>លេខត្រង់ស្វូ៖</td>
					<td><input type="text" id="transformerName"></td>
				</tr>
				<tr>
					<td>ថាមពលសរុប៖</td>
					<td><input type="text" id="total"></td>
				</tr>
			</table>
			<div class="pull-right">
				<a href="#" class="btn btn-primary" id="save">កត់ត្រាទុក</a>
				<a href="#" class="btn k-close" id="close">បិទ</a>
			</div>
		</div>
	</div>
</div>

<script>
	var power = kendo.observable({
		isEnabled: false,
		addNew : function() {
			wnd.center().open();
		}
	});
	var transformers = new kendo.data.DataSource({
		transport: {
			read: {
				url 	: ARNY.baseUrl + "api/electricities/transformers",
				type 	: "GET",
				dataType: "json"
			},
			create: {
				url 	: ARNY.baseUrl + "api/electricities/transformers",
				type 	: "POST",
				dataType: "json"
			},
			update: {
				url 	: ARNY.baseUrl + "api/electricities/transformers",
				type 	: "PUT",
				dataType: "json"
			},
			destroy: {
				url 	: ARNY.baseUrl + "api/electricities/transformers",
				type 	: "DELETE",
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

	var transformerRecords = new kendo.data.DataSource({
		transport: {
			read: {
				url 	: ARNY.baseUrl + "api/electricities/transformerRecords",
				type 	: "GET",
				dataType: "json"
			},
			create: {
				url 	: ARNY.baseUrl + "api/electricities/transformerRecords",
				type 	: "POST",
				dataType: "json"
			},
			update: {
				url 	: ARNY.baseUrl + "api/electricities/transformerRecords",
				type 	: "PUT",
				dataType: "json"
			},
			destroy: {
				url 	: ARNY.baseUrl + "api/electricities/transformerRecords",
				type 	: "DELETE",
				dataType: "json"
			},
			parameterMap : function(options, operation) {
				if( operation !== "read" && options.models ) {
					return { models: kendo.stringigy(options.models) };
				}
				return options;
			}
		},
		serverFiltering: true,
		schema: {
			model: {
				id: "id",
				fields: {
					date_recorded 	: { type: "date" },
					transformer_id 	: { type: "number", editable: true, validation: { required: true } },
					new_reading		: { type: "number", editable: true, validation: { required: true } }
				}
			}
		},
		sync: function(e) {
			alert(e);
		}
	});

	var wnd = $("#window").kendoWindow({
		title: "ថែមអំអានត្រងស្វថ្មី",
		visible: false,
		modal: true
	}).data("kendoWindow");
	kendo.init($(".container"));
	var myDate 		= $("#window").find("#myDate").kendoDatePicker({
		value: new Date()
	}).data("kendoDatePicker");
	var transformer = $("#window").find("#transformerName").kendoComboBox({
		dataSource: transformers,
		dataTextField: "transformer_number",
		dataValueField: "id",
		autoBind: false
	}).data("kendoComboBox");
	var total 		= $("#window").find("#total").kendoNumericTextBox({
		min: 0,
		value: 0
	}).data("kendoNumericTextBox");
	$("#window").find(".k-close").click(function(){ 
		wnd.close();
		var date = new Date();
		myDate.value(date);
		total.value("0");
		this.preventDefault();
	});
	$("#window").find("#save").click(function(e) {
		e.preventDefault();
		transformerRecords.add({
			transformer_id 	: transformer.value(),
			new_reading		: total.value(),
			date_recorded	: kendo.toString(myDate.value(), "yyyy-MM-dd")
		});
		transformerRecords.sync();
		transformer.value("");
		total.value("");
		myDate.value(new Date());
	});
	$(function () {
		kendo.bind($(".container"), power);
		var grid = $("#grid").kendoGrid({
			dataSource: transformerRecords,
			autoBind: false,
			columns: [
				{ field: "date_recorded", title:"ប្រចាំខែ", format: "{0:yyyy-MM-dd}" },
				{ field: "transformer_id", title:"លេខត្រង់ស្វូ"},
				{ field: "new_reading", title:"ថាមពុលសរុប", format: "{0:n}"},
				{ command: [
						{	
							name: "edit",
							text: {
								edit: "កែ",
								update: "រក្សាទុក",
								cancel: "មោឃះ"
							},
							template:"<a href='\\#' class='k-grid-edit'><i class='icon-pencil'></i></a> "
						},
						{
							name: "destroy",
							text: "លុប",
							template:" <a href='\\#' class='k-grid-delete'><i class='icon-trash'></i></a>"
						}
					],
					width: "50px"
				}
			],
			editable: {
				mode: "popup",
				confirmation: "តើអ្នកពិតជាចង់ លុបម៉ែនទ?"
			}
		}).data("kendoGrid");

		$("#search").click(function() {
			transformerRecords.filter({					
				filters: [
						{ value: $("#from").val() },
						{ value: $("#to").val() }
				]
			});
		});
	});
</script>