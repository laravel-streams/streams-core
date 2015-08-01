# Streams

- [Introduction](#introduction)
	- [Streams](#streams)
	- [Fields](#fields)
	- [Assignments](#assignments)


<a name="introduction"></a>
## Introduction

Streams is a powerful abstraction of database structure and related CRUD. "Streams" are made of the [Stream](#streams), it's [Fields](#fields), and those Fields' [Assignments](#assignments).

<a name="streams"></a>
### Streams

A stream represents a database structure, and more accurately the database `table`. Your application might have a stream for users, pages, FAQs, and anything else it needs to manage and display.

Related streams belong to a `namespace`. Oftentimes the namespace is also the name of the module these streams are for. For example the Pages module keeps all it's streams in the "pages" namespace.

<a name="fields"></a>
### Fields

If a stream represents the database `table`, fields represent the available database `columns` and associated `input` to populate that column. Fields also consist of a name, label, a field type, configuration for it's field type, rules like `required` or `unique` and more.

<a name="assignments"></a>
### Assignments

In order to actually add a field to a stream, you must assign it. After a field is assigned, the database column will be added, the input can display in forms and tables, and the field will also be available to access on the entry's model.

	$ryan = $contacts->where('name', 'Ryan Thompson')->first();
	
	echo $ryan->favorite_color; // #76EE00

In the example above `$contacts` is the Streams's entry model which returns the entry `$ryan`. Because we've assigned a "Favorite Color" field we can access the value of the field by the field's slug `favorite_color`. Since the "Favorite Color" field uses the 	`ColorpickerFieldType` it returns the hexadecimal value that was chosen with the color picker input.

Assignments can hold different configuration and rules that override the values in the field. This way, you can use one popular field in many slightly different ways.