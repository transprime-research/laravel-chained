<p align="center">
<img src="https://github.com/transprime-research/assets/blob/master/laravel-chained/twitter_header_photo_2.png">
</p>

<p align="center">
<a href="https://travis-ci.org/transprime-research/laravel-chained"> <img src="https://travis-ci.org/transprime-research/laravel-chained.svg?branch=master" alt="Build Status"/></a>
<a href="https://packagist.org/packages/transprime-research/laravel-chained"> <img src="https://poser.pugx.org/transprime-research/laravel-chained/v/stable" alt="Latest Stable Version"/></a>
<a href="https://packagist.org/packages/transprime-research/laravel-chained"> <img src="https://poser.pugx.org/transprime-research/laravel-chained/downloads" alt="Total Downloads"/></a>
<a href="https://packagist.org/packages/transprime-research/laravel-chained"> <img src="https://poser.pugx.org/transprime-research/laravel-chained/v/unstable" alt="Latest Unstable Version"/></a>
<a href="https://packagist.org/packages/transprime-research/laravel-chained"> <img src="https://poser.pugx.org/transprime-research/laravel-chained/d/monthly" alt="Latest Monthly Downloads"/></a>
  <a href="https://packagist.org/packages/transprime-research/laravel-chained"> <img src="https://poser.pugx.org/transprime-research/laravel-chained/license" alt="License"/></a>
</p>

## About Laravel-chained

Laravel chained help to chain method calls on any class.
> Do it Like a PRO :ok:

## Installation

- `composer require transprime-research/laravel-chained`

## Quick Usage
Say we have this class with a lot of static methods. Instead of:

```php

```

You use:

```php
chained('ChainedOnStr')
    ->on(Str::class)
    ->to('lower')
    ->to('snake')
    ->to('length')(); //14
```
Or Aliased method calls:

```php
chained('ChainedOnStr')
    ->on(Str::class)
    ->lower()
    ->snake()
    ->length()(); //14
```
## Other Usages

### tap() method

```php
chained('ChainedOnStr')
    ->on(Str::class)
    ->tap(function ($res) {
        var_dump($res);
    })
    ->to('lower')
    ->to('snake')
    ->to('length')
    ->up(); //Up is used instead of ()
```

## Coming Soon

### Chain on more classes

```php
use Transprime\Chained\Chained;

chained('ChainedOnStr')
    ->on(Str::class, function (Chained $chain) {

        return $chain->to('lower')->to('snake');

    })->on(Arr::class, function (Chained $chain) {

        return $chain->to('wrap')->to('add', 1, 'using_add');
    })();
    
//Or

chained('ChainedOnStr')
    ->on(Str::class) // next calls use `Str` class
    ->to('lower')->to('snake')
    ->on(Arr::class) // next calls use `Arr` class
    ->to('wrap')->to('add', 1, 'using_add')();
```

> Api implementation to be decided

## Additional Information

Be aware that this package is part of a series of "The Proof of Concept".

See other packages in this series here:

- A smart PHP if...elseif...else statement [https://github.com/omitobi/conditional]( https://github.com/omitobi/conditional)
- A functional PHP pipe in object-oriented way [https://github.com/transprime-research/piper](https://github.com/transprime-research/piper)
- Array now an object [https://github.com/transprime-research/arrayed](https://github.com/transprime-research/arrayed)
- A smart PHP try...catch statement [https://github.com/transprime-research/attempt](https://github.com/transprime-research/attempt)
- A smart Carbon + Collection package [https://github.com/omitobi/carbonate](https://github.com/omitobi/carbonate)
- Jsonable Http Request(er) package with Collections response [https://github.com/omitobi/laravel-habitue](https://github.com/omitobi/laravel-habitue)

## Contributions

For new features, checkout with prefix `feature/#issueid` e.g `feature/#100-add-auto-deploy`

- Clone this repository
- run `sh dockerizer.sh` or `bash dockerizer.sh`
- execute into the docker environment with `docker-compose exec conditional sh` (`sh` can be another bash)
- run tests with `vendor/bin/phpunit`
> The docker setup was made easy using [Laravel Dockerizer](https://github.com/transprime-research/laravel-dockerizer)

## Similar packages


## Licence

MIT (See LICENCE file)
