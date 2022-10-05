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

use Civi\Funding\Form\Traits\AssertFormTrait;
use Civi\Funding\Form\Validation\OpisValidatorFactory;
use Civi\Funding\Util\FormTestUtil;
use Civi\RemoteTools\Form\JsonForms\Control\JsonFormsHidden;
use Civi\RemoteTools\Form\JsonForms\Control\JsonFormsSubmitButton;
use Civi\RemoteTools\Form\JsonSchema\JsonSchema;
use Civi\RemoteTools\Form\JsonSchema\JsonSchemaString;
use Opis\JsonSchema\Errors\ErrorFormatter;
use PHPUnit\Framework\TestCase;
use Systopia\JsonSchema\Errors\ErrorCollector;

/**
 * @covers \Civi\Funding\Form\SonstigeAktivitaet\AVK1Form
 * @covers \Civi\Funding\Form\SonstigeAktivitaet\JsonSchema\AVK1JsonSchema
 * @covers \Civi\Funding\Form\SonstigeAktivitaet\UISchema\AVK1UiSchema
 */
class AVK1FormTest extends TestCase {

  use AssertFormTrait;

  public function testJsonSchema(): void {
    $fooSchemaString = new JsonSchemaString();
    $form = new AVK1Form(
      new \DateTime('2022-08-24'),
      new \DateTime('2022-08-25'),
      '€',
      ['submitAction1' => 'Do Submit1', 'submitAction2' => 'Do Submit2'],
      ['foo' => $fooSchemaString],
      ['foo' => 'bar']
    );

    $jsonSchema = $form->getJsonSchema();
    $properties = $jsonSchema->getKeywordValue('properties');
    static::assertInstanceOf(JsonSchema::class, $properties);
    static::assertSame($fooSchemaString, $properties->getKeywordValue('foo'));
    static::assertEquals(
      new JsonSchemaString(['enum' => ['submitAction1', 'submitAction2']]),
      $properties->getKeywordValue('action')
    );
    static::assertSame(['foo' => 'bar'], $form->getData());

    $data = (object) [
      'action' => 'submitAction1',
      'titel' => 'Test',
      'kurzbezeichnungDesInhalts' => 'foo bar',
      'beginn' => '2022-08-24',
      'ende' => '2022-08-25',
      'kosten' => (object) [
        'unterkunftUndVerpflegung' => 222.22,
        'honorare' => [
          (object) [
            'stunden' => 11.1,
            'verguetung' => 22.22,
            'zweck' => 'Honorar 1',
          ],
          (object) [
            'stunden' => 9.9,
            'verguetung' => 10,
            'zweck' => 'Honorar 2',
          ],
        ],
        'fahrtkosten' => (object) [
          'intern' => 2.2,
          'anTeilnehmerErstattet' => 3.3,
        ],
        'sachkosten' => (object) [
          'haftungKfz' => 4.4,
          'ausstattung' => [
            (object) [
              'gegenstand' => 'Thing1',
              'betrag' => 5.5,
            ],
            (object) [
              'gegenstand' => 'Thing2',
              'betrag' => 6.6,
            ],
          ],
        ],
        'sonstigeAusgaben' => [
          (object) [
            'betrag' => 12.34,
            'zweck' => 'Sonstige Ausgaben 1',
          ],
          (object) [
            'betrag' => 56.78,
            'zweck' => 'Sonstige Ausgaben 2',
          ],
        ],
        'versicherungTeilnehmer' => 9.9,
      ],
      'finanzierung' => (object) [
        'teilnehmerbeitraege' => 100.00,
        'eigenmittel' => 10.00,
        'oeffentlicheMittel' => (object) [
          'europa' => 1.11,
          'bundeslaender' => 2.22,
          'staedteUndKreise' => 3.33,
        ],
        'sonstigeMittel' => [
          (object) [
            'betrag' => 1.0,
            'quelle' => 'Quelle 1',
          ],
          (object) [
            'betrag' => 2.0,
            'quelle' => 'Quelle 2',
          ],
        ],
      ],
      'foo' => 'baz',
    ];

    $validator = OpisValidatorFactory::getValidator();
    $result = $validator->validate($data, \json_encode($jsonSchema));
    if (NULL !== $result->error()) {
      $errorFormatter = new ErrorFormatter();
      // Will fail, but we'll know why
      static::assertSame([], $errorFormatter->formatKeyed($result->error()));
    }

    $unterkunftUndVerpflegung = 222.22;
    $honorar1 = round(11.1 * 22.22, 2);
    static::assertSame($honorar1, $data->kosten->honorare[0]->betrag);
    $honorar2 = round(9.9 * 10, 2);
    static::assertSame($honorar2, $data->kosten->honorare[1]->betrag);
    $honorareGesamt = $honorar1 + $honorar2;
    static::assertSame($honorareGesamt, $data->kosten->honorareGesamt);
    $fahrtkostenGesamt = 2.2 + 3.3;
    static::assertSame($fahrtkostenGesamt, $data->kosten->fahrtkostenGesamt);
    $sachkostenGesamt = 4.4 + 5.5 + 6.6;
    static::assertSame($sachkostenGesamt, $data->kosten->sachkostenGesamt);
    $sonstigeAusgabenGesamt = 12.34 + 56.78;
    static::assertSame($sonstigeAusgabenGesamt, $data->kosten->sonstigeAusgabenGesamt);
    $versicherungTeilnehmer = 9.9;
    $gesamtkosten = $unterkunftUndVerpflegung
      + $honorareGesamt
      + $fahrtkostenGesamt
      + $sachkostenGesamt
      + $sonstigeAusgabenGesamt
      + $versicherungTeilnehmer;
    static::assertSame($gesamtkosten, $data->kosten->gesamtkosten);

    $oeffentlicheMittelGesamt = 1.11 + 2.22 + 3.33;
    static::assertSame($oeffentlicheMittelGesamt, $data->finanzierung->oeffentlicheMittelGesamt);
    $sonstigeMittelGesamt = 1.0 + 2.0;
    static::assertSame($sonstigeMittelGesamt, $data->finanzierung->sonstigeMittelGesamt);
    $gesamtmittel = 100.00 + 10.00 + $oeffentlicheMittelGesamt + $sonstigeMittelGesamt;
    static::assertSame($gesamtmittel, $data->finanzierung->gesamtmittel);

    static::assertSame($gesamtkosten - $gesamtmittel, $data->finanzierung->beantragterZuschuss);

    $data->foo = 'bar';
    static::assertAllPropertiesSet($jsonSchema->toStdClass(), $data);
  }

  public function testNotAllowedDates(): void {
    $form = new AVK1Form(
      new \DateTime('2022-08-24'),
      new \DateTime('2022-08-25'),
      '€',
      ['submitAction' => 'Do Submit'],
      [],
      [],
    );

    $data = (object) [
      'beginn' => '2022-08-23',
      'ende' => '2022-08-26',
    ];

    $jsonSchema = $form->getJsonSchema();
    $validator = OpisValidatorFactory::getValidator();
    $validator->setMaxErrors(20);
    $errorCollector = new ErrorCollector();
    $validator->validate($data, \json_encode($jsonSchema), ['errorCollector' => $errorCollector]);

    $beginnErrors = $errorCollector->getErrorsAt('/beginn');
    static::assertCount(1, $beginnErrors);
    static::assertSame('minDate', $beginnErrors[0]->keyword());
    $endeErrors = $errorCollector->getErrorsAt('/ende');
    static::assertCount(1, $endeErrors);
    static::assertSame('maxDate', $endeErrors[0]->keyword());
  }

  public function testEndeBeforeBeginn(): void {
    $form = new AVK1Form(
      new \DateTime('2022-08-24'),
      new \DateTime('2022-08-25'),
      '€',
      ['submitAction' => 'Do Submit'],
      [],
      []
    );

    $data = (object) [
      'beginn' => '2022-08-25',
      'ende' => '2022-08-24',
    ];

    $jsonSchema = $form->getJsonSchema();
    $validator = OpisValidatorFactory::getValidator();
    $errorCollector = new ErrorCollector();
    $validator->validate($data, \json_encode($jsonSchema), ['errorCollector' => $errorCollector]);

    static::assertFalse($errorCollector->hasErrorAt('/beginn'));
    $endeErrors = $errorCollector->getErrorsAt('/ende');
    static::assertCount(1, $endeErrors);
    static::assertSame('minDate', $endeErrors[0]->keyword());
  }

  public function testUiSchema(): void {
    $form = new AVK1Form(
      new \DateTime('2022-08-24'),
      new \DateTime('2022-08-25'),
      '€',
      ['submitAction1' => 'Do Submit1', 'submitAction2' => 'Do Submit2'],
      ['hidden' => new JsonSchemaString()],
      ['foo' => 'bar']
    );

    $uiSchema = $form->getUiSchema();
    static::assertNull($uiSchema->isReadonly());
    static::assertScopesExist($form->getJsonSchema()->toStdClass(), $uiSchema);
    static::assertScopeExists('#/properties/action', $uiSchema);

    static::assertControlInSchemaEquals(
      new JsonFormsHidden('#/properties/hidden'),
      $form->getUiSchema()
    );

    static::assertEquals(
      [
        new JsonFormsSubmitButton('#/properties/action', 'Do Submit1', 'submitAction1'),
        new JsonFormsSubmitButton('#/properties/action', 'Do Submit2', 'submitAction2'),
      ],
      FormTestUtil::getControlsWithScope('#/properties/action', $uiSchema)
    );
  }

}
