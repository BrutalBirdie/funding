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

namespace Civi\Api4;

use Civi\Funding\Api4\Action\FundingCaseTypeProgram\GetRelationAction;
use Civi\RemoteTools\Api4\Traits\EntityNameTrait;

/**
 * FundingCaseTypeProgram entity.
 *
 * Provided by the Funding Program Manager extension.
 *
 * @package Civi\Api4
 */
class FundingCaseTypeProgram extends Generic\DAOEntity {

  use EntityNameTrait;

  /**
   * Returns the entity that has the given funding case type ID and the given
   * funding program ID, or an empty result.
   *
   * @return \Civi\Funding\Api4\Action\FundingCaseTypeProgram\GetRelationAction
   */
  public static function getRelation(): GetRelationAction {
    return new GetRelationAction(static::get());
  }

}
