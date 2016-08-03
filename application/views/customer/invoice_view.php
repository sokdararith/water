<div class="row-fluid">
	<div class="span12">
		<div id="example" class="k-content">			
			<h4 align="center">វិក្កយបត្រ</h4>
			
			<div class="row-fluid">
				<div class="span4">				
					<table cellpadding="2" cellspacing="2">					          
						<tr>				
							<td>លេខវិក្ក​យបត្រ</td>
							<td><input class="k-textbox" data-bind="value: number" style="width:140px;" readonly /></td>
						</tr>
						<tr>
							<td>ថ្ងៃចេញវិក្កយបត្រ</td>
							<td><input data-role="datepicker" data-bind="value: issued_date" data-format="dd-MM-yyyy" /></td>
						</tr>		                      
						<tr>
			                <td>Class</td>
			              	<td><select data-role="combobox" data-text-field="name" data-value-field="id" data-bind="source: classList, value: class_id"></select></td>
			            </tr>            
						<tr>
							<td colspan="2">
								អាសយដ្ឋាន
								<br>
								<textarea id="memo" cols="0" rows="2" class="k-textbox" style="width:250px" data-bind="value: address"></textarea>
							</td>
						</tr>
					</table>
				</div>

			    <div class="span4">
			    	<div align="center">
			    		<span class="glyphicons standard circle_ok" data-bind="visible: paid"><i></i> ទូទាត់រួច</span>				    	
			    	</div>
			    </div>

				<div class="span4">
					<table cellpadding="2" cellspacing="2">	
						<tr>
			                <td>កាលកំណត់</td>
			              	<td><select data-role="dropdownlist" data-text-field="term" data-value-field="id" data-bind="source: paymentTermList, value: payment_term_id" data-option-label="(--- ជ្រើសរើស ---)"></select></td>
			            </tr>				
						<tr>
							<td>ថ្ងៃបង់ប្រាក់</td>
							<td><input data-role="datepicker" data-bind="value: due_date" data-format="dd-MM-yyyy" /></td>
						</tr>					
			            <tr>
			            	<td>លេខបញ្ជាលក់</td>				
							<td><select data-role="dropdownlist" data-text-field="number" data-value-field="id" data-auto-bind="false" data-bind="source: soList, value: so_id, events:{ change: soChange}" data-option-label="(--- ជ្រើសរើស ---)"></select></td>
						</tr>
						<tr>
			            	<td>លេខសម្រង់តំម្លៃ</td>				
							<td><select data-role="dropdownlist" data-text-field="number" data-value-field="id" data-auto-bind="false" data-bind="source: estimateList, value: estimate_id, events:{ change: estimateChange}" data-option-label="(--- ជ្រើសរើស ---)"></select></td>
						</tr>
						<tr>
			            	<td>លេខលិខិតដឺកជញ្ជូន</td>				
							<td><select data-role="dropdownlist" data-text-field="number" data-value-field="id" data-auto-bind="false" data-bind="source: gdnList, value: gdn_id, events:{ change: gdnChange}" data-option-label="(--- ជ្រើសរើស ---)"></select></td>
						</tr>
					</table>           		          	
			    </div>
			</div>
						
			<div data-role="grid" data-bind="source: invoiceItemList"
		        data-auto-bind="false" data-row-template="invoiceRowTemplate"                  
		        data-columns='[{ title: "#", width: 35 }, 
		            { title: "ទំនិញ", width: 175 },	                     
		            { title: "ពណ៌នា", width: 200 },
		            { title: "ចំនួន", width: 95 },
		            { title: "តំលៃ", width: 115 },	                    	                     
		            { title: "VAT", width: 80 },
		            { title: "ទឹកប្រាក់" }	                    	                    
		            ]'>
			</div>
			<button class="btn btn-inverse" data-bind="click: addNewRow"><i class="icon-plus icon-white"></i></button>
			
			<br>
			
			<div class="row-fluid">				
				<div class="span8">
					សំគាល់:
					<br>
					<textarea id="memo" cols="0" rows="4" class="k-textbox" style="width:300px" data-bind="value: memo"></textarea>
				</div>

				<div class="span4">
					<table width="100%">
						<tr align="right">
							<td>សរុបរង:</td>
							<td width="50%"><span data-bind="text: sub_total"></span></td>
						</tr>
						<tr align="right">
							<td><select data-role="combobox" data-text-field="name" data-value-field="id" 
										data-bind="source: vatList, value: vat_id" placeholder="VAT" style="width:140px"></select></td>
							<td><span data-bind="text: vat"></span></td>
						</tr>
						<tr align="right">
							<td>សរុប:</td>
							<td><span data-bind="text: vat"></span></td>
						</tr>
						<tr align="right">
							<td>សរុបតាមអតិថិជនរូបិយបណ្ណ:</td>
							<td><span data-bind="text: vat"></span></td>
						</tr>
					</table>
				</div>													
			</div>

			<div class="row-fluid">				
				<div class="span12" align="right">
					<span class="btn btn-primary btn-icon glyphicons print" data-bind="click: linkPrint, visible: isUpdate"><i></i> បោះពុម្ព</span>
					<span class="btn btn-primary btn-icon glyphicons cart_in" data-bind="click: btnCreateInvoice"><i></i> កត់ត្រា</span>
				</div>
			</div>		
		</div><!--End div example-->
	</div><!--End div span12-->
</div><!--End div row-fluid-->

<script id="invoiceRowTemplate" type="text/x-kendo-tmpl">		
	<tr>		
		<td class="sno">1</td>
		<td>
			<select data-role="combobox" data-text-field="name" data-value-field="id" data-suggest="true"
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
			<input class="price" data-role="numerictextbox" data-format="c0" data-bind="value: unit_price, events: {change : change}" 
				style="width: 100px" />
		</td>
		<td>
			<input data-role="numerictextbox" data-format="p0" 
					data-min="0"
					data-max="1"
					data-step="0.01"
					data-bind="value: vat, events: {change : change}" 
					style="width: 65px;" />
		</td>
		<td align="right">
			#:kendo.toString(kendo.parseFloat(amount), 'c0')#
			<i class="icon-trash" data-bind="events: { click: removeRow "></i>
		</td>		
    </tr>   
</script>

<script>
$(document).ready(function() {

}