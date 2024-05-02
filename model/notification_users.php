<?php
 /**
  *
  * Dont write any custom code in this class, build operation will overwrite this class;
  */
  namespace module\notifications\model;
  class notification_users extends \module\notifications\model\notification_users_domain_logic
  {
       public $behaviours = array (
);
       public $associations = array (
);
       public $fields = array (
  'user_id' => 
  array (
    'column' => 'user_id',
    'ntype' => 'int',
    'rules_grid' => '1',
    'business_key' => '662969f8-25ec-4c75-9917-41a1ac69033c',
    'is_sortable' => '0',
    'is_searchable' => '0',
    'is_multi_value' => '0',
    'is_computed_field' => '0',
  ),
  'notification_id' => 
  array (
    'column' => 'notification_id',
    'ntype' => 'int',
    'rules_grid' => '1',
    'business_key' => '66296a04-b84c-4fb4-9095-4dacac69033c',
    'is_sortable' => '0',
    'is_searchable' => '0',
    'is_multi_value' => '0',
    'is_computed_field' => '0',
  ),
  'last_viewed' => 
  array (
    'column' => 'last_viewed',
    'ntype' => 'datetime',
    'rules_grid' => '1',
    'business_key' => '66296a98-7b7c-43a4-ab88-4731ac69033c',
    'is_sortable' => '0',
    'is_searchable' => '0',
    'is_multi_value' => '0',
    'is_computed_field' => '0',
  ),
);
       public $filters = array (
);
       public $source = 'default';
       public $table = 'notifications__notification_users';
       public $parentClass = '\\kernel\\model';
       public $displayField = 'name';
       public $primaryKey = 'id';
       public $softDeleteColumn = 'deleted';
       public $sequenceColumnName = 'seq';
       public $business_key = '66296c0d-c2cc-464c-9205-43dfac69033c';
       public $isSequentialData = '0';
       public $isConfig = '0';
       public $overrideCallToParent = '0';
  }