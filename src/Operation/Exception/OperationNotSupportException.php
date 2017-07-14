<?php
namespace Bricks\Business\Atol54\Operation\Exception;

use Exception;

/**
 * Переданная операция operation не поддерживается.
 *
 * @author Artur Sh. Mamedbekov
 */
class OperationNotSupportException extends AbstractOperationException{
  /**
   * @param Exception $previous [optional]
   */
  public function __construct($previous = null){
    parent::__construct('Operation not supported', 3, $previous);
  }
}
