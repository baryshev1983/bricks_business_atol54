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
     * @var Client Атрибуты Клиента.
     */
    private $client;

    /**
     * @var Company Атрибуты компании.
     */
    private $company;

  /**
   * @var ItemList Товары.
   */
  private $items;

  /**
   * @var PaymentList Счета.
   */
  private $payments;

  /**
   * @param Client $client Атрибуты клиента.
   * @param Company $company Атрибуты компании.
   * @param ItemList $items Товары.
   * @param PaymentList $payments Счета.
   */
  public function __construct(Client $client, Company $company, ItemList $items, PaymentList $payments)
  {
    $this->client = $client;
    $this->company = $company;
    $this->items = $items;
    $this->payments = $payments;
  }

    /**
     * @return Client Атрибуты компании.
     */
    public function getClient(){
        return $this->client;
    }
    /**
     * @return Company Атрибуты компании.
     */
    public function getCompany(){
        return $this->company;
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
  public function toJson()
  {
    return sprintf(
      '{"client":%s,"company":%s,"items":%s,"payments":%s,"total":%01.2f}',
      $this->client->toJson(),
      $this->company->toJson(),
      $this->items->toJson(),
      $this->payments->toJson(),
      $this->getSum()
    );
  }
}
