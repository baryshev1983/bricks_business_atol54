<?php
namespace Bricks\Business\Atol54\UnitTest\Operation\Field;

use PHPUnit\Framework\TestCase;
use Bricks\Business\Atol54\Operation\Field\Service;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;

/**
 * @author Artur Sh. Mamedbekov
 */
class ServiceTest extends TestCase{
  public function testConstruct_testInvalidInn(){
    $this->expectException(InvalidArgumentException::class);
    new Service(1, 'foo');
  }

  public function testConstruct_testInvalidInnLength(){
    $this->expectException(InvalidArgumentException::class);
    new Service('123', 'foo');
  }

  public function testConstruct_testInvalidPaymentAddress(){
    $this->expectException(InvalidArgumentException::class);
    new Service(str_repeat('1', 10), 1);
  }

  public function testConstruct_testInvalidPaymentAddressLength(){
    $this->expectException(InvalidArgumentException::class);
    new Service(str_repeat('1', 10), str_repeat('a', 257));
  }

  public function testConstruct_testInvalidCallbackUrlLength(){
    $this->expectException(InvalidArgumentException::class);
    new Service(str_repeat('1', 10), 'foo', str_repeat('a', 257));
  }

  public function testToJson(){
    $this->assertEquals(
      '{"inn":"1234567890","payment_address":"seller.com","callback_url":"http:\/\/seller.com\/callback"}',
      (new Service('1234567890', 'seller.com', 'http://seller.com/callback'))->toJson()
    );
  }
}
