<div class="container">
	<div class="row">
		<div class="span12">
			<h2>Nationality Section</h2>
			<div class="input-append">
			<input style="width: 290px;" id="appendedInput" type="text" data-bind="value: nationality">
			<span class="add-on btn" data-bind="click: add">ADD</span>
			</div>
			<div id="nationalityGrid" data-role="grid" data-columns="['nationality']" data-bind="source: nationalities"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
var baseUrl = "<?php echo base_url(); ?>index.php/";
$(function() {
	nationalityVM = kendo.observable({
		nationalities	: new kendo.data.DataSource({
			transport	: {
				read	: {
					url	: baseUrl + "api/nationalities",
					type: "GET",
					dataType: "json"
				},
				create	: {
					url	: baseUrl + "api/nationalities",
					type: "POST",
					dataType: "json"
				},
				update	: {
					url	: baseUrl + "api/nationalities",
					type: "GET",
					dataType: "json"
				},
				destroy : {
					url	: baseUrl + "api/nationalities",
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
						nationality: { editable: true, type: "string", validation: { required: true } }
					}
				}
			}
		}),
		nationality		: "",
		add				: function() {
			if( this.get("nationality") != "" ) {
				this.get("nationalities").add({nationality: this.get("nationality")});
				this.get("nationalities").sync();
				this.set("nationality", "");
				this.get("nationalities").read();
			} else {
				
			}			
		}
	});
	
	kendo.bind($(".container"), nationalityVM);
});
</script>
