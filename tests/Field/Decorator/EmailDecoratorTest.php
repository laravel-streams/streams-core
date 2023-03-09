<?php

namespace Streams\Core\Tests\Field\Decorator;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\EmailFieldType;

class EmailDecoratorTest extends CoreTestCase
{
    public function test_it_returns_mail_to_link()
    {
        $field = new EmailFieldType([
            'stream' => Streams::make('films')
        ]);

        $decorator = $field->decorate('ryan@pyrocms.com');

        $this->assertStringContainsString(
            'ryan@pyrocms.com</a>',
            $decorator->mailto()
        );

        $this->assertStringContainsString(
            'Email Me</a>',
            $decorator->mailto('Email Me')
        );

        $this->assertStringContainsString(
            'ryan@pyrocms.com</a>',
            (string) $decorator
        );
    }

    public function test_it_returns_obfuscated_email()
    {
        $field = new EmailFieldType([
            'stream' => Streams::make('films')
        ]);

        $decorator = $field->decorate(null);

        $this->assertNull($decorator->obfuscate());

        $decorator = $field->decorate('ryan@pyrocms.com');

        $this->assertStringNotContainsString(
            'ryan@pyrocms.com',
            $decorator->obfuscate()
        );
    }
}
