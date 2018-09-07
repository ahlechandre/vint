<?php

namespace Modules\Project\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Project\Http\Requests\ProjectStudentRequest;
use Modules\Project\Repositories\ProjectStudentRepository;

class ProjectStudentController extends Controller
{
    /**
     * Repositório de dados.
     *
     * @var \Modules\User\Repositories\ProjectStudentRepository
     */
    protected $projectStudents;

    /**
     * Quantidade de recursos por página.
     *
     * @var int
     */
    static public $perPage = 10;

    /**
     * Inicializa o controlador com a instância do repositório de dados.
     *
     * @param \Modules\User\Repositories\ProjectStudentRepository $projectStudents
     * @return void
     */
    public function __construct(ProjectStudentRepository $projectStudents)
    {
        $this->projectStudents = $projectStudents;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $query = $request->get('q');
        $students = $this->projectStudents
            ->index($id, null, $query);
        $project = $students->data['project'];
        $students = $students->data['students'];        
        $user = $request->user();  
        
        // Verifica se existe usuário autenticado e se ele
        // pode criar alunos no projeto. Se puder, seleciona
        // todos os membros alunos disponíveis.
        if ($user && $user->can('createStudents', $project)) {
            $studentMembers = $project->group
                ->studentMembers()
                ->whereNotIn('user_id', $students->pluck('member_user_id'))
                ->get();

            return view('project::pages.projects.students', [
                'project' => $project,
                'students' => $students,
                'studentMembers' => $studentMembers
            ]);
        }

        return view('project::pages.projects.students', [
            'project' => $project,
            'students' => $students
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\User\Http\Requests\ProjectStudentRequest  $request
     * @param  string  $projectId
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectStudentRequest $request, $projectId)
    {
        $user = $request->user();
        $inputs = $request->sanitize();
        $store = $this->projectStudents
            ->store($user, $projectId, $inputs);

        return redirect("projects/{$projectId}/students")
            ->with('snackbar', $store->message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\User\Http\Requests\ProjectStudentRequest  $request
     * @param  string  $projectId
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectStudentRequest $request, $projectId, $id)
    {
        $user = $request->user();
        $inputs = $request->sanitize();
        $update = $this->projectStudents
            ->update($user, $projectId, $id, $inputs);

        return redirect("projects/{$projectId}/students")
            ->with('snackbar', $update->message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\User\Http\Requests\ProjectStudentRequest  $request
     * @param  string  $projectId
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $projectId, $id)
    {
        $user = $request->user();
        $update = $this->projectStudents
            ->destroy($user, $projectId, $id);

        return redirect("projects/{$projectId}/students")
            ->with('snackbar', $update->message);
    }
}
