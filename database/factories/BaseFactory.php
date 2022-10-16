<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

abstract class BaseFactory extends Factory
{
    public function modelName()
    {
        $resolver = fn (self $factory) => app()->getNamespace().
            'Models\\'.
            str_replace(class_basename($factory), '', str_replace(self::$namespace, '', static::class)).
            Str::replaceLast('Factory', '', class_basename($factory));

        return $this->model ?: $resolver($this);
    }
}
