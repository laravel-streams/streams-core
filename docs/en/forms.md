# Forms

- [Introduction](#introduction)
    - [Basic Usage](#basic-usage)
    - [Property Handlers](#property-handlers)
    - [Form Entries](#form-entries)
- [Components](#components)
    - [Fields](#fields)
    - [Sections](#sections)
    - [Actions](#actions)
    - [Buttons](#buttons)
- [Options](#options)
- [Ajax Forms](#ajax)
- [Form Handlers](#handlers)
- [Form Models](#models)
- [Form Repositories](#repositories)
- [Including Assets](#including-assets)
- [Read-only Forms](#readonly)
    
<hr>

<a name="introduction"></a>
## Introduction

Forms let you easily create and update stream entries. They can also be used without streams using regular Eloquent models or without any database backend at all as in an API powered form. 

<a name="basic-usage"></a>
### Basic Usage

To get started use `php artisan make:stream stream_slug vendor.module.slug` to create your stream namespace which will include a form builder.

    php artisan make:stream movies anomaly.module.tv

You can create a form builder manually anywhere but for the sake of demonstration we will use the `Streams Workflow`. 

##### Configuring the form

Every component listed below with have at least a setter and a getter. Some components will have additional methods to insert one definition at a time. An IDE that suggests OOP methods is highly encouraged. 

    $builder
        ->setActions(['save'])
        ->setButtons(['cancel'])
        ->AddOption('title', 'Amazing!']);

##### Rendering the form

To render the form you simply need to return `render()` from your controller. You can also pass along an optional entry `$id`.

    return $builder->render($id);

##### Manually building the form

The `build()` method will take the component definitions and build the form object and it's component objects. You can also pass along an optional entry `$id`.

    $builder->build();
    
    $form = $builder->getForm();
    
    foreach ($form->getFields() as $field) {
        if ($field->isRequired()) {
            echo "{$field->getInputName()} is required!";
        }
    }

<a name="property-handlers"></a>
### Property Handlers

All the properties for the form builder except for the `$model` and the `$repository` support handlers. This means that instead of setting the property on the builder you can instead set a callable string to _handle_ that property.

    protected $fields = MyFieldsHandler::class

Your `MyFieldsHandler` class should be `SelfHandling` since you did not include a `@method` in the handler.

    class MyFieldsHandler implements SelfHandling
    {
        public function handle(FormBuilder $builder)
        {
            $builder->setFields(
                [
                    'name'         => [
                        'label'        => 'module::field.name.name',
                        'instructions' => 'module::field.name.instructions',
                        'type'         => 'anomaly.field_type.text',
                        'required'     => true,
                        'config'       => [
                            'default_value' => function(Guard $auth) {
                                return $auth->user()->getDisplayName();
                            }
                        ]
                    ],
                ]
            );
        }
    }

As you can see in the example above this approach allows for you to implement your own logic to dynamically control the property's related components.

<a name="form-entries"></a>
### Form Entries

Most forms will either create or edit an entry. To create an entry simply exclude the entry value. However to edit an existing entry you must set the entry value.

    $builder->setEntry($id);

You can also set the actual object itself.

    $builder->setEntry($entry);
    
As a short cut you can also simply include an ID in the various build methods.

    $builder->build($id);
    $builder->make($id);
    $builder->render($id);

<a name="components"></a>
## Components

The form builder has many components that are in turn built into component objects for the form object. Below is a list of all available components and how they work.

<a name="fields"></a>
### Fields

Field definitions are the primary building block of a form. If your form uses a stream model then most of the work can be automated for you. However you can also define fields 100% manually too.

##### Using stream fields

To specify fields from the entry stream being used simply include the field slugs of the assigned fields.

    protected $fields = [
        'title',
        'category',
        'description',
    ];

Just like other UI definitions you can override automation and defaults by including more information.

    protected $fields = [
        'title' => [
            'required' => true
        ],
        'category',
        'description',
    ];

If you would like to include all default fields but make changes to only specific ones you can do so with the `'*'` wildcard.

    protected $fields = [
        '*',
        'title' => [
            'disabled' => true
        ],
    ];
    
<div class="alert alert-info">
<strong>Note:</strong> Forms using streams without defined fields will default to all fields.
</div>

##### Defining manual fields

The `InstallerFormBuilder` is a great example of a form that both defines custom fields manually and does not use a database.
 
    protected $fields = [
        'database_driver'       => [
            'label'        => 'anomaly.module.installer::field.database_driver.label',
            'instructions' => 'anomaly.module.installer::field.database_driver.instructions',
            'type'         => 'anomaly.field_type.select',
            'value'        => env('DB_DRIVER', 'mysql'),
            'required'     => true,
            'rules'        => [
                'valid_database',
            ],
            'validators'   => [
                'valid_database' => [
                    'handler' => DatabaseValidator::class,
                    'message' => false
                ]
            ],
            'config'       => [
                'options' => [
                    'mysql'    => 'MySQL',
                    'postgres' => 'Postgres',
                    'sqlite'   => 'SQLite',
                    'sqlsrv'   => 'SQL Server',
                ]
            ],
        ],
    ];
    
<div class="alert alert-primary">
<strong>Pro Tip:</strong> Even automated stream fields can be completely overridden including the field type. 
</div>

##### Skipping fields

You can skip fields from all form processing and being included in the form at all by adding them to the `$skips` array.

    protected $skips = [
        'example_field'
    ];

##### Custom validation

Creating custom validators for your form begins with adding a custom rule. Let's follow the above example and use `valid_database` that will check the field and others submitted to validate a database connection.

Custom validation required both the rule and the validator to be defined:

    'rules'        => [
        'valid_database',
    ],
    'validators'   => [
        'valid_database' => [
            'handler' => DatabaseValidator::class,
            'message' => false
        ]
    ],

Not the message is false because this rule will add it later if failed. You could also define a string or translation key. 

Now all that is left is to define your database validator. The validator is called from the service container and is passed the `$builder`.

    class DatabaseValidator
    {
    
        public function handle(Repository $config, Request $request, Container $container, InstallerFormBuilder $builder)
        {
            $input = $request->all();
    
            $config->set(
                'database.connections.install',
                [
                    'driver'    => $input['database_driver'],
                    'host'      => $input['database_host'],
                    'database'  => $input['database_name'],
                    'username'  => $input['database_username'],
                    'password'  => $input['database_password'],
                    'charset'   => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix'    => ''
                ]
            );
    
            try {
    
                $container->make('db')->connection('install');
    
            } catch (\Exception $e) {
    
                $error = $e->getMessage();
    
                $builder->addFormError('database_driver', trans('module::message.database_error', compact('error')));
    
                return false;
            }
    
            return true;
        }
    }

##### The field definition

Below is a list of all possible field definition properties available.

<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Default/Fallback</th>
        <th>Description</th>
    </tr>
    <tr>
        <td><code>slug</code> <strong class="text-danger">*</strong></td>
        <td>The streams field slug or definition key</td>
        <td>The field slug is used for naming the field input and identifying it amongst other fields.</td>
    </tr>
    <tr>
        <td><code>label</code></td>
        <td>The field assignment label or field name.</td>
        <td>The input label.</td>
    </tr>
    <tr>
        <td><code>instructions</code></td>
        <td>The field assignment instructions or field instructions.</td>
        <td>The input instructions.</td>
    </tr>
    <tr>
        <td><code>warning</code></td>
        <td>The field assignment warning or field warning.</td>
        <td>The input warning.</td>
    </tr>
    <tr>
        <td><code>placeholder</code></td>
        <td>The field assignment placeholder or field placeholder.</td>
        <td>The input placeholder.</td>
    </tr>
    <tr>
        <td><code>type</code></td>
        <td>The field type</td>
        <td>The namespace or slug of a field type to use.</td>
    </tr>
    <tr>
        <td><code>field</code></td>
        <td>The streams field slug</td>
        <td>The streams field slug to use for populating defaults.</td>
    </tr>
    <tr>
        <td><code>required</code></td>
        <td>&mdash;</td>
        <td>A shortcut boolean flag to add <pre>required</pre> to the rules array.</td>
    </tr>
    <tr>
        <td><code>unique</code></td>
        <td>&mdash;</td>
        <td>A shortcut boolean flag to add <pre>unique</pre> to the rules array.</td>
    </tr>
    <tr>
        <td><code>rules</code></td>
        <td>&mdash;</td>
        <td>An array of Laravel validation rules.</td>
    </tr>
    <tr>
        <td><code>validators</code></td>
        <td>&mdash;</td>
        <td>An array of custom validators keyed by rule. See above for more information on custom validation.</td>
    </tr>
    <tr>
        <td><code>prefix</code></td>
        <td>The form prefix</td>
        <td>The prefix helps when more than one form are displayed on a page.</td>
    </tr>
    <tr>
        <td><code>disabled</code></td>
        <td>false</td>
        <td>Determines whether the field will be disabled or not.</td>
    </tr>
    <tr>
        <td><code>enabled</code></td>
        <td>true</td>
        <td>Determines whether the field will be rendered or not.</td>
    </tr>
    <tr>
        <td><code>readonly</code></td>
        <td>false</td>
        <td>Determines whether the field will be read only or not.</td>
    </tr>
    <tr>
        <td><code>hidden</code></td>
        <td>false</td>
        <td>Determines whether the field will be hidden or not.</td>
    </tr>
    <tr>
        <td><code>config</code></td>
        <td>&mdash;</td>
        <td>A config array for the field type.</td>
    </tr>
    <tr>
        <td><code>attributes</code></td>
        <td>&mdash;</td>
        <td>An array of <code>key => value</code> HTML attributes. Any base level definition keys starting with <code>data-</code> will be pushed into attributes automatically.</td>
    </tr>
    <tr>
        <td><code>class</code></td>
        <td>Varies between field types.</td>
        <td>A class to append to the attributes.</td>
    </tr>
    <tr>
        <td><code>input_view</code></td>
        <td>Varies between field types.</td>
        <td>A prefixed view to use for the input.</td>
    </tr>
    <tr>
        <td><code>wrapper_view</code></td>
        <td>streams::form/partials/wrapper</td>
        <td>A prefixed view to use for the field wrapper.</td>
    </tr>
</table>

<a name="sections"></a>
### Sections

Sections help you organize your fields into different field groups.

##### Standard sections

Standard sections simply stack fields on top of each other in a single group. 

    protected $sections = [
        'database'      => [
            'title'  => 'Database Information',
            'fields' => [
                'database_driver',
                'database_host',
                'database_name',
                'database_username',
                'database_password'
            ]
        ],
        'administrator' => [
            'title'  => 'Admin Information',
            'fields' => [
                'admin_username',
                'admin_email',
                'admin_password'
            ]
        ],
    ];

##### Tabbed sections

Tabbed sections allow separating fields in the section into tabs.

    protected $sections = [
        'general' => [
             'tabs' => [
                 'form'          => [
                     'title'  => 'module::tab.form',
                     'fields' => [
                         'form_name',
                         'form_slug',
                         'form_description',
                         'success_message',
                         'success_redirect'
                     ]
                 ],
                 'notification'  => [
                     'title'  => 'module::tab.notification',
                     'fields' => [
                         'send_notification',
                         'notification',
                         'notification_send_to',
                         'notification_cc',
                         'notification_bcc'
                     ]
                 ],
             ]
         ]
    ];

##### Section views

You can also define a view to handle the entire section.

    protected $sections = [
        'general'      => [
            'view'  => 'module::form/general',
        ],
        'advanced'      => [
            'view'  => 'module::form/advanced',
        ],
    ];

##### The section definition

Below is a list of all possible section definition properties available.

<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Default/Fallback</th>
        <th>Description</th>
    </tr>
    <tr>
        <td><code>slug</code></td>
        <td>The definition key.</td>
        <td>The section slug can be used to reference the section later.</td>
    </tr>
    <tr>
        <td><code>title</code></td>
        <td>&mdash;</td>
        <td>The section title.</td>
    </tr>
    <tr>
        <td><code>description</code></td>
        <td>&mdash;</td>
        <td>The section description.</td>
    </tr>
    <tr>
        <td><code>fields</code></td>
        <td>&mdash;</td>
        <td>The section fields.</td>
    </tr>
    <tr>
        <td><code>tabs</code></td>
        <td>&mdash;</td>
        <td>The section tab definitions. See below for more information.</td>
    </tr>
    <tr>
        <td><code>attributes</code></td>
        <td>&mdash;</td>
        <td>An array of <code>key => value</code> HTML attributes. Any base level definition keys starting with <code>data-</code> will be pushed into attributes automatically.</td>
    </tr>
</table>

##### The tab definition

Below is a list of all possible tab definition properties available.

<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Default/Fallback</th>
        <th>Description</th>
    </tr>
    <tr>
        <td><code>slug</code> <span class="text-danger">*</span></td>
        <td>The definition key.</td>
        <td>The tab slug is used in it's HTML markup as part of an ID.</td>
    </tr>
    <tr>
        <td><code>title</code> <span class="text-danger">*</span></td>
        <td>&mdash;</td>
        <td>The tab title.</td>
    </tr>
    <tr>
        <td><code>fields</code></td>
        <td>&mdash;</td>
        <td>The section fields.</td>
    </tr>
</table>

<a name="actions"></a>
### Actions

Actions determine what your form does when submitted. Most actions assume the form saves and then does something else like redirect to a new form or the same form to continue editing the entry.

<div class="alert alert-info">
<strong>Note:</strong> Actions extend UI buttons so some actions may use registered buttons to further automate themselves.
</div>

##### Using registered actions

There are a number of actions registered in the `Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionRegistry` class. To use any of these actions simply inculde their string slug.
 
    protected $actions = [
        'save',
    ];

The full definition registered to the above actions is as follows.

    protected $actions = [
        'save' => [
            'button' => 'save',
            'text'   => 'streams::button.save'
        ],
    ];

##### Overriding registered actions

Just like other definitions either registered or automated, you can include more information in your definition to override things.

    protected $actions = [
        'save' => [
            'text'   => 'Save Me!'
        ],
    ];

##### The action definition

Below is a list of all action specific definition properties available. Since actions extend buttons please refer to UI button documentation for a complete set of options for buttons.

<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Default/Fallback</th>
        <th>Description</th>
    </tr>
    <tr>
        <td><code>slug</code> <span class="text-danger">*</span></td>
        <td>The definition key.</td>
        <td>The action becomes the submit button's name.</td>
    </tr>
    <tr>
        <td><code>redirect</code></td>
        <td>&mdash;</td>
        <td>The action redirect URL.</td>
    </tr>
    <tr>
        <td><code>handler</code></td>
        <td>&mdash;</td>
        <td>A callable class string. This is useful when you want to include additional logic when a form is submitted using a given action.</td>
    </tr>
</table>

##### Action Registry

Below are the registered basic actions. Note the button options that will in turn automate more action properties. Actions may also simply be buttons and allow default handling behavior. So be sure to refer to the button registry for more options.

Registered actions can be found in `Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionRegistry`.

    'update'         => [
        'button' => 'update',
        'text'   => 'streams::button.update'
    ],
    'save_exit'      => [
        'button' => 'save',
        'text'   => 'streams::button.save_exit'
    ],
    'save_edit'      => [
        'button' => 'save',
        'text'   => 'streams::button.save_edit'
    ],
    'save_create'    => [
        'button' => 'save',
        'text'   => 'streams::button.save_create'
    ],
    'save_continue'  => [
        'button' => 'save',
        'text'   => 'streams::button.save_continue'
    ],
    'save_edit_next' => [
        'button' => 'save',
        'text'   => 'streams::button.save_edit_next'
    ]

<a name="buttons"></a>
### Buttons

Form buttons extend base UI buttons and do not add anything to them. Form buttons allow you to add simple button links to your form that do not submit the form.

For more information on button definitions please refer to UI button documentation.

    protected = [
        'cancel',
        'view',
    ];

<a name="options"></a>
## Options

Form options help configure the behavior in general of the form. Anything from toggling specific UI on or off to adding a simple title and description can be done with the form options.

    protected $options = [
        'title' => 'My awesome form!',
        'form_view' => 'module::my/custom/form'
    ];
    
You can also set/add options from the API.

    $builder->addOption('url', 'http://domain.com/example/api');

##### Available options

Below is a list of all available options for forms.

<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Default/Fallback</th>
        <th>Description</th>
    </tr>
    <tr>
        <td><code>form_view</code> <span class="text-danger">*</span></td>
        <td>streams::form/form</td>
        <td>The form view is the primary form layout view.</td>
    </tr>
    <tr>
        <td><code>wrapper_view</code></td>
        <td>streams::blank</td>
        <td>The wrapper view is the admin layout wrapper. This is the view you would override if you wanted to include a sidebar with your form for example.</td>
    </tr>
    <tr>
        <td><code>permission</code></td>
        <td>{vendor}.module.{module}::{stream}.write</td>
        <td>The permission string required to access the form.</td>
    </tr>
    <tr>
        <td><code>url</code></td>
        <td>&mdash;</td>
        <td>The URL for the form submission. This is generally automated but varies depending on how the form is being used.</td>
    </tr>
</table>

<a name="ajax"></a>
## Ajax Forms

You can easily make forms use ajax behavior by setting the `$ajax` property.

    protected $ajax = true;

You can also mark forms ajax on the fly.

    $builder->setAjax(true);

Ajax forms are designed to be included in a modal by default but you can configure it to display like a normal form or however you like.

<a name="handlers"></a>
## Form Handlers

Form handlers are responsible for handling the end result of the form. Generally this is to simply save the form.

The default form handler for example looks like this:

    class FormHandler implements SelfHandling
    {
    
        public function handle(FormBuilder $builder)
        {
            if (!$builder->canSave()) {
                return;
            }
    
            $builder->saveForm();
        }
    }

##### Defining custom handlers

You can use your own form handler by defining it in your form builder. Simply define the self handling class or a callable class string.

    protected $handler = MyCustomHandler::class; // SelfHandling
     
Now in your form handler you can add your own logic.

    class MyCustomHandler implements SelfHandling
    {
    
        public function handle(MyCustomFormBuilder $builder)
        {
            if ($builder->hasFormErrors()) {
                return; // We have errors..
            }
            
            // Do lots of amazing stuff!
        }
    }

<a name="models"></a>
## Form Models

Form models are used to determine the form repository to use and provide the model for the system to use when creating and updating an entry.
 
Form models are guessed based on the form builders position first. If using `php artisan make:stream` the model does not need to be set.

If an entry object is set the model will be pulled off of that next.

Lastly if you would like to or need to define a model yourself you can do so on the form builder.

    protected $model = UserModel::class;

<a name="repositories"></a>
## Form Repositories

Form repositories are used to create an entry when creating and to update an entry when editing. The repository is guessed based on the type of model used.

If you would like to or need to define a repository yourself you can do so on the form builder.

    protected $repository = FancyFormRepository::class;

<a name="including-assets"></a>
## Including Assets

Besides the obvious overriding views to include your own assets you can also specify assets to include with the `$assets` array.

Specify the assets to include per the collection they should be added to.

    protected $assets = [
        'scripts.js' => [
            'theme::js/forms/initialize.js',
            'theme::js/forms/validation.js',
        ],
        'styles.css' => [
            'theme::scss/forms/validation.scss',
        ]
    ];

<a name="readonly"></a>
## Read-only Forms

To render the form as read-only just set the `$readOnly` flag.

    protected $readOnly = true;
