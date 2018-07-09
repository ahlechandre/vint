<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\System\Entities\Role;
use Illuminate\Routing\Controller;
use Modules\System\Entities\Ability;
use Modules\System\Http\Requests\RoleRequest;
use Modules\System\Repositories\RoleRepository;

class RoleController extends Controller
{
    /**
     * @var int
     */
    protected static $perPage = 10; 

    /**
     * @var RoleRepository
     */
    protected $roles;

    /**
     *
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
            abort($index->status);
        }

        return view('system::pages.roles.index', [
            'roles' => $index->data['roles']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = $request->user();

        // Verifica se o usuário pode realizar.
        if ($user->cant('create', Role::class)) {
            abort(403);
        }
        $abilities = Ability::with('resource', 'method')
            ->get();

        return view('system::pages.roles.create', [
            'abilities' => $abilities
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Modules\System\Http\Requests\RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $user = $request->user();
        $inputs = $request->sanitize();
        $store = $this->roles
            ->store($user, $inputs);
        $redirectTo = 'roles/' . (
            $store->success ?
                $store->data['role']->id :
                ''
        );
        
        return redirect($redirectTo)
            ->with('snackbar', $store->message);
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
        $section = $request->query('section', 'about');
        $role = Role::findOrFail($id);
        
        // Verifica se o usuário pode realizar.
        if ($user->cant('view', $role)) {
            abort(403);
        }

        switch ($section) {
            case 'abilities':
                $abilities = Ability::all();

                return view('system::pages.roles.show', [
                    'role' => $role,
                    'section' => $section,
                    'abilities' => $abilities
                ]);
            default:
                return view('system::pages.roles.show', [
                    'role' => $role,
                    'section' => $section,
                ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $user = $request->user();
        $role = Role::findOrFail((int) $id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $role)) {
            abort(403);
        }
        $abilities = Ability::with('resource', 'method')
            ->get();

        return view('system::pages.roles.edit', [
            'role' => $role,
            'abilities' => $abilities
        ]);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Modules\System\Http\Requests\RoleRequest  $request
     * @param  string  $request
     * @return Response
     */
    public function update(RoleRequest $request, $id)
    {
        $user = $request->user();
        $inputs = $request->sanitize();
        $update = $this->roles
            ->update($user, (int) $id, $inputs);
        $redirectTo = 'roles/' . (
            $update->success ?
                $update->data['role']->id :
                ''
        );
   
        return redirect("roles/{$id}")
            ->with('snackbar', $update->message);
    }
}
