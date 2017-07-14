<?php
namespace Bricks\Business\Atol54\UnitTest\Operation\Field;

use PHPUnit\Framework\TestCase;
use Bricks\Business\Atol54\Operation\Field\Payment;
use Bricks\Business\Atol54\Operation\Field\PaymentList;
use Bricks\Business\Atol54\Exception\OverflowException;

/**
 * @author Artur Sh. Mamedbekov
 */
class PaymentListTest extends TestCase{
  public function testAdd_shouldThrowExceptionIfListFilled(){
    $paymentList = new PaymentList;
    for($i = 0; $i < 10; $i++){
      $paymentList->add(new Payment(1, 1));
    }

    $this->expectException(OverflowException::class);
    $paymentList->add(new Payment(1, 1));
  }
  
  public function testToJson(){
    $paymentList = new PaymentList;
    $paymentList->add(new Payment(1, 1));
    $paymentList->add(new Payment(1, 2));

    $this->assertEquals(
      '[{"type":1,"sum":1.00},{"type":1,"sum":2.00}]',
      $paymentList->toJson()
    );
  }
}
