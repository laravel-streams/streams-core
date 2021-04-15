<?php

namespace Streams\Core\Tests\Message;

use Tests\TestCase;
use Streams\Core\Support\Facades\Messages;

class MessageManagerTest extends TestCase
{

    public function testCanAddMessage()
    {
        Messages::add('success', 'Test success!');

        $this->assertEquals([
            '49f720506984ca5b5e97789d66d876e1' => [
                'content' => 'Test success!',
                'type' => 'success',
            ]
        ], Messages::get());

        Messages::add('error', 'Test error!');

        $this->assertEquals([
            '49f720506984ca5b5e97789d66d876e1' => [
                'content' => 'Test success!',
                'type' => 'success',
            ],
            '3bc509e2a92608b76573754dd314af7b' => [
                'content' => 'Test error!',
                'type' => 'error',
            ]
        ], Messages::get());
    }

    public function testCanPullMessages()
    {
        Messages::add('success', 'Test success!');

        $this->assertEquals([
            '49f720506984ca5b5e97789d66d876e1' => [
                'content' => 'Test success!',
                'type' => 'success',
            ]
        ], Messages::get());

        $pulled = Messages::pull();

        $this->assertEquals([
            '49f720506984ca5b5e97789d66d876e1' => [
                'content' => 'Test success!',
                'type' => 'success',
            ]
        ], $pulled);

        $this->assertEquals([], Messages::get());
    }

    public function testError()
    {
        Messages::error('Test error!');

        $this->assertEquals([
            '3bc509e2a92608b76573754dd314af7b' => [
                'content' => 'Test error!',
                'type' => 'error',
            ]
        ], Messages::get());
    }

    public function testInfo()
    {
        Messages::info('Test info!');

        $this->assertEquals([
            '62ca1ba26e5877a6bb92834ed4fff98a' => [
                'content' => 'Test info!',
                'type' => 'info',
            ]
        ], Messages::get());
    }

    public function testSuccess()
    {
        Messages::success('Test success!');

        $this->assertEquals([
            '49f720506984ca5b5e97789d66d876e1' => [
                'content' => 'Test success!',
                'type' => 'success',
            ]
        ], Messages::get());
    }

    public function testWarning()
    {
        Messages::warning('Test warning!');

        $this->assertEquals([
            '3c3a0bf4647e539fa4a79ba19f5128a1' => [
                'content' => 'Test warning!',
                'type' => 'warning',
            ]
        ], Messages::get());
    }

    public function testDanger()
    {
        Messages::danger('Test danger!');

        $this->assertEquals([
            '50e3350b0d9423826f09dfe180861d7e' => [
                'content' => 'Test danger!',
                'type' => 'danger',
            ]
        ], Messages::get());
    }

    public function testImportant()
    {
        Messages::important('Test important!');

        $this->assertEquals([
            '2d75e4dda3986ac14c74f8ac0f3fc42a' => [
                'content' => 'Test important!',
                'type' => 'important',
            ]
        ], Messages::get());
    }
    
    public function testCanFlushMessages()
    {
        Messages::add('success', 'Test success!');

        $this->assertEquals([
            '49f720506984ca5b5e97789d66d876e1' => [
                'content' => 'Test success!',
                'type' => 'success',
            ]
        ], Messages::get());

        Messages::flush();

        $this->assertEquals([], Messages::get());
    }
}
