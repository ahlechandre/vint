<?php

namespace Modules\Group\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Group\Entities\Group;
use Illuminate\Routing\Controller;
use Modules\Group\Entities\Member;
use Modules\Group\Entities\Servant;
use Modules\System\Entities\Permission;
use Modules\Group\Http\Requests\GroupRequest;
use Modules\Group\Repositories\GroupRepository;
use Modules\Project\Repositories\ProgramRepository;
use Modules\Project\Repositories\ProjectRepository;
use Modules\Group\Repositories\MemberRepository;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Repositories\PublicationRepository;

class GroupController extends Controller
{
    /**
     * Repositório de dados.
     *
     * @var \Modules\User\Repositories\GroupRepository
     */
    protected $groups;

    /**
     * Quantidade de recursos por página.
     *
     * @var int
     */
    static public $perPage = 10;

    /**
     * Inicializa o controlador com a instância do repositório de dados.
     *
     * @param \Modules\User\Repositories\GroupRepository $groups
     * @return void
     */
    public function __construct(GroupRepository $groups)
    {
        $this->groups = $groups;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = self::$perPage;
        $query = $request->get('q');
        $index = $this->groups
            ->index($perPage, $query);

        return view('group::pages.groups.index', [
            'groups' => $index->data['groups']
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
        if ($user->cant('create', Group::class)) {
            return abort(403);
        }

        return view('group::pages.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\User\Http\Requests\GroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
        $user = $request->user();
        $inputs = $request->all();
        $store = $this->groups
            ->store($user, $inputs);
        $redirectTo = 'groups/' . (
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
     * @param   null|string  $section
     * @return  \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        return view('group::pages.groups.show', [
            'group' => $group
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
        $group = Group::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $group)) {
            return abort(403);
        }

        return view('group::pages.groups.edit', [
            'group' => $group
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\User\Http\Requests\GroupRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GroupRequest $request, $id)
    {
        $user = $request->user();
        $inputs = $request->sanitize();
        $update = $this->groups
            ->update($user, (int) $id, $inputs);

        return redirect("groups/{$id}")
            ->with('snackbar', $update->message);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  null|string  $id
     * @param  null|string  $memberUserId
     * @return \Illuminate\Http\Response
     */
    public function approveMembers(Request $request, $id, $memberUserId = null)
    {
        $user = $request->user();
        $approveMembers = $this->groups
            ->approveMembers($user, $id, $memberUserId);

        return redirect("groups/{$id}?section=members")
            ->with('snackbar', $approveMembers->message);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  null|string  $id
     * @param  null|string  $memberUserId
     * @return \Illuminate\Http\Response
     */
    public function denyMembers(Request $request, $id, $memberUserId = null)
    {
        $user = $request->user();
        $denyMembers = $this->groups
            ->denyMembers($user, $id, $memberUserId);

        return redirect("groups/{$id}?section=members")
            ->with('snackbar', $denyMembers->message);
    } 
}
