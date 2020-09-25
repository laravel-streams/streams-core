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

The Streams platform provides a flexible [policy interface](authorization) for policies.

## Users

The Streams platform provides a simple [user interface](authentication) to adapt to our requirements.
