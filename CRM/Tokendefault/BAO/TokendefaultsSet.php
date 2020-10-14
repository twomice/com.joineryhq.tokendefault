<?php
use CRM_Tokendefault_ExtensionUtil as E;

class CRM_Tokendefault_BAO_TokendefaultsSet extends CRM_Tokendefault_DAO_TokendefaultsSet {

  /**
   * Create a new TokendefaultsSet based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Tokendefault_DAO_TokendefaultsSet|NULL
   *
  public static function create($params) {
    $className = 'CRM_Tokendefault_DAO_TokendefaultsSet';
    $entityName = 'TokendefaultsSet';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  } */

}
