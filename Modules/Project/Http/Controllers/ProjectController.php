<?php

namespace Modules\Project\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Project\Http\Requests\ProjectRequest;
use Modules\Project\Repositories\ProjectRepository;
use Modules\Project\Entities\Project;
use Modules\Group\Entities\Servant;
use Modules\Group\Entities\Group;
use Modules\Group\Entities\Collaborator;
use Modules\Project\Entities\Program;

class ProjectController extends Controller
{
    /**
     * Repositório de dados.
     *
     * @var \Modules\Project\Repositories\ProjectRepository
     */
    protected $projects;

    /**
     * Quantidade de recursos por página.
     *
     * @var int
     */
    static public $perPage = 10;

    /**
     * Inicializa o controlador com a instância do repositório de dados.
     *
     * @param \Modules\Project\Repositories\ProjectRepository $projects
     * @return void
     */
    public function __construct(ProjectRepository $projects)
    {
        $this->projects = $projects;
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
        $index = $this->projects
            ->index($user, $perPage, $query);
        
        if (!$index->success) {
            return abort($index->status);
        }

        return view('project::pages.projects.index', [
            'projects' => $index->data['projects'],
            'projectRequestsCount' => $index->data['projectRequestsCount']
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
        if ($user->cant('create', Project::class)) {
            return abort(403);
        }
        // Programas para selecionar o programa.
        $programs = $user->isMember() ?
            Program::ofGroup($user->member->group)
                ->approved()
                ->get() :
            Program::approved()
                ->get();
        // Professores para selecionar o coordenador.
        $professors = Servant::professors()
            ->with('member.user')
            ->get();
        // Servidores para selecionar o orientador.
        $servants = Servant::with('member.user')
            ->get();
        // Colaboradores para selecionar o apoiador.
        $collaborators = Collaborator::with('member.user')
            ->get();

        if ($user->isMember()) {
            return view('project::pages.projects.create', [
                'programs' => $programs,
                'professors' => $professors,
                'servants' => $servants,
                'collaborators' => $collaborators
            ]);
        }
        // Se o usuário não é membro, deve selecionar o grupo do novo projeto.
        $groups = Group::all();

        return view('project::pages.projects.create', [
            'programs' => $programs,
            'professors' => $professors,
            'servants' => $servants,
            'collaborators' => $collaborators,
            'groups' => $groups
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\Project\Http\Requests\ProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $user = $request->user();
        $inputs = $request->all();
        $store = $this->projects
            ->store($user, $inputs);
        $redirectTo = 'projects/' . (
            $store->data['project']->id ?? null
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
        $project = Project::findOrFail($id);

        // Verifica se usuário pode realizar.
        if ($user->cant('view', $project)) {
            return abort(403);
        }
        $section = $request->query('section', 'about');
    
        return view('project::pages.projects.show', [
            'project' => $project,
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
        $project = Project::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $project)) {
            return abort(403);
        }
        // Programas para selecionar o programa.
        $programs = $user->isMember() ?
            Program::ofGroup($user->member->group)
                ->approved()
                ->get() :
            Program::approved()
                ->get();
        // Professores para selecionar o coordenador.
        $professors = Servant::professors()
            ->with('member.user')
            ->get();
        // Servidores para selecionar o orientador.
        $servants = Servant::with('member.user')
            ->get();
        // Colaboradores para selecionar o apoiador.
        $collaborators = Collaborator::with('member.user')
            ->get();

        return view('project::pages.projects.edit', [
            'project' => $project,
            'programs' => $programs,
            'professors' => $professors,
            'servants' => $servants,
            'collaborators' => $collaborators
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\Project\Http\Requests\ProjectRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, $id)
    {
        $user = $request->user();
        $inputs = $request->all();
        $update = $this->projects
            ->update($user, $id, $inputs);

        return redirect("projects/{$id}")
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
        $index = $this->projects
            ->requests($user, $perPage, $query);
        
        if (!$index->success) {
            return abort($index->status);
        }

        return view('project::pages.projects.requests', [
            'projects' => $index->data['projects']
        ]);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  null|string  $id
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, $id = null)
    {
        $user = $request->user();
        $approve = $this->projects
            ->approve($user, $id);

        return redirect('project-requests')
            ->with('snackbar', $approve->message);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  null|string  $id
     * @return \Illuminate\Http\Response
     */
    public function deny(Request $request, $id = null)
    {
        $user = $request->user();
        $deny = $this->projects
            ->deny($user, $id);

        return redirect('project-requests')
            ->with('snackbar', $deny->message);
    }
}
