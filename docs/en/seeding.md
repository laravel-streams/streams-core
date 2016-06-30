# Seeding

- [Introduction](#introduction)
- [Addon Seeds](#addon-seeds)

<hr>

<a name="introduction"></a>
## Introduction

Seeding in PyroCMS works exactly the same as [seeding in Laravel](https://laravel.com/docs/5.1/seeding).

<a name="addon-migrations"></a>
## Addon Migrations

Addon's can provide their own seeders. When seeding simply define the `--addon` option to designate the addon to seed.

    php artisan db:seed --addon=anomaly.module.posts

### Creating Addon Migrations

The above command will look for a seeder class named after your addon class.

    ExampleModule becomes ExampleModuleSeeder

To get started simply create the seeder class and define your run method. Here is a real example:

    <?php namespace Anomaly\PostsModule;

    use Anomaly\PostsModule\Category\CategorySeeder;
    use Anomaly\PostsModule\Post\PostSeeder;
    use Anomaly\PostsModule\Type\TypeSeeder;
    use Anomaly\Streams\Platform\Database\Seeder\Seeder;

    class PostsModuleSeeder extends Seeder
    {

        public function run()
        {
            $this->call(CategorySeeder::class);
            $this->call(TypeSeeder::class);
            $this->call(PostSeeder::class);
        }
    }
