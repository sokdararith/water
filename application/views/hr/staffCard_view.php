<div class="container">
	<div class="row">
		<div id="aside" class="span3">
			<?php $this->load->view('/hr/hrAside_view'); ?>
		</div>
		<div id="content" class="span9">
			<div class="row">
				<div id="cardList"></div>
			</div>
			<div class="pager"></div>
		</div>
	</div>
</div><!--Container-->
<script type="text/x-kendo-tmpl" id="Card">
<div class="span3">
	<div  style="height:100px;">
            Employee Code: <span>${code}</span><br>
            Name: <span>${first_name} ${last_name}</span><br>
            Phone: <span>${phone}</span><br>
            Email: <span>${email}</span>
    </div>
    <hr>

        <a class="k-button-icontext k-edit-button" href="\\#"><span class="k-icon k-edit"></span>Edit</a>
        <a class="k-button-icontext k-delete-button" href="\\#"><span class="k-icon k-delete"></span>Delete</a>
        <a class="k-button-icontext" href="<?php echo base_url(); ?>/staff/profile/${id}"><span class="k-icon k-view"></span>View</a>

</div>
</script>
<script type="text/x-kendo-tmpl" id="editCard">
    <div class="span3">
            <dl>
                <dt>Employee Number</dt>
                <dd>
                    <input class="k-input k-textbox" type="text" data-bind="value:code" name="code" required="required" validationMessage="required" />
                    <span data-for="code" class="k-invalid-msg"></span>
                </dd>
                <dt>First Name</dt>
                <dd>
                    <input class="k-input k-textbox" type="text" data-bind="value:first_name"  name="first_name" required="required" validationMessage="required" />
                    <span data-for="first_name" class="k-invalid-msg"></span>
                </dd>
                <dt>Last Name</dt>
                <dd>
                    <input class="k-input k-textbox" type="text" data-bind="value:last_name" name="last_name" required="required" validationMessage="required" />
                    <span data-for="last_name" class="k-invalid-msg"></span>
                </dd>
                <dt>Email</dt>
                <dd><input class="k-input k-textbox" type="email" name="email" data-bind="value:email" data-type="email"></dd>
                <dt>Phone</dt>
                <dd><input class="k-input k-textbox" type="phone" name="phone" data-bind="value:phone"></dd>
                <dt>Date of Birth</dt>
                <dd><input type="text" name="dob" data-bind="value:dob" data-role="datepicker" data-type="date" data-format="yyyy-MM-dd"></dd>
                <dt>National ID</dt>
                <dd><input type="text" name="id_no" data-bind="value:id_no" data-type="string"></dd>
                <dt>Gender</dt>
                <dd><input type="text" name="gender" data-bind="value:gender"></dd>
            </dl>
            <div class="edit-buttons">
                <a class="k-button-icontext k-update-button" href="\\#"><span class="k-icon k-update"></span>Save</a>
                <a class="k-button-icontext k-cancel-button" href="\\#"><span class="k-icon k-cancel"></span>Cancel</a>
            </div>
        </div>
</script>
<style scoped>
	.k-listview {
		border: 0;
	}
</style>

<script>
$(function() {
	var baseUrl = "<?php echo base_url(); ?>";
	$(".panel").kendoPanelBar({
		expandMode: "single"
	});

	var staff	= new kendo.data.DataSource({
			transport	: {
				read	: {
					url	: baseUrl + "api/employees",
					type: "GET",
					dataType: "json"
				},
				create	: {
					url	: baseUrl + "api/employees",
					type: "POST",
					dataType: "json"
				},
				update	: {
					url	: baseUrl + "api/employees",
					type: "PUT",
					dataType: "json"
				},
				destroy : {
					url	: baseUrl + "api/employees",
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
			pageSize: 10,
			schema: {
				model: {
					id: "id",
					fields: {
						id: {editable: false},
						code: {editable: true, type: "string"},
						first_name: {editable: true, type: "string"},
						last_name: {editable: true, type: "string"},
						email: {editable: true, type: "string"}
					}
				}
			}
	});

	var departments		= new kendo.data.DataSource({
			transport	: {
				read	: {
					url	: baseUrl + "api/departments",
					type: "GET",
					dataType: "json"
				},
				create	: {
					url	: baseUrl + "api/departments",
					type: "POST",
					dataType: "json"
				},
				update	: {
					url	: baseUrl + "api/departments",
					type: "GET",
					dataType: "json"
				},
				destroy : {
					url	: baseUrl + "api/departments",
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
					id: "id",
					fields: {
						name: { editable: true, type: "string", validation: { required: true } }
					}
				}
			},
			pageSize: 10
		})

	/*var grid = $("#cardList").kendoGrid({
			dataSource: staff,
			pageable: true,
			toolbar: ["create","save"],
			columns: [
				{ title: "Code", field: "code"},
				{ title: "first_name", field: "first_name" },
				{ title: "last name", field: "last_name" },
				{ title: "BoD", field: "dob", hidden: true}
			],
			columnMenu: true,
			resizable: true,
			editable: true
	}).data("kendoGrid");*/

	var listView = $("#cardList").kendoListView({
        dataSource: staff,
        template: kendo.template($("#Card").html()),
        editTemplate: kendo.template($("#editCard").html())
    }).data("kendoListView");
	$(".pager").kendoPager({
		dataSource: staff
	});
	//setting up click action for delete staff
	$("#cardList").on("click", ".k-edit-button", function(e) {
		e.preventDefault();
		//var target 	= $(e.currentTarget);
		//var id		= target.data('id');
		$("#department_id").kendoDropDownlist({
			dataSource: departments,
			dataTextField: "name",
			dataValueField: "id" 
		});
	});
});
</script>