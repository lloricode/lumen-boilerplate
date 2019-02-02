<?php

$api->get('/localizations', [
    'uses' => 'LocalizationController@index',
]);