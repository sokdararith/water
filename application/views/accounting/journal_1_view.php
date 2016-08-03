
<div class="span12">
	<h2 style="text-align: center;">កត់ត្រាទិន្នានុប្បវត្តិ</h2>
	<div id="application">
		<div class="well">
			<input type="text" data-role="datepicker" data-bind="value: date">
			<input type="text" placeholder="លេខសក្ខីបត្រ័" data-bind="value: entryNumber" style="margin-top: 10px;">
		</div>
		<i class="icon-plus" data-bind="click: addNew"></i>
		<div id="grid" data-role="grid" 
				 	   data-bind="source: journalItem.items" 
				 	   data-row-template="gridTmpl" 
				 	   data-columns="[
				 	   	  {title: 'គណនី', width:'265px'},
				 	   	  {title:'ឥណពន្ធ (Dr.)', width:'120px'},
				 	   	  {title:'ឥណទាន (Cr.)', width:'120px'},
				 	   	  {title:'Class', width:'180px'},
				 	   	  {title:'ពិពណ៍នា'},
				 	   	  {title:'', width:'30px'}]"></div>
		<table class="table">
			<tbody>
				<tr>
					<td width="310"></td>
					<td width="103"><span data-bind="text: debit"></span></td>
					<td width="103"><span data-bind="text: credit"></span></td>
					<td></td>
				</tr>
				<tr>
					<td width="310">លំអៀង </td>
					<td width="103"><span data-bind="text: dif"></span></td>
					<td width="103"></td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<div class="span3 pull-right">
			<button class="btn pull-right" data-bind="click: cancel">មិនយក</button>
			<button class="btn pull-right" data-bind="click: record">កត់ត្រាប្រត្តិការនេះ</button>
		</div>
		<span data-bind="text: journalItem.items.account_id"></span>
	</div>
</div>

<script id="gridTmpl" type="text/x-kendo-template">
	<tr>
		<td>
			<select data-role="combobox" name="account" id="account" 
					data-bind="source: accounts, value: account_id" 
					data-text-field="name" 
					data-value-field="id" 
					style="width: 250px"></select>
			
		</td>
		<td>
			<input type="text" data-bind="value: dr" style="width: 90px; margin-top: 9px;">
		</td>
		<td>
			<input type="text" data-bind="value: cr" style="width: 90px; margin-top: 9px;">
		</td>
		<td>
			<select data-role="combobox" name="account" id="account" 
					data-bind="source: classes, value: class_id" 
					data-text-field="name" 
					data-value-field="id" 
					style="width: 160px"></select>
		</td>
		<td>
			<input type="text" data-bind="value: memo" style="width: 180px;; margin-top: 9px;">
		</td>
		<td>
			<i class="icon-trash" data-bind="click: remove"></i>
		</td>
	</tr>	
</script>

<script>
	var items = [];
	//datasource
	var journalDS = new kendo.data.DataSource({
		transport: {
			create: {
				url: ARNY.baseUrl + "api/accounting_api/journals/",
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
		},
		requestEnd: function(e) {
			if(e.type === "create") {
				for(var i = 0; i < journalDS.data().length; i++) {
					journalDS.remove(journalDS.at(i));
				}
				journalModel.cancel();
				journalModel.set("entryNumber", "");
				alert("Succesfully posted!");
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
	// var accountDS = new kendo.data.DataSource({
	//     transport: {
	// 	    read: ARNY.baseUrl + "api/accounting_api/account",
	// 	    type: "GET",
	// 	    dataType: "json"
	//     }
	// });

	var journalItemModel = kendo.observable({
		items 		: [],
		add 		: function() {
			this.items.push({
				account_id	: 1,
				dr 			: 0,
				cr 			: 0,
				class_id	: 1,
				memo 		: ""
			});
		},
		remove 		: function(e) {
			for (var i = 0; i < this.items.length; i ++) {
	            var current = this.items[i];
	            if (current === e.data) {
	                this.items.splice(i, 1);
	                break;
	            }
	        }
		},
		itemCount	: function() {
			return this.get("items").length;
		},
		empty 		: function() {
			this.items.splice(0, this.items.length);
		}
	});

	var journalModel = kendo.observable({
		accounts 	: [],//accountDS,
		classes 	: [],//classDS,
		journalItem : journalItemModel,
		date 		: "",
		entryNumber : "",
		dataBound	: function(e) {
			$(e.currentTarget).closest("tr").find(".account").kendoDatePicker();
			console.log($(e.currentTarget).closest("tr").children().children());
		},
		debit		: function() {
			var dr = 0;
			if(this.journalItem.itemCount() > 0) {
				for(var i=0;i<this.journalItem.itemCount();i++) {
					dr += parseFloat(this.journalItem.items[i].dr);
				}
			}
			return dr; 
		},
		credit 		: function() {
			var cr = 0;
			if(this.journalItem.itemCount() > 0) {
				for(var i=0;i<this.journalItem.itemCount();i++) {
					cr += parseFloat(this.journalItem.items[i].cr);
				}
			}
			return cr;
		},
		dif 		: function() {
			var diff= 0,
			dr = parseFloat(this.debit()),
			cr = parseFloat(this.credit());
			if(dr > cr) {
				diff = parseFloat(dr) - parseFloat(cr);
			} else {
				diff = parseFloat(cr) - parseFloat(dr);
			}
			return kendo.toString(diff, '##,###');
		},
 		total 		: function() {

			return this.journalItem.itemCount();
		},
		addNew 		: function() {
			this.journalItem.add();
		},
		record 		: function() {
			//record to database
			var errors = [];
			if(this.journalItem.itemCount() > 0) {
				for(var i=0; i < this.journalItem.itemCount(); i++) {
					if(this.journalItem.items[i].dr>0 && this.journalItem.items[i].cr> 0) {
						errors.push("Cannot have value in debit and credit of the same entry.");
					}
				}
				if(this.journalItem.itemCount() < 2) {
					errors.push("You need at least two entries.");
				}
				if (this.dif() > 0) {
					errors.push("Dr. must be equal to Cr. side.");
				}
				if(this.debit() === 0 || this.credit() === 0) {
					errors.push("You must fill in the debit or credit side of all entries.");
				}
				if(this.get("date") == "") {
					errors.push("You must fill in the date.");
				}
				if(errors.length > 0) {
					var error = "";
					for(var i =0; i < errors.length; i++) {
						error += (i +1)+". "+errors[i] + "\n";
					}
					alert(error);
					errors.splice(0,errors.length)
				} else {
					journalDS.add({
				 		journalEntries : this.journalItem.items,
				 		memo: "", 
				 		voucher: this.get('entryNumber'),
				 		budget_id: 0,
				 		donor_id: 0,
				 		check_no: 0,
				 		people_id: 0,
				 		employee_id: <?php echo $this->session->userdata('user_id'); ?>,
				 		invoice_id: 0,
				 		payment_id: 0,
				 		bill_id: 0,	
				 		date: kendo.toString(this.get("date"), "yyyy-MM-dd"), 
				 		transaction_type: "GL"
				 	});
				 	journalDS.sync();
				}
			}
		},
		cancel 		: function() {
			this.journalItem.empty();
		},
		remove 		: function(e) {
			this.journalItem.remove(e);
		}
	});
	
	$.getJSON(ARNY.baseUrl + "api/accounting_api/account", function(data) {
	 	$.each(data, function(key, val) {
	    	journalModel.accounts.push({id: val.id, name: val.name});
		});
		
	});

	$.getJSON(ARNY.baseUrl + "api/accounting_api/class_dropdown", function(data) {
	 	$.each(data, function(key, val) {
	    	journalModel.classes.push({id: val.id, name: val.name});
		});	
	});

	$(function(){
		//router.start();
		kendo.bind($("#application"), journalModel);
		var today = new Date();
		journalModel.set("date", today);

		// $("#grid > div.k-grid-content > table > tbody > tr > td > input.account").bind(function(e){
		// 	$(e.currentTarget).kendoDatePicker();
		// });
	  	//console.log($("#grid > div.k-grid-content > table > tbody > tr>td").find("input.account"));
	});
</script>