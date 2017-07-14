<?php
namespace Bricks\Business\Atol54\Operation\Field;

use Bricks\Business\Atol54\JsonSerializableInterface;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;

/**
 * Чек.
 *
 * @author Artur Sh. Mamedbekov
 */
class Receipt implements JsonSerializableInterface{
  /**
   * @var Attributes Атрибуты чека.
   */
  private $attributes;
  
  /**
   * @var ItemList Товары.
   */
  private $items;

  /**
   * @var PaymentList Счета.
   */
  private $payments;

  /**
   * @param Attributes $attributes Атрибуты чека.
   * @param ItemList $items Товары.
   * @param PaymentList $payments Счета.
   */
  public function __construct(Attributes $attributes, ItemList $items, PaymentList $payments){
    $this->attributes = $attributes;
    $this->items = $items;
    $this->payments = $payments;
  }

  /**
   * @return Attributes Атрибуты чека.
   */
  public function getAttributes(){
    return $this->attributes;
  }

  /**
   * @return ItemList Товары.
   */
  public function getItems(){
    return $this->items;
  }

  /**
   * @return PaymentList Счета.
   */
  public function getPayments(){
    return $this->payments;
  }

  /**
   * @return float Сумма по чеку в рублях.
   */
  public function getSum(){
    return $this->getItems()->getSum();
  }

  /**
   * {@inheritdoc}
   */
  public function toJson(){
    return sprintf(
      '{"attributes":%s,"items":%s,"payments":%s,"total":%01.2f}',
      $this->attributes->toJson(),
      $this->items->toJson(),
      $this->payments->toJson(),
      $this->getSum()
    );
  }
}
