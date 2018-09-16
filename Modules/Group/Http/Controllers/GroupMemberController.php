<?php

namespace Modules\Group\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Group\Repositories\GroupMemberRepository;
use Modules\Member\Entities\Member;


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
    static public $perPage = 15;

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
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $groupId
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $groupId)
    {
        $term = $request->get('q');
        $index = $this->groupMembers
            ->index($groupId, self::$perPage, $term);
        $user = $request->user();
        $group = $index->data['group'];
        // Verifica se o usuário pode atualizar solicitações de membros.
        $canUpdateRequests = $user && $user->can('updateRequests', [Member::class, $group]);
        $requestsCount = $canUpdateRequests ?
            $group->membersNotApproved()->count() :
            null;

        return view('group::pages.members.index', [
            'group' => $group,
            'members' => $index->data['members'],
            'requestsCount' => $requestsCount,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $groupId
     * @return \Illuminate\Http\Response
     */
    public function requests(Request $request, $groupId)
    {
        $term = $request->get('q');
        $user = $request->user();
        $index = $this->groupMembers
            ->requests($user, $groupId, null, $term);

        if (!$index->success) {
            return abort($index->status);
        }

        // Redireciona para todos os membros caso não existam solicitações.
        if ($index->data['members']->isEmpty()) {
            return redirect("groups/{$groupId}/members")
                ->with('snackbar', __('messages.groups.members_requests_empty'));
        }

        return view('group::pages.members.requests', [
            'group' => $index->data['group'],
            'members' => $index->data['members']
        ]);
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

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $groupId
     * @param  string  $memberUserId
     * @return \Illuminate\Http\Response
     */
    public function detach(Request $request, $groupId, $memberUserId)
    {
        $user = $request->user();
        $detach = $this->groupMembers
            ->detach($user, $groupId, $memberUserId);

        return back()->with('snackbar', $detach->message);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $groupId
     * @param  null|string  $memberUserId
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, $groupId, $memberUserId = null)
    {
        $user = $request->user();
        $approve = $this->groupMembers
            ->approve($user, $groupId, $memberUserId);

        return redirect("groups/{$groupId}/members/requests")
            ->with('snackbar', $approve->message);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $groupId
     * @param  null|string  $memberUserId
     * @return \Illuminate\Http\Response
     */
    public function deny(Request $request, $groupId, $memberUserId = null)
    {
        $user = $request->user();
        $deny = $this->groupMembers
            ->deny($user, $groupId, $memberUserId);

        return redirect("groups/{$groupId}/members/requests")
            ->with('snackbar', $deny->message);
    }
}
