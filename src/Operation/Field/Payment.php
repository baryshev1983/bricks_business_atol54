<?php
namespace Bricks\Business\Atol54\Operation\Field;

use Bricks\Business\Atol54\JsonSerializableInterface;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;

/**
 * Счет.
 *
 * @author Artur Sh. Mamedbekov
 */
class Payment implements JsonSerializableInterface{
  /**
   * @var int Вид оплаты.
   */
  private $type;

  /**
   * @var float Сумма к оплате в рублях.
   */
  private $sum;

  /**
   * @param int|string $type Вид оплаты (1 - электронная).
   * @param float|int|string $sum Сумма к оплате в рублях.
   */
  public function __construct($type, $sum){
    if(!is_int($type) && !is_string($type)){
      throw InvalidArgumentException::fromParam('type', 'int|string', $type);
    }
    $type = (int) $type;
    if($type < 1 || $type > 9){
      throw new InvalidArgumentException(sprintf(
        'The type should be "[1-9]", %s given',
        $type
      ));
    }
    $this->type = $type;
    if(!is_string($sum) && !is_int($sum) && !is_float($sum)){
      throw InvalidArgumentException::fromParam('sum', 'float|int|string', $sum);
    }
    $this->sum = (float) $sum;
  }

  /**
   * @return int Вид оплаты.
   */
  public function getType(){
    return $this->type;
  }

  /**
   * @return float Сумма к оплате в рублях.
   */
  public function getSum(){
    return $this->sum;
  }

  /**
   * {@inheritdoc}
   */
  public function toJson(){
    return sprintf(
      '{"type":%s,"sum":%01.2f}',
      $this->type,
      $this->sum
    );
  }
}
