<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Backend\Auth\Permission;

use App\Http\Controllers\Controller;
use App\Models\Auth\Permission\Permission;
use App\Transformers\Auth\PermissionTransformer;
use Domain\Auth\Actions\FindPermissionByRouteKeyAction;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class PermissionController extends Controller
{
    public function __construct()
    {
        $permissions = Permission::PERMISSIONS;

        $this->middleware('permission:'.$permissions['index'], ['only' => 'index']);
        $this->middleware('permission:'.$permissions['show'], ['only' => 'show']);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {get} /auth/permissions Get all permissions
     * @apiName            get-all-permissions
     * @apiGroup           Permission
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             PermissionsResponse
     *
     */
    public function index(Request $request)
    {
        return $this->fractal(
            QueryBuilder::for(config('permission.models.permission'))
                ->allowedFilters('name')
                ->paginate(),
            new PermissionTransformer()
        );
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {get} /auth/permissions/{id} Show permission
     * @apiName            show-permission
     * @apiGroup           Permission
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             PermissionResponse
     *
     */
    public function show(Request $request, string $id)
    {
        return $this->fractal(
            app(FindPermissionByRouteKeyAction::class)->execute($id),
            new PermissionTransformer()
        );
    }
}
