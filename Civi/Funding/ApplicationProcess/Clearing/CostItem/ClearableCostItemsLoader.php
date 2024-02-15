<?php
/*
 * Copyright (C) 2024 SYSTOPIA GmbH
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

namespace Civi\Funding\ApplicationProcess\Clearing\CostItem;

use Civi\Funding\ApplicationProcess\ApplicationCostItemManager;
use Civi\Funding\ApplicationProcess\Clearing\AbstractClearableItemsLoader;
use Psr\Log\LoggerInterface;

/**
 * @extends AbstractClearableItemsLoader<\Civi\Funding\Entity\ApplicationCostItemEntity>
 */
class ClearableCostItemsLoader extends AbstractClearableItemsLoader {

  public function __construct(ApplicationCostItemManager $itemManager, LoggerInterface $logger) {
    parent::__construct($itemManager, $logger);
  }

  protected function getFinancePlanArrayItemKeyword(): string {
    return '$costItems';
  }

  protected function getFinancePlanNumberItemKeyword(): string {
    return '$costItem';
  }

}
