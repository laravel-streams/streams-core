# Messages

- [Introduction](#introduction)
- [Basic Usage](#basic-usage)
    - [Adding Messages](#adding-messages)
    - [Displaying Messages](#displaying-messages)

<hr>

<a name="introduction"></a>
## Introduction

PyroCMS provides a super simple API for displaying `success`, `info`, `warning`, and `error` flash messages.

<hr>

<a name="basic-usage"></a>
## Basic Usage

Use the `\Anomaly\Streams\Platform\Message\MessageBag` singleton to add and remove flash messages to the message bag.

<div class="alert alert-info">
<strong>Note:</strong> Messages are available as a property on public and admin controllers by default.
</div>

<a name="adding-messages"></a>
### Adding Messages

To add a flash message use the appropriate method per type of message you would like to add.

    $messages = app(MessageBag::class);

    $messages->success('This is a success message.');
    $messages->warning('This is a warning message.');
    $messages->error('This is an error message.');
    $messages->info('This is an info message.');

You can also add messages directly from your controller like this:

    $this->messages->success('You are no logged in.');

<a name="displaying-messages"></a>
### Displaying Messages

To display the messages of a given type simply pull them out of the message bag.

    foreach ($messages->pull('error') as $error) {
        echo trans($message);
    }

When pulling messages, they will no longer display on subsequent page loads. If you need to display messages and preserve their state you can use the `get` method.

    foreach ($messages->get('error') as $error) {
        echo trans($message);
    }

The message is always available in the `template` variable within views.

	{% if template.messages.has('success') %}
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
            {% for message in template.messages.pull('success') %}
                {{ trans(message)|markdown }}
            {% endfor %}
        </div>
    {% endif %}
