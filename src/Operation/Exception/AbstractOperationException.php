<?php
namespace Bricks\Business\Atol54\Operation\Exception;

use RuntimeException;

/**
 * @author Artur Sh. Mamedbekov
 */
abstract class AbstractOperationException extends RuntimeException{
  /**
   * @return string Описание ошибки.
   */
  public function getText(){
    return $this->message;
  }

  /**
   * @return string Тип источника ошибки.
   */
  public function getType(){
    return 'system';
  }
}
