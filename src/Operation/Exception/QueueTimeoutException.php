<?php
namespace Bricks\Business\Atol54\Operation\Exception;

use Exception;

/**
 * Не создан сервер очередей.
 *
 * @author Artur Sh. Mamedbekov
 */
class QueueTimeoutException extends AbstractOperationException{
  /**
   * @param Exception $previous [optional]
   */
  public function __construct($previous = null){
    parent::__construct('Queue server timeout', 7, $previous);
  }
}
