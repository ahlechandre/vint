<?php

namespace Modules\Group\Repositories;

use Exception;
use Modules\User\Entities\User;
use Modules\Group\Entities\Role;
use Illuminate\Support\Facades\DB;
use Modules\Group\Entities\Invite;
use Modules\Group\Entities\Member;
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
        $member = null;
        $store = function () use ($inputs, &$member) {
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
            // Cria o membro.
            $member = $user->member()
                ->create($inputs['member']);
            // Associa o novo membro aos grupos indicados.
            $member->groups()
                ->sync($inputs['member']['groups']);

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
            return repository_result(500);
        }

        return repository_result(200, __('messages.register.created'), [
            'member' => $member
        ]);
    }
}
