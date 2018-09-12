<?php

namespace Modules\Group\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Group\Http\Requests\CoordinatorRequest;
use Modules\Group\Repositories\CoordinatorRepository;

class CoordinatorController extends Controller
{
    /**
     * Repositório de dados.
     *
     * @var \Modules\User\Repositories\CoordinatorRepository
     */
    protected $coordinators;

    /**
     * Quantidade de recursos por página.
     *
     * @var int
     */
    static public $perPage = 15;

    /**
     * Inicializa o controlador com a instância do repositório de dados.
     *
     * @param \Modules\User\Repositories\CoordinatorRepository $coordinators
     * @return void
     */
    public function __construct(CoordinatorRepository $coordinators)
    {
        $this->coordinators = $coordinators;
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
        $index = $this->coordinators
            ->index($groupId, null, $term);
        $group = $index->data['group'];
        $coordinators = $index->data['coordinators'];
        $user = $request->user();

        // Se existir usuário autenticado e ele puder criar 
        // coordenadores, então seleciona todos os membros
        // servidores disponíveis no grupo.
        if ($user && $user->can('updateCoordinators', $group)) {
            $servantMembers = $group->servantMembers()
                ->whereNotIn('user_id', $coordinators->pluck('member_user_id'))
                ->get();

            return view('group::pages.coordinators.index', [
                'group' => $group,
                'coordinators' => $coordinators,
                'servantMembers' => $servantMembers,
            ]);
        }

        return view('group::pages.coordinators.index', [
            'group' => $group,
            'coordinators' => $coordinators
        ]);        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\User\Http\Requests\CoordinatorRequest  $request
     * @param  string  $groupId
     * @return \Illuminate\Http\Response
     */
    public function store(CoordinatorRequest $request, $groupId)
    {
        $user = $request->user();
        $inputs = $request->sanitize();
        $store = $this->coordinators
            ->store($user, $groupId, $inputs);

        return redirect("groups/{$groupId}/coordinators")
            ->with('snackbar', $store->message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\User\Http\Requests\CoordinatorRequest  $request
     * @param  string  $groupId
     * @param  string  $coordinatorUserId
     * @return \Illuminate\Http\Response
     */
    public function update(CoordinatorRequest $request, $groupId, $coordinatorUserId)
    {
        $user = $request->user();
        $inputs = $request->sanitize();
        $update = $this->coordinators
            ->update($user, $groupId, $coordinatorUserId, $inputs);

        return redirect("groups/{$groupId}/coordinators")
            ->with('snackbar', $update->message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\User\Http\Requests\CoordinatorRequest  $request
     * @param  string  $groupId
     * @param  string  $coordinatorUserId
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $groupId, $coordinatorUserId)
    {
        $user = $request->user();
        $update = $this->coordinators
            ->destroy($user, $groupId, $coordinatorUserId);

        return redirect("groups/{$groupId}/coordinators")
            ->with('snackbar', $update->message);
    }
}
