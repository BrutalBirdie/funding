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

namespace Civi\Funding\Fixtures;

use Civi\Api4\FundingCaseType;

final class FundingCaseTypeFixture {

  /**
   * @param array<string, scalar> $values
   *
   * @return array
   * @phpstan-return array<string, scalar|null>&array{id: int}
   *
   * @throws \API_Exception
   */
  public static function addFixture(array $values = []): array {
    return FundingCaseType::create()
      ->setValues($values + [
        'title' => 'Test Case Type',
        'name' => 'TestCaseType',
      ])->execute()->first();
  }

}
