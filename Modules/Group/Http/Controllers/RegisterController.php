<?php

namespace Modules\Group\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Group\Entities\Group;
use Illuminate\Routing\Controller;
use Modules\Group\Entities\Invite;
use Modules\Group\Http\Requests\RegisterRequest;
use Modules\Group\Repositories\RegisterRepository;
use Modules\Group\Entities\MemberType;
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
        $token = $request->query('invite');

        if (!$token) {
            return abort(404);
        }
        $invite = Invite::notExpired()
            ->where('token', $token)
            ->firstOrFail();
        $roleSlug = $request->query('role');
        
        if (!$roleSlug) {
            $roles = Role::all();

            // Membro deve definir o seu papel.
            return view('group::pages.register.roles', [
                'roles' => $roles,
                'group' => $invite->group,
            ]);
        }
        $role = Role::where('slug', $roleSlug)
            ->firstOrFail();

        // Caso o membro já tenha definido o seu papel.
        return view('group::pages.register.member', [
            'invite' => $invite,
            'role' => $role
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
            return redirect('register/success')
                ->with([
                    'snackbar' => $store->message,
                    'memberUserId' => $store->data['member']->user_id
                ]);
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
