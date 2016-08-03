<div class="widget widget-tabs widget-tabs-double-2 widget-tabs-gray">
    <!-- Tabs Heading -->
    <div class="widget-head">
        <ul>
            <li class="<?php if($this->uri->segment(2) == "lists") { echo "active"; } ?>" style="width:150px;">
            	<a href="<?php echo base_url('vendor/lists'); ?>/" class="glyphicons home"><i></i><span>អ្នកផ្គត់ផ្គង់</span></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "add_vendor") { echo "active"; } ?>" style="width:150px;">
            	<a href="<?php echo base_url('vendor/add_vendor'); ?>/" class="glyphicons user_add"><i></i><span>អ្នកផ្គត់ផ្គង់ថ្មី</span></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "electricity_bill") { echo "active"; } ?>" style="width:150px;">
            	<a href="<?php echo base_url('vendor/electricity_bill'); ?>/" class="glyphicons calculator"><i></i><span>វិក្កយបត្រអគ្គីសនី</span></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "vendor_aging_report") { echo "active"; } ?>" style="width:150px;">
                <a href="<?php echo base_url('report/vendor_aging_report'); ?>/" class="glyphicons notes"><i></i>
                    <span><?=$this->lang->line('accounting_report_ap_aging'); ?></span>
                </a>
            </li>                               
        </ul>
    </div>
    <!-- // Tabs Heading END -->
</div>
