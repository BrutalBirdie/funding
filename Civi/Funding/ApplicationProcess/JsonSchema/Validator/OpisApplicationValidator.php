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

namespace Civi\Funding\ApplicationProcess\JsonSchema\Validator;

use Opis\JsonSchema\SchemaLoader;
use Opis\JsonSchema\Validator;
use Systopia\JsonSchema\Parsers\SystopiaSchemaParser;

/**
 * @codeCoverageIgnore
 */
final class OpisApplicationValidator extends Validator {

  /**
   * @param array<string, mixed> $options
   */
  public function __construct(array $options = [], int $maxErrors = 1) {
    $loader = new SchemaLoader(new SystopiaSchemaParser([], $options, new ApplicationSchemaVocabulary()));
    parent::__construct($loader, $maxErrors);
  }

}
