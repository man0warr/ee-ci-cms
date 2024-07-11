<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Users extends Public_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('email');
    }


    public function login()
    {
        $data = array();
        $this->load->model('users_model');

        // Prevent IE users from caching this page
        if ( ! isset($_SESSION))
        {
            session_start();
        }

        // If redirect session variable is set, redirect to home page
        if ( ! $redirect_to = $this->session->userdata('redirect_to'))
        {
            $redirect_to = '/users/dashboard';
        }

        // If user is already logged in, redirect to desired location
        if ($this->secure->is_auth())
        {
            redirect($redirect_to);
        }

        // Check if user has a remember me cookie
        if ($this->users_model->check_remember_me())
        {
            redirect($redirect_to);
        }

        // Form Validation
        $this->form_validation->set_rules('email', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        // Process Form
        if ($this->form_validation->run() == TRUE)
        {
            // Database query to lookup email and password
            if ($this->users_model->login($this->input->post('email'), $this->input->post('password')))
            {
                redirect($redirect_to);
            }

            redirect(current_url());
        }

        if ($this->uri->segment(1) == ADMIN_PATH)
        {
        	// User is attempting to log into the admin panel use the admin theme
            $this->template->set_theme('admin', 'default', 'application/themes');
            $this->template->set_layout('default_wo_errors');
            $this->template->add_package('jquery');

            // Render the view
            $this->template->view("admin/login", $data);
        }
        else
        {
        	// Render the view
            $this->template->view("/users/login", $data);
        }
    }


    public function forgot_password()
    {
        $data = array();

        // Form Validation
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required|callback_email_exists');

        if ($this->form_validation->run() == TRUE)
        {
            // Characters to generate password from;
            $chars = "abcdefghijkmnopqrstuvwxyz023456789";

            $i = 0;
            $pass = '' ;

            // Randomly string together a 7 character password
            while ($i <= 7)
            {
                $num = rand(0, 33);
                $tmp = $chars[$num];
                $pass .= $tmp;
                $i++;
            }

            $User = $this->input->post('user');

            // Email the new password to the user
			$to = $User->email;
			$subject = 'Password Reset';
			$message = "Your {$this->settings->site_name} password has been reset.\n\nYour new password is: {$pass}";
			$this->send_email($to, $subject, $message);

            // Set users password in database
            $User->password = md5($this->config->item('encryption_key') . $pass);

            $this->load->model('users_model');
            $User->save();

            // Feedback and redirect
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">An email containing your new password has been sent to your email address.</div>');

            if ($this->uri->segment(1) == ADMIN_PATH)
            {
                redirect(ADMIN_PATH . '/users/login');
            }
            else
            {
                redirect('users/login');
            }
        }

        // If user was in admin panel load admin view
        if ($this->uri->segment(1) == ADMIN_PATH)
        {
            $this->template->set_theme('admin', 'default', 'application/themes');
            $this->template->add_package('jquery');
            $this->template->view("admin/forgot_password", $data);
        }
        else
        {
            $this->template->view("/users/forgot_password", $data);
        }
    }


    public function register()
    {
        $data = array();

        // Check that user registration is enabled
        if ( ! $this->settings->users_module->enable_registration)
        {
            return show_404();
        }

        // Validate Form
        $this->form_validation->set_rules('email', 'Email', "trim|required|valid_email|callback_email_check");
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|format_phone');
        $this->form_validation->set_rules('address', 'Address', 'trim');
        $this->form_validation->set_rules('address2', 'Address 2', 'trim');
        $this->form_validation->set_rules('city', 'City', 'trim');
        $this->form_validation->set_rules('state', 'State', 'trim');
        $this->form_validation->set_rules('zip', 'Zip', 'trim');
        $this->form_validation->set_rules('spam_check', 'Spam Check', 'trim');

        if ($this->form_validation->run() == TRUE)
        {
            // Stops bots that attempt to fill the field which is hidden by CSS
            if ($this->input->post('spam_check') != '')
            {
                return $this->template->view('/users/register', $data);
            }

			// Validation successful

           	// Create new user
            $this->load->model('users_model');
            $this->users_model->from_array($this->input->post());
            $this->users_model->id = NULL; // Prevent someone from trying to post an ID
            $this->users_model->group_id = $this->settings->users_module->default_group;
            $this->users_model->password = md5($this->config->item('encryption_key') . $this->input->post('password'));
            $this->users_model->created_date = date('Y-m-d H:i:s');
            $this->users_model->save();

            if ($this->settings->users_module->email_activation)
            {
            	// Assign an activation code to the users account
                $this->users_model->activation_code = md5($this->users_model->id . strtotime($this->users_model->created_date) . mt_rand());
                $this->users_model->activated = 0;
                $this->users_model->save();

                // E-mail the activation code to the user
                $to = $this->users_model->email;
                $subject = "{$this->settings->site_name} Activation";
                $message = "Thank you for your new member registration.\n\nTo activate your account, please visit the following URL\n\n" . site_url('users/activate/' . $this->users_model->id . '/' . $this->users_model->activation_code) . "\n\nThank You!\n\n" . $this->settings->site_name;
                $this->send_email($to, $subject, $message);

                // Redirect to thankyou page
                redirect('/users/thankyou');
            }
            else
            {
                // Create user document folder
	            $user_directory = "assets/cms/uploads/userdownloads/{$this->users_model->id}";

	            if ( ! is_dir($user_directory))
	            {
	                mkdir($user_directory);
	                chmod($user_directory, 0777);
	            }

	            // Log the user in
	            $this->users_model->create_session();

	            // Redirect to user dashboard
	            redirect('/users/dashboard');
            }
        }

        // Load the states
        $data['states'] = unserialize(STATES);

        // Render the view
        $this->template->view('/users/register', $data);
    }


    public function activate()
    {
    	$data = array();

        // Check that user email activation is enabled
        if ( ! $this->settings->users_module->email_activation)
        {
            return show_404();
        }

        // Check all needed parameters have been supplied
        $user_id = $this->uri->segment(3);
        $activation_code = $this->uri->segment(4);

        if ( ! $user_id ||  ! $activation_code)
        {
            return show_404();
        }

        // Lookup user by id and activation code
        $this->load->model('users_model');

        $data['User'] = $User = $this->users_model
            ->where('id', $user_id)
            ->where('activation_code', $activation_code)
            ->get();

        // Show 404 if user not found
        if ( ! $User->exists())
        {
            return show_404();
        }

        $data['new_activation'] = FALSE;

        if ( ! $User->activated)
        {
        	$data['new_activation'] = TRUE;

            $User->activated = 1;
            $User->save();

            // Create user document folder
            $user_directory = "assets/cms/uploads/userdownloads/{$User->id}";

            if ( ! is_dir($user_directory))
            {
                mkdir($user_directory);
                chmod($user_directory, 0777);
            }
        }

        // Render the view
        $this->template->view('/users/activate', $data);
    }


    public function thankyou()
    {
    	$data = array();

        // Render the view
        $this->template->view('/users/registration_thank_you', $data);
    }


	public function dashboard()
    {
    	// Ensure the user is logged in
        if ( ! isset($_SESSION['user_session']))
        {
            redirect('users/login');
        }

        // Load the user
        $this->load->model('users_model');
		$User = $this->users_model->where("id = ".$_SESSION['user_session']->id)->get();

        // Get the users documents
        $location = "assets/cms/uploads/userdownloads/{$User->id}/";
        $documents = $this->get_documents($location);

        // Render the documents
        $document_tree = $this->render_tree($documents);
        $data['documents'] = ($document_tree) ? $document_tree : '<p>No documents found.</p>';

        // Render the view
        $this->template->view('/users/dashboard', $data);
	}


    public function logout()
    {
        $this->load->model('users_model');

        // Check if current user was an admin logged in as another user
        if (isset($this->secure->get_user_session()->admin_id))
        {
            $this->users_model->get_by_id($this->secure->get_user_session()->admin_id);

            // Return to admin session
            if ($this->users_model->exists())
            {
                $this->users_model->create_session();
                redirect(ADMIN_PATH);
            }
        }

        // Delete all session data
        $this->session->sess_destroy();
        $this->users_model->destroy_remember_me();

        // Redirect to home page
        redirect('/');
    }


    /* Form Validation callback to check that the provided email address exists. */
    public function email_exists($email)
    {
        $this->load->model('users_model');
        $User = $this->users_model->where("email = '$email'")->get();

        if ( ! $User->exists())
        {
            $this->form_validation->set_message('email_exists', "The email address $email was not found.");
            return FALSE;
        }
        else
        {
            $_POST['user'] = $User;
            return TRUE;
        }
    }


    /* Form Validation callback to check if an email address is already in use. */
    public function email_check($email)
    {
        $this->load->model('users_model');
        $User = $this->users_model->where("email = '$email'")->get();

        if ($User->exists())
        {
            $this->form_validation->set_message('email_check', "This email address is already in use.");
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }


    /* Send am E-mail. */
    private function send_email($to, $subject, $message)
    {
    	$from_email = 'noreply@' . domain_name();
    	$from_name = $this->settings->site_name;

		$this->email->from($from_email, $from_name);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);

		$this->email->send();
    }


	/* Load an array of documents from the given location. */
    private function get_documents($location)
    {
        $documents = array();

        $skip = array('.', '..', '.svn');

        if (@$dp = opendir($location))
        {
            while (false !== ($entry = readdir($dp)))
            {
                if ((is_dir($location . $entry)) && ( ! in_array($entry, $skip)))
                {
                    // Folder
                    $folder_path = "{$location}{$entry}/";

                    $documents[] = array(
                        'dir' => true,
                        'name' => $entry,
                        'path' => $this->get_documents($folder_path)
                    );
                }
                elseif ((is_file($location . $entry)) && ( ! in_array($entry, $skip)))
                {
                    // File
                    $documents[] = array(
                        'dir' => false,
                        'name' => $entry,
                        'path' => "/{$location}{$entry}",
                    );
                }
            }

            closedir($dp);
        }

        sort($documents);
        return $documents;
    }


	/* Render a directory tree from the given document array. */
    private function render_tree($tree, $parent = true)
    {
        $html = '';

        if ($tree)
        {
	        $html .= ($parent) ? '<ul>' : '<ul style="display: none;">';

	        foreach ($tree as $node)
	        {
	            if ($node['dir'])
	            {
	                $name = $node['name'];
	                $branch = $node['path'];

	                // Folder
	                $html .= "<li>";
	                $html .= "<div class='folder'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span> {$name}</div>";
	                $html .= $this->render_tree($branch, false);
	                $html .= "</li>";
	            }
	            else
	            {
	                $name = $node['name'];
	                $path = $node['path'];

	                // File
	                $html .= "<li class='list-group-item'>";
	                $html .= "<a href='{$path}' target='_blank'><span class='glyphicon glyphicon-file' aria-hidden='true'></span> {$name}</a>";
	                $html .= "</li>";
	            }
	        }

	        $html .= '</ul>';
        }

        return $html;
    }

}
