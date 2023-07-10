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

namespace Civi\Funding\Mock\Form\FundingCaseType;

use Civi\RemoteTools\Form\JsonSchema\JsonSchemaInteger;
use Civi\RemoteTools\Form\JsonSchema\JsonSchemaMoney;
use Civi\RemoteTools\Form\JsonSchema\JsonSchemaObject;
use Civi\RemoteTools\Form\JsonSchema\JsonSchemaString;
use Webmozart\Assert\Assert;

final class TestJsonSchema extends JsonSchemaObject {

  /**
   * @phpstan-param array<string, \Civi\RemoteTools\Form\JsonSchema\JsonSchema> $extraProperties
   */
  public function __construct(array $extraProperties = [], array $keywords = []) {
    $required = $keywords['required'] ?? [];
    Assert::isArray($required);
    $keywords['required'] = array_merge([
      'title',
      'recipient',
      'startDate',
      'endDate',
      'amountRequested',
      'resources',
      'file',
    ], $required);

    parent::__construct([
      'title' => new JsonSchemaString(),
      'shortDescription' => new JsonSchemaString(['default' => 'Default description']),
      'recipient' => new JsonSchemaInteger(),
      'startDate' => new JsonSchemaString(),
      'endDate' => new JsonSchemaString(),
      'amountRequested' => new JsonSchemaMoney(),
      'resources' => new JsonSchemaMoney(),
      'file' => new JsonSchemaString(['format' => 'uri']),
    ] + $extraProperties, $keywords);
  }

}
