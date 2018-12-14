<?php
namespace Bricks\Business\Atol54\Operation\Field;

use Bricks\Business\Atol54\JsonSerializableInterface;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;

/**
 * Атрибуты Клиента.
 *
 * @author Vladimir Baryshev
 */
class Client implements JsonSerializableInterface{
  /**
   * @var string|null Контактный email покупателя.
   */
  private $email;

  /**
   * @var string|null Контактный телефон покупателя.
   */
  private $phone;

  /**
   * @param string $email [optional] Контактный email покупателя.
   * @param string $phone [optional] Контактный телефон покупателя.
   *
   * @throws InvalidArgumentException
   */
  public function __construct($email = null, $phone = null)
  {
    if(is_null($email)){
      throw new InvalidArgumentException('You must specify "email or phone"');
    } else {
      $emailLen = mb_strlen($email);
      if($emailLen < 1 || $emailLen > 64){
        throw new InvalidArgumentException(sprintf(
          'Length the "email" should be "[0-64]" chars, "%s" given.',
          $emailLen
        ));
      }
      $this->email = $email;
    }
    $this->phone = $phone;
  }

  /**
   * @return string|null Email клиента.
   */
  public function getEmail(){
    return $this->email;
  }

  /**
   * @return string|null Телефон клиента.
   */
  public function getPhone(){
    return $this->phone;
  }

  /**
   * {@inheritdoc}
   */
  public function toJson(){
    $json = [
      'email' => $this->email,
    ];
    if(!is_null($this->phone)){
      $json['phone'] = $this->phone;
    }

    return json_encode($json);
  }
}
