<?php

namespace Streams\Core\Criteria\Adapter;

use Elastic\Client\ClientBuilderInterface;
use Elastic\Elasticsearch\Client;
use Illuminate\Support\Facades\Config;

class ElasticsearchAdapter extends AbstractSearchIndexAdapter
{
    protected Client $client;

    protected function buildClient(): Client
    {
        if (! interface_exists(ClientBuilderInterface::class)) {
            throw new \RuntimeException(
                'The elastic/client package is required to use the Elasticsearch adapter.'
            );
        }

        if (! class_exists(Client::class)) {
            throw new \RuntimeException(
                'The elasticsearch/elasticsearch package is required to use the Elasticsearch adapter.'
            );
        }

        $builder = app(ClientBuilderInterface::class);

        $connection = $this->stream->config(
            'source.connection',
            Config::get('elastic.client.default', 'default'),
        );

        $this->client = $builder->connection($connection);

        return $this->client;
    }

    protected function performSearch(string $index, array $body): array
    {
        return $this->client->search([
            'index' => $index,
            'body' => $body,
        ])->asArray();
    }

    protected function performCount(string $index, array $query): int
    {
        $response = $this->client->count([
            'index' => $index,
            'body' => ['query' => $query],
        ])->asArray();

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

        $response = $this->client->index($params)->asArray();

        return (string) ($response['_id'] ?? $id);
    }

    protected function performDeleteByQuery(string $index, array $query): bool
    {
        $response = $this->client->deleteByQuery([
            'index' => $index,
            'body' => ['query' => $query],
        ])->asArray();

        return empty($response['failures'] ?? []);
    }
}
