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

namespace Civi\Funding\Event\ApplicationProcess;

use Civi\Funding\Entity\ApplicationProcessEntityBundle;
use Civi\Funding\Entity\Traits\ApplicationProcessEntityBundleTrait;
use Symfony\Component\EventDispatcher\Event;

final class ApplicationProcessCreatedEvent extends Event {

  use ApplicationProcessEntityBundleTrait;

  private int $contactId;

  public function __construct(
    int $contactId,
    ApplicationProcessEntityBundle $applicationProcessBundle
  ) {
    $this->contactId = $contactId;
    $this->applicationProcessBundle = $applicationProcessBundle;
  }

  public function getContactId(): int {
    return $this->contactId;
  }

}
