<?php

namespace Modules\Project\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Project\Http\Requests\ProjectRequest;
use Modules\Project\Repositories\ProjectRepository;
use Modules\Project\Entities\Project;
use Modules\Member\Entities\Servant;
use Modules\Group\Entities\Group;
use Modules\Member\Entities\Collaborator;
use Modules\Project\Entities\Program;
use Modules\Member\Entities\Student;

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
        $perPage = self::$perPage;
        $query = $request->get('q');
        $index = $this->projects
            ->index($perPage, $query);

        return view('project::pages.projects.index', [
            'projects' => $index->data['projects']
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function students(Request $request, $id)
    {
        $perPage = self::$perPage;
        $query = $request->get('q');
        $students = $this->projects
            ->students($id, $perPage, $query);

        return view('project::pages.projects.students', [
            'project' => $students->data['project'],
            'students' => $students->data['students']
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function publications(Request $request, $id)
    {
        $perPage = self::$perPage;
        $query = $request->get('q');
        $publications = $this->projects
            ->publications($id, $perPage, $query);

        return view('project::pages.projects.publications', [
            'project' => $students->data['project'],
            'publications' => $products->data['publications']
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function products(Request $request, $id)
    {
        $perPage = self::$perPage;
        $query = $request->get('q');
        $products = $this->projects
            ->products($id, $perPage, $query);

        return view('project::pages.projects.products', [
            'project' => $students->data['project'],
            'products' => $products->data['products']
        ]);
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

        return view('project::pages.projects.show', [
            'project' => $project
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
        // Todos os programas do grupo.
        $programs = $project->group->programs;
        // Todos os membros servidores do grupo.
        $servantMembers = $project->group
            ->servantMembers()
            ->with('user')
            ->get();
        // Todos os colaboradores do grupo.
        $collaboratorMembers = $project->group
            ->collaboratorMembers()
            ->with('user')
            ->get();

        return view('project::pages.projects.edit', [
            'project' => $project,
            'programs' => $programs,
            'servantMembers' => $servantMembers,
            'collaboratorMembers' => $collaboratorMembers,
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
}
