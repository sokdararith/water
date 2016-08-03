<div class="container">
	<div class="row">
		<div class="span12">
			<h2>Nationality Section</h2>
			<div class="input-append">
			<input style="width: 290px;" id="appendedInput" type="text" data-bind="value: department">
			<span class="add-on btn" data-bind="click: add">ADD</span>
			</div>
			<div id="departmentGrid" data-role="grid" data-columns="['name']" data-bind="source: departments"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
var baseUrl = "<?php echo base_url(); ?>index.php/";
$(function() {
	nationalityVM = kendo.observable({
		departments	: new kendo.data.DataSource({
			transport	: {
				read	: {
					url	: baseUrl + "api/departments",
					type: "GET",
					dataType: "json"
				},
				create	: {
					url	: baseUrl + "api/departments",
					type: "POST",
					dataType: "json"
				},
				update	: {
					url	: baseUrl + "api/departments",
					type: "GET",
					dataType: "json"
				},
				destroy : {
					url	: baseUrl + "api/departments",
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
					id: "id",
					fields: {
						name: { editable: true, type: "string", validation: { required: true } }
					}
				}
			}
		}),
		department		: "",
		add				: function() {
			if( this.get("department") != "" ) {
				this.get("departments").add({name: this.get("department"), deletable: "true"});
				this.get("departments").sync();
				this.set("department", "");
				this.get("departments").read();
			} else {
				
			}			
		}
	});
	
	kendo.bind($(".container"), nationalityVM);
});
</script>

