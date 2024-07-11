<?php

class Module_addons_model extends CI_Model
{
    private $module_addons = array();
    private $enabled_module_ids = array();


    public function __construct()
    {
        // Get user_id from the session
        $CI =& get_instance();
        $user_id = $CI->secure->get_user_session()->id;

        $query = $this->db->select('id, title, url, parent')
            ->from('module_addons')
            ->join('module_addons_users', 'module_addons.id = module_addons_users.module_addon_id')
            ->where('module_addons_users.user_id =', $user_id)
            ->get();

        // Store any add-on modules in the public array.
        foreach ($query->result() as $Result)
        {
            $this->module_addons[$Result->parent]['sub'][] = array(
                'title' => $Result->title,
                'url' => $Result->url
            );

            $this->enabled_module_ids[] = $Result->id;
        }
    }


    public function get_module_addons()
    {
        return $this->module_addons;
    }


    /* Gets all add-on modules along with their enabled state. */
    public function get_all_module_addons() {

        $all_module_addons = array();

        $query = $this->db->select('id, title, description')
            ->from('module_addons')
            ->get();

        foreach ($query->result() as $Result)
        {
            $id = $Result->id;
            $title = $Result->title;
            $description = $Result->description;

            if (in_array($id, $this->enabled_module_ids) === false) {
                $enabled = 0;
            } else {
                $enabled = 1;
            }

            $all_module_addons[] = array(
                'id' => $id,
                'title' => $title,
                'description' => $description,
                'enabled' => $enabled
            );
        }

        return $all_module_addons;
    }


    /* Update the state of a module. */
    public function set_module_state($module_id, $state)
    {
        // Get user_id from session
        $CI =& get_instance();
        $user_id = $CI->secure->get_user_session()->id;

        $data = array(
            'module_addon_id' => $module_id,
            'user_id' => $user_id
        );

        // Determine if the module was previously enabled.
        if (in_array($module_id, $this->enabled_module_ids) === false) {
            $previously_enabled = false;
        } else {
            $previously_enabled = true;
        }

        if (($state == "ENABLE") && (!$previously_enabled))
        {
            // Enable the module.
            $this->db->insert('module_addons_users', $data);
        }
        else if (($state == "DISABLE") && ($previously_enabled))
        {
            // Disable the module.
            $this->db->delete('module_addons_users', $data);
        }
    }

}
