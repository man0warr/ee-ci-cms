<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mediabox_id_field extends Field_type
{
    function view($data)
    {
        // Get all entries for link dropdown
        $this->load->model('mediaboxes/mediaboxes_model');

        $Mediaboxes = new Mediaboxes_model();
        $Mediaboxes->order_by('title')->get();

        $mediabox_array = array('' => '');

        foreach($Mediaboxes as $Mediabox)
        {
            $mediabox_array[$Mediabox->id] = $Mediabox->title;
        }

        $data['Mediaboxes'] = $mediabox_array;

        return $this->load->view('mediaboxes', $data, TRUE);
    }
}
