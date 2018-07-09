<?php

namespace Modules\System\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\System\Entities\Role;
use Illuminate\Routing\Controller;
use Modules\System\Http\Requests\RoleRequest;
use Modules\System\Transformers\RoleResource;
use Modules\System\Repositories\RoleRepository;
use Carbon\Carbon;

class RoleController extends Controller
{
    /**
     * @var int
     */
    protected static $perPage = 1000;
 
    /**
     * @var \Modules\System\Repositories\RoleRepository
     */
    protected $roles;

    /**
     *
     * @param  \Modules\System\Repositories\RoleRepository $roles
     * @return void
     */
    public function __construct(RoleRepository $roles)
    {
        $this->roles = $roles;
    }

    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $filter = $request->query('q');
        $index = $this->roles
            ->index($user, self::$perPage, $filter);

        if (!$index->success) {
            return response()->json([
                'message' => $index->message
            ], $index->status);
        }

        return RoleResource::collection($index->data['roles']);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $user = $request->user();
        $inputs = $request->json()->all();
        $store = $this->roles
            ->store($user, $inputs);
        
        return response()->json([
            'message' => $store->message,
            'data' => $store->success ? [
                'role' => new RoleResource($store->data['role'])
            ] : []
        ], $store->status);
    }

    /**
     * Show the specified resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        $role = Role::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('view', $role)) {
            return response()->json([
                'message' => __('messages.status.403'),
            ], 403);
        }

        return new RoleResource($role->load(
            'abilities.method',
            'abilities.resource',
            'users'
        ));
    }
    
    /**
     * Update the specified resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $user = $request->user();
        $inputs = $request->json()->all();
        $update = $this->roles
            ->update($user, $id, $inputs);
        
        return response()->json([
            'message' => $update->message,
            'data' => $update->success ? [
                'role' => new RoleResource($update->data['role'])
            ] : []
        ], $update->status);
    }
}
