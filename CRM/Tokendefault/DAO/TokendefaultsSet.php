<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from C:\xampp2\htdocs\drupal-test\sites\default\files\civicrm\ext\com.joineryhq.tokendefault\xml/schema/CRM/Tokendefault/TokendefaultsSet.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:f8dab63177afb159a3bc2d29f44f1737)
 */

/**
 * Database access object for the TokendefaultsSet entity.
 */
class CRM_Tokendefault_DAO_TokendefaultsSet extends CRM_Core_DAO {

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_tokendefaults_set';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Unique TokendefaultsSet ID
   *
   * @var int
   */
  public $id;

  /**
   * @var string
   */
  public $title;

  /**
   * @var int
   */
  public $is_default;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_tokendefaults_set';
    parent::__construct();
  }

  /**
   * Returns localized title of this entity.
   */
  public static function getEntityTitle() {
    return ts('Tokendefaults Sets');
  }

  /**
   * Returns all the column names of this table
   *
   * @return array
   */
  public static function &fields() {
    if (!isset(Civi::$statics[__CLASS__]['fields'])) {
      Civi::$statics[__CLASS__]['fields'] = [
        'id' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => CRM_Tokendefault_ExtensionUtil::ts('Unique TokendefaultsSet ID'),
          'required' => TRUE,
          'where' => 'civicrm_tokendefaults_set.id',
          'table_name' => 'civicrm_tokendefaults_set',
          'entity' => 'TokendefaultsSet',
          'bao' => 'CRM_Tokendefault_DAO_TokendefaultsSet',
          'localizable' => 0,
          'add' => NULL,
        ],
        'title' => [
          'name' => 'title',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => CRM_Tokendefault_ExtensionUtil::ts('Title'),
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'where' => 'civicrm_tokendefaults_set.title',
          'table_name' => 'civicrm_tokendefaults_set',
          'entity' => 'TokendefaultsSet',
          'bao' => 'CRM_Tokendefault_DAO_TokendefaultsSet',
          'localizable' => 0,
          'add' => NULL,
        ],
        'is_default' => [
          'name' => 'is_default',
          'type' => CRM_Utils_Type::T_INT,
          'where' => 'civicrm_tokendefaults_set.is_default',
          'table_name' => 'civicrm_tokendefaults_set',
          'entity' => 'TokendefaultsSet',
          'bao' => 'CRM_Tokendefault_DAO_TokendefaultsSet',
          'localizable' => 0,
          'add' => NULL,
        ],
      ];
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'fields_callback', Civi::$statics[__CLASS__]['fields']);
    }
    return Civi::$statics[__CLASS__]['fields'];
  }

  /**
   * Return a mapping from field-name to the corresponding key (as used in fields()).
   *
   * @return array
   *   Array(string $name => string $uniqueName).
   */
  public static function &fieldKeys() {
    if (!isset(Civi::$statics[__CLASS__]['fieldKeys'])) {
      Civi::$statics[__CLASS__]['fieldKeys'] = array_flip(CRM_Utils_Array::collect('name', self::fields()));
    }
    return Civi::$statics[__CLASS__]['fieldKeys'];
  }

  /**
   * Returns the names of this table
   *
   * @return string
   */
  public static function getTableName() {
    return self::$_tableName;
  }

  /**
   * Returns if this table needs to be logged
   *
   * @return bool
   */
  public function getLog() {
    return self::$_log;
  }

  /**
   * Returns the list of fields that can be imported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &import($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'tokendefaults_set', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of fields that can be exported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &export($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'tokendefaults_set', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of indices
   *
   * @param bool $localize
   *
   * @return array
   */
  public static function indices($localize = TRUE) {
    $indices = [];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}
