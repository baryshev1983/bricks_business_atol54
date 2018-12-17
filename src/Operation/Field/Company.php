<?php
namespace Bricks\Business\Atol54\Operation\Field;

use Bricks\Business\Atol54\JsonSerializableInterface;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;

/**
 * Атрибуты чека.
 *
 * @author Artur Sh. Mamedbekov
 * @author Vladimir Baryshev
 */
class Company implements JsonSerializableInterface{
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
   * @var string|null ИНН компании
   */
  private $inn;

    /**
     * @var string
     */
    private $paymentAddress;

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
  * Company constructor.
  * @param $sno
  * @param $email
  * @param $inn
  * @param $paymentAddress
  */
  public function __construct($sno, $email, $inn, $paymentAddress){
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
    if(!is_null($inn)){
      $innLen = mb_strlen($inn);
      if ($innLen !== 10 && $innLen !== 12) {
        throw new InvalidArgumentException(sprintf(
          'Length the "inn" should be "[10, 12]" chars, "%s" given.',
          $innLen
        ));
      }
      $this->inn = $inn;
    }
    $this->paymentAddress = $paymentAddress;
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
   * @return string|null INN компании
   */
  public function getInn(){
    return $this->inn;
  }

  /**
   * {@inheritdoc}
   */
  public function toJson(){
    $json = [
        'email' => $this->email,
        'sno' => $this->sno,
        'inn' => $this->inn,
        'payment_address' => $this->paymentAddress
    ];

    return json_encode($json);
  }
}
