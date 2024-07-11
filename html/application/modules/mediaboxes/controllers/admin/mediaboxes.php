<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mediaboxes extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
    }


    function index()
    {
        $data = array();
        $data['breadcrumb'] = set_crumbs(array(current_url() => 'Media Boxes'));

        // Load mediaboxes
        $Mediaboxes = $this->load->model('mediaboxes_model');
        $data['Mediaboxes'] = $Mediaboxes->get();

        // Load view
        $this->template->view('admin/mediaboxes/mediaboxes', $data);
    }


    function edit()
    {
    	$data = array();
        $data['breadcrumb'] = set_crumbs(array('mediaboxes' => 'Media Boxes', current_url() => 'Media Box Edit'));
		$data['edit_mode'] = $edit_mode = FALSE;

		// Load mediaboxes model
        $data['Mediabox'] = $Mediabox = $this->load->model('mediaboxes_model');

        // Check for Edit Mode
        $mediabox_id = $this->uri->segment(4);

        if ($mediabox_id)
        {
            $data['edit_mode'] = $edit_mode = TRUE;
            $Mediabox->get_by_id($mediabox_id);

            if ( ! $Mediabox->exists())
            {
                return show_404();
            }
        }

        // Validate Form
        $this->form_validation->set_rules('title', 'Title', "trim|required");

        if ($this->form_validation->run() == TRUE)
        {
        	// Save form data
            $Mediabox->from_array($this->input->post());
            $Mediabox->save();

            if ($edit_mode)
            {
                $this->session->set_flashdata('message', '<p class="success">Media Box saved successfully.</p>');
                redirect(ADMIN_PATH . '/mediaboxes');
            }
            else
            {
                redirect(ADMIN_PATH . '/mediaboxes/items/index/' . $Mediabox->id);
            }
        }

		// Load view
        $this->template->view('admin/mediaboxes/edit', $data);
    }


    function delete()
    {
    	// Get selected mediaboxes
        if ($this->input->post('selected'))
        {
            $selected = $this->input->post('selected');
        }
        else
        {
            $selected = (array) $this->uri->segment(4);
        }

        // Load mediaboxes
        $this->load->model('mediaboxes_model');
        $Mediaboxes = $this->mediaboxes_model->where_in('id', $selected)->get();

        if ($Mediaboxes->exists())
        {
            foreach($Mediaboxes as $Mediabox)
            {
            	// Delete both mediabox items and mediaboxes
                $Mediabox->mediabox_items->get()->delete_all();
                $Mediabox->delete();
            }

            $this->session->set_flashdata('message', '<p class="success">Media Box was deleted successfully.</p>');
        }

        redirect(ADMIN_PATH . '/mediaboxes');
    }
}
