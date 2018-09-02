<?php

namespace Modules\Member\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Member\Entities\Role;
use Modules\Group\Entities\Group;
use Illuminate\Routing\Controller;
use Modules\Member\Entities\Member;
use Modules\Member\Http\Requests\MemberRequest;
use Modules\Member\Repositories\MemberRepository;
use Modules\Member\Http\Requests\MemberRoleRequest;

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
        $perPage = self::$perPage;
        $query = $request->get('q');
        $index = $this->members
            ->index($perPage, $query);

        return view('member::pages.members.index', [
            'members' => $index->data['members'],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $userId
     * @return \Illuminate\Http\Response
     */
    public function programs(Request $request, $userId)
    {
        $perPage = self::$perPage;
        $query = $request->get('q');
        $programs = $this->members
            ->programs($userId, $perPage, $query);

        return view('member::pages.members.programs', [
            'member' => $programs->data['member'],
            'programs' => $programs->data['programs'],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $userId
     * @return \Illuminate\Http\Response
     */
    public function projects(Request $request, $userId)
    {
        $perPage = self::$perPage;
        $query = $request->get('q');
        $projects = $this->members
            ->projects($userId, $perPage, $query);

        return view('member::pages.members.projects', [
            'member' => $projects->data['member'],
            'projects' => $projects->data['projects'],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $userId
     * @return \Illuminate\Http\Response
     */
    public function publications(Request $request, $userId)
    {
        $perPage = self::$perPage;
        $query = $request->get('q');
        $publications = $this->members
            ->publications($userId, $perPage, $query);

        return view('member::pages.members.publications', [
            'member' => $publications->data['member'],
            'publications' => $publications->data['publications'],
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
        $member = Member::findOrFail($userId);
    
        return view('member::pages.members.show', [
            'member' => $member,
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
        $inputs = $request->all();
        $update = $this->members
            ->update($user, $userId, $inputs);

        return redirect("members/{$userId}")
            ->with('snackbar', $update->message);
    }

    /**
     *
     * @param  \Modules\Group\Http\Requests\MemberRoleRequest  $request
     * @param  string  $userId
     * @param  string  $roleId
     * @return \Illuminate\Http\Response
     */
    public function role(MemberRoleRequest $request, $userId, $roleId)
    {
        $user = $request->user();
        $inputs = $request->sanitize();
        $role = $this->members
            ->role($user, $userId, $roleId, $inputs);

        return redirect("members/{$userId}")
            ->with('snackbar', $role->message);
    }
}
