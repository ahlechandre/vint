<?php

namespace Modules\Project\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Project\Repositories\ProjectRepository;
use Modules\Project\Transformers\ProjectResource;
use Modules\Project\Entities\Project;

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
    public function forUser(Request $request)
    {
        $perPage = $request->query('per-page', self::$perPage);
        $query = $request->query('q');
        $user = $request->user();
        $forUser = $this->projects
            ->forUser($user, $perPage, $query);
        $projects = $forUser->data['projects'];

        return ProjectResource::collection($projects);
    }
}
