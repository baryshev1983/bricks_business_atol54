<?php
namespace Bricks\Business\Atol54;

/**
 * Интерфейс, описывающий сериализуемые в JSON классы.
 *
 * @author Artur Sh. Mamedbekov
 */
interface JsonSerializableInterface{
  /**
   * @return string JSON-представление объекта.
   */
  public function toJson();
}
