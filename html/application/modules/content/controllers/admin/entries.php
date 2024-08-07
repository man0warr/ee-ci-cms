<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Entries extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
	}

    // ------------------------------------------------------------------------

    /*
     * Index
     *
     * Display entries and apply any search filters

     * @return void
     */
	function index()
	{
        $data = array();
        $data['breadcrumb'] = set_crumbs(array(current_url() => 'Entries'));

        // Load libraries and models
        $this->load->model('entries_model');
        $this->load->model('content_types_model');
        $this->load->model('entry_revisions_model');
        $this->load->library('pagination');
        $data['query_string'] = ( ! empty($_SERVER['QUERY_STRING'])) ? '?' . $_SERVER['QUERY_STRING'] : '';
        $data['content_types_filter'] = array('' => '');
        $data['content_types_add_entry'] = array();

        // Process Filter using Admin Helper
        $filter = process_filter('entries');

        // Define fields the search filter searches
        $search = array();

        if (isset($filter['search']))
        {
            $search['title'] = $filter['search'];
            $search['slug'] = $filter['search'];
            $search['id'] = $filter['search'];
            unset($filter['search']);
        }

        // Pagination Settings
        $per_page = 50;

        // If user not a super admin only get the content types and entires allowed for access
        if ($this->Group_session->type != SUPER_ADMIN)
        {
            $this->content_types_model
                ->where('restrict_admin_access', 0)
                ->or_where_related('admin_groups', 'group_id', $this->Group_session->id);

            $this->entries_model
                ->group_start()
                ->where('restrict_admin_access', 0)
                ->or_where_related('content_types/admin_groups', 'group_id', $this->Group_session->id)
                ->group_end();
        }

        // Build content type filter dropdown
        // and add entry's list of content types
        $Content_types = $this->content_types_model->order_by('title', 'asc')->get();

        foreach($Content_types as $Content_type)
        {
            $entries_count = $Content_type->entries->count();

            // Only add the content type to the Add Entry dropdown if it has not reached the
            // limit of entries allowed. An empty entries_allowed is unlimited
            if ($Content_type->entries_allowed == '' ||  $entries_count < $Content_type->entries_allowed || ($entries_count == 0 && $Content_type->entries_allowed > 0))
            {
                $data['content_types_add_entry'][$Content_type->id] = $Content_type->title;
            }

            // Only add the content type to the filter dropdown if it has one or more entries
            if ($entries_count > 0)
            {
                $data['content_types_filter'][$Content_type->id] = $Content_type->title;
            }
        }

        $this->entries_model->include_related('content_types', 'title');

        // Filter by search string
        if ( ! empty($search))
        {
            $this->entries_model
                ->group_start()
                ->or_like($search)
                ->group_end();
        }

        // Filter by dropdowns
        if ( ! empty($filter))
        {
            $this->entries_model
                ->group_start()
                ->where($filter)
                ->group_end();
        }

        // Finalize and sort entries query
        $data['Entries'] = $this->entries_model
            ->order_by(($this->input->get('sort')) ? $this->input->get('sort') : 'modified_date', ($this->input->get('order')) ? $this->input->get('order') : 'desc')
            ->get_paged($this->uri->segment(5), $per_page, TRUE);

        // Create Pagination
        $config['base_url'] = site_url(ADMIN_PATH . '/content/entries/index/');
        $config['total_rows'] = $data['Entries']->paged->total_rows;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = '5';
        $config['num_links'] = 5;
        $config['suffix'] = $data['query_string'];
        $this->pagination->initialize($config);


        $this->template->view('admin/entries/entries', $data);
	}

    // ------------------------------------------------------------------------

    /*
     * Edit
     *
     * Add and edit entries

     * @return void
     */
    function edit()
    {
        // Init
        $data = array();
        $data['edit_mode'] = $edit_mode = FALSE;
        $data['breadcrumb'] = set_crumbs(array('content/entries' => 'Entries', current_url() => 'Entry Edit'));

        $data['content_type_id'] = $content_type_id = $this->uri->segment(5);
        $data['entry_id'] = $entry_id = $this->uri->segment(6);
        $data['revision_id'] = $revision_id = $this->uri->segment(7);

        // Get entry
        $this->load->model('users/users_model');
        $this->load->model('entries_model');
        $this->load->model('content_types_model');

        // Used for content types dropdown
        $Content_types_model = new Content_types_model();

        // If user not a super admin check if user's group is allowed access
        if ($this->Group_session->type != SUPER_ADMIN)
        {
            $this->content_types_model
                ->group_start()
                ->where('restrict_admin_access', 0)
                ->or_where_related('admin_groups', 'group_id', $this->Group_session->id)
                ->group_end();

            $this->entries_model
                ->group_start()
                ->where('restrict_admin_access', 0)
                ->or_where_related('content_types/admin_groups', 'group_id', $this->Group_session->id)
                ->group_end();

            // Only get Content Types user has access to for dropdown
            $Content_types_model->group_start()
                ->where('restrict_admin_access', 0)
                ->or_where_related('admin_groups', 'group_id', $this->Group_session->id)
                ->group_end();

        }

        $data['Entry'] = $Entry = $this->entries_model->get_by_id($entry_id);
        $data['Content_type'] = $Content_type = $this->content_types_model->get_by_id($content_type_id);

        // Load content fields library
        $config['Entry'] = $Entry;
        $config['content_type_id'] = $content_type_id;

        $this->load->add_package_path(APPPATH . 'modules/content/content_fields');
        $Content_fields = $this->load->library('content_fields');
        $Content_fields->initialize($config);

        // Check if versioning is enabled an wheater a revision is loaded
        if ($Content_type->enable_versioning && is_numeric($revision_id))
        {
            $Revision = new Entry_revisions_model();
            $Revision->get_by_id($revision_id);

            if ($Revision->exists())
            {
                $revision_data = @unserialize($Revision->revision_data);

                // Update Entry and Entrys data data from revision
                // Entries data gets queiried in the content_fields library initialize
                // Thank God for pass by reference
                if (is_array($revision_data))
                {
                    $Entry->from_array($revision_data);
                    $Entry->entries_data->from_array($revision_data);
                }
            }
        }

        // Get content types for the setting's
        // content type dropdown
        $Change_content_types = $Content_types_model->where('id !=', $content_type_id)->order_by('title')->get();
        $data['change_content_types'] = array('' => '');

        foreach($Change_content_types as $Change_content_type)
        {
            $entries_count = $Change_content_type->entries->count();

            // Only add the content type to the Add Entry dropdown if it has not reached the
            // limit of entries allowed. An empty entries_allowed is unlimited
            if ($Change_content_type->entries_allowed == '' ||  $entries_count < $Change_content_type->entries_allowed || ($entries_count == 0 && $Change_content_type->entries_allowed > 0))
            {
                $data['change_content_types'][$Change_content_type->id] = $Change_content_type->title;
            }
        }

        // Get Admins and Super Admins for the setting's
        // author dropdown
        $Users = $this->users_model->where_in_related('groups', 'type', array(SUPER_ADMIN, ADMINISTRATOR))->order_by('first_name')->get();
        $data['authors'] = array('' => '');
        foreach ($Users as $User)
        {
            $data['authors'][$User->id] = $User->full_name();
        }

        // Validate that the content type exists
        if ( ! $Content_type->exists())
        {
            return show_404();
        }

        if ($Entry->exists())
        {
            // Check that url content_type_id and entry content_type_id match
            if ($Entry->content_type_id != $content_type_id && ! $revision_id)
            {
                return show_404();
            }

            $data['edit_mode'] = $edit_mode = TRUE;
        }

        // Form Validation Rules
        if ($edit_mode)
        {
            $this->form_validation->set_rules('slug', 'URL', 'trim|max_length[255]|callback_unique_slug_check[' . addslashes($Entry->slug) . ']');
        }
        else
        {
            $this->form_validation->set_rules('slug', 'URL', 'trim|max_length[255]|callback_unique_slug_check');
        }

        $this->form_validation->set_rules('meta_title', 'Meta Title', 'trim');
        $this->form_validation->set_rules('meta_description', 'Meta Description', 'trim');
        $this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'trim');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_rules('title', 'Entry Title', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('created_date', 'Date Created', 'trim|required');

        // Validate url title if content type has a dynamic route
        if ($Content_type->dynamic_route != '')
        {
            $this->form_validation->set_rules('url_title', 'URL Title', 'trim|required|alpha_dash|max_length[100]|is_unique[entries.url_title' . (($edit_mode) ? '.id.' . $Entry->id : '') . ']');
        }

        // Get content fields html
        $field_validation = $Content_fields->run();

        // Validation and process form
        if ($this->form_validation->run() == TRUE && $field_validation)
        {
            // Populate from post and prep for insert / update
            $Entry->from_array($this->input->post());
            $Entry->modified_date = date('Y-m-d H:i:s');
            $Entry->created_date = date('Y-m-d H:i:s', strtotime($this->input->post('created_date')));
            $Entry->slug = ($this->input->post('slug') != '') ? $this->input->post('slug') : NULL;
            $Entry->url_title = ($this->input->post('url_title') != '') ? $this->input->post('url_title') : NULL;
            $Entry->meta_title = ($this->input->post('meta_title') != '') ? $this->input->post('meta_title') : NULL;
            $Entry->meta_description = ($this->input->post('meta_description') != '') ? $this->input->post('meta_description') : NULL;
            $Entry->meta_keywords = ($this->input->post('meta_keywords') != '') ? $this->input->post('meta_keywords') : NULL;
            $Entry->content_type_id = $content_type_id;
            $Entry->author_id = ($this->input->post('author_id') != '') ? $this->input->post('author_id') : NULL;

            // Ensure the id wasn't overwritten by an id in the post
            if ($edit_mode)
            {
                $Entry->id = $entry_id;
            }

            $Entry->save();

            // Save field data to entries_data
            $Content_fields->save();

            // Add Revision if versioing enabled
            if ($Content_type->enable_versioning)
            {
                // Delete old revsions so that not to exceed max revisions setting
                $Revision = new Entry_revisions_model();
                $Revision->where('entry_id', $entry_id)
                    ->order_by('id', 'desc')
                    ->limit(25, $Content_type->max_revisions - 1)
                    ->get()
                    ->delete_all();

                // Serialize and save post data to entry revisions table
                $User = $this->secure->get_user_session();
                $Revision = new Entry_revisions_model();
                $Revision->entry_id = $Entry->id;
                $Revision->content_type_id = $Entry->content_type_id;
                $Revision->author_id = $User->id;
                $Revision->author_name = $User->first_name . ' ' . $User->last_name;
                $Revision->revision_date = date('Y-m-d H:i:s');
                $Revision->revision_data = serialize($this->input->post());
                $Revision->save();
            }

            // Clear cache so updates will show on next page load
            $this->load->library('cache');
            $this->cache->delete_all('entries');

            // Clear navigation cache so updates will show on next page load
            $this->load->library('navigations/navigations_library');
            $this->navigations_library->clear_cache();

            // Set a success message
            $this->session->set_flashdata('message', '<p class="success">Changes Saved.</p>');

            // Deteremine where to redirect user
            if ($this->input->post('save_exit'))
            {
                redirect(ADMIN_PATH . "/content/entries");
            }
            else
            {
                redirect(ADMIN_PATH . "/content/entries/edit/" . $Entry->content_type_id . "/" . $Entry->id);
            }
        }


        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;
        $_SESSION['isLoggedIn'] = true;

        // Field form needs to be built after running form_validation->run()
        $data['Fields'] = $Content_fields->form();

        $this->template->view('admin/entries/edit', $data);
    }

    // ------------------------------------------------------------------------

    /*
     * Delete
     *
     * Delete entries and data associated to it

     * @return void
     */
    function delete()
    {
        $this->load->helper('file');
        $this->load->model('entries_model');

        if ($this->input->post('selected'))
        {
            $selected = $this->input->post('selected');
        }
        else
        {
            $selected = (array) $this->uri->segment(5);
        }

        $Entries = new Entries_model();
        $Entries->where_in('id', $selected)->get();

        if ($Entries->exists())
        {
            $message = '';
            $entries_deleted = FALSE;
            $entries_required = FALSE;
            $this->load->model('navigations/navigation_items_model');

            foreach($Entries as $Entry)
            {
                if ($Entry->id == $this->settings->content_module->site_homepage)
                {
                    $message .= '<p class="error">Entry ' . $Entry->title . ' (#' . $Entry->id . ') is set as the site homepage and cannot be deleted.</p>';
                }
                else if ($Entry->id == $this->settings->content_module->custom_404)
                {
                    $message .= '<p class="error">Entry ' . $Entry->title . ' (#' . $Entry->id . ') is set as the custom 404 and cannot be deleted.</p>';
                }
                else if ($Entry->required)
                {
                    $message .= '<p class="error">Entry ' . $Entry->title . ' (#' . $Entry->id . ') is required by the system and cannot be deleted.</p>';
                }
                else
                {
                    // Remove the entry from navigations
                    $Navigation_items = new Navigation_items_model();
                    $Navigation_items->where('entry_id', $Entry->id)->get();
                    $Navigation_items->delete_all();

                    $Entries_data = $Entry->entries_data->get();
                    $Entries_data->delete_all();

                    $Entry_revisions = $Entry->entry_revisions->get();
                    $Entry_revisions->delete_all();

                    $Entry->delete();
                    $entries_deleted = TRUE;
                }
            }

            if ($entries_deleted)
            {
                // Clear cache so updates will show on next entry load
                $this->load->library('cache');
                $this->cache->delete_all('entries');

                // Clear navigation cache so updates will show on next page load
                $this->load->library('navigations/navigations_library');
                $this->navigations_library->clear_cache();

                $message .= '<p class="success">The selected items were successfully deleted.</p>';
            }

            $this->session->set_flashdata('message', $message);
        }

        redirect(ADMIN_PATH . '/content/entries');
    }

    // ------------------------------------------------------------------------

    /*
     * Links
     *
     * Used by TinyMCE to build a list of of pages and get their URL

     * @return void
     */
	function links() {
        header('Content-type: text/javascript');

        $Entries = $this->load->model('content/entries_model');
        $Entries->where('status', 'published')
            ->where('slug !=', 'NULL')
            ->or_where('id =', $this->settings->content_module->site_homepage)
            ->order_by('title')
            ->get();

        $output = "var tinyMCELinkList = new Array(";

        foreach($Entries as $Entry)
        {
            $output .= "['$Entry->title', '{{ content:entry_url entry_id=\'$Entry->id\' }}'],";
        }

        $output = rtrim($output, ',');

        $output .= ");";

        echo $output;
	}

    // ------------------------------------------------------------------------

    /*
     * CSS
     *
     * Called by CKEditor and TinyMCE for custom styles

     * @return void
     */
    function css()
    {
        $this->load->model('entries_model');
        $entry_id = $this->uri->segment(5);
        $Entry = $this->entries_model->get_by_id($entry_id);

        if ( ! $Entry->exists())
        {
            return show_404();
        }

        $css = @file_get_contents(site_url('themes/' . $this->settings->theme . '/' . trim($this->settings->editor_stylesheet, '/'))) . "\n";

        if ($Entry->content_types->get()->exists())
        {
            $css .= $Entry->content_types->css . "\n\n";
        }

        header('Content-type: text/css');

        echo $css;
    }

    // ------------------------------------------------------------------------

    /*
     * Unique Slug Check
     *
     * Used to validate that the slug is a valid URL
     * and is unique in the database

     * @return bool or string
     */
    function unique_slug_check($slug, $current_slug = '')
    {
        $slug = trim($slug, '/');

        $regex = "((https?|ftp)\:\/\/)?"; // SCHEME
        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass
        $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP
        $regex .= "(\:[0-9]{2,5})?"; // Port
        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path
        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query
        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor

        if (preg_match("/^$regex$/", base_url() . $slug))
        {
            $Entries = new Entries_model();
            $Entries->get_by_slug($slug);

            if ($Entries->exists() && $slug != stripslashes($current_slug))
            {
                $this->form_validation->set_message('unique_slug_check', 'This %s provided is already in use.');
                return FALSE;
            }
            else
            {
                return $slug;
            }
        }
        else
        {
            $this->form_validation->set_message('unique_slug_check', 'The %s provided is not valid.');
            return FALSE;
        }
    }

    // ------------------------------------------------------------------------

    /*
     * Create Thumb
     *
     * Called by AJAX to create thumbnails of selected images
     *
     * @return void
     */
    function create_thumb()
    {
        if ( ! is_ajax())
        {
            return show_404();
        }

        if ($this->input->post('image_path'))
        {
            echo image_thumb($this->input->post('image_path'), 150, 150, FALSE, array('no_image_image' => ADMIN_NO_IMAGE));
        }
    }
}

