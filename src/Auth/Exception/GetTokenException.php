<?php
namespace Bricks\Business\Atol54\Auth\Exception;

use Exception;

/**
 * Исключение свидетельствует об ошибке при формировании токена.
 *
 * @author Artur Sh. Mamedbekov
 */
class GetTokenException extends AbstractAuthException{
  /**
   * @param Exception $previous [optional]
   */
  public function __construct($previous = null){
    parent::__construct('Could not generate token. Repeat the request', 18, $previous);
  }
}
