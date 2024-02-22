<?php
declare(strict_types = 1);

namespace Civi\Api4;

use Civi\Funding\Api4\Action\FundingClearingProcess\GetAction;
use Civi\Funding\Api4\Action\FundingClearingProcess\GetFormAction;
use Civi\Funding\Api4\Action\FundingClearingProcess\SubmitFormAction;
use Civi\Funding\Api4\Action\FundingClearingProcess\ValidateFormAction;
use Civi\Funding\Api4\Traits\AccessROPermissionsTrait;

/**
 * FundingClearingProcess entity.
 *
 * Provided by the Funding Program Manager extension.
 *
 * @package Civi\Api4
 */
final class FundingClearingProcess extends Generic\DAOEntity {

  use AccessROPermissionsTrait;

  public static function get($checkPermissions = TRUE) {
    return \Civi::service(GetAction::class)->setCheckPermissions($checkPermissions);
  }

  public static function getForm(): GetFormAction {
    return new GetFormAction();
  }

  public static function validateForm(): ValidateFormAction {
    return new ValidateFormAction();
  }

  public static function submitForm(): SubmitFormAction {
    return new SubmitFormAction();
  }

}
