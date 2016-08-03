<div class="container">
	<div class="row">
		<div class="span12">
			<?php $this->load->view($aside_bar); ?>
		</div>
		<div class="span12">
			<a href="#/new_task">New</a>
			<div id="application"></div>
			<div id="taskGrid"></div>
		</div>
	</div>
</div>
<style scoped>
	.k-listview {
		border: 0;
	}
	.status {
		border-bottom: 1px solid #ccc;
		padding-top: 25px;
		padding-bottom: 25px;
	}
	.status:last-child {
		border-bottom: 0;
	}
</style>
<script type="text/x-kendo-template" id="layout">
	<div id="app"></div>
</script>
<script type="text/x-kendo-template" id="listTmpl">
	<div data-role="listview" data-bind="source: list" data-template="taskTmpl"></div>
</script>
<script type="text/x-kendo-template" id="createTask">
	<div id="newtask" class="well">
		<table>
			<tr>
				<td colspan="3">
					<label for="title">Title<superscript>*</superscript>:</label>
					<input type="text" id="title" data-bind="value: title" placeholder="ការងារ" style="width: 98%;">
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<label for="description">ព័ណនា</label>
					<textarea name="description" data-bind="value: description" cols="30" rows="10"></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label for="dueDate">Due Date<superscript>*</superscript>:</label>
					<input type="text" id="dueDate" data-bind="value: due_date" data-role="datepicker">
					<label for="assignTo">ទទួលខុសត្រូវ<superscript>*</superscript>:</label>
					<input type="text" id="assignTo" data-bind="source: employees, value: assigned_to" data-role="dropdownlist" data-text-field="fullname" data-value-field="id" placeholder="ទទួលខុសត្រូវ">
				</td>
				<td>
					<label for="project">គំរោង:</label>
					<input type="text" id="project" data-bind="source: projectList, value: project" data-role="dropdownlist" data-text-field="project_name" data-value-field="id">
					<label for="priority">អទិភាព:</label>
					<input type="text" id="priority" data-bind="source: priorityList, value: priority" data-role="dropdownlist" data-text-field="priority" data-value-field="priority" placeholder="ទទួលខុសត្រូវ">
				</td>
			</tr>
			<tr>
				<td>
					<button id="addTask" data-bind="click: create"><?=$this->lang->line('button_save'); ?></button>
					<button id="addTask" data-bind="click: cancel"><?=$this->lang->line('button_cancel'); ?></button>
				</td>
			</tr>
		</table>
	</div>
</script>
<script type="text/x-kendo-template" id="editTask">
	<div id="newtask" class="well">
		<table>
			<tr>
				<td colspan="3">
					<label for="title">Title<superscript>*</superscript>:</label>
					<input type="text" id="title" data-bind="value: title" placeholder="ការងារ" style="width: 98%;">
					<label for="status">Status:</label>
					<input type="text" id="title" data-bind="source: statusList, value: status" data-role="dropdownlist" data-text-field="status" data-value-field="status" placeholder="ការងារ" style="width: 100%;">
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<label for="description">ព័ណនា</label>
					<input type="text" name="description" data-bind="value: description" style="width: 98%;">
				</td>
			</tr>
			<tr>
				<td>
					<label for="dueDate">Due Date<superscript>*</superscript>:</label>
					<input type="text" id="dueDate" data-bind="value: due_date" data-role="datepicker">
					<label for="assignTo">ទទួលខុសត្រូវ<superscript>*</superscript>:</label>
					<input type="text" id="assignTo" data-bind="source: employees, value: assigned_to" data-role="dropdownlist" data-text-field="fullname" data-value-field="id" placeholder="ទទួលខុសត្រូវ">
				</td>
				<td>
					<label for="project">គំរោង:</label>
					<input type="text" id="project" data-bind="source: projectList, value: project" data-role="dropdownlist" data-text-field="project_name" data-value-field="id">
					<label for="priority">អទិភាព:</label>
					<input type="text" id="priority" data-bind="source: priorityList, value: priority" data-role="dropdownlist" data-text-field="priority" data-value-field="priority" placeholder="ទទួលខុសត្រូវ">
				</td>
			</tr>
			<tr>
				<td>
					<button id="addTask" data-bind="click: update"><?=$this->lang->line('button_update'); ?></button>
					<button id="addTask" data-bind="click: cancel"><?=$this->lang->line('button_cancel'); ?></button>
				</td>
			</tr>
		</table>
	</div>
</script>
<script type="text/x-kendo-tmpl" id="taskTmpl">
	<div class="task">
		<strong class="title"><a href="\\#/edit/#=id#">#=title#</a></strong><br>
		<span class="meta">Created By: #=creator.last_name# #=creator.first_name#</span>&nbsp;|&nbsp;
		<span class="meta">ទទួលខុសត្រូវ: #=assigned_to.last_name# #=assigned_to.first_name#</span>&nbsp;|&nbsp;
		<span class="meta">Due: #=kendo.toString(due_date, 'dd, MM, yyyy')#</span>&nbsp;|&nbsp;
		<span class="meta">ស្ថានភាព: #=status#</span>
		<span class="priority">#=priority#</span>
		<br>
		
		<p class="description">#=description#</p>
	</div>
</script>
<script>
//all declarations

//ds or collection
var tasks = new kendo.data.DataSource({
		transport	: {
			read	: {
				url	: ARNY.baseUrl + "api/tasks",
				type: "GET",
				dataType: "json"
			},
			create	: {
				url	: ARNY.baseUrl + "api/tasks",
				type: "POST",
				dataType: "json"
			},
			update	: {
				url	: ARNY.baseUrl + "api/tasks/update",
				type: "PUT",
				dataType: "json"
			},
			destroy : {
				url	: ARNY.baseUrl + "api/tasks",
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
		pageSize: 30,
		serverSorting: true,
		schema: {
			model: {
				id: "id",
				fields: {
					id: {},
					assigned_to: {},
					creator: {},
					project_id: {},
					service_id: {},
					title: {},
					description: {},
					requested_date: {},
					finished_date: {},
					hours: {},
					due_date: {},
					status: {},
					priority: {}
				}
			}
		}
});
var employees = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/employees",
				dataType: "json"
			}
		}
});
var projects = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/projects",
				dataType: "json"
			}
		},
		schema: {
			data: "projects",
			count: "count"
		}
});
$("#priority").kendoDropDownList({
	dataSource: new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/helpers/priorities",
				dataType: "json"
			}
		}
	}),
	dataTextField: "priority",
	dataValueField: "priority"
});

var listModel = kendo.observable({
	list 		: tasks,
	projectList	: projects,
	employees 	: employees,
	priorityList: [
		{ id: 1, priority:"ទាប"},
		{ id: 2, priority:"មធ្យម"},
		{ id: 3, priority:"ខ្ពស់"}
	],
	statusList 	: [
		{ id: 1, status: "មិនទាន់ចាប់ផ្ដើម"},
		{ id: 2, status: "ផ្អាក់"},
		{ id: 3, status: "កំពុងដំណើរការ"},
		{ id: 4, status: "រងចាំ"},
		{ id: 5, status: "ចប់"},
	],
	assigned_to : "",
	project 	: "",
	creator 	: <?php echo $this->session->userdata('user_id'); ?>,
	due_date 	: "",
	title 		: "",
	status 		: "មិនទាន់ចាប់ផ្ដើម",
	description : "",
	priority 	: "ទាប",
	id 			: "", 
	create 		: function() {
		tasks.add({
			assigned_to 	: this.get("assigned_to"),
			creator 		: this.get("creator"),
			project_id 		: this.get("project"),
			due_date 		: this.get("due_date"),
			title 			: this.get("title"),
			status 			: "មិនទាន់ចាប់ផ្ដើម",
			description 	: this.get("description"),
			priority 		: this.get("priority")
		});
		tasks.sync();
		this.set("assigned_to", "");
		this.set("project", "");
		this.set("due_date", "");
		this.set("status", "មិនទាន់ចាប់ផ្ដើម");
		this.set("description", "");
		this.set("title", "");
		this.set("priority", "ទាប");
		router.navigate("/");
	},
	update: function() {
		var model = tasks.get(this.get('id'));
		model.set("title", this.get("title"));
		model.set("description", this.get("description"));
		model.set("status", this.get("status"));
		model.set("due_date", this.get("due_date"));
		model.set("assigned_to", this.get("assigned_to"));
		model.set("project", this.get("project"));
		model.set("priority", this.get("priority"));
		tasks.sync();
		this.set("assigned_to", "");
		this.set("project", "");
		this.set("due_date", "");
		this.set("status", "មិនទាន់ចាប់ផ្ដើម");
		this.set("description", "");
		this.set("title", "");
		this.set("priority", "ទាប");
		router.navigate("/");
	},
	cancel 		: function() {
		this.set("assigned_to", "");
		this.set("project", "");
		this.set("due_date", "");
		this.set("status", "មិនទាន់ចាប់ផ្ដើម");
		this.set("description", "");
		this.set("title", "");
		this.set("priority", "ទាប");
		router.navigate("/");
	}
});

var layout 		= new kendo.Layout("#layout");
var createView 	= new kendo.View("#createTask", { model: listModel });
var listView 	= new kendo.View("#listTmpl", { model: listModel });
var editView 	= new kendo.View("#editTask", { model: listModel });

var router = new kendo.Router({
	init: function(){
		layout.render("#application");
	}
});

router.route("/", function(){
	layout.showIn("#app", listView);
});

router.route("/new_task", function() {
	layout.showIn("#app", createView);
});

router.route("/edit/:id", function(taskID) {
	layout.showIn("#app", editView);
	var task = tasks.get(taskID);
	listModel.set("id", task.id);
	listModel.set("title", task.title);
	listModel.set("description", task.description);
	listModel.set("due_date", task.due_date);
	listModel.set("status", task.status);
	listModel.set("assigned_to", task.assigned_to);
	listModel.set("project", task.project);
	listModel.set("priority", task.priority);
});

$(function(){
	router.start();
});
</script>

<style scoped>
.task {
	padding: 5px;
	margin-top: 2px;
	border: 1px solid #ccc;
	position: relative;
}
.task:hover {
	background-color: #999;
}
.priority {
	position: absolute;
	top: -1px;
	right: -1px;
	width: 100px;
	padding: 3px;
	border-bottom-left-radius: 5px;
	background-color: #eee;
	color: red;
	text-align: center;
	font-weight: bold;
	border: 1px solid #ccc;
}
.meta {
	width: 300px;
}
</style>