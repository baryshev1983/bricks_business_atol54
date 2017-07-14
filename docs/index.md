# Авторизация

Класс _Auth_ используется для представления параметров авторизации клиента сервиса [Атол Онлайн][]. Он реализует интерфейс _JsonSerializableInterface_, что позволяет вызывать метод _toJson_ для формирования JSON-строки из его экземпляра.

**Важно**: здесь и далее стандартный интерфейс библиотеки PHP _JsonSerializable_ не применяется по причине отсутствия возможности генерировать JSON с указанным числом разрядов после запятой для дробных чисел.

Класс _Token_ используется для представления токена авторизации. Он реализует интерфейс _JsonUnserializableInterface_, что позволяет вызвать статичный метод _fromJson_ для формирования экземпляра класса из JSON-строки.

Пример:

```php
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Request;
use Bricks\Business\Atol54\Auth\Auth;
use Bricks\Business\Atol54\Auth\Token;

$auth = new Auth('my_login', 'my_password');

$request = new Request(
  'GET',
  'https://online.atol.ru/possystem/v3/getToken?' . http_build_query($auth->toArray())
);

$client = new HttpClient;
$response = $client->send($request);

$token = Token::fromJson($response->getBody()->getContents());

echo $token->getToken();
```

# Операции

Классы _SellOperation_ и _SellRefundOperation_ используется для представления всех параметров, необходимых для формирования чека по операциям "прихо" и "возврат прихода" с использованием протокола [Атол Онлайн][]. Он реализует интерфейс _JsonSerializableInterface_, что позволяет вызывать метод _toJson_ для формирования JSON-строки из его экземпляра.

Пример операции "приход":

```php
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Request;
use Bricks\Business\Atol54\Operation\Field\Item;
use Bricks\Business\Atol54\Operation\Field\ItemList;
use Bricks\Business\Atol54\Operation\Field\Payment;
use Bricks\Business\Atol54\Operation\Field\PaymentList;
use Bricks\Business\Atol54\Operation\Field\Attributes;
use Bricks\Business\Atol54\Operation\Field\Receipt;
use Bricks\Business\Atol54\Operation\Field\Service;
use Bricks\Business\Atol54\Operation\SellOperation;
use Bricks\Business\Atol54\Operation\Report\ShortReport;

$itemList = new ItemList;
$quantity = 1;
$price = 10;
$itemList->add(new Item('Болты "Особые"', $quantity, $price, Item::TAX_NO));

$paymentList = new PaymentList;
$quantity = 1;
$price = 10;
$paymentList->add(new Payment($quantity, $price));

$clientEmail = 'client@mail.com';
$attributes = new Attributes(Attributes::SNO_PATENT, $clientEmail);

$receipt = new Receipt($attributes, $itemList, $paymentList);

$inn = '0123456789';
$magazineDomain = 'magazine.com';
$service = new Service($inn, $magazineDomain);

$orderId = '123';
$operation = new SellOperation($orderId, $receipt, $service);

$json = $operation->toJson();

$method = 'sell';
$request = new Request(
  'POST',
  sprintf('https://online.atol.ru/possystem/v3/%s/%s?', $groupCode, $method) . http_build_query([
    'tokenid' => $token,
  ]),
  [
    'Content-Type' => 'application/json',
    'Content-Length' => strlen($json),
  ],
  $json
);

$client = new HttpClient;
$response = $client->send($request);

$report = ShortReport::fromJson($response->getBody()->getContents());

echo $report->getUuid();
echo $report->getStatus();
```

**Важно**: операция "возврат прихода" оформляется аналогично, но с использованием метода `sell_refund` (`$method`) и новым идентификатором счета (`$orderId`).

**Важно**: операции "расход" и "возврат расхода" оформляются аналогично с использованием соответствующих методов.

# Отчетность

Все классы данного раздела реализуют интерфейс _JsonUnserializableInterface_, что позволяет вызвать статичный метод _fromJson_ для формирования их экземпляров.

Класс _ShortReport_ используется для представления ответа на запрос регистрации операций.

Пример:

```php
use GuzzleHttp\Client as HttpClient;
use Bricks\Business\Atol54\Operation\Report\ShortReport;

$client = new HttpClient;
$response = $client->send($request);

$report = ShortReport::fromJson($response->getBody()->getContents());

echo $report->getUuid();
echo $report->getStatus();
```

Класс _FullReport_ используется для представления отчета о состоянии операции, возвращаемого методом `report`.

Пример:

```php
use GuzzleHttp\Client as HttpClient;
use Bricks\Business\Atol54\Operation\Report\FullReport;

$request = new Request(
  'GET',
  sprintf('https://online.atol.ru/possystem/v3/%s/report/%s?', $groupCode, $uuid) . http_build_query([
    'tokenid' => $token,
  ])
);

$client = new HttpClient;
$response = $client->send($request);

$report = FullReport::fromJson($response->getBody()->getContents());

echo $report->getPayload()->getFnNumber();
```

[Атол онлай]: http://online.atol.ru/
