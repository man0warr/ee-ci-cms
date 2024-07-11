<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'users',
  'fields' => 
  array (
    0 => 'id',
    1 => 'password',
    2 => 'first_name',
    3 => 'last_name',
    4 => 'email',
    5 => 'phone',
    6 => 'address',
    7 => 'address2',
    8 => 'city',
    9 => 'state',
    10 => 'zip',
    11 => 'group_id',
    12 => 'enabled',
    13 => 'activated',
    14 => 'activation_code',
    15 => 'last_login',
    16 => 'created_date',
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
    'password' => 
    array (
      'field' => 'password',
      'rules' => 
      array (
      ),
    ),
    'first_name' => 
    array (
      'field' => 'first_name',
      'rules' => 
      array (
      ),
    ),
    'last_name' => 
    array (
      'field' => 'last_name',
      'rules' => 
      array (
      ),
    ),
    'email' => 
    array (
      'field' => 'email',
      'rules' => 
      array (
      ),
    ),
    'phone' => 
    array (
      'field' => 'phone',
      'rules' => 
      array (
      ),
    ),
    'address' => 
    array (
      'field' => 'address',
      'rules' => 
      array (
      ),
    ),
    'address2' => 
    array (
      'field' => 'address2',
      'rules' => 
      array (
      ),
    ),
    'city' => 
    array (
      'field' => 'city',
      'rules' => 
      array (
      ),
    ),
    'state' => 
    array (
      'field' => 'state',
      'rules' => 
      array (
      ),
    ),
    'zip' => 
    array (
      'field' => 'zip',
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
    'enabled' => 
    array (
      'field' => 'enabled',
      'rules' => 
      array (
      ),
    ),
    'activated' => 
    array (
      'field' => 'activated',
      'rules' => 
      array (
      ),
    ),
    'activation_code' => 
    array (
      'field' => 'activation_code',
      'rules' => 
      array (
      ),
    ),
    'last_login' => 
    array (
      'field' => 'last_login',
      'rules' => 
      array (
      ),
    ),
    'created_date' => 
    array (
      'field' => 'created_date',
      'rules' => 
      array (
      ),
    ),
    'groups' => 
    array (
      'field' => 'groups',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'groups' => 
    array (
      'class' => 'groups_model',
      'other_field' => 'users',
      'join_other_as' => 'group',
      'model_path' => 'application/modules/users',
      'join_self_as' => 'users',
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