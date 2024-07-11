<?php
    // Define the basic navigation structure.
    $nav_array_basic = array(
        'Dashboard' => array(
            'title' => 'Dashboard',
            'url'   => '/',
            'id'    => 'dashboard',
            'sub'   => array(),
        ),
        'Content' => array(
            'title' => 'Content',
            'url'   => 'content/entries',
            'sub'   => array(
                    array(
                        'title' => 'Entries',
                        'url'   => 'content/entries',
                    ),
                    array(
                        'title' => 'Navigations',
                        'url'   => 'navigations',
                    ),
                    array(
                        'title' => 'Galleries',
                        'url'   => 'galleries',
                    ),
                    array(
                        'title' => 'Media Boxes',
                        'url'   => 'mediaboxes',
                    ),
                ),
        ),
        'Users' => array(
            'title' => 'Users',
            'url'   => 'users',
            'sub'   => array(
                    array(
                        'title' => 'Users',
                        'url'   => 'users',
                    ),
                    array(
                        'title' => 'User Documents',
                        'url'   => 'users/user-documents',
                    ),
                    array(
                        'title' => 'User Groups',
                        'url'   => 'users/groups',
                    ),
                ),
        ),
        'Tools' => array(
            'title' => 'Tools',
            'url'   => 'content/types',
            'sub'   => array(
                    array(
                        'title' => 'Content Types',
                        'url'   => 'content/types',
                    ),
                    array(
                        'title'  => 'Content Fields',
                        'url'    => 'content/fields',
                        'hidden' => TRUE, // Used for selected parents for this section
                    ),
                    array(
                        'title' => 'Code Snippets',
                        'url'   => 'content/snippets',
                    ),
                    array(
                        'title' => 'Manage Uploaded Files',
                        'url'   => 'settings/manage-uploaded-files',
                    ),
                    array(
                        'title' => 'Theme Editor',
                        'url'   => 'settings/theme-editor',
                    ),
                ),
        ),
        'System' => array(
            'title' => 'System',
            'url'   => 'settings/general-settings',
            'sub'   => array(
                    array(
                        'title' => 'General Settings',
                        'url'   => 'settings/general-settings',
                    ),
                    array(
                        'title' => 'Clear Cache',
                        'url'   => 'settings/clear-cache',
                    ),
                    array(
                        'title' => 'Server Info',
                        'url'   => 'settings/server-info',
                    ),
                ),
        ),
    );

    // Get any enabled add-on modules
    $this->load->model('settings/module_addons_model');
    $nav_array_addons = $this->module_addons_model->get_module_addons();

    if (isset($nav_array_addons))
    {
        // Merge the navigation addons to the basic navigation sytuctue.
        $nav_array = array_merge_recursive($nav_array_basic, $nav_array_addons);
    }
    else
    {
        // Use the basic navigation sytuctue.
        $nav_array = $nav_array_basic;
    }

    echo admin_nav($nav_array);
?>
