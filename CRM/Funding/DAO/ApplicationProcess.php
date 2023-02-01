<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from funding/xml/schema/CRM/Funding/FundingApplicationProcess.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:5ad4b2e505060fdea7e96f0a17ee4f4a)
 */
use CRM_Funding_ExtensionUtil as E;

/**
 * Database access object for the ApplicationProcess entity.
 */
class CRM_Funding_DAO_ApplicationProcess extends CRM_Core_DAO {
  const EXT = E::LONG_NAME;
  const TABLE_ADDED = '';

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_funding_application_process';

  /**
   * Field to show when displaying a record.
   *
   * @var string
   */
  public static $_labelField = 'title';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Unique FundingApplicationProcess ID
   *
   * @var int|string|null
   *   (SQL type: int unsigned)
   *   Note that values will be retrieved from the database as a string.
   */
  public $id;

  /**
   * Unique generated identifier
   *
   * @var string
   *   (SQL type: varchar(255))
   *   Note that values will be retrieved from the database as a string.
   */
  public $identifier;

  /**
   * FK to FundingCase
   *
   * @var int|string
   *   (SQL type: int unsigned)
   *   Note that values will be retrieved from the database as a string.
   */
  public $funding_case_id;

  /**
   * @var string
   *   (SQL type: varchar(64))
   *   Note that values will be retrieved from the database as a string.
   */
  public $status;

  /**
   * @var string
   *   (SQL type: timestamp)
   *   Note that values will be retrieved from the database as a string.
   */
  public $creation_date;

  /**
   * @var string
   *   (SQL type: timestamp)
   *   Note that values will be retrieved from the database as a string.
   */
  public $modification_date;

  /**
   * @var string
   *   (SQL type: varchar(255))
   *   Note that values will be retrieved from the database as a string.
   */
  public $title;

  /**
   * @var string
   *   (SQL type: varchar(255))
   *   Note that values will be retrieved from the database as a string.
   */
  public $short_description;

  /**
   * @var string
   *   (SQL type: timestamp)
   *   Note that values will be retrieved from the database as a string.
   */
  public $start_date;

  /**
   * @var string
   *   (SQL type: timestamp)
   *   Note that values will be retrieved from the database as a string.
   */
  public $end_date;

  /**
   * @var string
   *   (SQL type: text)
   *   Note that values will be retrieved from the database as a string.
   */
  public $request_data;

  /**
   * @var string
   *   (SQL type: decimal(10,2))
   *   Note that values will be retrieved from the database as a string.
   */
  public $amount_requested;

  /**
   * @var string
   *   (SQL type: decimal(10,2))
   *   Note that values will be retrieved from the database as a string.
   */
  public $amount_granted;

  /**
   * @var string
   *   (SQL type: decimal(10,2))
   *   Note that values will be retrieved from the database as a string.
   */
  public $granted_budget;

  /**
   * @var bool|string
   *   (SQL type: tinyint)
   *   Note that values will be retrieved from the database as a string.
   */
  public $is_review_content;

  /**
   * FK to Contact
   *
   * @var int|string
   *   (SQL type: int unsigned)
   *   Note that values will be retrieved from the database as a string.
   */
  public $reviewer_cont_contact_id;

  /**
   * @var bool|string
   *   (SQL type: tinyint)
   *   Note that values will be retrieved from the database as a string.
   */
  public $is_review_calculative;

  /**
   * FK to Contact
   *
   * @var int|string
   *   (SQL type: int unsigned)
   *   Note that values will be retrieved from the database as a string.
   */
  public $reviewer_calc_contact_id;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_funding_application_process';
    parent::__construct();
  }

  /**
   * Returns localized title of this entity.
   *
   * @param bool $plural
   *   Whether to return the plural version of the title.
   */
  public static function getEntityTitle($plural = FALSE) {
    return $plural ? E::ts('Application Processes') : E::ts('Application Process');
  }

  /**
   * Returns foreign keys and entity references.
   *
   * @return array
   *   [CRM_Core_Reference_Interface]
   */
  public static function getReferenceColumns() {
    if (!isset(Civi::$statics[__CLASS__]['links'])) {
      Civi::$statics[__CLASS__]['links'] = static::createReferenceColumns(__CLASS__);
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'funding_case_id', 'civicrm_funding_case', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'reviewer_cont_contact_id', 'civicrm_contact', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'reviewer_calc_contact_id', 'civicrm_contact', 'id');
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'links_callback', Civi::$statics[__CLASS__]['links']);
    }
    return Civi::$statics[__CLASS__]['links'];
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
          'title' => E::ts('ID'),
          'description' => E::ts('Unique FundingApplicationProcess ID'),
          'required' => TRUE,
          'where' => 'civicrm_funding_application_process.id',
          'table_name' => 'civicrm_funding_application_process',
          'entity' => 'ApplicationProcess',
          'bao' => 'CRM_Funding_DAO_ApplicationProcess',
          'localizable' => 0,
          'html' => [
            'type' => 'Number',
          ],
          'readonly' => TRUE,
          'add' => NULL,
        ],
        'identifier' => [
          'name' => 'identifier',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => E::ts('Identifier'),
          'description' => E::ts('Unique generated identifier'),
          'required' => TRUE,
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'where' => 'civicrm_funding_application_process.identifier',
          'dataPattern' => '/^[\p{L}\p{N}\p{P}]+$/u',
          'table_name' => 'civicrm_funding_application_process',
          'entity' => 'ApplicationProcess',
          'bao' => 'CRM_Funding_DAO_ApplicationProcess',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
          'add' => NULL,
        ],
        'funding_case_id' => [
          'name' => 'funding_case_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Funding Case ID'),
          'description' => E::ts('FK to FundingCase'),
          'required' => TRUE,
          'where' => 'civicrm_funding_application_process.funding_case_id',
          'table_name' => 'civicrm_funding_application_process',
          'entity' => 'ApplicationProcess',
          'bao' => 'CRM_Funding_DAO_ApplicationProcess',
          'localizable' => 0,
          'FKClassName' => 'CRM_Funding_DAO_FundingCase',
          'html' => [
            'type' => 'EntityRef',
          ],
          'add' => NULL,
        ],
        'status' => [
          'name' => 'status',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => E::ts('Status'),
          'required' => TRUE,
          'maxlength' => 64,
          'size' => CRM_Utils_Type::BIG,
          'where' => 'civicrm_funding_application_process.status',
          'table_name' => 'civicrm_funding_application_process',
          'entity' => 'ApplicationProcess',
          'bao' => 'CRM_Funding_DAO_ApplicationProcess',
          'localizable' => 0,
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'callback' => 'Civi\Funding\FundingPseudoConstants::getApplicationProcessStatus',
          ],
          'add' => NULL,
        ],
        'creation_date' => [
          'name' => 'creation_date',
          'type' => CRM_Utils_Type::T_TIMESTAMP,
          'title' => E::ts('Creation Date'),
          'required' => TRUE,
          'where' => 'civicrm_funding_application_process.creation_date',
          'table_name' => 'civicrm_funding_application_process',
          'entity' => 'ApplicationProcess',
          'bao' => 'CRM_Funding_DAO_ApplicationProcess',
          'localizable' => 0,
          'add' => NULL,
        ],
        'modification_date' => [
          'name' => 'modification_date',
          'type' => CRM_Utils_Type::T_TIMESTAMP,
          'title' => E::ts('Modification Date'),
          'required' => TRUE,
          'where' => 'civicrm_funding_application_process.modification_date',
          'table_name' => 'civicrm_funding_application_process',
          'entity' => 'ApplicationProcess',
          'bao' => 'CRM_Funding_DAO_ApplicationProcess',
          'localizable' => 0,
          'add' => NULL,
        ],
        'title' => [
          'name' => 'title',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => E::ts('Title'),
          'required' => TRUE,
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'where' => 'civicrm_funding_application_process.title',
          'table_name' => 'civicrm_funding_application_process',
          'entity' => 'ApplicationProcess',
          'bao' => 'CRM_Funding_DAO_ApplicationProcess',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
          'add' => NULL,
        ],
        'short_description' => [
          'name' => 'short_description',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => E::ts('Short Description'),
          'required' => TRUE,
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'where' => 'civicrm_funding_application_process.short_description',
          'table_name' => 'civicrm_funding_application_process',
          'entity' => 'ApplicationProcess',
          'bao' => 'CRM_Funding_DAO_ApplicationProcess',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
          'add' => NULL,
        ],
        'start_date' => [
          'name' => 'start_date',
          'type' => CRM_Utils_Type::T_TIMESTAMP,
          'title' => E::ts('Start Date'),
          'required' => FALSE,
          'where' => 'civicrm_funding_application_process.start_date',
          'table_name' => 'civicrm_funding_application_process',
          'entity' => 'ApplicationProcess',
          'bao' => 'CRM_Funding_DAO_ApplicationProcess',
          'localizable' => 0,
          'add' => NULL,
        ],
        'end_date' => [
          'name' => 'end_date',
          'type' => CRM_Utils_Type::T_TIMESTAMP,
          'title' => E::ts('End Date'),
          'required' => FALSE,
          'where' => 'civicrm_funding_application_process.end_date',
          'table_name' => 'civicrm_funding_application_process',
          'entity' => 'ApplicationProcess',
          'bao' => 'CRM_Funding_DAO_ApplicationProcess',
          'localizable' => 0,
          'add' => NULL,
        ],
        'request_data' => [
          'name' => 'request_data',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Request Data'),
          'required' => TRUE,
          'where' => 'civicrm_funding_application_process.request_data',
          'table_name' => 'civicrm_funding_application_process',
          'entity' => 'ApplicationProcess',
          'bao' => 'CRM_Funding_DAO_ApplicationProcess',
          'localizable' => 0,
          'serialize' => self::SERIALIZE_JSON,
          'add' => NULL,
        ],
        'amount_requested' => [
          'name' => 'amount_requested',
          'type' => CRM_Utils_Type::T_MONEY,
          'title' => E::ts('Amount Requested'),
          'required' => TRUE,
          'where' => 'civicrm_funding_application_process.amount_requested',
          'dataPattern' => '/^\d{1,10}(\.\d{2})?$/',
          'table_name' => 'civicrm_funding_application_process',
          'entity' => 'ApplicationProcess',
          'bao' => 'CRM_Funding_DAO_ApplicationProcess',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
          'add' => NULL,
        ],
        'amount_granted' => [
          'name' => 'amount_granted',
          'type' => CRM_Utils_Type::T_MONEY,
          'title' => E::ts('Amount Granted'),
          'required' => FALSE,
          'where' => 'civicrm_funding_application_process.amount_granted',
          'dataPattern' => '/^\d{1,10}(\.\d{2})?$/',
          'table_name' => 'civicrm_funding_application_process',
          'entity' => 'ApplicationProcess',
          'bao' => 'CRM_Funding_DAO_ApplicationProcess',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
          'add' => NULL,
        ],
        'granted_budget' => [
          'name' => 'granted_budget',
          'type' => CRM_Utils_Type::T_MONEY,
          'title' => E::ts('Granted Budget'),
          'required' => FALSE,
          'where' => 'civicrm_funding_application_process.granted_budget',
          'dataPattern' => '/^\d{1,10}(\.\d{2})?$/',
          'table_name' => 'civicrm_funding_application_process',
          'entity' => 'ApplicationProcess',
          'bao' => 'CRM_Funding_DAO_ApplicationProcess',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
          'add' => NULL,
        ],
        'is_review_content' => [
          'name' => 'is_review_content',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => E::ts('Is Review Content'),
          'required' => FALSE,
          'where' => 'civicrm_funding_application_process.is_review_content',
          'table_name' => 'civicrm_funding_application_process',
          'entity' => 'ApplicationProcess',
          'bao' => 'CRM_Funding_DAO_ApplicationProcess',
          'localizable' => 0,
          'html' => [
            'type' => 'CheckBox',
          ],
          'add' => NULL,
        ],
        'reviewer_cont_contact_id' => [
          'name' => 'reviewer_cont_contact_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Reviewer Cont Contact ID'),
          'description' => E::ts('FK to Contact'),
          'required' => FALSE,
          'where' => 'civicrm_funding_application_process.reviewer_cont_contact_id',
          'table_name' => 'civicrm_funding_application_process',
          'entity' => 'ApplicationProcess',
          'bao' => 'CRM_Funding_DAO_ApplicationProcess',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
          'html' => [
            'type' => 'EntityRef',
          ],
          'add' => NULL,
        ],
        'is_review_calculative' => [
          'name' => 'is_review_calculative',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => E::ts('Is Review Calculative'),
          'required' => FALSE,
          'where' => 'civicrm_funding_application_process.is_review_calculative',
          'table_name' => 'civicrm_funding_application_process',
          'entity' => 'ApplicationProcess',
          'bao' => 'CRM_Funding_DAO_ApplicationProcess',
          'localizable' => 0,
          'html' => [
            'type' => 'CheckBox',
          ],
          'add' => NULL,
        ],
        'reviewer_calc_contact_id' => [
          'name' => 'reviewer_calc_contact_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Reviewer Calc Contact ID'),
          'description' => E::ts('FK to Contact'),
          'required' => FALSE,
          'where' => 'civicrm_funding_application_process.reviewer_calc_contact_id',
          'table_name' => 'civicrm_funding_application_process',
          'entity' => 'ApplicationProcess',
          'bao' => 'CRM_Funding_DAO_ApplicationProcess',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
          'html' => [
            'type' => 'EntityRef',
          ],
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'funding_application_process', $prefix, []);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'funding_application_process', $prefix, []);
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
    $indices = [
      'index_identifier' => [
        'name' => 'index_identifier',
        'field' => [
          0 => 'identifier',
        ],
        'localizable' => FALSE,
        'unique' => TRUE,
        'sig' => 'civicrm_funding_application_process::1::identifier',
      ],
      'index_title' => [
        'name' => 'index_title',
        'field' => [
          0 => 'title',
        ],
        'localizable' => FALSE,
        'unique' => TRUE,
        'sig' => 'civicrm_funding_application_process::1::title',
      ],
    ];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}
