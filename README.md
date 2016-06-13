Amplitude PHP
=============

How to use it
-------------

```php

require_once 'vendor/autoload.php';

$apiKey = '123';
$amplitudeClient = new Amplitude\AmplitudeClient($apiKey);

$amplitudeEvent = new Amplitude\Message\Event();

// For user properties
$amplitudeEvent
    ->set('eventType', 'test.event')
    ->set('userId', 1)
    ->set('deviceId', 1)
    ->set('city_id', 1)
    ->set('country_id', 1);

// For event properties
$amplitudeEvent
    ->addToEventProperties('revenue', 1);

try {
    $response = $amplitudeClient->track($amplitudeEvent);
    print 'event tracked';
} catch (Exception $e) {
    print $e->getMessage();
}

```
