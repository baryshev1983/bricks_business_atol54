<?php
namespace Bricks\Business\Atol54\UnitTest\Operation\Field;

use PHPUnit\Framework\TestCase;
use Bricks\Business\Atol54\Operation\Field\Item;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;

/**
 * @author Artur Sh. Mamedbekov
 */
class ItemTest extends TestCase{
  public function testConstruct_testInvalidName(){
    $this->expectException(InvalidArgumentException::class);
    new Item([], 1, 1, Item::TAX_NO);
  }

  public function testConstruct_testInvalidNameLen(){
    $this->expectException(InvalidArgumentException::class);
    new Item(str_repeat('a', 65), 1, 1, Item::TAX_NO);
  }

  public function testConstruct_testInvalidQuantity(){
    $this->expectException(InvalidArgumentException::class);
    new Item('name', [], 1, Item::TAX_NO);
  }

  public function testConstruct_testInvalidTaxType(){
    $this->expectException(InvalidArgumentException::class);
    new Item('name', 1, 1, []);
  }

  public function testConstruct_testInvalidTaxValue(){
    $this->expectException(InvalidArgumentException::class);
    new Item('name', 1, 1, 'foo');
  }

  public function testToJson(){
    $this->assertEquals(
      '{"name":"Зеленый чай \"Юн Ву\", кг","quantity":2.000,"price":10.50,"sum":21.00,"tax":"none"}',
      (new Item('Зеленый чай "Юн Ву", кг', 2, 10.5, Item::TAX_NO))->toJson()
    );
  }
}
