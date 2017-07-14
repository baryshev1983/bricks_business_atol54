<?php
namespace Bricks\Business\Atol54\Auth;

use Bricks\Business\Atol54\Exception\InvalidArgumentException;

/**
 * Запрос авторизации.
 *
 * @author Artur Sh. Mamedbekov
 */
class Auth{
  /**
   * @var string Логин.
   */
  private $login;

  /**
   * @var string Пароль.
   */
  private $pass;

  /**
   * @param string $login Логин.
   * @param string $pass Пароль.
   *
   * @throws InvalidArgumentException
   */
  public function __construct($login, $pass){
    if(!is_string($login)){
      throw InvalidArgumentException::fromParam('login', 'string', $login);
    }
    $this->login = $login;
    if(!is_string($pass)){
      throw InvalidArgumentException::fromParam('pass', 'string', $pass);
    }
    $this->pass = $pass;
  }

  /**
   * @return string Логин.
   */
  public function getLogin(){
    return $this->login;
  }

  /**
   * @return string Пароль.
   */
  public function getPass(){
    return $this->pass;
  }

  /**
   * @return string Представление запроса на авторизацию в формате JSON.
   */
  public function toJson(){
    return sprintf(
      '{"login":"%s","pass":"%s"}',
      $this->login,
      $this->pass
    );
  }

  /**
   * @return array Представление запроса на авторизацию в виде ассоциативного 
   * массива.
   */
  public function toArray(){
    return [
      'login' => $this->login,
      'pass' => $this->pass,
    ];
  }
}
