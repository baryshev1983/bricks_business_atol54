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
   * @var array Карта соответствий статусов токена к исключениям.
   */
  private static $codeMap = [
    17 => BadRequestException::class,
    18 => GetTokenException::class,
    19 => WrongUserOrPasswordException::class,
  ];

  /**
   * @var string Токен.
   */
  private $token;

  /**
   * {@inheritdoc}
   *
   * @throws BadResponseException
   * @throws AbstractAuthException
   */
  public static function fromJson($json)
  {
    if (is_string($json)) {
      $json = json_decode($json);
    }

    if (isset($json->error) && $json->error !== null) {
        $exceptionClass = isset(self::$codeMap[$json->error->code])
            ? new self::$codeMap[$json->error->code]
            : new \RuntimeException('Ошибка авторизации');
        throw new $exceptionClass;
    } else {
        return new Token($json->token);
    }
  }

  /**
   * @param string $token Токен.
   *
   * @throws InvalidArgumentException
   *
   */
  public function __construct($token){
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
   * @return string Токен.
   */
  public function __toString(){
    return $this->getToken();
  }
}

