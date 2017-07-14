<?php
namespace Bricks\Business\Atol54\Auth\Exception;

use Exception;

/**
 * Исключение свидетельствует об использовании неверного логина или пароля для 
 * аутентификации.
 *
 * @author Artur Sh. Mamedbekov
 */
class WrongUserOrPasswordException extends AbstractAuthException{
  /**
   * @param Exception $previous [optional]
   */
  public function __construct($previous = null){
    parent::__construct('Wrong user or password', 19, $previous);
  }
}
