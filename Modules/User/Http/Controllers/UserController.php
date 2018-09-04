<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Entities\User;
use Modules\User\Entities\UserType;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\UserRequest;
use Modules\User\Repositories\UserRepository;
use Modules\User\Http\Requests\UserPasswordRequest;
use Auth;
use Modules\Member\Entities\Role;

class UserController extends Controller
{
    /**
     * Repositório de dados.
     *
     * @var \Modules\User\Repositories\UserRepository
     */
    protected $users;

    /**
     * Quantidade de recursos por página.
     *
     * @var int
     */
    static public $perPage = 30;

    /**
     * Inicializa o controlador com a instância do repositório de dados.
     *
     * @param \Modules\User\Repositories\UserRepository $users
     * @return void
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $perPage = self::$perPage;
        $query = $request->get('q');
        $index = $this->users
            ->index($user, $perPage, $query);
        
        if (!$index->success) {
            return abort($index->status);
        }

        return view('user::pages.users.index', [
            'users' => $index->data['users']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = $request->user();

        // Verifica se o usuário pode realizar.
        if ($user->cant('create', User::class)) {
            return abort(403);
        }
        $userTypes = UserType::ofUser($user)
            ->forUsersForm()
            ->get();

        return view('user::pages.users.create', [
            'userTypes' => $userTypes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\User\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = $request->user();
        $inputs = $request->sanitize();
        $store = $this->users
            ->store($user, $inputs);
        $redirectTo = 'users/' . (
            $store->data['userCreated']->id ?? null
        );

        return redirect($redirectTo)
            ->with('snackbar', $store->message);
    }

    /**
     * Show the specified resource.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   string  $id
     * @return  \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        $userToShow = User::findOrFail($id);

        // Verifica se usuário pode realizar.
        if ($user->cant('view', $userToShow)) {
            return abort(403);
        }
        $section = $request->query('section', 'about');
        
        return view('user::pages.users.show', [
            'userToShow' => $userToShow,
            'section' => $section
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function settings(Request $request)
    {
        return $this->edit($request, $request->user()->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $user = $request->user();
        $userToEdit = User::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $userToEdit)) {
            return abort(403);
        }
        $section = $request->query('section', 'general');

        switch ($section) {
            case 'general': {
                $userTypes = UserType::ofUser($user)->get();

                return view('user::pages.users.settings', [
                    'userToEdit' => $userToEdit,
                    'userTypes' => $userTypes,
                ]);
            }
            case 'security': {
                return view('user::pages.users.settings-security', [
                    'userToEdit' => $userToEdit,
                ]);
            }
            case 'member': {

                // Verifica se o usuário a ser editado é membro.
                if (!$userToEdit->isMember()) {
                    return abort(404);
                }
                $roles = Role::all();

                return view('user::pages.users.settings-member', [
                    'userToEdit' => $userToEdit,
                    'roles' => $roles
                ]);
            }            
            default: {
                return abort(404);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\User\Http\Requests\UserRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = $request->user();
        $inputs = $request->sanitize();
        $update = $this->users
            ->update($user, (int) $id, $inputs);

        return redirect('dashboard')
            ->with('snackbar', $update->message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\User\Http\Requests\UserRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function password(UserPasswordRequest $request, $id)
    {
        $user = $request->user();
        $inputs = $request->all();
        $update = $this->users
            ->password($user, (int) $id, $inputs);

        // Se a senha for atualizada com sucesso e o usuário da requisição
        // for o mesmo do usuário atualizado, faz logout para refazer 
        // o login com a sua nova senha.
        if ($update->success && ($user->id === (int) $id)) {
            Auth::logout();

            return redirect('login')
                ->with('snackbar', $update->message);
        }

        return redirect("users/{$id}")
            ->with('snackbar', $update->message);
    }
}
