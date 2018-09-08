<?php

namespace Modules\Group\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Group\Http\Requests\GroupRoleRequest;
use Modules\Group\Repositories\GroupRoleRepository;

class GroupRoleController extends Controller
{
    /**
     * Repositório de dados.
     *
     * @var \Modules\Group\Repositories\GroupRoleRepository
     */
    protected $groupRoles;

    /**
     * Quantidade de recursos por página.
     *
     * @var int
     */
    static public $perPage = 10;

    /**
     * Inicializa o controlador com a instância do repositório de dados.
     *
     * @param \Modules\User\Repositories\GroupRoleRepository $groupRoles
     * @return void
     */
    public function __construct(GroupRoleRepository $groupRoles)
    {
        $this->groupRoles = $groupRoles;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\User\Http\Requests\GroupRoleRequest  $request
     * @param  string  $groupId
     * @param  string  $groupRoleId
     * @return \Illuminate\Http\Response
     */
    public function update(GroupRoleRequest $request, $groupId, $groupRoleId)
    {
        $user = $request->user();
        $inputs = $request->all();
        $update = $this->groupRoles
            ->update($user, $groupId, $groupRoleId, $inputs);

        return redirect("groups/{$groupId}/edit?section=permissions")
            ->with('snackbar', $update->message);
    }
}
