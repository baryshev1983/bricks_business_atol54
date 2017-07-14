<?php
namespace Bricks\Business\Atol54\UnitTest\Auth;

use PHPUnit\Framework\TestCase;
use Bricks\Business\Atol54\Auth\Auth;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;

/**
 * @author Artur Sh. Mamedbekov
 */
class AuthTest extends TestCase{
  public function testConstruct_testInvalidLogin(){
    $this->expectException(InvalidArgumentException::class);
    new Auth(1, 'pass');
  }

  public function testConstruct_testInvalidPass(){
    $this->expectException(InvalidArgumentException::class);
    new Auth('login', 1);
  }

  public function testToJson(){
    $auth = new Auth('foo', 'bar');

    $this->assertEquals('{"login":"foo","pass":"bar"}', $auth->toJson());
  }

  public function testToArray(){
    $auth = new Auth('foo', 'bar');
    
    $this->assertEquals([
      'login' => 'foo',
      'pass' => 'bar',
    ], $auth->toArray());
  }
}
