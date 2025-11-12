---
title: Validation
sort: 6
stage: review
enabled: 1
---

# Validation

Streams Core provides automatic validation based on field types and rules. Data is validated before saving, ensuring integrity and consistency.

## How Validation Works

Validation happens automatically when:

- Creating entries via `repository()->create()`
- Saving entries via `entry->save()`
- Updating entries

Field types provide built-in validation, and you can add custom rules per field.

## Field Validation Rules

### Defining Rules

Add validation rules to field definitions:

```json
{
    "fields": {
        "title": {
            "type": "string",
            "required": true,
            "rules": ["max:200", "min:3"]
        },
        "email": {
            "type": "email",
            "required": true,
            "unique": true,
            "rules": ["email:rfc,dns"]
        },
        "age": {
            "type": "integer",
            "rules": ["min:18", "max:120"]
        }
    }
}
```

### Built-in Field Rules

Some field types have automatic validation:

**Email:**
```json
{
    "email": {
        "type": "email"
        // Automatically validates email format
    }
}
```

**URL:**
```json
{
    "website": {
        "type": "url"
        // Automatically validates URL format
    }
}
```

**Integer:**
```json
{
    "age": {
        "type": "integer"
        // Automatically validates numeric value
    }
}
```

## Common Validation Rules

Streams supports all Laravel validation rules:

### Required

```json
{
    "title": {
        "type": "string",
        "required": true
    }
}
```

### Unique

```json
{
    "email": {
        "type": "email",
        "unique": true
    }
}
```

Automatically checks uniqueness within the stream.

### String Length

```json
{
    "title": {
        "type": "string",
        "rules": [
            "min:3",
            "max:200"
        ]
    }
}
```

### Numeric Range

```json
{
    "age": {
        "type": "integer",
        "rules": [
            "min:18",
            "max:120"
        ]
    },
    "price": {
        "type": "decimal",
        "rules": [
            "min:0",
            "max:9999.99"
        ]
    }
}
```

### Pattern Matching

```json
{
    "phone": {
        "type": "string",
        "rules": [
            "regex:/^[0-9]{10}$/"
        ]
    }
}
```

### In Array

```json
{
    "status": {
        "type": "select",
        "rules": [
            "in:draft,published,archived"
        ]
    }
}
```

### Date Rules

```json
{
    "birth_date": {
        "type": "date",
        "rules": [
            "before:today",
            "after:1900-01-01"
        ]
    },
    "event_date": {
        "type": "datetime",
        "rules": [
            "after:now"
        ]
    }
}
```

### File Rules

```json
{
    "avatar": {
        "type": "image",
        "rules": [
            "image",
            "mimes:jpeg,png,jpg",
            "max:2048"  // KB
        ]
    }
}
```

## Conditional Validation

### Depend on Other Fields

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

### Required If

```json
{
    "shipping_address": {
        "type": "text",
        "rules": ["required_if:delivery_method,shipping"]
    }
}
```

### Required With

```json
{
    "address_2": {
        "type": "string",
        "rules": ["required_with:address_1"]
    }
}
```

## Automatic Validation

Entries validate automatically on save:

```php
try {
    $post = repository('posts')->create([
        'title' => '', // Violates 'required' rule
    ]);
} catch (\Illuminate\Validation\ValidationException $e) {
    $errors = $e->errors();
    
    // [
    //     'title' => ['The title field is required.']
    // ]
}
```

## Manual Validation

### Get Validator Instance

```php
$post = stream('posts')->factory()->make([
    'title' => '',
    'email' => 'invalid-email',
]);

$validator = $post->validator();

if ($validator->fails()) {
    $errors = $validator->errors();
    
    foreach ($errors->all() as $error) {
        echo $error;
    }
}
```

### Validate Without Saving

```php
$validator = stream('posts')->validator([
    'title' => 'Test Post',
    'email' => 'test@example.com',
]);

if ($validator->passes()) {
    // Validation passed
    $post = repository('posts')->create($data);
}
```

## Validation in Controllers

### Example Controller

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Streams\Core\Support\Facades\Streams;

class PostController extends Controller
{
    public function store(Request $request)
    {
        try {
            $post = repository('posts')->create(
                $request->all()
            );
            
            return redirect()
                ->route('posts.show', $post->id)
                ->with('success', 'Post created!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }
    
    public function update(Request $request, $id)
    {
        $post = repository('posts')->find($id);
        
        try {
            $post->fill($request->all());
            $post->save();
            
            return redirect()
                ->route('posts.show', $post->id)
                ->with('success', 'Post updated!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }
}
```

### Displaying Errors in Blade

```blade
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('posts.store') }}">
    @csrf
    
    <div>
        <label>Title</label>
        <input type="text" name="title" value="{{ old('title') }}">
        @error('title')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>
    
    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}">
        @error('email')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>
    
    <button type="submit">Create Post</button>
</form>
```

## Custom Validation Rules

### Using Laravel Validation Rules

Add any Laravel validation rule:

```json
{
    "username": {
        "type": "string",
        "rules": [
            "required",
            "alpha_dash",
            "unique:users,username",
            "min:3",
            "max:20"
        ]
    }
}
```

### Custom Rule Objects

Create custom validation rule classes:

**app/Rules/ValidDiscountCode.php:**

```php
<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidDiscountCode implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if discount code is valid
        return entries('discount_codes')
            ->where('code', $value)
            ->where('active', true)
            ->where('expires_at', '>', now())
            ->exists();
    }
    
    public function message()
    {
        return 'The discount code is invalid or expired.';
    }
}
```

**Use in stream:**

```json
{
    "discount_code": {
        "type": "string",
        "rules": [
            "App\\Rules\\ValidDiscountCode"
        ]
    }
}
```

Or apply at runtime:

```php
$order = repository('orders')->create([
    'discount_code' => $request->code,
], [
    'discount_code' => [new ValidDiscountCode],
]);
```

## Runtime Validation Rules

Add validation rules when creating/updating:

```php
// Extra rules for this operation
$post = repository('posts')->create($data, [
    'title' => ['required', 'max:100'],
    'custom_field' => ['required', 'alpha_num'],
]);
```

## Skipping Validation

Sometimes you need to bypass validation:

```php
$post = stream('posts')->factory()->make([
    'title' => '', // Would normally fail
]);

// Skip validation
$post->save(['validate' => false]);
```

**Use with caution!** Only skip validation when you're certain data is valid.

## Unique Validation

The `unique` property automatically validates uniqueness:

```json
{
    "email": {
        "type": "email",
        "unique": true
    },
    "slug": {
        "type": "slug",
        "unique": true
    }
}
```

### Update Handling

When updating, unique validation automatically excludes the current entry:

```php
$post = repository('posts')->find(1);
$post->email = 'same@email.com'; // Same as current
$post->save(); // Passes validation
```

### Custom Unique Rules

For more control:

```json
{
    "email": {
        "type": "email",
        "rules": [
            "unique:users,email,NULL,id,account_id,1"
        ]
    }
}
```

## Validation Messages

### Custom Messages

While you can't define custom messages in JSON, you can in custom entry classes:

```php
<?php

namespace App\Posts;

use Streams\Core\Entry\Entry;

class Post extends Entry
{
    protected function validationMessages(): array
    {
        return [
            'title.required' => 'Please provide a post title.',
            'title.max' => 'The title is too long (max 200 chars).',
            'email.email' => 'Please provide a valid email address.',
        ];
    }
}
```

### Using Language Files

Create language files for validation:

**resources/lang/en/validation.php:**

```php
return [
    'attributes' => [
        'title' => 'post title',
        'content' => 'post content',
    ],
];
```

## Validation Events

Listen to validation events in custom entry classes:

```php
<?php

namespace App\Posts;

use Streams\Core\Entry\Entry;

class Post extends Entry
{
    protected function onValidating(): void
    {
        // Before validation
        // Clean data, set defaults, etc.
    }
    
    protected function onValidated(): void
    {
        // After successful validation
        // Log, notify, etc.
    }
}
```

## Form Requests

Integrate with Laravel Form Requests:

**app/Http/Requests/StorePostRequest.php:**

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function rules()
    {
        $stream = stream('posts');
        
        // Get rules from stream
        return $stream->rules();
    }
    
    public function messages()
    {
        return [
            'title.required' => 'A post must have a title.',
        ];
    }
}
```

**Controller:**

```php
public function store(StorePostRequest $request)
{
    $post = repository('posts')->create(
        $request->validated()
    );
    
    return redirect()->route('posts.show', $post);
}
```

## API Validation

For API endpoints, return validation errors as JSON:

```php
public function store(Request $request)
{
    try {
        $post = repository('posts')->create(
            $request->all()
        );
        
        return response()->json($post, 201);
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $e->errors(),
        ], 422);
    }
}
```

## Best Practices

### Define Rules in Streams

Keep validation logic in stream definitions:

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

### Use Field Types

Leverage built-in field type validation:

```json
{
    "email": "email",      // Auto-validates
    "website": "url",      // Auto-validates
    "age": "integer"       // Auto-validates
}
```

### Provide Clear Feedback

Return helpful error messages to users:

```php
protected function validationMessages(): array
{
    return [
        'email.unique' => 'This email is already registered.',
        'password.min' => 'Password must be at least 8 characters.',
    ];
}
```

### Validate Early

Validate data before expensive operations:

```php
$validator = stream('posts')->validator($request->all());

if ($validator->fails()) {
    return back()->withErrors($validator)->withInput();
}

// Proceed with expensive operations
$this->processImages();
$this->notifyUsers();
```

### Test Validation

Write tests for validation rules:

```php
public function test_title_is_required()
{
    $this->expectException(ValidationException::class);
    
    repository('posts')->create([
        'title' => '',
    ]);
}

public function test_email_must_be_unique()
{
    repository('users')->create([
        'email' => 'test@example.com',
    ]);
    
    $this->expectException(ValidationException::class);
    
    repository('users')->create([
        'email' => 'test@example.com',
    ]);
}
```

## Next Steps

- **[Fields](/docs/core/fields)** - Learn about field types
- **[Entries](/docs/core/entries)** - Working with entry data
- **[Helpers](/docs/core/helpers)** - Convenient helper functions
