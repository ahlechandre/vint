<?php

namespace Modules\Group\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Group\Repositories\GroupMemberRepository;


class GroupMemberController extends Controller
{
    /**
     * Repositório de dados.
     *
     * @var \Modules\User\Repositories\GroupMemberRepository
     */
    protected $groupMembers;

    /**
     * Quantidade de recursos por página.
     *
     * @var int
     */
    static public $perPage = 10;

    /**
     * Inicializa o controlador com a instância do repositório de dados.
     *
     * @param \Modules\User\Repositories\GroupMemberRepository $groupMembers
     * @return void
     */
    public function __construct(GroupMemberRepository $groupMembers)
    {
        $this->groupMembers = $groupMembers;
    }
    
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $groupId
     * @param  string  $memberUserId
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request, $groupId, $memberUserId)
    {
        $user = $request->user();
        $toggle = $this->groupMembers
            ->toggle($user, $groupId, $memberUserId);

        return back()->with('snackbar', $toggle->message);
    }
}
