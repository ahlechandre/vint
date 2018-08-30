<?php

namespace Modules\Group\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Group\Repositories\GroupProgramRepository;
use Modules\Project\Entities\Program;
use Modules\Group\Entities\Group;


class GroupProgramController extends Controller
{
    /**
     * Repositório de dados.
     *
     * @var \Modules\User\Repositories\GroupProgramRepository
     */
    protected $programs;

    /**
     * Quantidade de recursos por página.
     *
     * @var int
     */
    static public $perPage = 10;

    /**
     * Inicializa o controlador com a instância do repositório de dados.
     *
     * @param \Modules\User\Repositories\GroupProgramRepository $programs
     * @return void
     */
    public function __construct(GroupProgramRepository $programs)
    {
        $this->programs = $programs;
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
        $index = $this->programs
            ->index($groupId, $perPage, $query);

        return view('group::pages.programs.index', [
            'group' => $index->data['group'],
            'programs' => $index->data['programs'],
            'programRequestsCount' => $index->data['programRequestsCount'],
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
        $servants = $group->servants()
            ->get();

        return view('group::pages.programs.create', [
            'group' => $group,
            'servants' => $servants,
        ]);
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
        $store = $this->programs
            ->store($user, $inputs);
        $redirectTo = 'programs/' . (
            $store->data['group']->id ?? null
        );

        return redirect($redirectTo)
            ->with('snackbar', $store->message);
    }
}
