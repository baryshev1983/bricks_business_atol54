<?php
namespace Bricks\Business\Atol54\Operation\Exception;

use Exception;

/**
 * Переданный token_id не активен.
 *
 * @author Artur Sh. Mamedbekov
 */
class StateExpiredTokenException extends AbstractOperationException{
  /**
   * @param Exception $previous [optional]
   */
  public function __construct($previous = null){
    parent::__construct('Target token_id expired', 14, $previous);
  }
}
