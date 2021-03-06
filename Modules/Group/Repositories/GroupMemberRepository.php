<?php

namespace Modules\Group\Repositories;

use Exception;
use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Illuminate\Support\Facades\DB;
use Modules\Member\Entities\Member;

class GroupMemberRepository
{
    /**
     * Lista todos os membros do grupo.
     *
     * @param  string|int  $groupId
     * @param  null|int  $perPage
     * @param  null|string  $term
     * @return stdClass
     */
    public function index($groupId, $perPage = null, $term = null)
    {
        $group = Group::findOrFail($groupId);

        return repository_result(200, null, [
            'group' => $group,
            'members' => $group->membersApproved()
                ->with('user')
                ->filterLike($term)
                ->simplePaginateOrGet($perPage)
        ]);
    }

    /**
     * Lista todos os membros não aprovados do grupo.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  string|int  $groupId
     * @param  null|int  $perPage
     * @param  null|string  $term
     * @return stdClass
     */
    public function requests(User $user, $groupId, $perPage = null, $term = null)
    {
        $group = Group::findOrFail($groupId);

        if ($user->cant('updateRequests', [Member::class, $group])) {
            return repository_result(403);
        }
        $members = $group->membersNotApproved()
            ->with('user')
            ->filterLike($term)
            ->simplePaginateOrGet($perPage);
        
        return repository_result(200, null, [
            'group' => $group,
            'members' => $members
        ]);
    }

    /**
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int|string  $groupId
     * @param  int|string  $memberUserId
     * @return stdClass
     */
    public function toggle(User $user, $groupId, $memberUserId)
    {
        $group = Group::findOrFail($groupId);
        $member = Member::findOrFail($memberUserId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('toggleMember', [$group, $member])) {
            return repository_result(403);
        }
        $toggle = function () use ($group, $member) {
            // Se o membro é coordenador do grupo e estiver saindo,
            // deve ser removido da coordenação.
            $isCoordinator = $group->coordinators
                ->contains('member_user_id', $member->user_id);

            if ($isCoordinator) {
                $group->coordinators()
                    ->detach($member->user_id);
            }
            $group->members()
                ->toggle($member->user_id);
        };

        try {
            // Tenta alternar.
            DB::transaction($toggle);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.groups.member_toggled'), [
            'group' => $group,
            'member' => $member
        ]);
    }

    /**
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int|string  $groupId
     * @param  int|string  $memberUserId
     * @return stdClass
     */
    public function detach(User $user, $groupId, $memberUserId)
    {
        $group = Group::findOrFail($groupId);
        $member = Member::findOrFail($memberUserId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('detachMember', [$group, $member])) {
            return repository_result(403);
        }
        $detach = function () use ($group, $member) {
            // Se o membro é coordenador do grupo e estiver saindo,
            // deve ser removido da coordenação.
            $isCoordinator = $group->coordinators
                ->contains('member_user_id', $member->user_id);

            if ($isCoordinator) {
                $group->coordinators()
                    ->detach($member->user_id);
            }            
            $group->members()
                ->detach($member->user_id);
        };

        try {
            // Tenta remover.
            DB::transaction($detach);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.groups.member_detached'), [
            'group' => $group,
            'member' => $member
        ]);
    }

    /**
     * Tenta aprovar membros no grupo.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int|string  $groupId
     * @param  null|int|string  $memberUserId
     * @return stdClass
     */
    public function approve(User $user, $groupId, $memberUserId = null)
    {
        $group = Group::findOrFail($groupId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('updateRequests', [Member::class, $group])) {
            return repository_result(403);
        }
        $members = $memberUserId ?
            $group->membersNotApproved()
                ->where('user_id', $memberUserId)
                ->get() :
            $group->membersNotApproved()
                ->get();

        $approve = function () use ($user, $group, $members) {
            $members->map(function ($member) use ($group) {
                return $group->membersNotApproved()
                    ->updateExistingPivot($member->user_id, [
                        'is_approved' => true
                    ]);
            });
        };

        try {
            // Tenta atualizar.
            DB::transaction($approve);
        } catch (Exception $exception) {
            return repository_result(500);
        }
        $message = __('messages.groups.'.(
            $members->count() > 1 ? 'members_approved' : 'member_approved'
        ));

        return repository_result(200, $message, [
            'group' => $group
        ]);
    }

    /**
     * Tenta recusar membros no grupo.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int|string  $groupId
     * @param  null|int|string  $memberUserId
     * @return stdClass
     */
    public function deny(User $user, $groupId, $memberUserId = null)
    {
        $group = Group::findOrFail($groupId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('updateRequests', [Member::class, $group])) {
            return repository_result(403);
        }
        $members = $memberUserId ?
            $group->members()
                ->where('user_id', $memberUserId)
                ->get() :
            $group->members()
                ->get();

        $deny = function () use ($user, $group, $members) {
            $members->map(function ($member) use ($group) {
                return $group->members()
                    ->detach($member->user_id);
            });
        };

        try {
            // Tenta recusar.
            DB::transaction($deny);
        } catch (Exception $exception) {
            return repository_result(500);
        }
        $message = __('messages.groups.'.(
            $members->count() > 1 ? 'members_denied' : 'member_denied'
        ));

        return repository_result(200, $message, [
            'group' => $group
        ]);
    } 
}
