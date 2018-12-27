<?php

namespace App\Http\Controllers;

use App\Traits\Hashable;
use Dingo\Api\Routing\Helpers;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use Hashable;
    use Helpers;
}
