<?php

namespace Modules\Group\Repositories;

use Exception;
use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Illuminate\Support\Facades\DB;

class CoordinatorRepository
{
    /**
     * Tenta adicionar um coordenador no grupo.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int  $groupId
     * @param  array  $inputs
     * @return stdClass
     */
    public function store(User $user, $groupId, array $inputs)
    {
        $group = Group::findOrFail($groupId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('createCoordinators', $group)) {
            return api_response(403);
        }
        $store = function () use ($inputs, $group) {
            $group->coordinators()
                ->attach($inputs['coordinator_user_id'], [
                    'is_vice' => $inputs['is_vice']
                ]);
        };

        try {
            // Tenta adicionar.
            DB::transaction($store);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.coordinators.created'), [
            'group' => $group,
        ]);
    }

    /**
     * Tenta atualizar um convite do grupo.
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

        // Verifica se o usuário pode realizar.
        if ($user->cant('updateCoordinators', $group)) {
            return api_response(403);
        }
        $update = function () use ($inputs, $group, $id) {
            $group->coordinators()
                ->updateExistingPivot($id, [
                    'is_vice' => $inputs['is_vice']
                ]);
        };

        try {
            // Tenta atualizar.
            DB::transaction($update);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.coordinators.updated'), [
            'group' => $group
        ]);
    }

    /**
     * Tenta remover um convite.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int  $groupId
     * @param  int  $id
     * @return stdClass
     */
    public function destroy(User $user, $groupId, $id)
    {
        $group = Group::findOrFail($groupId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('deleteCoordinators', $group)) {
            return api_response(403);
        }
        $destroy = function () use ($group, $id) {
            $group->coordinators()
                ->detach($id);
        };

        try {
            // Tenta atualizar.
            DB::transaction($destroy);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.coordinators.deleted'), [
            'group' => $group
        ]);
    }    
}
