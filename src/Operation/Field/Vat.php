<?php
namespace Bricks\Business\Atol54\Operation\Field;

use Bricks\Business\Atol54\JsonSerializableInterface;
use Bricks\Business\Atol54\Exception\InvalidArgumentException;

/**
 * Атрибуты налога на позицию.
 *
 * @author Vladimir Baryshev
 */
class Vat implements JsonSerializableInterface
{
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
     * Допустимые значения параметра type.
     */
  const VAT_TYPES = [
      self::TAX_NO,
      self::TAX_0,
      self::TAX_10,
      self::TAX_18,
      self::TAX_10_110,
      self::TAX_18_118,
    ];

  /**
   * @var string Ставка НДС.
   */
  private $type;

  /**
   * @var float Стоимость за единицу продукта в рублях.
   */
  private $sum;

  /**
   * @param float|int|string $sum Стоимость за единицу продукта.
   * @param string $type Ставка НДС.
   *
   * @throws InvalidArgumentException
   */
  public function __construct($type = self::TAX_NO, $sum = null)
  {
      if ($sum !== null) {
          $this->sum = (float)$sum;
      }

      if(!is_string($type)){
          throw InvalidArgumentException::fromParam('type', 'string', $type);
      } elseif(!in_array($type, self::VAT_TYPES)){
          throw new InvalidArgumentException(sprintf(
            'The tax should be "none|vat0|vat10|vat18|vat110|vat118", %s given',
            $type
          ));
      }
      $this->type = $type;
  }

  /**
   * @return string Ставка НДС.
   */
  public function getType(){
    return $this->type;
  }

  /**
   * @return float Стоимость за единицу продукта в рублях.
   */
  public function getSum(){
    return $this->sum;
  }

  /**
   * {@inheritdoc}
   */
  public function toJson()
  {
      if ($this->sum !== null) {
          return sprintf(
              '{"type":"%s","sum":"%s"}',
              $this->type,
              $this->sum
          );
      } else {
          return sprintf(
              '{"type":"%s"}',
              $this->type
          );
      }
  }
}
