<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

	private $header_count = 0;
	
	public function header_log($message){
		$backtrace = debug_backtrace();
		$line = "noline";
		$file = "nofile";
		if(!empty($backtrace)){
			//$backtrace = $backtrace[0];
			if(!empty($backtrace[0]['line'])){
				$line = $backtrace[0]['line'];
			}
			if(!empty($backtrace[0]['file'])){
				$file = $backtrace[0]['file'];
			}
		}
		header("X-debug-message-".$this->header_count++.": ".$message."-".$line."-".$file);
	}

	function __construct()
	{
		parent::__construct();

        $this->cms_parameters = array();
        $this->cms_base_route = '';

        // Check if to force ssl on controller
        if (in_uri($this->config->item('ssl_pages')))
        {
            force_ssl();
        } 
        else 
        {
            remove_ssl();
        }

        // Create Dynamic Page Title
        if ( ! $title = str_replace('-', ' ', $this->uri->segment(1)))
        {
            $title = 'Home';
        }

        if ($segment2 = str_replace('-', ' ', $this->uri->segment(2)))
        {
            $title = $segment2 . " - " . $title;
        }

        $this->template->set_meta_title(ucwords($title) . " | " . $this->settings->site_name);

        // Set Group
        if ($this->session->userdata('user_session'))
        {
            $this->group_id = $this->session->userdata('user_session')->group_id;
            $this->Group_session = $this->session->userdata('group_session');
        }

	}
}
