<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonials extends Admin_Controller
{
    public $model = 'testimonials_model';

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $data = array();
        $data['breadcrumb'] = set_crumbs(array(current_url() => 'Testimonials'));
        $this->template->add_package('tablednd');
        $Testimonials = $this->load->model('testimonials_model');

        // Get data from db
        $data['Testimonials'] = $Testimonials->order_by('sort', 'ASC')->get();

        $this->template->view('admin/testimonials', $data);
    }

    function edit()
    {
        $data['breadcrumb'] = set_crumbs(array('testimonials' => 'Testimonials', current_url() => 'Testimonial Edit'));

        $data['Testimonial'] = $Testimonial = $this->load->model('testimonials_model');
        $data['edit_mode'] = $edit_mode = FALSE;
        $testimonial_id = $this->uri->segment(4);
        $this->load->helper('file');

        // Set Mode
        if ($testimonial_id)
        {
            $data['edit_mode'] = $edit_mode = TRUE;
            $Testimonial->get_by_id($testimonial_id);

            if ( ! $Testimonial->exists())
            {
                return show_404();
            }
        }

        // Validate Form
        $this->form_validation->set_rules('by', 'By', "trim|required");
        $this->form_validation->set_rules('quotation', 'Quotation', "trim|required");

        if ($this->form_validation->run() == TRUE)
        {
            // Get the max sort number
            $Testimonial_sort = new Testimonials_model();
            $max_sort = $Testimonial_sort->select_func('MAX', '@sort', 'max_sort')->get()->max_sort;

            $Testimonial->from_array($this->input->post());
            $Testimonial->sort = $max_sort + 1;
            $Testimonial->save();

            if ($edit_mode)
            {
                $this->session->set_flashdata('message', '<p class="success">Testimonial saved successfully.</p>');
            }

            redirect(ADMIN_PATH . '/testimonials');
        }


        $this->template->view('admin/edit', $data);
    }

    function delete()
    {
        if ($this->input->post('selected'))
        {
            $selected = $this->input->post('selected');
        }
        else
        {
            $selected = (array) $this->uri->segment(4);
        }

        $this->load->model('testimonials_model');
        $Testimonials = $this->testimonials_model->where_in('id', $selected)->get();

        if ($Testimonials->exists())
        {
            foreach($Testimonials as $Testimonial)
            {
                $Testimonial->delete();
            }

            $this->session->set_flashdata('message', '<p class="success">$Testimonial was deleted successfully.</p>');
        }

        redirect(ADMIN_PATH . '/testimonials');
    }

    function order()
    {
        // Order testimonials
        if (is_ajax())
        {
            if(count($_POST) > 0 && $this->input->post('testimonial_table'))
            {
                $table_order = $this->input->post('testimonial_table');
                unset($table_order[0]);

                $table_order = array_values($table_order);

                $i = 1;
                foreach($table_order as $id)
                {
                    $Sort_testimonials = new Testimonials_model();
                    $Sort_testimonials->get_by_id($id);
                    $Sort_testimonials->sort = $i;
                    $Sort_testimonials->save();
                    unset($Sort_testimonials);

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
