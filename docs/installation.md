---
title: Installation
sort: 1
stage: review
enabled: 1
---

# Installation

Getting started with Streams Core is straightforward. This guide will walk you through installing and configuring the package in your Laravel application.

## Requirements

- PHP 8.0 or higher
- Laravel 10, 11, or 12
- Composer

## Installation via Composer

Install Streams Core using Composer:

```bash
composer require streams/core
```

The package will automatically register its service provider through Laravel's package auto-discovery.

## Publishing Assets (Optional)

If you need to customize public assets, publish them to your application:

```bash
php artisan vendor:publish --tag=public --provider="Streams\Core\StreamsServiceProvider"
```

This will copy public assets to `public/vendor/streams/core`.

## Configuration

Streams Core works out of the box with sensible defaults. However, you can publish and customize configuration if needed.

### Default Paths

By default, Streams looks for stream definitions in:

- `streams/` - Your stream definition files (JSON or YAML)
- `resources/streams/` - Package/addon stream definitions

### Creating Your First Stream Directory

Create the streams directory in your Laravel project root:

```bash
mkdir streams
```

## Verifying Installation

To verify Streams Core is installed correctly, create a test stream:

**streams/pages.json:**

```json
{
    "name": "Pages",
    "fields": {
        "title": "string",
        "slug": "slug",
        "content": "text"
    }
}
```

Then test it in `tinker`:

```bash
php artisan tinker
```

```php
>>> use Streams\Core\Support\Facades\Streams;
>>> $page = Streams::repository('pages')->create(['title' => 'Home', 'content' => 'Welcome!']);
>>> echo $page->title;
// "Home"
```

If you see the output, you're all set!

## Available Facades

Streams Core provides several facades for convenience:

```php
use Streams\Core\Support\Facades\Streams;      // Stream management
use Streams\Core\Support\Facades\Assets;       // Asset management
use Streams\Core\Support\Facades\Images;       // Image processing
use Streams\Core\Support\Facades\Applications; // Multi-app support
use Streams\Core\Support\Facades\Addons;       // Addon system
```

## Helper Functions

Streams Core also registers global helper functions:

```php
stream('posts')          // Get a stream instance
entries('posts')         // Query entries
repository('posts')      // Get repository instance
response_time()          // Get response time
memory_usage()           // Get current memory usage
```

## Directory Structure

After installation, your typical project structure might look like:

```
your-laravel-app/
├── app/
├── streams/              ← Your stream definitions
│   ├── posts.json
│   ├── pages.json
│   └── users.yaml
├── resources/
│   └── streams/          ← Package stream definitions
├── public/
└── vendor/
    └── streams/
        └── core/
```

## Data Storage

By default, streams can store data in multiple ways:

- **Filebase** (JSON files) - Default, no database required
- **Database** - Using Laravel's database
- **Eloquent** - Leverage existing Eloquent models
- **Collection** - In-memory data
- **Custom** - Build your own adapter

You configure the data source per stream. See the [Streams documentation](/docs/core/streams) for more details.

## Next Steps

Now that Streams Core is installed, you're ready to:

1. **[Define Streams](/docs/core/streams)** - Learn how to create stream definitions
2. **[Work with Entries](/docs/core/entries)** - Create and manage data
3. **[Query Data](/docs/core/repositories)** - Use repositories to query entries
4. **[Configure Fields](/docs/core/fields)** - Explore available field types

## Troubleshooting

### Stream Not Found Error

If you get a "Stream [name] is not registered" error:

1. Check that your stream file exists in the `streams/` directory
2. Verify the file is valid JSON or YAML
3. Clear your application cache: `php artisan cache:clear`
4. Check file permissions

### Autoloading Issues

If facades or helpers aren't working:

```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### File Permission Errors

If using file-based storage, ensure your web server has write permissions:

```bash
chmod -R 775 streams/data
chown -R www-data:www-data streams/data
```
