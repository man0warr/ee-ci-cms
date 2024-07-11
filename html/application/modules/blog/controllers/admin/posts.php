<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $data = array();
        $data['breadcrumb'] = set_crumbs(array(current_url() => 'Blog Posts'));
        $Blog_posts = $this->load->model('blog_posts_model');

        // Get data from db
        $data['Blog_posts'] = $Blog_posts->order_by('posted_date', 'DESC')->get();

        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;
        $_SESSION['isLoggedIn'] = true;

        $this->template->view('admin/posts/posts', $data);
    }

    function edit()
    {
        $data = array();
        $this->template->add_package(array('ckeditor', 'ck_jq_adapter'));

        $data['breadcrumb'] = set_crumbs(array('blog/posts' => 'Blog Posts', current_url() => 'Blog Post Edit'));

        $data['Blog_post'] = $Blog_post = $this->load->model('blog_posts_model');
        $data['edit_mode'] = $edit_mode = FALSE;
        $blog_post_id = $this->uri->segment(5);
        $this->load->helper('file');

        // Set Mode
        if ($blog_post_id)
        {
            $data['edit_mode'] = $edit_mode = TRUE;
            $Blog_post->get_by_id($blog_post_id);

            if ( ! $Blog_post->exists())
            {
                return show_404();
            }
        }

        // Validate Form
        $this->form_validation->set_rules('title', 'Title', "trim|required");
        $this->form_validation->set_rules('content', 'Content', "trim|required");
        $this->form_validation->set_rules('image_filename', 'Image', 'trim');
        $this->form_validation->set_rules('image_alt', 'Alternative Text', "trim");
        $this->form_validation->set_rules('posted_date', 'Posted Date', "trim|required");
        $this->form_validation->set_rules('posted_by', 'Posted By', "trim|required");

        if ($this->form_validation->run() == TRUE)
        {
            $Blog_post->from_array($this->input->post());
            $Blog_post->image_filename = ($this->input->post('image_filename') != '') ? $this->input->post('image_filename') : NULL;
            $Blog_post->image_alt = ($this->input->post('image_alt') != '') ? $this->input->post('image_alt') : NULL;
            $Blog_post->posted_date = date("Y-m-d H:i:s", strtotime($this->input->post('posted_date')));
            $Blog_post->save();

            if ($edit_mode)
            {
                $this->session->set_flashdata('message', '<p class="success">Post saved successfully.</p>');
            }

            redirect(ADMIN_PATH . '/blog/posts');
        }


        $this->template->view('admin/posts/edit', $data);
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

        $this->load->model('blog_posts_model');
        $Blog_posts = $this->blog_posts_model->where_in('id', $selected)->get();

        if ($Blog_posts->exists())
        {
            foreach($Blog_posts as $Blog_post)
            {
                $Blog_post->comments->get()->delete_all();
                $Blog_post->delete();
            }

            $this->session->set_flashdata('message', '<p class="success">Post was deleted successfully.</p>');
        }

        redirect(ADMIN_PATH . '/blog/posts');
    }

    function create_thumb()
    {
        if (is_ajax())
        {
           if ($this->input->post('image_path'))
           {
               echo image_thumb($this->input->post('image_path'), 100, 100);
           }
        }
        else
        {
            return show_404();
        }
    }

}
