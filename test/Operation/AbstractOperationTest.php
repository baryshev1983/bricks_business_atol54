<?php
namespace Bricks\Business\Atol54\UnitTest\Operation;

use PHPUnit\Framework\TestCase;
use DateTime;
use Bricks\Business\Atol54\Operation\Field\Attributes;
use Bricks\Business\Atol54\Operation\Field\Item;
use Bricks\Business\Atol54\Operation\Field\ItemList;
use Bricks\Business\Atol54\Operation\Field\Payment;
use Bricks\Business\Atol54\Operation\Field\PaymentList;
use Bricks\Business\Atol54\Operation\Field\Receipt;
use Bricks\Business\Atol54\Operation\Field\Service;
use Bricks\Business\Atol54\UnitTest\Operation\Mock\MockOperation;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;

/**
 * @author Artur Sh. Mamedbekov
 */
class AbstractOperationTest extends TestCase{
  /**
   * @var Receipt
   */
  private $defaultReceipt;

  /**
   * @var Service
   */
  private $defaultService;

  /**
   * {@inheritdoc}
   */
  public function setUp(){
    $attributes = new Attributes(Attributes::SNO_GENERAL, 'client@mail.com', '+79998887766');
    $itemList = new ItemList;
    $itemList->add(new Item('nameA', 1, 10.5, Item::TAX_NO));
    $itemList->add(new Item('nameB', 2, 10.5, Item::TAX_NO));
    $paymentList = new PaymentList;
    $paymentList->add(new Payment(1, 1));
    $paymentList->add(new Payment(1, 2));
    $this->defaultReceipt = new Receipt($attributes, $itemList, $paymentList);
    $this->defaultService = new Service('1234567890', 'seller.com', 'http://seller.com/callback');
  }

  public function testConstruct_testInvalidExternalId(){
    $this->expectException(InvalidArgumentException::class);
    new MockOperation(1, $this->defaultReceipt, $this->defaultService);
  }

  public function testConstruct_testInvalidExternalIdLength(){
    $this->expectException(InvalidArgumentException::class);
    new MockOperation(str_repeat('a', 257), $this->defaultReceipt, $this->defaultService);
  }

  public function testToJson(){
    $this->assertEquals(
      sprintf(
        '{"external_id":"foo","receipt":{"attributes":%s,"items":%s,"payments":%s,"total":%s},"service":{"inn":"1234567890","payment_address":"seller.com","callback_url":"http:\/\/seller.com\/callback"},"timestamp":"04.07.2017 22:11:00"}',
        '{"sno":"osn","email":"client@mail.com","phone":"+79998887766"}',
        '[{"name":"nameA","quantity":1.000,"price":10.50,"sum":10.50,"tax":"none"},{"name":"nameB","quantity":2.000,"price":10.50,"sum":21.00,"tax":"none"}]',
        '[{"type":1,"sum":1.00},{"type":1,"sum":2.00}]',
        '31.50'
      ),
      (new MockOperation('foo', $this->defaultReceipt, $this->defaultService, new DateTime('04.07.2017 22:11:00')))->toJson()
    );
  }
}
