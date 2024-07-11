<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Manage_uploaded_files extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
	}


    function index()
    {
        $data = array();
        $data['breadcrumb'] = set_crumbs(array(current_url() => 'Manage Uploaded Files'));

        // Enable KCFinder
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;

        // Load view
        $this->template->add_javascript('/application/modules/content/content_fields/assets/js/image.js');
        $this->template->add_javascript('/application/modules/content/content_fields/assets/js/file.js');
        $this->template->view('admin/manage_uploaded_files', $data);
    }

}
