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
        $memberTypeSlug = $request->query('member-type');
        
        if (!$memberTypeSlug) {
            $memberTypes = MemberType::all();

            // Membro deve definir o seu tipo.
            return view('group::pages.register.member_types', [
                'memberTypes' => $memberTypes
            ]);
        }
        $memberType = MemberType::where('slug', $memberTypeSlug)
            ->firstOrFail();

        // Caso o membro já tenha definido o seu tipo.
        return view('group::pages.register.member', [
            'invite' => $invite,
            'memberType' => $memberType
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
                ->with('snackbar', $store->message);
        }

        return back()->withInput()
            ->with('snackbar', $store->message);
    }
}
