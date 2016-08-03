		<div id="user-info" class="span3">
			<img src="./resources/images/photo.jpg" width="95%" height="240" class="img-polaroid">
			<p></p>
            <b class="navbar-text">សួរស្ដី, <?php echo $this->session->userdata("username"); ?></b>
            <ul class="nav pull-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">			
                  <b class="icon-cog"></b>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo base_url(); ?>users/change_information"><i class="icon-info-sign"></i> <?=$this->lang->line('user_change_information'); ?></a></li>
                  <li><a href="<?php echo base_url(); ?>users/change_password"><i class="icon-lock"></i> <?=$this->lang->line('user_change_password'); ?></a></li>
                  <li><a href="<?php echo base_url(); ?>auth/logout"><i class="icon-eject"></i> <?=$this->lang->line('top_menu_logout'); ?></a></li>
                </ul>
              </li>
            </ul>	
      	<ul class="nav nav-list">
		  	<li class="nav-header">Navigation</li>
		  	<li class="divider"></li>
		  	<li class="nav-header">Subordinates</li>
		  	<li>
		  		<table class="table table-striped" id="subordinates"></table>
		  	</li>
		</ul>
		</div><!--user information-->
			