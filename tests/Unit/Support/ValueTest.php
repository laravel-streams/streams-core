<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Support\Value;
use Anomaly\UsersModule\User\UserModel;
use Illuminate\Contracts\Support\Arrayable;

class ValueTest extends TestCase
{
    public function testCanProcessString()
    {
        $this->assertEquals('Bar',  Value::make('entry.foo', ['foo' => 'Bar']));
    }

    public function testCanRenderView()
    {
        $this->assertEquals('Test Bar',  trim(Value::make([
            'view' => 'streams::test',
        ], ['foo' => 'Bar'])));
    }

    public function testCanRenderTemplate()
    {
        $this->assertEquals('Test Bar',  Value::make(
            [
                'template' => '<?php echo \'Test\'; ?> {{ $entry[\'foo\'] }}'
            ],
            ['foo' => 'Bar']
        ));
    }

    // public function testCanMapEntryRelation()
    // {
    //     $user = UserModel::first();

    //     $this->assertEquals(json_encode($user->created_by),  Value::make('created_by', $user));
    // }

    public function testCanMapEntryRelationsCollections()
    {
        $user = UserModel::first();

        $this->assertEquals(json_encode($user->roles),  Value::make('roles', $user));
    }

    public function testCanMapEntryFieldValues()
    {
        $user = UserModel::first();

        $this->assertEquals($user->email,  Value::make('email', $user));
    }

    public function testCanMapArrayValues()
    {
        $this->assertEquals('bar',  Value::make('entry.foo', new ArrayValueStub()));
    }

    public function testCanMapArrayValueToWrapper()
    {
        $this->assertEquals('Foo Bar',  Value::make([
            'wrapper' => '{value.foo} {value.bar}',
            'value' => [
                'foo' => 'entry.foo',
                'bar' => 'entry.bar',
            ]
        ], [
            'foo' => 'Foo',
            'bar' => 'Bar',
        ]));
    }

    public function testCanTranslateTranslationKeys()
    {
        $this->assertEquals('Users', Value::make('anomaly.module.users::addon.title', ['foo' => 'Bar']));
    }

    public function testCanRenderStringTemplate()
    {
        $this->assertEquals('Test Bar',  Value::make(
            [
                'value' => '<?php echo \'Test\'; ?> {{ $entry[\'foo\'] }}',
                'is_safe' => true,
            ],
            ['foo' => 'Bar']
        ));
    }
}

class ArrayValueStub implements Arrayable
{
    public function toArray()
    {
        return ['foo' => 'bar'];
    }
}
