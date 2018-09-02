<?php

namespace Modules\Group\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Group\Entities\Group;
use Illuminate\Routing\Controller;
use Modules\Project\Entities\Program;
use Modules\Group\Http\Requests\GroupProgramRequest;
use Modules\Group\Repositories\GroupProgramRepository;

class GroupProgramController extends Controller
{
    /**
     * Repositório de dados.
     *
     * @var \Modules\User\Repositories\GroupProgramRepository
     */
    protected $groupPrograms;

    /**
     * Quantidade de recursos por página.
     *
     * @var int
     */
    static public $perPage = 10;

    /**
     * Inicializa o controlador com a instância do repositório de dados.
     *
     * @param \Modules\User\Repositories\GroupProgramRepository $groupPrograms
     * @return void
     */
    public function __construct(GroupProgramRepository $groupPrograms)
    {
        $this->groupPrograms = $groupPrograms;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $groupId
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $groupId)
    {
        $perPage = self::$perPage;
        $query = $request->get('q');
        $index = $this->groupPrograms
            ->index($groupId, $perPage, $query);
        $user = $request->user();
        $group = $index->data['group'];
        $requestsCount = $user && $user->can('updateRequests', [Program::class, $group]) ?
            $group->programs()
                ->notApproved()
                ->count() :
            null;

        return view('group::pages.programs.index', [
            'group' => $group,
            'programs' => $index->data['programs'],
            'requestsCount' => $requestsCount,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $groupId
     * @return \Illuminate\Http\Response
     */
    public function requests(Request $request, $groupId)
    {
        $query = $request->get('q');
        $user = $request->user();
        $index = $this->groupPrograms
            ->requests($user, $groupId, null, $query);

        if (!$index->success) {
            return abort($index->status);
        }

        return view('group::pages.programs.requests', [
            'group' => $index->data['group'],
            'programs' => $index->data['programs']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $groupId
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $groupId)
    {
        $user = $request->user();
        $group = Group::findOrFail($groupId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('create', [Program::class, $group])) {
            return abort(403);
        }
        $servantMembers = $group->servantMembers()
            ->get();
        
        return view('group::pages.programs.create', [
            'group' => $group,
            'servantMembers' => $servantMembers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\User\Http\Requests\GroupRequest  $request
     * @param  string  $groupId
     * @return \Illuminate\Http\Response
     */
    public function store(GroupProgramRequest $request, $groupId)
    {
        $user = $request->user();
        $inputs = $request->all();
        $store = $this->groupPrograms
            ->store($user, $groupId, $inputs);
        $redirectTo = isset($store->data['program']) ?
            "programs/{$store->data['program']->id}" :
            "groups/{$groupId}/programs"; 

        return redirect($redirectTo)
            ->with('snackbar', $store->message);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $groupId
     * @param  null|string  $programId
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, $groupId, $programId = null)
    {
        $user = $request->user();
        $approve = $this->groupPrograms
            ->approve($user, $groupId, $programId);

        return redirect("groups/{$groupId}/programs-requests")
            ->with('snackbar', $approve->message);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $groupId
     * @param  null|string  $programId
     * @return \Illuminate\Http\Response
     */
    public function deny(Request $request, $groupId, $programId = null)
    {
        $user = $request->user();
        $deny = $this->groupPrograms
            ->deny($user, $groupId, $programId);

        return redirect("groups/{$groupId}/programs-requests")
            ->with('snackbar', $deny->message);
    }    
}
