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

    'accepted' => ':attribute mora biti prihvaćeno.',
    'active_url' => ':attribute nije validan URL.',
    'after' => ':attribute mora biti posle :date.',
    'after_or_equal' => ':attribute mora biti datum jednak ili posle :date.',
    'alpha' => ':attribute mogu da sadrže samo slova.',
    'alpha_dash' => ':attribute mogu da sadrže samo slova, brojeve, i crtice.',
    'alpha_num' => ':attribute mogu da sadrže samo slova i brojeve.',
    'array' => ':attribute mora biti niz.',
    'before' => ':attribute mora biti datum pre :date.',
    'before_or_equal' => ':attribute mora biti datum pre ili jednak :date.',
    'between' => [
        'numeric' => ':attribute mora biti između :min i :max.',
        'file' => ':attribute mora biti između :min i :max kilobajta.',
        'string' => ':attribute mora biti između :min i :max karaterak.',
        'array' => ':attribute mora biti između :min i :max članova.',
    ],
    'boolean' => ':attribute polje mora biti true ili false.',
    'confirmed' => ':attribute potvrda se ne podudara.',
    'date' => ':attribute nije validan datum.',
    'date_format' => ':attribute ne podudara se format :format.',
    'different' => ':attribute i :other mora biti različito.',
    'digits' => ':attribute mora biti :digits cifra.',
    'digits_between' => ':attribute mora između :min i :max cifara.',
    'dimensions' => ':attribute ima nevažeće dimenzije slike.',
    'distinct' => ':attribute polje ima duplu vrednost.',
    'email' => ':attribute mora biti validna i-mejl adresa.',
    'exists' => 'Izabrani :attribute nije validan.',
    'file' => ':attribute mora biti fajl.',
    'filled' => ':attribute polje je obavezno.',
    'image' => ':attribute mora biti slika.',
    'in' => 'Izabrani :attribute nije validan.',
    'in_array' => ':attribute polje nepostoji u :other.',
    'integer' => ':attribute mora biti intidđer.',
    'ip' => ':attribute mora biti validna i-mejl adresa.',
    'json' => ':attribute mora biti validan JSON string.',
    'max' => [
        'numeric' => ':attribute ne može biti veći od :max.',
        'file' => ':attribute ne može biti veći od :max kilobajta.',
        'string' => ':attribute ne može biti veći od :max karaktera.',
        'array' => ':attribute ne mođe imati više od :max članova.',
    ],
    'mimes' => ':attribute mora biti fajl ekstenyije: :values.',
    'mimetypes' => ':attribute mora biti fajl ekstenyije: :values.',
    'min' => [
        'numeric' => ':attribute mora biti manji od :min.',
        'file' => ':attribute mora biti manji od :min kilobajta.',
        'string' => ':attribute mora biti manji od :min karaktera.',
        'array' => ':attribute must have manji od :min članova.',
    ],
    'not_in' => 'Selektovani :attribute nije validan.',
    'numeric' => ':attribute mora biti broj.',
    'present' => ':attribute polje mora biti prisutno.',
    'regex' => ':attribute format nije validan.',
    'required' => ':attribute polje je obavezno.',
    'required_if' => ':attribute polje je obavezno kada :other je :value.',
    'required_unless' => ':attribute polje je obavezno osim ako :other je u :values.',
    'required_with' => ':attribute polje je obavezno kada je :values prisutno.',
    'required_with_all' => ':attribute polje je obavezno kada je :values prisutno.',
    'required_without' => ':attribute polje je obavezno kada :values nije prisutno.',
    'required_without_all' => ':attribute polje je obavezno kada niko od :values nije prisutan.',
    'same' => ':attribute i :other mora da odgovara.',
    'size' => [
        'numeric' => ':attribute mora biti :size.',
        'file' => ':attribute mora biti :size kilobajta.',
        'string' => ':attribute mora biti :size karaktera.',
        'array' => ':attribute mora sadržati :size članova.',
    ],
    'string' => ':attribute mora biti string.',
    'timezone' => ':attribute mora biti validna zona.',
    'unique' => ':attribute je već zauzet.',
    'uploaded' => ':attribute nije uspelo otpremanje.',
    'url' => ':attribute format nije validan.',

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
