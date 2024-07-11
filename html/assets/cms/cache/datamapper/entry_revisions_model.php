<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'entry_revisions',
  'fields' => 
  array (
    0 => 'id',
    1 => 'entry_id',
    2 => 'content_type_id',
    3 => 'author_id',
    4 => 'author_name',
    5 => 'revision_date',
    6 => 'revision_data',
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
    'content_type_id' => 
    array (
      'field' => 'content_type_id',
      'rules' => 
      array (
      ),
    ),
    'author_id' => 
    array (
      'field' => 'author_id',
      'rules' => 
      array (
      ),
    ),
    'author_name' => 
    array (
      'field' => 'author_name',
      'rules' => 
      array (
      ),
    ),
    'revision_date' => 
    array (
      'field' => 'revision_date',
      'rules' => 
      array (
      ),
    ),
    'revision_data' => 
    array (
      'field' => 'revision_data',
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
      'other_field' => 'content_types',
      'join_other_as' => 'entry',
      'join_self_as' => 'content_types',
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