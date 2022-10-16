<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Backend\Auth\Role;

use App\Http\Controllers\Controller;
use App\Models\Auth\Role\Role;
use App\Transformers\Auth\RoleTransformer;
use Domain\Auth\Actions\FindRoleByRouteKeyAction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;

class RoleController extends Controller
{
    public function __construct()
    {
        $permissions = Role::PERMISSIONS;

        $this->middleware('permission:'.$permissions['index'], ['only' => 'index']);
        $this->middleware('permission:'.$permissions['create'], ['only' => 'store']);
        $this->middleware('permission:'.$permissions['show'], ['only' => 'show']);
        $this->middleware('permission:'.$permissions['update'], ['only' => 'update']);
        $this->middleware('permission:'.$permissions['destroy'], ['only' => 'destroy']);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {get} /auth/roles Get all roles
     * @apiName            get-all-roles
     * @apiGroup           Role
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             RolesResponse
     *
     */
    public function index(Request $request)
    {
        return $this->fractal(
            QueryBuilder::for(config('permission.models.role'))
                ->allowedFilters('name')
                ->paginate(),
            new RoleTransformer()
        );
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @api                {post} /auth/roles Store role
     * @apiName            store-role
     * @apiGroup           Role
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             RoleCreatedResponse
     * @apiParam {String} name (required)
     *
     */
    public function store(Request $request)
    {
        $attributes = $this->validate(
            $request,
            [
                'name' => 'required|string',
            ]
        );

        $role = Role::create(['name' => $attributes['name']]);

        return $this->fractal($role, new RoleTransformer())->respond(201);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {post} /auth/roles/{id} Show role
     * @apiName            show-role
     * @apiGroup           Role
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             RoleResponse
     *
     */
    public function show(Request $request, string $id)
    {
        return $this->fractal(
            app(FindRoleByRouteKeyAction::class)->execute($id),
            new RoleTransformer()
        );
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     *
     * @return \Spatie\Fractal\Fractal
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws \Illuminate\Validation\ValidationException
     * @api                {put} /auth/roles Update role
     * @apiName            update-role
     * @apiGroup           Role
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             RoleResponse
     * @apiParam {String} name
     *
     */
    public function update(Request $request, string $id)
    {
        $role = app(FindRoleByRouteKeyAction::class)
            ->execute($id);

        if (in_array($role->name, config('setting.permission.role_names'))) {
            abort(403, 'You cannot update/delete default role.');
        }

        $attributes = $this->validate(
            $request,
            [
                'name' => ['required', 'string', Rule::unique(config('permission.models.role'))],
            ]
        );

        $role->update([
            'name' => $attributes['name'],
        ]);

        return $this->fractal($role->refresh(), new RoleTransformer());
    }

    /**
     * @param  string  $id
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @api                {delete} /auth/roles/{id} Destroy role
     * @apiName            destroy-role
     * @apiGroup           Role
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             NoContentResponse
     *
     */
    public function destroy(string $id)
    {
        $role = app(FindRoleByRouteKeyAction::class)
            ->execute($id);

        if (in_array($role->name, config('setting.permission.role_names'))) {
            abort(403, 'You cannot update/delete default role.');
        }

        $role->delete();

        return response('', 204);
    }
}
