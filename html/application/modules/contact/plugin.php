<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Contact Plugin
 *
 * Build and send contact forms
 *
 */
class Contact_plugin extends Plugin
{
    private $default_success_message = "<strong>Thank you for starting the conversation. We look forward to helping you in any way we can!</strong>";

    private $default_contact_form = array(
        'fields' => array(
            'name' => array(
                'label' => 'Name',
                'type'  => 'text',
                'validation'  => 'trim|required',
            ),
            'email' => array(
                'label' => 'Email',
                'type'  => 'text',
                'validation'  => 'trim|required|valid_email',
            ),
            'phone' => array(
                'label' => 'Phone',
                'type'  => 'text',
                'validation'  => 'trim|required',
            ),
            'message' => array(
                'label' => 'Message',
                'type'  => 'textarea',
                'validation'  => 'trim|required',
            ),
            '' => array(
                'label' => '',
                'type' => 'submit',
                'value' => 'Send',
            )
        )
    );


    // ------------------------------------------------------------------------

    /*
     * Form
     *
     * Outputs and sets form validations.
     * If no formatting content specified, the default form will be used
     *
     * @access private
     * @return void
     */
    public function form()
    {
        $content = $this->content();

        $data['file_input'] = '<input type="file" name="userfile" />';
        $data['captcha'] = '<img src="' . site_url('contact/captcha') . '" />';
        $data['captcha_input'] = '<input style="width: 120px;" type="text" name="captcha_input" />';

        $content = $this->parser->parse_string($content, $data, TRUE);

        if ($content)
        {
            /*
             * Custom content was set, wrap content with form tags and add a spam check field
             */

        	if ($this->attribute('file_upload'))
        	{
        		// Multipart form required for file uploads
        		$content = '<form' . (($this->attribute('anchor')) ? ' action="' . current_url() . $this->attribute('anchor') . '"' : '')  . ' enctype="multipart/form-data" method="post"' . ($this->attribute('id') ? ' id="' . $this->attribute('id') . '"' : '') . ($this->attribute('class') ? ' class="' . $this->attribute('class') . '"' : '') . '>' . $content . '<div style="display: none;"><input type="text" name="spam_check" value="" />' . (($this->attribute('id')) ? '<input type="hidden" name="form_id" value="' . $this->attribute('id') . '" />' : '') . '</div></form>';
        	}
        	else
        	{
        		$content = '<form' . (($this->attribute('anchor')) ? ' action="' . current_url() . $this->attribute('anchor') . '"' : '')  . ' method="post"' . ($this->attribute('id') ? ' id="' . $this->attribute('id') . '"' : '') . ($this->attribute('class') ? ' class="' . $this->attribute('class') . '"' : '') . '>' . $content . '<div style="display: none;"><input type="text" name="spam_check" value="" />' . (($this->attribute('id')) ? '<input type="hidden" name="form_id" value="' . $this->attribute('id') . '" />' : '') . '</div></form>';
        	}

            if ($this->attribute('id') == '' || $this->attribute('id') == $this->input->post('form_id'))
            {
                // Repopulate form by default
                if ($this->input->post() && $this->attribute('required'))
                {
                    $content = $this->repopulate_form($content);
                }

                // Set required fields
                if ($this->attribute('required'))
                {
                    foreach(explode('|', $this->attribute('required')) as $name)
                    {
                        // Use the field name to make a label
                        $label = ucwords(str_replace('_', ' ', $name));

                        $this->form_validation->set_rules($name, $label, 'required');
                    }
                }

                // File upload validation
                if ($this->attribute('file_upload'))
                {
                	$this->form_validation->set_rules('userfile', 'Document', 'callback_require_file[userfile]');
                }

                // CAPTCHA validation
                if ($this->attribute('captcha'))
                {
                    $this->form_validation->set_rules('captcha_input', 'CAPTCHA', 'validate_captcha|required');
                }

     			// A theory that spam bots do not read css and will attempt to fill all fields
     			// The form will not submit if the hidden field has been filled
                if ($this->form_validation->run() == TRUE && $this->input->post('spam_check') == '')
                {
                	if ($this->attribute('file_upload'))
                	{
			            // Config CI upload class
			            $config['upload_path'] = "assets/cms/uploads/";
			            $config['allowed_types'] = ($this->attribute('allowed_types')) ? $this->attribute('allowed_types') : '*';
			            $config['overwrite'] = TRUE;

			            $this->load->library('upload', $config);

	                 	// Upload the file to the server
			            if ( ! $this->upload->do_upload('userfile', FALSE))
			            {
			                $content = $this->upload->display_errors('<p class="error">', '</p>') . $content;
			                return array('_content' => $content);
			            }
			            else
			            {
			            	$upload_data = $this->upload->data();
			            	$filepath = $upload_data['full_path'];
			            }
                	}

		            // send an e-mail to admin
		            if ($this->attribute('file_upload'))
		            {
		            	$this->send_email($filepath);

		            	// Remove the uploaded file from the server
		            	unlink($filepath);
		            }
		            else
		            {
		            	$this->send_email();
		            }

		            // Success Feedback
                    if ($this->attribute('success_redirect'))
                    {
                        redirect($this->attribute('success_redirect'));
                    }
                    else
                    {
                        if ($this->attribute('success_message'))
                        {
                            $success_message = $this->attribute('success_message');
                        }
                        else
                        {
                            $success_message = $this->default_success_message;
                        }

                        return $success_message;
                    }
                }

                // Add validation errors to the content
                $content = validation_errors() . $content;
            }

            return array('_content' => $content);
        }
        else
        {
            /*
             * No custom content was set, use the default form
             */

            $data['id'] = $this->attribute('id');
            $data['class'] = $this->attribute('class');
            $data['anchor'] = $this->attribute('anchor');

            $data['Form'] = $this->load->library('formation', $this->default_contact_form);
            $data['Form']->populate();

            if ($this->attribute('id') == '' || $this->attribute('id') == $this->input->post('form_id'))
            {
                if ($data['Form']->validate() == TRUE && $this->input->post('spam_check') == '')
                {
                    $this->send_email();

                    if ($this->attribute('success_redirect'))
                    {
                        redirect($this->attribute('success_redirect'));
                    }
                    else
                    {
                        if ($this->attribute('success_message'))
                        {
                            $success_message = $this->attribute('success_message');
                        }
                        else
                        {
                            $success_message = $this->default_success_message;
                        }

                        return $success_message;
                    }
                }
            }

            // Load view
            return $this->load->view('contact', $data, TRUE);
        }
    }


    // ------------------------------------------------------------------------

    /*
     * Send E-mail
     *
     * Builds and sends email to the specified address
     *
     * @access private
     * @return void
     */
    private function send_email($filename = false)
    {
    	$from_email = $this->attribute('from', 'noreply@' . domain_name());
    	$from_name = $this->attribute('from_name', $this->settings->site_name);
    	$to = $this->attribute('to', $this->settings->notification_email);
    	$subject = $this->attribute('subject', 'Contact Form Submission');
    	$message = '';

        // Build message
        unset($_POST['spam_check']);
        unset($_POST['form_id']);

        foreach($_POST as $field => $value)
        {
            if (is_array($value))
            {
                $message .= ucwords(str_replace('_', ' ', $field)) . ' : ' . "\r\n";

                foreach ($value as $arr_val)
                {
                    $message .= "\t" . $arr_val . "\r\n";
                }
            }
            else
            {
                $message .= ucwords(str_replace('_', ' ', $field)) . ' : ' . $value . "\r\n";
            }
        }

        // Send the email
        $this->load->library('email');

        $this->email->from($from_email, $from_name);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        // attach file if exists
        if ($filename)
        {
            $this->email->attach($filename);
        }

        // Send the notification email
        $this->email->send();

        // Send any additional notification emails
        if (ENVIRONMENT == 'production')
        {
            $additional_emails = explode(',', $this->settings->additional_notification_emails);

            foreach ($additional_emails as $additional_email)
            {
                // Only send emails to valid addresses
                if (strlen($additional_email) > 0 && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $additional_email))
                {
                    $this->email->to($additional_email);
                    $this->email->subject($subject);
                    $this->email->send();
                }
            }
        }
    }


    // ------------------------------------------------------------------------

    /*
     * Repopulate Form
     *
     * Repopulates a custom formatted form
     *
     * @access private
     * @return string
     */
    private function repopulate_form($content)
    {
        $DOM = new DOMDocument;
        @$DOM->loadHTML($content);
        $Xpath = new DOMXPath($DOM);

        // Remove <!DOCTYPE
        $DOM->removeChild($DOM->firstChild);

        // Remove <html><body></body></html>
        $DOM->replaceChild($DOM->firstChild->firstChild->firstChild, $DOM->firstChild);

        // Repopulate Text and Password Inputs
        $inputs = $Xpath->query('//input[@type="text"] | //input[@type="password"]');
        foreach ($inputs as $Input)
        {
            if ($name = $Input->getAttribute('name'))
            {
                $Input->setAttribute('value', $this->input->post($name));
            }
        }

        // Repopulate Radio and Checkbox Inputs
        $inputs = $Xpath->query('//input[@type="radio"] | //input[@type="checkbox"]');
        foreach ($inputs as $Input)
        {
            if ($name = $Input->getAttribute('name'))
            {
                $value = $Input->getAttribute('value');
                if ($this->input->post($name) == $value)
                {
                    $Input->setAttribute('checked', 'checked');
                }
            }
        }

        // Repopulate Textareas
        $textareas = $Xpath->query('//textarea');
        foreach ($textareas as $Textarea)
        {
            if ($name = $Textarea->getAttribute('name'))
            {
                $Textarea->nodeValue = $this->input->post($name);
            }
        }

        // Repopulate Dropdowns
        $options = $Xpath->query('//select/option');
        foreach ($options as $Option)
        {
            if ($name = $Option->parentNode->getAttribute('name'))
            {
                $value = $Option->getAttribute('value');
                if ($this->input->post($name) == $value)
                {
                    $Option->setAttribute('selected', 'selected');
                }
            }
        }

        return $DOM->saveHTML();
    }


    // ------------------------------------------------------------------------

    /*
     * Require File
     *
     * Form Validation callback to check if user profided a file to upload
     */
    private function require_file($userfile, $name)
    {
        if(isset($_FILES[$name]) && $_FILES[$name]['size'] > 0)
        {
            return true;
        }
        else
        {
            $this->form_validation->set_message('require_file', 'The %s field is required.');
            return false;
        }
    }
}
