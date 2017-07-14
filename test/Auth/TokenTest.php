<?php
namespace Bricks\Business\Atol54\UnitTest\Auth;

use PHPUnit\Framework\TestCase;
use Bricks\Business\Atol54\Auth\Token;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;
use Bricks\Business\Atol54\Auth\Exception\BadResponseException;
use Bricks\Business\Atol54\Auth\Exception\AbstractAuthException;
use Bricks\Business\Atol54\Auth\Exception\BadRequestException;
use Bricks\Business\Atol54\Auth\Exception\GetTokenException;
use Bricks\Business\Atol54\Auth\Exception\WrongUserOrPasswordException;

/**
 * @author Artur Sh. Mamedbekov
 */
class TokenTest extends TestCase{
  public function testConstruct_testInvalidCodeType(){
    $this->expectException(InvalidArgumentException::class);
    new Token([], '');
  }

  public function testConstruct_testInvalidCodeValude(){
    $this->expectException(InvalidArgumentException::class);
    new Token(2, '');
  }

  public function testConstruct_testInvalidToken(){
    $this->expectException(InvalidArgumentException::class);
    new Token(Token::CODE_NEW, 1);
  }

  public function testFromJson(){
    $token = Token::fromJson('{"code":0,"text":null,"token":"foo"}');

    $this->assertEquals(0, $token->getCode());
    $this->assertEquals('foo', $token);
  }

  public function testFromJson_testBadResponseExceptionWithoutCode(){
    $this->expectException(BadResponseException::class);
    
    Token::fromJson('{"text":null,"token":"foo"}');
  }

  public function testFromJson_testBadResponseExceptionWithoutToken(){
    $this->expectException(BadResponseException::class);
    
    Token::fromJson('{"code":0,"text":null}');
  }

  public function testFromJson_testBadRequestException(){
    $this->expectException(BadRequestException::class);
    
    Token::fromJson('{"code":17,"text":"foo","token":""}');
  }

  public function testFromJson_testGetTokenException(){
    $this->expectException(GetTokenException::class);
    
    Token::fromJson('{"code":18,"text":"foo","token":""}');
  }

  public function testFromJson_testWrongUserOrPasswordException(){
    $this->expectException(WrongUserOrPasswordException::class);
    
    Token::fromJson('{"code":19,"text":"foo","token":""}');
  }
}
