<?php
namespace Bricks\Business\Atol54\Operation\Exception;

use Exception;

/**
 * Передан некорректный uuid.
 *
 * @author Artur Sh. Mamedbekov
 */
class StateMissingUuidException extends AbstractOperationException{
  /**
   * @param Exception $previous [optional]
   */
  public function __construct($previous = null){
    parent::__construct('Invalid uuid', 15, $previous);
  }
}
