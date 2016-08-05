# Buttons

- [Introduction](#introduction)
- [Basic Usage](#basic-usage)

<hr>

<a name="introduction"></a>
## Introduction

Button definitions are used often in other UI definitions. For example module sections can define buttons and form actions extend them.

<hr>

<a name="basic-usage"></a>
## Basic Usage

Button definitions are just like any other definition. They start as easy as a simple string and can be defined in full as an array, callable string, or closure.

##### Using registered buttons

There are a number of buttons registered in the `Anomaly\Streams\Platform\Ui\Button\ButtonRegistry` class. To use any of these buttons simply inculde their string slug.
 
    'buttons' => [
        'save',
        'delete',
    ]

The full definition registered to the above buttons is as follows.

    'buttons' => [
        'save' => [
            'icon' => 'save',
            'type' => 'success',
            'text' => 'streams::button.save',
        ],
        'delete'        => [
            'icon' => 'trash',
            'type' => 'danger',
            'text' => 'streams::button.delete',
            'attributes' => [
                'data-toggle' => 'confirm',
                'data-message' => 'streams::message.confirm_delete'
            ]
        ],
    ]

##### Overriding registered buttons

Just like other definitions either registered or automated, you can include more information in your definition to override things.

    'buttons' => [
        'save' => [
            'class' => 'btn-xxl',
            'text' => 'Save this entry!',
        ],
        'delete' => [
            'data-message' => 'Deleting is dangerous.. are you sure you want to do this?'
        ],
    ]

##### The button definition

Below is a list of all possible button definition properties available.

<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Default/Fallback</th>
        <th>Description</th>
    </tr>
    <tr>
        <td><code>url</code></td>
        <td>&mdash;</td>
        <td>The URL of the button.</td>
    </tr>
    <tr>
        <td><code>text</code></td>
        <td>{vendor}.module.{module}::button.{button}.title</td>
        <td>The text or translation key.</td>
    </tr>
    <tr>
        <td><code>icon</code></td>
        <td>&mdash;</td>
        <td>A registered icon string or icon class.</td>
    </tr>
    <tr>
        <td><code>class</code></td>
        <td>&mdash;</td>
        <td>A CSS class to append to the button.</td>
    </tr>
    <tr>
        <td><code>type</code></td>
        <td>default</td>
        <td>The button type or context. By default, Bootstrap state colors (primary, success, etc) are supported.</td>
    </tr>
    <tr>
        <td><code>size</code></td>
        <td>md</td>
        <td>The button size. By default, Bootstrap button sized are supported.</td>
    </tr>
    <tr>
        <td><code>attributes</code></td>
        <td>&mdash;</td>
        <td>An array of <code>key => value</code> HTML attributes. Any base level definition keys starting with <code>data-</code> will be pushed into attributes automatically.</td>
    </tr>
    <tr>
        <td><code>permission</code></td>
        <td>&mdash;</td>
        <td>The permission string required to view the button.</td>
    </tr>
    <tr>
        <td><code>disabled</code></td>
        <td>false</td>
        <td>Determines whether the button will be disabled or not. A valuation string like <code>entry.is_disabled</code> can also be used to resolve the value.</td>
    </tr>
    <tr>
        <td><code>enabled</code></td>
        <td>true</td>
        <td>Determines whether the button will be rendered or not. A valuation string like <code>entry.is_disabled</code> can also be used to resolve the value.</td>
    </tr>
    <tr>
        <td><code>dropdown</code></td>
        <td>&mdash;</td>
        <td>An array of item definitions. See below for more information.</td>
    </tr>
    <tr>
        <td><code>position</code></td>
        <td>left</td>
        <td>The position of the button's dropdown.</td>
    </tr>
</table>

##### Dropdown item definitions

Dropdown items are a very small definition.

    'dropdown' => [
        'icon' => 'save',
        'text' => 'Save and exit',
    ]

##### The dropdown item definition

Below is a list of all possible dropdown item definition properties available.

<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Default/Fallback</th>
        <th>Description</th>
    </tr>
    <tr>
        <td><code>text</code></td>
        <td>&mdash;</td>
        <td>The text or translation key.</td>
    </tr>
    <tr>
        <td><code>icon</code></td>
        <td>&mdash;</td>
        <td>A registered icon string or icon class.</td>
    </tr>
    <tr>
        <td><code>url</code></td>
        <td>&mdash;</td>
        <td>The button URL. This gets pushed into <code>attributes</code> automatically as <code>href</code>.</td>
    </tr>
</table>

