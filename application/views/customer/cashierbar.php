<ul>
    <li class="<?php if($this->uri->segment(2) == "daily_payment") { echo "active"; } ?>">
        <a href="<?php echo base_url('customer/daily_payment'); ?>/" class="glyphicons coins"><i></i> ទទួលប្រាក់ប្រចាំថ្ងៃ</a>
    </li>
    <li class="<?php if($this->uri->segment(2) == "reconcile") { echo "active"; } ?>">
        <a href="<?php echo base_url('customer/reconcile'); ?>/" class="glyphicons calculator"><i></i> ផ្ទៀងផ្ទាត់&ផ្ទេរសាច់ប្រាក់</a>
    </li>
    <li class="<?php if($this->uri->segment(2) == "edit_payment") { echo "active"; } ?>">
        <a href="<?php echo base_url('customer/edit_payment'); ?>/" class="glyphicons edit"><i></i> កែប្រែការបង់ប្រាក់</a>
    </li>    
</ul>
