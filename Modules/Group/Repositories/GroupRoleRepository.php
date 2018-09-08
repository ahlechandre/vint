<?php

namespace Modules\Group\Repositories;

use Exception;
use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Illuminate\Support\Facades\DB;

class GroupRoleRepository
{
    /**
     * Tenta atualizar um papel do grupo.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int  $groupId
     * @param  int  $groupRoleId
     * @param  array  $inputs
     * @return stdClass
     */
    public function update(User $user, $groupId, $groupRoleId, array $inputs)
    {
        $group = Group::findOrFail($groupId);
        $groupRole = $group->groupRoles()
            ->findOrFail($groupRoleId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $groupRole)) {
            return repository_result(403);
        }
        $update = function () use ($inputs, $groupRole) {
            $groupRole->permissions()
                ->sync($inputs['permissions'] ?? []);
        };


        try {
            // Tenta atualizar.
            DB::transaction($update);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.group_roles.updated'), [
            'group' => $group,
            'groupRole' => $groupRole
        ]);
    }
}
