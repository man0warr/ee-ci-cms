<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'entries_data',
  'fields' => 
  array (
    0 => 'id',
    1 => 'entry_id',
    2 => 'field_id_1',
    3 => 'field_id_2',
    4 => 'field_id_3',
    5 => 'field_id_4',
    6 => 'field_id_5',
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
    'entry_id' => 
    array (
      'field' => 'entry_id',
      'rules' => 
      array (
      ),
    ),
    'field_id_1' => 
    array (
      'field' => 'field_id_1',
      'rules' => 
      array (
      ),
    ),
    'field_id_2' => 
    array (
      'field' => 'field_id_2',
      'rules' => 
      array (
      ),
    ),
    'field_id_3' => 
    array (
      'field' => 'field_id_3',
      'rules' => 
      array (
      ),
    ),
    'field_id_4' => 
    array (
      'field' => 'field_id_4',
      'rules' => 
      array (
      ),
    ),
    'field_id_5' => 
    array (
      'field' => 'field_id_5',
      'rules' => 
      array (
      ),
    ),
    'entries' => 
    array (
      'field' => 'entries',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'entries' => 
    array (
      'class' => 'entries_model',
      'other_field' => 'entries_data',
      'join_other_as' => 'entry',
      'join_self_as' => 'entries_data',
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