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

namespace Civi\Funding\ApplicationProcess\Handler;

use Civi\Funding\ApplicationProcess\Command\ApplicationFormNewValidateCommand;
use Civi\Funding\EntityFactory\FundingCaseTypeFactory;
use Civi\Funding\EntityFactory\FundingProgramFactory;
use Civi\Funding\Form\ApplicationJsonSchemaFactoryInterface;
use Civi\Funding\Form\Validation\ValidationResult;
use Civi\Funding\Form\Validation\ValidatorInterface;
use Civi\Funding\Form\ValidationErrorFactory;
use Civi\RemoteTools\Form\JsonSchema\JsonSchema;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Systopia\JsonSchema\Errors\ErrorCollector;

/**
 * @covers \Civi\Funding\ApplicationProcess\Handler\ApplicationFormNewValidateHandler
 * @covers \Civi\Funding\ApplicationProcess\Command\ApplicationFormNewValidateCommand
 * @covers \Civi\Funding\ApplicationProcess\Command\ApplicationFormNewValidateResult
 */
final class ApplicationFormNewValidateHandlerTest extends TestCase {

  private ApplicationFormNewValidateHandler $handler;

  /**
   * @var \Civi\Funding\Form\ApplicationJsonSchemaFactoryInterface&\PHPUnit\Framework\MockObject\MockObject
   */
  private MockObject $jsonSchemaFactoryMock;

  /**
   * @var \Civi\Funding\Form\Validation\ValidatorInterface&\PHPUnit\Framework\MockObject\MockObject
   */
  private MockObject $validatorMock;

  protected function setUp(): void {
    parent::setUp();
    $this->jsonSchemaFactoryMock = $this->createMock(ApplicationJsonSchemaFactoryInterface::class);
    $this->validatorMock = $this->createMock(ValidatorInterface::class);
    $this->handler = new ApplicationFormNewValidateHandler(
      $this->jsonSchemaFactoryMock,
      $this->validatorMock
    );
  }

  public function testHandle(): void {
    $contactId = 1;
    $fundingProgram = FundingProgramFactory::createFundingProgram();
    $fundingCaseType = FundingCaseTypeFactory::createFundingCaseType();

    $jsonSchema = new JsonSchema([]);
    $this->jsonSchemaFactoryMock->expects(static::once())->method('createJsonSchemaInitial')
      ->with(1, $fundingProgram, $fundingCaseType)
      ->willReturn($jsonSchema);

    $data = ['foo' => 'bar'];
    $postValidationData = ['foo' => 'baz'];
    $errorCollector = new ErrorCollector();
    $errorCollector->addError(ValidationErrorFactory::createValidationError());
    $validationResult = new ValidationResult($postValidationData, $errorCollector);

    $this->validatorMock->expects(static::once())->method('validate')
      ->with($jsonSchema, $data)
      ->willReturn($validationResult);

    $command = new ApplicationFormNewValidateCommand($contactId, $fundingProgram, $fundingCaseType, $data);
    $result = $this->handler->handle($command);
    static::assertSame($postValidationData, $result->getData());
    static::assertSame($validationResult->getLeafErrorMessages(), $result->getErrors());
    static::assertFalse($validationResult->isValid());
  }

}
