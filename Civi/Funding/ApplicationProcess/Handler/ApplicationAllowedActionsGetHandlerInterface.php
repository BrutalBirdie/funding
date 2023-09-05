<?php
/*
 * Copyright (C) 2023 SYSTOPIA GmbH
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

namespace Civi\Funding\ApplicationProcess\Handler;

use Civi\Funding\ApplicationProcess\Command\ApplicationAllowedActionsGetCommand;

interface ApplicationAllowedActionsGetHandlerInterface {

  public const SERVICE_TAG = 'funding.application.allowed_actions_get_handler';

  /**
   * @phpstan-return array<string, array{
   *    label: string,
   *    confirm: string|null,
   *    properties: array<string, mixed>&array{needsFormData?: bool},
   *  }>
   *    needsFormData is FALSE if the action is applicable without form data.
   */
  public function handle(ApplicationAllowedActionsGetCommand $command): array;

}
