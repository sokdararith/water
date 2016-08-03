self.addEventListener('install', function(event){
	event.waitUntil(
		caches.open('v1')
		.then(function(cache) {
			return cache.addAll([
				'/banhji/',
				'/banhji/admin',
				'/banhji/resources/js/kendoui/js/kendo.all.min.js',
				'/banhji/resources/js/kendoui/js/cultures/kendo.culture.km-KH.min.js',
				'/banhji/resources/js/kendoui/js/cultures/kendo.culture.en-US.min.js',
				'/banhji/resources/common/bootstrap/css/bootstrap.css',
				'/banhji/resources/common/bootstrap/css/responsive.css',
				'/banhji/resources/common/theme/fonts/glyphicons/css/glyphicons.css',
				'/banhji/resources/common/theme/fonts/font-awesome/css/font-awesome.min.css',
				'/banhji/resources/common/theme/css/style-default-menus-dark.css?1374506511',
				'/banhji/resources/common/theme/skins/css/blue-gray.css',
				'/banhji/resources/js/kendoui/styles/kendo.common.min.css',
				'/banhji/resources/js/kendoui/styles/kendo.bootstrap.min.css',
				'/banhji/resources/js/kendoui/styles/kendo.dataviz.material.min.css'
			]);
		})
	);
});
self.addEventListener('fetch', function(event) {
  var response;
  event.respondWith(caches.match(event.request).catch(function() {
    return fetch(event.request);
  }).then(function(r) {
    response = r;
    caches.open('v1').then(function(cache) {
      cache.put(event.request, response);
       console.log('sw fetch');
    });

    return response.clone();
  }).catch(function() {
    return caches.match('/banhji/resources/js/kendoui/styles/kendo.common.min.css');
  }));
});