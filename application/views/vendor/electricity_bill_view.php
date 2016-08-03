<div class="row-fluid">    
	<div class="span12">
		<div id="example" class="k-content">
			<?php $this->load->view('vendor/toolbar_view'); ?>			
								
			<div class="eBilling">
				<div class="well">
					<div class="row">
						<div class="span7">
							<label for="vendor">Vendor:</label>
							<input type="text" placeholder="Select Vendor" data-bind="value: vendor" id="vendor">
							<label for="term">Payment Term:</label>
							<input type="text" placeholder="Select Vendor" data-bind="value: vendor" id="pmtTerm">
						</div>
						<div class="span4">
							<label for="date">Date:</label>
							<input type="text" placeholder="Enter Date" data-bind="value: dateRecord" id="date">
							<label for="date">Due Date:</label>
							<input type="text" placeholder="Enter Date" data-bind="value: due_date" id="due_date">
							<label for="invoice">Invoice No.</label>
							<input type="text" name="invoice" placeholder="invoice no." style="width: 160px;">
						</div>
					</div>
				</div>				

				<div>
					<div id="grid"></div>
					<div class="pull-right">
						<button class="btn btn-primary" data-bind="click: record">Record</button>
						<button class="btn" data-bind="click: addNew">Add Row</button>
					</div>
				</div>
				
				<script id="editor" type="text/x-kendo-template">
				  <tr>
				  	<td><input type="text" data-role="dropdownlist" data-bind="source: transformer, value:transformer_id"></td>
				  	<td></td>
				  	<td></td>
				  	<td></td>
				  	<td></td>
				  </tr>
				</script>
			</div>
		</div> <!--end div example-->            
	</div> <!--End div span12-->		
</div> <!--End div row-fluid-->




<script>
	var transformerDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricities/transformer_cascading/",
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

	var vendorDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/people_api/vendors/",
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
			model: {
				id: "id"
			},
			data: "vendors",
			total: "count"
		}
	});
	var bills = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricities/bills/",
				type: "GET",
				dataType: "json"
			},
			create: {
				url: ARNY.baseUrl + "api/electricities/bills/",
				type: "POST",
				dataType: "json"
			},
			update: {
				url: ARNY.baseUrl + "api/electricities/bills/",
				type: "PUT",
				dataType: "json"
			},
			destroy: {
				url: ARNY.baseUrl + "api/electricities/bills/",
				type: "DELETE",
				dataType: "json"
			},
			parameterMap : function(options, operation) {
				if( operation !== "read" && options.models ) {
					return { models: kendo.stringigy(options.models) };
				}
				if( operation === "read") {
					return { vendor_id : billModel.get("vendor") };
				}
				return options;
			}
		},
		schema: {
			model: {
				id: "id"
			}
		},
		serverFiltering: true,
		requestEnd: function(e) {
			var type = e.type;
			
			if(type==="create") {
				recordModel.sync(e.response.id);
			}
		},
		error	: function(e) {
			console.log(e.status);
		}
	});
	var journalDS = new kendo.data.DataSource({
		transport: {
			create: {
				url: ARNY.baseUrl + "api/accounting_api/add_journal/",
				type: "POST",
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
	var recordDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricities/transformerRecords/",
				type: "GET",
				dataType: "json"
			},
			create: {
				url: ARNY.baseUrl + "api/electricities/transformerRecords/",
				type: "POST",
				dataType: "json"
			},
			update: {
				url: ARNY.baseUrl + "api/electricities/transformerRecords/",
				type: "PUT",
				dataType: "json"
			},
			destroy: {
				url: ARNY.baseUrl + "api/electricities/transformerRecords/",
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
	var PaymentTermDataSource = new kendo.data.DataSource({
        transport: {
	        read: ARNY.baseUrl + "api/accounting_api/payment_term",
	        type: "GET",
	        dataType: "json"
        }
    });
	var recordModel = kendo.observable({
		tempRecords : [],
		transformer: transformerDS,
		vendor : $("#vendor").val(),
		prevReading: "",
		newReading: "",
		multiplier: 1,
		invoice: "",
		tariff: "",
		dateRecord: "",
		due_date: "",
		transformer_number: "",
		reader: <?php echo $this->session->userdata('user_id'); ?>,
		addNew: function() {
			var msg = [];
			// if(this.get("vendor") !== "" && this.get("dateRecord") !== "") {
			// 	this.get("tempRecords").push(
			// 		{dateRecord: this.get("dateRecord"), vendor: this.get("vendor"), transformer: "", prev: "0", newReading: "0", multiplier: "1", tariff: "", reader: this.get("reader")}
			// 	);
			// } 
			if (this.get("dateRecord") == ""){
				msg.push("Please choose date.");
			} if (this.get("vendor") == "") {
				msg.push("Please choose vendor.");
			}

			if (msg.length > 0) {
				var x;
				for(i = 0; i < msg.length; i++) {
					x = msg[i];
				}
				alert(x);
			} else {
				this.get("tempRecords").push(
					{
						bill_id: 0, 
						transformer_id: "",
						prev_reading: "0", 
						new_reading: "0", 
						multiplier: "1", 
						tariff: ""
					}
				);
			}
			
		},
		record: function() {
			if(this.get("tempRecords").length > 0 && this.get("vendor") !== "") {
				var x = [];
				for (var i = 0; i < this.get("tempRecords").length; i++) {
					if(this.get("tempRecords")[i].transformer === "") {
						x.push(i+1);
					} if (this.get("tempRecords")[i].new_reading <= this.get("tempRecords")[i].prev_reading) {
						x.push(i+1);
					}
				}

				if(x.length > 0) {
					alert("check row: " + x);
				} else {
					//alert("Saved");
					

					var amount= 0;
					for (var i=0; i < this.get("tempRecords").length; i++) {
						amount += (((this.get("tempRecords")[i].new_reading - this.get("tempRecords")[i].prev_reading) * this.get("tempRecords")[i].multiplier) * this.get("tempRecords")[i].tariff);
					}
					if(amount > 0) {
						bills.add({
							vendor_id: this.get("vendor"),
							employee_id: this.get("reader"),
							bill_type: "electricity",
							date: kendo.toString(this.get("dateRecord"), "yyyy-MM-dd"),
							due_date: kendo.toString(this.get("due_date"), "yyyy-MM-dd"),
							amount_billed: amount,
							status: 0
						});
						journalDS.add(
					 	{
					 		account_id: 9, 
					 		dr: 0, 
					 		cr: amount, 
					 		memo: "Vendor Bill", 
					 		voucher: recordModel.get('invoice'),
					 		people_id: recordModel.get("vendor"), 
					 		date: kendo.toString(recordModel.get("dateRecord"), "yyyy-MM-dd"), 
					 		transaction_type: "Bill"
				 		});
						journalDS.add({
					 		account_id: 19, 
					 		dr: amount, 
					 		cr: 0, 
					 		memo: "Vendor Bill", 
					 		voucher: recordModel.get('invoice'), 
					 		people_id: recordModel.get("vendor"),
					 		date: kendo.toString(recordModel.get("dateRecord"), "yyyy-MM-dd"), 
					 		transaction_type: "Bill"
						 });
						bills.sync();
						journalDS.sync();
					}
				}
				
			} else {
				alert("Need to enter data");
			}
			//alert(this.get("tempRecords").length);
		},
		sync: function(billID) {
			for(var i = 0; i < this.get("tempRecords").length; i++) {
				this.get("tempRecords")[i].bill_id = billID;
			}
			recordDS.add(this.get("tempRecords"));
			recordDS.sync();
			for(var i= 0; i < this.get("tempRecords").length; i++) {
				this.get("tempRecords").splice(i,8);
				recordDS.remove(recordDS.at(i));
			}

			this.set("vendor", "");
			this.set("dateRecord", "");
		}
	});
	function categoryDropDownEditor(eBilling, options) {
        $('<input required data-text-field="transformer_number" data-value-field="transformer_number" data-bind="value:' + options.field + '"/>')
            .appendTo(eBilling)
            .kendoDropDownList({
                autoBind: false,
                dataSource: transformerDS,
                template: "<div>#=id#-#=transformer_number#</div>"
            });
    }
	$(function(){
		$("#date").kendoDatePicker();
		$("#pmtTerm").kendoDropDownList({
			dataSource: PaymentTermDataSource,
			index: -1,
			dataTextField: "term",
			dataValueField: "id"
		});
		$("#due_date").kendoDatePicker();
		$("#vendor").kendoDropDownList({
			dataSource: vendorDS,
			index: -1,
			dataTextField: "name",
			dataValueField: "id"
		});
		// $(".transformer").kendoDropDownList({
		// 	dataSource: transformerDS,
		// 	index: -1,
		// 	dataTextField: "transformer_number",
		// 	dataValueField: "id"
		// });
		var grid = $("#grid").kendoGrid({
			dataSource: recordModel.get("tempRecords"),
			editable: true,
			columns: [
				{ title: "transformer", field: "transformer_id", editor: categoryDropDownEditor},
				{ title: "New Reading", field: "new_reading", type:"numerictextbox"},
				{ title: "Prev Reading", field: "prev_reading"},
				{ title: "Multiplier", field: "multiplier", type: "number"},
				{ title: "Tariff", field: "tariff"},
				{ command: [{name:'destroy', text: 'Del', template: "<i class='icon-trash k-grid-delete'></i>"}], width: "40px"}
			]
		}).data("kendoGrid");

		kendo.bind($(".eBilling"), recordModel);
	});
</script>