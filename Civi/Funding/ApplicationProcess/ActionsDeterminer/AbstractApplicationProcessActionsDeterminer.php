<?php
/*
 * Copyright (C) 2022 SYSTOPIA GmbH
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

namespace Civi\Funding\ApplicationProcess\ActionsDeterminer;

use Civi\Funding\Entity\FullApplicationProcessStatus;

/**
 * @phpstan-type statusPermissionsActionMapT array<string|null, array<string, list<string>>>
 */
abstract class AbstractApplicationProcessActionsDeterminer implements ApplicationProcessActionsDeterminerInterface {

  /**
   * @phpstan-var statusPermissionsActionMapT
   */
  private array $statusPermissionActionsMap;

  /**
   * @phpstan-param statusPermissionsActionMapT $statusPermissionActionsMap
   */
  public function __construct(array $statusPermissionActionsMap) {
    $this->statusPermissionActionsMap = $statusPermissionActionsMap;
  }

  public function getActions(FullApplicationProcessStatus $status, array $statusList, array $permissions): array {
    return $this->doGetActions($status->getStatus(), $permissions);
  }

  public function getInitialActions(array $permissions): array {
    return $this->doGetActions(NULL, $permissions);
  }

  public function isActionAllowed(
    string $action,
    FullApplicationProcessStatus $status,
    array $statusList,
    array $permissions
  ): bool {
    return $this->isAnyActionAllowed([$action], $status, $statusList, $permissions);
  }

  public function isAnyActionAllowed(
    array $actions,
    FullApplicationProcessStatus $status,
    array $statusList,
    array $permissions
  ): bool {
    return [] !== array_intersect($this->getActions($status, $statusList, $permissions), $actions);
  }

  public function isEditAllowed(FullApplicationProcessStatus $status, array $statusList, array $permissions): bool {
    return $this->isAnyActionAllowed(['save', 'apply', 'update'], $status, $statusList, $permissions);
  }

  /**
   * @phpstan-param array<string> $permissions
   *
   * @phpstan-return list<string>
   */
  private function doGetActions(?string $status, array $permissions): array {
    $actions = [];
    foreach ($permissions as $permission) {
      $actions = \array_merge($actions, $this->statusPermissionActionsMap[$status][$permission] ?? []);
    }

    return \array_values(\array_unique($actions));
  }

}
