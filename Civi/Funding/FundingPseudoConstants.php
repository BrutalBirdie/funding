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

namespace Civi\Funding;

use Civi\Funding\Event\ApplicationProcess\GetPossibleApplicationProcessStatusEvent;
use Civi\Funding\Event\FundingCase\GetPossibleFundingCaseStatusEvent;
use CRM_Funding_ExtensionUtil as E;

/**
 * @phpstan-type optionT array{
 *   id: int|string,
 *   name: string,
 *   label: string,
 *   abbr: ?string,
 *   description: ?string,
 *   icon: ?string,
 *   color: ?string,
 * }
 */
final class FundingPseudoConstants {

  /**
   * @phpstan-return array<int, optionT>
   */
  public static function getApplicationProcessStatus(): array {
    $options = [
      [
        'id' => 'new',
        'name' => 'new',
        'label' => E::ts('New'),
        'icon' => 'fa-plus-circle',
      ],
      [
        'id' => 'draft',
        'name' => 'draft',
        'label' => E::ts('Draft'),
        'icon' => 'fa-spinner',
      ],
      [
        'id' => 'withdrawn',
        'name' => 'withdrawn',
        'label' => E::ts('Withdrawn'),
        'icon' => 'fa-arrow-circle-o-left',
      ],
      [
        'id' => 'applied',
        'name' => 'applied',
        'label' => E::ts('Applied'),
        'icon' => 'fa-circle-o',
      ],
      [
        'id' => 'review',
        'name' => 'review',
        'label' => E::ts('In review'),
        'icon' => 'fa-eye',
      ],
      [
        'id' => 'rejected',
        'name' => 'rejected',
        'label' => E::ts('Rejected'),
        'icon' => 'fa-times-circle-o',
        'color' => '#d65050',
      ],
      [
        'id' => 'eligible',
        'name' => 'eligible',
        'label' => E::ts('Eligible'),
        'icon' => 'fa-check-circle-o',
        'color' => '#56ab41',
      ],
      [
        'id' => 'final',
        'name' => 'final',
        'label' => E::ts('Final'),
        'icon' => 'fa-check-circle',
      ],
      [
        'id' => 'rework-requested',
        'name' => 'rework-requested',
        'label' => E::ts('Rework requested'),
        'icon' => 'fa-circle-o',
      ],
      [
        'id' => 'rework',
        'name' => 'rework',
        'label' => E::ts('In rework'),
        'icon' => 'fa-spinner',
      ],
      [
        'id' => 'rework-review-requested',
        'name' => 'rework-review-requested',
        'label' => E::ts('Rework review requested'),
        'icon' => 'fa-circle-o',
      ],
      [
        'id' => 'rework-review',
        'name' => 'rework-review',
        'label' => E::ts('Rework in review'),
        'icon' => 'fa-eye',
      ],
    ];

    // If ApplicationProcess is limited to one via "id" in $props, we could
    // determine the possible status depending on the funding case type...
    $event = new GetPossibleApplicationProcessStatusEvent($options);
    \Civi::dispatcher()->dispatch(GetPossibleApplicationProcessStatusEvent::class, $event);

    return $event->getOptions();
  }

  /**
   * @phpstan-return array<string, string>
   */
  public static function getDrawdownStatus(): array {
    return [
      'new' => E::ts('New'),
      'accepted' => E::ts('Accepted'),
    ];
  }

  /**
   * @phpstan-return array<string, string>
   */
  public static function getPayoutProcessStatus(): array {
    return [
      'open' => E::ts('Open'),
      'closed' => E::ts('Closed'),
    ];
  }

  /**
   * @phpstan-return array<int, optionT>
   */
  public static function getFundingCaseStatus(): array {
    $options = [
      'open' => E::ts('Open'),
      'ongoing' => E::ts('Ongoing'),
      'closed' => E::ts('Closed'),
    ];

    $event = new GetPossibleFundingCaseStatusEvent($options);
    \Civi::dispatcher()->dispatch(GetPossibleFundingCaseStatusEvent::class, $event);

    return $event->getOptions();
  }

  /**
   * @return array<string, string>
   */
  public static function getFundingProgramRelationshipTypes(): array {
    return [
      'adoptable' => E::ts('Applications adoptable'),
    ];
  }

  /**
   * @return array<string, string>
   */
  public static function getRelationshipTypeDirections(): array {
    return [
      'a_b' => E::ts('Relationship from a to b'),
      'b_a' => E::ts('Relationship from b to a'),
    ];
  }

}
