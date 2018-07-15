<?php

namespace Modules\Group\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Group\Http\Requests\InviteRequest;
use Modules\Group\Repositories\InviteRepository;
use Modules\Group\Entities\Invite;

class InviteController extends Controller
{
    /**
     * Repositório de dados.
     *
     * @var \Modules\User\Repositories\InviteRepository
     */
    protected $invites;

    /**
     * Quantidade de recursos por página.
     *
     * @var int
     */
    static public $perPage = 10;

    /**
     * Inicializa o controlador com a instância do repositório de dados.
     *
     * @param \Modules\User\Repositories\InviteRepository $invites
     * @return void
     */
    public function __construct(InviteRepository $invites)
    {
        $this->invites = $invites;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\User\Http\Requests\InviteRequest  $request
     * @param  string  $groupId
     * @return \Illuminate\Http\Response
     */
    public function store(InviteRequest $request, $groupId)
    {
        $user = $request->user();
        $inputs = $request->all();
        $store = $this->invites
            ->store($user, (int) $groupId, $inputs);

        return redirect("groups/{$groupId}?section=invites")
            ->with('snackbar', $store->message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\User\Http\Requests\InviteRequest  $request
     * @param  string  $groupId
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InviteRequest $request, $groupId, $id)
    {
        $user = $request->user();
        $inputs = $request->all();
        $update = $this->invites
            ->update(
                $user,
                (int) $groupId,
                (int) $id,
                $inputs
            );

        return redirect("groups/{$groupId}?section=invites")
            ->with('snackbar', $update->message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\User\Http\Requests\InviteRequest  $request
     * @param  string  $groupId
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $groupId, $id)
    {
        $user = $request->user();
        $update = $this->invites
            ->destroy(
                $user,
                (int) $groupId,
                (int) $id
            );

        return redirect("groups/{$groupId}?section=invites")
            ->with('snackbar', $update->message);
    }
}
