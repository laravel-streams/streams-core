# Glossary

<ul class="list-inline">
{% for letter in 'a'|upper..'z'|upper %}
    <li>
        <a href="#{{ letter }}">{{ letter }}</a>
    </li>
{% endfor %}
</ul>

<hr>

<a name="A"></a>
## A

#### Addon

An addon is a composer-like package of code that adds functionality to your project. Pyro supports `extension`, `field_type`, `module`, `plugin`, and `theme` addon types.

<hr>

<a name="C"></a>
## C

#### Command

Commands in Pyro work just like commands in Laravel, with the exception that handlers live in the same directory as commands (if not `SelfHandling`). Commands typically live within addons but can be used just the same as in Laravel.

#### Controller

Controllers in Pyro work just like controllers in Laravel, with some added functionality. Controllers typically live within addons but can be used just the same as in Laravel.

<hr>

<a name="E"></a>
## E

#### Extension

Extensions are an a "wild card" addon type. They let developers build addons and applications that are closed for modification and open for **extension**.

<hr>

<a name="F"></a>
## F

#### Field Type

Field types (FTs) are addons that make up the foundation of your entire application's UI and schema.

<hr>

<a name="M"></a>
## M

#### Message

The `\Anomaly\Streams\Platform\Message\MessageBag` stashes string messages in the session that are used to display alert / info type messages to the user.

{% code php %}
$messages->info("Heads up!");
{% endcode %}

#### Module

Modules are addons that make up the primary building blocks of an application.

<hr>

<a name="P"></a>
## P

#### Plugin

Plugins are addons that act essentially as [Twig extensions](http://twig.sensiolabs.org/doc/advanced.html). They help extend functionality within the view layer.

<hr>

<a name="R"></a>
## R

#### Route

Routes in Pyro work just like routes in Laravel, with some added functionality. Routes typically live in an addon's service provider but can be used just the same as in Laravel.

<hr>

<a name="S"></a>
## S

#### Service Provider

Service providers in Pyro work just like service providers in Laravel, with some added functionality. Service providers typically live within addons but can be used just the same as in Laravel.

<hr>

<a name="T"></a>
## T

#### Template Data

The `\Anomaly\Streams\Platform\View\ViewTemplate` is a collection of data that is set as a global variable in the view layer.

{% code php %}
$template->set("meta_title", "Hello World"); // {% verbatim %}{{ template.meta_title }}{% endverbatim %}
{% endcode %}

#### Theme

Themes the addons that are responsible for displaying the control panel and the public facing site.

<hr>

<a name="V"></a>
## V

#### View

Views in Pyro work just like views in Laravel with the exception that Twig is the default template engine. View's typically live within an addon but can be used anywhere in your application.