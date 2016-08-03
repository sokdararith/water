<div class="container">
	<div class="row">
		<div id="staff-list" class="span3">
			<div class="input-append">
			<input style="width: 180px;" id="appendedInput" type="text" placeholder="រកបុគ្គលិកតាមឈ្មោះ" data-bind="value: search_name">
			<span class="add-on" data-bind="click: search"><i class="icon-search"></i></span>
			</div>
			<div id="staff-grid"></div>
			
			<div id="hr-control">
				<ul class="panel">
					<li class="k-state-active">
						<span class="k-link k-state-selected">Staff</span>
						<ul>
							<li><a href="staff_cards">Staff Cards</a></li>
							<li><a href="staff/create">Add Staff</a></li>
							<li><a href="staff/credential">Assign Login Info</a></li>
						</ul>
					</li>
					<li>
						<span class="k-link">Payroll</span>
						<ul>
							<li>Payroll List</li>
						</ul>
					</li>
					<li>
						<span class="k-link">Timesheet</span>
					</li>
					<li>
						<span class="k-link">Something</span>
					</li>
				</ul>
				<div id="panelBottom"></div>
			</div>
		</div><!--staff-list-->
		<div id="user-detail" class="span9">
			<div id="toolbar">
			    <div class="btn-group">
				    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				    បង្កើតថែម
				    <span class="caret"></span>
				    </a>
				    <ul class="dropdown-menu">
				    	<li><a href="#">Credentials</a></li>
						<li><a href="#" data-bind="click: add_staff">បុគ្គលិក</a></li>
						<li><a href="#" data-bind="click: btnAddNational">សញ្ជាតិ</a></li>
						<li><a href="#" data-bind="click: btnAddDept">ផ្នែក</a></li>
						<li><a href="#" data-bind="click: btnAddDept">New Job</a></li>
				    </ul>
			    </div>
				<div class="btn-group">
					<button class="btn" data-bind="enabled: staff_tool, click: edit_staff">
						<i class="icon-edit"></i> បុគ្គលិក
					</button>
					<button class="btn" data-bind="click: delete_staff, enabled: staff_tool">
						<i class="icon-trash"></i> បុគ្គលិក
					</button>
					<button class="btn" data-bind="enabled: staff_tool, click: test">
						<i class="icon-plus"></i> salary
					</button>
					<button class="btn" data-bind="enabled: staff_tool, click: test">
						<i class="icon-edit"></i> Leave
					</button>
					<button class="btn" data-bind="enabled: staff_tool, click: test">
						<i class="icon-trash"></i> បុគ្គលិក
					</button>
				</div>
			</div>
			<div id="holder">
				<div id="staff-info" data-bind="invisible: showStaff">
					<div class="wrapper">
						<div class="row">
							<p></p>
							<div class="span3">
								<img width="200" data-bind="attr: { src: image_url, alt: staff_code, title: first_name }" />
							</div>
							<div class="span5">
								<address>
									<h2><span data-bind="text: first_name"></span> 
									<span data-bind="text: last_name"></span></h2><br>
									លេខអត្តសញ្ញានប័ណ: <strong><span data-bind="text: national_id"></span></strong><br>
									<abbr title="Email">E</abbr>: <span data-bind="text: email"></span><br>
									<abbr title="Phone">P</abbr>: <span data-bind="text: phone"></span><br>
									ថ្ងៃខែឆ្នាំកំណើត: <span data-bind="text: phone"></span><br>
									សញ្ជាត្តិ: <span data-bind="text: nationality"></span><br>
									ភេទ:<span data-bind="text: gender"></span><br>
									marital status: <span data-bind="text: marital_status"></span><br>
									ប្ដី/ប្រពន្ធ: <br>
									emergency contact: <span data-bind="text: emmergency_contact"></span>
								</address>											
							</div>
						</div><!--df-->
					    <div class="page-header">
					    <h3>Work History <small>Subtext for header</small></h3>
					    </div>
						<div id="workListView"></div>
						<h3>Education <small>Subtext for header</small></h3>
						<div id="educationListView"></div>
					</div><!--wrapper-->	
				</div><!--staff-info-->
				<div id="add-staff" data-bind="invisible: showAdd">
					<fieldset>
					<legend>Personal Information</legend>
					<div class="row">						
							<div class=span4>
							
							<label for="nationalID">National ID</label>
							<input class="k-textbox" type="text" name="nationalID" id="nationalID" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-bind="value: national_id" />
							<label for="nationality">Nationality</label>
							<input type="text" name="nationality" id="nationality" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-role="combobox"  data-bind="value: nationality_id, source: nationalities" data-text-field="nationality" data-value-field="id" data-placeholder="Select One" />
							&nbsp;<i class="icon-plus" data-bind="click: btnAddNational"></i>
							<div class="input-append" data-bind="invisible: showBtnNatoional">
							<input style="width: 168px;" id="appendedInput" type="text" data-bind="value: nationality">
							<span class="add-on btn" data-bind="click: wndBtnNational">ADD</span>
							</div>
							<label for="firstName">First Name</label>
							<input class="k-textbox" type="text" name="firstName" id="firstName" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-bind="value: first_name" />
							<label for="lastName">Last Name</label>
							<input class="k-textbox" type="text" name="lastName" id="lastName" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-bind="value: last_name" />
							<label for="phone">Phone</label>
							<input class="k-textbox" type="text" name="phone" id="phone" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-bind="value: phone" />
									
							</div>
							
							<div class=span4>
							
							<label for="imageUrl"></label>
							<img width="280" height="180" data-bind="attr: { src: image_url }" />
							<div style="width:80%">
				                <input name="userfile" id="userfile" type="file" />
				            </div>
							<label for="email">Email</label>
							<input class="k-textbox" type="text" name="email" id="email" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-bind="value: email" />
							<label for="gender">Gender</label>
							<input type="text" name="gender" id="gender" placeholder="ភេទ" data-role="dropdownlist" data-bind="value: gender, source: genders" data-text-field="gender" data-value-field="id" data-placeholder="Select One" />
							<label for="dob">DoB</label>
							<input type="text" name="dob" id="dob" placeholder="ថ្ងៃខែឆ្នាំកំណើត" data-role="datepicker" data-bind="value: dob" />
							<label for="maritalStatus">Marital Status</label>
							<input type="text" name="maritalStatus" id="maritalStatus" placeholder="រៀបការ" data-role="dropdownlist" data-bind="value: marital_status, source: marital_statuses" data-text-field="status" data-value-field="id" />
							</div>

					</div>
					</fieldset>
					
					<fieldset>
					<legend>Company</legend>
					<div class="row">						
						
							<div class=span4>
							<label for="staffID">Staff ID</label>
							<input class="k-input k-textbox" type="text" name="staffID" id="staffID" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-bind="value: staff_code" />
							<label for="department">Department</label>
							<input class="k-input k-text" type="text" name="department" id="department" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-role="combobox" data-bind="value: department, source: departments" data-text-field="name" data-value-field="id" data-placeholder="Select One" />&nbsp;<button class="btn" id="addDept" data-bind="click: btnAddDept"><i class="icon-plus"></i></button>
							<div class="input-append" data-bind="invisible: showBtnDepartment">
							<input style="width: 168px;" id="appendedInput" type="text" data-bind="value: department">
							<span class="add-on btn" data-bind="click: wndBtnDepartment">ADD</span>
							</div>
							<label for="lineManager">Line Manager</label>
							<input class="k-input k-text k-lone-widget" type="text" name="lineManager" id="lineManager" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-role="combobox" data-bind="value: line_manager, source: staffCollection" data-text-field="first_name" data-value-field="id" />
							<label for="job">Job Title</label>
							<input class="k-input k-text"type="text" name="job" id="job" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-role="combobox" data-bind="value: job_id"/>&nbsp;<button class="btn" id="addJob" data-bind="click: btnAddJob"><i class="icon-plus"></i></button>
									
							</div>
							
							<div class=span4>
								<label for="dateHired">Date Hired</label>
								<input type="text" name="dateHired" id="dateHired" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-role="datepicker" data-bind="value: hired_at" />
							<label for="spouse">Spouse</label>
							<input class="k-input k-text" type="text" name="spouse" id="spouse" placeholder="គ្រួសារ" data-role="dropdownlist" data-bind="value: spouse" />
							<label for="address">Address</label>
							<input class="k-input k-textbox" type="text" name="address" id="addres" placeholder="រូបភាព" data-bind="value: address" />
							<label for="emmergencyContact">Emmergency Contact</label>
							<input class="k-input k-text" type="text" name="emmergencyContact" id="emmergencyContact" placeholder="លេខបន្ទាន់" data-bind="value: emmergency_cont" />
							
							</div>
					</div>
					</fieldset>
					<button class="k-button" data-bind="click: staff_save, invisible: btnAddStaff">កត់ត្រា</button><button class="k-button" data-bind="click: staff_edit, invisible: btnEditStaff">កត់ត្រា</button>
				</div><!--add-staff-->
			</div>
		</div><!--user-detail-->
		
	</div><!--row-->
</div><!--containter-->




<script type="text/javascript">

//declarations
var baseUrl = "<?php echo base_url(); ?>";

var wndNationality		= $("#wndNationality");
var wndDepartment		= $("#wndDepartment");
var wndSpouse			= $("#wndSpouse");
var wndKid				= $("#wndKid");
var wndJob				= $("#wndJob");

$(function() {
	var eduTemplate			= kendo.template($("#educationTemplate").html());
	var workTemplate		= kendo.template($("#workTemplate").html());
	var timesheet 			= $("#timesheet").kendoGrid({
		columns: [
			{ title: "ភារះកិច្ច" },
			{ title: "ស្ថានភាពការងារ", width: "100px" }
		],
		height: "300px",
		pageable: true
	}).data("kendoGrid");
	
	$("#tabstrip").kendoTabStrip({
		animation: {
			close: {
				duration: 100,
				effect: "fadeOut"
			},
			open: {
				duration: 10,
				effect: "fadeIn"
			}
		}
	}).data("kendoTabStrip");
	$(".panel").kendoPanelBar({
		expandMode: "single"
	});
	var staffVM = kendo.observable({
		staffCollection	: new kendo.data.DataSource({
					transport	: {
						read	: {
							url	: baseUrl + "api/staff",
							type: "GET",
							dataType: "json"
						},
						create	: {
							url	: baseUrl + "api/staff",
							type: "POST",
							dataType: "json"
						},
						update	: {
							url	: baseUrl + "api/staff",
							type: "PUT",
							dataType: "json"
						},
						destroy : {
							url	: baseUrl + "api/staff",
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
								line_manager_id		: { type: "number" },
								job_id				: { type: "number" },
								department_id		: { type: "number" },
								hired_at			: { type: "date" }
							}
						}
					},
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
		}),
		tasks			: new kendo.data.DataSource({
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
					type: "GET",
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
		}),
		wife			: new kendo.data.DataSource({
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
					type: "GET",
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
		}),
		kids			: new kendo.data.DataSource({
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
		}),
		nationalities	: new kendo.data.DataSource({
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
		}),
		departments		: new kendo.data.DataSource({
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
		}),
		works			: new kendo.data.DataSource({
			transport	: {
				read	: {
					url	: baseUrl + "api/workhistories",
					type: "GET",
					dataType: "json"
				},
				create	: {
					url	: baseUrl + "api/workhistories",
					type: "POST",
					dataType: "json"
				},
				update	: {
					url	: baseUrl + "api/workhistories",
					type: "PUT",
					dataType: "json"
				},
				destroy : {
					url	: baseUrl + "api/workhistories",
					type: "DELETE",
					dataType: "json"
				},
				parameterMap : function(options, operation) {
					if( operation !== "read" && options.models ) {
						return { models: kendo.stringigy(options.models) };
					}
					if( operation==="read") {
						return { staff_id: staffVM.get("selectedStaff") }
					}
					return options;
				}
			},
			schema: {
				model: {
					id: "id",
					fields: {
						staff_id		: { type : "number" },
						job_id			: { type : "number"},
						title			: { type : "string"},  
						description		: { type: "string" },
						institution		: { type: "string" },
						from			: { type: "date"},
						to				: { type: "date"}
					}
				}
			},
			pageSize: 10
		}),
		educations		: new kendo.data.DataSource({
			transport	: {
				read	: {
					url	: baseUrl + "api/educations",
					type: "GET",
					dataType: "json"
				},
				create	: {
					url	: baseUrl + "api/educations",
					type: "POST",
					dataType: "json"
				},
				update	: {
					url	: baseUrl + "api/educations",
					type: "PUT",
					dataType: "json"
				},
				destroy : {
					url	: baseUrl + "api/educations",
					type: "DELETE",
					dataType: "json"
				},
				parameterMap : function(options, operation) {
					if( operation !== "read" && options.models ) {
						return { models: kendo.stringigy(options.models) };
					}
					if( operation==="read") {
						return { staff_id: staffVM.get("selectedStaff") }
					}
					return options;
				}
			},
			schema: {
				model: {
					id: "id",
					fields: {
						staff_id		: { type : "number" },
						degree			: { type : "string"},
						major			: { type : "string"},  
						description		: { type: "string" },
						institution		: { type: "string" },
						attended_at		: { type: "date"},
						completion_at	: { type: "date"}
					}
				}
			},
			pageSize: 10
		}),
		
		genders			: [
							{ id : "ប្រុស", gender : "ប្រុស" },
							{ id : "ស្រី", gender : "ស្រី" },
		],
		marital_statuses: [
							{ id : "single", status: "Single" },
							{ id : "married", status: "Married" },
							{ id : "divorced", status: "Divoiced" },
							{ id : "separated", status: "Separated" }
		],
		staff_tool 		: false,
		search_name		: "",
		selectedStaff	: false,
		showStaff		: true,
		showAdd			: true,
		showEdit		: true,
		spouse			: "",
		first_name		: "",
		last_name		: "",
		staff_code		: "",
		nationality_id	: "",
		nationality		: function() {
			if ( this.get('nationality_id') == "" ) {
				return "Unknown";
			} else {
				var model	= this.get('nationalities').get(this.get('nationality_id'));
				return model.nationality;
			}
		},
		national_id		: "",
		gender			: "",
		dob				: "",
		phone			: "",
		email			: "",
		address			: "",
		marital_status	: "",
		line_manager	: "",
		job_id			: "",
		hired_at		: "",
		company_id		: "",
		department		: "",
		image_url		: "../../uploads/pictures/unknown.png",
		emmergency_cont	: "",
		name			: function(e) {
			var fullname = this.get('last_name') + ' ' + this.get('first_name');
			return fullname;
		},
		btnAddDept		: function() {
			this.set('showBtnDepartment', false);
		},
		btnAddJob		: function() {
			wndJob.center().open();
		},
		btnAddNational	: function() {
			this.set('showBtnNatoional', false);
		},
		showBtnNatoional: true,
		showBtnDepartment: true,
		btnEditStaff	: true,
		btnAddStaff		: true,
		wndBtnNational	: function() {
			if( this.get("nationality") != "" ) {
				this.get("nationalities").add({nationality: this.get("nationality")});
				this.get("nationalities").sync();
				this.set("nationality", "");
				this.get("nationalities").read();
			} else {
				
			}
			this.set('showBtnNatoional', true);			
		},
		wndBtnDepartment: function() {
			if( this.get("department") != "" ) {
				this.get("departments").add({name: this.get("department"), deletable: "true"});
				this.get("departments").sync();
				this.set("department", "");
				this.get("departments").read();
			} else {
				
			}		
			this.set('showBtnDepartment', true);			
		},
		test			: function() {
			alert("hi");
		},
		search			: function(e) {
			if( this.get('search_name') == "" ) {
				this.set('staff_tool', false);
			} else {
				this.set('staff_tool', true);
			}
		},
		add_staff		: function(e) {

			this.set("showStaff", true);
			this.set("showEdit", true);
			this.set("showAdd", false);
			this.set("btnEditStaff", true);
			this.set("btnAddStaff", false);
			staffVM.set("staff_tool", false);
			
			this.set("staff_code", "");
			this.set("first_name", "");
			this.set("last_name", "");
			this.set("nationality", "");
			this.set("national_id", "");
			this.set("gender", "");
			this.set("dob", "");
			this.set("marital_status", "");
			this.set("line_manager", "");
			this.set("job_id", "");
			this.set("hired_at", "");
			this.set("company_id", "");
			this.set("department", "");
			this.set("image_url", "../../uploads/pictures/unknown.png");
			this.set("emergency_cont", "");
			
		},
		edit_staff		: function(e) {

			this.set("showAdd", false);
			this.set("showStaff", true);
			this.set("showEdit", true);
			this.set("btnEditStaff", false);
			this.set("btnAddStaff", true);
			
		},
		staff_edit		: function(e) {
			model = this.get('staffCollection').get(this.get('selectedStaff'));
			model.set("code", this.get('staff_code'));
			model.set("first_name", this.get('first_name'));
			model.set("last_name", this.get('last_name'));
			model.set("nationality_id", this.get('nationality'));
			model.set("id_no",this.get('natioanl_id'));
			model.set("dob",this.get('dob'));
			model.set("company_id",this.get('company_id'));
			model.set("marital_status",this.get('martital_status'));
			model.set("line_manager",this.get('line_manater'));
			model.set("department_id",this.get('department'));
			model.set("image_url",this.get('image_url'));
			model.set("emmergency_contact",this.get('emmergency_cont'));
			this.get('staffCollection').sync();
		},
		delete_staff	: function(e) {
			var r = confirm("តើអ្នកពិតជាមានបំណងលុបបុគ្គលិកនេះមែនទេ?");
			if( r == true ) {
				var staff = this.get("staffCollection").get(this.get('selectedStaff'));
				this.get("staffCollection").remove(staff);
				this.get("staffCollection").sync();
			} else {
				alert("you canceled it.");
			}
			
		},
		staff_save		: function(e) {
			this.get('staffCollection').add({
				code			: this.get('staff_code'),
				first_name		: this.get('first_name'),
				last_name		: this.get('last_name'),
				nationality_id	: this.get('nationality'),
				id_no			: this.get('natioanl_id'),
				gender			: this.get('gender'),
 				dob				: this.get('dob'),
				marital_status	: this.get('martital_status'),
				line_manager	: this.get('line_manater'),
				company_id		: this.get('company_id'),
				department_id	: this.get('department'),
				image_url		: this.get('image_url'),
				emmergency_contact	: this.get('emmergency_cont')
			});
			this.get('staffCollection').sync();
		},
		staff_update	: function(e) {
			
		}
	});
	kendo.bind($(".container"), staffVM);

	var staffGrid 	= $("#staff-grid").kendoGrid({
		dataSource: staffVM.get('staffCollection'),
		columns: [
			{ title: "បុគ្គលិក", field: "first_name" }
		],
		//rowTemplate: kendo.template($("#sCardTmpl").html()),
		height: "400px",
		selectable: true,
		change: function(e) {
			var id 		= this.select().data('uid');
			var model 	= this.dataSource.getByUid(id);
			//alert(model.id);
			staffVM.set("selectedStaff", model.id);
			staffVM.set("staff_tool", true);
			staffVM.set("name", "dararith");
			staffVM.set("showStaff", false);
			staffVM.set("showAdd", true);
			staffVM.set("showEdit", true);
			
			staffVM.set("staff_code", model.code);
			staffVM.set("first_name", model.first_name);
			staffVM.set("last_name", model.last_name);
			staffVM.set("email", model.email);
			staffVM.set("phone", model.phone);
			staffVM.set("nationality_id", model.nationality_id);
			staffVM.set("national_id", model.id_no);
			staffVM.set("gender", model.gender);
			staffVM.set("dob", model.dob);
			staffVM.set("marital_status", model.marital_status);
			staffVM.set("line_manager", model.line_manager);
			staffVM.set("job_id", model.job_id);
			staffVM.set("hired_at", model.hired_at);
			staffVM.set("company_id", model.company_id);
			staffVM.set("department", model.department_id);
			staffVM.set("image_url", model.image_url);
			staffVM.set("emergency_cont", model.emmergency_contact);
			
			var nationality = staffVM.get("nationalities").get(model.nationality_id);
			staffVM.set("nationality", nationality.nationality);
			staffVM.get("educations").read();
			staffVM.get("works").read();
		}
	}).data("kendoGrid");
	var nationalityG= $("#nationalityGrid").kendoGrid({
		dataSource: staffVM.get('nationalities'),
		columns: [
			{ title: "Nationality", field: "nationality"  }
		],
		height: 200,
		pageable: true
	}).data('kendoGrid');
	var kidGrid		= $("#kids").kendoGrid({
		dataSource  : staffVM.get('kids'),
		columns		: [
			{ title: "name", field: "last_name" },
			{ title: "name", field: "first_name" },
			{ title: "Gender", field: "gender" },
			{ title: "Birthday" },
			{ title: "Age", field: "dob" }
		],
		rowTemplate	: kendo.template($("#kidTemplate").html())
	}).data("kendoGrid");
	/*var educationList= $("#educationListView").kendoListView({
		dataSource	: staffVM.get("educations"),
		autoBine	: false,
		template	: kendo.template($("#educationTemplate").html())
	}).data("kendoListView");*/
	
	$("#userfile").kendoUpload({
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
				path = "../../uploads/pictures/" + value.name;
				staffVM.set("image_url", path);
			});
		} 
    });
	
	//rendering template to education and work history
	staffVM.get("educations").bind("change", function(e) {
		if(staffVM.get("educations").view().length > 0 ) {
			var tmpl	= kendo.render(eduTemplate, this.view());
			$("#educationListView").html(tmpl);
		} else {
			
		}
	});
	
	staffVM.get("works").bind("change", function(e) {
		var tmpl	= kendo.render(workTemplate, this.view());
		$("#workListView").html(tmpl);
	});
	
	//binding click even to template eduction
	$("#educationListView").on("click", ".k-edit", function(e){
		e.preventDefault();
		var target 	= $(e.currentTarget);
		var id		= target.data('id');
		eduMD		= staffVM.get('educations').get(id);
		$("#degree").val(eduMD.degree);
		$("#major").val(eduMD.major);
		$("#institution").val(eduMD.institution);
		$("#attended").val(eduMD.attended_at);
		$("#completed").val(eduMD.completion_at);
		wndEducation.center().open();
		//alert(id);
	});
	
	$("#staff-grid").on("click", ".editStaff", function(e){
		e.preventDefault;
		alert("Howdy!");
	});
});

</script>
<script type="text/x-kendo-template" id="kidTemplate">
# var birthday 	= new Date(dob).getTime(); #
# var today		= new Date().getTime(); #
# var one_day 	= 1000*60*60*24; #
# var age_year	= Math.floor(((today-birthday)/one_day)/365); #
# if (age_year < 1 ) {# 
#	age = Math.floor(((today-birthday)/one_day)%365) + " days"; # 
#} else { #
#	age = age_year + " years"; #
# } #
<tr>
	<td>${last_name }</td>
	<td>${first_name }</td>
	<td>#: gender #</td>
	<td>#: dob #</td>
	<td>#: age #</td>
	
</tr>	
</script>
<script type="text/x-kendo-template" id="educationTemplate">
<div class='well'>
<h3><strong>${institution}</strong></h3>
<p>#: degree #; #: major #</p>
<p>${ kendo.toString(new Date(attended_at), "y") } - ${ kendo.toString(new Date(completion_at), "y") }</p>

</div>
</script>
<script type="text/x-kendo-template" id="workTemplate">
# var work_from 	= new Date(from).getTime(); #
# var work_to; #
# if (to!="") { #
# 	work_to = new Date(to).getTime(); #
#} else {#
# 	work_to = new Date().getTime(); #
#}#

# var one_day 	= 1000*60*60*24; #
# if (to!="") { #
# 	work_to = new Date(to).getTime(); #
#} else {#
# 	work_to = new Date().getTime(); #
#}#

# var one_day 	= 1000*60*60*24; #
# var year	= Math.floor(((work_to-work_from)/one_day)/365); #
# var month	= Math.floor((((work_to-work_from)/one_day)%365)%12); #
# if (year > 1 ) { # 
#	year += " years"; # 
#} else { #
#	year += " year"; #
# } #
# if (month > 1 ) { # 
#	month += " months"; # 
#} else { #
#	month += " month"; #
# } #
<div class="well">
<h3><strong>${title}</strong></h3>
<p><strong>${institution}</strong></p>
<p>${ kendo.toString(new Date(from), "y") } - ${ kendo.toString(new Date(to), "y") } (${year} ${month})</p>
<p><strong>Description</strong></p><hr>
<p>${ description }</p>
</div>
</script>

<script type="text/x-kendo-tmpl" id="sCardTmpl">
<div>
<img src="${image_url}" width="100" height="130">
<strong>${first_name}</strong> <span class="editStaff">dlkfdf</span>
</div>
</script>
<style scoped>
	#tabstrip {
		background: #fff;
		border: 0;
		margin: 0 -4px;
		padding: 0;
	}
	.wrapper {
		padding: 0;
	}
	.info {
		padding: 0;
	}
</style>