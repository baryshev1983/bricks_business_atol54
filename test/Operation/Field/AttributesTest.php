<?php
namespace Bricks\Business\Atol54\UnitTest\Operation\Field;

use PHPUnit\Framework\TestCase;
use Bricks\Business\Atol54\Operation\Field\Attributes;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;

/**
 * @author Artur Sh. Mamedbekov
 */
class AttributesTest extends TestCase{
  public function testConstruct_testInvalidSnoType(){
    $this->expectException(InvalidArgumentException::class);
    new Attributes([], '');
  }

  public function testConstruct_testInvalidSnoValue(){
    $this->expectException(InvalidArgumentException::class);
    new Attributes('', '');
  }

  public function testConstruct_testNotFoundEmailAndPhone(){
    $this->expectException(InvalidArgumentException::class);
    new Attributes(Attributes::SNO_GENERAL);
  }

  public function testConstruct_testInvalidEmailLength(){
    $this->expectException(InvalidArgumentException::class);
    new Attributes(Attributes::SNO_GENERAL, str_repeat('a', 65));
  }

  public function testConstruct_testInvalidPhoneLength(){
    $this->expectException(InvalidArgumentException::class);
    new Attributes(Attributes::SNO_GENERAL, null, str_repeat('a', 65));
  }

  public function testToJson(){
    $attributes = new Attributes(Attributes::SNO_GENERAL, 'client@mail.com', '+79998887766');
    
    $this->assertEquals(
      '{"sno":"osn","email":"client@mail.com","phone":"+79998887766"}',
      $attributes->toJson()
    );
  }

  public function testToJson_withoutEmail(){
    $attributes = new Attributes(Attributes::SNO_GENERAL, null, '+79998887766');
    
    $this->assertEquals(
      '{"sno":"osn","phone":"+79998887766"}',
      $attributes->toJson()
    );
  }

  public function testToJson_withoutPhone(){
    $attributes = new Attributes(Attributes::SNO_GENERAL, 'client@mail.com', null);
    
    $this->assertEquals(
      '{"sno":"osn","email":"client@mail.com"}',
      $attributes->toJson()
    );
  }
}
