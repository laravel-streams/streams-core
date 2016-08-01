# Routers

- [Introduction](#introduction)
	- [Entry Routers](#entry-routers)
	- [Basic Usage](#basic-usage)

<hr>

<a name="introduction"></a>
## Introduction

Routers help you package and present your named routes for models. 

    {% verbatim %}
    return $this->redirect->to($product->route('view')); // Returns route named anomaly.module.products::products.view
    
    return $this->redirect->to($product->getRouter()->preview()); // Returns preview method from ProductRouter 
    {% endverbatim %}

<a name="entry-routers"></a>
### Entry Routers

Entry models return an instance of `Anomaly\Streams\Platform\Entry\EntryRouter` by default.

You can specify a custom router for an entry model by simply placing the router next to your model. Entry models automatically detect matching entry routers via class name transformation.

    {% verbatim %}
    Anomaly\PostsModule\Post\PostModel // Standard model naming convention
    Anomaly\PostsModule\Post\PostRouter // Detected automatically
    {% endverbatim %}

Your custom router should extend the base `EntryRouter`.

    {% verbatim %}
    class PostRouter extends EntryRouter
    {
        public function customMethod()
        {
            // Return your path / URL
        }
    }
    {% endverbatim %}

You can also override the `newRouter` method on your entry model in order to specify the router to use.

    {% verbatim %}
    public function newRouter()
    {
        return app(FancyRouter::class, ['model' => $this]);
    }
    {% endverbatim %}

<a name="basic-usage"></a>
### Basic Usage

By default the router simply looks for named routes within your addon that match the model.
   
Named routes should adhere to the following convention:

    {% verbatim %}
    {vendor}.{type}.{addon}::{namespace}.{name}
    
    anomaly.module.posts::categories.view
    {% endverbatim %}

##### Accessing simple routes

Most routes can be accessed via the `route` method by simply providing the simple name of the route.
    
    {% verbatim %}
    $product->route('view); // API example
    
    {% for category in entries('posts', 'categories').get() %}
        {{ category.route('view') }} // anomaly.module.posts::categories.view
    {% endfor %}
    
    {{ product.category.route('view') }} // Any entry can provide it's route
    {% endverbatim %}

##### Accessing custom routes

Some routers have custom methods to provide more complex routes. These can be accessed through the actual router.

    {% verbatim %}
    $product->getRouter()->variant(2); // API example
    
    {{ product.router.variant(2) }}
    {% endverbatim %}