<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class User_documents extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
    }


    function index()
    {
        $data = array();
        $data['breadcrumb'] = set_crumbs(array(current_url() => 'User Documents'));

        // Load users
        $this->load->model('users_model');
        $data['Users'] = $this->users_model->where('activated', '1')->order_by('id', 'asc')->get();

        // Enable KCFinder
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;

        // Load view
        $this->template->view('admin/user_documents/user_documents', $data);
    }

}
