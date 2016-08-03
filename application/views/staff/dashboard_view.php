<div class="container">
	<div class="row">
		<div class="span12">
			<?php $this->load->view($aside_bar); ?>
		</div>
		<div class="span12">
			<div class="row">
				<p></p>
				<div id="cardView">
				</div>
			</div><!--df-->
			<div id="cv">
				<span id="lead">ជិវប្រវត្តិ</span><br>
				<div class="row">
					<div class="span5"><h3>បទពសោធន៍</h3></div>
					<a class="k-button-icontext k-add-button span2 pull-right" href="#" id="addWork"><span class="k-icon k-add"></span>ថែមបទពសោធន៍</a>
				</div>
				
				<div id="workListView"></div>
				<hr>
				<div class="row">
					<div class="span5">
						<h3>ការអប់រំ</h3>
					</div>
					<div class="span2 pull-right">
						<a class="k-button-icontext k-add-button" href="#" id="addEdu"><span class="k-icon k-add"></span>ថែមការអប់រំ</a>
					</div>
				</div>
				<div id="educationListView"></div>
			</div><!--cv-->			    
		</div>
	</div><!--row-->
</div><!--container-->

<script type="text/javascript">

//declarations
var baseUrl = "<?php echo base_url(); ?>";
$(function() {
	var template 		= kendo.template($("#sCardTemplate").html());
	var works			= new kendo.data.DataSource({
		transport	: {
			read	: {
				url	: baseUrl + "api/workhistories",
				type: "GET",
				dataType: "json",
				data: {
					staff_id : <?php echo $this->uri->segment(3); ?>
				}
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
				return options;
			}
		},
		schema: {
			model: {
				id: "id",
				fields: {
					staff_id		: { type : "number", defaultValue: <?php echo $this->session->userdata('user_id'); ?> },
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
	});
	var educations		= new kendo.data.DataSource({
		transport	: {
			read	: {
				url	: baseUrl + "api/educations",
				type: "GET",
				dataType: "json",
				data: {
					staff_id : <?php echo $this->uri->segment(3); ?>
				}
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
				return options;
			}
		},
		schema: {
			model: {
				id: "id",
				fields: {
					staff_id		: { type : "number", defaultValue: <?php echo $this->session->userdata('user_id'); ?> },
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
	});
	var employee		= new kendo.data.DataSource({
			transport: {
				read	: {
					url	: baseUrl + "api/employees",
					type: "GET",
					dataType: "json",
					data: {
						id: <?php echo $this->uri->segment(3); ?>
					}
				}
			}
	});
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
	var workListView = $("#workListView").kendoListView({
	    dataSource: works,
	    template: kendo.template($("#workTemplate").html()),
	    editTemplate: kendo.template($("#workEditTemplate").html())
	}).data("kendoListView");

	var eduListView = $("#educationListView").kendoListView({
		dataSource: educations,
		template: kendo.template($("#education").html()),
		editTemplate: kendo.template($("#editEducation").html())
	}).data("kendoListView");
	//rendering template to education and work history
	employee.read();
	employee.bind("change", function(e) {
		var tmpl	= kendo.render(template, this.view());
		$("#cardView").html(tmpl);
	});
	$("#addWork").click(function(e) {
        workListView.add();
        e.preventDefault();
    });
    $("#addEdu").click(function(e) {
        eduListView.add();
        e.preventDefault();
    });
});

</script>
<script type="text/x-kendo-template" id="workTemplate">
	# var work_from 	= new Date(from).getTime(); #
	# var work_to; #
	# if (to!="") { #
	# 	work_to = new Date(to).getTime(); #
	#} else {#
	# 	work_to = new Date().getTime(); #
	#}#

	# var one_day   = 1000*60*60*24; #
    # var days      = (work_to - work_from)/one_day; #
    # var year      = Math.floor(days/365); #
    # var month     = Math.floor(year%12); #

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
	<div class="card">
		<h3><strong>${title}</strong></h3>
		<p><strong>${institution}</strong></p>
		<p>${ kendo.toString(new Date(from), "y") } - ${ kendo.toString(new Date(to), "y") } (${year} ${month})</p>
		<p><strong>តួនាទី</strong></p>
		<a class="k-button-icontext k-edit-button" href="\\#"><span class="k-icon k-edit"></span>កែ</a>
		<a class="k-button-icontext k-delete-button" href="\\#"><span class="k-icon k-delete"></span>លុប</a><hr>
		<p>#=description#</p>
	</div>
</script>

<script type="text/x-kendo-template" id="workEditTemplate">
	<div class="card">
	<table class="table table-striped">
		<tr>
			<td>Title:</td>
			<td>
				<input type="text" class="textbox" data-bind="value:title" name="title" required="ត្រូវការ" validationMessage="required">
				<span data-for="title" class="k-invalid-msg"></span>
			</td>
		</tr>
		<tr>
			<td>Company:</td>
			<td>
				<input type="text" class="textbox" data-bind="value:institution" name="institution" required="required" validationMessage="ត្រូវការ">
				<span data-for="institution" class="k-invalid-msg"></span>
			</td>
		</tr>
		<tr>
			<td>From:</td>
			<td>
				<input type="text" data-bind="value:from" name="from" required="required" validationMessage="ត្រូវការ" data-type="date" data-role="datepicker">
				<span data-for="from" class="k-invalid-msg"></span>
			</td>
		</tr>
		<tr>
			<td>To:</td>
			<td>
				<input type="text" data-bind="value:to" name="to" required="required" validationMessage="ត្រូវការ" data-type="date" data-role="datepicker">
				<span data-for="to" class="k-invalid-msg"></span>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<textarea name="description" id="description" cols="30" rows="10" style="width:100%; height: 400px" data-bind="value:description" data-role="editor"></textarea>
			</td>
		</tr>
	</table>
	<a class="k-button-icontext k-update-button" href="\\#"><span class="k-icon k-update"></span>កត់ត្រា</a>
	<a class="k-button-icontext k-cancel-button" href="\\#"><span class="k-icon k-cancel"></span>មោឃះ</a>
	</div>
</script>
<script type="text/x-kendo-template" id="education">
	<div class="card">
		<span><strong>${institution}</strong></span><br>
		<span>${degree}; ${major}</span><br>
		<span>${kendo.toString(attended_at, 'yyyy')}</span>-<span>${kendo.toString(completion_at, 'yyyy')}</span><hr>
		<a class="k-button-icontext k-edit-button" href="\\#"><span class="k-icon k-edit"></span>កែ</a>
		<a class="k-button-icontext k-delete-button" href="\\#"><span class="k-icon k-delete"></span>លុប</a>	
	</div>	
</script>
<script type="text/x-kendo-template" id="editEducation">
	<div class="card">
		<table class="table table-striped">
		<tr>
			<td>Institution:</td>
			<td>
			<input class="textbox" type="text" data-bind="value:institution" name="institution" id="institution" required="required" validationMessage="ត្រូវការ">
			<span data-for="institution" class="k-invalid-msg"></span>
			</td>
		</tr>
		<tr>
			<td>Degree</td>
			<td>
			<input class="textbox" type="text" data-bind="value:degree" name="degree" id="degree" required="required" validationMessage="ត្រូវការ">
			<span data-for="degree" class="k-invalid-msg"></span>
			</td>
		</tr>
		<tr>
			<td>Major</td>
			<td>
			<input class="textbox" type="text" data-bind="value:major" name="major" id="major" required="required" validationMessage="ត្រូវការ">
			<span data-for="major" class="k-invalid-msg"></span>
			</td>
		</tr>
		<tr>
			<td>From</td>
			<td>
			<input type="text" data-bind="value:attended_at" name="attended_at" id="attended_at" data-type="date" data-role="datepicker" required="required" validationMessage="ត្រូវការ">
			<span data-for="attended_at" class="k-invalid-msg"></span>
			</td>
		</tr>
		<tr>
			<td>To</td>
			<td>
			<input type="text" data-bind="value:completion_at" name="completion_at" id="completion_at" data-type="date" data-role="datepicker" required="required" validationMessage="ត្រូវការ">
			<span data-for="completion_at" class="k-invalid-msg"></span>
			</td>
		</tr>
		</table>
		<a class="k-button-icontext k-update-button" href="\\#"><span class="k-icon k-update"></span>កត់ត្រា</a>
		<a class="k-button-icontext k-cancel-button" href="\\#"><span class="k-icon k-cancel"></span>មោឃះ</a>
	</div>
	
</script>
<script type="text/x-kendo-tmpl" id="sCardTemplate">
	<div class="span3">
		<img width="200" src="${image_url}" class="img-polaroid" />
	</div>
	<div class="span7">
		<address>
			<table class="table table-striped">
				<tr>
					<td>Name:</td>
					<td>${last_name} ${first_name}</h2></td>
				</tr>
				<tr>
					<td>លេខអត្តសញ្ញានប័ណ:</td>
					<td>${id_no}</td>
				</tr>
				<tr>
					<td><abbr title="Email">E</abbr>:</td>
					<td>${email}</td>
				</tr>
				<tr>
					<td><abbr title="Phone">P</abbr>:</td>
					<td>${phone}</td>
				</tr>
				<tr>
					<td>ថ្ងៃខែឆ្នាំកំណើត:</td>
					<td>${kendo.toString(new Date(dob), "dd-MM-yyyy")}</td>
				</tr>
				<tr>
					<td>សញ្ជាត្តិ:</td>
					<td>${nationality_id}</td>
				</tr>
				<tr>
					<td>ភេទ:</td>
					<td>${gender}</td>
				</tr>
				<tr>
					<td>Marital status:</td>
					<td>${marital_status}</td>
				</tr>
				<tr>
					<td>ប្ដី/ប្រពន្ធ:</td>
					<td>${phone}</td>
				</tr>
				<tr>
					<td>emergency contact:</td>
					<td>${emmergency_contact}</td>
				</tr>
			</table>
		</address>											
	</div>
</script>
<style scoped>
	.k-listview {
		border: 0;
	}
	#cv {
		background-color: #eee;
		padding: 5px;
	}
	.textbox {
		height: 50px;
		padding: 2px;
		width: 160px;
	}
	#lead {
		padding: 5px 20px;
		margin-bottom: 10px;
		background-color: #000;
		height: 50px;
		width: 100px;
		line-height: 50px;
		color: #ccc;
	}
	#cv .card {
		padding: 5px 10px;
		background-color: #eee;
		border: 0;

	}
</style>