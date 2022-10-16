<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Backend\Auth\User;

use App\Http\Controllers\Controller;
use App\Models\Auth\User\User;
use App\Transformers\Auth\UserTransformer;
use Domain\User\Actions\FindUserByRouteKeyOnlyTrashAction;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class UserDeleteController extends Controller
{
    public function __construct()
    {
        $permissions = User::PERMISSIONS;

        $this->middleware('permission:'.$permissions['deleted list'], ['only' => 'deleted']);
        $this->middleware('permission:'.$permissions['restore'], ['only' => 'restore']);
        $this->middleware('permission:'.$permissions['purge'], ['only' => 'purge']);
    }

    /**
     * @param  string  $id
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {put} /auth/users/{id}/restore Restore user
     * @apiName            restore-user
     * @apiGroup           UserDelete
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UserResponse
     *
     */
    public function restore(string $id)
    {
        $user = app(FindUserByRouteKeyOnlyTrashAction::class)
            ->execute($id, throw404: true);

        $user->restore();

        return $this->fractal($user->refresh(), new UserTransformer());
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {get} /auth/users/deleted Get all deleted users
     * @apiName            get-all-deleted-users
     * @apiGroup           UserDelete
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UsersDeletedResponse
     *
     */
    public function deleted(Request $request)
    {
        return $this->fractal(
            QueryBuilder::for(User::onlyTrashed())
                ->allowedFilters(['first_name', 'last_name', 'email'])
                ->paginate(),
            new UserTransformer()
        );
    }

    /**
     * @param  string  $id
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @api                {delete} /auth/users/{id} Purge user
     * @apiName            purge-user
     * @apiGroup           UserDelete
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             NoContentResponse
     *
     */
    public function purge(string $id)
    {
        app(FindUserByRouteKeyOnlyTrashAction::class)
            ->execute($id, throw404: true)
            ->forceDelete();

        return response('', 204);
    }
}
