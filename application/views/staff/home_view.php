
	<div class="span3">
		<div id="staffList">
			
			<table id="list" class="table">
				<tbody></tbody>
			</table>
			<div class="pager"></div>
		</div><!--staffLit-->
	</div>
	<div id="detail" class="span9">
		<div>
			<div class="navbar">
				<div class="navbar-inner">
					<ul class="nav">
						<li><a href="#">Dashboard</a></li>
						<li><a href="#/createNew">New Staff</a></li>
					</ul>
				</div>
			</div> 
			<div id="application"></div>
		</div>
	</div><!--detail-->

<script type="text/x-kendo-template" id="staffListTmpl">
	<tr>
		<td><a href="\\#/e/#=id#" class="emp">#=fullname#</a></td>
	</tr>
</script>
<script type="text/x-kendo-template" id="layoutTmpl">
	<div id="app"></div>
</script>
<script type="text/x-kendo-template" id="staffLayoutTmpl">
	<div id="info">
		<div class="row">
			<div class="span4">
				<img data-bind="attr: { src: current.image_url}"><br>
				<p>Contract No: <span data-bind="text: current.contract_ref"></span></p>
			</div>
			<div class="span5">
				<table class="table table-condensed">
					<tbody>
						<tr>
							<td>Name:</td>
							<td><span data-bind="text: current.fullname"></span></td>
						</tr>
						<tr>
							<td>Address:</td>
							<td><span data-bind="text: current.location"></span></td>
						</tr>
						<tr>
							<td>Gender:</td>
							<td><span data-bind="text: current.gender"></span></td>
						</tr>
						<tr>
							<td>Phone:</td>
							<td><span data-bind="text: current.phone"></span></td>
						</tr>
						<tr>
							<td>Email:</td>
							<td><span data-bind="text: current.email"></span></td>
						</tr>
					</tbody>
				</table>
				<hr>
				<a href="#/newTask">Create Task</a>&nbsp;|&nbsp;
				<a href="#/viewTimesheet">View Timesheet</a>&nbsp;|&nbsp;
				<a href="#/detail">Detail Information</a>
			</div>
		</div>
	</div>
	<hr>
	<div id="staffDetail"></div>
</script>
<!---fd-->
<script type="text/x-kendo-template" id="dashboardTmpl">
	Dashboard
</script>
<script type="text/x-kendo-template" id="newTmpl">
	Create New E
</script>
<script type="text/x-kendo-template" id="detailTmpl">
	<span data-bind="text: current.department.name"></span>
</script>
<!--detail-->
<script>
	var employeeDS = new kendo.data.DataSource({
		transport	: {
			read	: {
				url	: ARNY.baseUrl + "api/employees",
				type: "GET",
				dataType: "json",
			},
			create	: {
				url	: ARNY.baseUrl + "api/employees",
				type: "POST",
				dataType: "json"
			},
			update	: {
				url	: ARNY.baseUrl + "api/employees",
				type: "PUT",
				dataType: "json"
			},
			destroy : {
				url	: ARNY.baseUrl + "api/employees",
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
			},
			data: "employees",
			total: "total"
		},
		serverPaging: true,
		pageSize: 1
	});

	var employeeModel = kendo.observable({
		setEmployee  	: function(eID) {
			this.set("current", employeeDS.get(eID));
		},
		departments 	: "",
		nationalities 	: "",
		jobs 			: "",
		genders 		: ["Male", "Female"],
		department 		: "",
		job 			: "",
		nationality 	: "",
	});

	var layout = new kendo.Layout("layoutTmpl");
	var staffLayout = new kendo.Layout("staffLayoutTmpl", {model: employeeModel});
	var dashboard = new kendo.View("dashboardTmpl");
	var detailInfo = new kendo.View("detailTmpl", {model: employeeModel});
	var createE = new kendo.View("newTmpl");
	//router
	var router = new kendo.Router({
		init: function() {
			layout.render("#application");
		}
	});

	router.route("/", function() {
		layout.showIn("#app", dashboard);
	});

	router.route("/e/:id", function(eID) {
		layout.showIn("#app", staffLayout);
		employeeModel.setEmployee(eID);

	});
	router.route("/detail", function() {
		staffLayout.showIn("#staffDetail", detailInfo);

	});
	router.route("/createNew", function() {
		layout.showIn("#app", createE);
	});
	$(function() {
		$("#list > tbody").kendoListView({
			dataSource: employeeDS,
			template: kendo.template($("#staffListTmpl").html())
		}).data("kendoListView");
		$(".pager").kendoPager({dataSource: employeeDS});
		router.start();
	});
</script>
<style scoped>
	.emp {
		display: block;
	}
	.emp:hover {
		text-decoration: none;
		color: #000; 
	}

</style>