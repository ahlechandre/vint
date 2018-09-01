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
            $group->members()
                ->toggle($member->user_id);
        };

        try {
            // Tenta alternar.
            DB::transaction($toggle);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.groups.members.toggle'), [
            'group' => $group,
            'member' => $member
        ]);
    }
}
