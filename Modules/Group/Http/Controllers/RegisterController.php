<?php

namespace Modules\Group\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Group\Entities\Group;
use Illuminate\Routing\Controller;
use Modules\Group\Entities\Invite;
use Modules\Group\Http\Requests\RegisterRequest;
use Modules\Group\Repositories\MemberRepository;
use Modules\Group\Entities\MemberType;

class RegisterController extends Controller
{
    /**
     * Repositório de dados.
     *
     * @var \Modules\Group\Repositories\MemberRepository
     */
    protected $members;

    /**
     * Inicializa o controlador com a instância do repositório de dados.
     *
     * @param \Modules\User\Repositories\MemberRepository $members
     * @return void
     */
    public function __construct(MemberRepository $members)
    {
        $this->members = $members;
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
    public function store(MemberRequest $request)
    {
        $user = $request->user();
        $inputs = $request->sanitize();
        $store = $this->members
            ->store($user, $inputs);
        $redirectTo = 'members/' . (
            $store->data['group']->id ?? null
        );

        return redirect($redirectTo)
            ->with('snackbar', $store->message);
    }
}
