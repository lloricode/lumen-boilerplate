<?php

declare(strict_types=1);

namespace App;

use DB;
use PDO;

class Helper
{
    public static function isLatestMysqlVersion(): bool
    {
        $pdo = DB::connection()->getPdo();
        return ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'mysql') &&
            version_compare($pdo->getAttribute(PDO::ATTR_SERVER_VERSION), '5.7.8', 'ge');
    }
}
