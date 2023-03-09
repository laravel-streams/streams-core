<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Schema\EmailSchema;
use Streams\Core\Field\Types\EmailFieldType;
use Streams\Core\Field\Decorator\EmailDecorator;

class EmailFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_to_string()
    {
        $field = new EmailFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame('test@email.com', $field->cast('test@email.com'));
        $this->assertSame('test@email.com', $field->restore('test@email.com'));
    }

    public function test_it_casts_non_emails_to_null()
    {
        $field = new EmailFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertNull($field->cast('test'));
    }

    public function test_it_stores_as_string()
    {
        $field = new EmailFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame('test@email.com', $field->modify('test@email.com'));
    }

    public function test_it_returns_email_decorator()
    {
        $field = new EmailFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(EmailDecorator::class, $field->decorate('test@email.com'));
    }

    public function test_it_returns_email_schema()
    {
        $field = new EmailFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(EmailSchema::class, $field->schema());
    }

    public function test_it_can_generate_emails()
    {
        $field = new EmailFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertNotFalse(filter_var($field->generate(), FILTER_VALIDATE_EMAIL));
    }
}
