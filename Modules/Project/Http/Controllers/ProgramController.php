<?php

namespace Modules\Project\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Project\Http\Requests\ProgramRequest;
use Modules\Project\Repositories\ProgramRepository;
use Modules\Project\Entities\Program;
use Modules\Group\Entities\Servant;
use Modules\Group\Entities\Group;

class ProgramController extends Controller
{
    /**
     * Repositório de dados.
     *
     * @var \Modules\Project\Repositories\ProgramRepository
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
     * @param \Modules\Project\Repositories\ProgramRepository $programs
     * @return void
     */
    public function __construct(ProgramRepository $programs)
    {
        $this->programs = $programs;
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
        $index = $this->programs
            ->index($user, $perPage, $query);
        
        if (!$index->success) {
            return abort($index->status);
        }

        return view('project::pages.programs.index', [
            'programs' => $index->data['programs'],
            'programRequestsCount' => $index->data['programRequestsCount']
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
        if ($user->cant('create', Program::class)) {
            return abort(403);
        }
        // Professores para selecionar o coordenador.
        $servants = Servant::professors()
            ->with('member.user')
            ->get();

        if ($user->isMember()) {
            return view('project::pages.programs.create', [
                'servants' => $servants,
            ]);
        }
        // Se o usuário não é membro, deve selecionar o grupo do novo programa.
        $groups = Group::all();

        return view('project::pages.programs.create', [
            'servants' => $servants,
            'groups' => $groups,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\Project\Http\Requests\ProgramRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgramRequest $request)
    {
        $user = $request->user();
        $inputs = $request->all();
        $store = $this->programs
            ->store($user, $inputs);
        $redirectTo = 'programs/' . (
            $store->data['program']->id ?? null
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
        $program = Program::findOrFail($id);

        // Verifica se usuário pode realizar.
        if ($user->cant('view', $program)) {
            return abort(403);
        }
        $section = $request->query('section', 'about');
    
        return view('project::pages.programs.show', [
            'program' => $program,
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
        $program = Program::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $program)) {
            return abort(403);
        }
        // Professores para selecionar o coordenador.
        $servants = Servant::professors()
            ->get();

        return view('project::pages.programs.edit', [
            'program' => $program,
            'servants' => $servants
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\Project\Http\Requests\ProgramRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProgramRequest $request, $id)
    {
        $user = $request->user();
        $inputs = $request->all();
        $update = $this->programs
            ->update($user, $id, $inputs);

        return redirect("programs/{$id}")
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
        $index = $this->programs
            ->requests($user, $perPage, $query);
        
        if (!$index->success) {
            return abort($index->status);
        }

        return view('project::pages.programs.requests', [
            'programs' => $index->data['programs']
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
        $approve = $this->programs
            ->approve($user, $id);

        return redirect('program-requests')
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
        $deny = $this->programs
            ->deny($user, $id);

        return redirect('program-requests')
            ->with('snackbar', $deny->message);
    }
}
