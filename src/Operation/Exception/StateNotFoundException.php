<?php
namespace Bricks\Business\Atol54\Operation\Exception;

use Exception;

/**
 * Документ не обработан.
 *
 * @author Artur Sh. Mamedbekov
 */
class StateNotFoundException extends AbstractOperationException{
  /**
   * @param Exception $previous [optional]
   */
  public function __construct($previous = null){
    parent::__construct('Document not found', 16, $previous);
  }
}
