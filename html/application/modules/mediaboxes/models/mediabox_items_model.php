<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mediabox_items_model extends DataMapper
{
    public $table = "mediabox_items";

    public $has_one = array(
        'mediaboxes' => array(
            'class' => 'mediaboxes_model',
            'other_field' => 'mediabox_items',
            'join_self_as' => 'mediabox_item',
            'join_other_as' => 'mediabox',
        ),
    );

}
