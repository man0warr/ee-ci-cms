<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'navigation_items',
  'fields' => 
  array (
    0 => 'id',
    1 => 'type',
    2 => 'entry_id',
    3 => 'title',
    4 => 'url',
    5 => 'tag_id',
    6 => 'class',
    7 => 'target',
    8 => 'parent_id',
    9 => 'navigation_id',
    10 => 'subnav_visibility',
    11 => 'hide',
    12 => 'disable_current',
    13 => 'disable_current_trail',
    14 => 'sort',
  ),
  'validation' => 
  array (
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'type' => 
    array (
      'field' => 'type',
      'rules' => 
      array (
      ),
    ),
    'entry_id' => 
    array (
      'field' => 'entry_id',
      'rules' => 
      array (
      ),
    ),
    'title' => 
    array (
      'field' => 'title',
      'rules' => 
      array (
      ),
    ),
    'url' => 
    array (
      'field' => 'url',
      'rules' => 
      array (
      ),
    ),
    'tag_id' => 
    array (
      'field' => 'tag_id',
      'rules' => 
      array (
      ),
    ),
    'class' => 
    array (
      'field' => 'class',
      'rules' => 
      array (
      ),
    ),
    'target' => 
    array (
      'field' => 'target',
      'rules' => 
      array (
      ),
    ),
    'parent_id' => 
    array (
      'field' => 'parent_id',
      'rules' => 
      array (
      ),
    ),
    'navigation_id' => 
    array (
      'field' => 'navigation_id',
      'rules' => 
      array (
      ),
    ),
    'subnav_visibility' => 
    array (
      'field' => 'subnav_visibility',
      'rules' => 
      array (
      ),
    ),
    'hide' => 
    array (
      'field' => 'hide',
      'rules' => 
      array (
      ),
    ),
    'disable_current' => 
    array (
      'field' => 'disable_current',
      'rules' => 
      array (
      ),
    ),
    'disable_current_trail' => 
    array (
      'field' => 'disable_current_trail',
      'rules' => 
      array (
      ),
    ),
    'sort' => 
    array (
      'field' => 'sort',
      'rules' => 
      array (
      ),
    ),
    'navigations' => 
    array (
      'field' => 'navigations',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'navigations' => 
    array (
      'class' => 'navigations_model',
      'other_field' => 'navigation_items',
      'join_self_as' => 'navigation_item',
      'join_other_as' => 'navigation',
      'model_path' => 'application/modules/navigations',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
  ),
  'has_many' => 
  array (
  ),
  '_field_tracking' => 
  array (
    'get_rules' => 
    array (
    ),
    'matches' => 
    array (
    ),
    'intval' => 
    array (
      0 => 'id',
    ),
  ),
);