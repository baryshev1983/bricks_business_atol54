<?php
namespace Bricks\Business\Atol54\Operation;

use DateTime;
use Bricks\Business\Atol54\JsonSerializableInterface;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;
use Bricks\Business\Atol54\Operation\Field\Receipt;
use Bricks\Business\Atol54\Operation\Field\Service;

/**
 * Операция.
 *
 * @author Artur Sh. Mamedbekov
 */
abstract class AbstractOperation implements JsonSerializableInterface{
  /**
   * @var string Идентификатор документа во внешней системе.
   */
  private $externalId;

  /**
   * @var Receipt Чек.
   */
  private $receipt;

  /**
   * @var DateTime Дата и время формирования документа во внешней системе.
   */
  private $timestamp;

  /**
   * @param string $externalId Идентификатор документа во внешней системе.
   * @param Receipt $receipt Чек.
   * @param DateTime $timestamp [optional] Дата и время формирования документа
   * во внешней системе.
   *
   * @throws InvalidArgumentException
   */
  public function __construct($externalId, Receipt $receipt, DateTime $timestamp = null){
    if(!is_string($externalId)){
      throw InvalidArgumentException::fromParam('externalId', 'string', $externalId);
    }
    $externalIdLen = mb_strlen($externalId);
    if($externalIdLen < 1 || $externalIdLen > 256){
      throw new InvalidArgumentException(sprintf(
        'Length the "externalId" should be "[0-256]" chars, "%s" given.',
        $externalIdLen
      ));
    }
    $this->externalId = $externalId;
    $this->receipt = $receipt;
    if(is_null($timestamp)){
      $timestamp = new DateTime;
    }
    $this->timestamp = $timestamp;
  }

  /**
   * @return string Идентификатор документа во внешней системе.
   */
  public function getExternalId(){
    return $this->externalId;
  }

  /**
   * @return Receipt Чек.
   */
  public function getReceipt(){
    return $this->receipt;
  }

  /**
   * @return DateTime Дата и время формирования документа во внешней системе.
   */
  public function getTimestamp(){
    return $this->timestamp;
  }

  /**
   * {@inheritdoc}
   */
  public function toJson(){
    return sprintf(
      '{"external_id":"%s","receipt":%s,"timestamp":"%s"}',
      $this->externalId,
      $this->receipt->toJson(),
      $this->timestamp->format('d.m.Y H:i:s')
    );
  }
}
