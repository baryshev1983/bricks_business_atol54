<?php
namespace Bricks\Business\Atol54\Operation\Field;

use Bricks\Business\Atol54\JsonSerializableInterface;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;

/**
 * Продукт.
 *
 * @author Artur Sh. Mamedbekov
 */
class Item implements JsonSerializableInterface
{
    /**
     * Типы Оплаты "Предоплата 100%. Полная предварительная оплата до момента
     * передачипредмета расчета"
     */
    const PAYMENT_FULL_PREPAYMENT = 'full_prepayment';

    /**
     * Типы Оплаты "Предоплата. Частичная
     * предварительная оплата до момента передачипредмета расчета"
     */
    const PAYMENT_PREPAYMENT = 'prepayment';

    /**
     * Типы Оплаты "Аванс"
     */
    const PAYMENT_ADVANCE = 'advance';

    /**
     * Типы Оплаты "Полный расчет. Полная оплата, в том числе с учетом аванса
     * (предварительной оплаты) в момент передачи предмета расчета"
     */
    const PAYMENT_FULL_PAYMENT = 'full_payment';

    /**
     * Типы Оплаты "Частичный расчет и кредит. Частичная оплата предмета расчета в момент
     * его передачи с последующей оплатой в кредит"
     */
    const PAYMENT_PARTIAL_PAYMENT = 'partial_payment';

    /**
     * Типы Оплаты "Передача в кредит. Передача предмета расчета без его оплаты в момент его
     * передачи с последующей оплатой в кредит."
     */
    const PAYMENT_CREDIT = 'credit';

    /**
     * Типы Оплаты "Оплата кредита. Оплата предмета расчета после его передачи с оплатой
     * в кредит (оплата кредита)"
     */
    const PAYMENT_CREDIT_PAYMENT = 'credit_payment';

    const PAYMENT_METHODS = [
        self::PAYMENT_FULL_PREPAYMENT,
        self::PAYMENT_PREPAYMENT,
        self::PAYMENT_ADVANCE,
        self::PAYMENT_FULL_PAYMENT,
        self::PAYMENT_PARTIAL_PAYMENT,
        self::PAYMENT_CREDIT,
        self::PAYMENT_CREDIT_PAYMENT
    ];
    /**
     * Тип Оплаты
     */
    private $paymentMethod;

  /**
   * @var string Название товара.
   */
  private $name;

  /**
   * @var float Стоимость за единицу продукта в рублях.
   */
  private $price;

  /**
   * @var float Количество продукта в заказе (в том числе весового).
   */
  private $quantity;

  /**
   * @var float Суммарная стоимость продукта в рублях.
   */
  private $sum;

  /**
   * @var Vat Атрибуты ставки НДС.
   *
   */
  private $vat;

    /**
     * @param string $name Название товара.
     * @param float|int|string $quantity Количество продукта в заказе.
     * @param float|int|string $price Стоимость за единицу продукта.
     * @param Vat $vat Ставка НДС.
     * @param string $paymentMethod
     *
     * @throws InvalidArgumentException
     */
    public function __construct($name, $quantity, $price, $vat, $paymentMethod = self::PAYMENT_FULL_PREPAYMENT){
    if(!is_string($name)){
      throw InvalidArgumentException::fromParam('name', 'string', $name);
    }
    $nameLen = mb_strlen($name);
    if($nameLen < 1 || $nameLen > 64){
      throw new InvalidArgumentException(sprintf(
        'Length the "name" should be "[0-64]" chars, "%s" given.',
        $nameLen
      ));
    }

    $this->name = $name;
    if (!is_string($quantity) && !is_int($quantity) && !is_float($quantity)){
      throw InvalidArgumentException::fromParam('quantity', 'float|int|string', $quantity);
    }
    $this->quantity = (float) $quantity;

    if (!is_string($price) && !is_int($price) && !is_float($price)){
      throw InvalidArgumentException::fromParam('price', 'float|int|string', $price);
    }

    if (!in_array($paymentMethod, self::PAYMENT_METHODS)) {
        throw InvalidArgumentException::fromParam(
            'payment_method',
            implode('|', self::PAYMENT_METHODS),
            $paymentMethod
        );
    }
    $this->price = (float) $price;
    $this->vat = $vat;
    $this->sum = $this->quantity * $this->price;
    $this->paymentMethod = $paymentMethod;
  }

  /**
   * @return string Название товара.
   */
  public function getName(){
    return $this->name;
  }

  /**
   * @return float Стоимость за единицу продукта в рублях.
   */
  public function getPrice(){
    return $this->price;
  }

  /**
   * @return float Количество продукта в заказе.
   */
  public function getQuantity(){
    return $this->quantity;
  }

    /**
     * @return float Суммарная стоимость продукта в рублях.
     */
    public function getSum(){
        return $this->sum;
    }

    /**
     * @return string Тип Оплаты
     */
    public function getPaymentMethod(){
        return $this->paymentMethod;
    }

  /**
   * @return Vat Ставка НДС.
   */
  public function getVat(){
    return $this->vat;
  }

  /**
   * {@inheritdoc}
   */
  public function toJson(){
    return sprintf(
      '{"name":"%s","quantity":%01.3f,"price":%01.2f,"sum":%01.2f,"payment_method":"%s","vat":%s}',
      addcslashes(addcslashes($this->name, '/'), '"'),
      $this->quantity,
      $this->price,
      $this->sum,
      $this->paymentMethod,
      $this->vat->toJson()
    );
  }
}
