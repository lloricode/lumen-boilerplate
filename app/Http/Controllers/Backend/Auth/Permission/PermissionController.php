<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/16/18
 * Time: 11:25 AM
 */

namespace App\Http\Controllers\Backend\Auth\Permission;

use App\Http\Controllers\Controller;
use App\Presenters\Auth\PermissionPresenter;
use App\Repositories\Auth\Permission\PermissionRepository;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class PermissionController
 *
 * @package App\Http\Controllers\Backend\Auth\Permission
 * @group   Authorization
 */
class PermissionController extends Controller
{
    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $permissions = app($permissionRepository->model())::PERMISSIONS;

        $this->middleware('permission:' . $permissions['index'], ['only' => 'index']);
        $this->middleware('permission:' . $permissions['show'], ['only' => 'show']);

        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Get all permissions.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @authenticated
     * @responseFile responses/auth/permissions.get.json
     */
    public function index(Request $request)
    {
        $this->permissionRepository->pushCriteria(new RequestCriteria($request));
        $this->permissionRepository->setPresenter(PermissionPresenter::class);
        return $this->permissionRepository->paginate();
    }

    /**
     * Show permission.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @authenticated
     * @responseFile responses/auth/permission.get.json
     */
    public function show(Request $request)
    {
        $this->permissionRepository->setPresenter(PermissionPresenter::class);
        return $this->permissionRepository->find($this->decodeId($request));
    }

}