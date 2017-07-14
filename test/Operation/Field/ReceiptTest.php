<?php
namespace Bricks\Business\Atol54\UnitTest\Operation\Field;

use PHPUnit\Framework\TestCase;
use Bricks\Business\Atol54\Operation\Field\Attributes;
use Bricks\Business\Atol54\Operation\Field\Item;
use Bricks\Business\Atol54\Operation\Field\ItemList;
use Bricks\Business\Atol54\Operation\Field\Payment;
use Bricks\Business\Atol54\Operation\Field\PaymentList;
use Bricks\Business\Atol54\Operation\Field\Receipt;

/**
 * @author Artur Sh. Mamedbekov
 */
class ReceiptTest extends TestCase{
  public function testToJson(){
    $attributes = new Attributes(Attributes::SNO_GENERAL, 'client@mail.com', '+79998887766');
    $itemList = new ItemList;
    $itemList->add(new Item('nameA', 1, 10.5, Item::TAX_NO));
    $itemList->add(new Item('nameB', 2, 10.5, Item::TAX_NO));
    $paymentList = new PaymentList;
    $paymentList->add(new Payment(1, 1));
    $paymentList->add(new Payment(1, 2));

    $this->assertEquals(
      sprintf(
        '{"attributes":%s,"items":%s,"payments":%s,"total":%s}',
        '{"sno":"osn","email":"client@mail.com","phone":"+79998887766"}',
        '[{"name":"nameA","quantity":1.000,"price":10.50,"sum":10.50,"tax":"none"},{"name":"nameB","quantity":2.000,"price":10.50,"sum":21.00,"tax":"none"}]',
        '[{"type":1,"sum":1.00},{"type":1,"sum":2.00}]',
        '31.50'
      ),
      (new Receipt($attributes, $itemList, $paymentList))->toJson()
    );
  }
}
