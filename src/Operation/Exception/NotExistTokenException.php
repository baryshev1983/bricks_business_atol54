<?php
namespace Bricks\Business\Atol54\Operation\Exception;

use Exception;

/**
 * Переданный token_id отсутствует в БД.
 *
 * @author Artur Sh. Mamedbekov
 */
class NotExistTokenException extends AbstractOperationException{
  /**
   * @param Exception $previous [optional]
   */
  public function __construct($previous = null){
    parent::__construct('Target token_id not found', 5, $previous);
  }
}
