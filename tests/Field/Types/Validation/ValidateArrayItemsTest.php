<?php

namespace Streams\Core\Tests\Field\Types\Validation;

use Streams\Core\Entry\Entry;
use Illuminate\Support\Collection;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\ArrayFieldType;
use Streams\Core\Field\Decorator\ArrayDecorator;

class ValidateArrayItemsTest extends CoreTestCase
{
    public function test_it_validates_array_items()
    {
        $stream = $this->stream([
            'items' => [
                ['type' => 'array'],
            ],
        ]);

        // $data = ['items' => [
        //     'Test',
        //     100,
        // ]];

        // $this->assertFalse($stream->validator($data)->passes());

        $data = ['items' => [
            ['Test', 100],
        ]];

        $this->assertTrue($stream->validator($data)->passes());
    }

//     public function test_it_validates_string_items()
//     {
//         $stream = $this->stream([
//             'items' => [
//                 ['type' => 'string'],
//             ],
//         ]);

//         $data = ['items' => [
//             'Test',
//             100,
//         ]];

//         $this->assertFalse($stream->validator($data)->passes());

// //         $data = ['items' => [
// //             'Test',
// //         ]];
// // dd($stream->validator($data)->passes());
// //         $this->assertTrue($stream->validator($data)->passes());
//     }

    protected function stream(array $config = [])
    {
        return Streams::build([
            'fields' => [
                [
                    'handle' => 'items',
                    'type' => 'array',
                    'config' => $config,
                ],
            ],
        ]);
    }
}
