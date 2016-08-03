<div class="container">
	<div class="row">
		<div class="span3">
			<ul class="tags"></ul>
		</div>
		<div class="span9">
			<div id="application"></div>
		</div>
	</div>
</div>
<script id="layout" type="text/x-kendo-tmpl">
	<div id="content"></div>
</script>
<script id="index" type="text/x-kendo-tmpl">
	<div class="hero-unit">
	  <h1>គ្រប់គ្រងព័តមានបន្ថែម</h1>
	  <p>Tagline</p>
	  <p>
	    <a href="#/new/Tag" class="btn btn-primary btn-large">
	      បន្ថែមថ្មី
	    </a>
	  </p>
	</div>
</script>
<script id="info" type="text/x-kendo-tmpl">
	Here is info <span data-bind="text: current.name"></span>
	<a class="btn" href="#/new/Tag">New</a>
	<button class="btn" data-bind="click: editUri">Edit</button>
	<a class="btn" href="#" data-bind="click: removeTag">Delete</a>
</script>
<script id="addTag" type="text/x-kendo-tmpl">
	<a href="#" class="pull-right"><i class="icon-home"></i></a><br>
	<div class="well">
		<input type="text" data-bind="value: name">
		<select data-bind="source: types, value: type" data-value-field="type" data-text-field="type"></select>
		<a href="#" data-bind="click: addTag"><i class="icon-plus"></i></a>
	</div>
</script>
<script id="editTag" type="text/x-kendo-tmpl">
	<a href="#" class="pull-right"><i class="icon-home"></i></a><br>
	<div class="well">
		<input type="text" data-bind="value: name">
		<select data-bind="source: types, value: type" data-value-field="type" data-text-field="type"></select>
		<a href="#" data-bind="click: editTag"><i class="icon-plus"></i></a>
	</div>
	
</script>
<script id="tagList" type="text/x-kendo-tmpl">
	<li class="tag">#=name# <i class="icon-chevron-right"></i></li>
</script>
<script>
	var tagDS = new kendo.data.DataSource({
		transport: {
			read: {
				url: ARNY.baseUrl + "api/settings/classes/",
				type: "GET",
				dataType: "json"
			},
			create: {
				url: ARNY.baseUrl + "api/settings/classes/",
				type: "POST",
				dataType: "json"
			},
			update: {
				url: ARNY.baseUrl + "api/settings/classes/",
				type: "PUT",
				dataType: "json"
			},
			parameterMap: function(options, operation) {
				if(operation!=="read" && options.models) {
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
	
	var tagModel = kendo.observable({
		tags 		: tagDS,
		types 		: [
			{id: 1, type: "Class"}, 
			{id: 2, type: "Budget"}, 
			{id: 3, type: "Donor"}, 
			{id: 4, type: "Location"}
		],
		name 		: "",
		type 		: "Class",
		setCurrent 	: function(id) {
			this.set("current", tagDS.get(id));
		},
		addTag 		: function() {
			if(this.get("name")!=="") {
				tagDS.add({name: this.get("name"), type: this.get("type")});
				tagDS.sync();
				this.set("name", "");
				this.set("type", "Class");
			}
			
		},
		removeTag 	: function(e) {
			e.preventDefault();
			var conf = confirm("Delete "+ this.get("current").id);
			if(conf) {
				model = tagDS.get(this.get("current").id);
				tagDS.remove(model);
				tagDS.sync();
			} else {

			}
			//alert(this.get("current").id);
		},
		editUri 	: function(e) {
			router.navigate('/edit/'+this.get("current").id);
		},
		editTag 	: function() {
			var model = tagDS.get(this.get("current").id);
			model.set("name", this.get("name"));
			model.set("type", this.get("type"));
			if(model.dirty) {
				tagDS.sync();
			}

		}
	});
	var layout 	= new kendo.Layout("#layout");
	var index	= new kendo.View("#index", {model: tagModel});
	var info	= new kendo.View("#info", {model: tagModel});
	var addTag	= new kendo.View("#addTag", {model: tagModel});
	var editTag	= new kendo.View("#editTag", {model: tagModel});

	var router = new kendo.Router({
		init: function() {
			layout.render("#application");
		}
	});
	router.route('/', function(){
		layout.showIn("#content", index);
	});
	router.route('/:id', function(id){
		layout.showIn("#content", info);
		tagModel.setCurrent(id);
	});
	router.route('/new/Tag', function() {
		layout.showIn("#content", addTag);
	});
	router.route('/edit/:id', function(id) {
		layout.showIn("#content", editTag);
		tagModel.set("name", tagDS.get(id).name);
		tagModel.set("type", tagDS.get(id).type);
	});
	$(function(){
		router.start();
		$(".tags").kendoListView({
			dataSource: tagDS,
			selectable: true,
			template: kendo.template($("#tagList").html()),
			change: function() {
				var uid = this.select().data('uid');
				var model = this.dataSource.getByUid(uid);
				router.navigate("/"+model.id);

			}
		});
	});
</script>
<style scoped>
	.tags {
		list-style: none;
		padding: 0;
		margin: 0;
		border: 0;
	}
	.tags .tag {
		padding: 5px 3px;
		margin-bottom: 2px;
		background-color: #eee;
		border: 0px solid #ccc;
	}
	.tag i {
		position: absolute;
		right: 8px;
	}
	.tag.k-state-selected {
		background-color: blue;
	}
</style>