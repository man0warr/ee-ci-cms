<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'content_field_types',
  'fields' => 
  array (
    0 => 'id',
    1 => 'title',
    2 => 'model_name',
    3 => 'datatype',
    4 => 'array_post',
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
    'title' => 
    array (
      'field' => 'title',
      'rules' => 
      array (
      ),
    ),
    'model_name' => 
    array (
      'field' => 'model_name',
      'rules' => 
      array (
      ),
    ),
    'datatype' => 
    array (
      'field' => 'datatype',
      'rules' => 
      array (
      ),
    ),
    'array_post' => 
    array (
      'field' => 'array_post',
      'rules' => 
      array (
      ),
    ),
    'content_fields' => 
    array (
      'field' => 'content_fields',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
  ),
  'has_many' => 
  array (
    'content_fields' => 
    array (
      'class' => 'content_fields_model',
      'other_field' => 'content_field_types',
      'join_self_as' => 'content_field_type',
      'join_other_as' => 'content_fields',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
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