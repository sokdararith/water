<div class="container">
	<div class="row">
		<div id="content" class="span12">
			<?php $this->load->view('/hr/toolbar'); ?>
            <div id="wndDepartment">
                <div class="input-append" style="padding:5px;">
                    <input style="width: 225px" id="department" type="text" placeholder="Department">
                    <button class="btn" type="button" id="btnDept">ថែម</button>
                </div>
            </div>
            <div id="wndNationality">
                <div class="input-append" style="padding:5px;">
                    <input style="width: 225px" id="appendedInputButton" type="text" data-bind="value: nationality" placeholder="Nationality">
                    <button class="btn" type="button" data-bind="click: btnNationality">ថែម</button>
                </div>
            </div>

			<div id="employeeList" data-bind="visible: showStaff">
                <table id="empListView" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Birth Date</th>
                            <th>Gender</th>
                            <th>Contract Ref.</th>
                            <th>Start Date</th>
                            <th>Year of Service</th>
                            <th><abbr title="Curriculum of Vitae">CV</abbr></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                </table> 
                <div id="empListPager"></div>        
            </div>
			<div id="newStaff" data-bind="visible: showAddStaff">
                <div id="tabStrip">
                    <ul>
                        <li class="k-state-active">General Information</li>
                        <li>Company Information</li>
                    </ul>
                    <div id="general">
                        <div class="something">
                        <table class="table table-striped">
                            <tr>
                                <td>
                                    <label for="nationalID">National ID</label>
                                    <input class="k-textbox" type="text" name="nationalID" id="nationalID" data-bind="value: id_card" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" />
                                </td>
                                <td>
                                    <label for="nationality">Nationality</label>
                                    <input type="text" name="nationality" id="nationality" data-bind="value: nationality, source: nationalityDS" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-role="combobox" data-text-field="nationality" data-value-field="id" data-placeholder="Select One" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="firstName">First Name</label>
                                    <input class="k-textbox" type="text" name="firstName" id="firstName" data-bind="value: first_name" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" />
                                </td>
                                <td>
                                    <label for="lastName">Last Name</label>
                                    <input class="k-textbox" type="text" name="lastName" id="lastName" data-bind="value: last_name" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="phone">Phone</label>
                                    <input class="k-textbox" type="text" name="phone" id="phone" data-bind="value: phone" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" />
                                </td>
                                <td>
                                    <label for="email">Email</label>
                                    <input class="k-textbox" type="text" name="email" id="email" data-bind="value: email" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="gender">Gender</label>
                                    <input type="text" name="gender" id="gender" placeholder="ភេទ" data-bind="value: gender, source:genders" data-role="dropdownlist" data-text-field="gender" data-value-field="id" data-placeholder="Select One" />
                                </td>
                                <td>
                                    <label for="dob">DoB</label>
                                    <input type="text" name="dob" id="dob" placeholder="ថ្ងៃខែឆ្នាំកំណើត" data-bind="value: dob" data-role="datepicker" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="maritalStatus">Marital Status</label>
                                    <input type="text" name="maritalStatus" id="maritalStatus" placeholder="រៀបការ" data-bind="value: marital_status, source:marital_statuses" data-role="dropdownlist" data-text-field="status" data-value-field="id" />
                                </td>
                                <td>
                                    <label for="imageUrl"></label>
                                    <div style="width:80%">
                                        <input name="userfile" class="userfile" id="userfile" type="file" />
                                    </div>
                                </td>
                            </tr>
                        </table>                        
                        </div>
                    </div>
                    <div id="company">
                        <div class="something">
                        <table class="table table-striped">
                            <tr>
                                <td>
                                    <label for="staffID">Staff ID</label>
                                    <input class="k-input k-textbox" type="text" name="staffID" id="staffID" data-bind="value:code" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" />
                                </td>
                                <td>
                                    <label for="lineManager">Line Manager</label>
                                    <input class="k-input k-text k-lone-widget" type="text" name="lineManager" id="lineManager" data-bind="value: line_manager, source: employeeDS" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-role="combobox"  data-text-field="first_name" data-value-field="id" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="job">Job Title</label>
                                    <input class="k-input k-text"type="text" name="job" id="job" data-bind="value: job, source:jobDS" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-role="combobox" data-value-field="id" data-text-field="title"  />
                                </td>
                                <td>
                                    <label for="department">Department</label>
                                    <input class="k-input k-text" type="text" name="department" id="department" data-bind="value: department, source:departmentDS" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-role="combobox" data-text-field="name" data-value-field="id" data-placeholder="Select One" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="dateHired">Date Hired</label>
                                    <input type="text" name="dateHired" id="dateHired" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-bind="value: date_hired" data-role="datepicker" />
                                </td>
                                <td>
                                    <label for="contractRef">Contract Ref.</label>
                                    <input class="k-input k-textbox" type="text" name="contractRef" id="contractRef" data-bind="value:contract_ref" placeholder="លេខបន្ទាន់" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="emmergencyContact">Emmergency Contact</label>
                                    <input class="k-input k-textbox" type="text" name="emmergencyContact" id="emmergencyContact" data-bind="value: emmergency_con" placeholder="លេខបន្ទាន់" />
                                </td>
                                <td>
                                    <label for="address">Address</label>
                                    <textarea class="k-input k-textarea" type="text" name="address" id="addres" data-bind="value: address" placeholder="រូបភាព" /></textarea>
                                </td>
                            </tr>
                        </table>
                        </div>
                    </div>
                </div><!--tabStrip-->
                <p></p>
                <span class="btn btn-large" data-bind="click: save, visible: btnSave">Save</span>
                <span class="btn btn-large" data-bind="click: update, visible: btnUpdate">Update</span>
                <span class="btn btn-large" data-bind="click: cancel, visible: btnCancel">Cancel</span>
            </div><!--newStaff-->
		</div>
	</div>
</div><!--Container-->

<script>
var baseUrl = "<?php echo base_url(); ?>";
var employees = new kendo.data.DataSource({
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
                        return {
                            models: kendo.stringigy(options.models)
                        };
                    }
                    return options;
                }
            },
            schema: {
                model: {
                    id: "id",
                    fields: {
                        code				: { type: "string" },
                        company_id			: { type: "number" },
                        national_id			: { type: "string" },
                        nationality			: { type: "string" },
                        first_name			: { type: "string" },
                        last_name			: { type: "string" },
                        email				: { type: "string" },
                        phone				: { type: "string" },
                        image_url			: { type: "string" },
                        dob					: { type: "date" },
                        gender				: { type: "string" },
                        marital_status		: { type: "string" },
                        address				: { type: "string" },
                        login_credential_id	: { type: "number" },
                        contract_ref        : { type: "string" },
                        line_manager_id		: { type: "number" },
                        job_id				: { type: "number" },
                        department_id		: { type: "number" },
                        hired_at			: { type: "date" }
                    }
                }
            },
            pageSize: 20,
            error: function(e) {
                var obj = $.parseJSON(e.responseText);
                alert(obj.message);
            },
            requestEnd: function(e) {
                switch(e.type) {
                    case "create": 
                    //let user know it is created
                    alert("Created");
                    staffGrid.refresh();
                    break;
                    case "update":
                    //let user know it is updated
                    var obj = e.response;
                    alert(obj.status);
                    staffGrid.refresh();
                    break;
                    case "delete":
                    //let user know it is deleted
                    break;
                }
            }
});

var spouses = new kendo.data.DataSource({
    transport	: {
        read	: {
            url	: "",
            type: "GET",
            dataType: "json"
        },
        create	: {
            url	: "",
            type: "POST",
            dataType: "json"
        },
        update	: {
            url	: "",
            type: "PUT",
            dataType: "json"
        },
        destroy : {
            url	: "",
            type: "DELETE",
            dataType: "json"
        },
        parameterMap : function(options, operation) {
            if( operation !== "read" && options.models ) {
                return {
                    models: kendo.stringigy(options.models)
                };
            }
            if( operation === "read") {
                return { staff_id : staffVM.get("selectedStaff") }
            }
            return options;
        }
    },
    change		: function(e) {
        
    }
});

var children = new kendo.data.DataSource({
            transport	: {
                read	: {
                    url	: baseUrl + "staff/kids",
                    type: "GET",
                    dataType: "json"
                },
                create	: {
                    url	: baseUrl + "staff/kids",
                    type: "POST",
                    dataType: "json"
                },
                update	: {
                    url	: baseUrl + "staff/kids",
                    type: "PUT",
                    dataType: "json"
                },
                destroy : {
                    url	: baseUrl + "staff/kids",
                    type: "DELETE",
                    dataType: "json"
                },
                parameterMap : function(options, operation) {
                    if( operation !== "read" && options.models ) {
                        return {
                            models: kendo.stringigy(options.models)
                        };
                    }
                    return options;
                }
            },
            change		: function(e) {
        
            }
});
var nationalities = new kendo.data.DataSource({
    transport	: {
        read	: {
            url	: baseUrl + "api/nationalities",
            type: "GET",
            dataType: "json"
        },
        create	: {
            url	: baseUrl + "api/nationalities",
            type: "POST",
            dataType: "json"
        },
        update	: {
            url	: baseUrl + "api/nationalities",
            type: "GET",
            dataType: "json"
        },
        destroy : {
            url	: baseUrl + "api/nationalities",
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
                nationality: { editable: true, type: "string", validation: { required: true } }
            }
        }
    },
    pageSize: 10
});

var departments = new kendo.data.DataSource({
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
});

var positions 		= new kendo.data.DataSource({
    transport	: {
        read	: {
            url	: baseUrl + "api/positions",
            type: "GET",
            dataType: "json"
        },
        create	: {
            url	: baseUrl + "api/positions",
            type: "POST",
            dataType: "json"
        },
        update	: {
            url	: baseUrl + "api/positions",
            type: "GET",
            dataType: "json"
        },
        destroy : {
            url	: baseUrl + "api/positions",
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
                title: { editable: true, type: "string", validation: { required: true } },
                description: { editble: true, type: "string" }
            }
        }
    },
    pageSize: 10
});
var wndDepartment = $("#wndDepartment").kendoWindow({
    title: "Department",
    width: "315px",
    modal: true,
    visible: false
}).data("kendoWindow");
var wndStaffEdit = $("#wndStaffEdit").kendoWindow({
    title: "Department",
    width: "950px",
    modal: true,
    visible: false
}).data("kendoWindow");
var wndNationality = $("#wndNationality").kendoWindow({
    title: "Nationality",
    width: "315px",
    modal: true,
    visible: false
}).data("kendoWindow");
$(function() {  
    $("#tabStrip, #tabStripEdit").kendoTabStrip();
    $(".userfile").kendoUpload({
        async: {
            saveUrl: baseUrl +"/api/files/do_upload_image",
            removeUrl: "remove",
            autoUpload: true
        },
        localization: {
            dropFilesHere: "ទំលាក់រួបភាពទីនេះ",
            select : "រើសយករូប",
            statusUploading: "កំពុងទទួលយករូបភាព",
            statusFailed: "មិនអាចផ្ញើរ",
            retry: "សាកល្បងម្ដងទៀត",
            cancel: "មោឃ៖ភាព"
        },
        showFileList: false,
        success: function(e) {
            var files = e.files;
            var name, path;
            $.each(files, function(index, value){
                path = "./../uploads/pictures/" + value.name;
                staffVM.set("image_url", path);
            });
        } 
    });
    var staffVM = kendo.observable({
       employeeDS : employees,
       nationalityDS: nationalities,
       departmentDS: departments,
       jobDS       : positions,
	   children    : [],
	   spouses     : [],
       toDo        : [],
       genders     : [
                { id : "ប្រុស", gender : "ប្រុស" },
                { id : "ស្រី", gender : "ស្រី" },
        ],
        marital_statuses: [
                            { id : "single", status: "Single" },
                            { id : "married", status: "Married" },
                            { id : "divorced", status: "Divoiced" },
                            { id : "separated", status: "Separated" }
        ],
        emp_id     : "",
	   code        : "",
	   id_card     : "",
       nationality : "",
	   first_name  : "",
       last_name   : "",
       phone       : "",
       email       : "",
       dob         : "",
       gender      : "",
       address     : "",
       department  : "",
       contract_ref: "",
       job         : [],
       line_manager: "",
       date_hired  : "",
       emmergency_con: "",
       showStaff   : true,
       showAddStaff: false,
       addStaff    : function () {
            if(this.get('showStaff')) {
                this.set('showStaff', false);
                this.set('showAddStaff', true);
            } else {
                this.set('showStaff', true);
                this.set('showAddStaff', false);
            }            
       },
       addChild    : function () {

       },
       addWife     : function () {

       },
       addToDo     : function () {

       },
       showDept  : function () {
            wndDepartment.center().open();
       },
       addDept     : function (e) {
            if( this.get('department') != "" ) {
                this.get('departmentDS').add({ name: this.get('department'), deletable: "true" });
                this.get('departmentDS').sync();
            } else {
                alert("សូមបញ្ចូលឈ្មោះការិយាល័យ");
            } 
       },
       showNation  : function () {
            wndNationality.center().open();
       },
       addNation   : function () {

       },
       addJob      : function () {

       },
       editStaff    : function () {
            empList.edit(empList.element.children().first());
       },
       btnSave      : true,
       btnUpdate    : true,
       btnCancel    : true,
       btnDepartment: function(e) {

       },
       save         : function(e) {
            employees.add({
                id_no           : staffVM.get("id_card"),
                natinoality_id  : staffVM.get("nationality"),
                first_name      : staffVM.get("first_name"),
                last_name       : staffVM.get("last_name"),
                phone           : staffVM.get("phone"),
                email           : staffVM.get("email"),
                gender          : staffVM.get("gender"),
                dob             : staffVM.get("dob"),
                marital_status  : staffVM.get("marital_status"),
                code            : staffVM.get("code"),
                line_manager_id : staffVM.get("line_manager"),
                job_id          : staffVM.get("job"),
                department_id   : staffVM.get("department"),
                hired_at        : staffVM.get("date_hired"),
                contract_ref    : staffVM.get("contract_ref"),
                emmergency_contact : staffVM.get("emmergency_con"),
                address         : staffVM.get("address")
            });
            employees.sync();
       },
       update       : function(e) {
                var model = employees.get(this.get("emp_id"));
                model.set("id_no", staffVM.get("id_card"));
                model.set("natinoality_id", staffVM.get("natinoality"));
                model.set("first_name", staffVM.get("first_name"));
                model.set("last_name", staffVM.get("last_name"));
                model.set("phone", staffVM.get("phone"));
                model.set("email", staffVM.get("email"));
                model.set("gender", staffVM.get("gender"));
                model.set("dob", staffVM.get("dob"));
                model.set("marital_status", staffVM.get("marital_status"));
                model.set("code", staffVM.get("code"));
                model.set("line_manager_id", staffVM.get("line_manager"));
                model.set("job_id", staffVM.get("job"));
                model.set("department_id", staffVM.get("department"));
                model.set("hired_at", staffVM.get("date_hired"));
                model.set("contract_ref", staffVM.get("contract_ref"));
                model.set("emmergency_contact", staffVM.get("emmergency_con"));
                model.set("address", staffVM.get("address"));
                employees.sync();
       }
     });
    kendo.bind($(".container"), staffVM);

    var empList = $("#empListView tbody").kendoListView({
        dataSource  : employees,
        template    : kendo.template($("#empListViewTmpl").html())
    }).data("kendoListView");
    $("#empListPager").kendoPager({
        dataSource  : employees
    });
    $("#empListView").on("click", ".edit", function(e){
        this.preventDefault;
        var target  = $(e.currentTarget);
        var id      = target.data("id");
        var emp     = employees.get(id);
        staffVM.set("emp_id", emp.id);
        staffVM.set("id_card", emp.id_no);
        staffVM.set("nationality", emp.nationality_id);
        staffVM.set("first_name", emp.first_name);
        staffVM.set("last_name", emp.last_name);
        staffVM.set("phone", emp.phone);
        staffVM.set("email", emp.email);
        staffVM.set("gender", emp.gender);
        staffVM.set("dob", emp.dob);
        staffVM.set("marital_status", emp.marital_status);
        staffVM.set("code", emp.code);
        staffVM.set("line_manager", emp.line_manager_id);
        staffVM.set("job", emp.job_id);
        staffVM.set("department", emp.department_id);
        staffVM.set("date_hired", emp.hired_at);
        staffVM.set("contract_ref", emp.contract_ref);
        staffVM.set("emmergency_con", emp.emmergency_contact);
        staffVM.set("address", emp.address);
        staffVM.set("showStaff", false);
        staffVM.set("showAddStaff", true);
        staffVM.set("btnSave", false);
        //wndStaffEdit.center().open();
    });
    $("#empListView").on("click", ".del", function(e){
        this.preventDefault;
        var target  = $(e.currentTarget);
        var id      = target.data("id");
        var emp     = employees.get(id);
        var conf    = confirm("Are you sure you want to delete " + emp.first_name);

        if(conf) {
            employees.remove(emp);
            employees.sync();
        }
    });

    $("#wndDepartment").on("click", "#btnDept", function(e){
        if( $("#department").val() != "" ) {
            this.get('departmentDS').add({ name: $("#department").val(), deletable: "true" });
            this.get('departmentDS').sync();
        } else {
            //alert("សូមបញ្ចូលឈ្មោះការិយាល័យ");
            alert($("#department").val());
        } 
    });
});
</script>

<script type="text/x-kendo-tmpl" id="empListViewTmpl">
    # var hired     = new Date(hired_at).getTime(); #
    # var now       = new Date(); #
    # var one_day   = 1000*60*60*24; #
    # var days      = (now.getTime() - hired)/one_day; #
    # var year      = Math.floor(days/365); #
    # var month     = Math.floor(year%12); #
    # if (year > 1 ) { #
    #    year += " yrs"; #
    # } else { #
    #   year += " yr"; #
    # } #
    # if (month > 1 ) { #
    #    month += " months"; #
    # } else { #
    #   month += " month"; #
    # } #
    <tr>
        <td>
            <span>#:first_name#</span>&nbsp;<span>#:last_name#</span>
        </td>
        <td>#=department.name#</td>
        <td>#= kendo.toString(dob, 'yyyy-MM-dd') #</td>
        <td>#=gender#</td>
        <td>#=contract_ref#</td>
        <td>#= kendo.toString(hired_at, 'yyyy-MM-dd') #</td>
        <td>${year} (${month})</td>
        <td><abbr title="CV for ${first_name}"><a href="<?php echo base_url(); ?>staff/profile/#=id#" data-id="#=id#">CV</a></abbr</td>
        <td><a href="\\#" class="edit" data-id="#=id#"><i class="icon-pencil"></i></a>&nbsp;|&nbsp;<a href="\\#" class="del" data-id="#=id#"><i class="icon-trash"></i></a></td>
    </tr>
</script>