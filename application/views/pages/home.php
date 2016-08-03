<div class="container">
	<div class="row">
		<div id="user-info" class="span3">
			<img src="./resources/images/photo.jpg" width="95%" height="240" class="img-polaroid">
			<p></p>
			<div class="navbar">
				<div class="navbar-inner">
		            <b class="navbar-text">សួរស្ដី, <?php echo $this->session->userdata("username"); ?></b>
		            <ul class="nav pull-right">
		              <li class="dropdown">
		                <a href="#" class="dropdown-toggle" data-toggle="dropdown">			
		                  <b class="icon-cog"></b>
		                </a>
		                <ul class="dropdown-menu">
		                  <li><a href="<?php echo base_url(); ?>users/change_information"><i class="icon-info-sign"></i> <?=$this->lang->line('user_change_information'); ?></a></li>
		                  <li><a href="<?php echo base_url(); ?>users/change_password"><i class="icon-lock"></i> <?=$this->lang->line('user_change_password'); ?></a></li>
						  <li><?php if ($this->session->userdata('role_id') == "1") { echo anchor('admin', '<i class=" icon-wrench"></i> Admin Dashboard'); } ?></li>
		                  <li><a href="<?php echo base_url(); ?>auth/logout"><i class="icon-eject"></i> <?=$this->lang->line('top_menu_logout'); ?></a></li>
		                </ul>
		              </li>
		            </ul>
				</div>
			</div>
				
			<?php if(isset($subordinate) && !empty($subordinate)) :?>

			<table class="table table-striped">
				<thead>
					<tr>
						<td><b><?php echo $this->lang->line('subordinate'); ?>:</b></td>
					</tr>
				</thead>
			<?php foreach( $subordinate as $sub ) : ?>
				<?php $i = 1; ?>
				<tr>
					<td><?php echo ($i.'. '.$sub->first_name); ?></td>
				</tr>
				
			<?php $i++;	endforeach; ?>
			</table>
			<?php endif; ?>

			<h3>&nbsp;Notification!</h3>

			<div class="alert alert-info" data-bind="invisible: show_unassigned_tasks">

            	<a href="#" data-bind="click: assign_now"><span data-bind="text: unassigned_tasks"></span> unassigned tasks</a>

            </div>

            <div class="alert alert-info" data-bind="invisible: show_incomplete_tasks">

            	<a href="#" data-bind="click: complete_now"><span data-bind="text: incomplete_tasks"></span> incomplete tasks</a>

            </div> 

            <div class="alert alert-info" data-bind="invisible: show_users">

            	<a href="#" data-bind="click: complete_now"><span data-bind="text: incomplete_tasks"></span> Staff</a>

            </div>


		</div><!--user information-->
		<div id="tasks-section" class="span9">
			<div class="row">
				<div id="crm-toolbar" class="span9">
					<div class="navbar">
						<div class="navbar-inner">
							<ul class="nav">
								<li><a href="#">Home</a></li>
								<li><a href="#">Leads</a></li>
								<li><a href="#">Accounts</a></li>
								<li><a href="#">Contacts</a></li>
								<li><a href="#">Tasks</a></li>
							</ul>
						    <div class="navbar-search pull-right">
								<div class="input-append">
									<input type="text" class="span2" placeholder="Search">
									<span class="btn add-on">Search</span>
								</div>
						    
						    </div>
						</div>
					</div>
				</div><!--crm-toolbar-->
				<div class="span9">
					<div class="row">
						<div class="span9">
							<!--Status update-->
							<textarea name="update-status" id="status-update" placeholder="message here" style="width: 98%"></textarea>
							<button class="btn pull-right">Upload File</button><button class="btn pull-right" id="clickedme">Update</button>
						</div>
					</div>
						Change stutus update to task where staff can comment on the status and other thing related to particular task.
					<ul class="thumbnails">
						<li class="span3">
							<div>
								Lead List
							</div>
						</li>
						<li class="span3">
							<div>
								Contact List
							</div>
						</li>
						<li class="span3">
							<div>
								Accounts List
							</div>
						</li>
					</ul>
					<dl>
						<dt>Leads</dt>
						<dd>Are individuals or representatives of organizations who show interest in your products or services.</dd>
						<dt>Accounts</dt>
						<dd>are companies or dept. wihting a company, with which you make business dealings.</dd>
						<dt>Contacts</dt>
						<dd>are people in a company with whome your communicate and interact in pursuit of a buisness opportunity.</dd>
					</dl>
					<div id="status"></div>
					<div id="status-pager"></div>
				</div>
			</div>

	</div><!--row-->
</div>
<!--views-->
<script type="text/x-kendo-template" id="tasklist">
	# $.each(data.has_tasks, function(index, item) { #
		# if (index < data.has_tasks.length - 1) { #
			<tr>
				<td>#: this.task_description #</td>
				<td onclick="javascript:alert('hi');">#: this.status #</td>
			</tr>
				
		# } else { #
			<tr>
				<td>#: this.task_description #</td>
				<td onclick="javascript:alert('hi');">#: this.status #</td>
			</tr>
	   # } #
	# }); #
</script>
<!--views-->
<script type="text/javascript">
var base_url = "<?php echo base_url(); ?>api/";
	
$(function () {
	//sidebar script

	
	//end of sidebar script	
	//taskGrid.hideColumn("status");
	
	var viewMD = kendo.observable({
		//datasources
		statusStore				: new kendo.data.DataSource({
			transport: {
				read: {
					url: "<?php echo base_url();?>api/status/messages",
					type: "GET",
					dataType: "json"
				},
				parameterMap: function(options, operation) {
					if(operation!== "read" && options.models) {
						return { models: kendo.stringify(options.models) };
					}
					return options;
				}
			},
			schema: {
				model: {
					id: "id",
					fields: {
						id		: { editable: false },
						message	: { editable: true }
					}
				}
			},
			pageSize: 20
		}),
			actionStatus : new kendo.data.DataSource({
			transport: {
				create: {
					url: "<?php echo base_url();?>api/status/messages",
					type: "POST",
					dataType: "json"
				},
				update: {
					url: "<?php echo base_url();?>api/status/messages",
					type: "PUT",
					dataType: "json"
				},
				destroy: {
					url: "<?php echo base_url();?>api/status/messages",
					type: "DELETE",
					dataType: "json"
				},
				parameterMap: function(options, operation) {
					if(operation!== "read" && options.models) {
						return { models: kendo.stringify(options.models) };
					}
					return options;
				}
			},
			batch: true,
			schema: {
				model: {
					id: "id",
					fields: {
						id		: { editable: false },
						message	: { editable: true }
					}
				}
			}
		}),
		commentStore : new kendo.data.DataSource({
			//transport: 
		}),
		//other
		unassigned_tasks		: <?php echo $unassign_tasks; ?>,
        incomplete_tasks		: <?php echo $assigned_tasks; ?>,
        number_of_users			: <?php echo $number_of_users; ?>,
        show_comment			: true,
        //functions
        display_comment			: function() {
        	alert("hi comment!");
        },
        show_incomplete_tasks	: function() {
        	if (this.get('incomplete_tasks') > 0 ) {
        		return false;
        	}
        	return true;
        },
		show_unassigned_tasks: function() {
        	if (this.get('incomplete_tasks') > 0 ) {
        		return false;
        	}
        	return true;
        },
        show_users: function() {
        	if (this.get('number_of_users') > 0 ) {
        		return false;
        	}
        	return true;
        }
	});
	
	kendo.bind($(".container"), viewMD);

	var userStatus = $("#status").kendoListView({
		dataSource	: viewMD.get("statusStore"),
		template	: kendo.template($("#statuslist").html()) 
	}).data('kendoGrid');
	$("#status-pager").kendoPager({
		dataSource:  viewMD.get("statusStore")
	});

	$("#clickedme").click(function(e){
		viewMD.get('actionStatus').add({user_id: <?php echo $this->session->userdata('user_id'); ?>, message: $("#status-update").val()});
		viewMD.get('actionStatus').sync();
		$("#status-update").val('');
	});

});

</script>

