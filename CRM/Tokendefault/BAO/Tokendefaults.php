<?php
use CRM_Tokendefault_ExtensionUtil as E;

class CRM_Tokendefault_BAO_Tokendefaults extends CRM_Tokendefault_DAO_Tokendefaults {

  /**
   * Create a new Tokendefaults based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Tokendefault_DAO_Tokendefaults|NULL
   *
  public static function create($params) {
    $className = 'CRM_Tokendefault_DAO_Tokendefaults';
    $entityName = 'Tokendefaults';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  } */

}
