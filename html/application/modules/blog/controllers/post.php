<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Post extends Public_Controller
{

    public function view()
    {
        $data = array();
        $Blog_post = $this->load->model('blog_posts_model');
        $blog_post_id = $this->uri->segment(4);
        $data['thank_you'] = $this->uri->segment(5);

        $data['Blog_post'] = $Blog_post->get_by_id($blog_post_id);

        if ( ! $Blog_post->exists())
        {
            return show_404();
        }

        if ($this->settings->disable_comments)
        {
            $data['display_comments'] = false;
        }
        else
        {
            $data['display_comments'] = true;
            $data['Comments'] = $Blog_post->comments->where('activated', 'YES')
                                    ->where('approved', 'YES')
                                    ->order_by('comment_date', 'DESC')
                                    ->get_by_blog_post_id($blog_post_id);
        }

        $this->template->view('post', $data);
    }

    /* Add a comment to the post. */
    public function add()
    {
        $data = array();
        $Blog_post = $this->load->model('blog_posts_model');
        $blog_post_id = $this->input->post('blog_post_id');

        $data['Blog_post'] = $Blog_post->get_by_id($blog_post_id);

        if ( ! $Blog_post->exists())
        {
            return show_404();
        }

        $data['Comments'] = $Blog_post->comments->order_by('comment_date', 'DESC')->get_by_blog_post_id($blog_post_id);

        // Validate Form
        $this->form_validation->set_rules('name', 'Name', "trim|required");
        $this->form_validation->set_rules('email', 'Email', "trim|required");
        $this->form_validation->set_rules('comment', 'Comment', 'trim|required');
        $this->form_validation->set_rules('captcha_input', 'CAPTCHA', 'validate_captcha|required');

        if ($this->form_validation->run() == TRUE)
        {
            $Comment = new Blog_post_comments_model();

            $Comment->content = $this->input->post('comment');
            $Comment->name = $this->input->post('name');
            $Comment->email = $this->input->post('email');
            $Comment->activation_code = md5($blog_post_id . time() . mt_rand());
            $Comment->blog_post_id = $blog_post_id;

            $Comment->save();

            // send email with activation code
            $this->load->library('email');

            $this->email->from('noreply@'.domain_name(), $this->settings->site_name);
            $this->email->to($Comment->email, $Comment->name);
            $this->email->subject($this->settings->site_name . ': Blog Comment Confirmation');
            $this->email->message("Thank you for your comment.\n\nTo activate your comment, please visit the following URL\n\n" . site_url('blog/post/activate/' . $Comment->id . '/' . $Comment->activation_code) . "\n\nThank You!\n\n" . $this->settings->site_name);

            $this->email->send();

            // tidy up
            unset($Comment);

            redirect(site_url('/blog/post/view/' . $blog_post_id . '/1'));
        }

        $data['thank_you'] = false;
        $data['display_comments'] = 1;

        $this->template->view('post', $data);
    }

    /* Activate a comment. */
    function activate()
    {
        $data = array();
        $this->load->model('blog_post_comments_model');
        $comment_id = $this->uri->segment(4);
        $activation_code = $this->uri->segment(5);

        if ( ! $comment_id || ! $activation_code)
        {
            return show_404();
        }

        // Lookup user by id and activation code
        $data['Comment'] = $Comment = $this->blog_post_comments_model
            ->where('id', $comment_id)
            ->where('activation_code', $activation_code)
            ->get();

        // Show 404 if user not found
        if ( ! $Comment->exists())
        {
            return show_404();
        }

        $data['new_activation'] = false;

        if ($Comment->activated == 'NO')
        {
            $Comment->activated = 'YES';
            $Comment->save();
            $data['new_activation'] = true;
        }

        $this->template->view('blog/activate', $data);
    }

}
