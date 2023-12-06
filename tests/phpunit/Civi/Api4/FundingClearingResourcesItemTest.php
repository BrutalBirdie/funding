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

namespace Civi\Api4;

use Civi\API\Exception\UnauthorizedException;
use Civi\Funding\AbstractFundingHeadlessTestCase;
use Civi\Funding\ClearingProcess\ClearingProcessPermissions;
use Civi\Funding\Entity\ClearingProcessEntity;
use Civi\Funding\Fixtures\ApplicationProcessFixture;
use Civi\Funding\Fixtures\ApplicationResourcesItemFixture;
use Civi\Funding\Fixtures\ClearingProcessFixture;
use Civi\Funding\Fixtures\ClearingResourcesItemFixture;
use Civi\Funding\Fixtures\ContactFixture;
use Civi\Funding\Fixtures\FundingCaseContactRelationFixture;
use Civi\Funding\Fixtures\FundingCaseFixture;
use Civi\Funding\Fixtures\FundingCaseTypeFixture;
use Civi\Funding\Fixtures\FundingProgramFixture;
use Civi\Funding\Util\RequestTestUtil;

/**
 * @covers \Civi\Api4\FundingClearingResourcesItem
 * @covers \Civi\Funding\Api4\Action\FundingClearingResourcesItem\GetAction
 * @covers \Civi\Funding\Api4\Action\Generic\ClearingItem\GetAction
 *
 * @group headless
 */
final class FundingClearingResourcesItemTest extends AbstractFundingHeadlessTestCase {

  protected function setUp(): void {
    parent::setUp();
  }

  public function testGet(): void {
    $contact = ContactFixture::addIndividual();
    $contactNotPermitted = ContactFixture::addIndividual();
    $clearingProcess = $this->createClearingProcess();
    $applicationProcess = ApplicationProcessFixture::addFixture($clearingProcess->getFundingCaseId());
    $applicationResourcesItem = ApplicationResourcesItemFixture::addFixture($applicationProcess->getId());
    $clearingResourcesItem = ClearingResourcesItemFixture::addFixture(
      $clearingProcess->getId(),
      $applicationResourcesItem->getId()
    );

    FundingCaseContactRelationFixture::addContact(
      $contact['id'],
      $clearingProcess->getFundingCaseId(),
      ['review_test'],
    );

    RequestTestUtil::mockInternalRequest($contact['id']);
    $result = FundingClearingResourcesItem::get()->addSelect('id', 'currency', 'CAN_review')->execute();
    static::assertCount(1, $result);
    static::assertSame(
      [
        'id' => $clearingResourcesItem->getId(),
        'currency' => FundingProgramFixture::DEFAULT_CURRENCY,
        'CAN_review' => FALSE,
      ],
      $result->first(),
    );

    FundingCaseContactRelationFixture::addContact(
      $contact['id'],
      $clearingProcess->getFundingCaseId(),
      [ClearingProcessPermissions::REVIEW_CALCULATIVE],
    );
    $result = FundingClearingResourcesItem::get()->addSelect('id', 'currency', 'CAN_review')->execute();
    static::assertCount(1, $result);
    static::assertSame(
      [
        'id' => $clearingResourcesItem->getId(),
        'currency' => FundingProgramFixture::DEFAULT_CURRENCY,
        'CAN_review' => TRUE,
      ],
      $result->first(),
    );

    $clearingProcess->setStatus('draft');
    FundingClearingProcess::update(FALSE)
      ->setValues($clearingProcess->toArray())
      ->execute();
    $result = FundingClearingResourcesItem::get()->addSelect('id', 'currency', 'CAN_review')->execute();
    static::assertCount(1, $result);
    static::assertSame(
      [
        'id' => $clearingResourcesItem->getId(),
        'currency' => FundingProgramFixture::DEFAULT_CURRENCY,
        'CAN_review' => FALSE,
      ],
      $result->first(),
    );

    RequestTestUtil::mockInternalRequest($contactNotPermitted['id']);
    static::assertCount(0, FundingDrawdown::get()
      ->addSelect('id')->execute());
  }

  public function testUpdateNotPermitted(): void {
    static::expectException(UnauthorizedException::class);
    FundingClearingResourcesItem::update()
      ->addValue('x', 'y')
      ->addWhere('y', '=', 'z')
      ->execute();
  }

  private function createClearingProcess(): ClearingProcessEntity {
    $fundingProgram = FundingProgramFixture::addFixture();
    $fundingCaseType = FundingCaseTypeFixture::addFixture();
    $recipientContact = ContactFixture::addOrganization();
    $creationContact = ContactFixture::addIndividual();

    $fundingCase = FundingCaseFixture::addFixture(
      $fundingProgram->getId(),
      $fundingCaseType->getId(),
      $recipientContact['id'],
      $creationContact['id'],
    );

    return ClearingProcessFixture::addFixture($fundingCase->getId(), ['status' => 'review']);
  }

}
