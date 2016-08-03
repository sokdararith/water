<div class="widget widget-tabs widget-tabs-double-2 widget-tabs-gray">
    <!-- Tabs Heading -->
    <div class="widget-head">
        <ul>
            <li class="<?php if($this->uri->segment(1) == "inventory") { echo "active"; } ?>" style="width:100px;">
            	<a href="<?php echo base_url('inventory'); ?>/" class="glyphicons home"><i></i><span>សន្និធិ</span></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "items") { echo "active"; } ?>" style="width:100px;">
            	<a href="<?php echo base_url('inventory/items'); ?>/" class="glyphicons user_add"><i></i><span> <?=$this->lang->line('inventory_item'); ?> </span></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "load_unit_measure") { echo "active"; } ?>" style="width:100px;">
                <a href="<?php echo base_url('inventory/load_unit_measure'); ?>/" class="glyphicons dashboard"><i></i><span>អំនានកុងទ័រ</span></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "load_adjustment") { echo "active"; } ?>" style="width:100px;">
            	<a href="<?php echo base_url('inventory/load_adjustment'); ?>/" class="glyphicons calculator"><i></i><span> <?=$this->lang->line('inventory_adjustment'); ?> </span></a>
            </li>
            <li class="<?php if($this->uri->segment(1) == "inventory") { echo "active"; } ?>" style="width:120px;">
            	<a href="<?php echo base_url('inventory/index/'); ?>/" class="glyphicons check"><i></i><span> <?=$this->lang->line('inventory_item'); ?> </span></a>
            </li>            
        </ul>
    </div>
    <!-- // Tabs Heading END -->
</div>
