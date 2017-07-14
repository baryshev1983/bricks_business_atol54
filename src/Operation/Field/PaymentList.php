<?php
namespace Bricks\Business\Atol54\Operation\Field;

use IteratorAggregate;
use ArrayIterator;
use Bricks\Business\Atol54\JsonSerializableInterface;
use Bricks\Business\Atol54\Exception\OverflowException;

/**
 * Список счетов для заказа.
 *
 * @author Artur Sh. Mamedbekov
 */
class PaymentList implements JsonSerializableInterface, IteratorAggregate{
  /**
   * @var array Список счетов.
   */
  private $list;

  public function __construct(){
    $this->list = [];
  }

  /**
   * Добавляет счет в список.
   *
   * @param Payment $payment Добавляемый счет.
   *
   * @throws OverflowException
   */
  public function add(Payment $payment){
    if(count($this->list) == 10){
      throw new OverflowException('This list is filled');
    }
    $this->list[] = $payment;
  }

  /**
   * {@inheritdoc}
   */
  public function toJson(){
    return sprintf('[%s]',
      implode(',', array_map(function(Payment $payment){
        return $payment->toJson();
      }, $this->list))
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getIterator(){
    return new ArrayIterator($this->list);
  }
}
