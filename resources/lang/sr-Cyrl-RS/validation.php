<?php

declare(strict_types=1);

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

    'accepted' => ':attribute мора бити прихваћено.',
    'active_url' => ':attribute није валидан УРЛ.',
    'after' => ':attribute мора бити после :date.',
    'after_or_equal' => ':attribute мора бити датум једнак или после :date.',
    'alpha' => ':attribute могу да садрже само слова.',
    'alpha_dash' => ':attribute могу да садрже само слова, бројеве, и цртице.',
    'alpha_num' => ':attribute могу да садрже само слова и бројеве.',
    'array' => ':attribute мора бити низ.',
    'before' => ':attribute мора бити датум пре :date.',
    'before_or_equal' => ':attribute мора бити датум пре или једнак :date.',
    'between' => [
        'numeric' => ':attribute мора бити између :min и :max.',
        'file' => ':attribute мора бити између :min и :max килобајта.',
        'string' => ':attribute мора бити између :min и :max karaterak.',
        'array' => ':attribute мора бити између :min и :max чланова.',
    ],
    'boolean' => ':attribute поље мора бити true или false.',
    'confirmed' => ':attribute потврда се не подудара.',
    'date' => ':attribute није валидан датум.',
    'date_format' => ':attribute не подудара се формат :format.',
    'different' => ':attribute и :other мора бити различито.',
    'digits' => ':attribute мора бити :digits цифара.',
    'digits_between' => ':attribute мора између :min и :max цифара.',
    'dimensions' => ':attribute има неважеће димензије слике.',
    'distinct' => ':attribute поље има дуплу вредност.',
    'email' => ':attribute мора бити валиднау-мејл адреса.',
    'exists' => 'Изабрани :attribute није валидан.',
    'file' => ':attribute мора бити фајл.',
    'filled' => ':attribute поље је обавезно.',
    'image' => ':attribute мора бити слика.',
    'in' => 'Изабрани :attribute није валидан.',
    'in_array' => ':attribute поље непостоји у :other.',
    'integer' => ':attribute мора бити интиджер.',
    'ip' => ':attribute мора бити валидна и-мејл адреса.',
    'json' => ':attribute мора бити валидан ЈСОН стринг.',
    'max' => [
        'numeric' => ':attribute не може бити већи од :max.',
        'file' => ':attribute не може бити већи од :max килобајта.',
        'string' => ':attribute не може бити већи од :max карактера.',
        'array' => ':attribute не може имати више од :max чланова.',
    ],
    'mimes' => ':attribute мора бити фајл екстензије: :values.',
    'mimetypes' => ':attribute мора бити фајл екстензије: :values.',
    'min' => [
        'numeric' => ':attribute мора бити мањи од :min.',
        'file' => ':attribute мора бити мањи од :min килобајта.',
        'string' => ':attribute мора бити мањи од :min карактера.',
        'array' => ':attribute мора бити мањи од :min чланова.',
    ],
    'not_in' => 'Селектовани :attribute није валидан.',
    'numeric' => ':attribute мора бити broj.',
    'present' => ':attribute поље мора бити присутно.',
    'regex' => ':attribute формат није валидан.',
    'required' => ':attribute поље је обавезно.',
    'required_if' => ':attribute поље је обавезно када :other је :value.',
    'required_unless' => ':attribute поље је обавезно осим ако :other је у :values.',
    'required_with' => ':attribute поље је обавезно када је :values присутно.',
    'required_with_all' => ':attribute поље је обавезно када је :values присутно.',
    'required_without' => ':attribute поље је обавезно када :values није присутно.',
    'required_without_all' => ':attribute поље је обавезно када нико од :values није присутан.',
    'same' => ':attribute и :other мора да одговара.',
    'size' => [
        'numeric' => ':attribute мора бити :size.',
        'file' => ':attribute мора бити :size килобајта.',
        'string' => ':attribute мора бити :size карактера.',
        'array' => ':attribute мора садржати :size чланова.',
    ],
    'string' => ':attribute мора бити стринг.',
    'timezone' => ':attribute мора бити валидна зона.',
    'unique' => ':attribute је већ заузет.',
    'uploaded' => ':attribute није успело отпремање.',
    'url' => ':attribute формат није валидан.',

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
            'rule-name' => 'custom-message',
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
