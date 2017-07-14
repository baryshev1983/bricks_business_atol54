<?php
namespace Bricks\Business\Atol54\Operation\Report;

use DateTime;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;
use Bricks\Business\Atol54\Operation\Exception\BadResponseException;
use Bricks\Business\Atol54\Operation\Exception\AbstractOperationException;
use Bricks\Business\Atol54\Operation\Exception\BadRequestException;
use Bricks\Business\Atol54\Operation\Exception\IncomingBadRequestException;
use Bricks\Business\Atol54\Operation\Exception\OperationNotSupportException;
use Bricks\Business\Atol54\Operation\Exception\MissingTokenException;
use Bricks\Business\Atol54\Operation\Exception\NotExistTokenException;
use Bricks\Business\Atol54\Operation\Exception\ExpiredTokenException;
use Bricks\Business\Atol54\Operation\Exception\ExistExternalIdException;
use Bricks\Business\Atol54\Operation\Exception\GroupCodeToTokenException;

/**
 * Сокращенный отчет.
 *
 * @author Artur Sh. Mamedbekov
 */
class ShortReport extends AbstractReport{
  /**
   * @var string Идентификатор.
   */
  private $uuid;

  /**
   * @var DateTime Дата и время формирования документа во внешней системе.
   */
  private $timestamp;

  /**
   * @var string Текущий статус обработки.
   */
  private $status;

  /**
   * {@inheritdoc}
   *
   * @throws BadResponseException
   * @throws AbstractOperationException
   */
  public static function fromJson($json){
    if(is_string($json)){
      $json = json_decode($json);
    }

    if(!property_exists($json, 'error')){
      throw new BadResponseException('Required parameter "error" not found');
    }

    if(is_null($json->error)){
      if(!property_exists($json, 'uuid')){
        throw new BadResponseException('Required parameter "uuid" not found');
      }
      if(!property_exists($json, 'timestamp')){
        throw new BadResponseException('Required parameter "timestamp" not found');
      }
      if(!property_exists($json, 'status')){
        throw new BadResponseException('Required parameter "status" not found');
      }

      return new self($json->uuid, new DateTime($json->timestamp), $json->status);
    }
    else{
      if(!property_exists($json->error, 'code')){
        throw new BadResponseException('Required parameter "error.code" not found');
      }

      throw AbstractReport::errorToException((int) $json->error->code);
    }
  }

  /**
   * @param string $uuid Идентификатор.
   * @param DateTime $timestamp Дата и время формирования документа во внешней 
   * системе.
   * @param string $status Текущий статус обработки.
   *
   * @throws InvalidArgumentException
   */
  public function __construct($uuid, DateTime $timestamp, $status){
    if(!is_string($uuid)){
      throw InvalidArgumentException::fromParam('uuid', 'string', $uuid);
    }
    $this->uuid = $uuid;
    $this->timestamp = $timestamp;
    if(!is_string($status)){
      throw InvalidArgumentException::fromParam('status', 'string', $status);
    }
    if(!in_array($status, AbstractReport::getStatusValues())){
      throw new InvalidArgumentException(sprintf(
        'The "status" should be "wait|fail", %s given',
        $status
      ));
    }
    $this->status = $status;
  }

  /**
   * @return string Уникальный идентификатор документа.
   */
  public function getUuid(){
    return $this->uuid;
  }

  /**
   * @return DateTime Дата и время формирования документа во внешней системе.
   */
  public function getTimestamp(){
    return $this->timestamp;
  }

  /**
   * @return string Текущий статус обработки.
   *
   * @see self::STATUS_*
   */
  public function getStatus(){
    return $this->status;
  }
}
