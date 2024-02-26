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

namespace Civi\Funding\ClearingProcess\Handler;

use Civi\Funding\ClearingProcess\ClearingCostItemManager;
use Civi\Funding\ClearingProcess\ClearingExternalFileManagerInterface;
use Civi\Funding\ClearingProcess\ClearingResourcesItemManager;
use Civi\Funding\ClearingProcess\Command\ClearingFormDataGetCommand;
use Civi\Funding\ClearingProcess\Command\ClearingFormValidateCommand;
use Civi\Funding\Entity\AbstractClearingItemEntity;

final class ClearingFormDataGetHandler implements ClearingFormDataGetHandlerInterface {

  private ClearingCostItemManager $clearingCostItemManager;

  private ClearingResourcesItemManager $clearingResourcesItemManager;

  private ClearingExternalFileManagerInterface $externalFileManager;

  private ClearingFormValidateHandlerInterface $validateHandler;

  public function __construct(
    ClearingCostItemManager $clearingCostItemManager,
    ClearingResourcesItemManager $clearingResourcesItemManager,
    ClearingExternalFileManagerInterface $externalFileManager,
    ClearingFormValidateHandlerInterface $validateHandler
  ) {
    $this->clearingCostItemManager = $clearingCostItemManager;
    $this->clearingResourcesItemManager = $clearingResourcesItemManager;
    $this->externalFileManager = $externalFileManager;
    $this->validateHandler = $validateHandler;
  }

  public function handle(ClearingFormDataGetCommand $command): array {
    $clearingProcessId = $command->getClearingProcess()->getId();

    $data = [
      'costItems' => [],
      'resourcesItems' => [],
      'reportData' => $command->getClearingProcess()->getReportData(),
    ];

    foreach ($this->clearingCostItemManager->getByClearingProcessId($clearingProcessId) as $clearingItem) {
      $data['costItems'][$clearingItem->getApplicationCostItemId()]['records'][] = [
        '_id' => $clearingItem->getId(),
        'amount' => $clearingItem->getAmount(),
        'file' => $this->getExternalFileUri($clearingItem),
        'description' => $clearingItem->getDescription(),
      ];
    }

    foreach ($this->clearingResourcesItemManager->getByClearingProcessId($clearingProcessId) as $clearingItem) {
      $data['resourcesItems'][$clearingItem->getApplicationResourcesItemId()]['records'][] = [
        '_id' => $clearingItem->getId(),
        'amount' => $clearingItem->getAmount(),
        'file' => $this->getExternalFileUri($clearingItem),
        'description' => $clearingItem->getDescription(),
      ];
    }

    // Perform calculations.
    $result = $this->validateHandler->handle(
      new ClearingFormValidateCommand($command->getClearingProcessBundle(), $data)
    );

    return $result->getData();
  }

  private function getExternalFileUri(AbstractClearingItemEntity $clearingItem): ?string {
    $externalFile = $this->externalFileManager->getFile($clearingItem);

    return NULL === $externalFile ? NULL : $externalFile->getUri();
  }

}
