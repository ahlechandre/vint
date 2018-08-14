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
    static public $perPage = 10;

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

        return redirect("groups/{$groupId}?section=coordinators")
            ->with('snackbar', $store->message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\User\Http\Requests\CoordinatorRequest  $request
     * @param  string  $groupId
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CoordinatorRequest $request, $groupId, $id)
    {
        $user = $request->user();
        $inputs = $request->sanitize();
        $update = $this->coordinators
            ->update(
                $user,
                $groupId,
                $id,
                $inputs
            );

        return redirect("groups/{$groupId}?section=coordinators")
            ->with('snackbar', $update->message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\User\Http\Requests\CoordinatorRequest  $request
     * @param  string  $groupId
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $groupId, $id)
    {
        $user = $request->user();
        $update = $this->coordinators
            ->destroy($user, $groupId, $id);

        return redirect("groups/{$groupId}?section=coordinators")
            ->with('snackbar', $update->message);
    }
}
