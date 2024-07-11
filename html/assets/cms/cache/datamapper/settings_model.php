<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'settings',
  'fields' => 
  array (
    0 => 'id',
    1 => 'slug',
    2 => 'value',
    3 => 'module',
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
    'slug' => 
    array (
      'field' => 'slug',
      'rules' => 
      array (
      ),
    ),
    'value' => 
    array (
      'field' => 'value',
      'rules' => 
      array (
      ),
    ),
    'module' => 
    array (
      'field' => 'module',
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