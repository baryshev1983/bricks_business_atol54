<?php
namespace Bricks\Business\Atol54\UnitTest\Operation\Field;

use PHPUnit\Framework\TestCase;
use Bricks\Business\Atol54\Operation\Field\Item;
use Bricks\Business\Atol54\Operation\Field\ItemList;
use Bricks\Business\Atol54\Exception\OverflowException;

/**
 * @author Artur Sh. Mamedbekov
 */
class ItemListTest extends TestCase{
  public function testAdd_shouldThrowExceptionIfListFilled(){
    $itemList = new ItemList;
    for($i = 0; $i < 100; $i++){
      $itemList->add(new Item('name', 1, 1, Item::TAX_NO));
    }

    $this->expectException(OverflowException::class);
    $itemList->add(new Item('name', 1, 1, Item::TAX_NO));
  }
  
  public function testToJson(){
    $itemList = new ItemList;
    $itemList->add(new Item('nameA', 1, 10.5, Item::TAX_NO));
    $itemList->add(new Item('nameB', 2, 10.5, Item::TAX_NO));

    $this->assertEquals(
      '[{"name":"nameA","quantity":1.000,"price":10.50,"sum":10.50,"tax":"none"},{"name":"nameB","quantity":2.000,"price":10.50,"sum":21.00,"tax":"none"}]',
      $itemList->toJson()
    );
  }

  public function testGetSum(){
    $itemList = new ItemList;
    $itemList->add(new Item('nameA', 1, 1, Item::TAX_NO));
    $itemList->add(new Item('nameB', 2, 1.5, Item::TAX_NO));

    $this->assertEquals(4.0, $itemList->getSum());
  }
}
