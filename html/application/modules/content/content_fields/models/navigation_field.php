<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Navigation_field extends Field_type
{
    function view($data)
    {
        // Get all navigations for link dropdown
        $this->load->model('navigations/navigations_model');

        $Navigations = new Navigations_model();
        $Navigations->order_by('id')->get();

        $Navigation_array = array('' => '');

        foreach($Navigations as $Navigation)
        {
            $Navigation_array[$Navigation->id] = $Navigation->title;
        }

        $data['Navigations'] = $Navigation_array;

        return $this->load->view('navigation', $data, TRUE);
    }
}
