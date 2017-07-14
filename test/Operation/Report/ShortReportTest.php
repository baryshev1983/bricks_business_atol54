<?php
namespace Bricks\Business\Atol54\UnitTest\Operation\Report;

use PHPUnit\Framework\TestCase;
use DateTime;
use Bricks\Business\Atol54\Operation\Report\ShortReport;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;
use Bricks\Business\Atol54\Operation\Exception\BadResponseException;
use Bricks\Business\Atol54\Operation\Exception\BadRequestException;
use Bricks\Business\Atol54\Operation\Exception\IncomingBadRequestException;
use Bricks\Business\Atol54\Operation\Exception\OperationNotSupportException;
use Bricks\Business\Atol54\Operation\Exception\MissingTokenException;
use Bricks\Business\Atol54\Operation\Exception\NotExistTokenException;
use Bricks\Business\Atol54\Operation\Exception\ExpiredTokenException;
use Bricks\Business\Atol54\Operation\Exception\ExistExternalIdException;
use Bricks\Business\Atol54\Operation\Exception\GroupCodeToTokenException;

/**
 * @author Artur Sh. Mamedbekov
 */
class ShortReportTest extends TestCase{
  public function testConstruct_testInvalidUuid(){
    $this->expectException(InvalidArgumentException::class);
    new ShortReport(1, new DateTime, 'wait');
  }

  public function testConstruct_testInvalidStatus(){
    $this->expectException(InvalidArgumentException::class);
    new ShortReport('id', new DateTime, 'foo');
  }

  public function testFromJson(){
    $report = ShortReport::fromJson('{"uuid":"id","timestamp":"04.07.2017 22:57:00","error":null,"status":"wait"}');

    $this->assertEquals('id', $report->getUuid());
    $this->assertEquals(new DateTime('04.07.2017 22:57:00'), $report->getTimestamp());
    $this->assertEquals('wait', $report->getStatus());
  }

  public function testFromJson_testBadResponseExceptionWithoutUuid(){
    $this->expectException(BadResponseException::class);
    
    ShortReport::fromJson('{"timestamp":"04.07.2017 22:57:00","error":null,"status":"wait"}');
  }

  public function testFromJson_testBadResponseExceptionWithoutTimestamp(){
    $this->expectException(BadResponseException::class);
    
    ShortReport::fromJson('{"uuid":"id","error":null,"status":"wait"}');
  }

  public function testFromJson_testBadResponseExceptionWithoutError(){
    $this->expectException(BadResponseException::class);
    
    ShortReport::fromJson('{"uuid":"id","timestamp":"04.07.2017 22:57:00","status":"wait"}');
  }

  public function testFromJson_testBadResponseExceptionWithoutStatus(){
    $this->expectException(BadResponseException::class);
    
    ShortReport::fromJson('{"uuid":"id","timestamp":"04.07.2017 22:57:00","error":null}');
  }

  public function testFromJson_testBadRequestException(){
    $this->expectException(BadRequestException::class);
    
    ShortReport::fromJson('{"uuid":"id","timestamp":"04.07.2017 22:57:00","error":{"code":1,"text":"foo","type":"system"},"status":"fail"}');
  }

  public function testFromJson_testIncomingBadRequestException(){
    $this->expectException(IncomingBadRequestException::class);
    
    ShortReport::fromJson('{"uuid":"id","timestamp":"04.07.2017 22:57:00","error":{"code":2,"text":"foo","type":"system"},"status":"fail"}');
  }

  public function testFromJson_testOperationNotSupportException(){
    $this->expectException(OperationNotSupportException::class);
    
    ShortReport::fromJson('{"uuid":"id","timestamp":"04.07.2017 22:57:00","error":{"code":3,"text":"foo","type":"system"},"status":"fail"}');
  }

  public function testFromJson_testMissingTokenException(){
    $this->expectException(MissingTokenException::class);
    
    ShortReport::fromJson('{"uuid":"id","timestamp":"04.07.2017 22:57:00","error":{"code":4,"text":"foo","type":"system"},"status":"fail"}');
  }

  public function testFromJson_testNotExistTokenException(){
    $this->expectException(NotExistTokenException::class);
    
    ShortReport::fromJson('{"uuid":"id","timestamp":"04.07.2017 22:57:00","error":{"code":5,"text":"foo","type":"system"},"status":"fail"}');
  }

  public function testFromJson_testExpiredTokenException(){
    $this->expectException(ExpiredTokenException::class);
    
    ShortReport::fromJson('{"uuid":"id","timestamp":"04.07.2017 22:57:00","error":{"code":6,"text":"foo","type":"system"},"status":"fail"}');
  }

  public function testFromJson_testExistExternalIdException(){
    $this->expectException(ExistExternalIdException::class);
    
    ShortReport::fromJson('{"uuid":"id","timestamp":"04.07.2017 22:57:00","error":{"code":10,"text":"foo","type":"system"},"status":"fail"}');
  }

  public function testFromJson_testGroupCodeToTokenException(){
    $this->expectException(GroupCodeToTokenException::class);
    
    ShortReport::fromJson('{"uuid":"id","timestamp":"04.07.2017 22:57:00","error":{"code":22,"text":"foo","type":"system"},"status":"fail"}');
  }
}
