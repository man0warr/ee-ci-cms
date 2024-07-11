<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mediaboxes_model extends DataMapper
{
    public $table = "mediaboxes";

    public $has_many = array(
        'mediabox_items' => array(
            'class' => 'mediabox_items_model',
            'other_field' => 'mediaboxes',
            'join_self_as' => 'mediabox',
            'join_other_as' => 'mediabox_item',
        ),
    );

}
