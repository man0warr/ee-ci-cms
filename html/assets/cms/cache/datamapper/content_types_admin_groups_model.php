<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'content_types_admin_groups',
  'fields' => 
  array (
    0 => 'id',
    1 => 'content_type_id',
    2 => 'group_id',
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
    'content_type_id' => 
    array (
      'field' => 'content_type_id',
      'rules' => 
      array (
      ),
    ),
    'group_id' => 
    array (
      'field' => 'group_id',
      'rules' => 
      array (
      ),
    ),
    'content_types' => 
    array (
      'field' => 'content_types',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'content_types' => 
    array (
      'class' => 'content_types_model',
      'other_field' => 'admin_groups',
      'join_other_as' => 'content_type',
      'join_self_as' => 'admin_groups',
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