<div class="container">
  <div class="row">
    <div class="span3"></div>
    <div class="span9">
    	<?php $this->load->view('crm/toolbar'); ?>
        <ul class="thumbnails">
        	<li class="span3">
            	<div id="lead"></div>
            </li>
        	<li class="span3">
            	<div id="contact"></div>
            </li>
        	<li class="span3">
            	<div id="group"></div>
            </li>
        </ul>
        <div id="tasks"></div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(function() {
	var customerDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: "",
				dataType: "json" 
			},
			parameterMap: function(options, operation) {
				if (operation === 'read') {
					
				}
			}
		},
		schema: {
			model: {
				id: "id"
			}
		}
	});
	//view model for this page
	var viewModel = kendo.observable({
		
	});
	
	kendo.bind($('.container'), viewModel);
	
	var lead = $('#lead').kendoGrid({
		columns: [
			{ title: "Leads" }
		],
		height: 200
	}).data('kendoGrid');
	
	var contact = $('#contact').kendoGrid({
		columns: [
			{ title: "Contacts" }
		],
		height: 200
	}).data('kendoGrid');
	
	var group = $('#group').kendoGrid({
		columns: [
			{ title: "Groups" }
		],
		height: 200
	}).data('kendoGrid');
	
	var task = $('#tasks').kendoGrid({
		columns: [
			{ title: "Tasks" },
			{ title: "Assigned to", width: "130px" },
			{ title: "Status", width: "100px" }
		],
		height: 300,
		pageable: true
	}).data('kendoGrid');
});
</script>