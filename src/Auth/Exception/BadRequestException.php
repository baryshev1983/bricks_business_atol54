<?php
namespace Bricks\Business\Atol54\Auth\Exception;

use Exception;

/**
 * Исключение свидетельствует о некорректном запросе.
 *
 * @author Artur Sh. Mamedbekov
 */
class BadRequestException extends AbstractAuthException{
  /**
   * @param Exception $previous [optional]
   */
  public function __construct($previous = null){
    parent::__construct('Invalid request URL or format', 17, $previous);
  }
}
