# Presenters

- [Introduction](#introduction)
	- [Entry Presenters](#entry-presenters)
	- [Basic Usage](#basic-usage)

<hr>

<a name="introduction"></a>
## Introduction

Presenters help you separate your entity logic (models) from your view layer (presentation logic) for the entity.

All presentable objects including entry models and collections are automatically decorated with a presenter on their way to the view layer. 

    {% verbatim %}
    return $this->view->make('module::some/view', compact('entries'));
    
    {{ dump(entries.first()) }} // An EntryPresenter
    {% endverbatim %}

<a name="entry-presenters"></a>
### Entry Presenters

Entry models return an instance of `Anomaly\Streams\Platform\Entry\EntryPresenter` by default.

You can specify a custom presenter for an entry model by simply placing the presenter next to your model. Entry models automatically detect matching entry presenters via class name transformation.

    {% verbatim %}
    Anomaly\PostsModule\Post\PostModel // Standard model naming convention
    Anomaly\PostsModule\Post\PostPresenter // Detected automatically
    {% endverbatim %}

Your custom presenter should extend the base `EntryPresenter`.

    {% verbatim %}
    class PostPresenter extends EntryPresenter
    {
        public function customMethod()
        {
            // Your logic here...
        }
    }
    {% endverbatim %}

You can also override the `newPresenter` method on your entry model in order to specify the presenter to use.

    {% verbatim %}
    public function newPresenter()
    {
        return new FancyPresenter($this);
    }
    {% endverbatim %}

<a name="basic-usage"></a>
### Basic Usage

It's important to note that all public methods available on the decorated object are available through the presenter verbatim unless overridden in the presenter.

    {% verbatim %}
    $model->getExample(); // "Foo"
    
    $presenter->getExample(); // "Foo"
    
    {{ presenter.getExample() }} // "Foo"
    
    $model->parent(); // Relationship
    
    $presenter->parent(); // Relationship
    
    {{ presenter.parent() }} // Relationship
    {% endverbatim %}

Accessor methods are also accessible through presenter attributes.

    {% verbatim %}
    $model->getExample(); // "Foo"
    
    $presenter->example; // "Foo"
    
    {{ presenter.example }} // "Foo"
    {% endverbatim %}

Common boolean access methods are also accessible through presenter attributes.

    {% verbatim %}
    $model->isDemo(); // boolean
    
    $presenter->demo; // boolean
    
    {{ presenter.demo }} // boolean
    {% endverbatim %}

<div class="alert alert-danger">
<strong>Warning:</strong> Any methods explicitly defined on the presenter override any otherwise interpreted values. 
</div>