# Object Definitions

- [Introduction](#introduction)
- [The Build Process](#build-process)

<hr>

<a name="introduction"></a>
## Introduction

Object definitions are a simple string or array that define how to build an object. PyroCMS relies heavily on object definitions to reduce the time / effort overhead of building complex objects like forms, tables, and more.

Definitions are used in PyroCMS to define buttons for a table row, columns in a table row, column values, form fields, form layout sections, and much more.

As you explore docs further you can refer back to this page whenever working with definitions.

The gist is simple. Definitions help you type this:

    'save'

And get this:

    Action {
        active: false
        prefix: null
        slug: "save"
        save: true
        redirect: "https://workbench.local:8890/admin/posts/categories"
        handler: "Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionHandler"
        url: null
        text: "streams::button.save"
        icon: "save"
        class: null
        type: "success"
        size: "sm"
        permission: null
        disabled: false
        enabled: true
        attributes: [
            "name" => "action"
            "value" => "save"
        ]
        dropdown: []
        position: "left"
        parent: null
        entry: null
    }

Imagine the time you'll save when using this pattern on bigger objects like forms!

##### Defining more information

Sometimes you may not want to take the fully automated path. Any additional information that you pass along will be merged into any automation or defaults that exist.
 
    'save' => [
        'text' => 'Save Category'
    ]

The above example would override the otherwise automated title.

    Action {
        active: false
        prefix: null
        slug: "save"
        save: true
        redirect: "https://workbench.local:8890/admin/posts/categories"
        handler: "Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionHandler"
        url: null
        text: "Save Category"
        icon: "save"
        class: null
        type: "success"
        size: "sm"
        permission: null
        disabled: false
        enabled: true
        attributes: [
            "name" => "action"
            "value" => "save"
        ]
        dropdown: []
        position: "left"
        parent: null
        entry: null
    }

##### Providing custom target objects

While it's rarely required, you can also provide your own class name to use for the target object. This is helpful when your class overrides the target object.
 
You can define your class with the name of the definition. For example since we're using action examples, the class would be defined as `action`.

    'save' =>[
        'text' => 'Save Category'
        'special_property' => 'example',
        'action' => MyActionClass::class
    ]

During the hydration process the `special_property` can be set on the `MyActionClass` as long as a public accessor (For example `setSpecialProperty($specialProperty)`) exists.

<a name="build-process"></a>
## The Build Process

While the build process varies slightly from object to object these following processes are always run.

##### Resolving Values

The very first step is always value resolution. This step let's you define actions instead of an array as a callable class string. Resolution also recursively calls callable class strings located within the definitions.
 
    protected $actions = MyActionHandler::class // Implements self handling interface
    
    protected $actions = MyActionHandler::class . '@handle'

Resolution varies from use case to use case but generally if the definition set is a callable string the handler will need to accept the `$builder` and call `setActions` while properties typically need to return the value for the property. 

##### Normalization

The next process that is done is normalization. This step basically turns string definitions into arrays and tries to guess the required property options.

Per our example, the following form `action` definition:

    'save'

Is normalized into this:

    [
        "slug" => "save"
        "action" => "save"
        "attributes" => []
        "size" => "sm"
    ]

Notice the `action` target option is set but is obviously not a class. The `save` action is registered in the `ActionRegistry` and will be replaced with even more property options later. 

##### Guessing

The next step is usually guessing properties of the definition. This again varies by definition but generally the value of options are valuated with the `Value` service and converted to anticipated values.

Consider the above form action example and imagine that that you want to disable for edit forms but not create forms.

    'save' => [
        'disabled' => 'edit' // converted to true/false in the guessing processes based on form mode
    ]

##### Merging registered properties

Remember the above example where the `action` target object was normalized to `save`? That `save` action is a registered action in the `ActionRegistry`.

Each definition type has it's own registry that can be referred to and is documented.

If we continue with the `save` example we will see more properties added after merging registered definitions.

    [
        "text" => "streams::button.save"
        "icon" => "save"
        "type" => "success"
        "slug" => "save"
        "attributes" => [▼
          "name" => "action"
          "value" => "save"
        ]
        "size" => "sm"
        "redirect" => "https://workbench.local:8890/admin/posts/categories"
    ]

And remember all of this started with a simple `'save'` string.

##### Parsing

By this time we should have a very complete set of property options. The parsing stage simply looks recursively for parsable strings and parses them.
 
The payload data passed to the parser differs for each definition type.
 
    'save' => [
        'text' => 'Save {entry.name}'
    ]

##### Evaluation

The evaluation step differs between definition types but is always included.

In this step the definition values are passed through the `Evaluator` service. The payload passed to the evaluator differs between definition types.

    'save' => [
        'text' => function(EntryInterface $entry) { // the form entry in this example
            return "Save {$entry->name}";
        }
    ]

