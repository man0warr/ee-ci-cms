<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'content_types',
  'fields' => 
  array (
    0 => 'id',
    1 => 'title',
    2 => 'short_name',
    3 => 'layout',
    4 => 'page_head',
    5 => 'page_foot',
    6 => 'theme_layout',
    7 => 'dynamic_route',
    8 => 'required',
    9 => 'access',
    10 => 'restrict_to',
    11 => 'restrict_admin_access',
    12 => 'enable_versioning',
    13 => 'max_revisions',
    14 => 'entries_allowed',
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
    'short_name' => 
    array (
      'field' => 'short_name',
      'rules' => 
      array (
      ),
    ),
    'layout' => 
    array (
      'field' => 'layout',
      'rules' => 
      array (
      ),
    ),
    'page_head' => 
    array (
      'field' => 'page_head',
      'rules' => 
      array (
      ),
    ),
    'page_foot' => 
    array (
      'field' => 'page_foot',
      'rules' => 
      array (
      ),
    ),
    'theme_layout' => 
    array (
      'field' => 'theme_layout',
      'rules' => 
      array (
      ),
    ),
    'dynamic_route' => 
    array (
      'field' => 'dynamic_route',
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
    'access' => 
    array (
      'field' => 'access',
      'rules' => 
      array (
      ),
    ),
    'restrict_to' => 
    array (
      'field' => 'restrict_to',
      'rules' => 
      array (
      ),
    ),
    'restrict_admin_access' => 
    array (
      'field' => 'restrict_admin_access',
      'rules' => 
      array (
      ),
    ),
    'enable_versioning' => 
    array (
      'field' => 'enable_versioning',
      'rules' => 
      array (
      ),
    ),
    'max_revisions' => 
    array (
      'field' => 'max_revisions',
      'rules' => 
      array (
      ),
    ),
    'entries_allowed' => 
    array (
      'field' => 'entries_allowed',
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
    'content_fields' => 
    array (
      'field' => 'content_fields',
      'rules' => 
      array (
      ),
    ),
    'admin_groups' => 
    array (
      'field' => 'admin_groups',
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
    'entries' => 
    array (
      'class' => 'entries_model',
      'other_field' => 'content_types',
      'join_self_as' => 'content_type',
      'join_other_as' => 'entry',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'content_fields' => 
    array (
      'class' => 'content_fields_model',
      'other_field' => 'content_types',
      'join_self_as' => 'content_type',
      'join_other_as' => 'content_field',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'admin_groups' => 
    array (
      'class' => 'content_types_admin_groups_model',
      'other_field' => 'content_types',
      'join_self_as' => 'content_type',
      'join_other_as' => 'admin_groups',
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