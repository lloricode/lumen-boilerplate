# Lumen Boilerplate

![Run Tests](https://github.com/lloricode/lumen-boilerplate/workflows/Run%20Tests/badge.svg?branch=master)
[![Chat](https://img.shields.io/badge/chat-on%20discord-7289da.svg)](https://discordapp.com/invite/9X3Y5pC)

RESTful API template made from [Lumen 8](https://lumen.laravel.com/)

| Previous Lumen Version | 
| ----- | 
|[7](https://github.com/lloricode/lumen-boilerplate/tree/framework-7)|
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
php artisan migrate:fresh --seed
```

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

![](https://user-images.githubusercontent.com/8251344/92990536-e09e3280-f50f-11ea-9565-00277319abcc.png)

## API Documentation (Swagger)

You can visit the generated API documentation in http://lumen-boilerplate.test/documentation in your local machine. (working in progress)

![Screenshot from 2020-09-13 00-36-59](https://user-images.githubusercontent.com/8251344/93000197-44991900-f559-11ea-8c0d-6e076d4ceb41.png)

or here's the published postman [here](https://documenter.getpostman.com/view/4366674/SWEDzudy)

## PHPUnit

![](https://user-images.githubusercontent.com/8251344/82751581-c6b6d380-9dea-11ea-89ba-eaee58242757.png)

In your project directory run this command:

```bash
vendor/bin/phpunit
```

**Notes:** 
- If you run this via [Homestead's](https://laravel.com/docs/homestead) ssh, you can this command: `phpunit` (in your project directory).
- After running testing, you can check generated code coverage from `.build` folder.


## Built With

* [laravel/lumen-framework](https://github.com/laravel/lumen-framework) - The stunningly fast micro-framework by Laravel.
* [GrahamCampbell/Laravel-Throttle](https://github.com/GrahamCampbell/Laravel-Throttle) - A rate limiter for Laravel.
* [spatie/laravel-fractal](https://github.com/spatie/laravel-fractal) - An easy to use Fractal wrapper built for Laravel and Lumen applications.
* [fruitcake/laravel-cors](https://github.com/fruitcake/laravel-cors) - Adds CORS (Cross-Origin Resource Sharing) headers support in your Laravel application.
* [thephpleague/fractal](https://github.com/thephpleague/fractal) - Output complex, flexible, AJAX/RESTful data structures, extended by [spatie/laravel-fractal](https://github.com/spatie/laravel-fractal)
* [laravel/passport](https://github.com/laravel/passport) - OAuth2 server and API authentication, fix installed by [dusterio/lumen-passport](https://github.com/dusterio/lumen-passport).
* [andersao/l5-repository](https://github.com/andersao/l5-repository) - Repositories to abstract the database layer.
* [spatie/laravel-permission](https://github.com/spatie/laravel-permission) - Associate users with roles and permissions.
* [DarkaOnLine/SwaggerLume](https://github.com/DarkaOnLine/SwaggerLume) - Lumen swagger.
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
- [x] Throttle for lumen
- [ ] Url versioning
- [ ] Finishing swagger

## Support Us

[![Paypal](https://user-images.githubusercontent.com/8251344/82770823-839d4480-9e6c-11ea-9d35-921a32a04f8f.png)](https://www.paypal.com/donate?hosted_button_id=V8PYXUNG6QP44)
