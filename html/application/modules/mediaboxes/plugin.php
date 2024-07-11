<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mediaboxes_plugin extends Plugin
{
    public $mediaboxes = array();

    /*
     * Media Boxes
     *
     * Builds an array of mediaboxes
     *
     * @return array
     */
    public function mediaboxes()
    {
        $this->build_mediaboxes_array();

        return $this->mediaboxes;
    }

    // ------------------------------------------------------------------------

    /*
     * Build Media Boxes Array
     *
     * Queries and builds array of mediaboxes
     *
     * @access private
     * @return void
     */
    private function build_mediaboxes_array()
    {
    	// Load Mediaboxes
        $this->Mediaboxes = $this->load->model('mediaboxes_model');

        $this->Mediaboxes->get_by_id($this->attribute('mediabox_id'));

        if ( ! $this->Mediaboxes->exists())
        {
            return;
        }

        // Filter based on given limits
        if ($this->attribute('limit_offset') && $this->attribute('limit'))
        {
        	$Items = $this->Mediaboxes->mediabox_items->where('hide', 0)->order_by('sort', 'ASC')->limit($this->attribute('limit'), $this->attribute('limit_offset'))->get();
        }
        else if ($this->attribute('limit'))
        {
        	$Items = $this->Mediaboxes->mediabox_items->where('hide', 0)->order_by('sort', 'ASC')->limit($this->attribute('limit'))->get();
        }
        else
        {
        	$Items = $this->Mediaboxes->mediabox_items->where('hide', 0)->order_by('sort', 'ASC')->get();
        }

        $count = 0;

        foreach($Items as $Item)
        {
            $count++;

            // Determine the link URL from the lint type
            if ($Item->link_type == 'INTERNAL')
            {
            	$link_url = site_url($Item->link_internal);
            }
            else if ($Item->link_type == 'EXTERNAL')
            {
            	$link_url = $Item->link_external;
            }
            else if ($Item->link_type == 'IMAGE')
            {
            	$link_url = $Item->image_path;
            }
            else if ($Item->link_type == 'FILE')
            {
            	$link_url = $Item->link_file;
            } else {
            	$link_url = '';
            }

            $this->mediaboxes[] = array(
                'title'       => $Item->title,
                'subtitle'    => $Item->subtitle,
                'text_1'      => $Item->text_1,
                'text_2'      => $Item->text_2,
                'image'  	  => $Item->image_path,
                'alt'   	  => $Item->image_alt,
            	'description' => $Item->description,
            	'link_url'    => $link_url,
                'link_target' => $Item->link_target,
            	'link_type'   => $Item->link_type,
                'count'       => $count
            );
        }
    }

}