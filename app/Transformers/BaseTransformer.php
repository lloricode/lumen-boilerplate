<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 11/25/18
 * Time: 12:50 AM
 */

namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use InvalidArgumentException;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract
{
    abstract public function getResourceKey(): string;

    protected static function forId(Model $model): string
    {
        return (string) $model->{$model->getRouteKeyName()};
    }

    protected static function filterData(array $response, array $data, array $roleNames = null): array
    {
        if (app('auth')->check() && app('auth')->user()->hasAnyRole(
            is_null($roleNames) ? config('setting.permission.role_names.system') : $roleNames
        )) {
            return array_merge($response, $data);
        }

        return $response;
    }

    protected static function addTimesHumanReadable(
        Model $entity,
        array $responseData,
        array $columns = [],
        $isIncludeDefault = true
    ): array {
        $auth = app('auth');

        if ( ! $auth->check()) {
            return $responseData;
        }

        if ( ! $auth->user()->hasAnyRole(config('setting.permission.role_names'))) {
            return $responseData;
        }

        $isHasCustom = count($columns) > 0;

        $defaults = ['created_at', 'updated_at', 'deleted_at'];

        // only custom
        if ($isHasCustom && ! $isIncludeDefault) {
            $toBeConvert = $columns;
        }  // custom and defaults
        elseif ($isHasCustom && $isIncludeDefault) {
            $toBeConvert = array_merge($columns, $defaults);
        } // only defaults
        else {
            $toBeConvert = $defaults;
        }

        $return = [];
        foreach ($toBeConvert as $column) {
            $return = array_merge(
                $return,
                ( ! is_null($entity->{$column})) ? array_merge($return, self::readableTimestamp($column, $entity)) : []
            );
        }

        return array_merge($responseData, $return);
    }

    protected static function readableTimestamp(string $column, $entity): array
    {
        if ($entity instanceof Model) {
            // sometime column is not carbonated, i mean instance if Carbon/Carbon
            $at = Date::parse($entity->{$column});
        } elseif ($entity instanceof Carbon) {
            $at = $entity;
        } elseif (is_string($entity)) {
            $at = Date::parse($entity);
        } else {
            throw new InvalidArgumentException(
                'Invalid $entity argument'
            );
        }

        $tz = $at->timezone(
            app('auth')->guard('api')->user()->timezone
            ?? config('app.timezone')
        );

        return [
            $column => $tz->format(config('setting.formats.datetime_12')),
            $column.'_readable' => $tz->diffForHumans(),
        ];
    }

    protected function collection($data, $transformer, ?string $resourceKey = null): Collection
    {
        return parent::collection($data, $transformer, $resourceKey ?: $transformer->getResourceKey());
    }
}
