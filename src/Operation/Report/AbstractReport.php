<?php
namespace Bricks\Business\Atol54\Operation\Report;

use Bricks\Business\Atol54\JsonUnserializableInterface;
use Bricks\Business\Atol54\Operation\Exception\BadResponseException;
use Bricks\Business\Atol54\Operation\Exception\AbstractOperationException;
use Bricks\Business\Atol54\Operation\Exception\BadRequestException;
use Bricks\Business\Atol54\Operation\Exception\IncomingBadRequestException;
use Bricks\Business\Atol54\Operation\Exception\OperationNotSupportException;
use Bricks\Business\Atol54\Operation\Exception\MissingTokenException;
use Bricks\Business\Atol54\Operation\Exception\NotExistTokenException;
use Bricks\Business\Atol54\Operation\Exception\ExpiredTokenException;
use Bricks\Business\Atol54\Operation\Exception\QueueTimeoutException;
use Bricks\Business\Atol54\Operation\Exception\ValidationException;
use Bricks\Business\Atol54\Operation\Exception\QueueException;
use Bricks\Business\Atol54\Operation\Exception\ExistExternalIdException;
use Bricks\Business\Atol54\Operation\Exception\StateBadRequestException;
use Bricks\Business\Atol54\Operation\Exception\StateMissingTokenException;
use Bricks\Business\Atol54\Operation\Exception\StateNotExistTokenException;
use Bricks\Business\Atol54\Operation\Exception\StateExpiredTokenException;
use Bricks\Business\Atol54\Operation\Exception\StateMissingUuidException;
use Bricks\Business\Atol54\Operation\Exception\StateNotFoundException;
use Bricks\Business\Atol54\Operation\Exception\GroupCodeToTokenException;

/**
 * Отчет об обработке документа.
 *
 * @author Artur Sh. Mamedbekov
 */
abstract class AbstractReport implements JsonUnserializableInterface{
  /**
   * Обработка завершена успешно.
   */
  const STATUS_DONE = 'done';

  /**
   * В процессе обработки.
   */
  const STATUS_WAIT = 'wait';

  /**
   * Ошибка.
   */
  const STATUS_FAIL = 'fail';

  /**
   * @var array Карта соответствий статусов ошибок к исключениям.
   */
  private static $codeMap = [
    1 => BadRequestException::class,
    2 => IncomingBadRequestException::class,
    3 => OperationNotSupportException::class,
    4 => MissingTokenException::class,
    5 => NotExistTokenException::class,
    6 => ExpiredTokenException::class,
    7 => QueueTimeoutException::class,
    8 => ValidationException::class,
    9 => QueueException::class,
    10 => ExistExternalIdException::class,
    11 => StateBadRequestException::class,
    12 => StateMissingTokenException::class,
    13 => StateNotExistTokenException::class,
    14 => StateExpiredTokenException::class,
    15 => StateMissingUuidException::class,
    16 => StateNotFoundException::class,
    22 => GroupCodeToTokenException::class,
  ];

  /**
   * @return string[] Коды статуса обработки документа.
   */
  public static function getStatusValues(){
    return [
      self::STATUS_DONE,
      self::STATUS_WAIT,
      self::STATUS_FAIL,
    ];
  }

  /**
   * @param int $code Код ошибки.
   *
   * @return AbstractOperationException Исключение, соответствующее данному коду 
   * ошибки.
   */
  public static function errorToException($code){
    if(!isset(self::$codeMap[$code])){
      return new BadResponseException(sprintf(
        'Undefined error code "%s"',
        $code
      ));
    }
    $exceptionClass = self::$codeMap[$code];
    return  new $exceptionClass;
  }
}
