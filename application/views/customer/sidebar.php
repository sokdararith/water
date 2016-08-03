<div class="widget widget-tabs widget-tabs-double-2 widget-tabs-gray">
    <!-- Tabs Heading -->
    <div class="widget-head">
        <ul>
            <li class="<?php if($this->uri->segment(2) == "") { echo "active"; } ?>" style="width:100px;">
            	<a href="<?php echo base_url('customer'); ?>/" class="glyphicons home"><i></i><span>អតិថិជន</span></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "add_customer") { echo "active"; } ?>" style="width:100px;">
            	<a href="<?php echo base_url('customer/add_customer'); ?>/" class="glyphicons user_add"><i></i><span>អតិថិជនថ្មី</span></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "add_meter_record_by_area") { echo "active"; } ?>" style="width:100px;">
                <a href="<?php echo base_url('customer/add_meter_record_by_area'); ?>/" class="glyphicons dashboard"><i></i><span>អំនានកុងទ័រ</span></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "meter_record_by_area") { echo "active"; } ?>" style="width:100px;">
            	<a href="<?php echo base_url('customer/meter_record_by_area'); ?>/" class="glyphicons calculator"><i></i><span>រៀបចំវិក្កយបត្រ</span></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "so_fulfillment") { echo "active"; } ?>" style="width:120px;">
            	<a href="<?php echo base_url('customer/so_fulfillment'); ?>/" class="glyphicons check"><i></i><span>តាមដានបញ្ជាលក់</span></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "cashier") { echo "active"; } ?>" style="width:100px;">
                <a href="<?php echo base_url('customer/cashier'); ?>/" class="glyphicons credit_card"><i></i><span>បេឡាករ</span></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "customer_list") { echo "active"; } ?>" style="width:120px;">
                <a href="<?php echo base_url('customer/customer_list'); ?>/" class="glyphicons notes"><i></i><span>របាយការណ៍អតិថិជន</span></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "customer_type") { echo "active"; } ?>" style="width:100px;">
                <a href="<?php echo base_url('customer/customer_type'); ?>/" class="glyphicons settings"><i></i><span>ការរៀបចំ</span></a>
            </li>            
        </ul>
    </div>
    <!-- // Tabs Heading END -->
</div>
