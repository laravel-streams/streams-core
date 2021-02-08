<?php

namespace Streams\Core\Exception\Solution;

use Facade\IgnitionContracts\RunnableSolution;
use Illuminate\Support\Facades\Artisan;

class CopyExampleEnvSolution implements RunnableSolution
{
    public function getSolutionTitle(): string
    {
        return 'Your .env file is missing';
    }

    public function getDocumentationLinks(): array
    {
        return [
            'Laravel Streams > Installation' => 'https://streams.dev/docs/configuration',
        ];
    }

    public function getSolutionActionDescription(): string
    {
        return 'Copy the .example.env file using `@php -r \"copy(\'.env.example\', \'.env\');\"`.';
    }

    public function getRunButtonText(): string
    {
        return 'Generate app key';
    }

    public function getSolutionDescription(): string
    {
        return '';
    }

    public function getRunParameters(): array
    {
        return [];
    }

    public function run(array $parameters = [])
    {
        Artisan::run('php -r \"file_exists(\'.env\') || copy(\'.env.example\', \'.env\');\"');
    }
}
