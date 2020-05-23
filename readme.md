![Run Tests](https://github.com/lloricode/lumen-boilerplate/workflows/Run%20Tests/badge.svg?branch=master)

RESTful API template made from [Lumen 7](https://lumen.laravel.com/)

Join to our [discord](https://discord.gg/9X3Y5pC)

## Old version of Lumen

| Lumen | 
| ----- | 
|[6](https://github.com/lloricode/lumen-boilerplate/tree/framework-6)|
|[5.8](https://github.com/lloricode/lumen-boilerplate/tree/framework-5.8)|
|[5.7](https://github.com/lloricode/lumen-boilerplate/tree/framework-5.7)|

## Installation

### 1. Download
  Clone/Download this repository place on your server. *(I highly recommend you use either Laravel Homestead or Laravel Valet, to get the optimal server configuration and no errors through installation.)*

### 2. Environment Files
This boilerplate comes with a `.env.example` file in the root of the project.

Copy `env.example` to `.env` where you prepare your environment.

**Note:** Make sure you do not rename `.env.example`, for team purposes.

### 3. Composer
Lumen boilerplate dependencies are managed through the [PHP Composer tool](https://getcomposer.org/). Install the depencencies by navigating into your project in terminal and typing this command:
```bash
composer install
```

After that run :
```bash
composer fresh
```
This will migrate tables, seed fake data to your database, and install [laravel passport](https://github.com/laravel/passport).

See  `composer.json` > `scripts index`. 

![](https://user-images.githubusercontent.com/8251344/50570069-01fbd100-0db6-11e9-9080-a65bfee70f1d.png)


## Login using OAuth2 by [laravel/passport](https://github.com/laravel/passport)

### 1. Installation
Install laravel passport by navigating into your project in terminal and run this command:
```bash
php artisan passport:install
```
This will generate Client ID and Client Secret.

![](https://user-images.githubusercontent.com/8251344/50570034-fcea5200-0db4-11e9-8237-b3ae20c06a25.png)

### 2. Access Tokens
Use the `Client ID` and `Client Secret` of password grant for OAuth2 - Login (Password grant) endpoint.

![](https://user-images.githubusercontent.com/8251344/50570031-d6c4b200-0db4-11e9-8cd0-bd3cb7d3de2a.png)

Do not forget to add **Headers**  
  - Accept       = `application/x.lumen.boilerplate.v1+json` *(Depends on your API_SUBTYPE value in your environment if `api strict` mode is **enabled**)*.
  - Content-Type = `application/x-www-form-urlencoded`.

![](https://user-images.githubusercontent.com/8251344/50570058-cfea6f00-0db5-11e9-96bb-94143f449145.png)

## API Documentation

You should run this command in your project directory first:
```bash
npm install apidoc -g
```

To generate the API documentation run this command:
```bash
php artisan apidocs
```

You can visit the generated API documentation in http://lumen-boilerplate.test/docs.

![screenshot from 2018-12-31 11-09-41](https://user-images.githubusercontent.com/8251344/50553955-a9accc80-0cec-11e9-8fbf-f41cc1e10286.png)
![screenshot from 2018-12-31 11-09-56](https://user-images.githubusercontent.com/8251344/50553957-ab769000-0cec-11e9-8b81-e8359f4ef5b1.png)

or here's the published postman [here](https://documenter.getpostman.com/view/4366674/SWEDzudy)

## PHPUnit

![](https://user-images.githubusercontent.com/8251344/50570082-4ab38a00-0db6-11e9-83c0-c379c09d14d8.png)

In your project directory run this command:

First run this command to create `database.sqlite` in database folder. this make testing database faster

```base
composer db
```  

Then run phpunit

```bash
vendor/bin/phpunit
```

**Notes:** 
- If you running this via [Homestead's](https://laravel.com/docs/5.7/homestead) ssh, you can this command: `phpunit` (in your project directory).
- Run `composer coverage` to see code coverage via `html`.
- Run `composer coverage-txt` to see code coverage via `terminal`.


## Built With

* [laravel/lumen-framework](https://github.com/laravel/lumen-framework) - The stunningly fast micro-framework by Laravel.
* [spatie/laravel-fractal](https://github.com/spatie/laravel-fractal) - An easy to use Fractal wrapper built for Laravel and Lumen applications.
* [fruitcake/laravel-cors](https://github.com/fruitcake/laravel-cors) - Adds CORS (Cross-Origin Resource Sharing) headers support in your Laravel application.
* [thephpleague/fractal](https://github.com/thephpleague/fractal) - Output complex, flexible, AJAX/RESTful data structures, extended by [spatie/laravel-fractal](https://github.com/spatie/laravel-fractal)
* [laravel/passport](https://github.com/laravel/passport) - OAuth2 server and API authentication, fix installed by [dusterio/lumen-passport](https://github.com/dusterio/lumen-passport).
* [andersao/l5-repository](https://github.com/andersao/l5-repository) - Repositories to abstract the database layer.
* [spatie/laravel-permission](https://github.com/spatie/laravel-permission) - Associate users with roles and permissions.
* [vinkla/laravel-hashids](https://github.com/vinkla/laravel-hashids) - A Hashids bridge for Laravel.
* [apidoc/apidoc](https://github.com/apidoc/apidoc) - RESTful web API Documentation Generator.
* [rap2hpoutre/laravel-log-viewer](https://github.com/rap2hpoutre/laravel-log-viewer) - Laravel log viewer.
* [coderello/laravel-passport-social-grant](https://github.com/coderello/laravel-passport-social-grant) - API authentication via social networks for your Laravel application.
* [flipboxstudio/lumen-generator](https://github.com/flipboxstudio/lumen-generator) - Add Lumen missing generator.

See also the list of [contributors](https://github.com/lloricode/lumen-boilerplate/graphs/contributors) who participated in this project.

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).

## Todo

- [x] Replace dingo/api
- [x] Fix for PHP7.4
- [x] Log viewer
- [ ] Documentation private route with permission
- [x] Localization
- [ ] Code Generator
- [ ] Seeder for Test/Production separately
- [ ] Manage seeder for permissions
- [x] Include Postman collection/Config/Preset
- [ ] Wiki
- [ ] Firewall
- [x] Social login
- [ ] Back up
- [ ] Data transfer objects (DTO) https://github.com/spatie/data-transfer-object
- [ ] Throttle for lumen
- [ ] Url versioning

