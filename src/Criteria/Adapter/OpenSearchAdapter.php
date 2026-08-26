<?php

namespace Streams\Core\Criteria\Adapter;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use OpenSearch\Client;
use OpenSearch\ClientBuilder;

class OpenSearchAdapter extends AbstractSearchIndexAdapter
{
    protected Client $client;

    protected function buildClient(): Client
    {
        if (! class_exists(ClientBuilder::class)) {
            throw new \RuntimeException(
                'The opensearch-project/opensearch-php package is required to use the OpenSearch adapter.'
            );
        }

        $connection = $this->stream->config(
            'source.connection',
            Config::get('streams.core.opensearch.default', 'default'),
        );

        $config = Config::get("streams.core.opensearch.connections.{$connection}", []);

        $builder = ClientBuilder::create()
            ->setHosts(Arr::get($config, 'hosts', ['https://localhost:9200']));

        $username = Arr::get($config, 'username');
        $password = Arr::get($config, 'password');

        if ($username && $password) {
            $builder->setBasicAuthentication($username, $password);
        }

        if (Arr::get($config, 'ssl_verification', true) === false) {
            $builder->setSSLVerification(false);
        }

        $this->client = $builder->build();

        return $this->client;
    }

    protected function performSearch(string $index, array $body): array
    {
        return $this->client->search([
            'index' => $index,
            'body' => $body,
        ]);
    }

    protected function performCount(string $index, array $query): int
    {
        $response = $this->client->count([
            'index' => $index,
            'body' => ['query' => $query],
        ]);

        return (int) ($response['count'] ?? 0);
    }

    protected function performIndex(string $index, ?string $id, array $document): string
    {
        $params = [
            'index' => $index,
            'body' => $document,
        ];

        if ($id) {
            $params['id'] = $id;
        }

        $response = $this->client->index($params);

        return (string) ($response['_id'] ?? $id);
    }

    protected function performDeleteByQuery(string $index, array $query): bool
    {
        $response = $this->client->deleteByQuery([
            'index' => $index,
            'body' => ['query' => $query],
        ]);

        return empty($response['failures'] ?? []);
    }
}
