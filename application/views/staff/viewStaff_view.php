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
				<span id="lead">Background</span><br>
				<div class="row">
					<div class="span6"><h3>Experience</h3></div>
				</div>
				
				<div id="workListView"></div>
				<hr>
				<div class="row">
					<div class="span6">
						<h3>Education</h3>
					</div>
					<div class="span1 pull-right">
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
	    template: kendo.template($("#workTemplate").html())
	}).data("kendoListView");

	var eduListView = $("#educationListView").kendoListView({
		dataSource: educations,
		template: kendo.template($("#education").html())
	}).data("kendoListView");
	//rendering template to education and work history
	employee.read();
	employee.bind("change", function(e) {
		var tmpl	= kendo.render(template, this.view());
		$("#cardView").html(tmpl);
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
	<div class="card">
		<h3><strong>${title}</strong></h3>
		<p><strong>${institution}</strong></p>
		<p>${ kendo.toString(new Date(from), "y") } - ${ kendo.toString(new Date(to), "y") } (${year} ${month})</p>
		<p><strong>Description</strong></p>
		<p>#=description#</p>
	</div>
</script>


<script type="text/x-kendo-template" id="education">
	<div class="card">
		<span><strong>${institution}</strong></span><br>
		<span>${degree}; ${major}</span><br>
		<span>${kendo.toString(attended_at, 'yyyy')}</span>-<span>${kendo.toString(completion_at, 'yyyy')}</span><hr>
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