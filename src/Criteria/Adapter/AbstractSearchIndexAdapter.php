<?php

namespace Streams\Core\Criteria\Adapter;

use Illuminate\Support\Arr;
use Streams\Core\Stream\Stream;

abstract class AbstractSearchIndexAdapter extends AbstractAdapter
{
    protected array $wheres = [];

    protected array $searches = [];

    protected array $orders = [];

    protected int $size = 10000;

    protected int $from = 0;

    public function __construct(Stream $stream)
    {
        $this->stream = $stream;
        $this->query = $this->buildClient();
    }

    abstract protected function buildClient(): mixed;

    abstract protected function performSearch(string $index, array $body): array;

    abstract protected function performCount(string $index, array $query): int;

    abstract protected function performIndex(string $index, ?string $id, array $document): string;

    abstract protected function performDeleteByQuery(string $index, array $query): bool;

    public function where($field, $operator = null, $value = null, $nested = null): static
    {
        if (is_null($value)) {
            $value = $operator;
            $operator = '=';
        }

        $this->wheres[] = compact('field', 'operator', 'value', 'nested');

        return $this;
    }

    public function search(string $query, ?array $fields = null): static
    {
        $this->searches[] = [
            'query' => $query,
            'fields' => $fields ?? $this->stream->config('source.search_fields', ['label']),
        ];

        return $this;
    }

    public function orderBy($field, $direction = 'asc'): static
    {
        $this->orders[] = [$field => ['order' => strtolower($direction)]];

        return $this;
    }

    public function limit($limit, $offset = 0): static
    {
        $this->size = (int) $limit;
        $this->from = (int) $offset;

        return $this;
    }

    public function get(array $parameters = []): array
    {
        $this->callParameterMethods($parameters);

        $response = $this->performSearch($this->index(), $this->buildBody());

        return $this->extractHits($response);
    }

    public function count(array $parameters = []): int
    {
        $this->callParameterMethods($parameters);

        $count = $this->performCount($this->index(), $this->buildQuery());

        $this->reset();

        return $count;
    }

    public function save(array $attributes): array
    {
        $keyName = $this->stream->config('key_name', 'id');

        $id = Arr::pull($attributes, $keyName);

        $documentId = $this->performIndex(
            $this->index(),
            $id ? (string) $id : null,
            $attributes,
        );

        $attributes[$keyName] = $documentId;

        return $attributes;
    }

    public function delete(array $parameters = []): bool
    {
        $this->callParameterMethods($parameters);

        return $this->performDeleteByQuery($this->index(), $this->buildQuery());
    }

    public function truncate(): void
    {
        $this->performDeleteByQuery($this->index(), ['match_all' => new \stdClass]);
    }

    protected function buildBody(): array
    {
        $body = [
            'query' => $this->buildQuery(),
            'size' => $this->size,
            'from' => $this->from,
        ];

        if (! empty($this->orders)) {
            $body['sort'] = $this->orders;
        }

        return $body;
    }

    protected function buildQuery(): array
    {
        if (empty($this->wheres) && empty($this->searches)) {
            return ['match_all' => new \stdClass];
        }

        $must = [];
        $should = [];

        foreach ($this->searches as $search) {
            $must[] = [
                'query_string' => [
                    'query' => $search['query'],
                    'fields' => $search['fields'],
                ],
            ];
        }

        foreach ($this->wheres as $where) {
            $clause = $this->buildClause($where['field'], $where['operator'], $where['value']);

            if (($where['nested'] ?? null) === 'or') {
                $should[] = $clause;
            } else {
                $must[] = $clause;
            }
        }

        $bool = [];

        if ($must) {
            $bool['must'] = $must;
        }

        if ($should) {
            $bool['should'] = $should;
        }

        return ['bool' => $bool];
    }

    protected function buildClause(string $field, string $operator, mixed $value): array
    {
        return match (strtoupper($operator)) {
            '=' => ['term' => [$field => $value]],
            '!=', '<>' => ['bool' => ['must_not' => [['term' => [$field => $value]]]]],
            'LIKE' => $this->buildLikeClause($field, $value),
            '>' => ['range' => [$field => ['gt' => $value]]],
            '>=' => ['range' => [$field => ['gte' => $value]]],
            '<' => ['range' => [$field => ['lt' => $value]]],
            '<=' => ['range' => [$field => ['lte' => $value]]],
            'IN' => ['terms' => [$field => array_values((array) $value)]],
            'NOT IN' => ['bool' => ['must_not' => [['terms' => [$field => array_values((array) $value)]]]]],
            default => ['match' => [$field => $value]],
        };
    }

    protected function buildLikeClause(string $field, string $value): array
    {
        if (strpos($value, '%') !== false) {
            return ['wildcard' => [$field => [
                'value' => str_replace('%', '*', $value),
                'case_insensitive' => true,
            ]]];
        }

        return ['match' => [$field => $value]];
    }

    protected function extractHits(array $response): array
    {
        $keyName = $this->stream->config('key_name', 'id');

        return array_map(function (array $hit) use ($keyName) {
            $source = $hit['_source'] ?? [];

            if (! isset($source[$keyName])) {
                $source[$keyName] = $hit['_id'];
            }

            return $source;
        }, $response['hits']['hits'] ?? []);
    }

    protected function index(): string
    {
        $name = $this->stream->config('source.index', $this->stream->id);

        if ($this->stream->config('source.scout_prefix', false)) {
            $name = config('scout.prefix', '').$name;
        }

        return $name;
    }

    protected function reset(): void
    {
        $this->wheres = [];
        $this->searches = [];
        $this->orders = [];
        $this->size = 10000;
        $this->from = 0;
    }
}
