<?php
namespace Bricks\Business\Atol54\Operation\Report;

use DateTime;
use Bricks\Business\Atol54\Operation\Report\Field\Payload;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;
use Bricks\Business\Atol54\Operation\Exception\BadResponseException;
use Bricks\Business\Atol54\Operation\Exception\AbstractOperationException;

/**
 * Полный отчет.
 *
 * @author Artur Sh. Mamedbekov
 */
class FullReport extends ShortReport{
  /**
   * @var Payload Дополнительные данные.
   */
  private $payload;

  /**
   * @var string Идентификатор группы ККТ.
   */
  private $groupCode;

  /**
   * @var string Наименование сервиса.
   */
  private $daemonCode;

  /**
   * @var string Код ККТ.
   */
  private $deviceCode;

  /**
   * @var string URL функции обратного вызова для сообщения о результатах 
   * регистрации.
   */
  private $callbackUrl;

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
      $shortReport = ShortReport::fromJson($json);

      if(!property_exists($json, 'payload')){
        throw new BadResponseException('Required parameter "payload" not found');
      }
      if(!property_exists($json, 'group_code')){
        throw new BadResponseException('Required parameter "group_code" not found');
      }
      if(!property_exists($json, 'daemon_code')){
        throw new BadResponseException('Required parameter "daemon_code" not found');
      }
      if(!property_exists($json, 'device_code')){
        throw new BadResponseException('Required parameter "device_code" not found');
      }
      if(!property_exists($json, 'callback_url')){
        throw new BadResponseException('Required parameter "callback_url" not found');
      }

      $payload = Payload::fromJson($json->payload);
      return new self(
        $shortReport->getUuid(),
        $shortReport->getTimestamp(),
        $shortReport->getStatus(),
        $payload,
        $json->group_code,
        $json->daemon_code,
        $json->device_code,
        $json->callback_url
      );
    }
    else{
      if(!property_exists($json->error, 'code')){
        throw new BadResponseException('Required parameter "error.code" not found');
      }

      throw AbstractReport::errorToException((int) $json->error->code);
    }
  }

  /**
   * {@inheritdoc}
   * @param Payload $payload Дополнительные данные.
   * @param string $groupCode Идентификатор группы ККТ.
   * @param string $daemonCode Наименование сервиса.
   * @param string $deviceCode Код ККТ.
   * @param string $callbackUrl URL функции обратного вызова для сообщения о 
   * результатах регистрации.
   *
   * @throws InvalidArgumentException
   */
  public function __construct(
    $uuid,
    DateTime $timestamp,
    $status,
    Payload $payload,
    $groupCode,
    $daemonCode,
    $deviceCode,
    $callbackUrl
  ){
    parent::__construct($uuid, $timestamp, $status);
    $this->payload = $payload;
    if(!is_string($groupCode)){
      throw InvalidArgumentException::fromParam('groupCode', 'string', $groupCode);
    }
    $this->groupCode = $groupCode;
    if(!is_string($daemonCode)){
      throw InvalidArgumentException::fromParam('groupCode', 'string', $daemonCode);
    }
    $this->daemonCode = $daemonCode;
    if(!is_string($deviceCode)){
      throw InvalidArgumentException::fromParam('groupCode', 'string', $deviceCode);
    }
    $this->deviceCode = $deviceCode;
    if(!is_string($callbackUrl)){
      throw InvalidArgumentException::fromParam('groupCode', 'string', $callbackUrl);
    }
    $this->callbackUrl = $callbackUrl;
  }

  /**
   * @return Payload Дополнительные данные.
   */
  public function getPayload(){
    return $this->payload;
  }

  /**
   * @return string Идентификатор группы ККТ.
   */
  public function getGroupCode(){
    return $this->groupCode;
  }

  /**
   * @return string Наименование сервиса.
   */
  public function getDaemonCode(){
    return $this->daemonCode;
  }

  /**
   * @return string Код ККТ.
   */
  public function getDeviceCode(){
    return $this->deviceCode;
  }

  /**
   * @return string URL функции обратного вызова для сообщения о результатах 
   * регистрации.
   */
  public function getCallbackUrl(){
    return $this->callbackUrl;
  }
}
