---
title: Fields
sort: 5
stage: review
enabled: 1
---

# Fields

Fields define the structure and behavior of your stream entries. Each field has a type that determines how data is stored, validated, cast, and displayed.

## What is a Field?

A field represents a single property of an entry. Fields provide:

- **Type Casting** - Automatic conversion to proper PHP types
- **Validation** - Built-in rules and custom validation
- **Processing** - Modify data before storage and after retrieval
- **Defaults** - Automatic default values
- **Relationships** - Connect to other streams

## Defining Fields

### Short Syntax

For simple fields, just specify the type:

```json
{
    "fields": {
        "title": "string",
        "published": "boolean",
        "views": "integer",
        "price": "decimal"
    }
}
```

### Long Syntax

For advanced configuration:

```json
{
    "fields": {
        "title": {
            "type": "string",
            "required": true,
            "rules": ["max:200"],
            "default": "Untitled",
            "example": "My First Post"
        }
    }
}
```

## Field Properties

All fields support these common properties:

| Property | Type | Description |
|----------|------|-------------|
| `type` | string | Field type (string, integer, boolean, etc.) |
| `required` | boolean | Whether field is required |
| `unique` | boolean | Whether value must be unique |
| `default` | mixed | Default value when creating entries |
| `rules` | array | Laravel validation rules |
| `config` | object | Type-specific configuration |
| `example` | mixed | Example value for documentation |
| `description` | string | Field description |
| `protected` | boolean | Hide from array/JSON output |

## Available Field Types

### String

Text values up to 255 characters.

```json
{
    "title": {
        "type": "string",
        "required": true,
        "rules": ["max:200"]
    }
}
```

**Auto-generated examples:** Based on field name, generates realistic data like names, addresses, phone numbers, etc.

### Text

Longer text content (stored as TEXT in database).

```json
{
    "content": {
        "type": "text",
        "required": true
    }
}
```

### Integer

Whole numbers.

```json
{
    "views": {
        "type": "integer",
        "default": 0,
        "rules": ["min:0"]
    }
}
```

### Decimal

Floating point numbers.

```json
{
    "price": {
        "type": "decimal",
        "default": 0.00,
        "config": {
            "decimals": 2
        }
    }
}
```

### Number

General numeric field (integer or decimal).

```json
{
    "rating": {
        "type": "number",
        "rules": ["min:1", "max:5"]
    }
}
```

### Boolean

True/false values.

```json
{
    "published": {
        "type": "boolean",
        "default": false
    }
}
```

### Date

Date without time.

```json
{
    "birth_date": {
        "type": "date"
    }
}
```

Returns Carbon instance for easy date manipulation.

### Datetime

Date and time.

```json
{
    "published_at": {
        "type": "datetime"
    }
}
```

Returns Carbon instance.

### Time

Time without date.

```json
{
    "start_time": {
        "type": "time"
    }
}
```

### Email

Email address with validation.

```json
{
    "email": {
        "type": "email",
        "required": true,
        "unique": true
    }
}
```

Automatically validates email format.

### Url

URL with validation.

```json
{
    "website": {
        "type": "url"
    }
}
```

Automatically validates URL format.

### Slug

URL-friendly slug.

```json
{
    "slug": {
        "type": "slug",
        "unique": true
    }
}
```

Auto-generates from other fields (typically title).

### Uuid

Universally unique identifier.

```json
{
    "id": {
        "type": "uuid",
        "required": true
    }
}
```

Automatically generates UUID v4 if not provided.

### Color

Color value (hex, rgb, etc.).

```json
{
    "brand_color": {
        "type": "color",
        "default": "#3490dc"
    }
}
```

### Hash

Hashed value (for passwords, etc.).

```json
{
    "password": {
        "type": "hash",
        "required": true,
        "rules": ["min:8"]
    }
}
```

Automatically hashes using bcrypt. Cannot be decrypted.

### Encrypted

Encrypted value that can be decrypted.

```json
{
    "api_key": {
        "type": "encrypted"
    }
}
```

Uses Laravel's encryption. Can be decrypted.

### Array

Array of values.

```json
{
    "tags": {
        "type": "array",
        "default": []
    }
}
```

**With wrapper collection:**

```json
{
    "tags": {
        "type": "array",
        "config": {
            "wrapper": "Illuminate\\Support\\Collection"
        }
    }
}
```

Returns a Collection instead of plain array.

### Object

Object/associative array.

```json
{
    "meta": {
        "type": "object",
        "default": {}
    }
}
```

### Select

Single selection from options.

```json
{
    "status": {
        "type": "select",
        "config": {
            "options": {
                "draft": "Draft",
                "published": "Published",
                "archived": "Archived"
            }
        },
        "default": "draft"
    }
}
```

### Multiselect

Multiple selections from options.

```json
{
    "categories": {
        "type": "multiselect",
        "config": {
            "options": {
                "php": "PHP",
                "laravel": "Laravel",
                "javascript": "JavaScript"
            }
        }
    }
}
```

### Relationship

Relate to entries in another stream.

```json
{
    "author": {
        "type": "relationship",
        "config": {
            "related": "users"
        }
    }
}
```

**Multiple relationships:**

```json
{
    "categories": {
        "type": "relationship",
        "config": {
            "related": "categories",
            "multiple": true
        }
    }
}
```

**Auto-fill with authenticated user:**

```json
{
    "created_by": {
        "type": "relationship",
        "config": {
            "related": "users"
        },
        "default": "auth_id"
    }
}
```

### Polymorphic

Relate to entries in multiple streams.

```json
{
    "commentable": {
        "type": "polymorphic",
        "config": {
            "related": ["posts", "pages", "videos"]
        }
    }
}
```

### File

File upload field.

```json
{
    "attachment": {
        "type": "file",
        "config": {
            "disk": "public",
            "path": "uploads/files"
        }
    }
}
```

### Image

Image upload field with processing.

```json
{
    "featured_image": {
        "type": "image",
        "config": {
            "disk": "public",
            "path": "uploads/images",
            "sizes": {
                "thumbnail": {
                    "width": 150,
                    "height": 150
                },
                "medium": {
                    "width": 800,
                    "height": 600
                }
            }
        }
    }
}
```

## Field Configuration

Each field type supports type-specific configuration via the `config` property.

### Common Configurations

```json
{
    "title": {
        "type": "string",
        "required": true,
        "unique": true,
        "default": "Untitled",
        "rules": ["max:200", "min:3"],
        "config": {
            "max": 200
        }
    }
}
```

### Type-Specific Config

**Decimal precision:**

```json
{
    "price": {
        "type": "decimal",
        "config": {
            "decimals": 2,
            "separator": "."
        }
    }
}
```

**Relationship options:**

```json
{
    "author": {
        "type": "relationship",
        "config": {
            "related": "users",
            "key_name": "id"
        }
    }
}
```

**Image processing:**

```json
{
    "photo": {
        "type": "image",
        "config": {
            "disk": "s3",
            "path": "photos/{year}/{month}",
            "quality": 90,
            "sizes": {
                "thumb": {"width": 100, "height": 100, "fit": "crop"},
                "large": {"width": 1200, "height": 800, "fit": "contain"}
            }
        }
    }
}
```

## Validation Rules

Fields support Laravel validation rules:

```json
{
    "email": {
        "type": "email",
        "required": true,
        "unique": true,
        "rules": [
            "email:rfc,dns",
            "max:255"
        ]
    },
    "age": {
        "type": "integer",
        "rules": [
            "min:18",
            "max:120"
        ]
    },
    "website": {
        "type": "url",
        "rules": [
            "url",
            "active_url"
        ]
    }
}
```

### Conditional Rules

Use validation rules that depend on other fields:

```json
{
    "password": {
        "type": "hash",
        "required": true,
        "rules": ["min:8"]
    },
    "password_confirmation": {
        "type": "string",
        "rules": ["same:password"]
    }
}
```

## Default Values

### Static Defaults

```json
{
    "status": {
        "type": "select",
        "default": "draft"
    }
}
```

### Dynamic Defaults

**Random string:**

```json
{
    "token": {
        "type": "string",
        "default": "random"
    }
}
```

**UUID:**

```json
{
    "id": {
        "type": "uuid"
        // Automatically generates UUID
    }
}
```

**Current user ID:**

```json
{
    "created_by": {
        "type": "relationship",
        "config": {"related": "users"},
        "default": "auth_id"
    }
}
```

## Accessing Field Values

### On Entries

```php
$post = repository('posts')->find(1);

// Property access
echo $post->title;

// Method access
echo $post->getAttribute('title');

// Array access
echo $post['title'];
```

### Type Casting

Fields automatically cast values:

```php
// Boolean field
$post->published = 'true';  // String
var_dump($post->published); // bool(true)

// Integer field
$post->views = '100';       // String
var_dump($post->views);     // int(100)

// Datetime field
$post->published_at = '2024-01-01';
echo $post->published_at->format('F j, Y'); // Carbon instance
```

## Relationships

### One-to-One

```json
{
    "profile": {
        "type": "relationship",
        "config": {
            "related": "profiles"
        }
    }
}
```

```php
$user = repository('users')->find(1);
$profile = $user->profile;
echo $profile->bio;
```

### One-to-Many

```json
{
    "author": {
        "type": "relationship",
        "config": {
            "related": "users"
        }
    }
}
```

```php
$post = repository('posts')->find(1);
$author = $post->author;
echo $author->name;
```

### Many-to-Many

```json
{
    "categories": {
        "type": "relationship",
        "config": {
            "related": "categories",
            "multiple": true
        }
    }
}
```

```php
$post = repository('posts')->find(1);
foreach ($post->categories as $category) {
    echo $category->name;
}
```

## Protected Fields

Hide sensitive data from array/JSON output:

```json
{
    "password": {
        "type": "hash",
        "protected": true
    },
    "api_key": {
        "type": "encrypted",
        "protected": true
    }
}
```

```php
$user = repository('users')->find(1);

// Not in array output
$array = $user->toArray();
// ['id' => 1, 'name' => 'John', ...] (no password)

// Still accessible directly
echo $user->password; // hashed value
```

## Custom Field Types

Create custom field types by extending the base Field class:

**app/Fields/PhoneFieldType.php:**

```php
<?php

namespace App\Fields;

use Streams\Core\Field\Field;

class PhoneFieldType extends Field
{
    public function cast($value)
    {
        // Remove non-numeric characters
        return preg_replace('/[^0-9]/', '', $value);
    }
    
    public function modify($value)
    {
        // Store cleaned value
        return $this->cast($value);
    }
    
    public function decorate($value)
    {
        // Display formatted
        if (strlen($value) === 10) {
            return sprintf('(%s) %s-%s',
                substr($value, 0, 3),
                substr($value, 3, 3),
                substr($value, 6)
            );
        }
        return $value;
    }
    
    public function rules(): array
    {
        return [
            'regex:/^[0-9]{10}$/'
        ];
    }
}
```

**Register in service provider:**

```php
use Streams\Core\Support\Facades\Streams;

Streams::registerFieldType('phone', \App\Fields\PhoneFieldType::class);
```

**Use in stream:**

```json
{
    "phone": {
        "type": "phone",
        "required": true
    }
}
```

## Best Practices

### Use Appropriate Types

```json
{
    "email": "email",        // Not "string"
    "published": "boolean",  // Not "integer"
    "price": "decimal",      // Not "string"
}
```

### Validate Thoroughly

```json
{
    "email": {
        "type": "email",
        "required": true,
        "unique": true,
        "rules": ["email:rfc,dns"]
    }
}
```

### Provide Defaults

```json
{
    "status": {
        "type": "select",
        "default": "draft"
    }
}
```

### Document Fields

```json
{
    "api_key": {
        "type": "encrypted",
        "description": "Third-party API key for integration",
        "example": "sk_test_123abc"
    }
}
```

### Organize Complex Streams

```json
{
    "fields": {
        // Identity
        "id": "uuid",
        "handle": "slug",
        
        // Content
        "title": "string",
        "content": "text",
        
        // Relationships
        "author": {"type": "relationship", "related": "users"},
        
        // Metadata
        "published": "boolean",
        "published_at": "datetime"
    }
}
```

## Next Steps

- **[Validation](/docs/core/validation)** - Learn about validation in depth
- **[Entries](/docs/core/entries)** - Working with entry data
- **[Streams](/docs/core/streams)** - Stream configuration
