<?php

namespace Modules\User\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Entities\User;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\UserRequest;
use Modules\User\Transformers\UserResource;
use Modules\User\Repositories\UserRepository;

class UserController extends Controller
{
    /**
     * @var \Modules\User\Repositories\UserRepository
     */
    protected $users;
 
    /**
     * @var int
     */
    protected static $perPage = 1000;

    /**
     *
     * @param \Modules\User\Repositories\UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
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
        $perPage = (int) $request->query('per-page', self::$perPage);
        $queries = $request->query();
        $index = $this->users
            ->index($user, $perPage, $filter, $queries);
        
        if (!$index->success) {
            return response()->json([
                'message' => $index->message
            ], $index->status);
        }
    
        return UserResource::collection($index->data['users']);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Modules\User\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = $request->user();
        $inputs = $request->json()->all();
        $store = $this->users
            ->store($user, $inputs);
        
        return response()->json([
            'message' => $store->message,
            'data' => $store->success ? [
                'user' => new UserResource($store->data['userCreated'])
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
        $userToShow = User::findOrFail((int) $id);
        
        // Verifica se o usuário pode realizar.
        if ($user->cant('view', $userToShow)) {
            return response()->json([
                'message' => __('messages.status.403'),
            ], 403);
        }
        $user->load('role');

        return new UserResource($userToShow);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Modules\User\Http\Requests\UserRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = $request->user();
        $inputs = $request->json()->all();
        $update = $this->users
            ->update($user, (int) $id, $inputs);
        
        return response()->json([
            'message' => $update->message,
            'data' => $update->success ? [
                'user' => new UserResource($update->data['userUpdated'])
            ] : []
        ], $update->status);
    }
}
