<?php
namespace Bricks\Business\Atol54\Operation\Exception;

use Exception;

/**
 * Не указан group_code.
 *
 * @author Artur Sh. Mamedbekov
 */
class StateBadRequestException extends AbstractOperationException{
  /**
   * @param Exception $previous [optional]
   */
  public function __construct($previous = null){
    parent::__construct('Invalid group_code', 11, $previous);
  }
}
