<?php

namespace Streams\Core\Criteria\Adapter;

use Illuminate\Support\Arr;

class SelfAdapter extends FileAdapter
{

    protected $data = [];
    protected $query = [];


    protected function readData()
    {
        $default = 'streams/' . $this->stream->handle . '.json';

        $file = base_path(trim($this->stream->config('source.file', $default), '/\\'));

        $keyName = $this->stream->config('key_name', 'id');

        $this->data = Arr::get(json_decode(file_get_contents($file), true), 'data', []);

        array_walk($this->data, function ($item, $key) use ($keyName) {
            $this->data[$key] = [$keyName => $key] + $item;
        });
    }

    protected function writeData()
    {
        $source = $this->stream->config('source.file', 'streams/' . $this->stream->handle . '.json');

        $file = base_path(trim($source, '/\\'));

        $contents = json_decode(file_get_contents($file), true);

        $keyName = $this->stream->config('key_name', 'id');

        array_walk($this->data, function ($item, $key) use ($keyName) {

            Arr::pull($item, $keyName);

            $this->data[$key] = $item;
        });

        $contents['data'] = $this->data;

        file_put_contents($file, json_encode($contents, JSON_PRETTY_PRINT));

        return true;
    }
}
