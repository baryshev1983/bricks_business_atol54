<?php
namespace Bricks\Business\Atol54\Auth\Exception;

use RuntimeException;

/**
 * @author Artur Sh. Mamedbekov
 */
abstract class AbstractAuthException extends RuntimeException{
  /**
   * @return string Описание ошибки.
   */
  public function getText(){
    return $this->message;
  }
}
