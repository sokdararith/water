<div class="container">
	<div class="row">
		<div class="span12"><?php $this->load->view('/hr/toolbar'); ?></div>
		<div class="span12">
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
									<input class="k-textbox" type="text" name="nationalID" id="nationalID" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-bind="value: national_id" />
								</td>
								<td>
									<label for="nationality">Nationality</label>
									<input type="text" name="nationality" id="nationality" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-role="combobox"  data-bind="value: nationality_id, source: nationalities" data-text-field="nationality" data-value-field="id" data-placeholder="Select One" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="firstName">First Name</label>
									<input class="k-textbox" type="text" name="firstName" id="firstName" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-bind="value: first_name" />
								</td>
								<td>
									<label for="lastName">Last Name</label>
									<input class="k-textbox" type="text" name="lastName" id="lastName" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-bind="value: last_name" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="phone">Phone</label>
									<input class="k-textbox" type="text" name="phone" id="phone" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-bind="value: phone" />
								</td>
								<td>
									<label for="email">Email</label>
									<input class="k-textbox" type="text" name="email" id="email" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-bind="value: email" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="gender">Gender</label>
									<input type="text" name="gender" id="gender" placeholder="ភេទ" data-role="dropdownlist" data-bind="value: gender, source: genders" data-text-field="gender" data-value-field="id" data-placeholder="Select One" />
								</td>
								<td>
									<label for="dob">DoB</label>
									<input type="text" name="dob" id="dob" placeholder="ថ្ងៃខែឆ្នាំកំណើត" data-role="datepicker" data-bind="value: dob" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="maritalStatus">Marital Status</label>
									<input type="text" name="maritalStatus" id="maritalStatus" placeholder="រៀបការ" data-role="dropdownlist" data-bind="value: marital_status, source: marital_statuses" data-text-field="status" data-value-field="id" />
								</td>
								<td>
									<label for="imageUrl"></label>
									<div style="width:80%">
						                <input name="userfile" id="userfile" type="file" />
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
									<input class="k-input k-textbox" type="text" name="staffID" id="staffID" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-bind="value: staff_code" />
								</td>
								<td>
									<label for="lineManager">Line Manager</label>
									<input class="k-input k-text k-lone-widget" type="text" name="lineManager" id="lineManager" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-role="combobox" data-bind="value: line_manager, source: staffCollection" data-text-field="first_name" data-value-field="id" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="job">Job Title</label>
									<input class="k-input k-text"type="text" name="job" id="job" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-role="combobox" data-bind="source: positions, value: job_id" data-text-field="title" data-value-field="id" />
								</td>
								<td>
									<label for="department">Department</label>
									<input class="k-input k-text" type="text" name="department" id="department" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-role="combobox" data-bind="value: department, source: departments" data-text-field="name" data-value-field="id" data-placeholder="Select One" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="dateHired">Date Hired</label>
									<input type="text" name="dateHired" id="dateHired" placeholder="លេខអត្តសញ្ញណប័ណ្ណ" data-role="datepicker" data-bind="value: hired_at" />
								</td>
								<td>
									<label for="contract_ref">Contract Ref.</label>
									<input type="text" name="contract_ref" id="contract_ref" class="k-textbox" data-bind="value: contract_ref" placeholder="លេខកុងត្រា">
								</td>
							</tr>
							<tr>
								<td>
									<label for="emmergencyContact">Emmergency Contact</label>
									<input class="k-input k-textbox" type="text" name="emmergencyContact" id="emmergencyContact" placeholder="លេខបន្ទាន់" data-bind="value: emmergency_cont" />
								</td>
								<td>
									<label for="address">Address</label>
									<textarea class="k-input k-textarea" type="text" name="address" id="addres" placeholder="រូបភាព" data-bind="value: address" /></textarea>
								</td>
							</tr>
						</table>
					</div>
				</div>

			</div><!--tabStrip-->
			<p></p>
			<span class="btn btn-large" data-bind="click: btnSave">Save</span>
		</div>
	</div>
</div>
<style scoped>
	.k-ediable-area body {
		300px;
	}
</style>
<script>
var baseUrl = "<?php echo base_url(); ?>";
$(function(){
	$("#tabStrip").kendoTabStrip();
	$(".panelbar").kendoPanelBar({
		expandMode: "single"
	});
	var staffVM = kendo.observable({
		staffCollection	: new kendo.data.DataSource({
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
								contract_ref 		: { type: "string" },
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
							var ask = prompt("You have added staff to database, do you want to add more?");
							if(ask) {
								alert(ask);
							} else {
								alert("someting");
							}
							break;
							case "update":
							//let user know it is updated
							var obj = e.response;
							alert("updated " + obj.status);
							staffGrid.refresh();
							break;
							case "delete":
							//let user know it is deleted
							alert("deleted " + obj.status);
							staffGrid.refresh();
							break;
						}
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
		positions 		: new kendo.data.DataSource({
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
		spouse			: "",
		first_name		: "",
		last_name		: "",
		staff_code		: "",
		nationality_id	: "",
		national_id		: "",
		gender			: "",
		dob				: "",
		phone			: "",
		email			: "",
		address			: "",
		marital_status	: "",
		line_manager	: "",
		contract_ref 	: "",
		job_id			: "",
		job_title 		: "",
		job_description	: "",
		address 		: "",
		hired_at		: "",
		company_id		: "",
		department		: "",
		image_url		: "./../uploads/pictures/unknown.png",
		emmergency_cont	: "",
		btnNationality	: function() {
			if( this.get("nationality") != "" ) {
				this.get("nationalities").add({nationality: this.get("nationality")});
				this.get("nationalities").sync();
				this.set("nationality", "");
				this.get("nationalities").read();
			} else {
				
			}
			this.set('showBtnNatoional', true);			
		},
		btnDepartment	: function() {
			if( this.get("department") != "" ) {
				this.get("departments").add({name: this.get("department"), deletable: "true"});
				this.get("departments").sync();
				this.set("department", "");
				this.get("departments").read();
			} else {
				
			}		
		},
		btnPosition		: function() {
			this.get('positions').add({
				title: this.get('job_title'),
				description: this.get('job_description')
			});
			this.get('positions').sync();
			this.set('job_title', '');
			this.set('job_description', '');
		},
		search			: function(e) {
			if( this.get('search_name') == "" ) {
				this.set('staff_tool', false);
			} else {
				this.set('staff_tool', true);
			}
		},
		btnSave		: function(e) {
			this.get('staffCollection').add({
				company_id		: this.get('company_id'),
				code			: this.get('staff_code'),
				nationality_id	: this.get('nationality'),
				id_no			: this.get('natioanl_id'),
				first_name		: this.get('first_name'),
				last_name		: this.get('last_name'),
				image_url		: this.get('image_url'),
				phone 			: this.get('phone'),
				email 			: this.get('email'),
				dob				: kendo.toString(this.get('dob'), "yyyy-MM-dd"),
				hired_at		: kendo.toString(this.get('hired_at'), "yyyy-MM-dd"),
				gender			: this.get('gender'), 				
				marital_status	: this.get('martital_status'),
				line_manager	: this.get('line_manater'),
				job_id			: this.get('job_id'),
				department_id	: this.get('department'),	
				contract_ref 	: this.get('contract_ref'),			
				emmergency_contact	: this.get('emmergency_cont')
			});
			this.get('staffCollection').sync();

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
			this.set("image_url", "./../uploads/pictures/unknown.png");
			this.set("emergency_cont", "");
		}
	});
	kendo.bind($(".container"), staffVM);
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
				path = "./../uploads/pictures/" + value.name;
				staffVM.set("image_url", path);
			});
		} 
    });
});
</script>