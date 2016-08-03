<div class="container">
	<div class="row">
		<div class="span2">
			<?php $this->load->view("electricity/sidebar_view"); ?>
		</div>
		<div class="span10">
			<div id="list" data-bind="visible: show"> 
				<button class="btn" data-bind="click: isShown">Create</button>
				<table class="table">
					<tbody data-role="listview" data-bind="source: DS" data-template="typeList"></tbody>
				</table>
			</div>
			<div id="create" data-bind="invisible: show">
				<button class="btn" data-bind="click: isShown">List</button>
				<table class="table">
					<tr>
						<td>ប្រភេទ</td>
						<td></td>
					</tr>
					<tr>
						<td>ជើង</td>
						<td></td>
					</tr>
					<tr>
						<td>ការពាររន្ទះMV</td>
						<td></td>
					</tr>
					<tr>
						<td>ខ្សែMVតចូលត្រងស្វូរ</td>
						<td></td>
					</tr>
					<tr>
						<td>កាំបិត<br>ផ្ដាច់</td>
						<td></td>
					</tr>
					<tr>
						<td>Support</td>
						<td></td>
					</tr>
					<tr>
						<td>តេអុី</td>
						<td></td>
					</tr>
					<tr>
						<td>កុងទ័រ</td>
						<td></td>
					</tr>
					<tr>
						<td>ហ្វុ៊យសុីប</td>
						<td></td>
					</tr>
					<tr>
						<td>ខ្សែស្រោមLV</td>
						<td></td>
					</tr>
					<tr>
						<td>ខ្សែស្រោមLVអតិថិជន</td>
						<td></td>
					</tr>
					<tr>
						<td>ខ្សែការពាររន្ទះ</td>
						<td></td>
					</tr>
					<tr>
						<td>ខ្សែដី</td>
						<td></td>
					</tr>
					<tr>
						<td>ក្រចាប់ទែរ</td>
						<td></td>
					</tr>
					<tr>
						<td>ដែកទែរ</td>
						<td></td>
					</tr>
					<tr>
						<td>ប្រអប់</td>
						<td></td>
					</tr>
					<tr>
						<td>P.G Clam</td>
						<td></td>
					</tr>
					<tr>
						<td>កូស</td>
						<td></td>
					</tr>
					<tr>
						<td>ទុយោ</td>
						<td></td>
					</tr>
				</table>
			</div>
			sfdsf <span data-bind="text: type.count"></span>
		</div>
</div>
<script id="typeList" type="text/x-kendo-template">
	<tr>
		<td>ប្រភេទ</td>
		<td>#=type#</td>
	</tr>
	<tr>
		<td>ជើង</td>
		<td>#=base#</td>
	</tr>
	<tr>
		<td>ការពាររន្ទះMV</td>
		<td>#=lightning_arrest#</td>
	</tr>
	<tr>
		<td>ខ្សែMVតចូលត្រងស្វូរ</td>
		<td>#=cable_connection#</td>
	</tr>
	<tr>
		<td>កាំបិតផ្ដាច់</td>
		<td>#=fuse_cut_out#</td>
	</tr>
	<tr>
		<td>Support</td>
		<td>#=support#</td>
	</tr>
	<tr>
		<td>តេអុី</td>
		<td>#=current#</td>
	</tr>
	<tr>
		<td>កុងទ័រ</td>
		<td>#=analog_meter#</td>
	</tr>
	<tr>
		<td>ហ្វុ៊យសុីប</td>
		<td></td>
	</tr>
	<tr>
		<td>ខ្សែស្រោមLV</td>
		<td>#=pvc_sheath_cable#</td>
	</tr>
	<tr>
		<td>ខ្សែស្រោមLVអតិថិជន</td>
		<td>#=lv_wire_customer#</td>
	</tr>
	<tr>
		<td>ខ្សែការពាររន្ទះ</td>
		<td>#=lightning_protective_cable#</td>
	</tr>
	<tr>
		<td>ខ្សែដី</td>
		<td>#=ground_wire#</td>
	</tr>
	<tr>
		<td>ក្រចាប់ទែរ</td>
		<td>#=earth_rod#</td>
	</tr>
	<tr>
		<td>ដែកទែរ</td>
		<td>#=clam#</td>
	</tr>
	<tr>
		<td>ប្រអប់</td>
		<td></td>
	</tr>
	<tr>
		<td>P.G Clam</td>
		<td></td>
	</tr>
	<tr>
		<td>កូស</td>
		<td>#=connector#</td>
	</tr>
	<tr>
		<td>ទុយោ</td>
		<td>#=conduit#</td>
	</tr>
</script>
<script>
	var transformerTypeDS = new kendo.data.DataSource({
		transport: {
			read: {
				url 	: ARNY.baseUrl + "api/electricities/transformerTypes",
				type 	: "GET",
				dataType: "json"
			},
			create: {
				url 	: ARNY.baseUrl + "api/electricities/transformerTypes",
				type 	: "POST",
				dataType: "json"
			},
			update: {
				url 	: ARNY.baseUrl + "api/electricities/transformerTypes",
				type 	: "PUT",
				dataType: "json"
			},
			destroy: {
				url 	: ARNY.baseUrl + "api/electricities/transformerTypes",
				type 	: "DELETE",
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
	var typeModel = kendo.observable({
		tranType 	: [],
		add 		: function(e) {
			this.tranType.push({
				type 			: "",
				capacity 		: "50KVA",
				description 	: "",
				base 			: "",
				lighting_arrest : "",
				cable_connection: "",
				fuse_cut_out 	: "",
				support 		: "",
				current 		: "",
				circuit_breaker : "",
				analog_meter 	: "",
				pvc_sheath_cable: "",
				lv_wire_customer: "",
				lightning_protective_cable: "",
				ground_wire 	: "",
				clam 			: "",
				earth_rod		: "",
				distribution_box: "",
				connector 		: "",
				conduit 		: ""
			});
		},
		remove 		: function(e) {
			for(var i = 0; i < this.tranType.length; i++) {
				var current = this.tranType[i];
				if(current === e.data) {
					this.tranType.splice(i, 1);
					break;
				}
			}
		},
		empty 		: function(e) {
			if(this.tranType.length > 0) {
				this.tranType.splice(0, this.tranType.length);
			}
		},
		count 		: function(e) {
			return this.get("tranType").length;
		}
	});
	var transformer = kendo.observable({
		DS 			: transformerTypeDS,
		type 		: typeModel,
		show 		: true,
		isShown 	: function() {
			if(this.get("show")=== true) {
				this.set("show", false);
			} else {
				this.set("show", true);
			}
		},
		add 		: function(e) {
			this.DS.add(this.get("type").tranType);
		},
		remove		: function(e) {
			console.log(e.id);
		}, 
		sync 		: function(e) {
			this.DS.sync();
		}
	});
	$(function () {
		kendo.bind($(".container"), transformer);
		
	});
</script>