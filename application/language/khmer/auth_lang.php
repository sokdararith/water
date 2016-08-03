<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Lang - Khmer
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.14.2010
*
* Description:  Khmer language file for Ion Auth messages and errors
*
*/

// Account Creation
$lang['account_creation_successful'] 	  	 = 'គណនីបានបង្កើតដោយជោគជ័យ';
$lang['account_creation_unsuccessful'] 	 	 = 'មិនអានបង្កើតគណនីបានទេ';
$lang['account_creation_duplicate_email'] 	 = 'មានអ៉ីម៉ែលរួចហើយឬមិនត្រឹមត្រូវ';
$lang['account_creation_duplicate_username'] = 'មានឈ្មោះអ្នកប្រើរួចហើយឬមិនត្រឹមត្រូវ';

// Password
$lang['password_change_successful'] 	 	 = 'លេខសំងាត់បានត្រូវប្ដូរដោយជោគជ័យ';
$lang['password_change_unsuccessful'] 	  	 = 'មិនអាចប្ដូរលេខសំងាត់បានទេ';
$lang['forgot_password_successful'] 	 	 = 'លេខសំងាត់កែបានផ្ញើរអ៉ីម៉ែល';
$lang['forgot_password_unsuccessful'] 	 	 = 'មិនអាចកែលេខសំងាត់បាន';

// Activation
$lang['activate_successful'] 		  	     = 'គណនីបានដំណើរការ';
$lang['activate_unsuccessful'] 		 	     = 'មិនអាចដំណើរការគណនីបាន';
$lang['deactivate_successful'] 		  	     = 'គណនីបានត្រូវផ្អាក់';
$lang['deactivate_unsuccessful'] 	  	     = 'មិនអាចផ្អាកគណនីបាន';
$lang['activation_email_successful'] 	  	 = 'អ៉ីម៉ែលអំពីការដំណើរការគណនីបានត្រូវផ្ញើរ';
$lang['activation_email_unsuccessful']   	 = 'មិនអាចផ្ញើរអ៉ីម៉ែលពីដំណើរការគណនីបានទេ';

// Login / Logout
$lang['login_successful'] 		  	         = 'ចូលបានជោគជ័យ';
$lang['login_unsuccessful'] 		  	     = 'ការចូលមិនត្រឹមត្រូវ';
$lang['login_unsuccessful_not_active'] 		 = 'គណនីមិនដំណើរការ';
$lang['login_timeout']                       = 'ត្រូវបានចាក់ចេញបណ្ដោះអាសន្ន សូមព្យាយាមម្ដតទៀត';
$lang['logout_successful'] 		 	         = 'ចាកចេញដោយជោគជ័យ';

// Account Changes
$lang['update_successful'] 		 	         = 'ពត៏មានគណនីត្រូវបានធ្វើបច្ចុប្បនភាពជោគជ័យ';
$lang['update_unsuccessful'] 		 	     = 'មិនអាចធ្វើបច្ចុប្បនភាពលើគណនីបានទេ';
$lang['delete_successful']               = 'អ្នកប្រើប្រាស់ត្រូវបានលុប';
$lang['delete_unsuccessful']           = 'មិនអាចលុបអ្នកប្រើប្រាស់បាន';

// Groups
$lang['group_creation_successful']  = 'ក្រុមត្រូវបានបង្កើត';
$lang['group_already_exists']       = 'ឈ្មោះក្រុមត្រូវបានគេយកមុនហើយ';
$lang['group_update_successful']    = 'ពត៏មានក្រុមត្រូវបានធ្វើបច្ចុប្បនភាព';
$lang['group_delete_successful']    = 'ក្រុមត្រូវបានលុប';
$lang['group_delete_unsuccessful'] 	= 'មិនអាចលុបក្រុមបាន';
$lang['group_name_required'] 		= 'ឈ្មោះក្រុមត្រូវការបញ្ចូល';

// Email Subjects
$lang['email_forgotten_password_subject']    = 'ការបញ្ចាក់លើការភ្លេចលេខសំងាត់';
$lang['email_new_password_subject']          = 'លេខសំងាត់ថ្មី';
$lang['email_activation_subject']            = 'ការដំណើរការគណនី';