<div class="widget widget-heading-simple widget-body-gray widget-employees">
		<div class="widget-body padding-none">	
			<div class="row-fluid row-merge">
				<div class="span3 listWrapper" style="height: 630px;">
					<div class="innerAll">
						<form autocomplete="off" class="form-inline">
							<div class="widget-search separator bottom">
								<button type="button" class="btn btn-default pull-right" id="search"><i class="icon-search"></i></button>
								<div class="overflow-hidden">
									<input type="search" value="" placeholder="ស្វែងរក" id="searchField">
								</div>
							</div>
							<div class="select2-container" style="width: 100%;">
								<div class="overflow-hidden">
									<select name="" id="searchOptions" style="width: 100%;" tabindex="-1">
						                <option value="name">ឈ្មោះ</option>
						                <option value="company">ក្រុមហ៊ុន</option>
						                <option value="phone">ទូរស័ព្ទ</option>
						                <option value="customer_no">ID</option>
									</select>
								</div>
							</div>
							<!-- <div class="select2-container" id="s2id_autogen2" style="width: 100%;">
								<a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
									<span>Design</span><abbr class="select2-search-choice-close" style="display:none;"></abbr>   
									<div><b></b></div></a><input class="select2-focusser select2-offscreen" type="text"></div>
									<select style="width: 100%;" class="select2-offscreen" tabindex="-1">
						               <optgroup label="Department">
						                   <option value="design">Design</option>
						                   <option value="development">Development</option>
						               </optgroup>
									</select> -->
						</form>
					</div>
					<span class="results"></span>
					<ul class="list unstyled" id="vendorList" style="height: 535px;"></ul>
				</div>

				<div class="span9 detailsWrapper">
					
					<!-- <div class="innerLR">
						<div class="navbar">
							<div class="navbar-inner">
								<ul class="nav">
									<li><a href="#"><i class="icon-home"></i></a></li>
							        <li class="<?php if($this->uri->segment(2) == "journal") { echo "active"; } ?>">
							            <a href="<?php echo base_url('report/vendor_aging_report'); ?>/">
							            <?=$this->lang->line('accounting_report_ap_aging'); ?>
							            </a>
							        </li>
								</ul>
							</div>
						</div>
					</div> -->	
					<div class="innerAll">
						<div id="application"></div>
					</div>
					
				</div>
			</div>	
		</div>
</div>
<div id="dialog">

</div>
<script id="vendorListTmpl" type="text/x-kendo-template">
	<li class="">
		<div class="media innerAll">
			<div class="media-object pull-left thumb hidden-phone"><img data-src="holder.js/51x51/dark" alt="51x51" style="width: 51px; height: 51px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADMAAAAzCAYAAAA6oTAqAAACAUlEQVRoQ+2Yv8upcRjGrxdFDEZKBmWxSIlFIgmRwSbl/6MUNkWUwSgZDAYxKEQMisGP0/c76NTRebl17t5O91PP4nku131dn++9PF+JROKO/+T6kjA/lKSQ+aFgIGSEDEMDcswYSiZZCBlSbQwiIcNQMslCyJBqYxAJGYaSSRZChlQbg0jIMJRMsiCRsVqt8Pv9uN1uMJlMWC6XWCwWeoBwOIzD4YDpdPp0oE+03yUkhXG73cjlcrhcLjrMZDLBcDhEJBKBx+PBfD5Hq9V66v2J9p+E8Xq9iEajqNfrOJ/P+nY6nUilUrBYLJjNZuh0Okgmk3A4HGg0GshkMjidTprYK9rvBn/2nEQmFovB5/M9/q/f72s66ioWi9jtdmi327DZbCiVSjAajfpIVqtVBAKBl7RsYex2uyaw2Wz0sMfjEc1m848w6odQKIRgMIjxeIzBYIB3tO8GIpHJ5/O4Xq/odruaxGq1euzI72TMZjPK5bLeK/V+pVJBPB5/SftuEPU+KYxa8nQ6rf3UkGp3ttvtg8x6vUav10M2m4XL5UKtVkOhUMB+v8doNHpJyxZGGRkMBr0T6ojd7+99e/9E+7eQJDKU1jg0EoajZYqHkKG0xqERMhwtUzyEDKU1Do2Q4WiZ4iFkKK1xaIQMR8sUDyFDaY1DI2Q4WqZ4CBlKaxyaXyM+XIKj6S59AAAAAElFTkSuQmCC"></div>
			<div class="media-body">
				<span class="strong">#=surname# #=name#</span>
				<span class="muted">#=phone#</span>
				<span class="muted">#=email#</span>
				
			</div>
		</div>
	</li>
</script>
<script id="itemsTmpl" type="text/x-kendo-template">
	<li>
		<span data-bind="text: item.id"></span>
	</li>
</script>
<script id="appIndex" type="text/x-kendo-template">
	<div id="info"></div>
	<div id="content" style="padding-top: 10px;"></div>
</script>
<script id="vendorInfo" type="text/x-kendo-template">
	<div class="title">
		<div class="row-fluid">
			<div class="span4">
				<h3 class="text-primary" data-bind="text: vendor.name"></h3>
				<span class="muted" data-bind="text: vendor.job"></span>
				<ul class="icons-ul">
					<li><i class="icon-envelope icon-li icon-fixed-width"></i> <span data-bind="text: vendor.email"></span></li>
					<li><i class="icon-phone icon-li icon-fixed-width"></i> <span data-bind="text: vendor.phone"></span></li>
				</ul>
			</div>
			<div class="span8">
				<div class="row-fluid">
					<div class="span6">
						<span class="widget-stats widget-stats-primary widget-stats-4">
							<span class="txt">សមតុល្យ</span>
							<span class="count" data-bind="text: vendor.amount_due"></span>
							<span class="glyphicons refresh"><i></i></span>
							<div class="clearfix"></div>
							<i class="icon-play-circle"></i>
						</span>
					</div>
					<div class="span5 offset1">
						<h5 class="strong">Skills</h5>
						<div class="progress progress-mini progress-primary count-outside add-outside"><div class="count">100%</div><div class="bar" style="width: 100%;"></div><div class="add">HTML</div></div>
						<div class="progress progress-mini progress-primary count-outside add-outside"><div class="count">90%</div><div class="bar" style="width: 90%;"></div><div class="add">CSS</div></div>
						<div class="progress progress-mini progress-primary count-outside add-outside"><div class="count">93%</div><div class="bar" style="width: 93%;"></div><div class="add">jQuery</div></div>
						<div class="progress progress-mini progress-primary count-outside add-outside"><div class="count">79%</div><div class="bar" style="width: 79%;"></div><div class="add">PHP</div></div>
						<div class="progress progress-mini count-outside add-outside"><div class="count">20%</div><div class="bar" style="width: 20%;"></div><div class="add">WP</div></div>
						<div class="separator bottom"></div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<hr>
	<div class="menubar links primary hidden-print">
		<ul>
			<li>Navigation:</li>
			<li><a data-bind="click: eBill, enabled: showBtn">វិក្កយបត្រ័អគ្គីសនី</a></li>
			<li><a data-bind="click: purchase, enabled: showBtn">ទិញសន្និធិ</a></li>
			<li><a data-bind="click: expense, enabled: showBtn">ចំណាយ</a></li>
			<li><a data-bind="click: payBill, enabled: showBtn">ទូទាត់បំណុល</a></li>
			<li><a data-bind="click: po, enabled: showBtn">បញ្ជាទិញ</a></li>
			<li class="divider"></li>
			<li>របាយការណ៍</li>
			<li><a data-bind="click: billHistory, enabled: showBtn">ប្រត្តិប័ត្រការណ៍</a></li>
			<li><a data-bind="click: transfomerRec, enabled: showBtn">ទិញថាមពល</a></li>
		</ul>
	</div>	
</script>
<!--bill list-->
<script id="billGrid" type="text/x-kendo-template">
	<tr data-bind="events: {dblclick: change}" data-id="#:id#">
		<td>
			#=kendo.toString(date, 'dd-MM-yyyy')#
		</td>
		<td>
			<span data-bind="text: bill_type"></span>
		</td>
		<td style="text-align: right">
			#=kendo.toString(parseFloat(amount_billed), "c2")#
		</td>
		<td style="text-align: right">
			#=kendo.toString(amount_due, "c2")#
		</td>
		<td style="text-align: right">
			#=kendo.toString(amount_paid, "c2")#
		</td>	
		<td>
			#= status === "1"? "ទូទាត់រួច":"មិនទាន់ទូទាត់" #
		</td>
	</tr>
</script>
<script id="purchase" type="text/x-kendo-template">
	<div id="payment">
		<div class="btn-group">
			<button class="btn" data-bind="disabled: paidCash, click: cashBtn">ទិញជាសាច់ប្រាក់</button>
			<button class="btn" data-bind="enabled: paidCash, click: cashBtn">ទិញជំពាក់</button>
		</div>

		<div id="cashPayment" data-bind="visible: paidCash" class="well">
			<table class="table">
				<tbody>
					<tr>
						<td>គណនីសាច់ប្រាក់</td>
						<td><input type="text" placeholder="គណនីសាច់ប្រាក់" 
											   data-bind="source: cashAccts, value: cashAcct" 
											   data-role="combobox" 
											   data-text-field="name" 
											   data-value-field="id" style="width: 220px;"
											   name="cashAccount" 
											   required data-required-msg="សូមផ្ដល់លេខគណនីសាច់ប្រាក់">
							<span class="k-invalid-msg" data-for="cashAccount"></span>
						</td>
						<td>កាលបរិច្ឆេទកត់ត្រា</td>
						<td><input type="text" data-role="datepicker" placeholder="cash" data-bind="value: date" style="width: 220px;"></td>
					</tr>
					<tr>
						<td>វិធីទូទាត់</td>
						<td><input type="text" placeholder="វិធីទូទាត់" data-bind="source: paymentMethod, value: pmtMethod" data-role="combobox" data-text-field="method" data-value-field="id" style="width: 220px;"></td>
						<td>លេខសក្ខីបត្រ័</td>
						<td><input type="text" placeholder="លេខសក្ខីបត្រ័" data-bind="value: ref"></td>
					</tr>
					<tr>
						<td>លេខសែក</td>
						<td><input type="text" placeholder="លេខសែក" data-bind="value: checkNo"></td>
						<td>ពិពណ៍នារួម</td>
						<td><input type="text" placeholder="ពិពណ៍នាសម្រាបសាច់ប្រាក់" data-bind="value: memo"></td>
					</tr>
					<tr>
						<td>Class</td>
						<td><input type="text" placeholder="រើសយក license" data-bind="source: classes, value: class_id" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 220px;"></td>
						<td>P.O</td>
						<td>
							<input data-role="combobox"
				                   data-placeholder="ទាញពីបញ្ជាទិញ"				                   
				                   data-text-field="number"
				                   data-value-field="id"
				                   data-bind="value: po_id, source: poList, events:{ change: poChange }"
				                   style="width: 220px" />
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div id="creditPayment" data-bind="invisible: paidCash" class="well">
			<table class="table">
				<tbody>
					<tr>	
						<td>គណនីជំពាក់</td>
						<td><input type="text" placeholder="គណនីអ្នកផ្គត់ផ្គង់" 
											   data-bind="source: creditAccts, value: creditAcct" 
											   data-role="combobox" 
											   data-text-field="name" 
											   data-value-field="id" 
											   style="width: 220px;"
											   name="creditAccount" 
											   required data-required-msg="សូមផ្ដល់លេខគណនីជំពាក់">
							<span class="k-invalid-msg" data-for="creditAccount"></span>
						</td>
						<td>កាលបរិច្ឆេទកត់ត្រា</td>
						<td><input type="text" data-role="datepicker" placeholder="Date" data-bind="value: date" style="width: 220px;"></td>
					</tr>
					<tr>
						<td>វិធីទូទាត់</td>
						<td><input type="text" placeholder="វិធីទូទាត់" data-bind="source: paymentTerms, value: paymentTerm" data-role="combobox" data-text-field="term" data-value-field="id" style="width: 220px;"></td>
						<td>លេខសក្ខីបត្រ័</td>
						<td><input type="text" placeholder="លេខសក្ខីបត្រ័" data-bind="value: ref"></td>

					</tr>
					<tr>
						<td>ថ្ងៃត្រូវទូទាត់</td>
						<td><input type="text" data-role="datepicker" placeholder="Due Date" data-bind="value: due_date" style="width: 220px;"></td>
						<td>ពិពណ៍នារួម</td>
						<td><input type="text" placeholder="ពិពណ៍នាសម្រាប់គណនីជំពាក់" data-bind="value: memo"></td>
					</tr>
					<tr>
						<td>Class</td>
						<td><input type="text" placeholder="រើសយក license" data-bind="source: classes, value: class_id" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 220px;"></td>
						<td>លេខវិក្កយប័ត្រ</td>
						<td><input type="text" placeholder="លេខវិក្កយប័ត្រអ្នកផ្គត់ផ្គង់" data-bind="value: invoiceNumber"></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td>P.O</td>
						<td>
							<input data-role="combobox"
				                   data-placeholder="ទាញពីបញ្ជាទិញ"				                   
				                   data-text-field="number"
				                   data-value-field="id"
				                   data-bind="value: po_id, source: poList, events:{ change: poChange }"
				                   style="width: 220px" />
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<table class="table table-condensed">
			<tbody data-role="grid" data-bind="source: cart" data-row-template="cartTmpl" data-columns="[{title: 'ឈ្មោះសន្និធិ', width: '140px'}, {title:'ពិពណ៏នា'}, {title:'តំលៃ', width: '110px'}, {title:'ចំនួន', width: '100px'}, {title:'សរុប', width: '120px'}, {title:'', width: '40px'}]"></tbody>
		</table>
		<i class="icon-plus" data-bind="click: addToCart"></i>
		<table>
			<tbody>
				<tr>
					<td colspan="6" style="text-align:right; font-size: 30px;margin: 20px 0;">សរុប:<span data-bind="text: total"></span></td>
				</tr>
			</tbody>
		</table>
		<button class="btn btn-primary pull-right" data-bind="click: record">កត់ត្រាប្រតិបត្តិការនេះ</button>
	</div>
</script>
<script id="cartTmpl" type="text/x-kendo-template">
	<tr>
		<td><input type="text" placeholder="Select One" data-bind="source: items, value: item_id, events: {change: change}" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 130px;"></td>
		<td><input type="text" placeholder="Description" style="width: 145px;" data-bind="value: description"></td>
		<td><input type="text" style="width: 80px;" data-role="numerictextbox" data-bind="value: cost"></td>
		<td><input type="text" style="width: 60px;" data-bind="value: quantity"></td>
		<td><span data-bind="text: subtotal"></span></td>
		<td><i class="icon-trash" data-bind="click: remove"></i></td>
	</tr>
</script>
<script id="eBill" type="text/x-kendo-template">
	<div id="electricity">
		<div class="well">
			<table class="table">
				<tbody>
					<tr>
						<td>លេខវិក្កយប័ត្រ</td>
						<td><input type="text" placeholder="លេខវិក្កយប័ត្រអ្នកផ្គត់ផ្គង់" 
											   data-bind="value: invoiceNumber" 
											   id="invoiceNumber" 
											   required data-required-msg="សូមវាយលេលខវិក្ក័យប័ត្រ"
											   name="invoiceNumber">
							<span class="k-invalid-msg" data-for="invoiceNumber"></span>
						</td>
						<td>លេខសក្ខីបត្រ័</td>
						<td><input type="text" placeholder="លេខសក្ខីបត្រ័ជំពាក់" data-bind="value: ref" id="referenceNumber"></td>
					</tr>
					<tr>
						<td>Class</td>
						<td><input type="text" placeholder="រើសយក license" 
											   data-bind="source: classes, value: class_id" 
											   data-role="combobox" data-text-field="name" 
											   data-value-field="id" style="width: 220px;"
											   required data-required-msg="សូមរើសយកClassមួយ។"
											   name="class">
							<span class="k-invalid-msg" data-for="class"></span>
						</td>
						<td>កាលបរិច្ឆេទកត់ត្រា:</td>
						<td><input type="text" placeholder="Enter Date" data-role="datepicker" data-bind="value: date" id="date" style="width: 220px;"></td>
					</tr>
					<tr>
						<td>គឺតចាប់ពីថ្ងៃទី</td>
						<td><input type="text" placeholder="ពី" data-role="datepicker" data-bind="value: billFrom" id="from" style="width: 220px;"></td>
						<td>លក្ខខណ្ឌទូទាត់:</td>
						<td><input type="text" placeholder="Payment Term" data-role="dropdownlist" data-bind="source: paymentTerms, value: paymentTerm" data-text-field="term" data-value-field="id" id="pmtTerm" style="width: 220px;"></td>
					</tr>
					<tr>
						<td>ដល់ថ្ងៃទី</td>
						<td><input type="text" placeholder="ដល់" data-role="datepicker" data-bind="value: billTo" id="to" style="width: 220px;"></td>
						<td>កាលបរិច្ឆេទទូទាត់:</td>
						<td><input type="text" placeholder="Enter Date" data-role="datepicker" data-bind="value: dateDue" id="due_date" style="width: 220px;"></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div id="transformerGrid" data-role="grid" 
								  data-bind="source: transformers" 
								  data-editable="true" 
								  data-navigatable="true"
								  data-row-template="transformerList" 
								  data-columns="[
								  	{title:'ត្រង់ស្វូ', width:'190px'},
								  	{title:'អំនានថ្មី'},
								  	{title:'អំនានចាស់'},
								  	{title:'មេគុណ'},
								  	{title:'តម្លៃ'},
								  	{title:'', width:'30px'}
								  ]"></div>
		<div>
		<i class="icon-plus" data-bind="click: addNew"></i>
			<p style="text-align: right; font-size: 30px; margin: 20px 0;">សរុប:<span data-bind="text: cTotal"></span></p>
		</div>
		<button class="btn pull-right" data-bind="click: record">កត់ត្រាវិក្កយបត្រនេះ</button>
	</div>
</script>
<script id="transformerList" type="text/x-kendo-template">
	<tr>
			<td>
				<select name="" id="" 
						placeholder="Select One" 
						data-role="combobox" 
						data-option-label="Select One" 
						data-bind="source: transformerDS, value: transformer_id, events: {change: change}" 
						data-text-field="transformerNumber" 
						data-value-field="id">
				</select>
			</td>
			<td>
				<input type="text" data-bind="value: new_reading" style="width: 80px; margin-top: 13px">
			</td>
			<td>
				<input type="text" data-bind="value: prev_reading" style="width: 80px; margin-top: 13px">
			</td>
			<td>
				<input type="text" data-bind="value: multiplier" style="width: 80px; margin-top: 13px">
			</td>
			<td>
				<input type="text" data-bind="value: tariff" style="width: 80px; margin-top: 13px">
			</td>
			<td>
				<i class="icon-trash" data-bind="click: remove"></i>
			</td>	
		</tr>
</script>
<script id="expense" type="text/x-kendo-template">
	<div id="payment">
		<div class="btn-group">
			<button class="btn" data-bind="disabled: paidCash, click: cashBtn">ចំណាយជាសាច់ប្រាក់</button>
			<button class="btn" data-bind="enabled: paidCash, click: cashBtn">ចំណាយជំពាក់</button>
		</div>
		<div id="cashPayment" data-bind="visible: paidCash" class="well">
			<table class="table">
				<tbody>
					<tr>
						<td>គណនីសាច់ប្រាក់</td>
						<td><input type="text" placeholder="គណនីសាច់ប្រាក់" data-bind="source: cashAccts, value: cashAcct" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 220px;"></td>
						<td>កាលបរិច្ឆេទកត់ត្រា</td>
						<td><input type="text" data-role="datepicker" placeholder="cash" data-bind="value: date" style="width: 220px;"></td>
					</tr>
					<tr>
						<td>វិធីទូទាត់</td>
						<td><input type="text" placeholder="វិធីទូទាត់" data-bind="source: paymentMethod, value: pmtMethod" data-role="combobox" data-text-field="method" data-value-field="id" style="width: 220px;"></td>
						<td>លេខសក្ខីបត្រ័</td>
						<td><input type="text" placeholder="លេខសក្ខីបត្រ័" data-bind="value: ref"></td>
					</tr>
					<tr>
						<td>លេខសែក</td>
						<td><input type="text" placeholder="លេខសែក" data-bind="value: checkNo"></td>
						<td>ពិពណ៍នារួម</td>
						<td><input type="text" placeholder="ពិពណ៍នារួម" data-bind="value: memo"></td>
					</tr>
					<tr>
						<td>Class</td>
						<td><input type="text" placeholder="រើសយក license" data-bind="source: classes, value: class_id" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 220px;"></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div id="creditPayment" data-bind="invisible: paidCash" class="well">
			<table class="table">
				<tbody>
					<tr>
						<td>គណនីជំពាក់</td>
						<td><input type="text" placeholder="គណនីជំពាក់" data-bind="source: creditAccts, value: creditAcct" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 220px;"></td>
						<td>កាលបរិច្ឆេទកត់ត្រា</td>
						<td><input type="text" data-role="datepicker" placeholder="cash" data-bind="value: date" style="width: 220px;"></td>
					</tr>
					<tr>
						<td>វិធីទូទាត់</td>
						<td><input type="text" placeholder="វិធីទូទាត់" data-bind="source: paymentTerms, value: paymentTerm" data-role="combobox" data-text-field="term" data-value-field="id" style="width: 220px;"></td>
						<td>លេខសក្ខីបត្រ័</td>
						<td><input type="text" placeholder="លេខសក្ខីបត្រ័" data-bind="value: ref"></td>
					</tr>
					<tr>
						<td>ថ្ងៃត្រូវបង់ប្រាក់</td>
						<td><input type="text" data-role="datepicker" placeholder="Due Date" data-bind="value: dateDue" style="width: 220px;"></td>
						<td>ពិពណ៍នារួម</td>
						<td><input type="text" placeholder="ពិពណ៍នារួម" data-bind="value: memo"></td>
					</tr>
					<tr>
						<td>Class</td>
						<td><input type="text" placeholder="រើសយក license" data-bind="source: classes, value: class_id" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 220px;"></td>
						<td>លេខវិក្កយប័ត្រ</td>
						<td><input type="text" placeholder="លេខវិក្កយប័ត្រ" data-bind="value: invoiceNumber"></td>
					</tr>
				</tbody>
			</table>
		</div>
		<hr>
		
		<table class="table">

			<tbody data-role="grid" data-bind="source: bucket" 
									data-row-template="expenseCart"
									data-columns="[{title:'គណនី', width: '150px'},{title:'ចំនួន', width: '110px'},'ពិពណ៍នាសម្រាប់គណនីនេះ',{title:'Class', width:'140px'},{title:'', width:'50px'}]"></tbody>
		</table>
		<i class="icon-plus" data-bind="click: addToCart"></i>
		<table>
			<tr>
				<td colspan="5"><p style="text-align:right">ចំនួនដែលត្រូវទូទាត់ <span data-format="{0:C}" data-bind="text: total"></span></p></td>
			</tr>
		</table>
		<button class="btn pull-right" data-bind="click: record">កត់ត្រាប្រតិបត្តិការនេះ</button>
	</div>
</script>
<script id="expenseCart" type="text/x-kendo-template">
	<tr>
		<td><select type="text" placeholder="Select One" data-bind="source: expenseAccts, value: account_id, events: {change: change}" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 130px;"></select></td>
		<td><input type="text" data-bind="value: amount" data-role="numerictextbox" data-format="{0:c}" style="width: 100px;"></td>
		<td><input type="text" placeholder="Description" data-bind="value: memo"></td>
		<td><input type="text" placeholder="Select One" data-bind="source: classes, value: class_id" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 130px;"></td>
		<td><i class="icon-trash" data-bind="click: remove"></i></td>
	</tr>	
</script>
<script id="paybill" type="text/x-kendo-template">
	<div id="billHead" data-role="validator" class="well">
		<table class="table">
			<tbody>
				<tr>
					<td>គណនីសាច់ប្រាក់:</td>
					<td><input type="text" placeholder="គណនីសាច់ប្រាក់" data-bind="source: cashAccounts, value: cashAccount" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 220px;" required data-required-msg="You need to enter a URL" data-text-msg="This url is invalid"></td>
					<td>លេខសែក:</td>
					<td><input type="text" placeholder="បើប្រើសេកដើម្បីទូទាត់"></td>
				</tr>
				<tr>
					<td>កាលបរិច្ឆេទទូទាត់</td>
					<td><input type="text" placeholder="កាលបរិច្ឆេទ" data-bind="value: date" data-role="datepicker" style="width: 220px;"></td>
					<td>ពិពណ៍នារួម</td>
					<td><input type="text" placeholder="ពិពណ៍នារួម" data-bind="value: payment"></td>
				</tr>
				<tr>
					<td>Class</td>
					<td><input type="text" placeholder="រើសយក license" data-bind="source: classes, value: class_id" data-role="combobox" data-text-field="name" data-value-field="id" style="width: 220px;"></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3" style="text-align: right">ចំនួនដែលត្រូវទូទាត់</td>
					<td><span  style="font-size:30px;" data-bind="text: totalAmount"></span></td>
				</tr>
			</tbody>
		</table>
	</div>
	<table class="table" id="bills">
		<thead>
			<tr>
				<th><i class="icon-ok"></i></th>
				<th width="100">កាលបរិច្ឆេទ</th>
				<th>លេខវិក្កយប័ត្រ</th>
				<th>ប្រភេទប្រត្តិបត្រការ</th>
				<th>ចំណាយជំពាក់</th>
				<th>ចំនួនត្រូវទូទាត់</th>
				<th width="110">សាច់ប្រាក់</th>
			</tr>
		</thead>
		<tbody data-role="listview" data-bind="source: bills" data-template="billList"></tbody>
	</table>
	<button class="btn" data-bind="click: pay_bill">ទូទាត់បំណុលទាំងនេះ</button>
</script>
<script id="billList" type="text/x-kendo-template">
		<tr data-id="#=id#">
			<td><input type="checkbox" name="bill-#=id#" class="checkBox" data-id="#=id#" data-bind="click: tick"></td>
			<td>
				<span data-bind="text: date" data-format="{dd-MM-yyyy}"></span>
			</td>
			<td>
				#=invoiceNumber#
			</td>
			<td>
				<span data-bind="text: bill_type"></span>
			</td>
			<td>
				<span data-bind="text:amount_billed" data-format="{0,C}"></span>
			</td>
			<td>
				#=kendo.toString(amount_due, "c")#
			</td>
			<td>
				<input type="text" data-bind="value: amount_pay, events: {keypress: onEnter}"  class="amount" style="width: 100px; margin-bottom: 0;" data-format="{0,'c2'}">
			</td>	
		</tr>
</script>
<script id="billHistory" type="text/x-kendo-template">
	<table class="table" id="bills">
		<thead>
			<tr>
				<th width="100">កាលបរិច្ឆេទ</th>
				<th>ប្រភេទវិក្កយប័ត្រ</th>
				<th>ចំណាយជំពាក់</th>
				<th>ចំនួនត្រូវទូទាត់</th>
				<th>ចំនួនទូទាត់រួច</th>
				<th width="110">ទូទាត់</th>
			</tr>
		</thead>
		<tbody data-role="listview" data-bind="source: bills" data-template="billGrid"></tbody>
	</table>
</script>
<script id="transformerHistTmpl" type="text/x-kendo-template">
	<table class="table table-bordered table-vertical-center table-pricing table-pricing-2">
		<thead>
			<tr>
				<th class="center">កាលបរិច្ឆេទ</th>
				<th class="center">ត្រង់ស្វូ</th>
				<th class="center">លេខវិក្កយប័ត្រ</th>
				<th class="center">អំនានថ្មី</th>
				<th class="center">អំនានចាស់</th>
				<th class="center">មេគុណ</th>
				<th class="center">ថាមពុលសរុប</th>
				<th width="20"></th>
			</tr>
		</thead>
		<tbody data-role="listview" data-bind="source: transformerHist" 
								 data-template="transformerHistListTmpl" 
								 data-edit-template="editTransformerHistTmpl"></tbody>
	</table>
		
</script>
<script id="transformerHistListTmpl" type="text/x-kendo-template">
	<tr>
		<td>#=created_at#</td>
		<td>#=transformer.transformer_number#</td>
		<td>#=bill.invoice_number#</td>
		<td>#=new_reading#</td>
		<td>#=prev_reading#</td>
		<td>#=multiplier#</td>
		<td>#=(new_reading - prev_reading) * multiplier#</td>
		<td>
			<div class="edit-buttons">
                <a class="k-edit-button" href="\\#"><i class="icon-edit"></i></a>
                <a class="k-delete-button" href="\\#"><i class="icon-trash"></i></a>
            </div>
		</td>
	</tr>
</script>
<script id="editTransformerHistTmpl" type="text/x-kendo-template">
	<tr>
		<td>#=created_at#</td>
		<td>#=transformer.transformer_number#</td>
		<td>#=bill.invoice_number#</td>
		<td><input type="text" data-bind="value: new_reading"></td>
		<td><input type="text" data-bind="value: prev_reading"></td>
		<td>#=multiplier#</td>
		<td>#=(new_reading - prev_reading) * multiplier#</td>
		<td>
			<div class="edit-buttons">
                <a class="k-update-button" href="\\#"><i class="icon-check"></i></a>
                <a class="k-cancel-button" href="\\#"><i class="icon-remove"></i></a>
            </div>
		</td>
	</tr>
</script>

<!-- By Dawine -->
<!-- Purchase Order -->
<script id="purchaseOrderView" type="text/x-kendo-template">
	<div class="row-fluid">
		<div class="span12">
			<div class="pull-right">								
				<table cellpadding="2" cellspacing="2">
					<tr>				
						<td>លេខ P.O</td>
						<td><input class="k-textbox" data-bind="value: number" style="width:140px;" readonly /></td>
					</tr>			
					<tr>
						<td>កាលបរិច្ឆេទ</td>
						<td><input data-role="datepicker" data-bind="value: issued_date" data-format="dd-MM-yyyy" /></td>
					</tr>
					<tr>
						<td>ថ្ងៃរំពឹងទុក</td>
						<td><input data-role="datepicker" data-bind="value: expected_date" data-format="dd-MM-yyyy" /></td>
					</tr>			
					<tr>
		                <td valign="top">ការដឹកជញ្ជូនទៅកាន់</td>
		              	<td><textarea name="shipTo" id="shipTo" cols="" rows="2" data-bind="value: ship_to"></textarea></td>
		            <tr>		            
				</table>           		          	
		    </div>

			<div>
				<table cellpadding="2" cellspacing="2">            
					<tr>
		                <td>Class</td>
		              	<td><select data-role="combobox" data-text-field="name" data-value-field="id" data-bind="source: classList, value: class_id"></select></td>
		            <tr>            
					<tr>
						<td colspan="2">
							អាសយដ្ឋាន
							<br>
							<textarea name="address" id="address" cols="" rows="2" data-bind="value: address"></textarea>
						</td>
					</tr>
				</table>
			</div>
			
			<br><br>

			<div data-role="grid" data-bind="source: invoiceItemList"
		        data-auto-bind="false" data-row-template="invoiceRowTemplate"                  
		        data-columns='[{ title: "#", width: 35 }, 
		            { title: "ទំនិញ", width: 175 },	                     
		            { title: "ពណ៌នា", width: 300 },
		            { title: "ចំនួន", width: 95 },
		            { title: "តំលៃ", width: 115 },		            
		            { title: "ទឹកប្រាក់" }	                    	                    
		            ]'>
			</div>
			<button class="btn btn-inverse" data-bind="click: addNewRow"><i class="icon-plus icon-white"></i></button>
			
			<br>

			<div class="pull-right">												
				<div class="innerAll padding-bottom-none-phone">
					<a data-bind="click: btnCreatePO" class="widget-stats widget-stats-primary widget-stats-4">
						<span class="txt">សរុប</span>
						<span class="count" style="font-size: 35px;" data-bind="text: total"></span>
						<span class="glyphicons cart_in"><i></i></span>
						<div class="clearfix"></div>
						<i class="icon-play-circle"></i>
					</a>
				</div>										
			</div>

			<div>
				<table>
					<tr>
						<td>
							សំគាល់:
							<br>
							<textarea name="address" id="address" cols="" rows="2" data-bind="value: memo"></textarea>
						</td>
					</tr>			
				</table>
			</div>	
		</div>
	</div>	
</script>
<script id="invoiceRowTemplate" type="text/x-kendo-tmpl">		
	<tr>		
		<td class="sno">1</td>
		<td>
			<select data-role="combobox" data-text-field="name" data-value-field="id" 
					data-bind="source: itemList, value: item_id, events: {change : itemChange}">
			</select>
		</td>		
		<td>
			<input type="text" data-bind="value: description" style="margin-bottom: 0;" />
		</td>
		<td>
			<input data-role="numerictextbox" data-format="n0" data-bind="value: quantity, events: {change : change}"
				style="width: 80px" />
		</td>				
		<td>
			<input data-role="numerictextbox" data-format="c0" data-bind="value: unit_price, events: {change : change}" 
				style="width: 100px" />
		</td>		
		<td align="right">
			#:kendo.toString(quantity*unit_price, 'c0')#
			<i class="icon-trash" data-bind="events: { click: removeRow "></i>
		</td>		
    </tr>   
</script>

<script>
	//global variable
	var operationType; //this is either purchase or expense.
	var billId = 0;
	var billStatus = 0;
	//DataSource
	var transformerDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricities/transformers/",
				type: "GET",
				dataType: "json"
			},
			create: {
				url: ARNY.baseUrl + "api/electricities/transformers/",
				type: "POST",
				dataType: "json"
			},
			update: {
				url: ARNY.baseUrl + "api/electricities/transformers/",
				type: "PUT",
				dataType: "json"
			},
			destroy: {
				url: ARNY.baseUrl + "api/electricities/transformers/",
				type: "DELETE",
				dataType: "json"
			},
			parameterMap : function(options, operation) {
				if( operation !== "read" && options.models ) {
					return { models: kendo.stringigy(options.models) };
				}
				return options;
			}
		},
		schema: {
			model: {
				id: "id"
			}
		}
	});
	var transformerRecordDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricities/transformerRecords/",
				type: "GET",
				dataType: "json"
			},
			create: {
				url: ARNY.baseUrl + "api/electricities/transformerRecords/",
				type: "POST",
				dataType: "json"
			},
			update: {
				url: ARNY.baseUrl + "api/electricities/transformerRecords/",
				type: "PUT",
				dataType: "json"
			},
			destroy: {
				url: ARNY.baseUrl + "api/electricities/transformerRecords/",
				type: "DELETE",
				dataType: "json"
			},
			parameterMap : function(options, operation) {
				if( operation !== "read" && options.models ) {
					return { models: kendo.stringigy(options.models) };
				}
				return options;
			}
		},
		serverFiltering: true,
		schema: {
			model: {
				id: "id"
			}
		}
	});
	var vendorDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/vendors/",
				type: "GET",
				dataType: "json"
			},
			parameterMap : function(options, operation) {
				if( operation !== "read" && options.models ) {
					return { models: kendo.stringigy(options.models) };
				}
				return options;
			}
		},
		serverFiltering: false,
		schema: {
			model: {
				id: "id"
			},
			data: "vendors",
			total: "count"
		}
	});
	var itemDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/inventory_api/item",
				type: "GET",
				dataType: "json"
			}
		}
	});	
	var itemRecordDS = new kendo.data.DataSource({
        transport: {
	        create: {
		        url : ARNY.baseUrl + "api/inventory_api/item_record",
		        type: "POST",
		        dataType: "json"
	        },
	        parameterMap: function(options, operation) {
	    		if (operation !== "read" && options.models) {
	    			  	 return {models: kendo.stringify(options.models)};
	  			}
			
					return options;				   
	  		}
		},
		batch: false,	                            
	 	schema: {
			model: {
				id : "id"
			}		 
		}   
	});
	var cashAccountDS = new kendo.data.DataSource({
	    transport: {
		    read: ARNY.baseUrl + "api/accounting_api/cash_account",
		    type: "GET",
		    dataType: "json"
	    }
    });

    var accountDS = new kendo.data.DataSource({
	    transport: {
		    read: ARNY.baseUrl + "api/accounting_api/account",
		    type: "GET",
		    dataType: "json"
	    }
    });

    var expenseAccountDS = new kendo.data.DataSource({
	    transport: {
		    read: ARNY.baseUrl + "api/accounting_api/expense_account",
		    type: "GET",
		    dataType: "json"
	    }
    });

    $.getJSON(ARNY.baseUrl + "api/accounting_api/class_dropdown", function(data) {
	 	$.each(data, function(key, val) {
	    	eBillModel.classes.push({id: val.id, name: val.name});
	    	purchaseModel.classes.push({id: val.id, name: val.name});
	    	expenseModel.classes.push({id: val.id, name: val.name});
	    	billModel.classes.push({id: val.id, name: val.name});
		});	
	});

	$.getJSON(ARNY.baseUrl + "api/electricities/transformers/", function(data) {
	 	$.each(data, function(key, val) {
	    	eBillModel.transformerDS.push({	id: val.id, 
	    									transformerNumber: val.transformerNumber, 
	    									lastReading: val.lastInvoice.new_reading=== ""? 0:val.lastInvoice.new_reading, 
	    									lastTariff: val.lastInvoice.tariff
	    								});
		});	
	});

	$.getJSON(ARNY.baseUrl + "api/inventory_api/item", function(data) {
	 	$.each(data, function(key, val) {
	    	purchaseModel.items.push({	id: val.id, 
	    									name: val.item_sku +' '+ val.name,
	    									cogs_account: val.cogs_account.id, 
	    									income_account: val.income_account.id, 
	    									general_account: val.general_account.id,
	    									purchase_description: val.purchase_description,
	    									cost: val.cost
	    								});
		});	
	});

	$.getJSON(ARNY.baseUrl + "api/accounting_api/expense_account", function(data) {
	 	$.each(data, function(key, val) {
	    	expenseModel.expenseAccts.push({	account_type_id 	: val.account_type_id, 
	    								id 					: val.id,
    									code 				: val.code,
    									name 				: val.name,
    									description 		: val.description
	    								});
		});	
	});

    var cogsDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/accounting_api/cogs_account/",
				type: "GET",
				dataType: "json"
			},
			parameterMap : function(options, operation) {
				if( operation !== "read" && options.models ) {
					return { models: kendo.stringigy(options.models) };
				}
				return options;
			}
		},
		schema: {
			model: {
				id: "id"
			}
		}
	});
    var creditAccountDS = new kendo.data.DataSource({
			transport: {
				read: ARNY.baseUrl + "api/accounting_api/liability_account",
				type: "GET",
				dataType: "json"
			}
	    });
    var expenseAccountDS = new kendo.data.DataSource({
			transport: {
				read: ARNY.baseUrl + "api/accounting_api/expense_account",
				type: "GET",
				dataType: "json"
			}
	    });
	var PaymentTermDS = new kendo.data.DataSource({
        transport: {
	        read: ARNY.baseUrl + "api/accounting_api/payment_term",
	        type: "GET",
	        dataType: "json"
        }
    });
	var bills = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricities/bills/",
				type: "GET",
				dataType: "json"
			},
			create: {
				url: ARNY.baseUrl + "api/electricities/bills/",
				type: "POST",
				dataType: "json"
			},
			update: {
				url: ARNY.baseUrl + "api/electricities/bills/",
				type: "PUT",
				dataType: "json"
			},
			destroy: {
				url: ARNY.baseUrl + "api/electricities/bills/",
				type: "DELETE",
				dataType: "json"
			},
			parameterMap : function(options, operation) {
				if( operation !== "read" && options.models ) {
					return { models: kendo.stringigy(options.models) };
				}
				if( operation === "read" ) {
					return { vendor_id: vendorModel.vendor.id };
				}
				return options;
			}
		},
		//serverFiltering: true,
		schema: {
			model: {
				id: "id"
			}
		},
		requestEnd: function(e) {
			var type = e.type;
			
			if(type==="create") {
				if(e.response.type === "expense") {
					expenseModel.sync(e.response.bill.id);
				} else if(e.response.type === "purchase") {
					purchaseModel.sync(e.response.bill.id);
				} else if (e.response.type === "ebill") {
					eBillModel.sync(e.response.bill.id);
					//console.log(e.response.type);
				}	
			}
		},
		error	: function(e) {
			console.log(e.status);
		}
	});

	var journalDS = new kendo.data.DataSource({
		transport: {
			create: {
				url: ARNY.baseUrl + "api/accounting_api/journals/",
				type: "POST",
				dataType: "json"
			},
			parameterMap : function(options, operation) {
				if( operation !== "read" && options.models ) {
					return { models: kendo.stringigy(options.models) };
				}
				return options;
			}
		},
		schema: {
			model: {
				id: "id"
			}
		}
	});
	var billPayments = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricities/bill_payments/",
				type: "GET",
				dataType: "json"
			},
			create: {
				url: ARNY.baseUrl + "api/electricities/bill_payments/",
				type: "POST",
				dataType: "json"
			},
			update: {
				url: ARNY.baseUrl + "api/electricities/bill_payments/",
				type: "PUT",
				dataType: "json"
			},
			destroy: {
				url: ARNY.baseUrl + "api/electricities/bill_payments/",
				type: "DELETE",
				dataType: "json"
			},
			parameterMap : function(options, operation) {
				if( operation !== "read" && options.models ) {
					return { models: kendo.stringigy(options.models) };
				}
				return options;
			}
		},
		schema: {
			model: {
				id: "id"
			}
		},
		requestEnd: function(e){
			if(e.type === "create") {
				if(billModel.payments.length > 0) {
					billModel.payments.splice(0, billModel.payments.length);
				}
				billModel.bills.read();
				router.navigate("/");
			}
		}
		//serverFiltering: true,
	});

	var invoiceDS = new kendo.data.DataSource({
	  	transport: {
		  	read: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
			  	type: "GET",
			  	dataType: "json"
		  	},
		  	create: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
			  	type: "POST",
			  	dataType: "json"
		  	},
	        parameterMap: function(options, operation) {
	            if (operation !== "read" && options.models) {
	                return {models: kendo.stringify(options.models)};
	            }
	            return options;
	        }
	  	},    
	  	schema: {
		  	model: {
			  	id : "id"
		  	}		
	  	},	  	
	  	serverFiltering : true	  	
	});

	var classDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/accounting_api/class_dropdown",
				type: "GET",
				dataType: "json"
			}
		}		
	});

	var poDS = new kendo.data.DataSource({
	  	transport: {
		  	read: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
			  	type: "GET",
			  	dataType: "json"
		  	},
		  	update: {
			  	url : ARNY.baseUrl + "api/invoices/invoice",		  
			  	type: "PUT",
			  	dataType: "json"
		  	}
	  	},
	  	schema: {
		  	model: {
			  	id : "id"
		  	}		
	  	},	  		  		  	
	  	serverFiltering : true	  	
	});


	var vendorModel	= kendo.observable({
		vendorList 	: vendorDS,
		setVendor 		: function(vendorID) {
			this.set("vendor", vendorDS.get(vendorID));
		},
		showBtn 		: false,
		map 			: function() {
			var uri = "#/" + this.get("vendor").id + "/map/" + this.get("vendor").latitute + "/" +this.get("vendor").longtitute;
			router.navigate(uri);
		},
		viewBill 		: function() {
			var uri = "#/" + this.get("vendor").id + "/viewBills";
			router.navigate(uri);
		},
		eBill 		: function(e) {
			var uri = "#/" + this.get("vendor").id + "/eBill";
			router.navigate(uri);
		},
		purchase 		: function(e) {
			var uri = "#/" + this.get("vendor").id + "/purchase";
			router.navigate(uri);
		},
		po 		: function(e) {
			var uri = "#/" + this.get("vendor").id + "/purchaseOrder";
			router.navigate(uri);
		},
		payBill 		: function() {
			var uri = "#/" + this.get("vendor").id + "/paybill";
			if(this.get("vendor").bills.length > 0) {
				router.navigate(uri);
			}
			
		},		
		billHistory		: function() {
			var uri = "#/" + this.get("vendor").id + "/billHistory";
			//if(this.get("vendor").bills.length > 0) {
				router.navigate(uri);
			//}
			
		},
		expense 		: function() {
			var uri = "#/" + this.get("vendor").id + "/expense";
			router.navigate(uri);
		},
		transfomerRec	: function() {
			var uri = "#/" + this.get("vendor").id + "/transfomerRec";
			router.navigate(uri);
		},
		change 			: function(e) {
			var uid = $(e.currentTarget).closest("tr").data('id');
			//var billModel = this.vendor.bills.get(uid);
			console.log(uid);
		}
	});

	var eBillModel = kendo.observable({
		paymentTerms 	: PaymentTermDS,
		transformerDS 	: [],
		transformerHist : transformerRecordDS,
		classes 		: [],
		transformers 	: [{
			bill_id: null, transformer_id: null, new_reading: 0, prev_reading: 0, multiplier: 1, tariff: 0, vendor_id: null
		}],
		paymentTerm 	: "",
		invoiceNumber 	: "",
		ref 			: "",
		billFrom 		: "",
		billTo 			: "",
		class_id 		: "",
		date 			: new Date(),
		remove 			: function(e) {
			 for (var i = 0; i < this.transformers.length; i ++) {
	            var current = this.transformers[i];
	            if (current === e.data) {
	                this.transformers.splice(i, 1);
	                break;
	            }
	        }
		},
		dateDue 	: function() {
			var date;
			if(this.get("paymentTerm") !== "") {
				
				var net = parseInt(PaymentTermDS.get(this.get("paymentTerm")).net_due_in);
				var due_date = new Date(this.get("date"));
				due_date.setDate(due_date.getDate() + net);
				date = new Date(due_date);
			} else {
				date = new Date();
			}
			return date;
		},
		close 			: function(e) {
			e.preventDefault();
			layout.showIn("#info", vendor);
			var uri = "/"+vendorModel.vendor.id;
			router.navigate(uri, false);
		},
		tempValue 		: "",
		change 			: function(e) {
			// for (var i = 0; i < this.transformers.length; i ++) {
	  //           var current = this.transformers[i];
	  //           if (current === e.data) {
	  //           	//loop through tranformerDS to find the last reading
	  //           	for(var i=0; i<this.get("transformerDS").length; i++) {
	  //           		if(this.get("transformerDS")[i].id === e.data.transformer_id) {
	  //           			//if(this.get("transformerDS")[i].lastReading === "undefined") {
	  //           				//current.set("preve_reading", 1);
	            				
	  //           			//} else {
	  //           				current.set("prev_reading", this.get("transformerDS")[i].lastReading);
	  //           				current.set("tariff", this.get("transformerDS")[i].lastTariff);
	  //           			//}
	  //           			break;
	  //           		}
	  //           	}
	  //               break;
	  //           }
	  //       }
	  		console.log("e");
		},
		addNew 		: function() {
			this.transformers.push({bill_id: 0, transformer_id: '', new_reading: 0, prev_reading: 0, multiplier: 1, tariff: 0, vendor_id: vendorModel.get("vendor").id});
		},
		record 			: function(e) {
			var amount_due = 0;
			var amount_s =0;
			var validator = $(e.currentTarget).parent();
			var validated = validator.kendoValidator().data("kendoValidator");
			if(validated.validate()){
				if(this.get("transformers").length > 0) {

					bills.add({
						type: "ebill",
						vendor_id: vendorModel.get("vendor").id,
						employee_id: <?php echo $this->session->userdata('user_id'); ?>,
						bill_type: "ជំពាក់អគ្គីសនី",
						date: kendo.toString(this.get("date"), "yyyy-MM-dd"),
						due_date: kendo.toString(this.dateDue, "yyyy-MM-dd"),
						amount_due: 0,
						amount_paid: 0,
						voucher: this.get("ref"),
						invoiceNumber: this.get("invoiceNumber"),
						class_id: this.get("class_id"),
						amount_billed: this.total(),
						status: 0
					});

					bills.sync();			
				} else {
					alert("សូមបញ្ចូលទិន្ន័យសំរាប់តរ្ង់ស្វូ");
				}
				
			} else {

			}
		},
		total 			: function(e) {
			var total = 0;
			if( this.get("transformers").length > 0) {
				for(var i=0; i < this.get("transformers").length; i++) {
					var usage = this.get("transformers")[i].new_reading - this.get("transformers")[i].prev_reading;
					var actual= usage * this.get("transformers")[i].multiplier;
					var t = actual * this.get("transformers")[i].tariff;
					total += t;
				}
			}
			this.set("cTotal", kendo.toString(total, "c2"));
			return parseFloat(total);


			//to add the reading to each tranformer
		},
		cTotal 			: function(e) {
			var total = 0;
			if( this.get("transformers").length > 0) {
				for(var i=0; i < this.get("transformers").length; i++) {
					var usage = this.get("transformers")[i].new_reading - this.get("transformers")[i].prev_reading;
					var actual= usage * this.get("transformers")[i].multiplier;
					var t = actual * this.get("transformers")[i].tariff;
					total += t;
				}
			}
			return kendo.toString(parseFloat(total), "c2");


			//to add the reading to each tranformer
		},
		sync 			: function(billId) {
			//2. get the bill id and save to item_records table
			for(var i = 0; i < this.get("transformers").length; i++) {
				this.transformers[i].set("bill_id", billId);
			}
			var journalEntries = [];
			
				
			journalEntries.push(
			 	{
			 		account_id: 30, 
			 		bill_id: billId,
			 		dr: 0, 
			 		cr: this.total(),
			 		class_id: 0, 
			 		memo: "ប្រត្តិបត្រ័ការទិញអគ្គសនីពី " + kendo.toString(this.get("billFrom"), 'yyyy-MM-dd') + " ដល់ " + kendo.toString(this.get("billTo"), 'yyyy-MM-dd')
		 		});
			
			journalEntries.push({
		 		account_id: 52,
		 		bill_id: billId, 
		 		dr: this.total(), 
		 		cr: 0, 
		 		class_id: 0,
		 		memo: "ប្រត្តិបត្រ័ការទិញអគ្គសនីពី " + kendo.toString(this.get("billFrom"), 'yyyy-MM-dd') + " ដល់ " + kendo.toString(this.get("billTo"), 'yyyy-MM-dd')
			});
			

			if(journalEntries.length > 0) {
				journalDS.add({
			 		bill_id: billId,
			 		journalEntries : journalEntries,
			 		memo: "ប្រត្តិបត្រ័ការទិញអគ្គសនីពី " + kendo.toString(this.get("billFrom"), 'yyyy-MM-dd') + " ដល់ " + kendo.toString(this.get("billTo"), 'yyyy-MM-dd'), 
			 		voucher: this.get("ref"),
			 		class_id: this.get("class_id"),
			 		budget_id: 0,
			 		donor_id: 0,
			 		check_no: "",
			 		people_id: vendorModel.get("vendor").id,
			 		employee_id: <?php echo $this->session->userdata('user_id'); ?>,
			 		invoice_id: this.get("invoiceNumber"),
			 		payment_id: 0,
			 		bill_id: billId,	
			 		date: kendo.toString(this.get("date"), "yyyy-MM-dd"), 
			 		transaction_type: "ជំពាក់អគ្គីសនី",
			 		people_id: vendorModel.get("vendor").id,
			 	}); 	
			}			
			transformerRecordDS.add(this.get("transformers"));
			transformerRecordDS.sync();
			journalDS.sync();
			journalEntries.splice(0, journalEntries.length);
			//this.empty();
			if(this.get("transformers").length > 0) {
				
				for(var i = 0; i < journalDS.data().length; i++) {
					journalDS.remove(journalDS.at(i))
				}
				bills.remove(bills.at(0));
				this.get("transformers").splice(0, this.get("transformers").length);
			}
			this.set("billTo", "");
				this.set("billFrom", "");
				this.set("invoiceNumber", "");
				this.set("ref", "");
		}
	});

	var purchaseModel = kendo.observable({
		items 		: [],
		cashAccts	: cashAccountDS,
		creditAccts : creditAccountDS,
		paymentTerms : PaymentTermDS,
		classes 		: [],
		class_id 		: "",
		paymentMethod: [
			{ id: 1, method: "Cash"},
			{ id: 2, method: "Check"},
			{ id: 3, method: "Credit Card"}
		],
		close 		: function(e) {
			e.preventDefault();
			layout.showIn("#info", vendor);
			var uri = "/"+vendorModel.vendor.id;
			router.navigate(uri, false);
		},
		pmtMethod 	: "",
		cashAcct 	: "",
		creditAcct 	: "",
		checkNo 	: "",
		paymentTerm : "",		
		vendor  	: "",
		billed 		: false,
		cart 		: [{
			bill_id: 0, item_id: "", description: "", quantity: 0, cost: 0, price: 0, amount: 0, account_id: 0
		}],
		paidCash   	: true,
		checkoutBtn	: false,
		date 		: new Date(),
		invoiceNumber : "",
		ref 	 	: "",
		memo 		: "",
		po_id 		: "",			
		poList 		: poDS,

		loadPO 		: function(id){
			poDS.filter({
				filters: [
					{ field: "vendor_id", value: id },
					{ field: "status", value: 0 },
					{ field: "type", value: "PO" }
				]
			});
		},
		poChange	: function(e){
			var d = e.sender;
			var id = kendo.parseInt(d._selectedValue);
			this.set("cart", []);			
			if(id>0 || id!=null){
			 	var po = poDS.get(id);			
			 	var items = po.invoice_items;

			 	for (var i=0;i<items.length;i++) {
			 		var it = items[i];
			 		var acct_id = 0;
			 		for(var j=0; j<this.get("items").length; j++) {
	            		if(this.get("items")[j].id === it.item_id) {	            				
	            				acct_id = this.get("items")[j].general_account;
	            			break;
	            		}
	            	}

			 		this.cart.push({						
						'item_id' 		: it.item_id,
						'description' 	: it.description,				
						'quantity' 		: it.quantity,
						'cost'			: it.unit_price,
						'price' 		: it.unit_price,						
						'amount' 		: it.amount,
						'account_id'	: acct_id			
					});
								
			 	}			 	
			 	this.set("po_number", d._prev);	 				
			}			
		},

		due_date 	: function() {
			var date;
			if(this.get("paymentTerm") !== "") {	
				var net = parseInt(PaymentTermDS.get(this.get("paymentTerm")).net_due_in);
				var due_date = new Date(this.get("date"));
				due_date.setDate(due_date.getDate() + net);
				date = new Date(due_date);
			} else {
				date = new Date();
			}
			return date;
		},
		dateDue 	: function() {
			var date;
			if(this.get("paymentTerm") !== "") {
				
				var net = parseInt(PaymentTermDS.get(this.get("paymentTerm")).net_due_in);
				var due_date = new Date(this.get("date"));
				due_date.setDate(due_date.getDate() + net);
				date = new Date(due_date);
			} else {
				date = new Date();
			}
			return date;
		},
		cashBtn 	: function() {
			if(this.get("paidCash")) {
				this.set("paidCash", false);
			} else {
				this.set("paidCash", true);
			}
		},
		cleared: false,
		addToCart 	: function(e) {
			this.cart.push({bill_id: 0, item_id: "", description: "", quantity: 0, cost: 0, price: 0, amount: 0, account_id: 0});
		},
		subtotal : function(e) {
			var cost = e.cost * e.quantity;	
	        return cost;
		},
		cTotal  : 0,
		total 	: function() {
			var total=0;
			var cart = this.get("cart");
			if(cart.length > 0) {
				for(var i = 0; i < cart.length; i++) {
					cart[i].set("amount", (cart[i].get("cost") * cart[i].get("quantity")));
					total += parseFloat(cart[i].get("cost") * cart[i].get("quantity"));
				}	
			}
			this.set("cTotal", kendo.toString(parseFloat(total), 'c2'));
			return total;
		},
		cartCount 	: function() {
			return this.get("cart").length;
		},
		remove		: function(e) {
	        for (var i = 0; i < this.cart.length; i ++) {
	            var current = this.cart[i];
	            if (current === e.data) {
	                this.cart.splice(i, 1);
	                break;
	            }
	        }
	    },
		empty: function() {
	        var contents = this.get("cart");
	        contents.splice(0, contents.length);
	        this.set("checkoutBtn", false);
	    },
	    clear: function() {
	        var contents = this.get("contents");
	        contents.splice(0, contents.length);
	        this.set("cleared", true);
	        this.set("checkoutBtn", true);
	    },
		checkout 		: function() {
			var uri = "/vendor/" + vendorModel.get("vendor").id + "/checkout";
			router.navigate(uri);
		},
		change 			: function(e) {
			for (var i = 0; i < this.cart.length; i ++) {
	            var current = this.cart[i];
	            if (current === e.data) {
	            	//loop through items to find the last reading
	            	for(var i=0; i<this.get("items").length; i++) {
	            		if(this.get("items")[i].id === e.data.item_id) {	            			
	            				current.set("description", this.get("items")[i].purchase_description);
	            				current.set("cost", this.get("items")[i].cost);
	            				current.set("account_id", this.get("items")[i].general_account);
	            			break;
	            		}
	            	}
	                break;
	            }
	        }
		},
		record 			: function(e) {
			var billType;
			var validator;
			var journalEntries = [];
			if(this.get("paidCash")) {
				validator = $(e.currentTarget).parent().find("#cashPayment");
			} else {
				validator = $(e.currentTarget).parent().find("#creditPayment");
			}
			
			var validated = validator.kendoValidator().data("kendoValidator");

			if( validated.validate() ) {
				if(this.cartCount() > 0) {
					if(this.get("paidCash")) {
						//3. save to journal
						journalEntries.push({
						 		account_id: this.get("cashAcct"), 
						 		dr: 0, 
						 		cr: this.total(),
						 		class_id: this.get("class_id"),
						 		memo: this.get('memo')
					 	});
						for(var i=0; i < this.cart.length; i++) {
							journalEntries.push({
						 		account_id: this.cart[i].account_id,
						 		bill_id: 0,
						 		dr: this.cart[i].amount, 
						 		cr: 0,
						 		class_id: this.get("class_id"), 
						 		memo: this.cart[i].description
							});
						} //for loop

						if(journalEntries.length > 0) {
							journalDS.add({
						 		bill_id: 0,
						 		journalEntries : journalEntries,
						 		memo: this.get('memo'), 
						 		voucher: this.get('ref'),
						 		class_id: this.get("class_id"),
						 		budget_id: 0,
						 		donor_id: 0,
						 		check_no: this.get('checkNo'),
						 		people_id: vendorModel.get("vendor").id,
						 		employee_id: <?php echo $this->session->userdata('user_id'); ?>,
						 		invoice_id: 0,
						 		payment_id: 0,	
						 		date: kendo.toString(this.get("date"), "yyyy-MM-dd"), 
						 		transaction_type: "ទិញជាសាច់ប្រាក់",
						 		people_id: vendorModel.get("vendor").id,
						 	});
						 	journalEntries.splice(0, journalEntries.length);
						}
						journalDS.sync();

						//By Dawine
						var items = this.get("cart");
						itemRecordDS.add(items);
						itemRecordDS.sync();

						//empty to prepare datasource for new insertion
						if(this.cart.length > 0) {		
							for(var i = 0; i < this.cart.length; i++) {
								itemRecordDS.remove(itemRecordDS.at(i))
							}
							for(var i = 0; i < journalDS.data().length; i++) {
								journalDS.remove(journalDS.at(i));
							}
							this.cart.splice(0, this.cart.length);
							bills.remove(bills.at(0));
							this.set("creditAcct", "");
							this.set("paymentTerm", "");
							this.set("pmtMethod", "");
							
						}
					} else {																
						bills.add({
							type: "purchase",
							vendor_id: vendorModel.get("vendor").id,
							employee_id: <?php echo $this->session->userdata('user_id'); ?>,
							payment_id: this.get("paymentTerm"),
							bill_type: "ទិញជំពាក់",
							date: kendo.toString(this.get("date"), "yyyy-MM-dd"),
							due_date: kendo.toString(new Date(this.dateDue()), "yyyy-MM-dd"),
							amount_due: 0,
							amount_paid: 0,
							voucher: this.get("ref"),
							invoiceNumber: this.get("invoiceNumber"),
							class_id: this.get("class_id"),
							amount_billed: parseFloat(this.total()),
							status: 0,
							po_id: this.get("po_id")							
						});
						this.updatePO();
						bills.sync();	
					}			
				} else {
					alert("cart empty");
				}
			} else {
				alert("oops!");
			}
			

		},
		sync 			: function(billId) {
			//2. get the bill id and save to item_records table
			for(var i = 0; i < this.cartCount(); i++) {
				this.cart[i].set("bill_id", billId);
			}
			itemRecordDS.add(this.cart);
			itemRecordDS.sync();
			var journalEntries = [];
			if(this.get("paidCash")) {
				
			} else {
				journalEntries.push({
			 		account_id: this.get("creditAcct"),
			 		bill_id: billId, 
			 		dr: 0, 
			 		cr: this.total(),
			 		class_id: this.get("class_id"), 
			 		memo: this.get('memo'), 
			 	});
				for(var i=0; i < this.cart.length; i++) {
					journalEntries.push({
				 		account_id: this.cart[i].account_id,
				 		bill_id: billId,
				 		dr: this.cart[i].amount, 
				 		cr: 0, 
				 		class_id: this.get("class_id"),
				 		memo: this.cart[i].description, 
					});
				} //for loop

				if(journalEntries.length > 0) {
					journalDS.add({
				 		bill_id: billId,
				 		journalEntries : journalEntries,
				 		memo: this.get('memo'), 
				 		voucher: this.get('ref'),
				 		class_id: this.get("class_id"),
				 		budget_id: 0,
				 		donor_id: 0,
				 		check_no: this.get('checkNo'),
				 		people_id: vendorModel.get("vendor").id,
				 		employee_id: <?php echo $this->session->userdata('user_id'); ?>,
				 		invoice_id: 0,
				 		payment_id: 0,	
				 		date: kendo.toString(this.get("date"), "yyyy-MM-dd"), 
				 		transaction_type: "ទិញជំពាក់",
				 		people_id: vendorModel.get("vendor").id,
				 	});

				 	journalEntries.splice(0, journalEntries.length);
				}					
			}
			journalDS.sync();
			//empty to prepare datasource for new insertion
			if(this.cart.length > 0) {		
				for(var i = 0; i < this.cart.length; i++) {
					itemRecordDS.remove(itemRecordDS.at(i))
				}
				for(var i = 0; i < journalDS.data().length; i++) {
					journalDS.remove(journalDS.at(i));
				}
				this.cart.splice(0, this.cart.length);
				bills.remove(bills.at(0));
				this.set("creditAcct", "");
				this.set("paymentTerm", "");
				this.set("pmtMethod", "");
				
			}

		},
		updatePO			: function(){
			var id = this.get("po_id");					
			if(id>0 && id!=""){
				var d = poDS.get(id);				
				d.set("status", 1);
				poDS.sync();
			}								
		}
		
	});

	var expenseModel = kendo.observable({
		cashAccts	: cashAccountDS,
		expenseAccts: [],
		creditAccts : creditAccountDS,
		accounts 	: accountDS,
		paymentTerms : PaymentTermDS,
		classes 	: [],
		class_id 	: "",
		invoiceNumber: "",
		paymentMethod: [
			{ id: 1, method: "Cash"},
			{ id: 2, method: "Check"},
			{ id: 3, method: "Credit Card"}
		],
		close 		: function(e) {
			e.preventDefault();
			layout.showIn("#info", vendor);
			var uri = "/"+vendorModel.vendor.id;
			router.navigate(uri, false);		},
		pmtMethod 	: "",
		cashAcct 	: "",
		ExpAcct 	: "",
		creditAcct 	: "",
		checkNo 	: "",
		paymentTerm : "",		
		vendor  	: "",
		billed 		: false,
		bucket 		: [
			{bill_id: 0, account_id: "", code: 0, account_name: 0, amount: 0, memo: "", class_id: ""}
		],
		paidCash   	: true,
		checkoutBtn	: false,
		date 		: new Date(),
		ref 		: "",
		memo 		: "",
		dateDue 	: function() {
			var date;
			if(this.get("paymentTerm") !== "") {
				
				var net = parseInt(PaymentTermDS.get(this.get("paymentTerm")).net_due_in);
				var due_date = new Date(this.get("date"));
				due_date.setDate(due_date.getDate() + net);
				date = new Date(due_date);
			} else {
				date = new Date();
			}
			return date;
		},
		cashBtn 	: function() {
			if(this.get("paidCash")) {
				this.set("paidCash", false);
			} else {
				this.set("paidCash", true);
			}
		},
		cleared: false,
		addToCart 	: function(e) {
			this.bucket.push(
				{bill_id: 0, account_id: "", code: 0, account_name: 0, amount: 0, memo: "", class_id: ""}
			);
		},
		change 	: function(e) {
			for (var i = 0; i < this.bucket.length; i ++) {
	            var current = this.bucket[i];
	            if (current === e.data) {
	            	//loop through items to find the last reading
	            	for(var i=0; i<this.get("expenseAccts").length; i++) {
	            		if(this.get("expenseAccts")[i].id === e.data.account_id) {	            			
	            				current.set("memo", this.get("expenseAccts")[i].description);
	            			break;
	            		}
	            	}
	                break;
	            }
	        }
		},
		total 	: function() {
			var total=0;
			var bucket = this.get("bucket");
			if(bucket.length > 0) {
				for(var i = 0; i < bucket.length; i++) {
					total += parseFloat(bucket[i].get("amount"));
				}	
			}
			
			return total;
		},
		cartCount 	: function() {
			return this.get("bucket").length;
		},
		remove		: function(e) {
			for (var i = 0; i < this.bucket.length; i ++) {
	            var current = this.bucket[i];
	            if (current === e.data) {
	                this.bucket.splice(i, 1);
	                break;
	            }
	        }	        
	    },
		empty: function() {
	        var contents = this.get("bucket");
	        contents.splice(0, contents.length);
	        this.set("checkoutBtn", false);
	    },
	    clear: function() {
	        var contents = this.get("bucket");
	        contents.splice(0, contents.length);
	        this.set("cleared", true);
	        this.set("checkoutBtn", true);
	    },
		record 			: function() {
			var amount_due = 0;
			var amount_s =0;
			var journalEntries = [];
			if(this.cartCount() > 0) {
				if(this.get("paidCash")) {
					//3. save to journal
				
					journalEntries.push(
					 	{
					 		account_id: this.get("cashAcct"), 
					 		bill_id: 0,
					 		dr: 0, 
					 		cr: this.total(),
					 		class_id: this.get("class_id"), 
				 			memo: this.get('memo'),  
				 		});
					for(var i = 0; i<this.cartCount(); i++) {
						journalEntries.push({
					 		account_id: this.bucket[i].account_id,
					 		bill_id: 0, 
					 		dr: this.bucket[i].amount, 
					 		cr: 0, 
					 		class_id: this.get("class_id"),
					 		memo: this.bucket[i].memo, 
						});
					}

					if(journalEntries.length > 0) {
						journalDS.add({
					 		bill_id: 0,
					 		journalEntries : journalEntries,
					 		memo: this.get('memo'), 
					 		voucher: this.get('ref'),
					 		class_id: this.get("class_id"),
					 		budget_id: 0,
					 		donor_id: 0,
					 		check_no: this.get('checkNo'),
					 		people_id: vendorModel.get("vendor").id,
					 		employee_id: <?php echo $this->session->userdata('user_id'); ?>,
					 		invoice_id: 0,
					 		payment_id: 0,	
					 		date: kendo.toString(this.get("date"), "yyyy-MM-dd"), 
					 		transaction_type: "ចំណាយជាសាច់ប្រាក់",
					 		people_id: vendorModel.get("vendor").id,
					 	});
					 	journalEntries.splice(0, journalEntries.length);
					}
					journalDS.sync();
					this.empty();
					this.set("account_id", "");
					this.set("pmtMethod", "");
					this.set("class_id", "");
					this.set("checkNo", "");
					this.set("ref", "");
					this.set("memo", "");
					if(this.bucket.length > 0) {
						
						for(var i = 0; i < journalDS.data().length; i++) {
							journalDS.remove(journalDS.at(i))
						}
						bills.remove(bills.at(0));
						this.bucket.splice(0, this.bucket.length);
					}
				} else {
					console.log(this.dateDue());
					bills.add({
						type: "expense",
						vendor_id: vendorModel.get("vendor").id,
						employee_id: <?php echo $this->session->userdata('user_id'); ?>,
						bill_type: "ចំណាយជំពាក់",
						date: kendo.toString(this.get("date"), "yyyy-MM-dd"),
						due_date: kendo.toString(this.dateDue, "yyyy-MM-dd"),
						amount_due: 0,
						amount_paid: 0,
						invoice_number: this.get("invoiceNumber"),
						class_id: this.get("class_id"),
						voucher: this.get("ref"),
						amount_billed: parseFloat(this.total()),
						status: 0
					});
				}
				bills.sync();			
			} else {
				alert("cart empty");
			}
		},
		sync 			: function(billId) {
			//2. get the bill id and save to item_records table
			for(var i = 0; i < this.cartCount(); i++) {
				this.bucket[i].set("bill_id", billId);
			}
			var journalEntries = [];
			if(this.get("paidCash")) {
				
			} else {
				journalEntries.push(
				 	{
				 		account_id: this.get("creditAcct"),
				 		bill_id: billId, 
				 		payment_id: this.get("paymentTerm"),
				 		dr: 0, 
				 		cr: this.total(), 
				 		memo: this.get('memo'), 
				 		class_id: this.get("class_id")
			 		});
				for(var i = 0; i<this.cartCount(); i++) {
					journalEntries.push({
				 		account_id: this.bucket[i].account_id,
				 		bill_id: billId, 
				 		dr: this.bucket[i].amount, 
				 		cr: 0, 
				 		memo: this.bucket[i].memo,
				 		class_id: this.bucket[i].class_id
					});
				}

				if(journalEntries.length > 0) {
					journalDS.add({
				 		bill_id: billId,
				 		journalEntries : journalEntries,
				 		memo: this.get('memo'), 
				 		voucher: this.get('ref'),
				 		class_id: this.get("class_id"),
				 		budget_id: 0,
				 		donor_id: 0,
				 		check_no: this.get('checkNo'),
				 		people_id: vendorModel.get("vendor").id,
				 		employee_id: <?php echo $this->session->userdata('user_id'); ?>,
				 		invoice_id: 0,
				 		payment_id: 0,	
				 		date: kendo.toString(this.get("date"), "yyyy-MM-dd"), 
				 		transaction_type: "ចំណាយជំពាក់",
				 		people_id: vendorModel.get("vendor").id,
				 	});
				 	journalEntries.splice(0, journalEntries.length);
				}
				
			}
			journalDS.sync();
			this.empty();
			if(this.bucket.length > 0) {
				
				for(var i = 0; i < journalDS.data().length; i++) {
					journalDS.remove(journalDS.at(i))
				}
				bills.remove(bills.at(0));
				this.bucket.splice(0, this.bucket.length);
			}
		}
	});

	var billModel = kendo.observable({
		bills 			: bills,
		payments 		: [],
		cashAccounts 	: cashAccountDS,
		cashAccount 	: "",
		classes 		: [],
		class_id 		: "",
		paymentMethod 	: [
			{ id: 1, method: "Cash"},
			{ id: 2, method: "Check"},
			{ id: 3, method: "Credit Card"}
		],
		close 		: function(e) {
			e.preventDefault();
			layout.showIn("#info", vendor);
			var uri = "/"+vendorModel.vendor.id;
			router.navigate(uri, false);
		},
		pmtMethod 		: "",
		pmtMethods 		: "cash",
		date 			: new Date(),
		payment_note	: "",
		payBtn 			: false,
		checkNo 		: "",
		ref 			: "from pay bill page.",
		tick 			: function(e) {
			//console.log($(e.currentTarget).is(":checked"));
			//console.log(e.data);
			var current = $(e.currentTarget);
			var data 	= e.data;
			var found 	= false;
			if(current.is(":checked") === true) {
				if(this.payments.length > 0) {
					for(var i=0; i < this.payments.length; i++) {
						if(data.id === this.payments[i].bill_id) {
							current.closest("tr").find(".amount").val(data.amount_due);
							this.payments[i].set("amount_paid", data.amount_due);
							found = true;
							break;
						}
					}
				} 
				if(found === false) {
					current.closest("tr").find(".amount").val(data.amount_due);
					this.payments.push({
							bill_id: data.id,
						 	amount_paid: data.amount_due,
						 	date: kendo.toString(this.get("date"),"yyyy-MM-dd"),
						 	payment_note: this.get("payment_note")
					});
				}	
			} else {
				current.closest("tr").find(".amount").val("");
				if(this.payments.length > 0) {
					for(var i=0; i < this.payments.length; i++) {
						if(data.id === this.payments[i].bill_id) {
							this.payments.splice(i, 1);
							break;
						}
					}
				}
			}
		},
		onEnter 		: function(e) {
			var current = $(e.currentTarget);
			var data 	= e.data;
			var found 	= false;
			if(e.which == 13) {
				if(current.closest("tr").find('.amount').val() > data.amount_due) {
					current.closest("tr").find('.amount').val("");
					current.closest("tr").find('.amount').focus();
				} else {
					if(this.payments.length > 0) {
						for(var i=0; i < this.payments.length; i++) {
							if(data.id === this.payments[i].bill_id) {
								this.payments[i].set("amount_paid", current.closest("tr").find('.amount').val());
								current.closest("tr").find(".checkbox").attr('checked');
								found = true;
								break;
							}
						}	
					}

					if(found === false) {
						this.payments.push({
								bill_id: data.id,
							 	amount_paid: current.closest("tr").find('.amount').val(),
							 	date: kendo.toString(this.get("date"),"yyyy-MM-dd"),
							 	payment_note: this.get("payment_note")
						});
						current.closest("tr").find(".checkbox").attr('checked');
					}
				}
			}	
		},
		total 			: function() {
			return this.get("payments").length;
		},
		totalAmount		: function() {
			var total = 0;
				for(var i=0; i<this.get("payments").length; i++) {
					total = parseFloat(total) + parseFloat(this.get("payments")[i].amount_paid);
				}
			return total;
		},
		employee 		: <?php echo $this->session->userdata('user_id'); ?>,
		empty 			: function() {
			
		},
		showDetail  : function(e) {
			if(e.type == 'dblclick') {
				alert("show detial");
			}
			
		},
		pay_bill	: function() {
			var data = bills.data();
			var vendor = vendorDS.get(vendorModel.get("vendor").id);
			if(this.get("cashAccount") === "") {
				alert("Empty");
			} else {
				if(this.get("payments").length > 0) {	
					billPayments.add(this.get("payments"));
					billPayments.sync();

					var journalEntries = [];
					journalEntries.push(
				 	{
				 		account_id: 30, //this logs to account payables should this be saved by the config setting
				 		dr: this.totalAmount(), 
				 		cr: 0, 
				 		memo: this.get('payment_note'), 
				 		class_id: this.get("class_id"),
				 		voucher: this.get('ref'),
				 		people_id: 4, 
				 		check_no: this.get('checkNo'),
				 		date: kendo.toString(this.get("date"), "yyyy-MM-dd"), 
				 		transaction_type: "សងបំណុល"
			 		});
					journalEntries.push({
				 		account_id: this.get("cashAccount"), 
				 		dr: 0, 
				 		cr: this.totalAmount(), 
				 		memo: this.get('payment_note'),
				 		class_id: this.get("class_id"), 
				 		voucher: this.get('ref'),
				 		people_id: 4,
				 		check_no: this.get('checkNo'),
				 		date: kendo.toString(this.get("date"), "yyyy-MM-dd"), 
				 		transaction_type: "សងបំណុល"
					 });
					if(journalEntries.length > 0) {
						journalDS.add({
					 		bill_id: billId,
					 		journalEntries : journalEntries,
					 		memo: this.get('memo'), 
					 		voucher: this.get('ref'),
					 		class_id: this.get("class_id"),
					 		budget_id: 0,
					 		donor_id: 0,
					 		check_no: this.get('checkNo'),
					 		people_id: vendorModel.get("vendor").id,
					 		employee_id: <?php echo $this->session->userdata('user_id'); ?>,
					 		invoice_id: 0,
					 		payment_id: 0,	
					 		date: kendo.toString(this.get("date"), "yyyy-MM-dd"), 
					 		transaction_type: "ទូទាត់បំណុល",
					 		people_id: vendorModel.get("vendor").id,
					 	});
					 	journalEntries.splice(0, journalEntries.length);
					}

					journalDS.sync();
					totalPaid = 0;
					vendor.set("outstanding", (vendor.outstanding - this.totalAmount()));
					for(var i = 0; i < billPayments.data().length; i++) {
						billPayments.remove(billPayments.at(0));
					}
					for(var i =0; i < journalDS.data().length; i++) {
						journalDS.remove(journalDS.at(i));
					}
					this.payments.splice(0, this.payments.length);
					this.set("cashAcct", "");
					this.set("checkNo", "");
					this.set("payment_not", "");
					bills.read();
				}				
			}
			
		}
	});

	var journalModel = kendo.observable({
		dataSource 		: journalDS,
		journalEntries 	: [],
		addEntry 		: function() {
			var entry;
		},
		removeEntry 	: function() {
			var entry;
		},
		editEntry 		: function() {
			var entry;
		},
		deleteEntry 	: function() {
			var entry;
		},
		addJournal 		: function() {
			var journal;
		},
		removeJournal 	: function() {
			var journal;
		},
		deleteJournal 	: function() {
			var journal;
		},
		editJournal 	: function() {
			var journal;
		},
		updateEntry 	: function() {
			var entry;
		},
		updateJournal 	: function() {
			var journal;
		},
		recordJournal 	: function() {
			var journal;
		}
	});

	var purchaseOrderModel = kendo.observable({		
		last_po_no 			: "<?php echo $last_po_no;?>",		

		number 				: "",
		type 				: "PO",
		status				: 0,
		biller				: <?php echo $this->session->userdata('user_id'); ?>,	
		vendor_id			: 0,
		address				: "",
		ship_to 			: "",		  	  
		issued_date			: new Date(),
		expected_date		: new Date(),		
		memo				: "",
		class_id			: "",
		
		total 				: kendo.toString(0,"c0"),					    
		
		invoiceItemList 	: [],
		itemList 			: [],		
		classList 			: classDS,
		
		pageLoad 			: function(id){
			var v = vendorDS.get(id);
			var addr = v.house_no +' '+ v.street_no;

			this.set("address", addr);
			this.set("ship_to", v.ship_to);			
			this.set("vendor_id", id);
			this.set("invoiceItemList", []);
			this.set("itemList", []);
			
			this.setExpectedDate();
			this.setPONumber();
			this.setItemSource();
			this.addNewRow();
		},
		setExpectedDate 	: function(){
			var exdate = new Date();
			exdate.setDate(exdate.getDate()+7);
			this.set("expected_date", exdate);
		},		
		setItemSource 		: function(){	    				  	
		  	for (var i=0; i< itemDS.total(); i++) {
	    		var data = itemDS.data();

	    		this.itemList.push({
	    			id 		: data[i].id,
	    			name 	: data[i].name	    			
	    		});
	    	}	    	
	    },
	    setPONumber 		: function(){
	    	var last_invoice_no = this.get("last_po_no");		
			var invoice_no = 0;
			if(last_invoice_no.length>6){
				invoice_no = parseInt(last_invoice_no.substr(6));						
			}
			invoice_no++;

			var str_inv_no = "PO" + kendo.toString(new Date(this.get("issued_date")), "yy") + kendo.toString(new Date(this.get("issued_date")), "MM");
			var inv_no = str_inv_no + kendo.toString(invoice_no, "00000");

			this.set("number", inv_no);
	    },
		autoIncreaseNo 		: function(){
			$(".sno").each(function(index,element){                 
			   $(element).text(index + 1); 
			});
		},
		addNewRow 			: function(){
			this.invoiceItemList.push({
				'invoice_id' 	: 0,
				'item_id' 		: "",
				'description' 	: "",				
				'quantity' 		: 1,
				'unit_price' 	: 0,
				'vat' 			: 0,
				'amount' 		: 0				
			});
			this.autoIncreaseNo();			
		},
		removeRow 			: function(e){
			var item = e.data;
	        var index = this.get("invoiceItemList").indexOf(item);        
	        this.get("invoiceItemList").splice(index, 1);
	        this.change();
		},
		change				: function(){			
			var total = 0;		
			$.each(this.get("invoiceItemList"), function(index, data) {				
				var amt = data.quantity * data.unit_price;				
	            total += amt;
	        });			

			this.set("total", kendo.toString(total,"c0"));

	    	this.autoIncreaseNo();    	
		},
		itemChange 			: function(e){
			var d = e.data;			
			var arr =  this.get("invoiceItemList");			
	        var index = arr.indexOf(d);
	        var data = arr[index];
	        var item = itemDS.get(d.item_id);	        
			
	        data.set("description", item.name);
	        data.set("unit_price", item.price);
	        data.set("vat", item.vat);
	        
	        this.change();	        	        	
		},
		btnCreatePO 		: function(){
			this.addPO();
			this.clearPO();
		},		
	    addPO 				: function(){
	    	if(kendo.parseFloat(this.get("total"))>0){
	    		//Add invoice to datasource	
		    	invoiceDS.add({
		    		'number' 			: this.get("number"),
				   	'type'				: this.get("type"),
				   	'status' 			: this.get("status"),
				   	'biller' 			: this.get("biller"),
				   	'vendor_id' 		: this.get("vendor_id"),			   	
				   	'address' 			: this.get("address"),
				   	'issued_date' 		: kendo.toString(new Date(this.get("issued_date")),"yyyy-MM-dd"),
				   	'expected_date' 	: kendo.toString(new Date(this.get("expected_date")),"yyyy-MM-dd"),				   	
				   	'class_id' 			: this.get("class_id"),
				   	'memo' 				: this.get("memo"),

				   	'invoice_items'		: this.get("invoiceItemList")
		    	});					
		    	invoiceDS.sync();		    		    			    	
	    	}        	    		    	
	    },	    
	    clearPO 			: function(){	    	
	    	this.set("last_po_no", this.get("number"));
			this.set("invoiceItemList", []);			

			this.set("memo", "");
			this.set("total", kendo.toString(0,"c0"));

			//Remove invoice
			for (var i=0; i< invoiceDS.total(); i++) {
				var dataItem = invoiceDS.at(i);
	  			invoiceDS.remove(dataItem);
			}

			this.setPONumber();
			this.addNewRow();			
	    }
	});
    
	//view/layout
	var layout 		= new kendo.Layout("#appIndex");
	var vendor 		= new kendo.View("#vendorInfo", {model: vendorModel});
	var eBill 		= new kendo.View("#eBill", { model: eBillModel });
	var transformerH	= new kendo.View("#transformerHistTmpl", { model: eBillModel });
	var purchase 	= new kendo.View("#purchase", { model: purchaseModel });
	var expense 	= new kendo.View("#expense", { model: expenseModel });
	var paybill 	= new kendo.View("#paybill", {model: billModel});
	var billHist 	= new kendo.View("#billHistory", {model: billModel});
	var billList 	= new kendo.View("#billList", {model: billModel});
	var purchaseOrder = new kendo.View("#purchaseOrderView", {model: purchaseOrderModel});

	//route
	var router = new kendo.Router({
		init: function() {
			layout.render("#application");
		}
	});

	router.route(":id", function(vendorId) {
		layout.showIn("#info", vendor);
		if(purchaseModel.get("cart").length > 0) {
			purchaseModel.empty();
		}
		vendorDS.fetch(function(e) {
			vendorModel.setVendor(vendorId);
			vendorModel.set("showBtn", true);
			purchaseModel.set("vendor", vendorId);
			$("#vendorList>li").find("#"+vendorId).addClass("active");
			billStatus = 1;
		});
		// bills.read();
		// console.log(vendorId);
	});

	router.route("/:id/eBill", function(id){
		layout.showIn("#content", eBill);
		//operationType = "purcashe";
	});

	router.route("/:id/purchase", function(id){
		layout.showIn("#content", purchase);
		operationType = "purcashe";
		purchaseModel.loadPO(id);
	});
	router.route("/:id/expense", function(id){
		layout.showIn("#content", expense);
		
	});

	router.route("/:id/transfomerRec", function(id){
		layout.showIn("#content", transformerH);
	});

	router.route("/bill/:id", function(id){
		//layout.showIn("#info", expense);
		alert("billing detail");
	});

	router.route("/:id/paybill", function(id){
		layout.showIn("#content", paybill);
		bills.filter({
			field: 'status',
			value: 0
		});
	});

	router.route("/:id/billHistory", function(id){
		layout.showIn("#content", billHist);
		bills.filter({
			field: 'vendor_id',
			value: id
		});
	});

	router.route("/:id/purchaseOrder", function(id){
		purchaseOrderModel.pageLoad(id);
		layout.showIn("#content", purchaseOrder);		
	});

	$(function(){		
		itemDS.read();

		$("#search").on('click', function() {
			var field = $("#searchOptions").val();
			var value = $("#searchField").val();
			vendorDS.filter(
				{ field: field, operator: 'contains',value: value}
			);
		});
		$("#vendorList").kendoListView({
			dataSource: vendorDS,
			selectable: true,
			template: kendo.template($("#vendorListTmpl").html()),
			change: function(e) {
				e.preventDefault();
				var uid = this.select().data('uid');
				var id = this.dataSource.getByUid(uid).id;
				var uri = id;
				//vendorModel.setVendor(id);
				// layout.showIn("#info", vendor);	
				
				// transformerRecordDS.filter(
				// 	{ field: 'vendor_id', value: id }
				// );

				// bills.filter(
				// 	{ field: 'vendor_id', value: id }
				// );			
				router.navigate(uri, false);
			}
		});
		$("#pager").kendoPager({
			dataSource: vendorDS,
			info: false
		});
		router.start();

		// $("#application").on("click", "#billTable > tbody > tr", function(e) {
		// 	//router.navigate("/bill/1", false);
		// 	var uid = $(e.currentTarget).closest("tr").data('uid');
		// 	alert(uid);
		// });
	});
</script>