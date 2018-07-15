<?php

namespace Modules\Group\Repositories;

use Exception;
use Illuminate\Support\Str;
use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Illuminate\Support\Facades\DB;
use Modules\Group\Entities\Invite;

class InviteRepository
{
    /**
     * Tenta criar um novo convite no grupo.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int  $groupId
     * @param  array  $inputs
     * @return stdClass
     */
    public function store(User $user, $groupId, array $inputs)
    {
        $group = Group::findOrFail($groupId);
        $invite = null;

        // Verifica se o usuário pode realizar.
        if ($user->cant('create', [Invite::class, $group])) {
            return api_response(403);
        }
        $store = function () use ($user, $inputs, $group, &$invite) {
            $token = Str::random(Invite::TOKEN_LENGTH);
            $invite = $group->invites()
                ->create(array_merge($inputs, [
                    'token' => $token,
                    'user_id' => $user->id
                ]));
        };

        try {
            // Caso o token gerado já exista no banco, uma exceção
            // deverá ser gerada pois o campo é unico. 
            // Assim, um segundo parâmetro é passado para a função 
            // de transação para tentar criar por 5 vezes o convite,
            // em caso de falha.
            DB::transaction($store, 5);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.invites.created'), [
            'group' => $group,
            'invite' => $invite
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
        $invite = $group->invites()
            ->findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $invite)) {
            return api_response(403);
        }
        $update = function () use ($user, $inputs, $invite) {
            $invite->update([
                'expires_at' => $inputs['expires_at']
            ]);
        };

        try {
            // Tenta atualizar.
            DB::transaction($update);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.invites.updated'), [
            'group' => $group,
            'invite' => $invite
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
        $invite = $group->invites()
            ->findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('delete', $invite)) {
            return api_response(403);
        }
        $destroy = function () use ($invite) {
            $invite->delete();
        };

        try {
            // Tenta atualizar.
            DB::transaction($destroy);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.invites.deleted'), [
            'group' => $group
        ]);
    }    
}
