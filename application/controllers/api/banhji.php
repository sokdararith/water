<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Banhji extends REST_Controller {
	private $user = null;
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();
		$this->entity = $this->input->get_request_header('Entity');
		$this->user   = $this->input->get_request_header('User');
		$this->company= null;
		$login = new Login();
		$login->where('id', $this->user)->get();
		if($login->exists()) {
			$company = $login->institute->get();
			$this->company = $company->id;
		}
	}

	public function users_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== false ? $this->get('limit') : 1000;
		$page = $this->get('page') !== false ? $this->get('page') : 1;
		
		$institute = new Institute();
		// if(isset($filters)) {
		// 	foreach($filters as $f) {
		// 		$institute->where($f['field'], $f['value']);
		// 	}
		// } else {
			$institute->where('id', $this->company);
		// }
		$institute->get();
		if($institute->exists()) {
			$logins = $institute->login->get();

			foreach($logins as $u) {
				$perm = $u->permission->get();
				$data[] = array(
					'id' 		=> $u->id,
					'username'  => $u->username,
					'first_name'=> $u->first_name,
					'last_name' => $u->last_name,
					'password'  => "*******",
					'permission'=> array(
						'id' 	=> $perm->id,
						'name' 	=> $perm->name
					)

				);
			}
		}

		if($data) {
			$this->response(
				array(
					'error'  => false,
					'count' => count($data),
					'results'=> $data
					
				),
				200
			);
		} else {
			$this->response(
				array(
					'error'  => true,
					'count' => 0,
					'results'=> array()					
				),
				200
			);
		}
	}

	public function users_put() {
		$requested_data = json_decode($this->put('models'));
		foreach($requested_data as $r) {
			// permission
			$permission = new Permission();
			$permission->where('id', $r->permission->id)->get();
			$login = new Login();
			$login->where('id', $r->id)->get();
			if($login->save($permission)){
				$data[] = array(
					'id' 		=> $login->id,
					'username'  => $login->username,
					'password'  => "*******",
					'permission'=> array(
						'id' 	=> $permission->id,
						'name' 	=> $permission->name
					)
				);
			}
		}
		if(isset($data)) {
			$this->response(
				array(
					'error'  => false,
					'count' => count($data),
					'results'=> $data
					
				),
				200
			);
		} else {
			$this->response(
				array(
					'error'  => true,
					'count' => 0,
					'results'=> array()					
				),
				200
			);
		}
	}

	public function users_post() {
		$requested_data = json_decode($this->post('models'));
		foreach($requested_data as $r) {
			// permission
			$permission = new Permission();
			$permission->where('id', $r->permission->id)->get();
			$institute = new Institute();
			$institute->where('id', $this->company)->get();
			$login = new Login();
			$login->where('username', $r->username)->get();
			if($login->exists()) {
				if($login->save($institute)){
					$data[] = array(
						'id' 		=> $login->id,
						'username'  => $login->username,
						'password'  => "*******",
						'permission'=> array(
							'id' 	=> $permission->id,
							'name' 	=> $permission->name
						)
					);
				}
			} else {
				$login->username = $r->username;
				$login->hashedPassword = hash('sha512', $this->config->item('encryption_key').$r->password);
				if($login->save(array($institute, $permission))){
					$data[] = array(
						'id' 		=> $login->id,
						'username'  => $login->username,
						'password'  => "*******",
						'permission'=> array(
							'id' 	=> $permission->id,
							'name' 	=> $permission->name
						)
					);
				}
			}
		}
		if(isset($data)) {
			$this->response(
				array(
					'error'  => false,
					'count' => count($data),
					'results'=> $data
					
				),
				201
			);
		} else {
			$this->response(
				array(
					'error'  => true,
					'count' => 0,
					'results'=> array()					
				),
				200
			);
		}
	}

	public function users_delete() {
		$requested_data = json_decode($this->delete('models'));
		foreach($requested_data as $r) {
			// permission
			$login = new Login();
			$login->where('id', $r->id)->get();
			$institute = $login->institute->get();
			$temp = array('id'=>$login->id);
			if($login->delete($institute)){
				$data[] = $temp;
			}
		}
		if(isset($data)) {
			$this->response(
				array(
					'error'  => false,
					'count' => count($data),
					'results'=> $data
					
				),
				200
			);
		} else {
			$this->response(
				array(
					'error'  => true,
					'count' => 0,
					'results'=> array()					
				),
				200
			);
		}
	}

	// Company section
	public function company_get() {
		$requested_data = $this->get("filter");
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') ? $this->get('limit'): 50;
		$offset= $this->get('offset')? $this->get('offset'): null;

		$institute = new Institute();
		$institute->limit($limit, $offset);
		if(isset($filters)) {
			foreach($filters as $f) {
				$institute->where($f['field'], $f['value']);
			}
			// $institute->get_paged($page, $limit);
			$institute->get();
			if($institute->exists()) {
				foreach($institute as $i) {
					// $industry = $i->industry->get();
					$data[] = array(
						'id' => $i->id,
						'name' => $i->name,
						'email'=> $i->email,
						'address'=> $i->address,
						'logo' => $i->logo,
						'description' => $i->description,
						'country' => array('id' => $i->country_id),
						'province' => array('id' => $i->province_id),
						'industry'=> array('id' => $i->industry_id),
						'tax_regime' => $i->tax_regime,
						'type' => array('id' => $i->type_id),
						'locale' => $i->locale,
						'report_locale' => $i->report_locale,
						'vat_no' => $i->vat_number,
						'date_founded' => $i->year_founded,
						'fiscal_date' => $i->fiscal_date,
						'financial_year' => $i->financial_year,
						'financial_report_date' => $i->financial_report_date,
						'legal_name' => $i->legal_name,
						'is_local' => $i->is_local === 'true' ? TRUE:FALSE
					);
				}
				$this->response(
					array('error' => false, 'msg' => 'data found', 'results'=>$data, 'count'=>count($data)), 200);
			} else {		
				$this->response(
					array('error' => false, 'msg' => 'no user found', 'results'=>array(), 'count'=>0), 200);
			}	
		} else {
			$this->response(array('error' => true, 'msg' => 'no filter', 'results'=>array(), 'count'=>0), 200);
		}
	}

	public function company_post() {
		$posted_data = json_decode($this->post('models'));

		foreach($posted_data as $d) {
			$company = new Institute();
			$company->industry_id = $d->industry->id;
			$company->name = $d->name;
			$company->email= $d->email;
			$company->address = $d->address;
			// $company->logo = $d->logo;
			$company->description = $d->description;
			$company->country_id = $d->country->id;
			$company->province_id = $d->province->id;
			$company->type_id = $d->type->id;
			$company->year_founded = $d->date_founded;
			$company->legal_name = $d->legal_name;
			$company->fiscal_date = $d->fiscal_date;
			$company->locale = $d->locale->locale;
			$company->tax_regime = $d->tax_regime->code;
			$company->vat_number = $d->vat_no;
			$company->report_locale = $d->report_locale->locale;
			$company->is_local = $d->is_local;
			$company->deleted = 'false';

			$login = new Login();
			$login->where('id', $d->login)->get();
			$module = new Module();
			$module->where('is_core', 'true')->get();
			if($company->save(array($login, $module)){
				$data[] = array(
					'id' => $company->id,
					'name' => $company->name,
					'email'=> $company->email,
					'address'=> $company->address,
					'logo' => $company->logo,
					'description' => $company->description,
					'country' => array('id' => $company->country_id),
					'province' => array('id' => $company->province_id),
					'industry'=> array('id' => $company->industry_id),
					'tax_regime' => $company->tax_regime,
					'type' => array('id' => $company->type_id),
					'locale' => $company->locale,
					'report_locale' => $company->report_locale,
					'vat_no' => $company->vat_number,
					'date_founded' => $company->year_founded,
					'fiscal_date' => $company->fiscal_date,
					'financial_year' => $company->financial_year,
					'financial_report_date' => $company->financial_report_date,
					'legal_name' => $company->legal_name,
					'is_local' => $company->is_local === 'true' ? TRUE:FALSE
				);
			}
		}
		if(isset($data)) {
			$this->response(
				array(
					'error'  => false,
					'count' => count($data),
					'results'=> $data
				),
				201
			);
		} else {
			$this->response(
				array(
					'error'  => true,
					'count' => 0,
					'results'=> array()					
				),
				200
			);
		}
	}

	public function company_put() {
		$posted_data = json_decode($this->put('models'));

		foreach($posted_data as $d) {
			$company = new Institute();
			$company->where('id', $d->id)->get();
			if($company->exists()) {
				$company->industry_id = $d->industry->id;
				$company->name = $d->name;
				$company->email= $d->email;
				$company->address = $d->address;
				$company->logo = $d->logo;
				$company->description = $d->description;
				$company->country_id = $d->country->id;
				$company->province_id = $d->province->id;
				$company->type_id = $d->type->id;
				$company->year_founded = $d->date_founded;
				$company->legal_name = $d->legal_name;
				$company->fiscal_date = $d->fiscal_date;
				$company->locale = $d->locale;
				$company->tax_regime = $d->tax_regime;
				$company->vat_number = $d->vat_no;
				$company->logo = $d->logo;
				$company->financial_year = $d->financial_year;
				$company->is_local = $d->is_local;
				$company->report_locale = $d->report_locale;
				$company->type_id = $d->type->id;
				if($company->save()){
					$data[] = $d;
				}
			}
		}
		if(isset($data)) {
			$this->response(
				array(
					'error'  => false,
					'count' => count($data),
					'results'=> $data,
				),
				201
			);
		} else {
			$this->response(
				array(
					'error'  => true,
					'count' => 0,
					'results'=> array()					
				),
				200
			);
		}
	}

	public function company_delete() {
		$posted_data = json_decode($this->delete('models'));

		foreach($posted_data as $d) {
			$company = new Institute();
			$company->where('id', $d->id)->get();
			$company->deleted = 'true';
			if($company->save()){
				$data[] = $d;
			}
		}
		if(isset($data)) {
			$this->response(
				array(
					'error'  => false,
					'count' => count($data),
					'results'=> $data,
					'upload'=> $this->upload->data()
				),
				201
			);
		} else {
			$this->response(
				array(
					'error'  => true,
					'count' => 0,
					'results'=> array()					
				),
				200
			);
		}
	}

	// role
	public function roles_get() {
		$permission = new Permission();
		$permission->get_iterated();

		foreach($permission as $perm) {
			$data[] = array(
				'id' 	=> $perm->id,
				'name' 	=> $perm->name
			);
		}

		$this->response(
			array(
				'error'  => false,
				'count' => count($data),
				'results'=> $data
				
			),
			200
		);
	}

	public function roles_put() {}

	public function roles_post() {
		$models = json_decode($this->post('models'));
		$r = new Role();
		foreach($models as $model) {
			$r->name = $model->name;
			$r->description = $model->description;
			if($r->save()) {
				$data[] = array(
					'id' => $r->id,
					'name'=>$r->name,
					'description'=>$r->description
				);
			}
		}
	}

	public function roles_delete() {}

	// add role to user
	public function addroles_post() {}
	public function addroles_put() {}
	public function addroles_delete() {}

	public function password_post() {
		$requested_data = json_decode($this->post('models'));
		foreach($requested_data as $r) {
			$login = new Login();
			$login->where('username', $r->username)->get();
			if($login->exists()) {
				$login->hashedPassword = hash('sha512', $this->config->item('encryption_key').$r->password);
				if($login->save()){
					$this->response(
						array(
							'error'  => false,
							'count' => 1,
							'results'=> array()	
						),
						201
					);
				} else {
					$this->response(
						array(
							'error'  => true,
							'count' => 1,
							'results'=> array()
							
						),
						200
					);
				}
			} else {
				$this->response(
					array(
						'error'  => true,
						'count' => 1,
						'results'=> array()
						
					),
					200
				);
			}
		}
	}

	public function industry_get() {
		$industry = new Industry();
		$industry->get();
		foreach($industry as $i) {
			$data[] = array(
				'id' => $i->id,
				'code' => $i->code,
				'name' => $i->name
			);
		}
		$this->response(
			array(
				'error'  => false,
				'count' => count($data),
				'results'=> $data
				
			),
			200
		);
	}

	public function types_get() {
		$industry = new Institute_type();
		$industry->get();
		foreach($industry as $i) {
			$data[] = array(
				'id' => $i->id,
				'country' => $i->country_id,
				'name' => $i->type
			);
		}
		$this->response(
			array(
				'error'  => false,
				'count' => count($data),
				'results'=> $data
				
			),
			200
		);
	}

	public function countries_get() {
		$industry = new Country();
		$industry->get();
		foreach($industry as $i) {
			$data[] = array(
				'id' => $i->id,
				'code' => $i->code,
				'name' => $i->name
			);
		}
		$this->response(
			array(
				'error'  => false,
				'count' => count($data),
				'results'=> $data
				
			),
			200
		);
	}

	public function provinces_get() {
		$industry = new Province();
		$industry->get();
		foreach($industry as $i) {
			$data[] = array(
				'id' => $i->id,
				'country' => $i->country_id,
				'local' => $i->name_local,
				'english' => $i->name_en
			);
		}
		$this->response(
			array(
				'error'  => false,
				'count' => count($data),
				'results'=> $data
				
			),
			200
		);
	}

	public function logo_post() {
		$files = $_FILES['userFile'];
		if(isset($files['name'])) {
			if($files['type'] === "image/jpeg" || $files['type'] === "image/jpg" || $files['type'] === "image/png") {
				if($files['size'] < 3000000) {
					$type = explode(".", $files['name']);
					$sourcePath = $files['tmp_name'];
					$fileName = 'logo_'.uniqid().'.'.$type[1];
					$targetPath = './uploads/logo/'.$fileName;
					if(move_uploaded_file($sourcePath,$targetPath)){
						// crop image
						$config['image_library'] = 'gd2';
						$config['source_image']	= './uploads/logo/'.$fileName;
						$config['quality'] = "97%";
						$config['create_thumb'] = FALSE;
						$config['master_dim'] = 'auto';
						$config['maintain_ratio'] = TRUE;
						$config['width']	= 200;
						$config['height']	= 200;

						$this->load->library('image_lib', $config); 

						$this->image_lib->resize();

						$this->response(
							array(
								'error'  => false,
								'count' => 1,
								'msg' => 'uploaded.',
								'results'=> array(
									'error' => 0,
									'url' => "uploads/logo/".$fileName
								)	
							),
							200
						);
					} else {
						$this->response(
							array(
								'error'  => false,
								'count' => 1,
								'msg' => 'Exceed max size limit.',
								'results'=> array('url' => $files['name'])	
							),
							200
						);
					}
				} else {
					$this->response(
						array(
							'error'  => true,
							'count' => 1,
							'msg' => 'Exceed max size limit.'.$files['name'],
							'results'=> array()	
						),
						200
					);
				}
			} else {
				$this->response(
					array(
						'error'  => true,
						'count' => 1,
						'msg' => 'picture type not allowed (only jpeg, jpg or png is allowed).',
						'results'=> array()	
					),
					200
				);
			}	
		} else {
			$this->response(
				array(
					'error'  => false,
					'count' => 1,
					'results'=> $files
				),
				200
			);
		}
			$this->response(
				array(
					'error'  => false,
					'count' => 1,
					'results'=> array()
				),
				200
			);
	}

}//End Of Class