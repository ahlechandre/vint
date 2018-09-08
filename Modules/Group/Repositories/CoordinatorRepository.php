<?php

namespace Modules\Group\Repositories;

use Exception;
use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Illuminate\Support\Facades\DB;

class CoordinatorRepository
{
    
    /**
     * Lista os coordenadores do grupo.
     *
     * @param  int|string  $groupId
     * @param  null|int  $perPage
     * @param  null|int  $filter
     * @return stdClass
     */
    public function index($groupId, $perPage = null, $filter = null)
    {
        $group = Group::findOrFail($groupId);
        $coordinators = $group->coordinators()
            ->with('member.user')
            ->filterLike($filter)
            ->get();

        return repository_result(200, null, [
            'group' => $group,
            'coordinators' => $coordinators,
        ]);
    }

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
            return repository_result(403);
        }
        $store = function () use ($inputs, $group) {
            // Verifica se o coordenador indicado é um servidor do grupo.
            $coordinatorMember = $group->servantMembers()
                ->findOrFail($inputs['coordinator_user_id']);

            $group->coordinators()
                ->syncWithoutDetaching([
                    $coordinatorMember->user_id => [
                        'is_vice' => $inputs['is_vice']
                    ]                    
                ]);
        };

        try {
            // Tenta adicionar.
            DB::transaction($store);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.coordinators.created'), [
            'group' => $group,
        ]);
    }

    /**
     * Tenta atualizar um convite do grupo.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int  $groupId
     * @param  int  $coordinatorUserId
     * @param  array  $inputs
     * @return stdClass
     */
    public function update(User $user, $groupId, $coordinatorUserId, array $inputs)
    {
        $group = Group::findOrFail($groupId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('updateCoordinators', $group)) {
            return repository_result(403);
        }
        $update = function () use ($inputs, $group, $coordinatorUserId) {
            $group->coordinators()
                ->updateExistingPivot($coordinatorUserId, [
                    'is_vice' => $inputs['is_vice']
                ]);
        };

        try {
            // Tenta atualizar.
            DB::transaction($update);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.coordinators.updated'), [
            'group' => $group
        ]);
    }

    /**
     * Tenta remover um convite.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int  $groupId
     * @param  int  $coordinatorUserId
     * @return stdClass
     */
    public function destroy(User $user, $groupId, $coordinatorUserId)
    {
        $group = Group::findOrFail($groupId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('deleteCoordinators', $group)) {
            return repository_result(403);
        }
        $destroy = function () use ($group, $coordinatorUserId) {
            $group->coordinators()
                ->detach($coordinatorUserId);
        };

        try {
            // Tenta atualizar.
            DB::transaction($destroy);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.coordinators.deleted'), [
            'group' => $group
        ]);
    }    
}
