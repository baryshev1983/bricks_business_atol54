<?php
namespace Bricks\Business\Atol54\Operation\Exception;

use Exception;

/**
 * Некорректный token_id
 *
 * @author Artur Sh. Mamedbekov
 */
class StateMissingTokenException extends AbstractOperationException{
  /**
   * @param Exception $previous [optional]
   */
  public function __construct($previous = null){
    parent::__construct('Invalid token_id', 12, $previous);
  }
}
