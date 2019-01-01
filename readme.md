![](https://user-images.githubusercontent.com/8251344/50554123-d6161800-0cef-11e9-9341-c9ccfe8d9599.png)

[![Build Status](https://travis-ci.org/lloricode/lumen-dingo-boilerplate.svg?branch=master)](https://travis-ci.org/lloricode/lumen-dingo-boilerplate)

API template made from [Lumen 5.7](https://lumen.laravel.com/) and exntended by [dingo/api](https://github.com/dingo/api).

### Installing
- after cloning/downloding this repo, first open to terminal then change directory to a project directory.
- sample, in linux, `cd lumen-dingo-boilerplate`.
- run `composer install` to install project dependencies.
- copy `.env.example` to `.env`. (dont just rename it), for team reference purpose.
- prepare you environment in `.env`
- lumen has no `php artisan key:generate`, so you can [google](https://google.com/search?q=how+to+add+APP_KEY+in+lumen) it to add value first.
- run `composer fresh`, this will migrate and seed fake data to your database, and install laravel passport. see composer.json `scripts` index.
- ![](https://user-images.githubusercontent.com/8251344/50570069-01fbd100-0db6-11e9-9080-a65bfee70f1d.png)


### Login using OAuth2 by [laravel/passport](https://github.com/laravel/passport)
- run `php artisan passport:install`
- ![](https://user-images.githubusercontent.com/8251344/50570034-fcea5200-0db4-11e9-8237-b3ae20c06a25.png)
- in `Password grant` result, use the `Client ID` and `Client Secret` in submitting request body in `client_id` and `client_secret`
.- ![](https://user-images.githubusercontent.com/8251344/50570031-d6c4b200-0db4-11e9-8cd0-bd3cb7d3de2a.png)
- then dont forget to add `headers`'s `Accept` with value `application/x.lumen.dingo.boilerplate.v1+json`. (depend on you setup environtment) when `api strict` mode is `enabled`.
- ![](https://user-images.githubusercontent.com/8251344/50570058-cfea6f00-0db5-11e9-96bb-94143f449145.png)



### Available Endpoints
- run `npm install apidoc -g`
- to generate documentation run `php artisan apidocs`, then visit `http://lumen-dingo-boilerplate.test/docs` to your browser. 
- ![screenshot from 2018-12-31 11-09-41](https://user-images.githubusercontent.com/8251344/50553955-a9accc80-0cec-11e9-8fbf-f41cc1e10286.png)
![screenshot from 2018-12-31 11-09-56](https://user-images.githubusercontent.com/8251344/50553957-ab769000-0cec-11e9-8b81-e8359f4ef5b1.png)

## Running the tests
- ![](https://user-images.githubusercontent.com/8251344/50570082-4ab38a00-0db6-11e9-83c0-c379c09d14d8.png)
- you can view integration [here](https://travis-ci.org/lloricode/lumen-dingo-boilerplate)
- go to project directory.
- run `vendor/bin/phpunit`, if you running this via [homestead](https://laravel.com/docs/5.7/homestead), you can run this through `ssh` via `phpunit` in current project directory.
- run `composer coverage` to see code coverage via `html`.
- run `composer coverage-txt` to see code coverage via `terminal`.


## Built With
* [laravel/lumen-framework:5.7.*](https://github.com/laravel/lumen-framework) - The stunningly fast micro-framework by Laravel.
* [dingo/api](https://github.com/dingo/api) - A RESTful API package for the Laravel and Lumen frameworks.
* [laravel/passport](https://github.com/laravel/passport) - OAuth2 server and API authentication, fix installed by [dusterio/lumen-passport](https://github.com/dusterio/lumen-passport).
* [andersao/l5-repository](https://github.com/andersao/l5-repository) - Repositories to abstract the database layer.
* [spatie/laravel-permission](https://github.com/spatie/laravel-permission) - Associate users with roles and permissions.
* [apidoc/apidoc](https://github.com/apidoc/apidoc) - RESTful web API Documentation Generator.


See also the list of [contributors](https://github.com/lloricode/lumen-dingo-boilerplate/graphs/contributors) who participated in this project.

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).
