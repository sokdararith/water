<div class="row-fluid">    
	<div class="span12">
		<div id="example" class="k-content">
			
			<div class="relativeWrap" data-toggle="source-code" style="overflow: visible;">
				<div class="widget widget-tabs widget-tabs-double widget-tabs-vertical row-fluid row-merge widget-tabs-gray">
				
					<!-- Tabs Heading -->
					<div class="widget-head span2">
						<?php $this->load->view('customer/readingbar'); ?>
					</div>
					<!-- // Tabs Heading END -->
					
					<div class="widget-body span10">
						<div class="tab-content">						
							<!-- Tab content -->
							<div class="tab-pane active" id="tab1-1">								
								<table>
					        	  <tr>
					        	  	<td>ជំហ៊ានទី១ </td>
					        	  	<td><input name="userfile" id="userfile" type="file" /></td>                    	  	
					        	  	<td>ជំហ៊ានទី២ </td>
					        	  	<td><button class="btn btn-info" data-bind="click: readFile">ទាញយកទិន្នន័យ</button></td>
					        	  </tr>
					        	</table>                    
												
								<br>

								<div id="grid" data-role="grid" data-bind="source: meterList"
						            data-editable="true" data-row-template="rowTemplate" 
						            data-auto-bind="false"                  
						            data-columns='[
						            	{ "title": "លេខកូដ", width: 70 },
						                { "title": "ឈ្មោះ", width: 100 },		                	                                      
						                { "title": "ប្រចាំខែ", width: 70 },		                 
						                { "title": "ប្រអប់", width: 80 },
						                { "title": "#កុងទ័រ", width: 80 },
						                { "title": "ជំុ(R)", width: 40 },
						                { "title": "អំ.ចាស់(R)", width: 70 },
						                { "title": "អំ.ថ្មី(R)" },
						                { "title": "សរុប", width: 50 },
						                { "title": "ជំុថ្មី", width: 40 },
						                { "title": "អំ.ចាស់", width: 70 },
						                { "title": "អំ.ថ្មី" },
										{ "title": "សរុប", width: 50 }
						                ]'>
								</div>

								<br>

								<div class="status" align="center"></div>

								<div>
						        	<table width="100%">
						        		<tr>
						        			<td>ប្រចាំខែ</td>
								            <td><input data-role="datepicker" data-bind="value: month_of" data-start="year" data-depth="year" data-format="MM-yyyy" /></td>
								            <td>អ្នកអាន</td>
							            	<td>
							            		<select data-role="combobox" data-text-field="fullname" data-value-field="id" data-bind="source: readerList, value: reader_id"></select>
							            		<span id="reader"></span>
							            	</td>
							          		<td align="right">ចំនួនអំនានសុរប:</td>
							          		<td align="right"><span data-bind="text: total_read"></span></td>				            
							          	</tr>
							          	<tr>
							          		<td>ថ្ងៃអានចាប់ពី</td>
							            	<td><input data-role="datepicker" data-bind="value: date_read_from" data-format="dd-MM-yyyy" /></td>		            
							          		<td>ដល់</td>
							            	<td><input data-role="datepicker" data-bind="value: date_read_to" data-format="dd-MM-yyyy" /></td>			          			            
								            <td align="right">ថាមពលប្រើប្រាស់សរុប:</td>            
								            <td align="right"><span data-bind="text: total_active"></span></td>
							          	</tr>
							          	<tr>
							          		<td>ត្រង់ស្វូ</td>
							          		<td>
							          			<select data-role="combobox" data-text-field="transformer_number" data-value-field="id" 
							        					data-bind="source: transformerList, value: transformer"></select>	
							          		</td>			            	
							            	<td>ថាមពលប្រើប្រាស់ត្រង់ស្វូ(LV)</td>
						            		<td><input data-role="numerictextbox" data-format="n0" data-min="0" data-bind="value: usage" /></td>			          				            
								            <td align="right">ថាមពល Reactive សរុប:</td>            
								            <td align="right" width="90px"><span data-bind="text: total_reactive"></span></td>
							          	</tr>
							          	<tr>							          		
							          		<td></td>
							          		<td></td>
							          		<td></td>
							          		<td></td>
							          		<td></td>			          				          		
							          		<td align="right">
							          			<button class="btn btn-primary" data-bind="click: addMeterRecord"><i class="icon-hdd icon-white"></i> កត់ត្រា</button>     
							          		</td>
							          	</tr>
							        </table>
						        	
						        	<br>

						        	<div id="bottom" align="right">
										<a href="#top">ទៅកាន់ផ្នែកខាងលើ &uarr;</a>
									</div>
						        </div>
						        					
							</div>
							<!-- // Tab content END -->							
						</div>						
					</div>

				</div>
			</div>
		</div> <!--end div example-->            
	</div> <!--End div span12-->		
</div> <!--End div row-fluid-->
	

<!-- Row template -->
<script id="rowTemplate" type="text/x-kendo-tmpl">
	<tr id="rowGrid-#:id#">
		<td>#:customers.number#</td>		
		<td>#:customers.surname# #:customers.name#</td>			
		<td>
			#if(meter_records.month_of!=null){#
				#:kendo.toString(new Date(meter_records.month_of), "MM-yyyy")#				
			#}#
			<span id="msgD-#:id#"></span>
		</td>		
		<td>#: electricity_boxes.box_no #</td>
		<td>#: meter_no #</td>
		<td align="center">
		   <input type="checkbox" data-bind="checked: rcheckNewRound, events: { change: change }" #: tariff_id==0 ? disabled="disabled" : "" # />
		</td>
		<td>
			#if(meter_records.reactive_new_reading!=null && meter_records.reactive_new_reading >0){#
				#: meter_records.reactive_new_reading #
			#}#
		</td>
		<td>
		   <input data-role="numerictextbox" data-format="n0" data-min="0" style="width:70px;"
		   		data-bind="value: reactive_new_reading, events: { change: change }" style="width: 80px;" #: tariff_id==0 ? disabled="disabled" : "" # />		   		   
		</td>
		<td>
			#if(reactive_new_reading!==""){#
				#if(rcheckNewRound){#
					#:kendo.parseInt(reactive_new_reading) + kendo.parseInt(max_digit) - kendo.parseInt(meter_records.reactive_new_reading)#
				#}else{#
					#:kendo.parseInt(reactive_new_reading) - kendo.parseInt(meter_records.reactive_new_reading)#
				#}#
			#}#
			<span id="msgR-#:id#"></span>
		</td>
		<td align="center">
		   <input type="checkbox" data-bind="checked: checkNewRound, events: { change: change }" />
		</td>		
		<td>
			#if(meter_records.new_reading!=null){#
				#:meter_records.new_reading#
			#}#
		</td>
		<td>
		   <input class="txt-#:id#" data-role="numerictextbox" data-format="n0" data-min="0" style="width:70px;"
		   		data-bind="value: new_reading, events: { change: change }" style="width: 80px;" />		   		   			
		</td>
		<td>
			#if(new_reading!==""){#
				#if(checkNewRound){#
					#:kendo.parseInt(new_reading) + kendo.parseInt(max_digit) - kendo.parseInt(meter_records.new_reading)#
				#}else{#
					#:kendo.parseInt(new_reading) - kendo.parseInt(meter_records.new_reading)#
				#}#
			#}#
			<span id="msg-#:id#"></span>
		</td>
    </tr>
</script>

<!-- Document ready -->
<script>
$(document).ready(function() {
	//Datasources
	var irFileDS = new kendo.data.DataSource({
	  	transport: {	
	  	  	read:  {
			  	url: ARNY.baseUrl + "api/files/meter_reading_file",
			  	type: "GET",
			  	dataType: "json"
		  	}
	  	},
	  	requestEnd: function(e) {
		    var response = e.response;
		    var type = e.type;
		    
		    if(type==="read"){
		    	var totalActive = 0;		    	
		    	for (var i=0; i < response.length; i++){		    		
					var active = response[i].new_reading - response[i].meter_records.new_reading;									
										
					if(active>0){
						totalActive += active;						
					}					
		   		};

		    	viewModel.set("total_read", response.length);
		    	viewModel.set("total_active", totalActive);		    	
		    }
	  	},
	  	serverFiltering: true
	});

	var meterRecordDS = new kendo.data.DataSource({
	    transport: {	
	  	  	create:  {
			  	url: ARNY.baseUrl + "api/meter_records/meter_record_batch",
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
	  	}
	});

	var transformerDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/electricities/transformer_cascading",
				type: "GET",
				dataType: "json"
			}
		}
	});

	var transformerRecordDS = new kendo.data.DataSource({
	    transport: {	
	  	  	create:  {
			  	url: ARNY.baseUrl + "api/electricities/transformer_record",
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
	  	}
	});

	var readerDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/employees/index",
				type: "GET",
				dataType: "json"
			}
		},
		schema: {
			data: "employees",
			total: "total"
		},
		serverFiltering: true		
	});

	//View model
	var viewModel = kendo.observable({		
		reader_id		: "",
		month_of 		: new Date(),
		date_read_from	: new Date(),
		date_read_to	: new Date(),		
		total_read 		: 0,		
		total_active	: 0,
		total_reactive	: 0,

		//Transformer
		usage 			: 0,
		
		meterRecords  	: [],
		meterList 		: irFileDS,
		transformerList : transformerDS,			
		readerList 		: readerDS,

		readFile 		: function(e){
			irFileDS.read();
		},		    	
      	change 				: function(){
  			var totalActive = 0;
  			var totalReactive = 0;  														
			for(var i=0; i < irFileDS.total(); i++) {
				var data = irFileDS.at(i);

				if(data.new_reading!==""){					
					var newRound = 0;
					if(data.checkNewRound){
						newRound = data.max_digit;						
					}
					totalActive += (kendo.parseInt(data.new_reading) + kendo.parseInt(newRound)) - kendo.parseInt(data.meter_records.new_reading);										
				}

				if(data.reactive_new_reading!==""){					
					var reactiveNewRound = 0;
					if(data.rcheckNewRound){
						reactiveNewRound = data.max_digit;
					}										
					totalReactive += (kendo.parseInt(data.reactive_new_reading) + kendo.parseInt(reactiveNewRound)) - kendo.parseInt(data.meter_records.reactive_new_reading);					
				}					
			}
			
			this.set("total_active", totalActive);
			this.set("total_reactive", totalReactive);			
      	},
      	validation 			: function() {
			var result = true;																					
			for(var i=0; i < irFileDS.total(); i++) {
				var data = irFileDS.at(i);
				var r = true;
				
				//Validate on new reading
				var active_usage = 0;				
				if(data.new_reading!==""){					
					//Validate on date
					var dateReadTo = kendo.toString(new Date(this.get("date_read_to")), "yyyy-MM-dd");					
					var monthOf = new Date(this.get("month_of"));
					monthOf.setDate(1);
					monthOf = kendo.toString(monthOf, "yyyy-MM-dd");																
					if(monthOf <= data.meter_records.month_of){
						result = false;
						r = false;						
						$("#msgD-"+data.id).text("!");
					}else{
						$("#msgD-"+data.id).text("");
					}
					
					var newRound = 0;
					if(data.checkNewRound){
						newRound = data.max_digit;
					}
					active_usage = (parseInt(data.new_reading) + newRound) - data.meter_records.new_reading;											
				}
				if(active_usage<0){
					result = false;
					r = false;
					$("#msg-"+data.id).text("!");						
				}else{
					$("#msg-"+data.id).text("");
				}

				//Validate on reactive new reading
				var reactive_usage = 0;
				if(data.reactive_new_reading!==""){
					var reactiveNewRound = 0;
					if(data.rcheckNewRound){
						reactiveNewRound = data.max_digit;
					}
					reactive_usage = (parseInt(data.reactive_new_reading) + reactiveNewRound) - data.meter_records.reactive_new_reading;						
				}

				if(reactive_usage<0){
					result = false;
					r = false;
					$("#msgR-"+data.id).text("!");						
				}else{
					$("#msgR-"+data.id).text("");
				}
				
				//Highlight invalid input each rows
				if(r==false){
					$("#rowGrid-"+data.id).addClass("alert alert-error");
				}else{
					$("#rowGrid-"+data.id).removeClass("alert alert-error");
				}																
			}

			//Validate on reader
			if(!(this.get("reader_id")>0)){
				result = false;				
				$("#reader").text("!").addClass("alert alert-error");					
			}else{
				$("#reader").text("").removeClass("alert alert-error");
			}			
		
			return result;
		},
      	addMeterRecord 		: function(){      		
      		if(this.validation()){      			
      			var monthOf = new Date(this.get("month_of"));
				monthOf.setDate(1);
				monthOf = kendo.toString(monthOf, "yyyy-MM-dd");

      			for(var i=0; i < irFileDS.total(); i++) {
					var data = irFileDS.at(i);
					
					if(data.new_reading!==""){
						var newRound = 0;
						if(data.checkNewRound){
							newRound = data.max_digit;
						}
						var rnewRound = 0;
						if(data.rcheckNewRound){
							rnewRound = data.max_digit;
						}

						this.meterRecords.push({				
							meter_id				: data.id,
						   	prev_reading			: data.meter_records.new_reading,
						   	new_reading 			: data.new_reading,
						   	new_round				: newRound,
						   	reactive_prev_reading	: data.meter_records.reactive_new_reading,								   
						   	reactive_new_reading	: data.reactive_new_reading,
						   	reactive_new_round		: rnewRound,		   
						   	is_backup_reading 		: data.parent_id>0 ? 1 : 0,
						   	month_of 				: monthOf,
						   	date_read_from			: kendo.toString(this.get("date_read_from"), "yyyy-MM-dd"),						   
						   	date_read_to			: kendo.toString(this.get("date_read_to"), "yyyy-MM-dd"),
						   	reader 					: this.get("reader_id"),
						   	invoice_id				: 0 //No invoice yet					   	
						});
					}					
				}

				if(this.get("meterRecords").length>0){
					meterRecordDS.add(this.get("meterRecords"));
					meterRecordDS.sync();
			 		this.addTransformerRecord();

					this.set("transformer", "");
					$("#grid").kendoGrid();
					this.set("meterRecords", []);
					
					$(".status").text("").removeClass("alert alert-error");
					$(".status").text("កត់ត្រាបានសំរេច").addClass("alert alert-success");
				}				
			}else{
				$(".status").text("សូមត្រួតពិនិត្រឪ្យបានត្រឺមត្រូវម្ដងទៀត").addClass("alert alert-error");
			}
      	},
      	addTransformerRecord : function(){
      		var usage = kendo.parseInt(this.get("usage"));

      		if(usage>0 && usage!=null){      		   		      		
	  			var monthOf = new Date(this.get("month_of"));
				monthOf.setDate(1);
				monthOf = kendo.toString(monthOf, "yyyy-MM-dd");

	      		transformerRecordDS.add({
	      			type				: "LV",
	      			transformer_id  	: this.get("transformer").id,      			
	      			usage 				: usage,
	      			month_of 			: monthOf,
	      			date_read_from  	: kendo.toString(new Date(this.get("date_read_from")), "yyyy-MM-dd"),
	      			date_read_to  		: kendo.toString(new Date(this.get("date_read_to")), "yyyy-MM-dd"),
	      			reader 				: this.get("reader_id")
	      		});

	      		transformerRecordDS.sync();
      		}
      	}  			
	});  
	kendo.bind($("#example"), viewModel);

	//Upload file
	$("#userfile").kendoUpload({
        async: {
            saveUrl: ARNY.baseUrl +"api/files/do_upload_file",
            removeUrl: "remove",
            autoUpload: true
        },
		localization: {
			dropFilesHere: "ទំលាក់រួបភាពទីនេះ",
			select : "រើសទិន្នន័យ",
			statusUploading: "កំពុងទទួលយករូបភាព",
			statusFailed: "មិនអាចផ្ញើរ",
			retry: "សាកល្បងម្ដងទៀត",
			cancel: "មោឃ៖ភាព"
		},
		showFileList: false,
		success: function(e) {
			var files = e.files;
			var name, path;
			$.each(files, function(index, value){
				path = "./../uploads/pictures/" + value.name;
				//staffVM.set("image_url", path);
			});
		} 
    });
		
});//End document ready
</script>