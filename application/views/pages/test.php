<div class="container">
	<div class="row">
		<div class="span12">
			<div id="statusGrid"></div>
			<button id="save">Save</button>
		</div>
	</div>
</div>
<script type="text/x-kendo-tmpl" id="statuslist">
	<div class="media">
		<a href="" class="pull-left"><img class="media-object" src="${user_id}"></a>
		<div class="media-body">
			<p class="message"><strong>Message: </strong>${message}</p>
			<p class="posted">Posted on ${created_at} <span class="btn" id="${id}" onClick="testAlert('hi from here')"><i class="icon-comment"></i></span</p>
			<p><textarea name="comment" id="" cols="30" rows="10" class="comment"></textarea></p><hr>
			# $.each(data.comments, function(index, item) { #
				# if (index < data.comments.length - 1) { #
					<div class="media">
						<a href="" class="pull-left"><img class="media-object" src="${user_id}"></a>
						<div class="media-body">
							<p><i>Comment: </i>#: this.comment #</p>
							<p class="posted">Posted on #: this.created_at #</p>
						</div>				
					</div>
				# } else { #
					<div class="media">
						<a href="" class="pull-left"><img class="media-object" src="${user_id}"></a>
						<div class="media-body">
							<p><i>Comment: </i>#: this.comment #</p>
							<p class="posted">Posted on #: this.created_at #</p>
						</div>				
					</div>
			   # } #
			# }); #
		</div>	
	</div>
</script>
<script type="text/javascript">
$(function(){
	var template = kendo.template($("#statuslist").html());
	statusDS = new kendo.data.DataSource({
			transport: {
				read: {
					url: "<?php echo base_url();?>api/status/messages",
					type: "GET",
					dataType: "json"
				}
			}
	});
	
	var actionStatus = new kendo.data.DataSource({
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
	});
	
	var statusListView = $("#statusGrid").kendoListView({
		dataSource: statusDS,
		selectable: true,
		template: template
	}).data('kendoListView');
	
	$("#save").click(function(){
		actionStatus.add([
			{ user_id: "1", message: "This is the message yo!"},
			{ user_id: "1", message: "Here is another message"}
			]);
		actionStatus.sync();
		//alert("Arrrrrrrrr!");
	});
	
	function testAlert(msg) {
		alert(msg);
	}

});
</script>