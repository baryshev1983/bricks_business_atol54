<?php
namespace Bricks\Business\Atol54\UnitTest\Operation\Report;

use PHPUnit\Framework\TestCase;
use DateTime;
use Bricks\Business\Atol54\Operation\Report\Field\Payload;
use Bricks\Business\Atol54\Operation\Report\FullReport;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;
use Bricks\Business\Atol54\Operation\Exception\BadResponseException;
use Bricks\Business\Atol54\Operation\Exception\QueueTimeoutException;
use Bricks\Business\Atol54\Operation\Exception\ValidationException;
use Bricks\Business\Atol54\Operation\Exception\QueueException;
use Bricks\Business\Atol54\Operation\Exception\StateBadRequestException;
use Bricks\Business\Atol54\Operation\Exception\StateMissingTokenException;
use Bricks\Business\Atol54\Operation\Exception\StateNotExistTokenException;
use Bricks\Business\Atol54\Operation\Exception\StateExpiredTokenException;
use Bricks\Business\Atol54\Operation\Exception\StateMissingUuidException;
use Bricks\Business\Atol54\Operation\Exception\StateNotFoundException;

/**
 * @author Artur Sh. Mamedbekov
 */
class FullReportTest extends TestCase{
  /**
   * @var Payload
   */
  private $defaultPayload;

  /**
   * {@inheritdoc}
   */
  public function setUp(){
    $this->defaultPayload = new Payload(
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
  }

  public function testConstruct_testInvalidGroupCode(){
    $this->expectException(InvalidArgumentException::class);
    new FullReport('id', new DateTime, 'wait', $this->defaultPayload, [], 'prod-agent-1', 'KSR13.00-1-11', 'callback');
  }

  public function testConstruct_testInvalidDaemonCode(){
    $this->expectException(InvalidArgumentException::class);
    new FullReport('id', new DateTime, 'wait', $this->defaultPayload, 'MyCompany_MyShop', [], 'KSR13.00-1-11', 'callback');
  }

  public function testConstruct_testInvalidDeviceCode(){
    $this->expectException(InvalidArgumentException::class);
    new FullReport('id', new DateTime, 'wait', $this->defaultPayload, 'MyCompany_MyShop', 'prod-agent-1', [], 'callback');
  }

  public function testConstruct_testInvalidCallbackUrl(){
    $this->expectException(InvalidArgumentException::class);
    new FullReport('id', new DateTime, 'wait', $this->defaultPayload, 'MyCompany_MyShop', 'prod-agent-1', 'KSR13.00-1-11', []);
  }

  public function testFromJson(){
    $json = '{
      "uuid":"2ea26f17-0884-4f08-b120-306fc096a58f",
      "error":null,
      "status":"done",
      "payload":{
        "total":1598,
        "fns_site":"www.nalog.ru",
        "fn_number":"1110000100238211",
        "shift_number":23,
        "receipt_datetime":"12.04.2017 20:16:00",
        "fiscal_receipt_number":6,
        "fiscal_document_number":133,
        "ecr_registration_number":"0000111118041361",
        "fiscal_document_attribute":3449555941
      },
      "timestamp":"12.04.2017 20:15:08",
      "group_code":"MyCompany_MyShop",
      "daemon_code":"prod-agent-1",
      "device_code":"KSR13.00-1-11",
      "callback_url":"callback"
    }';
    $report = FullReport::fromJson($json);

    $this->assertEquals($this->defaultPayload, $report->getPayload());
    $this->assertEquals('MyCompany_MyShop', $report->getGroupCode());
    $this->assertEquals('prod-agent-1', $report->getDaemonCode());
    $this->assertEquals('KSR13.00-1-11', $report->getDeviceCode());
    $this->assertEquals('callback', $report->getCallbackUrl());
  }

  public function testFromJson_testQueueTimeoutException(){
    $this->expectException(QueueTimeoutException::class);
    
    FullReport::fromJson('{"error":{"code":7}}');
  }

  public function testFromJson_testValidationException(){
    $this->expectException(ValidationException::class);
    
    FullReport::fromJson('{"error":{"code":8}}');
  }

  public function testFromJson_testQueueException(){
    $this->expectException(QueueException::class);
    
    FullReport::fromJson('{"error":{"code":9}}');
  }

  public function testFromJson_testStateBadRequestException(){
    $this->expectException(StateBadRequestException::class);
    
    FullReport::fromJson('{"error":{"code":11}}');
  }

  public function testFromJson_testStateMissingTokenException(){
    $this->expectException(StateMissingTokenException::class);
    
    FullReport::fromJson('{"error":{"code":12}}');
  }

  public function testFromJson_testStateNotExistTokenException(){
    $this->expectException(StateNotExistTokenException::class);
    
    FullReport::fromJson('{"error":{"code":13}}');
  }

  public function testFromJson_testStateExpiredTokenException(){
    $this->expectException(StateExpiredTokenException::class);
    
    FullReport::fromJson('{"error":{"code":14}}');
  }

  public function testFromJson_testStateMissingUuidException(){
    $this->expectException(StateMissingUuidException::class);
    
    FullReport::fromJson('{"error":{"code":15}}');
  }

  public function testFromJson_testStateNotFoundException(){
    $this->expectException(StateNotFoundException::class);
    
    FullReport::fromJson('{"error":{"code":16}}');
  }
}
