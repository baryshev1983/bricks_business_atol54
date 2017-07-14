<?php
namespace Bricks\Business\Atol54\Operation\Field;

use Bricks\Business\Atol54\JsonSerializableInterface;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;

/**
 * Службные данные.
 *
 * @author Artur Sh. Mamedbekov
 */
class Service implements JsonSerializableInterface{
  /**
   * @var string ИНН организации.
   */
  private $inn;

  /**
   * @var string Домен организации.
   */
  private $paymentAddress;

  /**
   * @var string|null URL функции обратного вызова для сообщения о результатах 
   * регистрации.
   */
  private $callbackUrl;

  /**
   * @param string $inn ИНН организации.
   * @param string $paymentAddress Домен организации.
   * @param string $callbackUrl [optional] URL функции обратного вызова для 
   * сообщения о результатах регистрации.
   *
   * @throws InvalidArgumentException
   */
  public function __construct($inn, $paymentAddress, $callbackUrl = null){
    if(!is_string($inn)){
      throw InvalidArgumentException::fromParam('inn', 'string', $inn);
    }
    $innLen = strlen($inn);
    if($innLen != 10 && $innLen != 12){
      throw new InvalidArgumentException(sprintf(
        'Length the "inn" should be "10|12" chars, "%s" given.',
        $innLen
      ));
    }
    $this->inn = $inn;
    if(!is_string($paymentAddress)){
      throw InvalidArgumentException::fromParam('paymentAddress', 'string', $paymentAddress);
    }
    $paymentAddressLen = mb_strlen($paymentAddress);
    if($paymentAddressLen < 1 || $paymentAddressLen > 256){
      throw new InvalidArgumentException(sprintf(
        'Length the "paymentAddress" should be "[1-256]" chars, "%s" given.',
        $paymentAddressLen
      ));
    }
    $this->paymentAddress = $paymentAddress;
    if(is_string($callbackUrl)){
      $callbackUrlLen = mb_strlen($callbackUrl);
      if($callbackUrlLen < 1 || $callbackUrlLen > 256){
        throw new InvalidArgumentException(sprintf(
          'Length the "callbackUrl" should be "[1-256]" chars, "%s" given.',
          $callbackUrlLen
        ));
      }
      $this->callbackUrl = $callbackUrl;
    }
  }

  /**
   * @return string ИНН организации.
   */
  public function getInn(){
    return $this->inn;
  }

  /**
   * @return string Домен организации.
   */
  public function getPaymentAddress(){
    return $this->paymentAddress;
  }

  /**
   * @return string|null URL функции обратного вызова для сообщения о 
   * результатах регистрации.
   */
  public function getCallbackUrl(){
    return $this->callbackUrl;
  }

  /**
   * {@inheritdoc}
   */
  public function toJson(){
    $json = [
      'inn' => $this->inn,
      'payment_address' => $this->paymentAddress,
    ];
    if(!is_null($this->callbackUrl)){
      $json['callback_url'] = $this->callbackUrl;
    }

    return json_encode($json);
  }
}
