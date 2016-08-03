<div class="container">
	<div class="row">
		<div class="span12">
			<?php $this->load->view('/staff/sidenav'); ?>
		</div>
		<div class="span12">
			<div id="timesheet"></div>
		</div>
	</div>
</div>
<script type="text/kendo-x-tmpl" id="timesheetTmpl">
	<tr>
		<td>${task_id}</td>
		<td>${hours}</td>
		<td>${remark}</td>
		<td>${date_done}</td>
		<td><a href="\\#" class="k-edit-button">Edit</a> | <a href="\\#" class="k-delete-button">Del</a></td>
	</tr>
</script>
<script type="text/kendo-x-tmpl" id="editTimesheetTmpl">
	<tr>
		<td><input type="text" name="task_id" data-type="number" data-role="numerictextbox"></td>
		<td><input type="text" name="hours" data-type="number" data-role="numerictextbox"></td>
		<td>${remark}</td>
		<td><input type="text" name="date" data-type="date" data-role="datepicker" data-bind="value: date"></td>
		<td><a href="\\#" class="k-update-button">Save</a> | <a href="\\#" class="k-cancel-button">Cancel</a></td>
	</tr>
</script>
<script>
var baseUrl 	= "<?php echo base_url(); ?>api/";
var timesheets 	= new kendo.data.DataSource({
		transport	: {
			create	: {
				url	: baseUrl + "tasks/index",
				type: "POST",
				dataType: "json"
			},
			read	: {
				url	: baseUrl + "tasks/index/<?php echo $this->session->userdata('user_id'); ?>",
				type: "GET",
				dataType: "json"
			},
			update	: {
				url	: baseUrl + "tasks/index",
				type: "PUT",
				dataType: "json"
			},
			destroy	: {
				url	: baseUrl + "tasks/index",
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
		pageSize: 20,
		schema: {
			model: {
				id: "id",
				fields: {
					id 				: { editable: false },
					staff 			: { defaultValue: { id: 6, first_name: "Sokdararith"} },
					description		: { editable: false, type: "string" },
					requested_date	: { editable: true, type: "date" },
					finished_date	: { editable: true, type: "date" },
					hours 			: { editable: true, type: "number" },
					due_date 		: { editable: false, type: "date" },
					status 			: { editable: true, type: "string", defaultValue: "not started" },
					priority 		: { editable: false, type: "string", defaultValue: "low" }
				}
			}
		}
});

$(function(){
	var timesheetVM = kendo.observable({
		items 		: [{task_id: "1", hours: "5", remark: "", date_done: "2013-03-13"},
					   {task_id: "1", hours: "5", remark: "", date_done: "2013-03-13"}],
		task_id		: "",
		hours_done	: "",
		remark 		: "",
		date 		: "",
		add			: function(e) {
			/*this.get("items").push({
				task_id 	: this.get("task_id"),
				hours 		: this.get("hours_done"),
				remark 		: this.get("remark"),
				date_done 	: this.get("date")
			});*/
			listView.add();
		},
		remove		: function(e) {
			alert(e.index);
		}
	});
	kendo.bind($(".container"), timesheetVM);
	$(".k-add-button").click(function(e) {
		e.preventDefault();
		listView.add();
	});

	var timesheet = $("#timesheet").kendoGrid({
		dataSource: timesheets,
		toolbar: ["save"],	
		columns: [
			{ title: "Task", field: "id", width: "60px" },
			{ title: "description", field: "description" },
			{ title: "Hours", field: "hours", width: "90px" },
			{ title: "Due Date", field: "due_date", width: "100px", template:"#=kendo.toString(due_date, 'dd-MM-yyyy')#" },
			{ title: "Status", field: "status", width: "100px", editor: statusDropDownEditor },
			{ title: "Priority", field: "priority", width: "100px" }
		],
		editable: true,
		pageable: true,
		groupable: true,
		change: function() {
			this.dataSource.sync();
		}
	}).data("kendoGrid");
	function statusDropDownEditor(container, options) {
        $('<input data-text-field="status" data-value-field="status" data-bind="value:' + options.field + '"/>')
            .appendTo(container)
            .kendoDropDownList({
                dataSource: {
                	transport: {
                		read: {
                			url: baseUrl + "helpers/statuses",
                			type: "GET",
                			dataType: "json"
                		}
                	} 
                }
                
            });
    }
});
</script>
<script type="text/x-kendo-tmpl" id="msgTmpl">
<div class="status">
	<ul class="media-list">
	  <li class="media">
	    <a class="pull-left" href="\\#">
	      <img class="media-object" src="./resources/images/photo.jpg" width="64" height="64">
	    </a>
	    <h2>${id}</h2>
	    <div>${message}</div>
	  </li>
	</ul>
	</div>
</script>
<style scoped>
.k-listview {
	border: 0;
}
</style>