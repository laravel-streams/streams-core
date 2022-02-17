<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Field\Value\EmailValue;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\EmailFieldType;

class EmailFieldTypeTest extends CoreTestCase
{

    public function test_it_casts_non_emails_to_null()
    {
        $field = new EmailFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertNull($field->cast('test'));
    }

    public function test_it_returns_email_values()
    {
        $field = new EmailFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(EmailValue::class, $field->expand('test@email.com'));
    }
}
