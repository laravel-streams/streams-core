# Parser

- [Introduction](#introduction)
	- [Basic Usage](#basic-usage)

<hr>

<a name="introduction"></a>
## Introduction

The `Parser` service is a simple class that parses data into a string. The parser leverages the [nicmart/string-template](https://packagist.org/packages/nicmart/string-template) package.

<a name="basic-usage"></a>
### Basic Usage

Using the parser is easy! Just include `Anomaly\Streams\Platform\Support\Parser` in your code and run `parse` on your string.

    $parser->parse('Hello {user.first_name} {user.last_name}!', ['user' => Auth::user()]);

Note that here, because stream entries are `Arrayable` the object can be traversed like a nested array.

##### Parsing strings from within a view

You can use the `parse` function in your view just like the API.

    {{ parse('Hello {name}!', {'name': 'Ryan'}) }}
