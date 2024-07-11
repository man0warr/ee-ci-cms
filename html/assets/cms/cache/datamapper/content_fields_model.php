<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'content_fields',
  'fields' => 
  array (
    0 => 'id',
    1 => 'content_type_id',
    2 => 'content_field_type_id',
    3 => 'label',
    4 => 'short_tag',
    5 => 'required',
    6 => 'options',
    7 => 'settings',
    8 => 'sort',
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
    'content_field_type_id' => 
    array (
      'field' => 'content_field_type_id',
      'rules' => 
      array (
      ),
    ),
    'label' => 
    array (
      'field' => 'label',
      'rules' => 
      array (
      ),
    ),
    'short_tag' => 
    array (
      'field' => 'short_tag',
      'rules' => 
      array (
      ),
    ),
    'required' => 
    array (
      'field' => 'required',
      'rules' => 
      array (
      ),
    ),
    'options' => 
    array (
      'field' => 'options',
      'rules' => 
      array (
      ),
    ),
    'settings' => 
    array (
      'field' => 'settings',
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
    'content_types' => 
    array (
      'field' => 'content_types',
      'rules' => 
      array (
      ),
    ),
    'content_field_types' => 
    array (
      'field' => 'content_field_types',
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
      'other_field' => 'content_fields',
      'join_self_as' => 'content_field',
      'join_other_as' => 'content_type',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'content_field_types' => 
    array (
      'class' => 'content_field_types_model',
      'other_field' => 'content_fields',
      'join_other_as' => 'content_field_type',
      'join_self_as' => 'content_fields',
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