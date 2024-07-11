<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'navigations',
  'fields' => 
  array (
    0 => 'id',
    1 => 'title',
    2 => 'required',
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
    'required' => 
    array (
      'field' => 'required',
      'rules' => 
      array (
      ),
    ),
    'navigation_items' => 
    array (
      'field' => 'navigation_items',
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
    'navigation_items' => 
    array (
      'class' => 'navigation_items_model',
      'other_field' => 'navigations',
      'join_self_as' => 'navigation',
      'join_other_as' => 'navigation_item',
      'model_path' => 'application/modules/navigations',
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