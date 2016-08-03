<ul>
    <li class="<?php if($this->uri->segment(2) == "add_meter_record_by_area") { echo "active"; } ?>">
        <a href="<?php echo base_url('customer/add_meter_record_by_area'); ?>/" class="glyphicons google_maps"><i></i> តាមត្រង់ស្វូ</a>
    </li>
    <li class="<?php if($this->uri->segment(2) == "ir_reader") { echo "active"; } ?>">
        <a href="<?php echo base_url('customer/ir_reader'); ?>/" class="glyphicons barcode"><i></i> តាម IR Reader</a>
    </li>
    <li class="<?php if($this->uri->segment(2) == "unread_meter") { echo "active"; } ?>">
        <a href="<?php echo base_url('customer/unread_meter'); ?>/" class="glyphicons unchecked"><i></i> មិនទាន់អាន</a>
    </li>    
</ul>
