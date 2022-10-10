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

namespace Civi\Funding\Form\SonstigeAktivitaet;

use Civi\RemoteTools\Form\JsonSchema\JsonSchemaInteger;

final class AVK1FormExisting extends AVK1Form {

  public function __construct(\DateTimeInterface $minBegin, \DateTimeInterface $maxEnd,
    string $currency, int $applicationProcessId, array $submitActions, bool $readOnly, array $data
  ) {
    $data['applicationProcessId'] = $applicationProcessId;

    $hiddenProperties = [
      'applicationProcessId' => new JsonSchemaInteger(['const' => $applicationProcessId, 'readOnly' => TRUE]),
    ];

    parent::__construct($minBegin, $maxEnd, $currency, $submitActions, $hiddenProperties, $data);

    if ($readOnly) {
      $this->getUiSchema()->setReadonly(TRUE);
    }
  }

}
