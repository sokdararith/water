<div class="container">
	<div class="row">
		<div class="span12">
			<div class="error">
				<?php echo $this->session->flashdata('message'); ?>
			</div>
			<div id="login">
				<?php echo form_open('auth/register_company'); ?>
				<?php echo form_input('company'); ?><br>
				<?php echo form_submit('login', 'Register Company'); ?>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>