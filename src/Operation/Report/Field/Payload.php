<?php
namespace Bricks\Business\Atol54\Operation\Report\Field;

use DateTime;
use Bricks\Business\Atol54\JsonUnserializableInterface;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;
use Bricks\Business\Atol54\Operation\Exception\BadResponseException;

/**
 * Дополнительные данные отчета.
 *
 * @author Artur Sh. Mamedbekov
 */
class Payload implements JsonUnserializableInterface{
  /**
   * @var float Итоговая сумма документа в рублях.
   */
  private $total;

  /**
   * @var string Адрес сайта ФНС.
   */
  private $fnsSite;

  /**
   * @var string Номер ФН.
   */
  private $fnNumber;

  /**
   * @var int Номер смены.
   */
  private $shiftNumber;

  /**
   * @var DateTime Дата и время документа из ФН.
   */
  private $receiptDatetime;

  /**
   * @var int Номер чека в смене.
   */
  private $fiscalReceiptNumber;

  /**
   * @var int Фискальный номер документа.
   */
  private $fiscalDocumentNumber;

  /**
   * @var int Фискальный признак документа.
   */
  private $fiscalDocumentAttribute;

  /**
   * @var string Регистрационный номер ККТ.
   */
  private $ecrRegistrationNumber;

  /**
   * {@inheritdoc}
   *
   * @throws BadResponseException
   */
  public static function fromJson($json){
    if(is_string($json)){
      $json = json_decode($json);
    }
    
    if(!property_exists($json, 'total')){
      throw new BadResponseException('Required parameter "total" not found');
    }
    if(!property_exists($json, 'fns_site')){
      throw new BadResponseException('Required parameter "fns_site" not found');
    }
    if(!property_exists($json, 'fn_number')){
      throw new BadResponseException('Required parameter "fn_number" not found');
    }
    if(!property_exists($json, 'shift_number')){
      throw new BadResponseException('Required parameter "shift_number" not found');
    }
    if(!property_exists($json, 'receipt_datetime')){
      throw new BadResponseException('Required parameter "receipt_datetime" not found');
    }
    if(!property_exists($json, 'fiscal_receipt_number')){
      throw new BadResponseException('Required parameter "fiscal_receipt_number" not found');
    }
    if(!property_exists($json, 'fiscal_document_number')){
      throw new BadResponseException('Required parameter "fiscal_document_number" not found');
    }
    if(!property_exists($json, 'fiscal_document_attribute')){
      throw new BadResponseException('Required parameter "fiscal_document_attribute" not found');
    }
    if(!property_exists($json, 'ecr_registration_number')){
      throw new BadResponseException('Required parameter "ecr_registration_number" not found');
    }

    return new self(
      $json->total,
      $json->fns_site,
      $json->fn_number,
      $json->shift_number,
      new DateTime($json->receipt_datetime),
      $json->fiscal_receipt_number,
      $json->fiscal_document_number,
      $json->fiscal_document_attribute,
      $json->ecr_registration_number
    );
  }

  /**
   * @param float|int|string $total Итоговая сумма документа в рублях.
   * @param string $fnsSite Адрес сайта ФНС.
   * @param string $fnNumber Номер ФН.
   * @param int|string $shiftNumber Номер смены.
   * @param DateTime $receiptDatetime Дата и время документа из ФН.
   * @param int|string $fiscalReceiptNumber Номер чека в смене.
   * @param int|string $fiscalDocumentNumber Фискальный номер документа.
   * @param int|string $fiscalDocumentAttribute Фискальный признак документа.
   * @param string $ecrRegistrationNumber Регистрационный номер ККТ.
   *
   * @throws InvalidArgumentException
   */
  public function __construct(
    $total,
    $fnsSite,
    $fnNumber,
    $shiftNumber,
    DateTime $receiptDatetime,
    $fiscalReceiptNumber,
    $fiscalDocumentNumber,
    $fiscalDocumentAttribute,
    $ecrRegistrationNumber
  ){
    if(!is_string($total) && !is_int($total) && !is_float($total)){
      throw InvalidArgumentException::fromParam('total', 'float|int|string', $total);
    }
    $this->total = (float) $total;
    if(!is_string($fnsSite)){
      throw InvalidArgumentException::fromParam('fnsSite', 'string', $fnsSite);
    }
    $this->fnsSite = $fnsSite;
    if(!is_string($fnNumber)){
      throw InvalidArgumentException::fromParam('fnNumber', 'string', $fnNumber);
    }
    $this->fnNumber = $fnNumber;
    if(!is_string($shiftNumber) && !is_int($shiftNumber)){
      throw InvalidArgumentException::fromParam('shiftNumber', 'int|string', $shiftNumber);
    }
    $this->shiftNumber = (int) $shiftNumber;
    $this->receiptDatetime = $receiptDatetime;
    if(!is_string($fiscalReceiptNumber) && !is_int($fiscalReceiptNumber)){
      throw InvalidArgumentException::fromParam('fiscalReceiptNumber', 'int|string', $fiscalReceiptNumber);
    }
    $this->fiscalReceiptNumber = (int) $fiscalReceiptNumber;
    if(!is_string($fiscalDocumentNumber) && !is_int($fiscalDocumentNumber)){
      throw InvalidArgumentException::fromParam('fiscalDocumentNumber', 'int|string', $fiscalDocumentNumber);
    }
    $this->fiscalDocumentNumber = (int) $fiscalDocumentNumber;
    if(!is_string($fiscalDocumentAttribute) && !is_int($fiscalDocumentAttribute)){
      throw InvalidArgumentException::fromParam('fiscalDocumentAttribute', 'int|string', $fiscalDocumentAttribute);
    }
    $this->fiscalDocumentAttribute = (int) $fiscalDocumentAttribute;
    if(!is_string($ecrRegistrationNumber)){
      throw InvalidArgumentException::fromParam('ecrRegistrationNumber', 'string', $ecrRegistrationNumber);
    }
    $this->ecrRegistrationNumber = $ecrRegistrationNumber;
  }

  /**
   * @return float Итоговая сумма документа в рублях.
   */
  public function getTotal(){
    return $this->total;
  }

  /**
   * @return string Адрес сайта ФНС.
   */
  public function getFnsSite(){
    return $this->fnsSite;
  }

  /**
   * @return string Номер ФН.
   */
  public function getFnNumber(){
    return $this->fnNumber;
  }

  /**
   * @return int Номер смены.
   */
  public function getShiftNumber(){
    return $this->shiftNumber;
  }

  /**
   * @return DateTime Дата и время документа из ФН.
   */
  public function getReceiptDatetime(){
    return $this->receiptDatetime;
  }

  /**
   * @return int Номер чека в смене.
   */
  public function getFiscalReceiptNumber(){
    return $this->fiscalReceiptNumber;
  }

  /**
   * @return int Фискальный номер документа.
   */
  public function getFiscalDocumentNumber(){
    return $this->fiscalDocumentNumber;
  }

  /**
   * @return int Фискальный признак документа.
   */
  public function getFiscalDocumentAttribute(){
    return $this->fiscalDocumentAttribute;
  }

  /**
   * @return string Регистрационный номер ККТ.
   */
  public function getEcrRegistrationNumber(){
    return $this->ecrRegistrationNumber;
  }
}
