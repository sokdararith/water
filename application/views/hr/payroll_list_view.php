<div class="container">
	<div class="row">
		<div class="span12">
			<?php $this->load->view('hr/toolbar'); ?>
			<h2>Payroll List</h2>
			<div class="span4 pull-right">
				<input type="text" data-role="numerictextbox" data-template="#=kendo.toString(exchange_rate, 'c3')#" data-bind="value: exchange_rate" placeholder="អាត្រាប្ដូប្រាក់">
				<button class="btn btn-primary" data-bind="click: generate">Generate</button>
			</div>
			<table id="payrollListTable" class="table table-striped">
				<thead>
					<tr>
						<th>ឈ្មោះ និយោជិត</th>
						<th>ប្រាក់បៀវត្ស ត្រូវបើកជា ដុល្លា</th>
						<th>ប្រាក់បៀវត្ស ត្រូវបើកជា រៀល</th>
						<th>ក្នុងបន្ទុក</th>
						<th>ទឹកប្រាក់ កាត់បន្ថយ</th>
						<th>មូលដ្ឋាន គិតពន្ធ ប.វ</th>
						<th>អត្រាពន្ធ</th>
						<th>ពន្ធលើ ប្រាក់បៀវត្ស ជារៀល</th>
						<th>ពន្ធលើ ប្រាក់បៀវត្ស ជាដុល្លា</th>
						<th>ប្រាក់បៀវត្ស សុទ្ធ</th>
						<th>កាត់</th>
						<th>ប្រាក់បៀវត្ស ដែលទទួលបាន</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
				<tfoot></tfoot>
			</table>
			<div id="pager"></div>
		</div>
	</div>
</div>
<script type="text/x-kendo-tmpl" id="payrollListTmpl">
# var base_salary = (amount*exchange_rate)-(dependents[0].dependents*75000); #
# var salary_tax, tax_percentate, tax_salary_usd; #
#if(base_salary<=500000) { #
#	tax_percentate = "0%"; #
#	salary_tax = 0; #
#   tax_salary_usd = (salary_tax/exchange_rate); #
#} else if(base_salary<=1250000) { #
#	tax_percentate = "5%"; #
#	salary_tax = (base_salary*0.05)-25000; #
#   tax_salary_usd = (salary_tax/exchange_rate); #
#} else if (base_salary <= 8500000){ #
#	tax_percentate = "10%"; #
#	salary_tax = (base_salary*0.1)-87500; #
#   tax_salary_usd = (salary_tax/exchange_rate); #
#} else if (base_salary <= 12500000) { #
#	tax_percentate = "15%"; #
#	salary_tax = (base_salary*0.15)-512500; #
#   tax_salary_usd = (salary_tax/exchange_rate); #
#} else { #
#	tax_percentate = "20%"; #
#	salary_tax = (base_salary*0.2)-1137500; #
#   tax_salary_usd = (salary_tax/exchange_rate); #
#} #
	<tr>
		<td>${staff.first_name}</td>
		<td>#kendo.culture("en-US"); ##=kendo.toString(amount, "c2")#</td>
		<td>#kendo.culture("km-KH"); ##=kendo.toString(amount*exchange_rate, "c2")#</td>
		<td>${dependents[0].dependents}</td>
		<td>#=kendo.toString(dependents[0].dependents*7500, "c2")#</td>
		<td>#=kendo.toString(base_salary, "c2")#</td>
		<td>#=tax_percentate#</td>
		<td>#=salary_tax#</td>
		<td>#kendo.culture("en-US"); # #=kendo.toString(tax_salary_usd, "c2")#</td>
		<td>#=kendo.toString(amount-parseFloat(tax_salary_usd), "c2")#</td>
		<td>#=kendo.toString(advance_deduction,"c2")#</td>
		<td>#=kendo.toString((amount-parseFloat(tax_salary_usd)-advance_deduction), "c2")#</td>
		<td>
			<div class="edit-buttons">
				<a class="k-button-icontext k-edit-button" href="\\#"><span class="k-icon k-edit">Edit</span></a>
	            <a class="k-button-icontext k-delete-button" href="\\#"><span class="k-icon k-delete">Del</span></a>
            </div>
		</td>
	</tr>	
</script>
<script type="text/x-kendo-tmpl" id="editPayrollListTmpl">
# var base_salary = (amount*exchange_rate)-(dependents[0].dependents*75000); #
# var salary_tax, tax_percentate, tax_salary_usd; #
#if(base_salary<=500000) { #
#	tax_percentate = "0%"; #
#	salary_tax = 0; #
#   tax_salary_usd = kendo.toString((salary_tax/exchange_rate),"c2"); #
#} else if(base_salary<=1250000) { #
#	tax_percentate = "5%"; #
#	salary_tax = (base_salary*0.05)-25000; #
#   tax_salary_usd = kendo.toString((salary_tax/exchange_rate),"c2"); #
#} else if (base_salary<=8500000){ #
#	tax_percentate = "10%"; #
#	salary_tax = (base_salary*0.1)-87500; #
#   tax_salary_usd = kendo.toString((salary_tax/exchange_rate),"c2"); #
#} else if (base_salary<=1250000) { #
#	tax_percentate = "15%"; #
#	salary_tax = (base_salary*0.15)-512500; #
#   tax_salary_usd = kendo.toString((salary_tax/exchange_rate),"c2"); #
#} else { #
#	tax_percentate = "20%"; #
#	salary_tax = (base_salary*0.2)-1137500; #
#   tax_salary_usd = kendo.toString((salary_tax/exchange_rate),"c2"); #
#} #
	<tr>
		<td>${staff.first_name}</td>
		<td><input type="text" name="amount" data-bind="value: amount" data-role="numerictextbox" style="width: 100px;"></td>
		<td>#=kendo.toString(amount*exchange_rate, "c3")#</td>
		<td>${dependents[0].dependents}</td>
		<td>#=dependents[0].dependents*7500#</td>
		<td>#=base_salary#</td>
		<td>#=tax_percentate#</td>
		<td>#=salary_tax#</td>
		<td>#kendo.culture("en-US"); tax_salary_usd#</td>
		<td>#=kendo.toString(amount-parseFloat(tax_salary_usd))#</td>
		<td><input type="text" name="advance_deduction" data-bind="value: advance_deduction" data-role="numerictextbox" style="width: 100px;"></td>
		<td>#=kendo.toString((amount-parseFloat(tax_salary_usd)-advance_deduction), "c2")#</td>
		<td>
			<div class="edit-buttons">
                <a class="k-button-icontext k-update-button" href="\\#"><span class="k-icon k-update"></span></a>
                <a class="k-button-icontext k-cancel-button" href="\\#"><span class="k-icon k-cancel"></span></a>
            </div>
		</td>
	</tr>
</script>
<script>

var baseUrl = "<?php echo base_url(); ?>api/";
var payrollList = new kendo.data.DataSource({
	transport: {
		read: {
			url: baseUrl + "payrolls/index",
			dataType: "json",
			type: "GET"
		},
		create: {
			url: baseUrl + "payrolls/index",
			dataType: "json",
			type: "POST"
		},
		update: {
			url: baseUrl + "payrolls/index",
			dataType: "json",
			type: "PUT"
		},
		destroy: {
			url: baseUrl + "payrolls/index",
			dataType: "json",
			type: "DELETE"
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
			id: "id",
			fields: {
				id: { editable: false },
				staff: {},
				amount: { editale: true, type: "number" },
				exchange_rate: { editable: true, type: "number" },
				advance_deduction: { editable: true, type: "number" },
				paid: { editable: true, type: "boolean" }
			}
		}
	},
	pageSize: 30
});

$(function() {
var payrollVM = kendo.observable({
	name 				: "",
	nationality			: "",
	position 			: "",
	g_salary_usd 		: "",
	allowance			: "",
	g_salary_khr 		: function() {
		var gross_salary = parseInt(this.get("g_salary_usd") * this.get("exchange_rate"));
		var allowance   = this.get("dependent") * 75000;
		this.set("allowance", allowance);
		var base_salary = gross_salary - allowance;
		this.set("salary_based_tax", base_salary);
		return gross_salary;
	},
	exchange_rate		: "",
	dependent 			: "",
	salary_based_tax	: "",
	tax_rate			: function() {
		if(this.get("salary_based_tax")<=500000) {
			return "0%";
		} else if(this.get("salary_based_tax")<=1250000) {
			return"5%";
		} else if (this.get("salary_based_tax")<=8500000){
			return "10%";
		} else if (this.get("salary_based_tax")<=1250000) {
			return "15%";
		} else {
			return "20%";
		}

	},
	salary_reciept_kh 	: function(){
		if(this.get("salary_based_tax")<=500000) {
			var usd = parseInt(this.get("salary_based_tax")*0.0)/this.get("exchange_rate");
			return parseInt(this.get("salary_based_tax")*0.0);
		} else if(this.get("salary_based_tax")<=1250000) {
			
			return parseInt(this.get("salary_based_tax")*0.5)-25000;
		} else if (this.get("salary_based_tax")<=8500000){
			var usd = parseInt((this.get("salary_based_tax")*0.1)-87500)/this.get("exchange_rate");
			this.set("salary_reciept_usd", usd);
			return parseInt(this.get("salary_based_tax")*0.1)-87500;
		} else if (this.get("salary_based_tax")<=1250000) {
			
			return parseInt(this.get("salary_based_tax")*0.15)-512500;
		} else {
			
			return parseInt(this.get("salary_based_tax")*0.2)-1137500;
		}
	},
	salary_reciept_usd	: "",
	deduction			: "",
	net_salary_usd		: "",
	generate: function() {
		jQuery.ajax({
			url: baseUrl + "payrolls/generate",
			dataType: 'json',
			type: "POST",
			data: {
				exchange_rate: payrollVM.get("exchange_rate")
			},
			success: function(data) {
				alert("Yeah!");
				payrollList.read();
			},
			error: function(response) {
				//var obj = $.parseJSON(data);
				alert(typeOf(response));
				//alert("សូមពិនិត្យអាត្រាប្ដូរប្រាក់ឡើងវិញ។");
			}
		});
	}
});
	kendo.bind($(".container"), payrollVM);
	var listView = $("#payrollListTable tbody").kendoListView({
		dataSource: payrollList,
		template: kendo.template($("#payrollListTmpl").html()),
		editTemplate: kendo.template($("#editPayrollListTmpl").html())
	}).data('kendoListView');
	var pager = $("#pager").kendoPager({ dataSource: payrollList}).data("kendoPager");
});
</script>