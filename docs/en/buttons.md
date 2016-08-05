# Buttons

- [Introduction](#introduction)
- [Basic Usage](#basic-usage)
- [Button Registry](#registry)

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

<a name="registry"></a>
## Button Registry

Below are the registered basic buttons. Some definitions that extend buttons may extend on these or use them in their own registry.

    /**
     * Default Buttons
     */
    'default'       => [
        'type' => 'default'
    ],
    'cancel'        => [
        'text' => 'streams::button.cancel',
        'type' => 'default'
    ],
    
    /**
     * Primary Buttons
     */
    'options'       => [
        'text' => 'streams::button.options',
        'type' => 'primary',
        'icon' => 'cog',
    ],
    
    /**
     * Success Buttons
     */
    'green'         => [
        'type' => 'success'
    ],
    'success'       => [
        'icon' => 'check',
        'type' => 'success'
    ],
    'save'          => [
        'text' => 'streams::button.save',
        'icon' => 'save',
        'type' => 'success'
    ],
    'update'        => [
        'text' => 'streams::button.save',
        'icon' => 'save',
        'type' => 'success'
    ],
    'create'        => [
        'text' => 'streams::button.create',
        'icon' => 'fa fa-asterisk',
        'type' => 'success'
    ],
    'new'           => [
        'text' => 'streams::button.new',
        'icon' => 'fa fa-plus',
        'type' => 'success'
    ],
    'new_field'     => [
        'text' => 'streams::button.new_field',
        'icon' => 'fa fa-plus',
        'type' => 'success'
    ],
    'add'           => [
        'text' => 'streams::button.add',
        'icon' => 'fa fa-plus',
        'type' => 'success'
    ],
    'add_field'     => [
        'text' => 'streams::button.add_field',
        'icon' => 'fa fa-plus',
        'type' => 'success'
    ],
    'assign_fields' => [
        'text' => 'streams::button.assign_fields',
        'icon' => 'fa fa-plus',
        'type' => 'success'
    ],
    'send'          => [
        'text' => 'streams::button.send',
        'icon' => 'envelope',
        'type' => 'success'
    ],
    'submit'        => [
        'text' => 'streams::button.submit',
        'type' => 'success'
    ],
    'install'       => [
        'text' => 'streams::button.install',
        'icon' => 'download',
        'type' => 'success'
    ],
    'entries'       => [
        'text' => 'streams::button.entries',
        'icon' => 'list-ol',
        'type' => 'success'
    ],
    'done'          => [
        'text' => 'streams::button.done',
        'type' => 'success',
        'icon' => 'check'
    ],
    'select'        => [
        'text' => 'streams::button.select',
        'type' => 'success',
        'icon' => 'check'
    ],
    'restore'       => [
        'text' => 'streams::button.restore',
        'type' => 'success',
        'icon' => 'repeat'
    ],
    'finish'        => [
        'text' => 'streams::button.finish',
        'type' => 'success',
        'icon' => 'check'
    ],
    'finished'      => [
        'text' => 'streams::button.finished',
        'type' => 'success',
        'icon' => 'check'
    ],
    
    /**
     * Info Buttons
     */
    'blue'          => [
        'type' => 'info'
    ],
    'info'          => [
        'type' => 'info'
    ],
    'information'   => [
        'text' => 'streams::button.info',
        'icon' => 'fa fa-info',
        'type' => 'info'
    ],
    'help'          => [
        'icon'        => 'circle-question-mark',
        'text'        => 'streams::button.help',
        'type'        => 'info',
        'data-toggle' => 'modal',
        'data-target' => '#modal'
    ],
    'view'          => [
        'text' => 'streams::button.view',
        'icon' => 'fa fa-eye',
        'type' => 'info'
    ],
    'export'        => [
        'text' => 'streams::button.export',
        'icon' => 'download',
        'type' => 'info'
    ],
    'fields'        => [
        'text' => 'streams::button.fields',
        'icon' => 'list-alt',
        'type' => 'info'
    ],
    'assignments'   => [
        'text' => 'streams::button.assignments',
        'icon' => 'list-alt',
        'type' => 'info'
    ],
    'settings'      => [
        'text' => 'streams::button.settings',
        'type' => 'info',
        'icon' => 'cog',
    ],
    'configure'     => [
        'text' => 'streams::button.configure',
        'icon' => 'wrench',
        'type' => 'info'
    ],
    
    /**
     * Warning Buttons
     */
    'orange'        => [
        'type' => 'warning'
    ],
    'warning'       => [
        'icon' => 'warning',
        'type' => 'warning'
    ],
    'edit'          => [
        'text' => 'streams::button.edit',
        'icon' => 'pencil',
        'type' => 'warning'
    ],
    
    /**
     * Danger Buttons
     */
    'red'           => [
        'type' => 'danger'
    ],
    'danger'        => [
        'icon' => 'fa fa-exclamation-circle',
        'type' => 'danger'
    ],
    'remove'        => [
        'text' => 'streams::button.remove',
        'type' => 'danger',
        'icon' => 'ban'
    ],
    'delete'        => [
        'icon'       => 'trash',
        'type'       => 'danger',
        'text'       => 'streams::button.delete',
        'attributes' => [
            'data-toggle'  => 'confirm',
            'data-message' => 'streams::message.confirm_delete'
        ]
    ],
    'prompt'        => [
        'icon'       => 'trash',
        'type'       => 'danger',
        'button'     => 'delete',
        'text'       => 'streams::button.delete',
        'attributes' => [
            'data-match'   => 'yes',
            'data-toggle'  => 'prompt',
            'data-message' => 'streams::message.prompt_delete'
        ]
    ],
    'uninstall'     => [
        'type'       => 'danger',
        'icon'       => 'times-circle',
        'text'       => 'streams::button.uninstall',
        'attributes' => [
            'data-toggle'  => 'confirm',
            'data-message' => 'streams::message.confirm_uninstall'
        ]
    ]

