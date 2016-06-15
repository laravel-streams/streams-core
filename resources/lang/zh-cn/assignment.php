<?php

return [
    'field'        => [
        'name'         => '字段',
        'label'        => '字段',
        'instructions' => '请指定一个字段。'
    ],
    'label'        => [
        'name'         => '标签',
        'instructions' => '标签(Label) 只会使用在 表单(Form) 当中，如果没有填写，字段名称会自动被采用。'
    ],
    'required'     => [
        'name'         => '必填',
        'label'        => '这是个必填字段吗？',
        'instructions' => '如果是必填，这个字段就必须有变数值。'
    ],
    'unique'       => [
        'name'         => '唯一',
        'label'        => '这个字段的变数值是唯一的吗？',
        'instructions' => '如果是唯一，这个字段的变数值就不能是相同的。'
    ],
    'placeholder'  => [
        'name'         => '替代文字',
        'instructions' => '如果程序支持，替代文字(placeholders) 将会在 input 没有输入时显示。'
    ],
    'translatable' => [
        'name'         => '多语言',
        'label'        => '这个字段使用多语言吗？',
        'instructions' => '如果是，那么就将开启所有启用中的语言字段。'
    ],
    'instructions' => [
        'name'         => '说明',
        'instructions' => '字段说明将会出现在表单当中。'
    ],
    'warning'      => [
        'name'         => '警告',
        'instructions' => '警告将作为重要信息的提醒。'
    ]
];
