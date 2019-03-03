<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    "accepted"             => ":attribute kabul edilmek zorundadır.",
    "active_url"           => ":attribute web sitesi geçerli değildir.",
    "after"                => ":attribute  :date tarihinden sonra olmalıdır.",
    "alpha"                => ":attribute yalnızca harfler içerebilir.",
    "alpha_dash"           => ":attribute sadece harf, sayı veya tire olabilir.",
    //
    "alpha_num"            => ":attribute sadece harf ve rakam içerebilir.",
    "array"                => ":attribute bir dizi olmalı.",
    "before"               => ":attribute daha önce bir tarih olmalı.",
    "between"              => [
        "numeric" => ":attribute arasında olmalı :min and :max.",
        "file"    => ":attribute arasında olmalı :min and :max kilobytes.",
        "string"  => ":attribute arasında olmalı :min and :max characters.",
        "array"   => ":attribute arasında olmalı :min and :max items.",
    ],
    "boolean"              => ":attribute alan doğru veya yanlış olmalı",
    "confirmed"            => ":attribute onay uyuşmuyor.",
    "date"                 => ":attribute geçerli bir tarih değil.",
    "date_format"          => ":attribute biçimiyle eşleşmiyor :format.",
    "different"            => ":attribute and :diğeri farklı olmalı.",
    "digits"               => ":attribute must be :basamak basamak.",
    "digits_between"       => ":attribute arasında olmalı:min ve :maksimum rakam",
    "email"                => " Geçerli bir :attribute adresi giriniz.",
    "filled"               => ":attribute alan gereklidir.",
    "exists"               => "Seçili :attribute geçersizdir.",
    "image"                => ":attributebir resim olmalı.",
    "in"                   => "Seçili :attribute geçersizdir.",
    "integer"              => ":attribute tam sayı olmak zorunda.",
    "ip"                   => ":attribute geçerli bir IP adresi olmalı.",
    "max"                  => [
        "numeric" => "The :attribute daha büyük olamaz :max.",
        "file"    => "The :attribute daha büyük olmayabilir than :max kilobytes.",
        "string"  => "The :attribute daha büyük olamaz :max characters.",
        "array"   => "The :attribute daha fazla olmayabilir :max items.",
    ],
    "mimes"                => "The :attribute must be a file of type: :values.",
    "min"                  => [
        "numeric" => "The :attribute must be at least :min.",
        "file"    => "The :attribute must be at least :min kilobytes.",
        "string"  => ":attribute en az :min karakter olmalıdır.",
        "array"   => "The :attribute must have at least :min items.",
    ],
    "not_in"               => "The selected :attribute is invalid.",
    "numeric"              => "The :attribute must be a number.",
    "regex"                => ":attribute formatı geçersiz",
    "required"             => ":attribute zorunlu alan",
    "required_if"          => "The :attribute alan ne zaman gereklidir :other is :value.",
    "required_unless"      => "The :attribute alan zorunlu değilse :other is in :values.",
    "required_with"        => "The :attribute alan ne zaman gereklidir:values is present.",
    "required_with_all"    => "The :attribute alan ne zaman gereklidir :values is present.",
    "required_without"     => "The :attribute alan ne zaman gereklidir :values is not present.",
    "required_without_all" => "The :attribute alan ne zaman gereklidir:values are present.",
    "same"                 => "The :attribute and :Diğerleri eşleşmeli.",
    "size"                 => [
        "numeric" => "The :attribute must be :size.",
        "file"    => "The :attribute must be :size kilobytes.",
        "string"  => "The :attribute must be :size characters.",
        "array"   => "The :attribute must contain :size items.",
    ],
    "invalid"              => "The :attribute is invalid.",
    "unique"               => "Bu :attribute zaten alınmış.",
    "unique_trash"         => "The :attribute may already be taken by a trashed entry.",
    "url"                  => "The :attribute biçim geçersiz.",
    "valid_password"       => "The :attribute geçerli bir şifre olmalı",
    "timezone"             => "The :attribute geçerli bir bölge olmalı",
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'özel mesaj',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
