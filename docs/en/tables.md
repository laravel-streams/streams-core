# Tables

- [Introduction](#introduction)
    - [Basic Usage](#basic-usage)
    - [Property Handlers](#property-handlers)
    - [Table Entries](#table-entries)
- [Components](#components)
    - [Filters](#filters)
    - [Columns](#columns)
    - [Actions](#actions)
- [Options](#options)
- [Ajax Tables](#ajax)
- [Table Models](#models)
- [Table Repositories](#repositories)
- [Including Assets](#including-assets)

<hr>

<a name="introduction"></a>
## Introduction

Tables let you easily display a table of stream entries. They can also be used without streams using regular Eloquent models or without any database backend at all by manually loading entries.

<a name="basic-usage"></a>
### Basic Usage

To get started use `php artisan make:stream stream_slug vendor.module.slug` to create your stream namespace which will include a table builder.

    php artisan make:stream movies anomaly.module.tv

You can create a table builder manually anywhere but for the sake of demonstration we will use the `Streams Workflow`.

##### Configuring the table

Every component listed below with have at least a setter and a getter. Some components will have additional methods to insert one definition at a time. An IDE that suggests OOP methods is highly encouraged.

    $builder
        ->setButtons(['edit'])
        ->setActions(['delete'])
        ->addOption('title', 'Amazing!']);

##### Rendering the table

To render the table you simply need to return `render()` from your controller.

    return $builder->render();

##### Manually building the table

The `build()` method will take the component definitions and build the table object and it's component objects.

    $builder->build();

    $table = $builder->getTable();

    foreach ($table->getRows() as $row) {
        foreach ($row->getColumns() as $column) {
            echo $column->getValue();
        }
    }

<a name="property-handlers"></a>
### Property Handlers

All the properties for the table builder except for the `$model` and the `$repository` support handlers. This means that instead of setting the property on the builder you can instead set a callable string to _handle_ that property.

    protected $columns = MyColumnsHandler::class

Your `MyColumnsHandler` should include a `@method` otherwise `@handle` is assumed.

    class MyColumnsHandler
    {
        public function handle(TableBuilder $builder)
        {
            $builder->setColumns(
                [
                    'name',
                    'status' => [
                        'heading' => 'Status',
                        'value' => function($entry) {
                            return $entry->isEnabled() ? 'Enabled' : 'Disabled';
                        }
                    ]
                ]
            );
        }
    }

<a name="components"></a>
## Components

The table builder has many components that are in turn built into component objects for the table object. Below is a list of all available components and how they work.

<a name="filters"></a>
### Filters

Filter definitions display filters to help find entry sets.

##### Using stream filters

To specify filters from the entry stream being used simply include the filter slugs of the assigned filters.

    protected $filters = [
        'title',
        'category',
        'description',
    ];

##### Defining manual filters

You can also define filters manually.

    protected $filters = [
        'title' => [
            'type' => 'text',
            'query' => MyCustomQuery::class
        ],
    ];

##### The filter query

While the filter querying is generally handled 100% automatically. You can however, define your own logic as well.

    protected $filters = [
        'title' => [
            'query' => MyCustomQuery::class
        ],
    ];

The query class must accept the query `Builder` and is called with the service container.

    public function handle(Builder $query, FilterInterface $filter)
    {
        $query->where('example', 'LIKE', "%" . $filter->getValue() . "%");
    }

The `FieldTypeQuery` is responsible for default query operations. You can associate a custom field type query for your custom field types too.

For more information on developing field types please refer to the Field Type Development documentation.å

<div class="alert alert-primary">
<strong>Pro Tip:</strong> Even automated stream filters can be completely overridden.
</div>

##### The filter definition

Below is a list of all possible filter definition properties available.

<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Default/Fallback</th>
        <th>Description</th>
    </tr>
    <tr>
        <td><code>value</code> <span class="text-danger">*</span></td>
        <td>&mdash;</td>
        <td>The valuated string for the coumn text value. You can pass an array of values and merge them into the wrapper too.</td>
    </tr>
    <tr>
        <td><code>slug</code></td>
        <td>The definition value/key</td>
        <td>The filter slug is used for naming the filter input and identifying it amongst other filters.</td>
    </tr>
    <tr>
        <td><code>heading</code></td>
        <td>The filter assignment name.</td>
        <td>The filter label.</td>
    </tr>
    <tr>
        <td><code>filter</code></td>
        <td>&mdash;</td>
        <td>The custom filter class to use.</td>
    </tr>
    <tr>
        <td><code>wrapper</code></td>
        <td>{value}</td>
        <td>The filter value wrapper. The value is merged into the wrapper.</td>
    </tr>
    <tr>
        <td><code>view</code></td>
        <td>&mdash;</td>
        <td>The view to delegate the filter to.</td>
    </tr>
    <tr>
        <td><code>view</code></td>
        <td>&mdash;</td>
        <td>The view to delegate the filter to.</td>
    </tr>
    <tr>
        <td><code>class</code></td>
        <td>&mdash;</td>
        <td>The filter class. Includes the heading row.</td>
    </tr>
</table>

<a name="columns"></a>
### Columns

Column definitions are the primary building block of a table. If your table uses a stream model then most of the work can be automated for you. However you can also define columns 100% manually too.

##### Using stream columns

To specify columns from the entry stream being used simply include the column slugs of the assigned columns.

    protected $columns = [
        'title',
        'category',
        'description',
    ];

Just like other UI definitions you can override automation and defaults by including more intableation.

    protected $columns = [
        'title' => [
            'heading' => 'Example Title'
        ],
        'category',
        'description',
    ];

<div class="alert alert-info">
<strong>Note:</strong> Tables using streams without defined columns will default to the title column only.
</div>

##### Defining manual columns

You can also define columns manually. Take a look at how the `FileTableBuilder` does it.

    protected $columns = [
        'entry.preview' => [
            'heading' => 'anomaly.module.files::field.preview.name'
        ],
        'name'          => [
            'sort_column' => 'name',
            'wrapper'     => '
                    <strong>{value.file}</strong>
                    <br>
                    <small class="text-muted">{value.disk}://{value.folder}/{value.file}</small>
                    <br>
                    <span>{value.size} {value.keywords}</span>',
            'value'       => [
                'file'     => 'entry.name',
                'folder'   => 'entry.folder.slug',
                'keywords' => 'entry.keywords.labels',
                'disk'     => 'entry.folder.disk.slug',
                'size'     => 'entry.size_label'
            ]
        ],
        'size'          => [
            'sort_column' => 'size',
            'value'       => 'entry.readable_size'
        ],
        'mime_type',
        'folder'
    ];

<div class="alert alert-primary">
<strong>Pro Tip:</strong> Even automated stream columns can be completely overridden.
</div>

##### The column definition

Below is a list of all possible column definition properties available.

<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Default/Fallback</th>
        <th>Description</th>
    </tr>
    <tr>
        <td><code>value</code> <span class="text-danger">*</span></td>
        <td>&mdash;</td>
        <td>The valuated string for the coumn text value. You can pass an array of values and merge them into the wrapper too.</td>
    </tr>
    <tr>
        <td><code>slug</code></td>
        <td>The definition value/key</td>
        <td>The column slug is used for naming the column input and identifying it amongst other columns.</td>
    </tr>
    <tr>
        <td><code>heading</code></td>
        <td>The column assignment name.</td>
        <td>The column label.</td>
    </tr>
    <tr>
        <td><code>column</code></td>
        <td>&mdash;</td>
        <td>The custom column class to use.</td>
    </tr>
    <tr>
        <td><code>wrapper</code></td>
        <td>{value}</td>
        <td>The column value wrapper. The value is merged into the wrapper.</td>
    </tr>
    <tr>
        <td><code>view</code></td>
        <td>&mdash;</td>
        <td>The view to delegate the column to.</td>
    </tr>
    <tr>
        <td><code>view</code></td>
        <td>&mdash;</td>
        <td>The view to delegate the column to.</td>
    </tr>
    <tr>
        <td><code>class</code></td>
        <td>&mdash;</td>
        <td>The column class. Includes the heading row.</td>
    </tr>
</table>

<a name="actions"></a>
### Actions

Actions determine available mass actions for the table when 1 or more rows are selected.

<div class="alert alert-info">
<strong>Note:</strong> Actions extend UI buttons so some actions may use registered buttons to further automate themselves.
</div>

##### Using registered actions

There are a number of actions registered in the `Anomaly\Streams\Plattable\Ui\Table\Component\Action\ActionRegistry` class. To use any of these actions simply include their string slug.

    protected $actions = [
        'delete',
    ];

The full definition registered to the above actions is as follows.

    protected $actions = [
        'delete' => [
            'handler' => Delete::class
        ],
    ];

##### Overriding registered actions

Just like other definitions either registered or automated, you can include more information in your definition to override things.

    protected $actions = [
        'delete' => [
            'text' => 'Delete rows!'
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
        <td><code>slug</code> <span class="text-danger">\*</span></td>
        <td>The definition key.</td>
        <td>The action becomes the submit button's name.</td>
    </tr>
    <tr>
        <td><code>permission</code></td>
        <td>&mdash;</td>
        <td>The required permission to view/execute the action.</td>
    </tr>
    <tr>
        <td><code>handler</code></td>
        <td>&mdash;</td>
        <td>A callable class string or closure. The handler is passed an array of selected IDs from the table as well as the table builder itself.</td>
    </tr>
</table>

##### Action Registry

Below are the registered basic actions. Note the button options that will in turn automate more action properties. Actions may also simply be buttons and allow default handling behavior. So be sure to refer to the button registry for more options.

Registered actions can be found in `Anomaly\Streams\Plattable\Ui\Table\Component\Action\ActionRegistry`.

    'delete'       => [
        'handler' => Delete::class
    ],
    'prompt'       => [
        'handler' => Delete::class
    ],
    'force_delete' => [
        'button'  => 'prompt',
        'handler' => ForceDelete::class,
        'text'    => 'streams::button.force_delete',
    ],
    'export'       => [
        'button'  => 'info',
        'icon'    => 'download',
        'handler' => Export::class,
        'text'    => 'streams::button.export'
    ],
    'edit'         => [
        'handler' => Edit::class
    ],
    'reorder'      => [
        'handler' => Reorder::class,
        'text'    => 'streams::button.reorder',
        'icon'    => 'fa fa-sort-amount-asc',
        'class'   => 'reorder',
        'type'    => 'success'
    ]

##### The Action Handler

Below is an example of the action handler.

    class ExampleHandler extends ActionHandler
    {

        public function handle(ExampleTableBuilder $builder, array $selected)
        {
            $model = $builder->getTableModel();

            foreach ($selected as $id) {

                $entry = $model->find($id);

                // Do something here
            }

            if ($selected) {
                $this->messages->success('Something amazing was done!');
            }
        }
    }

<a name="options"></a>
## Options

Table options help configure the behavior in general of the table. Anything from toggling specific UI on or off to adding a simple title and description can be done with the table options.

    protected $options = [
        'title' => 'My awesome table!',
        'table_view' => 'module::my/custom/table'
    ];

You can also set/add options from the API.

    $builder->addOption('title', 'Example Title');

##### Available options

Below is a list of all available options for tables.

<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Default/Fallback</th>
        <th>Description</th>
    </tr>
    <tr>
        <td><code>table_view</code> <span class="text-danger">\*</span></td>
        <td>streams::table/table</td>
        <td>The table view is the primary table layout view.</td>
    </tr>
    <tr>
        <td><code>wrapper_view</code></td>
        <td>streams::blank</td>
        <td>The wrapper view is the admin layout wrapper. This is the view you would override if you wanted to include a sidebar with your table for example.</td>
    </tr>
    <tr>
        <td><code>permission</code></td>
        <td>{vendor}.module.{module}::{stream}.read</td>
        <td>The permission string required to access the table.</td>
    </tr>
</table>

<a name="ajax"></a>
## Ajax Tables

You can easily make tables use ajax behavior by setting the `$ajax` property.

    protected $ajax = true;

You can also mark tables ajax on the fly.

    $builder->setAjax(true);

Ajax tables are designed to be included in a modal by default but you can configure it to display like a normal table or however you like.

<a name="models"></a>
## Table Models

Table models are used to determine the table repository to use and provide the model for the system to use when creating and updating an entry.

Table models are guessed based on the table builders position first. If using `php artisan make:stream` the model does not need to be set.

If an entry object is set the model will be pulled off of that next.

Lastly if you would like to or need to define a model yourself you can do so on the table builder.

    protected $model = UserModel::class;

<a name="repositories"></a>
## Table Repositories

Table repositories are used to create an entry when creating and to update an entry when editing. The repository is guessed based on the type of model used.

If you would like to or need to define a repository yourself you can do so on the table builder.

    protected $repository = FancyTableRepository::class;

<a name="including-assets"></a>
## Including Assets

Besides the obvious overriding views to include your own assets you can also specify assets to include with the `$assets` array.

Specify the assets to include per the collection they should be added to.

    protected $assets = [
        'scripts.js' => [
            'theme::js/tables/initialize.js',
            'theme::js/tables/validation.js',
        ],
        'styles.css' => [
            'theme::scss/tables/validation.scss',
        ]
    ];
