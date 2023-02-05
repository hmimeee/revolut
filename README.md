# Revolut Payment Gateway
A package to integrate Revolut payment gateway. Revolut is a British financial technology company that offers banking services, but as of December 2022 does not have a UK banking licence.

Read the documentation below to integrate the library for your PHP Application.

## Requirements
PHP 5.6.0 and later.

## Composer
You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash 
composer require hmimeee/revolut
```
To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once('vendor/autoload.php');
```

## Dependencies

The bindings require the following extensions in order to work properly:

-   [`curl`](https://secure.php.net/manual/en/book.curl.php), although you can use your own non-cURL client if you prefer
-   [`json`](https://secure.php.net/manual/en/book.json.php)
-   [`mbstring`](https://secure.php.net/manual/en/book.mbstring.php) (Multibyte String)

If you use Composer, these dependencies should be handled automatically. If you install manually, you'll want to make sure that these extensions are available.

## Getting Started
Simple usage looks like:

```php
$revolut = getRevolut([
    'env' => 'sandbox', //or, live
    'key' => 'Your marchant secret key here'
]);
$response = $revolut->createOrder([
    'amount' => 1210, //The amount must be the smallest currency unit like (from $12.10 to 1210)
    'currency' => 'GBP',
    'description' => 'An example order', //Can skip it as it's optional.
    'name' => 'John Doe', //Can skip it as it's optional.
    'email' => 'email@example.com', //Can skip it as it's optional.
]);

if ($response['status']) {
    $orderId = $response['data']->id; //Keep the Order ID to verify the payment in the Webhook Endpoint.
    
    header("location:" . $response['data']->checkout_url);
} else {
    echo $response['message'];
}
```

## Webhook Endpoint Preparing
A Post request will be sent from Revolut along with the data below:
```json
{
  "event": "ORDER_COMPLETED",
  "order_id": "9fc01989-3f61-4484-a5d9-ffe768531be9",
  "merchant_order_ext_ref": "Test #3928"
}
```
Now match with the Order ID and take your further action like the code below:
```php
if($_POST['event'] == 'ORDER_COMPLETED') {
  //Match that previous $orderId with $_POST['order_id'], and take proper action.
}
```

💥 Boom! You've done everything.
