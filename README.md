# Sms.ru notifications channel for Laravel 5.3 [WIP]

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![StyleCI](https://styleci.io/repos/66461111/shield)](https://styleci.io/repos/66461111)

This package makes it easy to send notifications using [sms.ru](//sms.ru) with Laravel 5.3.

## Contents

- [Installation](#installation)
    - [Setting up the SmsRu service](#setting-up-the-SmsRu-service)
- [Usage](#usage)
    - [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install the package via composer:

```bash
composer require laravel-notification-channels/sms-ru
```

You must install the service provider:
```php
// config/app.php
'providers' => [
    ...
    NotificationChannels\SmsRu\SmsRuServiceProvider::class,
],
```

### Setting up the SmscRu service

Add your SmscRu login, secret key (hashed password) and default sender name  to your `config/services.php`:

```php
// config/services.php
...
'sms-ru' => [
    'api_id'  => env('SMSRU_API_ID'),
    'sender' => 'John_Doe'
],
...
```

## Usage

You can use the channel in your `via()` method inside the notification:

```php
use Illuminate\Notifications\Notification;
use NotificationChannels\SmsRu\SmscRuMessage;
use NotificationChannels\SmsRu\SmscRuChannel;

class AccountApproved extends Notification
{
    public function via($notifiable)
    {
        return [SmsRuChannel::class];
    }

    public function toSmscRu($notifiable)
    {
        return (new SmsRuMessage())
            ->content("Your {$notifiable->service} account was approved!");
    }
}
```

### Available methods

TODO

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email jhaoda@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [romach3](https://github.com/romach3)
- [JhaoDa](https://github.com/jhaoda)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
