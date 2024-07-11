<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends Admin_Controller
{
    public $model = 'blog_post_comments_model';

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $data = array();
        $blog_post_id = $this->uri->segment(5);
        $data['breadcrumb'] = set_crumbs(array('blog/posts' => 'Blog Posts', current_url() => 'Comments'));

        if ($blog_post_id)
        {
            $data['Blog_post'] = $Blog_post = $this->load->model('blog_posts_model');

            // get comments for the specified blog post
            $Blog_post->get_by_id($blog_post_id);

            if ( ! $Blog_post->exists())
            {
                return show_404();
            }

            // Get data from db
            $data['Comments'] = $Blog_post->comments->where('activated', 'YES')
                                    ->order_by('comment_date', 'DESC')
                                    ->get_by_blog_post_id($blog_post_id);

        }
        else
        {
            $data['Blog_post'] = null;

            // get all comments
            $Comments = $this->load->model('blog_post_comments_model');
            $data['Comments'] = $Comments->include_related('blog_posts', 'title')->where('activated', 'YES')
                                    ->where('approved', 'NO')
                                    ->order_by('comment_date', 'DESC')
                                    ->get();
        }

        $this->template->view('admin/comments/comments', $data);
    }

    function view()
    {
        $data = array();
        $data['Comment'] = $Comment = $this->load->model('blog_post_comments_model');
        $comment_id = $this->uri->segment(5);
        $Comment->get_by_id($comment_id);

        if ( ! $Comment->exists())
        {
            return show_404();
        }

        $data['breadcrumb'] = set_crumbs(array('blog/posts' => 'Blog Posts', 'blog/comments/index/' . $Comment->blog_post_id => 'Comments', current_url() => 'Comment View'));

        $this->template->view('admin/comments/view', $data);
    }

    function approve()
    {
        $Comment = $this->load->model('blog_post_comments_model');
        $comment_id = $this->uri->segment(5);
        $Comment->get_by_id($comment_id);

        if ( ! $Comment->exists())
        {
            return show_404();
        }

        $Comment->approved = 'YES';
        $Comment->save();

        $this->session->set_flashdata('message', '<p class="success">Comment was approved successfully.</p>');

        redirect(ADMIN_PATH . '/blog/comments/view/' . $Comment->id);
    }

    function delete()
    {
        $Comment = $this->load->model('blog_post_comments_model');
        $comment_id = $this->uri->segment(5);
        $Comment->get_by_id($comment_id);

        if ( ! $Comment->exists())
        {
            return show_404();
        }

        $blog_post_id = $Comment->blog_post_id;

        $Comment->delete();
        $this->session->set_flashdata('message', '<p class="success">Comment was deleted successfully.</p>');

        redirect(ADMIN_PATH . '/blog/comments/index/' . $blog_post_id);
    }

}
