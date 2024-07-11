<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class General_settings extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $data = array();
        $data['breadcrumb'] = set_crumbs(array(current_url() => 'General Settings'));

        $this->load->model('settings/settings_model');
        $this->load->model('users/groups_model');
        $this->load->model('content/entries_model');

        // Read the environment variable
        $data['development_mode'] = (ENVIRONMENT == 'development') ? TRUE : FALSE;

        // Get Themes
        $data['themes'] = $this->template->get_themes();
        $data['layouts'] = $this->template->get_theme_layouts();

        // Get Groups
        $Groups = new Groups_model();
        $data['Groups'] = $Groups->where('type !=', 'super_admin')->order_by('name')->get();

        // Get All Entries
        $Entries = new Entries_model();
        $data['Entries'] = $Entries->order_by('title')->get();

        // Build object with current settings
        $Settings_table = $this->settings_model->get();

        $data['Settings'] = new stdClass();

        foreach ($Settings_table as $Setting)
        {
            $data['Settings']->{$Setting->slug} = new stdClass();
            $data['Settings']->{$Setting->slug}->value = $Setting->value;
            $data['Settings']->{$Setting->slug}->module = $Setting->module;
        }

        // Define the initial version number
        if ($data['Settings']->cms_version->value)
        {
            $data['initial_cms_version'] = ($data['Settings']->version_modified->value) ? "{$data['Settings']->cms_version->value}+" : $data['Settings']->cms_version->value;
        }
        else
        {
            $data['initial_cms_version'] = '';
        }

        // Get any enabled add-on modules
        $this->load->model('settings/module_addons_model');
        $data['Module_addons_enabled'] = $this->module_addons_model->get_all_module_addons();

        // Form Validation Rules
        if ($data['development_mode'])
        {
        	$this->form_validation->set_rules('developers_email', 'Developers Email', 'trim|required|valid_email');
        	$this->form_validation->set_rules('use_developers_email', 'Development Mode', 'trim|required');
        }

        $this->form_validation->set_rules('site_name', 'Site Name', 'trim|required');
        $this->form_validation->set_rules('notification_email', 'Notification Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('content[site_homepage]', 'Site Homepage', 'trim|required');
        $this->form_validation->set_rules('content[custom_404]', 'Custom 404', 'trim|required');
        $this->form_validation->set_rules('theme', 'Theme', 'trim|required');
        $this->form_validation->set_rules('layout', 'Default Layout', 'trim|required');

        $this->form_validation->set_rules('users[default_group]', 'Default User Group', 'trim|required');
        $this->form_validation->set_rules('users[enable_registration]', 'User Registration', 'trim|required');
        $this->form_validation->set_rules('users[email_activation]', 'Require Email Activation', 'trim|required');

        // Form Processing
        if ($this->form_validation->run() == TRUE)
        {
            // checkboxes don't send a 0, so clear it here
            if (! $this->input->post('version_modified'))
            {
                $Settings_m = new Settings_model();
                $Settings_m->where('slug', 'version_modified')->update('value', 0);
            }
            if (! $this->input->post('disable_comments'))
            {
                $Settings_m = new Settings_model();
                $Settings_m->where('slug', 'disable_comments')->update('value', 0);
            }
            if (! $this->input->post('search_content_types'))
            {
                $Settings_m = new Settings_model();
                $Settings_m->where('slug', 'search_content_types')->update('value', 0);
            }

            foreach ($_POST as $slug => $value)
            {
                if ($slug == "module")
                {
                    foreach ($value as $module_slug => $module_value)
                    {
                        // Strip off the first 3 chars, leaving the module id. (id_nnn)
                        $module_id = (int)substr($module_slug, 3);

                        // Save the state of the module.
                        $this->module_addons_model->set_module_state($module_id, $module_value);
                    }
                }
                else
                {
                    // settings
                    if (is_array($value))
                    {
                        // Value is an array so save it as a module setting
                        foreach ($value as $module_slug => $module_value)
                        {
                            $Settings_m = new Settings_model();
                            $Settings_m->where('slug', $module_slug)->where('module', $slug)->update('value', $module_value);
                        }
                    }
                    else
                    {
                        $Settings_m = new Settings_model();
                        $Settings_m->where('slug', $slug)->where('module IS NULL')->update('value', $value);
                    }
                    unset($Settings_m);
                }
            }

            $this->load->library('cache');
            $this->cache->delete_all('settings');

            $this->session->set_flashdata('message', '<p class="success">Settings Saved.</p>');
            redirect(uri_string());
        }

        $this->template->view('admin/general_settings', $data);
    }

    function theme_ajax()
    {
        if ( ! is_ajax())
        {
            return show_404();
        }

        $data['status'] = 'OK';

        if ($theme = $this->input->post('theme'))
        {
            $layouts = $this->template->get_theme_layouts($theme);

            if (empty($layouts))
            {
                $data['status'] = 'ERROR';
                $data['message'] = 'No layouts found';
            }
        }
        else
        {
            $data['status'] = 'ERROR';
            $data['message'] = 'No theme was specified';
        }

        $data['layouts'] = $layouts;

        echo  json_encode($data);
    }
}

