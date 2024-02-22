<?php
/*
 * Copyright (C) 2024 SYSTOPIA GmbH
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as published by
 *  the Free Software Foundation in version 3.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types = 1);

namespace Civi\Funding\ClearingProcess\Api4\ActionHandler;

use Civi\Funding\Api4\Action\FundingClearingProcess\SubmitFormAction;
use Civi\Funding\ClearingProcess\ClearingProcessBundleLoader;
use Civi\RemoteTools\ActionHandler\ActionHandlerInterface;
use Webmozart\Assert\Assert;

final class SubmitFormActionHandler implements ActionHandlerInterface {

  public const ENTITY_NAME = 'FundingClearingProcess';

  private ClearingProcessBundleLoader $clearingProcessBundleLoader;

  /**
   * @phpstan-return array{
   *   data: array<string, mixed>,
   *   errors: array<string, non-empty-list<string>>,
   * }
   * 'data' contains the persisted data, or the data after validation if the
   * validation failed. 'errors' contains JSON pointers mapped to error
   * messages if the validation failed, or an emtpy \stdClass object otherwise.
   *
   * @throws \CRM_Core_Exception
   */
  public function submitForm(SubmitFormAction $action): array {
    $clearingProcessBundle = $this->clearingProcessBundleLoader->get($action->getId());
    Assert::notNull($clearingProcessBundle, sprintf('Clearing pricess with ID %d not found', $action->getId()));

    return [
      'data' => [],
      'errors' => new \stdClass(),
    ];
  }

}
