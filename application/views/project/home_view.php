<div class="container">
	<div class="row">
		<div class="span12">
			<?php $this->load->view($aside_bar); ?>
		</div>
		<div class="span12">
			<div>
				<a href="#" id="newProject" class="btn"><i class="icon-plus"></i> Create New</a>	
			</div>
			<p></p>			
			<div id="projects" >
				
			</div>
			<div id="pager"></div>
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
<script type="text/x-kendo-tmpl" id="project">
	<div class="project">
		<div><strong><a href="\\#/detail/#=id#">#=project_name#</a></strong>(#=tasks#)</div>
		<div>
			<span>Start: #=kendo.toString(start_on, "dd-MM-yyyy")#</span>&nbsp;|&nbsp;
			<span>End: #=kendo.toString(end_date, "dd-MM-yyyy")#</span>&nbsp;|&nbsp;
			<span>Funded By: #=funded_by#</span>&nbsp;|&nbsp;
		</div>
		<div>
			#=description#
		</div>
		<div class="edit-buttons">
			<a class="k-button-icontext k-edit-button" href="\\#"><span class="k-icon k-edit"></span></a>
	        <a class="k-button-icontext k-delete-button" href="\\#"><span class="k-icon k-delete"></span></a>
	    </div>
	</div>
</script>
<script type="text/x-kendo-tmpl" id="editProject">
	<div class="project">
		<label for="title">ឈ្មោះ</label>
		<input type="text" name="title" data-bind="value:project_name" data-type="string">
		<label for="start_date">Start Date</label>
		<input type="text" name="start_date" data-bind="value:start_on" data-type="date" data-role="datepicker">
		<label for="end_date">End Date</label>
		<input type="text" name="end_date" data-bind="value:end_date" data-type="date" data-role="datepicker">
		<span>Funded By: #=funded_by#</span>&nbsp;|&nbsp;
		<label for="description">Description</label>
			<textarea type="text" name="description" id="description" placeholder="Description" data-bind="value:description"></textarea
		<div class="edit-buttons">
            <a class="k-button-icontext k-update-button" href="\\#"><span class="k-icon k-update"></span></a>
            <a class="k-button-icontext k-cancel-button" href="\\#"><span class="k-icon k-cancel"></span></a>
        </div>
	</div>
</script>
<script>
var baseUrl 	= "<?php echo base_url(); ?>";
var projects	= new kendo.data.DataSource({
		transport	: {
			read	: {
				url	: baseUrl + "api/projects",
				type: "GET",
				dataType: "json"
			},
			create	: {
				url	: baseUrl + "api/projects",
				type: "POST",
				dataType: "json"
			},
			update	: {
				url	: baseUrl + "api/projects",
				type: "PUT",
				dataType: "json"
			},
			destroy : {
				url	: baseUrl + "api/projects",
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
					id 				: { editable: false, type: "number", validation: { required: true } },
					project_name	: { editable: true, type: "string", validation: { required: true } },
					description 	: { editable: true, type: "string", validation: { required: false } },
					start_date 		: { editable: true, type: "date", validation: { required: false } },
					end_date 		: { editable: true, type: "date", validation: { required: false } }
				}
			},
			data: "projects",
			count: "count"
		}
});
function createNew() {
	
}
$(function(){
	var projectListView = $("#projects").kendoListView({
        dataSource: projects,
        template: kendo.template($("#project").html()),
        editTemplate: kendo.template($("#editProject").html())
    }).data("kendoListView");
	$("#pager").kendoPager({dataSource:projects});
    $("#newProject").click(function(e){
		e.preventDefault();
		projectListView.add();
	});
})(jquery)
</script>