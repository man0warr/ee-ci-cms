<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'groups',
  'fields' => 
  array (
    0 => 'id',
    1 => 'name',
    2 => 'type',
    3 => 'permissions',
    4 => 'required',
    5 => 'modifiable_permissions',
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
    'name' => 
    array (
      'field' => 'name',
      'rules' => 
      array (
      ),
    ),
    'type' => 
    array (
      'field' => 'type',
      'rules' => 
      array (
      ),
    ),
    'permissions' => 
    array (
      'field' => 'permissions',
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
    'modifiable_permissions' => 
    array (
      'field' => 'modifiable_permissions',
      'rules' => 
      array (
      ),
    ),
    'users' => 
    array (
      'field' => 'users',
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
    'users' => 
    array (
      'class' => 'users_model',
      'other_field' => 'groups',
      'join_self_as' => 'group',
      'model_path' => 'application/modules/users',
      'join_other_as' => 'users',
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