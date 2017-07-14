<?php
namespace Bricks\Business\Atol54\Operation\Exception;

use Exception;

/**
 * Ошибка при работе очереди
 *
 * @author Artur Sh. Mamedbekov
 */
class QueueException extends AbstractOperationException{
  /**
   * @param Exception $previous [optional]
   */
  public function __construct($previous = null){
    parent::__construct('Queue error', 9, $previous);
  }
}
