<?php

namespace Streams\Core\Message;

use Illuminate\Session\Store;

class MessageManager
{
    public function __construct(protected Store $session)
    {
    }

    public function add(string $type, string|array $message): static
    {
        if (is_string($message)) {
            $message = [
                'content' => $message,
            ];
        }

        $message['type'] = $type;

        return $this->merge(md5(json_encode($message)), $message);
    }

    protected function merge(string $key, array $message): static
    {
        $messages = $this->session->get('messages', []);

        $messages = array_merge($messages, [$key => $message]);

        $this->session->flash('messages', $messages);

        return $this;
    }

    public function get(): array
    {
        return $this->session->get('messages', []);
    }

    public function pull(): array
    {
        return $this->session->pull('messages', []);
    }

    public function error(string|array $message): static
    {
        $this->add(__FUNCTION__, $message);

        return $this;
    }

    public function info(string|array $message): static
    {
        $this->add(__FUNCTION__, $message);

        return $this;
    }

    public function success(string|array $message): static
    {
        $this->add(__FUNCTION__, $message);

        return $this;
    }

    public function warning(string|array $message): static
    {
        $this->add(__FUNCTION__, $message);

        return $this;
    }

    public function danger(string|array $message): static
    {
        $this->add(__FUNCTION__, $message);

        return $this;
    }

    public function important(string|array $message): static
    {
        $this->add(__FUNCTION__, $message);

        return $this;
    }

    public function flush(): static
    {
        $this->session->forget('messages');

        return $this;
    }
}
