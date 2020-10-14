<?php

use Streams\Core\Message\MessageManager;

/**
 * @todo complete tests for pull, merge, flush, and the type getters
 *
 * Class MessageManagerTest
 */
class MessageManagerTest extends StreamsTestCase
{
    public function testThatYouCanAddAMessage()
    {
        /** @var MessageManager $messageManager */
        $messageManager = app(MessageManager::class);

        $content = [
            'type' => 'error',
            'content' => 'testing',
        ];

        $md5Hashed = md5(json_encode($content));

        $messageManager->add('error', 'testing');

        // we use reflection because testing the getter is in another class
        $session = $this->reflectObjectProperty($messageManager, 'session');

        $this->assertEquals([$md5Hashed => $content], $session->get('messages'));
    }

    public function testThatYouCanRetrieveAllMessages()
    {
        /** @var MessageManager $messageManager */
        $messageManager = app(MessageManager::class);

        $contents = [
            ['type' => 'error', 'content' => 'testing'],
            ['type' => 'info', 'content' => 'testing']
        ];
        $hashedContents = array_combine(array_map(function($content) use ($contents) {
            return md5(json_encode($contents[$content]));
        }, array_keys($contents)), $contents);

        foreach ($contents as $content) {
            $messageManager->add($content['type'], $content['content']);
        }
        $this->assertEquals($hashedContents, $messageManager->get());
    }
}
