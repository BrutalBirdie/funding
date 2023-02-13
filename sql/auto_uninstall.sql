-- +--------------------------------------------------------------------+
-- | Copyright CiviCRM LLC. All rights reserved.                        |
-- |                                                                    |
-- | This work is published under the GNU AGPLv3 license with some      |
-- | permitted exceptions and without any warranty. For full license    |
-- | and copyright information, see https://civicrm.org/licensing       |
-- +--------------------------------------------------------------------+
--
-- Generated from drop.tpl
-- DO NOT EDIT.  Generated by CRM_Core_CodeGen
---- /*******************************************************
-- *
-- * Clean up the existing tables-- *
-- *******************************************************/

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `civicrm_funding_app_cost_item`;
DROP TABLE IF EXISTS `civicrm_funding_application_snapshot`;
DROP TABLE IF EXISTS `civicrm_funding_app_resources_item`;
DROP TABLE IF EXISTS `civicrm_funding_application_process`;
DROP TABLE IF EXISTS `civicrm_funding_new_case_permissions`;
DROP TABLE IF EXISTS `civicrm_funding_case_type_program`;
DROP TABLE IF EXISTS `civicrm_funding_case_contact_relation`;
DROP TABLE IF EXISTS `civicrm_funding_case`;
DROP TABLE IF EXISTS `civicrm_funding_recipient_contact_relation`;
DROP TABLE IF EXISTS `civicrm_funding_program_relationship`;
DROP TABLE IF EXISTS `civicrm_funding_program_contact_relation`;
DROP TABLE IF EXISTS `civicrm_funding_program`;
DROP TABLE IF EXISTS `civicrm_funding_case_type`;

SET FOREIGN_KEY_CHECKS=1;