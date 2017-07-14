<?php
namespace Bricks\Business\Atol54\Operation\Field;

use Bricks\Business\Atol54\JsonSerializableInterface;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;

/**
 * Атрибуты чека.
 *
 * @author Artur Sh. Mamedbekov
 */
class Attributes implements JsonSerializableInterface{
  /**
   * Общая.
   */
  const SNO_GENERAL = 'osn';

  /**
   * Упрощенная (доходы).
   */
  const SNO_SIMPLE_INCOMES = 'usn_income';

  /**
   * Упрощенная (доходы минус расходы).
   */
  const SNO_SIMPLE_PROFIT = 'usn_income_outcome';

  /**
   * Единый налог на вмененный доход.
   */
  const SNO_IMPUTED = 'envd';

  /**
   * Единый сельскохозяйственный налог.
   */
  const SNO_AGRICULTURAL = 'esn';

  /**
   * Патентная.
   */
  const SNO_PATENT = 'patent';

  /**
   * @var string Система налогообложения магазина.
   *
   * @see self::SNO_*
   */
  private $sno;

  /**
   * @var string|null Контактный email покупателя.
   */
  private $email;

  /**
   * @var string|null Контактный телефон покупателя.
   */
  private $phone;

  /**
   * @return string[] Допустимые значения параметра sno.
   */
  public static function getSnoValues(){
    return [
      self::SNO_GENERAL,
      self::SNO_SIMPLE_INCOMES,
      self::SNO_SIMPLE_PROFIT,
      self::SNO_IMPUTED,
      self::SNO_AGRICULTURAL,
      self::SNO_PATENT,
    ];
  }

  /**
   * @param string $sno Система налогообложения магазина.
   * @param string $email [optional] Контактный email покупателя.
   * @param string $phone [optional] Контактный телефон покупателя.
   *
   * @throws InvalidArgumentException
   *
   * @see self::SNO_*
   */
  public function __construct($sno, $email = null, $phone = null){
    if(!is_string($sno)){
      throw InvalidArgumentException::fromParam('sno', 'string', $sno);
    }
    if(!in_array($sno, self::getSnoValues())){
      throw new InvalidArgumentException(sprintf(
        'The tax system should be "[osn|usn_income|usn_income_outcome|envd|esn|patent]", %s given',
        $sno
      ));
    }
    $this->sno = $sno;
    if(!is_null($email)){
      $emailLen = mb_strlen($email);
      if($emailLen < 1 || $emailLen > 64){
        throw new InvalidArgumentException(sprintf(
          'Length the "email" should be "[0-64]" chars, "%s" given.',
          $emailLen
        ));
      }
      $this->email = $email;
    }
    if(!is_null($phone)){
      $phoneLen = mb_strlen($phone);
      if($phoneLen < 1 || $phoneLen > 64){
        throw new InvalidArgumentException(sprintf(
          'Length the "phone" should be "[0-64]" chars, "%s" given.',
          $phoneLen
        ));
      }
      $this->phone = $phone;
    }
    if(is_null($this->email) && is_null($this->phone)){
      throw new InvalidArgumentException('You must specify "email or phone"');
    }
  }

  /**
   * @return string Система налогообложения магазина.
   *
   * @see self::SNO_*
   */
  public function getSno(){
    return $this->sno;
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
      'sno' => $this->sno,
    ];
    if(!is_null($this->email)){
      $json['email'] = $this->email;
    }
    if(!is_null($this->phone)){
      $json['phone'] = $this->phone;
    }

    return json_encode($json);
  }
}
