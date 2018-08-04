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
    static public $perPage = 10;

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
    public function edit(Request $request, $id)
    {
        $user = $request->user();
        $userToEdit = User::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $userToEdit)) {
            return abort(403);
        }
        $userTypes = UserType::ofUser($user)
            ->forUsersForm()
            ->get();

        return view('user::pages.users.edit', [
            'userToEdit' => $userToEdit,
            'userTypes' => $userTypes,
        ]);
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

        return redirect("users/{$id}")
            ->with('snackbar', $update->message);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function editPassword(Request $request, $id)
    {
        $user = $request->user();
        $userToEdit = User::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $userToEdit)) {
            return abort(403);
        }
        
        return view('user::pages.users.edit-password', [
            'userToEdit' => $userToEdit
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\User\Http\Requests\UserRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(UserPasswordRequest $request, $id)
    {
        $user = $request->user();
        $inputs = $request->all();
        $update = $this->users
            ->updatePassword($user, (int) $id, $inputs);

        return redirect("users/{$id}?section=security")
            ->with('snackbar', $update->message);
    }
}
