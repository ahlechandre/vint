<?php

namespace Modules\Group\Repositories;

use Exception;
use Illuminate\Support\Str;
use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Illuminate\Support\Facades\DB;
use Modules\Group\Entities\Invite;

class GroupRoleRepository
{
    /**
     * Tenta atualizar um papel do grupo.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int  $groupId
     * @param  int  $id
     * @param  array  $inputs
     * @return stdClass
     */
    public function update(User $user, $groupId, $id, array $inputs)
    {
        $group = Group::findOrFail($groupId);
        $groupRole = $group->groupRoles()
            ->findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $groupRole)) {
            return api_response(403);
        }
        $update = function () use ($inputs, $groupRole) {
            $groupRole->permissions()
                ->sync($inputs['permissions'] ?? []);
        };

        DB::transaction($update);

        try {
            // Tenta atualizar.
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.group_roles.updated'), [
            'group' => $group,
            'groupRole' => $groupRole
        ]);
    }
}
