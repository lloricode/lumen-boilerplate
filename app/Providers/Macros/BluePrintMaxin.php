<?php

declare(strict_types=1);

namespace App\Providers\Macros;

use App\Helper;

class BluePrintMaxin
{
    public function jsonable()
    {
        return function ($column) {
            $type = Helper::isLatestMysqlVersion() ? 'json' : 'longText';
            return $this->$type($column);
        };
    }
}
