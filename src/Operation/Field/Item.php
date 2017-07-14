<?php
namespace Bricks\Business\Atol54\Operation\Field;

use Bricks\Business\Atol54\JsonSerializableInterface;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;

/**
 * Продукт.
 *
 * @author Artur Sh. Mamedbekov
 */
class Item implements JsonSerializableInterface{
  /**
   * Без НДС.
   */
  const TAX_NO = 'none';

  /**
   * Ставка НДС 0%.
   */
  const TAX_0 = 'vat0';

  /**
   * Ставка НДС 10%.
   */
  const TAX_10 = 'vat10';

  /**
   * Ставка НДС 18%.
   */
  const TAX_18 = 'vat18';

  /**
   * Ставка НДС 10/110.
   */
  const TAX_10_110 = 'vat110';

  /**
   * Ставка НДС 18/118.
   */
  const TAX_18_118 = 'vat118';

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
   * @var string Ставка НДС.
   *
   * @see self::TAX_*
   */
  private $tax;

  /**
   * @return string[] Допустимые значения параметра tax.
   */
  public static function getTaxValues(){
    return [
      self::TAX_NO,
      self::TAX_0,
      self::TAX_10,
      self::TAX_18,
      self::TAX_10_110,
      self::TAX_18_118,
    ];
  }

  /**
   * @param string $name Название товара.
   * @param float|int|string $quantity Количество продукта в заказе.
   * @param float|int|string $price Стоимость за единицу продукта.
   * @param string $tax Ставка НДС.
   *
   * @throws InvalidArgumentException
   *
   * @see self::TAX_*
   */
  public function __construct($name, $quantity, $price, $tax){
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
    if(!is_string($quantity) && !is_int($quantity) && !is_float($quantity)){
      throw InvalidArgumentException::fromParam('quantity', 'float|int|string', $quantity);
    }
    $this->quantity = (float) $quantity;
    if(!is_string($price) && !is_int($price) && !is_float($price)){
      throw InvalidArgumentException::fromParam('price', 'float|int|string', $price);
    }
    $this->price = (float) $price;
    if(!is_string($tax)){
      throw InvalidArgumentException::fromParam('tax', 'string', $tax);
    }
    if(!in_array($tax, self::getTaxValues())){
      throw new InvalidArgumentException(sprintf(
        'The tax should be "none|vat0|vat10|vat18|vat110|vat118", %s given',
        $tax
      ));
    }
    $this->tax = $tax;
    $this->sum = $this->quantity * $this->price;
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
   * @return int Ставка НДС.
   */
  public function getTax(){
    return $this->tax;
  }

  /**
   * {@inheritdoc}
   */
  public function toJson(){
    return sprintf(
      '{"name":"%s","quantity":%01.3f,"price":%01.2f,"sum":%01.2f,"tax":"%s"}',
      addcslashes(addcslashes($this->name, '/'), '"'),
      $this->quantity,
      $this->price,
      $this->sum,
      $this->tax
    );
  }
}
