<?php
namespace Bricks\Business\Atol54\UnitTest\Operation\Report\Field;

use PHPUnit\Framework\TestCase;
use DateTime;
use Bricks\Business\Atol54\Operation\Report\Field\Payload;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;
use Bricks\Business\Atol54\Operation\Exception\BadResponseException;

/**
 * @author Artur Sh. Mamedbekov
 */
class PayloadTest extends TestCase{
  public function testConstruct(){
    $payload = new Payload(
      1598,
      'www.nalog.ru',
      '1110000100238211',
      23,
      new DateTime('12.04.2017 20:16:00'),
      6,
      133,
      3449555941,
      '0000111118041361'
    );

    $this->assertEquals(1598, $payload->getTotal());
  }

  public function testConstruct_testInvalidTotal(){
    $this->expectException(InvalidArgumentException::class);
    new Payload(
      [],
      'www.nalog.ru',
      '1110000100238211',
      23,
      new DateTime('12.04.2017 20:16:00'),
      6,
      133,
      3449555941,
      '0000111118041361'
    );
  }

  public function testConstruct_testInvalidFnsSite(){
    $this->expectException(InvalidArgumentException::class);
    new Payload(
      1598,
      [],
      '1110000100238211',
      23,
      new DateTime('12.04.2017 20:16:00'),
      6,
      133,
      3449555941,
      '0000111118041361'
    );
  }

  public function testConstruct_testInvalidFnNumber(){
    $this->expectException(InvalidArgumentException::class);
    new Payload(
      1598,
      'www.nalog.ru',
      [],
      23,
      new DateTime('12.04.2017 20:16:00'),
      6,
      133,
      3449555941,
      '0000111118041361'
    );
  }

  public function testConstruct_testInvalidShiftNumber(){
    $this->expectException(InvalidArgumentException::class);
    new Payload(
      1598,
      'www.nalog.ru',
      '1110000100238211',
      [],
      new DateTime('12.04.2017 20:16:00'),
      6,
      133,
      3449555941,
      '0000111118041361'
    );
  }

  public function testConstruct_testInvalidFiscalReceiptNumber(){
    $this->expectException(InvalidArgumentException::class);
    new Payload(
      1598,
      'www.nalog.ru',
      '1110000100238211',
      23,
      new DateTime('12.04.2017 20:16:00'),
      [],
      133,
      3449555941,
      '0000111118041361'
    );
  }

  public function testConstruct_testInvalidFiscalDocumentNumber(){
    $this->expectException(InvalidArgumentException::class);
    new Payload(
      1598,
      'www.nalog.ru',
      '1110000100238211',
      23,
      new DateTime('12.04.2017 20:16:00'),
      6,
      [],
      3449555941,
      '0000111118041361'
    );
  }

  public function testConstruct_testInvalidFiscalDocumentAttribute(){
    $this->expectException(InvalidArgumentException::class);
    new Payload(
      1598,
      'www.nalog.ru',
      '1110000100238211',
      23,
      new DateTime('12.04.2017 20:16:00'),
      6,
      133,
      [],
      '0000111118041361'
    );
  }

  public function testConstruct_testInvalidEcrRegistrationNumber(){
    $this->expectException(InvalidArgumentException::class);
    new Payload(
      1598,
      'www.nalog.ru',
      '1110000100238211',
      23,
      new DateTime('12.04.2017 20:16:00'),
      6,
      133,
      3449555941,
      []
    );
  }

  public function testFromJson_testBadResponseExceptionWithoutTotal(){
    $this->expectException(BadResponseException::class);
    
    Payload::fromJson('{"fns_site":"www.nalog.ru","fn_number":"1110000100238211","shift_number":23,"receipt_datetime":"12.04.2017 20:16:00","fiscal_receipt_number":6,"fiscal_document_number":133,"ecr_registration_number":"0000111118041361","fiscal_document_attribute":3449555941}');
  }

  public function testFromJson_testBadResponseExceptionWithoutFnsSite(){
    $this->expectException(BadResponseException::class);
    
    Payload::fromJson('{"total":1598,"fn_number":"1110000100238211","shift_number":23,"receipt_datetime":"12.04.2017 20:16:00","fiscal_receipt_number":6,"fiscal_document_number":133,"ecr_registration_number":"0000111118041361","fiscal_document_attribute":3449555941}');
  }

  public function testFromJson_testBadResponseExceptionWithoutFnNumber(){
    $this->expectException(BadResponseException::class);
    
    Payload::fromJson('{"total":1598,"fns_site":"www.nalog.ru","shift_number":23,"receipt_datetime":"12.04.2017 20:16:00","fiscal_receipt_number":6,"fiscal_document_number":133,"ecr_registration_number":"0000111118041361","fiscal_document_attribute":3449555941}');
  }

  public function testFromJson_testBadResponseExceptionWithoutShiftNumber(){
    $this->expectException(BadResponseException::class);
    
    Payload::fromJson('{"total":1598,"fns_site":"www.nalog.ru","fn_number":"1110000100238211","receipt_datetime":"12.04.2017 20:16:00","fiscal_receipt_number":6,"fiscal_document_number":133,"ecr_registration_number":"0000111118041361","fiscal_document_attribute":3449555941}');
  }

  public function testFromJson_testBadResponseExceptionWithoutReceiptDatetime(){
    $this->expectException(BadResponseException::class);
    
    Payload::fromJson('{"total":1598,"fns_site":"www.nalog.ru","fn_number":"1110000100238211","shift_number":23,"fiscal_receipt_number":6,"fiscal_document_number":133,"ecr_registration_number":"0000111118041361","fiscal_document_attribute":3449555941}');
  }

  public function testFromJson_testBadResponseExceptionWithoutFiscalReceiptNumber(){
    $this->expectException(BadResponseException::class);
    
    Payload::fromJson('{"total":1598,"fns_site":"www.nalog.ru","fn_number":"1110000100238211","shift_number":23,"receipt_datetime":"12.04.2017 20:16:00","fiscal_document_number":133,"ecr_registration_number":"0000111118041361","fiscal_document_attribute":3449555941}');
  }

  public function testFromJson_testBadResponseExceptionWithoutFiscalDocumentNumber(){
    $this->expectException(BadResponseException::class);
    
    Payload::fromJson('{"total":1598,"fns_site":"www.nalog.ru","fn_number":"1110000100238211","shift_number":23,"receipt_datetime":"12.04.2017 20:16:00","fiscal_receipt_number":6,"ecr_registration_number":"0000111118041361","fiscal_document_attribute":3449555941}');
  }

  public function testFromJson_testBadResponseExceptionWithoutFiscalDocumentAttribute(){
    $this->expectException(BadResponseException::class);
    
    Payload::fromJson('{"total":1598,"fns_site":"www.nalog.ru","fn_number":"1110000100238211","shift_number":23,"receipt_datetime":"12.04.2017 20:16:00","fiscal_receipt_number":6,"fiscal_document_number":133,"ecr_registration_number":"0000111118041361"}');
  }

  public function testFromJson_testBadResponseExceptionWithoutEcrRegistrationNumber(){
    $this->expectException(BadResponseException::class);
    
    Payload::fromJson('{"total":1598,"fns_site":"www.nalog.ru","fn_number":"1110000100238211","shift_number":23,"receipt_datetime":"12.04.2017 20:16:00","fiscal_receipt_number":6,"fiscal_document_number":133,"fiscal_document_attribute":3449555941}');
  }
}
