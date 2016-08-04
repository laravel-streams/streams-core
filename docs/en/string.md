# String

- [Introduction](#introduction)
    - [Basic Usage](#basic-usage)

<hr>

<a name="introduction"></a>
## Introduction

The string service in PyroCMS extends Laravel's `Str` class.

<a name="basic-usage"></a>
### Basic Usage

Aside from all the inherited methods there are a few additional convenient methods at your disposal. To get started include the `Anomaly\Streams\Platform\Support\Str` class in your code.

##### Converting strings to human readable

Sometimes it's helpful to convert formatted strings like dot syntax keys or slugs into a human readable format.

    echo $str->humanize('posts.view'); // "posts view"

    echo ucwords($str->humanize('my_favorite_post')); "My favorite Post"

##### Truncating strings while preserving whole words

Similar to Laravel's `limit`, the `truncate` method limits the string but preserves whole words.

    echo $str->truncate('The CMS built for everyone.', 10); // "The CMS..."

    echo $str->truncate('The CMS built for everyone.', 10, '... [continued]'); // "The CMS... [continued]"

<div class="alert alert-info">
<strong>Note:</strong> Please refer to the Streams Plugin documentation to learn how to access String functions from a view.
</div>
