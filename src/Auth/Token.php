<?php
namespace Bricks\Business\Atol54\Auth;

use stdClass;
use Bricks\Business\Atol54\JsonUnserializableInterface;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;
use Bricks\Business\Atol54\Auth\Exception\BadResponseException;
use Bricks\Business\Atol54\Auth\Exception\AbstractAuthException;
use Bricks\Business\Atol54\Auth\Exception\BadRequestException;
use Bricks\Business\Atol54\Auth\Exception\GetTokenException;
use Bricks\Business\Atol54\Auth\Exception\WrongUserOrPasswordException;

/**
 * Токен авторизации.
 *
 * @author Artur Sh. Mamedbekov
 */
class Token implements JsonUnserializableInterface{
  /**
   * Новый токен.
   */
  const CODE_NEW = 0;

  /**
   * Сгенерированный ранее токен.
   */
  const CODE_OLD = 1;

  /**
   * @var array Карта соответствий статусов токена к исключениям.
   */
  private static $codeMap = [
    17 => BadRequestException::class,
    18 => GetTokenException::class,
    19 => WrongUserOrPasswordException::class,
  ];

  /**
   * @var int Статус токена.
   *
   * @see self::CODE_*
   */
  private $code;

  /**
   * @var string Токен.
   */
  private $token;

  /**
   * @return int[] Коды статуса токена.
   */
  public static function getCodeValues(){
    return [
      self::CODE_NEW,
      self::CODE_OLD,
    ];
  }

  /**
   * {@inheritdoc}
   *
   * @throws BadResponseException
   * @throws AbstractAuthException
   */
  public static function fromJson($json){
    if(is_string($json)){
      $json = json_decode($json);
    }

    if(!property_exists($json, 'code')){
      throw new BadResponseException('Required parameter "code" not found');
    }

    $code = (int) $json->code;
    if(!isset(self::$codeMap[$code])){
      if(!property_exists($json, 'token')){
        throw new BadResponseException('Required parameter "token" not found');
      }

      return new self($code, $json->token);
    }
    else{
      $exceptionClass = self::$codeMap[$code];
      throw new $exceptionClass;
    }
  }

  /**
   * @param int|string|float $code Статус токена.
   * @param string $token Токен.
   *
   * @throws InvalidArgumentException
   *
   * @see self::CODE_*
   */
  public function __construct($code, $token){
    if(!is_string($code) && !is_int($code)){
      throw InvalidArgumentException::fromParam('code', 'int|string', $code);
    }
    $code = (int) $code;
    if(!in_array($code, self::getCodeValues())){
      throw new InvalidArgumentException(sprintf(
        'The "code" should be "[0-1]", %s given',
        $code
      ));
    }
    $this->code = $code;
    if(!is_string($token)){
      throw InvalidArgumentException::fromParam('token', 'string', $token);
    }
    $this->token = $token;
  }

  /**
   * @return string Токен.
   */
  public function getToken(){
    return $this->token;
  }

  /**
   * @return int Статус токена.
   */
  public function getCode(){
    return $this->code;
  }

  /**
   * @return string Токен.
   */
  public function __toString(){
    return $this->getToken();
  }
}