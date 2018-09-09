<?php

namespace Modules\Member\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Member\Repositories\MemberRepository;
use Modules\Member\Transformers\MemberResource;
use Modules\Member\Entities\Member;

class MemberController extends Controller
{
    /**
     * Repositório de dados.
     *
     * @var \Modules\Member\Repositories\MemberRepository
     */
    protected $members;

    /**
     * Quantidade de recursos por página.
     *
     * @var int
     */
    static public $perPage = 10;

    /**
     * Inicializa o controlador com a instância do repositório de dados.
     *
     * @param \Modules\Member\Repositories\MemberRepository $members
     * @return void
     */
    public function __construct(MemberRepository $members)
    {
        $this->members = $members;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forUser(Request $request)
    {
        $perPage = $request->query('per-page', self::$perPage);
        $query = $request->query('q');
        $user = $request->user();
        $forUser = $this->members
            ->forUser($user, $perPage, $query);
        $members = $forUser->data['members'];

        return MemberResource::collection($members);
    }
}
