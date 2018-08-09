<?php

namespace Modules\Group\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Group\Entities\Group;
use Illuminate\Routing\Controller;
use Modules\Group\Http\Requests\MemberRequest;
use Modules\Group\Repositories\MemberRepository;
use Modules\Group\Entities\Member;

class MemberController extends Controller
{
    /**
     * Repositório de dados.
     *
     * @var \Modules\User\Repositories\MemberRepository
     */
    protected $members;

    /**
     * Quantidade de recursos por página.
     *
     * @var int
     */
    static public $perPage = 10;

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
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $perPage = self::$perPage;
        $query = $request->get('q');
        $index = $this->members
            ->index($user, $perPage, $query);
        
        if (!$index->success) {
            return abort($index->status);
        }

        return view('group::pages.members.index', [
            'members' => $index->data['members'],
            'memberRequestsCount' => $index->data['memberRequestsCount']
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
        if ($user->cant('create', Member::class)) {
            return abort(403);
        }

        return view('group::pages.members.create');
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

    /**
     * Show the specified resource.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   string  $id
     * @return  \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        $group = Member::findOrFail($id);

        // Verifica se usuário pode realizar.
        if ($user->cant('view', $group)) {
            return abort(403);
        }
        $section = $request->query('section', 'about');
    
        if ($section === 'group-roles') {
            // Carrega as permissões caso a seção seja de papéis.
            $permissions = Permission::with('action', 'resource')
                ->get();

            return view('group::pages.members.show', [
                'group' => $group,
                'permissions' => $permissions,
                'section' => $section
            ]);    
        }

        return view('group::pages.members.show', [
            'group' => $group,
            'section' => $section
        ]);
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
        $group = Member::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $group)) {
            return abort(403);
        }

        return view('group::pages.members.edit', [
            'group' => $group
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\User\Http\Requests\MemberRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MemberRequest $request, $id)
    {
        $user = $request->user();
        $inputs = $request->sanitize();
        $update = $this->members
            ->update($user, (int) $id, $inputs);

        return redirect("members/{$id}")
            ->with('snackbar', $update->message);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function requests(Request $request)
    {
        $user = $request->user();
        $perPage = self::$perPage;
        $query = $request->get('q');
        $index = $this->members
            ->requests($user, $perPage, $query);
        
        if (!$index->success) {
            return abort($index->status);
        }

        return view('group::pages.members.requests', [
            'members' => $index->data['members']
                ->load('user', 'role')
        ]);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  null|string  $memberUserId
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, $memberUserId = null)
    {
        $user = $request->user();
        $approve = $this->members
            ->approve($user, $memberUserId);

        return redirect('member-requests')
            ->with('snackbar', $approve->message);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  null|string  $memberUserId
     * @return \Illuminate\Http\Response
     */
    public function deny(Request $request, $memberUserId = null)
    {
        $user = $request->user();
        $deny = $this->members
            ->deny($user, $memberUserId);

        return redirect('member-requests')
            ->with('snackbar', $deny->message);
    }
}
