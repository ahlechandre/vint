<?php

namespace Modules\Group\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Group\Entities\Group;
use Illuminate\Routing\Controller;
use Modules\Group\Http\Requests\RegisterRequest;
use Modules\Group\Repositories\RegisterRepository;
use Modules\Group\Entities\Role;
use Modules\Group\Entities\Member;

class RegisterController extends Controller
{
    /**
     * Repositório de dados.
     *
     * @var \Modules\Group\Repositories\RegisterRepository
     */
    protected $registers;

    /**
     * Inicializa o controlador com a instância do repositório de dados.
     *
     * @param \Modules\Group\Repositories\RegisterRepository $members
     * @return void
     */
    public function __construct(RegisterRepository $registers)
    {
        $this->registers = $registers;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $roleSlug = $request->query('role');
        
        if (!$roleSlug) {
            $roles = Role::all();

            // Membro deve definir o seu papel.
            return view('group::pages.register.roles', [
                'roles' => $roles,
            ]);
        }
        $role = Role::where('slug', $roleSlug)
            ->firstOrFail();
        $groups = Group::all();

        // Caso o membro já tenha definido o seu papel.
        return view('group::pages.register.member', [
            'role' => $role,
            'groups' => $groups
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\User\Http\Requests\MemberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        $user = $request->user();
        $inputs = $request->sanitize();
        $store = $this->registers
            ->store($inputs);

        if ($store->success) {
            return redirect('login')
                ->with(['snackbar' => $store->message]);
        }

        return back()->withInput()
            ->with('snackbar', $store->message);
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function success()
    {
        // Se a requisição não for de um membro recém criado.
        if (!session()->get('memberUserId')) {
            return abort('404');
        }
        $member = Member::with('user')
            ->findOrFail(session()->get('memberUserId'));

        return view('group::pages.register.success', [
            'member' => $member,
        ]);
    }
}
