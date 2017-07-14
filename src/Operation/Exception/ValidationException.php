<?php
namespace Bricks\Business\Atol54\Operation\Exception;

use Exception;

/**
 * Ошибка валидации
 *
 * @author Artur Sh. Mamedbekov
 */
class ValidationException extends AbstractOperationException{
  /**
   * @param Exception $previous [optional]
   */
  public function __construct($previous = null){
    parent::__construct('Invalid request JSON', 8, $previous);
  }
}
