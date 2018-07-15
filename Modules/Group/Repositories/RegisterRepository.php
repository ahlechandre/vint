<?php

namespace Modules\Group\Repositories;

use Exception;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\DB;
use Modules\Group\Entities\Invite;
use Modules\System\Entities\Role;
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
            // Papel de membro.
            $role = Role::member()
                ->first();
            // Tipo do novo membro.
            $memberType = MemberType::findOrFail(
                $inputs['member']['member_type_id']
            );
            // Cria o usuário do membro.
            $user = $role->users()
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
            if ($memberType->isServant()) {
                return $member->servant()
                    ->create($inputs['servant']);
            }

            // Se o novo membro é aluno.
            if ($memberType->isStudent()) {
                return $member->student()
                    ->create($inputs['student']);
            }

            // Se o novo membro é colaborador.
            if ($memberType->isCollaborator()) {
                return $member->collaborator()
                    ->create();
            }
        };

        try {
            // Tenta criar.
            DB::transaction($store);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.register.created'), [
            'member' => $member
        ]);
    }
}
