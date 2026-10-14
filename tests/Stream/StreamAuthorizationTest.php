<?php

namespace Streams\Core\Tests\Stream;

use Streams\Core\Entry\Entry;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;

class StreamAuthorizationTest extends CoreTestCase
{
    public function test_it_registers_the_top_level_policy_for_the_entry_class()
    {
        $this->assertNull(Gate::getPolicyFor(ContactEntry::class));

        Streams::register([
            'id' => 'contacts',
            'policy' => ContactPolicy::class,
            'config' => [
                'abstract' => ContactEntry::class,
            ],
            'fields' => [
                'name' => 'string',
            ],
        ]);

        $this->assertInstanceOf(ContactPolicy::class, Gate::getPolicyFor(new ContactEntry([
            'stream' => Streams::make('contacts'),
        ])));
    }

    public function test_it_registers_gates_from_stream_config()
    {
        $this->be(new User);

        $this->assertFalse(Gate::has('contacts.review'));

        Streams::register([
            'id' => 'contacts',
            'config' => [
                'gates' => [
                    'contacts.review' => [ContactPolicy::class, 'review'],
                ],
            ],
            'fields' => [
                'name' => 'string',
            ],
        ]);

        $this->assertTrue(Gate::has('contacts.review'));
        $this->assertTrue(Gate::allows('contacts.review'));
    }

    public function test_it_registers_a_top_level_gates_map_when_config_gates_is_absent()
    {
        $this->be(new User);

        Streams::register([
            'id' => 'reviews',
            'gates' => [
                'reviews.publish' => function ($user = null) {
                    return true;
                },
            ],
            'fields' => [
                'name' => 'string',
            ],
        ]);

        $this->assertTrue(Gate::allows('reviews.publish'));
    }
}

class ContactEntry extends Entry {}

class ContactPolicy
{
    public function review($user = null): bool
    {
        return true;
    }
}
