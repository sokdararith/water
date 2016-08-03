<div class="navbar navbar-inverse">
	<div class="navbar-inner">
		<ul class="nav">
			<li class="<?php if($this->uri->segment(2) == "item_view") { echo "active"; } ?>">
		  		<a href="<?php echo base_url('report/item'); ?>/">
					<?=$this->lang->line('report_index'); ?>
					បញ្ជីរាយសារពើភ័ណ្ឌ
		  		</a>
			</li>
		  	<li class="<?php if($this->uri->segment(2) == "vendor_aging_report") { echo "active"; } ?>">
		  		<a href="<?php echo base_url('report/vendor_aging_report'); ?>/">
					<?=$this->lang->line('report_vendor_aging_report'); ?>
					Vendor
		  		</a>
			</li>
		  	
		</ul>
	</div>
</div>