<?php
namespace Bricks\Business\Atol54\Operation\Exception;

use Exception;

/**
 * Чек с переданным external_id уже зарегистрирован ранее.
 *
 * @author Artur Sh. Mamedbekov
 */
class ExistExternalIdException extends AbstractOperationException{
  /**
   * @param Exception $previous [optional]
   */
  public function __construct($previous = null){
    parent::__construct('Target external_id already exist', 10, $previous);
  }
}
