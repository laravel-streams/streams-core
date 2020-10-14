---
title: Messages
category: basics
intro: Essential flash messages.
enabled: true
sort: 20
---

## Introduction

The Streams platform provides an implementation agnostic service to include messages with the application response.

#### Flash Messages

Messages will display once, and on the next page load. This is used for **view** responses.

#### API Messages

Messages can provide standardized [API errors](/docs/api/errors).

## Basic Usage

Within your code, before the response is generated, make a call to the `Messages` facade.

```php
use Streams\Core\Support\Facades\Messages;

public function example()
{
    Messages::success('Welcome aboard!');

    return home();
}
```

### Error Types

You may also perform:

```php
Messages::success(): // Set the flash theme to "success".
Messages::error(): // Set the flash theme to "danger".
Messages::warning(): // Set the flash theme to "warning".
Messages::overlay(): // Render the message as an overlay.
Messages::overlay([
    'title' => 'Modal Title'
    'message' => 'Modal Message',
]): // Display a modal overlay with a title.
Messages::danger(): // Render a "danger" flash message that must be dismissed.
Messages::important(): // Add a close button to the flash message.
```

### Displaying Messages

With this message flashed, you may now display it in your views. Because messages and overlays are so common, we provide a template out of the box to get you started. You're free to use - and even modify to your needs - this template how you see fit.

```blade
@verbatim@include('streams::messages')@endverbatim
```

#### Custom Markup

Any array data passed in, including the two mandatory **type** and **content** values.

```blade
@verbatim<ul>
@foreach (Messages::pull() as $message)
    <li>{{ $message->type }}: {{ $message->content }}</li>
@endforeach@endverbatim
</ul>
```
