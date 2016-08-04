# Control Panel

- [Introduction](#introduction)
- [Basic Usage](#basic-usage)
	- [URI Structure](#uri-structure)
	- [Module Navigation](#module-navigation)
	- [Section Navigation](#section-navigation)
	- [Section Buttons](#section-buttons)

<hr>

<a name="introduction"></a>
## Introduction

The control panel is the admin UI for PyroCMS. It is powered primarily by the `modules` installed.

The building of the control panel is delegated to the `ControlPanelBuilder`.

<hr>

<a name="basic-usage"></a>
## Basic Usage

Because much of this process is automated all you need to do is provide a little information in your module and the rest is done for you.

<a name="uri-structure"></a>
### URI Structure

##### Module URIs

Modules, being the primary building block of the control panel, must be routed by their slug first.
 
    admin/products // Products module
    admin/settings // Settings module

##### Section URIs

The third slug is reserved for `sections`. Each module is divided into sections. The first section, known as the `default section` does not require a URI segment.

    admin/products              // default section of products module
    admin/products/categories   // "categories" section of products module
    admin/products/brands       // "brands" section of products module

<div class="alert alert-info">
<strong>Pro-tip:</strong> An excellent naming convention is to name your products after your primary stream. And your default section after your module and primary stream as well so everything aligns nicely. 
</div>

##### Continuing the URI

After the module section segment the control panel no longer has any interest in your URI pattern without further configuration.

<a name="module-navigation"></a>
### Module Navigation

Primary module navigation is entirely automated. To get started just make sure that your module has an `addon.title` language key.
 
    File: products-module/resources/lang/en/addon.php
    
    <?php
    
    return [
        'title' => 'Products'
    ];

<a name="section-navigation"></a>
### Section Navigation

Sections are defined in your `Module` class in the `$sections` property. 

    protected $sections = [
        'users',
        'roles',
        'fields',
    ];

Sections also support `handlers` to dynamically control the sections of your module. To do so use a callable string for your `$sections` property or create a valid handler class next to your module class.

    protected $sections = 'Anomaly\ProductsModule\ProductsModuleSections@handle';

The handler is called from the service container but passed the `$builder`.

    class ProductsModuleSections
    {
        public function handle(ControlPanelBuilder $builder)
        {
            $builder->setSections([
                'users',
                'roles',
                'fields',
            ]);
        }
    }

##### Defining full section definition

By default you only need to define a simple string for a section. This string becomes the `slug` of the section and is used in translating it's name.

You can however provide as much information about the section as you want to customize it's behavior.

    protected $sections = [
        'users'  => [
            'buttons' => [
                'new_user'
            ]
        ],
        'roles'  => [
            'buttons' => [
                'new_role'
            ]
        ],
        'fields' => [
            'buttons' => [
                'add_field' => [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                    'href'        => 'admin/users/fields/choose'
                ]
            ]
        ]
    ];

<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Default</th>
        <th>Description</th>
    </tr>
    <tr>
        <td><pre>slug</pre> <strong class="text-danger">*</strong></td>
        <td>The section array key</td>
        <td>The slug will become the URI segment and must be unique.</td>
    </tr>
    <tr>
        <td><pre>buttons</pre></td>
        <td>None</td>
        <td>An array of button definitions.</td>
    </tr>
</table>

