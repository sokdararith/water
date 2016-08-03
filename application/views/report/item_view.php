<div class="container">
	<div class="row"> 
        <?php $this->load->view("report/sidebar"); ?>       
        <h2 style="text-align:center">បញ្ជីរាយសារពើភ័ណ្ឌ</h2>
        <h5 style="text-align:center">(ITEM LISTING)</h5>
		<div class="span12">
			<div id="example" class="k-content">
                <div id="grid"></div>
                <script>                    
                    $(document).ready(function() {
                        $("#grid").kendoGrid({
                            dataSource: {                               
                                transport: {
                                    read: {
                                        url : ARNY.baseUrl + "api/inventory_api/item",
                                        type: "GET",
                                        dataType: "json"
                                    },
                                    parameterMap: function(options, operation) {
                                        if (operation !== "read" && options.models) {
                                            return {models: kendo.stringify(options.models)};
                                        }           
                                        return options;
                                    }
                                }
                            },
                            height: 620,
                            resizable: true,
                            filterable: true,
                            sortable: true,
                            columnMenu: true,
                            reorderable: true,
                            columns: [                                      
                                { field: "name", title: "ឈ្មោះ", width: 170}, 
                                { field: "purchase_description", title: "ការពិពណ៌នាសង្ខេប"},
                                { field: "type_name.name", title: "ប្រភេទ", type: "number"},
                                { field: "cost", title: "តម្លៃនៃការទិញ", type: "number", format: "{0:c}"},
                                { field: "price", title: "តំលៃលក់", type: "number", format: "{0:c}"},                                
                                { field: "quantity", title: "បរិមាណ", type: "number"}                                                                                                      
                            ]
                        });
                    });
                </script>
            </div>
		</div>
	</div>
</div>