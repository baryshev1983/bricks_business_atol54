<?php
namespace Bricks\Business\Atol54\UnitTest\Operation\Field;

use PHPUnit\Framework\TestCase;
use Bricks\Business\Atol54\Operation\Field\Payment;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;

/**
 * @author Artur Sh. Mamedbekov
 */
class PaymentTest extends TestCase{
  public function testConstruct_testInvalidSum(){
    $this->expectException(InvalidArgumentException::class);
    new Payment(1, []);
  }

  public function testConstruct_testInvalidType(){
    $this->expectException(InvalidArgumentException::class);
    new Payment([], 1);
  }

  public function testConstruct_testInvalidTypeValue(){
    $this->expectException(InvalidArgumentException::class);
    new Payment(0, 1);
  }

  public function testToJson(){
    $this->assertEquals(
      '{"type":1,"sum":10.50}',
      (new Payment(1, 10.5))->toJson()
    );
  }
}
