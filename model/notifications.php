<?php
 /**
  *
  * Dont write any custom code in this class, build operation will overwrite this class;
  */
  namespace module\notifications\model;
  class notifications extends \module\notifications\model\notifications_domain_logic
  {
       public $behaviours = array (
);
       public $associations = array (
  'notification_users' => 
  array (
    'assocType' => 'hasMany',
    'className' => '\\module\\notifications\\model\\notification_users',
    'associationAlias' => 'notification_users',
    'foreignKey' => 'notification_id',
    'show_link' => '1',
    'business_key' => '6629c9f0-3aa4-455f-aabe-498eac69033c',
    'isAclParent' => '0',
    'isAclChild' => '0',
    'isSubModel' => '0',
    'isSearchable' => '0',
    'consider_as_submodel_for_deep_cloning' => '0',
    'inheritEditAcl' => '0',
    'inheritDeleteAcl' => '0',
  ),
);
       public $fields = array (
  'message' => 
  array (
    'column' => 'message',
    'ntype' => 'string',
    'length' => '255',
    'rules_grid' => '1',
    'business_key' => '66295e0d-81a0-4834-a693-4916ac69033c',
    'is_sortable' => '0',
    'is_searchable' => '0',
    'is_multi_value' => '0',
    'is_computed_field' => '0',
  ),
  'access_url' => 
  array (
    'column' => 'access_url',
    'ntype' => 'string',
    'length' => '255',
    'rules_grid' => '1',
    'business_key' => '662962dd-7a38-4b65-8ed0-40c3ac69033c',
    'is_sortable' => '0',
    'is_searchable' => '0',
    'is_multi_value' => '0',
    'is_computed_field' => '0',
  ),
  'recipients' => 
  array (
    'column' => 'recipients',
    'ntype' => 'string',
    'length' => '255',
    'rules_grid' => '1',
    'business_key' => '66296bf9-dc34-49b3-b4a9-46ebac69033c',
    'is_sortable' => '0',
    'is_searchable' => '0',
    'is_multi_value' => '0',
    'is_computed_field' => '0',
  ),
  'sender_id' => 
  array (
    'column' => 'sender_id',
    'ntype' => 'int',
    'rules_grid' => '1',
    'business_key' => '66296b2e-7af8-4103-8ca4-4023ac69033c',
    'is_sortable' => '0',
    'is_searchable' => '0',
    'is_multi_value' => '0',
    'is_computed_field' => '0',
  ),
);
       public $filters = array (
);
       public $source = 'default';
       public $table = 'notifications__notifications';
       public $parentClass = '\\kernel\\model';
       public $displayField = 'name';
       public $primaryKey = 'id';
       public $softDeleteColumn = 'deleted';
       public $sequenceColumnName = 'seq';
       public $business_key = '66295dc5-a2c4-48d1-a726-4cc4ac69033c';
       public $isSequentialData = '0';
       public $isConfig = '0';
       public $overrideCallToParent = '0';
  }