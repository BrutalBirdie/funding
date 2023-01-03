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

namespace Civi\Funding\Permission\FundingCase\RelationFactory;

use Civi\Funding\Entity\FundingCaseEntity;

interface RelationPropertiesFactoryInterface {

  public static function getSupportedFactoryType(): string;

  /**
   * @phpstan-param array<string, mixed> $properties
   *
   * @phpstan-return array<string, mixed>
   */
  public function createRelationProperties(
    array $properties,
    FundingCaseEntity $fundingCase
  ): array;

  public function getRelationType(): string;

}
