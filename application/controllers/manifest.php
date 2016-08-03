<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manifest extends CI_Controller {
	
	public function index() {	
		header('Contect-Type: text/cache-manifest');
		echo "CACHE MANIFEST

		CACHE:
			/banhji/resources/js/kendoui/js/kendo.all.min.js
			/banhji/resources/js/kendoui/js/cultures/kendo.culture.km-KH.min.js
			/banhji/resources/js/kendoui/js/cultures/kendo.culture.en-US.min.js
			/banhji/resources/common/bootstrap/css/bootstrap.css
			/banhji/resources/common/bootstrap/css/responsive.css
			/banhji/resources/common/theme/fonts/glyphicons/css/glyphicons.css
			/banhji/resources/common/theme/fonts/font-awesome/css/font-awesome.min.css
			/banhji/resources/common/theme/css/style-default-menus-dark.css?1374506511
			/banhji/resources/common/theme/skins/css/blue-gray.css
			/banhji/resources/js/kendoui/styles/kendo.common.min.css
			/banhji/resources/js/kendoui/styles/kendo.bootstrap.min.css
			/banhji/resources/js/kendoui/styles/kendo.dataviz.material.min.css
		";
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */