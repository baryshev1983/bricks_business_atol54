<?php
namespace Bricks\Business\Atol54\Operation\Exception;

use Exception;

/**
 * Переданы пустые значения group_code или operation.
 *
 * @author Artur Sh. Mamedbekov
 */
class IncomingBadRequestException extends AbstractOperationException{
  /**
   * @param Exception $previous [optional]
   */
  public function __construct($previous = null){
    parent::__construct('Invalid group_code or operation', 2, $previous);
  }
}
