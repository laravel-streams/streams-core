# Valuation

- [Introduction](#introduction)
    - [Basic Usage](#basic-usage)

<hr>

<a name="introduction"></a>
## Introduction

Valuation in PyroCMS is a service that valuates a value `definition` based on an entry.

A value definition is a string value or simple array that contains at least a `value` key which is a string.

The value service is used heavily in UI components to determine table column values based on column definitions for example.

<a name="basic-usage"></a>
### Basic Usage

To get started you need to include the `Anomaly\Streams\Platform\Support\Value` class in your code.

##### Making a simple value.

The simplest value parameter you can pass is a simple string. Assuming that the `$entry` is a stream entry with a field having a slug `name` we can simply use the field slug.

    echo $value->make('name', $entry); // "Ryan Thompson"

##### Accessing presenter methods

The entry is decorated within the valuator. You can accesses presenter methods just like in a view by using the entry `term`. The entry term is `entry` by default.

    echo $value->make('entry.hello', $entry); // "Hello Ryan Thompson!"

You can also use a function syntax to run presenter methods.

    echo $value->make('entry.say("Hi")', $entry); // "Hi Ryan Thompson!"

##### Changing the entry term

If you would like to refer to the entry as something different you can change the `$term`.

    echo $value->make('person.say("Hi")', $entry, 'person'); // "Hi Ryan Thompson!"

##### Wrapping your value

To wrap your value you must provide the parameters as an array and include a wrapper string that contains `{value}` within it.

    echo $value->make(
        [
            'wrapper' => '<strong>{value}</strong>',
            'value' => 'name'
        ],
        $entry
    ); // "<strong>Ryan Thompson</strong>"

##### Incorporating multiple values

Sometimes you might want to wrap multiple entry values within the same string. To do so the value key should contain an array of values referenced in the wrapper like `{value.key}`

    echo $value->make(
        [
            'wrapper' => '<h1>{value.name}<br><small>{value.email}</small></h1>',
            'value' => [
                'name' => 'name',
                'email' => 'entry.email.mailto'
            ]
        ],
        $entry
    ); // "<h1>Ryan Thompson<br><small><a href="mailto:ryan@pyrocms.com">ryan@pyrocms.com</a></small></h1>"

As you can see you can quickly provide rich value strings from a simple array.

##### Utilizing view fragments

You can also delegate the value to a view. Call them what you will but in PyroCMS they are referred to as fragments because they are similar to partials but generally much smaller and acute in purpose. The `$entry` is passed to the view.

    return $value->make('theme::fragments/micro-profile', $entry);

##### Passing additional information

To pass additional information on top of the entry you can provide a `$payload` array.

    echo $value->make(
        [
            'wrapper' => '<span class="label label-{context}">{value}</span>',
            'value' => 'name'
        ],
        $entry,
        'entry',
        [
            'context' => 'success',
        ]
    ); // "<span class="label label-success">Ryan Thompson</span>"