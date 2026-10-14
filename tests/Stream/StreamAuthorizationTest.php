<?php

namespace Streams\Core\Tests\Stream;

use Streams\Core\Entry\Entry;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Stream\StreamPolicy;
use Streams\Core\Support\Facades\Streams;

class StreamAuthorizationTest extends CoreTestCase
{
    public function test_policies_are_isolated_between_streams_sharing_an_entry_class()
    {
        $this->be(new User);

        $contacts = Streams::register(['id' => 'contacts', 'policy' => ContactPolicy::class]);
        $private = Streams::register(['id' => 'private', 'policy' => PrivateContactPolicy::class]);
        $unconfigured = Streams::register(['id' => 'unconfigured']);

        $this->assertTrue(Gate::allows('review', new Entry(['stream' => $contacts])));
        $this->assertFalse(Gate::allows('review', new Entry(['stream' => $private])));
        $this->assertFalse(Gate::allows('review', new Entry(['stream' => $unconfigured])));
    }

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

        $this->assertInstanceOf(StreamPolicy::class, Gate::getPolicyFor(new ContactEntry([
            'stream' => Streams::make('contacts'),
        ])));

        $this->be(new User);
        $this->assertTrue(Gate::allows('review', new ContactEntry([
            'stream' => Streams::make('contacts'),
        ])));
    }

    public function test_stream_policies_preserve_guest_rules_and_denial_responses()
    {
        $stream = Streams::register(['id' => 'guest_contacts', 'policy' => GuestContactPolicy::class]);
        $entry = new Entry(['stream' => $stream]);

        $this->assertTrue(Gate::allows('view', $entry));
        $this->assertFalse(Gate::allows('update', $entry));

        $this->be(new User);
        $this->assertSame('Read only', Gate::inspect('update', $entry)->message());
        $this->assertFalse(Gate::allows('unknown', $entry));
    }

    public function test_stream_policies_preserve_before_callbacks_and_extra_arguments()
    {
        $this->be(new User);
        $stream = Streams::register(['id' => 'before_contacts', 'policy' => BeforeContactPolicy::class]);
        $entry = new Entry(['stream' => $stream]);

        $this->assertFalse(Gate::allows('review', [$entry, false]));
        $this->assertTrue(Gate::allows('review', [$entry, true]));
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

class PrivateContactPolicy
{
    public function review($user = null): bool
    {
        return false;
    }
}

class GuestContactPolicy
{
    public function view(?User $user, Entry $entry): bool
    {
        return true;
    }

    public function update(User $user, Entry $entry)
    {
        return \Illuminate\Auth\Access\Response::deny('Read only');
    }
}

class BeforeContactPolicy
{
    public function before(User $user, string $ability, Entry $entry, bool $allowed): ?bool
    {
        return $allowed ? true : null;
    }

    public function review(User $user, Entry $entry, bool $allowed): bool
    {
        return false;
    }
}
