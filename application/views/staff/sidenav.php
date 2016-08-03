<div class="navbar navbar-inverse">
    <div class="navbar-inner">
        <ul class="nav">
            <li class="<?php if($this->uri->segment(2) == "" && $this->uri->segment(1) == "staff") { echo "active"; } ?>">
                <a href="#"><?=$this->lang->line('dashboard'); ?></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "profile") { echo "active"; } ?>">
                <a href="<?php echo base_url(); ?>staff/profile/<?php echo $this->session->userdata('user_id'); ?>"><?=$this->lang->line('profile'); ?></a>
            </li>
            <li class="<?php if($this->uri->segment(1) == "project") { echo "active"; } ?>">
                <a href="<?php echo base_url(); ?>project/">Project</a>
            </li>
            <li class="<?php if($this->uri->segment(1) == "activity") { echo "active"; } ?>">
                <a href="<?php echo base_url(); ?>activity/">Tasks</a>
            </li>
            <li class="<?php if($this->uri->segment(1) == "timesheet") { echo "active"; } ?>">
                <a href="<?php echo base_url(); ?>timesheet/">Timesheet</a>
            </li>
        </ul>
    </div>
</div>
				

			