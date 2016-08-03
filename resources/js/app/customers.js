	var customers = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/people_api/index",
				dataType: "json",
				type: "GET"
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
				id: "id"
			},
			data: "customers",
			total: "total"
		},
		serverPaging: true,
		pageSize: 20,
		serverFiltering: true
	});
	//model
	var profileM = kendo.observable({
		setID : function(id) {
			this.set('id', id);
			this.set('customer', customers.get(id));
		},
		showMap: function() {
			var data = [{
				lat:this.get('customer').latitute, 
				lng:this.get('customer').longtitute, 
				name:this.get('customer').name
			}];
			$('#map').kendoMap({
				dataSource: data,
			    title: "my map",
			    map: {
			      options: {
			        zoom: 18,
			        center: {
			        	lat: this.get('customer').latitute,
			        	lng: this.get('customer').longtitute
			        }
			      }
			    },
			    marker: {
			      template: "#: name #",
			      options: {
			        animation: google.maps.Animation,
			        draggable: true
			      }
			    }
			});
		},
		edit: function() {
			this.get('customer').set('gender', "ស");
			customers.sync();
		},
		toJSON : function() {
			return kendo.stringify(this.get('customerMD'));
		}

	});
    function createMap(lat,lng,name) {
    	
    };
	var invoiceMD = kendo.observable({
		customerID : ""
	});
	
	//layout and view
	var layout 	= new kendo.Layout("layout-tmpl");
	var index 	= new kendo.View("main-tmpl");
	var newCust	= new kendo.View("newCustomer-tmpl");
	var newInvoice	= new kendo.View("newInvoice-tmpl");
	var card 	= new kendo.View("card-tmpl");
	var profile	= new kendo.View("profile-tmpl", {model: profileM});
	var invoice = new kendo.View("invoice-tmpl", {model: invoiceMD});
	var map 	= new kendo.View("map-tmpl", {model: profileM});

	//initial router and bind to app div
	//must be used before routing
	var router = new kendo.Router({
		init: function() {
	        layout.render("#app");
	    }
	});
	//routing to proper url
	router.route("/", function(){
		layout.showIn("#showHere", index);
	});
	router.route("/card", function(){
		layout.showIn("#showHere", card);
	});
	router.route("/newCust", function(){
		layout.showIn("#showHere", newCust);
	});
	router.route("/newInvoice", function(){
		layout.showIn("#showHere", newInvoice);
	});
	router.route("/map/:id", function(customerID){
		profileM.setID(customerID);
		layout.showIn("#showHere", map);

	});
	router.route("/profile/:id", function(customerID){
		profileM.setID(customerID);
		layout.showIn("#showHere", profile);

		//layout.showIn("#detail", invoice);
		
	});
	router.route("/invoice/:id", function(customerID){
		invoiceMD.set("customerID", customerID);
		layout.showIn("#showHere", invoice);
	});

	router.route('map/:id/:lat/:lng', function(id,lat, lng){
		alert(lat + " " + lng);
	});

	var custSearch = kendo.observable({
		term : "",
		search: function() {
			if(this.get("term") !== "") {
				customers.filter({
					filters: [
						{ value: this.get("term") }	
					]
				});
			}
		}
	});
	function showInvoice() {
		router.navigate("/profile/"+ profileM.get("id")+"/invoice");
		//alert("hi");
	}

	jQuery(document).ready(function($) {
		// Stuff to do as soon as the DOM is ready;
		router.start();
		//kendo.init($("#custList"));
		kendo.bind($(".input-append"), custSearch);
		var custGrid = $("#custList").kendoListView({
			dataSource : customers,
			template: kendo.template($("#list-tmpl").html()),
			editTemplate: kendo.template($("#editList-tmpl").html()),
			selectable: "true",
			change: function(e) {
				var id = this.select().data("uid");
				var model = this.dataSource.getByUid(id);
				profileM.set("id", model.id);
				router.navigate("/profile/"+model.id);
			}
		}).data("kendoListView");
		var pager = $("#pager").kendoPager({
			dataSource: customers,
			info: false,
			previousNext: false,
			numeric: false,			
			input: true,
			messages: {
				itemsPerPage: "",
				page: "ទំព័រ",
				of: "នៃ {0}"
			},
			pageSizes: [20,30,40]
		});
		
	});