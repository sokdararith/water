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
				</div><!--navbar-->
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
	var powerDS = new kendo.data.DataSource({
		transport: {
			read: {
				url 	: ARNY.baseUrl + "api/electricities/powers",
				type 	: "GET",
				dataType: "json"
			},
			create: {
				url 	: ARNY.baseUrl + "api/electricities/powers",
				type 	: "POST",
				dataType: "json"
			},
			update: {
				url 	: ARNY.baseUrl + "api/electricities/powers",
				type 	: "PUT",
				dataType: "json"
			},
			destroy: {
				url 	: ARNY.baseUrl + "api/electricities/powers",
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
				id: "id"
			}
		}
	});
	var wnd = $("#window").kendoWindow({
		title: "ថែមការផលិត",
		visible: false,
		modal: true
	}).data("kendoWindow");
	kendo.init($(".container"));
	$("#window").find("#myDate").kendoDatePicker();
	$("#window").find("#transformerName").kendoComboBox();
	$("#window").find("#total").kendoNumericTextBox();
	$("#window").find(".k-close").click(function(){
		wnd.close();
	});
	$("#window").find("#save").click(function() {
		powerDS.add({amount: $("#window").find("#total").val(), date_recorded: $("#window").find("#myDate").val()});
		powerDS.sync();
	});
	$(function () {
		kendo.bind($(".container"), power);
		var grid = $("#grid").kendoGrid({
			dataSource: powerDS,
			columns: [
				{ field: "date_recorded", title:"ប្រចាំខែ"},
				{ field: "amount", title:"ថាមពុលសរុប"},
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
			powerDS.filter({					
				filters: [
						{ value: $("#from").val() },
						{ value: $("#to").val() }
				]
			});
		});
	});
</script>