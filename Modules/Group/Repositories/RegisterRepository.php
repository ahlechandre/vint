<?php

namespace Modules\Group\Repositories;

use Exception;
use Modules\User\Entities\User;
use Modules\Group\Entities\Role;
use Illuminate\Support\Facades\DB;
use Modules\Group\Entities\Invite;
use Modules\User\Entities\UserType;
use Modules\Group\Entities\MemberType;

class RegisterRepository
{
    /**
     * Tenta criar um novo membro.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  array  $inputs
     * @return stdClass
     */
    public function store(array $inputs)
    {
        $invite = Invite::notExpired()
            ->where('token', $inputs['invite_token'])
            ->firstOrFail();
        $member = null;
        $store = function () use ($inputs, $invite, &$member) {
            // Tipo de usuário membro.
            $userType = UserType::member()
                ->first();
            // Papel do novo membro.
            $role = Role::findOrFail(
                $inputs['member']['role_id']
            );
            // Cria o usuário do membro.
            $user = $userType->users()
                ->create($inputs);
            // Cria o membro no grupo do convite.
            $member = $user->member()
                ->create(array_merge(
                    $inputs['member'],
                    [
                        'group_id' => $invite->group_id
                    ]
                ));

            // Se o novo membro é servidor.
            if ($role->isServant()) {
                return $member->servant()
                    ->create($inputs['servant']);
            }

            // Se o novo membro é aluno.
            if ($role->isStudent()) {
                return $member->student()
                    ->create($inputs['student']);
            }

            // Se o novo membro é colaborador.
            if ($role->isCollaborator()) {
                return $member->collaborator()
                    ->create();
            }
        };

        DB::transaction($store);
        try {
            // Tenta criar.
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.register.created'), [
            'member' => $member
        ]);
    }
}
