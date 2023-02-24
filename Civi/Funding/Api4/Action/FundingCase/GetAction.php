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

namespace Civi\Funding\Api4\Action\FundingCase;

use Civi\Api4\FundingCase;
use Civi\Api4\Generic\DAOGetAction;
use Civi\Core\CiviEventDispatcherInterface;
use Civi\Funding\Event\FundingCase\GetPermissionsEvent;
use Civi\Funding\Session\FundingSessionInterface;
use Civi\RemoteTools\Api4\Action\Traits\PermissionsGetActionTrait;
use Civi\RemoteTools\Authorization\PossiblePermissionsLoaderInterface;

final class GetAction extends DAOGetAction {

  use PermissionsGetActionTrait;

  private CiviEventDispatcherInterface $_eventDispatcher;

  private PossiblePermissionsLoaderInterface $_possiblePermissionsLoader;

  private FundingSessionInterface $session;

  public function __construct(CiviEventDispatcherInterface $eventDispatcher,
    PossiblePermissionsLoaderInterface $possiblePermissionsLoader,
    FundingSessionInterface $session
  ) {
    parent::__construct(FundingCase::_getEntityName(), 'get');
    $this->_eventDispatcher = $eventDispatcher;
    $this->_possiblePermissionsLoader = $possiblePermissionsLoader;
    $this->session = $session;
  }

  /**
   * @param array{id: int} $record
   *
   * @return array<string>
   */
  protected function getRecordPermissions(array $record): array {
    $permissionsGetEvent = new GetPermissionsEvent($record['id'], $this->session->getContactId());
    $this->_eventDispatcher->dispatch(GetPermissionsEvent::class, $permissionsGetEvent);

    return $permissionsGetEvent->getPermissions();
  }

  /**
   * @phpstan-return array<string>
   */
  protected function getPossiblePermissions(): array {
    return \array_keys($this->_possiblePermissionsLoader->getFilteredPermissions($this->getEntityName()));
  }

}
