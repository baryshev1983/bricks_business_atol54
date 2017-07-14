<?php
namespace Bricks\Business\Atol54\Operation\Exception;

use Exception;

/**
 * Код group_code не соответствует переданному token_id.
 *
 * @author Artur Sh. Mamedbekov
 */
class GroupCodeToTokenException extends AbstractOperationException{
  /**
   * @param Exception $previous [optional]
   */
  public function __construct($previous = null){
    parent::__construct('Invalid group_code for target token_id', 22, $previous);
  }
}
