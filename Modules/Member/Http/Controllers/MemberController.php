<?php

namespace Modules\Member\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Group\Entities\Role;
use Modules\Group\Entities\Group;
use Illuminate\Routing\Controller;
use Modules\Group\Entities\Member;
use Modules\Group\Http\Requests\MemberRequest;
use Modules\Group\Repositories\MemberRepository;
use Modules\Group\Http\Requests\MemberRoleRequest;

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
     * Show the specified resource.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   string  $userId
     * @return  \Illuminate\Http\Response
     */
    public function show(Request $request, $userId)
    {
        $user = $request->user();
        // Apenas membros aprovados.
        $member = Member::findOrFail($userId);

        // Verifica se usuário pode realizar.
        if ($user->cant('view', $member)) {
            return abort(403);
        }
        $section = $request->query('section', 'about');
    
        return view('group::pages.members.show', [
            'member' => $member,
            'section' => $section
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $userId
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $userId)
    {
        $user = $request->user();
        // Apenas aprovados.
        $member = Member::findOrFail($userId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $member)) {
            return abort(403);
        }
        $roles = Role::all();
        
        return view('group::pages.members.edit', [
            'member' => $member,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\User\Http\Requests\MemberRequest  $request
     * @param  string  $userId
     * @return \Illuminate\Http\Response
     */
    public function update(MemberRequest $request, $userId)
    {
        $user = $request->user();
        $inputs = $request->sanitize();
        $update = $this->members
            ->update($user, $userId, $inputs);

        return redirect("members/{$userId}")
            ->with('snackbar', $update->message);
    }

    /**
     *
     * @param  \Modules\Group\Http\Requests\MemberRoleRequest  $request
     * @param  string  $userId
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function role(MemberRoleRequest $request, $userId, $id)
    {
        $user = $request->user();
        $inputs = $request->sanitize();
        $role = $this->members
            ->role(
                $user,
                $userId,
                $id,
                $inputs
            );

        return redirect("members/{$userId}")
            ->with('snackbar', $role->message);
    }
}
