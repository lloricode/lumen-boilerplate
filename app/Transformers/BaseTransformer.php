<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 11/25/18
 * Time: 12:50 AM
 */

namespace App\Transformers;

use Illuminate\Support\Carbon;
use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract
{
    /**
     * @param array $response
     * @param array $data
     * @param array $roleNames
     *
     * @return array
     */
    public function filterData(array $response, array $data, array $roleNames = null): array
    {
        if (app('auth')->user()->hasAnyRole(
            is_null($roleNames) ? config('setting.role_names.system') : $roleNames
        )) {
            return array_merge($response, $data);
        }

        return $response;
    }

    /**
     * prepare human readable time with users timezone
     *
     * @param       $entity
     * @param       $responseData
     * @param array $columns
     * @param bool  $isIncludeDefault
     *
     * @return array
     */
    public function addTimesHumanReadable($entity, $responseData, array $columns = [], $isIncludeDefault = true): array
    {
        $auth = app('auth');

        if (!$auth->check()) {
            return $responseData;
        }

        if (!$auth->user()->hasAnyRole(config('setting.role_names'))) {
            return $responseData;
        }

        $timeZone = $auth->user()->timezone ?? config('app.timezone');

        $readable = function ($column) use ($entity, $timeZone) {

            // sometime column is not carbonated, i mean instance if Carbon/Carbon
            $at = Carbon::parse($entity->{$column});

            return [
                $column => $at->format(config('setting.formats.datetime_12')),
                $column . '_readable' => $at->diffForHumans(),
                $column . '_tz' => $at->timezone($timeZone)->format(config('setting.formats.datetime_12')),
                $column . '_readable_tz' => $at->timezone($timeZone)->diffForHumans(),
            ];
        };

        $isHasCustom = count($columns) > 0;

        $defaults = ['created_at', 'updated_at', 'deleted_at'];

        // only custom
        if ($isHasCustom && !$isIncludeDefault) {
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
            $return = array_merge($return,
                (!is_null($entity->{$column})) ? array_merge($return, $readable($column)) : []);
        }

        return array_merge($responseData, $return);
    }
}