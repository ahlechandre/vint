<?php

namespace Modules\Project\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Project\Http\Requests\ProgramRequest;
use Modules\Project\Repositories\ProgramRepository;
use Modules\Project\Entities\Program;
use Modules\Member\Entities\Servant;
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
        $perPage = self::$perPage;
        $query = $request->get('q');
        $index = $this->programs
            ->index($perPage, $query);
        
        return view('project::pages.programs.index', [
            'programs' => $index->data['programs']
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function projects(Request $request, $id)
    {
        $perPage = self::$perPage;
        $query = $request->get('q');
        $programs = $this->programs
            ->projects($id, $perPage, $query);
        
        return view('project::pages.programs.projects', [
            'program' => $programs->data['program'],
            'projects' => $programs->data['projects']
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

        if ($user) {
            $program = Program::withoutGlobalScope('approved')
                ->findOrFail($id);
            
            if (!$program->is_approved && $user->cant('update', $program)) {
                return abort(404);
            }

            return view('project::pages.programs.show', [
                'program' => $program
            ]);            
        }
        $program = Program::findOrFail($id);
    
        return view('project::pages.programs.show', [
            'program' => $program
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
        $servantMembers = $program->group
            ->servantMembers()
            ->with('user')
            ->get();

        return view('project::pages.programs.edit', [
            'program' => $program,
            'servantMembers' => $servantMembers
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
}
