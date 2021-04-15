---
title: Security
category: basics
intro: 
stage: outlining
enabled: true
sort: 99
todo: 
---

## CSRF

The Streams platform build on [Laravel CSRF basics](https://laravel.com/docs/csrf).

### Route Option

You can also disable CSRF protection using [route options](routing#route-options).

```json
"csrf": false
```
 
```php
Route::streams('uri', [
    'csrf' => false
]);
```

## Policies

The Streams platform uses [policies](policies) to authorize secured actions.

## Users

The Streams platform makes it easy to use and integrate any authentication system or roll your own based on your projects needs.

@todo Document user examples and how this can be acheived easily!
