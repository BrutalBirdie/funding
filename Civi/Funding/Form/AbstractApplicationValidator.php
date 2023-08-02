<?php
/*
 * Copyright (C) 2023 SYSTOPIA GmbH
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

namespace Civi\Funding\Form;

use Civi\Funding\Entity\ApplicationProcessEntityBundle;
use Civi\Funding\Entity\FundingCaseTypeEntity;
use Civi\Funding\Entity\FundingProgramEntity;
use Civi\Funding\Form\Validation\ValidatorInterface;
use Civi\RemoteTools\Form\JsonSchema\JsonSchema;

abstract class AbstractApplicationValidator implements ApplicationValidatorInterface {

  private ApplicationJsonSchemaFactoryInterface $jsonSchemaFactory;

  private ValidatorInterface $jsonSchemaValidator;

  public function __construct(
    ApplicationJsonSchemaFactoryInterface $jsonSchemaFactory,
    ValidatorInterface $jsonSchemaValidator
  ) {
    $this->jsonSchemaFactory = $jsonSchemaFactory;
    $this->jsonSchemaValidator = $jsonSchemaValidator;
  }

  /**
   * @inheritDoc
   */
  public function validateExisting(
    ApplicationProcessEntityBundle $applicationProcessBundle,
    array $data,
    int $maxErrors = 1
  ): ApplicationValidationResult {
    $jsonSchema = $this->jsonSchemaFactory->createJsonSchemaExisting($applicationProcessBundle);
    $jsonSchemaValidationResult = $this->jsonSchemaValidator->validate($jsonSchema, $data, $maxErrors);
    if (!$jsonSchemaValidationResult->isValid()) {
      return ApplicationValidationResult::newInvalid(
        // @phpstan-ignore-next-line leaf error messages are not empty.
        $jsonSchemaValidationResult->getLeafErrorMessages(),
        new ValidatedApplicationDataInvalid($jsonSchemaValidationResult->getData()),
      );
    }

    return $this->getValidationResultExisting(
      $applicationProcessBundle,
      $data,
      $jsonSchema,
      $jsonSchemaValidationResult->getData(),
      $maxErrors
    );
  }

  /**
   * @inheritDoc
   */
  public function validateInitial(
    int $contactId,
    FundingProgramEntity $fundingProgram,
    FundingCaseTypeEntity $fundingCaseType,
    array $data,
    int $maxErrors = 1
  ): ApplicationValidationResult {
    $jsonSchema = $this->jsonSchemaFactory->createJsonSchemaInitial($contactId, $fundingCaseType, $fundingProgram);
    $jsonSchemaValidationResult = $this->jsonSchemaValidator->validate($jsonSchema, $data, $maxErrors);
    if (!$jsonSchemaValidationResult->isValid()) {
      return ApplicationValidationResult::newInvalid(
        // @phpstan-ignore-next-line leaf error messages are not empty.
        $jsonSchemaValidationResult->getLeafErrorMessages(),
        new ValidatedApplicationDataInvalid($jsonSchemaValidationResult->getData()),
      );
    }

    return $this->getValidationResultInitial(
      $contactId,
      $fundingProgram,
      $fundingCaseType,
      $data,
      $jsonSchema,
      $jsonSchemaValidationResult->getData(),
      $maxErrors,
    );
  }

  /**
   * Called after successful JSON schema validation.
   *
   * @param \Civi\RemoteTools\Form\JsonSchema\JsonSchema $jsonSchema *
   *
   * @phpstan-param array<string, mixed> $formData JSON serializable.
   * @phpstan-param array<string, mixed> $validatedData JSON serializable.
   *   Data returned by JSON schema validator.
   */
  abstract protected function getValidationResultExisting(
    ApplicationProcessEntityBundle $applicationProcessBundle,
    array $formData,
    JsonSchema $jsonSchema,
    array $validatedData,
    int $maxErrors
  ): ApplicationValidationResult;

  /**
   * Called after successful JSON schema validation.
   *
   * @param \Civi\RemoteTools\Form\JsonSchema\JsonSchema $jsonSchema *
   *
   * @phpstan-param array<string, mixed> $formData JSON serializable.
   * @phpstan-param array<string, mixed> $validatedData JSON serializable.
   *   Data returned by JSON schema validator.
   */
  abstract protected function getValidationResultInitial(
    int $contactId,
    FundingProgramEntity $fundingProgram,
    FundingCaseTypeEntity $fundingCaseType,
    array $formData,
    JsonSchema $jsonSchema,
    array $validatedData,
    int $maxErrors
  ): ApplicationValidationResult;

  protected function createValidationResultValid(
    ValidatedApplicationDataInterface $validatedApplicationData,
    JsonSchema $jsonSchema
  ): ApplicationValidationResult {
    return ApplicationValidationResult::newValid($validatedApplicationData, $this->isJsonSchemaReadOnly($jsonSchema));
  }

  protected function isJsonSchemaReadOnly(JsonSchema $jsonSchema): bool {
    return TRUE === $jsonSchema->getKeywordValueOrDefault('readOnly', FALSE);
  }

}
