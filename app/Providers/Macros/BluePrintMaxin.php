<?php

namespace App\Providers\Macros;

use App\Helper;
use Illuminate\Database\Schema\Blueprint;

class BluePrintMaxin
{

    public function jsonable()
    {
        return function ($column) {
            $type = Helper::isLatestMysqlVersion() ? 'json' : 'longText';
            return $this->$type($column);
        };
    }

    public function foreignConstraint()
    {
        return function (
            $column,
            string $foreignTableName,
            string $onDelete = null,
            string $name = null
        ) {
            return $this->foreignConstraintInteger(false, $this, $column, $foreignTableName, $onDelete, $name);
        };
    }

    public function foreignConstraintInteger()
    {
        return function (
            bool $isRelationBigInteger,
            Blueprint $blueprint,
            $column,
            string $foreignTableName,
            string $onDelete = null,
            string $name = null
        ) {
            $tbl = $blueprint
                ->{($isRelationBigInteger ? 'bigInteger' : 'integer')}(
                    $column
                )
                ->unsigned();

            if (is_null($onDelete)) {
                $blueprint->foreign($column, $name)
                    ->references('id')
                    ->on($foreignTableName);
            } else {
                $blueprint->foreign($column)
                    ->references('id')
                    ->on($foreignTableName)
                    ->onDelete($onDelete);
            }
            return $tbl;
        };
    }

    public function foreignConstraintBigInteger()
    {
        return function (
            $column,
            string $foreignTableName,
            string $onDelete = null,
            string $name = null
        ) {
            return $this->foreignConstraintInteger(true, $this, $column, $foreignTableName, $onDelete, $name);
        };
    }

}