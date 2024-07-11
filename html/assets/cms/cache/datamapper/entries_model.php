<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'entries',
  'fields' => 
  array (
    0 => 'id',
    1 => 'slug',
    2 => 'title',
    3 => 'url_title',
    4 => 'required',
    5 => 'content_type_id',
    6 => 'status',
    7 => 'meta_title',
    8 => 'meta_description',
    9 => 'meta_keywords',
    10 => 'created_date',
    11 => 'modified_date',
    12 => 'author_id',
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
    'title' => 
    array (
      'field' => 'title',
      'rules' => 
      array (
      ),
    ),
    'url_title' => 
    array (
      'field' => 'url_title',
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
    'content_type_id' => 
    array (
      'field' => 'content_type_id',
      'rules' => 
      array (
      ),
    ),
    'status' => 
    array (
      'field' => 'status',
      'rules' => 
      array (
      ),
    ),
    'meta_title' => 
    array (
      'field' => 'meta_title',
      'rules' => 
      array (
      ),
    ),
    'meta_description' => 
    array (
      'field' => 'meta_description',
      'rules' => 
      array (
      ),
    ),
    'meta_keywords' => 
    array (
      'field' => 'meta_keywords',
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
    'modified_date' => 
    array (
      'field' => 'modified_date',
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
    'content_types' => 
    array (
      'field' => 'content_types',
      'rules' => 
      array (
      ),
    ),
    'entries_data' => 
    array (
      'field' => 'entries_data',
      'rules' => 
      array (
      ),
    ),
    'entry_revisions' => 
    array (
      'field' => 'entry_revisions',
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
      'other_field' => 'entries',
      'join_self_as' => 'entry',
      'join_other_as' => 'content_type',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
  ),
  'has_many' => 
  array (
    'entries_data' => 
    array (
      'class' => 'entries_data_model',
      'other_field' => 'entries',
      'join_self_as' => 'entry',
      'join_other_as' => 'entries_data',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'entry_revisions' => 
    array (
      'class' => 'entry_revisions_model',
      'other_field' => 'entries',
      'join_self_as' => 'entry',
      'join_other_as' => 'entry_revisions',
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