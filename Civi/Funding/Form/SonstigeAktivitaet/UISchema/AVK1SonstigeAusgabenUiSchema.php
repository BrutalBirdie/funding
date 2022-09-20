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

namespace Civi\Funding\Form\SonstigeAktivitaet\UISchema;

use Civi\RemoteTools\Form\JsonForms\Control\JsonFormsArray;
use Civi\RemoteTools\Form\JsonForms\Control\JsonFormsHidden;
use Civi\RemoteTools\Form\JsonForms\JsonFormsControl;
use Civi\RemoteTools\Form\JsonForms\Layout\JsonFormsGroup;

final class AVK1SonstigeAusgabenUiSchema extends JsonFormsGroup {

  public function __construct(string $currency) {
    $elements = [
      new JsonFormsArray('#/properties/kosten/properties/sonstigeAusgaben', 'Sonstige Ausgaben', NULL, [
        new JsonFormsHidden('#/properties/_identifier'),
        new JsonFormsControl('#/properties/betrag', 'Betrag', NULL, NULL, $currency),
        new JsonFormsControl('#/properties/zweck', 'Zweck'),
      ]),
      new JsonFormsControl('#/properties/kosten/properties/sonstigeAusgabenGesamt',
        'Sonstige Ausgaben gesamt', NULL, NULL, $currency),
    ];

    parent::__construct(
      'Sonstige Ausgaben',
      $elements,
      'Bitte geben Sie hier alle weiteren Kosten an. Bitte führen Sie jede Position einzeln auf.'
    );
  }

}
