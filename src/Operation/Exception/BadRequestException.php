<?php
namespace Bricks\Business\Atol54\Operation\Exception;

use Exception;

/**
 * Исключение свидетельствует о некорректном запросе.
 *
 * @author Artur Sh. Mamedbekov
 */
class BadRequestException extends AbstractOperationException{
  /**
   * @param Exception $previous [optional]
   */
  public function __construct($previous = null){
    parent::__construct('Invalid request URL or format', 1, $previous);
  }
}
