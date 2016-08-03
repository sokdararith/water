<div class="container">
	<div class="row">
		<div class="span12">
			<div id="login">
				<?php echo form_open('auth/login'); ?>
				<?php echo form_input('username'); ?><br>
				<?php echo form_password('password'); ?><br>
				<?php echo form_submit('login', 'Login'); ?> | <?php echo anchor('auth/register', 'Register'); ?>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function() {
	$('#company').kendoComboBox({
		dataSource: new kendo.data.DataSource({
			transport: {
				read: {
					url: "<?php echo base_url(); ?>api/account/companies",
					data: "GET",
					dataType: "json"
				}
			}
		}),
		index: -1,
		placeholder: "Select your company",
		dataTextField: "name",
		dataValueField: "id",
	});
});
</script>