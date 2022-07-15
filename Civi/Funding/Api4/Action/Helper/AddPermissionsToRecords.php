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

namespace Civi\Funding\Api4\Action\Helper;

use Civi\Api4\Generic\Result;

final class AddPermissionsToRecords {

  /**
   * @var callable
   * @phpstan-var callable(array<string, mixed>&array{id: int}): (array<int, string>|null)
   */
  private $getRecordPermissions;

  /**
   * @phpstan-param callable(array<string, mixed>&array{id: int}): (array<int, string>|null) $getRecordPermissions
   *   Callable that returns the permissions for a given record. If it returns
   *   NULL, the record is filtered out.
   */
  public function __construct(callable $getRecordPermissions) {
    $this->getRecordPermissions = $getRecordPermissions;
  }

  public function __invoke(Result $result): void {
    $records = [];
    /** @var array<string, mixed>&array{id: int} $record */
    foreach ($result as $record) {
      $record['permissions'] = ($this->getRecordPermissions)($record);
      if (NULL === $record['permissions']) {
        continue;
      }

      // For Drupal Views
      foreach ($record['permissions'] as $permission) {
        $record['PERM_' . $permission] = TRUE;
      }

      $records[] = $record;
    }

    $result->rowCount = count($records);
    $result->exchangeArray($records);
  }

}
