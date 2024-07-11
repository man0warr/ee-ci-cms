<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
    }


    function index()
    {
        $data = array();
        $data['breadcrumb'] = set_crumbs(array('mediaboxes' => 'Media Boxes', current_url() => 'Items'));

        $data['mediabox_id'] = $mediabox_id = $this->uri->segment(5);

		// Load mediaboxes
        $data['Mediabox'] = $Mediabox = $this->load->model('mediaboxes_model');
        $Mediabox->get_by_id($mediabox_id);

        if ( ! $Mediabox->exists())
        {
            return show_404();
        }

        // Load mediabox items
        $data['Items'] = $Mediabox->mediabox_items->order_by('sort', 'ASC')->get_by_mediabox_id($mediabox_id);

        // Load view
        $this->template->add_package('tablednd');
        $this->template->view('admin/items/items', $data);
    }


    function edit()
    {
        $data = array();
        $data['edit_mode'] = $edit_mode = FALSE;

        $data['mediabox_id'] = $mediabox_id = $this->uri->segment(5);
        $data['breadcrumb'] = set_crumbs(array('mediaboxes' => 'Mediaboxes', 'mediaboxes/items/index/' . $mediabox_id => 'Items', current_url() => 'Item Edit'));

        // Load mediabox items
        $data['Item'] = $Item = $this->load->model('mediabox_items_model');

        // Check for Edit Mode
        $item_id = $this->uri->segment(6);

        if ($item_id)
        {
            $data['edit_mode'] = $edit_mode = TRUE;
            $Item->get_by_id($item_id);

            if ( ! $Item->exists())
            {
                return show_404();
            }
        }

        // Validate Form
        $this->form_validation->set_rules('title', 'Title', "trim|required");
        $this->form_validation->set_rules('subtitle', 'Subtitle', "trim");
        $this->form_validation->set_rules('text_1', 'Text 1', "trim");
        $this->form_validation->set_rules('text_2', 'Text 2', "trim");
        $this->form_validation->set_rules('image_alt', 'Image Alternate Text', 'trim');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('link_type', 'Link Type', "required");
        $this->form_validation->set_rules('link_target', 'Link Target', "trim");
        $this->form_validation->set_rules('hide', 'Hide', 'integer');

        // Validate links dependingon link type
        if ($this->input->post('link_type') == 'INTERNAL')
        {
			$this->form_validation->set_rules('link_internal', 'Page', "trim|required");
        }
        else if ($this->input->post('link_type') == 'EXTERNAL')
        {
			$this->form_validation->set_rules('link_external', 'URL', "trim|required");
        }
        else if ($this->input->post('link_type') == 'IMAGE')
        {
			$this->form_validation->set_rules('image_path', 'Image', 'trim|required');
        }
        else if ($this->input->post('link_type') == 'FILE')
        {
			$this->form_validation->set_rules('link_file', 'Document', 'trim|required');
        }

        if ($this->form_validation->run() == TRUE)
        {
            // Save form data
            $Item->from_array($this->input->post());
            $Item->mediabox_id = $mediabox_id;
            $Item->description = ($this->input->post('description')) ? $this->input->post('description') : NULL;
            $Item->hide = ($this->input->post('hide')) ? 1 : 0;
            $Item->save();

            // Set the sort to the id if creating new item
            if ( ! $edit_mode)
            {
                $Item->sort = $Item->id;
                $Item->save();
            }

            if ($edit_mode)
            {
                $this->session->set_flashdata('message', '<p class="success">Item saved successfully.</p>');
            }

            redirect(ADMIN_PATH . '/mediaboxes/items/index/'.$Item->mediabox_id);
        }

        // Get all entries for link dropdown
        $this->load->model('content/entries_model');

        $Pages = $this->entries_model
            ->where('status', 'published')
            ->where('slug !=', 'NULL')
            ->or_where('id =', $this->settings->content_module->site_homepage)
            ->order_by('title')
            ->get();

        $data['Pages'] = option_array_value($Pages, 'slug', 'title', array(''  => '- SELECT -'));

        // Session variables for KCFinder
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;
        $_SESSION['isLoggedIn'] = true;

        // Load view
        $this->template->add_package(array('ckeditor', 'ck_jq_adapter'));
        $this->template->add_javascript('/application/modules/content/content_fields/assets/js/image.js');
        $this->template->add_javascript('/application/modules/content/content_fields/assets/js/file.js');
        $this->template->view('admin/items/edit', $data);
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
            $selected = (array) $this->uri->segment(5);
        }

        // Load mediabox items
        $this->load->model('mediabox_items_model');
        $Items = new Mediabox_items_model();
        $Items->where_in('id', $selected)->get();

        if ($Items->exists())
        {
            // Delete mediabox items
            $Items->delete_all();

            $this->session->set_flashdata('message', '<p class="success">The selected items were successfully deleted.</p>');
        }

        redirect(ADMIN_PATH . '/mediaboxes/items/index/'.$this->uri->segment(5));
    }


    function order()
    {
        if (is_ajax())
        {
            if(count($_POST) > 0 && $this->input->post('item_table'))
            {
                $this->load->model('mediabox_items_model');

                $table_order = $this->input->post('item_table');

                unset($table_order[0]);
                $table_order = array_values($table_order);

                $i = 1;

                foreach($table_order as $id)
                {
                    $Sort_items = new Mediabox_items_model();
                    $Sort_items->get_by_id($id);
                    $Sort_items->sort = $i;
                    $Sort_items->save();
                    unset($Sort_items);

                    $i++;
                }
            }

            return;
        }
        else
        {
            return show_404();
        }
    }

}
