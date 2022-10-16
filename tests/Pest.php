<?php

declare(strict_types=1);

use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Test\TestCase;

uses(TestCase::class)
    ->in(__DIR__);

//function login()
//{
//    test()->actingAs(UserFactory::new()->create());
//}

## for lumen IDE helper

function call(
    $method,
    $uri,
    $parameters = [],
    $cookies = [],
    $files = [],
    $server = [],
    $content = null
): Response|TestResponse {
    return test()->call(...func_get_args());
}

function get($uri, array $headers = []): TestCase
{
    return test()->get(...func_get_args());
}

function post($uri, array $data = [], array $headers = []): TestCase
{
    return test()->post(...func_get_args());
}

function put($uri, array $data = [], array $headers = []): TestCase
{
    return test()->put(...func_get_args());
}

function delete($uri, array $data = [], array $headers = []): TestCase
{
    return test()->delete(...func_get_args());
}

function seeJson(array $data = null, $negate = false): TestCase
{
    return test()->seeJson(...func_get_args());
}

function assertResponseStatus($status): void
{
    test()->assertResponseStatus(...func_get_args());
}

function assertResponseOk(): void
{
    test()->assertResponseOk();
}

function seeInDatabase($table, array $data, $onConnection = null): TestCase
{
    return test()->seeInDatabase(...func_get_args());
}

function notSeeInDatabase($table, array $data, $onConnection = null): TestCase
{
    return test()->notSeeInDatabase(...func_get_args());
}

//function getResponse(): \Illuminate\Testing\TestResponse
//{
//    return test()->response;
//}
