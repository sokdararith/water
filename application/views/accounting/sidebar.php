<div class="widget widget-tabs widget-tabs-double-2 widget-tabs-gray">
    <!-- Tabs Heading -->
    <div class="widget-head">
        <ul>
        	<li class="<?php if($this->uri->segment(2) == "") { echo "active"; } ?>" >
            	<a href="<?php echo base_url('accounting'); ?>/" class="glyphicons home"><i></i><span>គណនេយ្យ</span></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "items") { echo "active"; } ?>" >
            	<a href="<?php echo base_url('accounting/items'); ?>/" class="glyphicons pin_flag"><i></i><span> <?=$this->lang->line('accounting_items'); ?> </span></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "journal") { echo "active"; } ?>" >
            	<a href="<?php echo base_url('accounting/journal'); ?>/" class="glyphicons pencil"><i></i><span> <?=$this->lang->line('accounting_journal'); ?> </span></a>
            </li>            
            <li class="<?php if($this->uri->segment(2) == "balance_sheet") { echo "active"; } ?>" >
            	<a href="<?php echo base_url('report/balance_sheet'); ?>/" class="glyphicons blogger"><i></i><span> <?=$this->lang->line('accounting_report_balance_sheet'); ?> </span></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "journal") { echo "active"; } ?>" >
            	<a href="<?php echo base_url('report/journal'); ?>/" class="glyphicons certificate"><i></i><span> <?=$this->lang->line('accounting_report_journal'); ?> </span></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "general_ledger") { echo "active"; } ?>" >
            	<a href="<?php echo base_url('report/general_ledger'); ?>/" class="glyphicons align_center"><i></i><span> <?=$this->lang->line('accounting_report_general_ledger'); ?> </span></a>
            </li>
            <li class="<?php if($this->uri->segment(2) == "pl_report") { echo "active"; } ?>" >
                <a href="<?php echo base_url('report/pl_report'); ?>/" class="glyphicons stats"><i></i><span> <?=$this->lang->line('accounting_report_profit_loss'); ?> </span></a>
            </li>              
        </ul>
    </div>
    <!-- // Tabs Heading END -->
</div>
