Laravel Chatwork
===

[![Build Status](https://travis-ci.org/yokuru/laravel-chatwork.svg?branch=master)](https://travis-ci.org/yokuru/laravel-chatwork)
[![Coverage Status](https://coveralls.io/repos/github/yokuru/laravel-chatwork/badge.svg?branch=master)](https://coveralls.io/github/yokuru/laravel-chatwork?branch=master)
[![MIT License](http://img.shields.io/badge/license-MIT-blue.svg?style=flat)](LICENSE)

[Laravel Notification](https://laravel.com/docs/notifications) driver for Chatwork.

## Installation

With [Composer](https://getcomposer.org/):

```
composer require yokuru/laravel-chatwork
```

After installing the package, please publish the configuration file.

```
php artisan vendor:publish --provider="Yokuru\Chatwork\ServiceProvider"
```

## Usage

### 1. Set the Chatwork API Token

Open `.env` and set your Chatwork API Token like as below.

```
CHATWORK_API_TOKEN=AAAAAAAAAAAAAA
```

### 2. Create an notification class

Create a notification class like as below.

```
class SampleNotification extends ChatworkNotification
{
    function toChatwork($notifiable): ChatworkMessage
    {
        return (new ChatworkMessage())
            ->text('This is sample notification');
    }
}
```

### 3. Sending notification

Here are some examples of notification methods.   
Please refer to the following page if you want to know more about Laravel Notification.  
https://laravel.com/docs/notifications

#### Example of On-Demand Notifications


```
Notification::route('chatwork', '{YOUR_ROOM_ID}')
    ->notify(new SampleNotification());
```

#### Example of using Notifiable trait

Add the method `routeNotificationForChatwork` to your model using Notifiable.

```
class User extends Authenticatable
{
    use Notifiable;
    
    public function routeNotificationForChatwork()
    {
        return '{ROOM_ID_OF_THIS_USER}';   
    }
}
```

Next, just notify when you want.

```
$user->notify(new SampleNotification());
```

## Building message

You can create a chat message as below.

```
(new SampleNotification())
    ->to('999999')
    ->info("Please confirm this.\nhttp://example.com/", 'Customer has been registered.')
    ->toAll()
    ->text('FYI');
```

![sample](https://github.com/yokuru/laravel-chatwork/raw/docs/images/sample.png)

### Mention specific user

```
$message->to('999999');
```

![to](https://github.com/yokuru/laravel-chatwork/raw/docs/images/to.png)

### Mention all users in the room

```
$message->toAll();
```

![toall](https://github.com/yokuru/laravel-chatwork/raw/docs/images/to_all.png)

### Simple text

```
$message->text('This is simple text message.');
```

![text](https://github.com/yokuru/laravel-chatwork/raw/docs/images/text.png)

### Information

```
$message->info('This is information.');
```

![info](https://github.com/yokuru/laravel-chatwork/raw/docs/images/info.png)

#### With title

```
$message->info('This is information.', 'Information title');
```

![info_with_title](https://github.com/yokuru/laravel-chatwork/raw/docs/images/info_with_title.png)

## License

MIT