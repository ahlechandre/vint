<?php

namespace Modules\Group\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Group\Entities\Group;
use Illuminate\Routing\Controller;
use Modules\Project\Entities\Project;
use Modules\Group\Http\Requests\GroupProjectRequest;
use Modules\Group\Repositories\GroupProjectRepository;

class GroupProjectController extends Controller
{
    /**
     * Repositório de dados.
     *
     * @var \Modules\User\Repositories\GroupProjectRepository
     */
    protected $groupProjects;

    /**
     * Quantidade de recursos por página.
     *
     * @var int
     */
    static public $perPage = 15;

    /**
     * Inicializa o controlador com a instância do repositório de dados.
     *
     * @param \Modules\User\Repositories\GroupProjectRepository $groupProjects
     * @return void
     */
    public function __construct(GroupProjectRepository $groupProjects)
    {
        $this->groupProjects = $groupProjects;
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
        $term = $request->get('q');
        $index = $this->groupProjects
            ->index($groupId, self::$perPage, $term);
        $user = $request->user();
        $group = $index->data['group'];
        // Verifica se o usuário pode atualizar solicitações de projetos.
        $canUpdateRequests = $user && $user->can('updateRequests', [Project::class, $group]);
        $requestsCount = $canUpdateRequests ?
            $group->projects()
                ->notApproved()
                ->count() :
            null;

        return view('group::pages.projects.index', [
            'group' => $group,
            'projects' => $index->data['projects'],
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
        $term = $request->get('q');
        $user = $request->user();
        $index = $this->groupProjects
            ->requests($user, $groupId, null, $term);

        if (!$index->success) {
            return abort($index->status);
        }

        return view('group::pages.projects.requests', [
            'group' => $index->data['group'],
            'projects' => $index->data['projects']
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
        if ($user->cant('create', [Project::class, $group])) {
            return abort(403);
        }
        $projects = $group->projects()
            ->approved()
            ->get();
        $servantMembers = $group->servantMembers()
            ->with('user')
            ->get();
        $collaboratorMembers = $group->collaboratorMembers()
            ->with('user')
            ->get();

        return view('group::pages.projects.create', [
            'group' => $group,
            'projects' => $projects,
            'servantMembers' => $servantMembers,
            'collaboratorMembers' => $collaboratorMembers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\User\Http\Requests\GroupRequest  $request
     * @param  string  $groupId
     * @return \Illuminate\Http\Response
     */
    public function store(GroupProjectRequest $request, $groupId)
    {
        $user = $request->user();
        $inputs = $request->all();
        $store = $this->groupProjects
            ->store($user, $groupId, $inputs);
        $redirectTo = isset($store->data['project']) ?
            "projects/{$store->data['project']->id}" :
            "groups/{$groupId}/projects"; 

        return redirect($redirectTo)
            ->with('snackbar', $store->message);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $groupId
     * @param  null|string  $projectId
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, $groupId, $projectId = null)
    {
        $user = $request->user();
        $approve = $this->groupProjects
            ->approve($user, $groupId, $projectId);

        return redirect("groups/{$groupId}/projects/requests")
            ->with('snackbar', $approve->message);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $groupId
     * @param  null|string  $projectId
     * @return \Illuminate\Http\Response
     */
    public function deny(Request $request, $groupId, $projectId = null)
    {
        $user = $request->user();
        $deny = $this->groupProjects
            ->deny($user, $groupId, $projectId);

        return redirect("groups/{$groupId}/projects/requests")
            ->with('snackbar', $deny->message);
    }    
}
