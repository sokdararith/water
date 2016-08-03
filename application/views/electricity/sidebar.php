<div class="widget widget-tabs widget-tabs-double-2 widget-tabs-gray">
    <!-- Tabs Heading -->
    <div class="widget-head">
        <ul>
        	<li class="<?php if($this->uri->segment(2) == "transformer_list") { echo "active"; } ?>" style="width:100px;">
            	<a href="<?php echo base_url('electricity/transformer_list'); ?>/" class="glyphicons home"><i></i><span>អគ្គីសនី</span></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "index") { echo "active"; } ?>" >
            	<a href="<?php echo base_url(); ?>electricity/index/" class="glyphicons pin_flag"><i></i><span>របាយការណ៍អគ្គីសនីទូទៅ</span></a>
            </li>            
        </ul>
    </div>
    <!-- // Tabs Heading END -->
</div>