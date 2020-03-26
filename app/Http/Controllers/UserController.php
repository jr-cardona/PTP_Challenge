<?php

namespace App\Http\Controllers;

use Config;
use Exception;
use App\Entities\User;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use App\Actions\Users\GetUsersAction;
use App\Http\Requests\SaveUserRequest;
use App\Actions\Users\StoreUsersAction;
use Spatie\Permission\Models\Permission;
use App\Actions\Users\UpdateUsersAction;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Auth\Access\AuthorizationException;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the resource.
     * @param GetUsersAction $action
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function index(GetUsersAction $action, Request $request)
    {
        $users = $action->execute(new User(), $request);

        if($format = $request->get('format')){
            $this->authorize('export', User::class);
            return (new UsersExport($users->get()))
                ->download('users-list.' . $format);
        }

        $paginate = Config::get('constants.paginate');
        $count = $users->count();
        $users = $users->paginate($paginate);

        return response()->view('users.index', compact(
                'users', 'request', 'count', 'paginate')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param User $user
     * @return Response
     */
    public function create(User $user)
    {
        $roles = Role::pluck('name', 'id');
        $permissions = Permission::pluck('name', 'id');

        return response()->view('users.create', compact('user', 'roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUsersAction $action
     * @param SaveUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUsersAction $action, SaveUserRequest $request)
    {
        $user = $action->execute(new User(), $request);

        return redirect()->route('users.show', $user)
            ->with('success', ('Usuario creado satisfactoriamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return RedirectResponse|Response
     */
    public function show(User $user)
    {
        if ($user->isClient()) return redirect()->route('clients.show', $user->client);

        return response()->view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return RedirectResponse|Response
     */
    public function edit(User $user)
    {
        if ($user->isClient()) return redirect()->route('clients.edit', $user->client);

        $roles = Role::pluck('name', 'id');
        $permissions = Permission::pluck('name', 'id');

        return response()->view('users.edit', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUsersAction $action
     * @param SaveUserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUsersAction $action, User $user,
                           SaveUserRequest $request)
    {
        $user = $action->execute($user, $request);

        return redirect()->route('users.show', $user)
            ->with('success', ('Usuario actualizado satisfactoriamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', ('Usuario eliminado satisfactoriamente'));
    }

    /**
     * @param User $user
     * @return Response
     * @throws AuthorizationException
     */
    public function editPassword(User $user){
        $this->authorize('update', $user);

        return response()->view('users.edit-password', compact('user'));
    }

    /**
     * @param User $user
     * @param ChangePasswordRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function updatePassword(User $user, ChangePasswordRequest $request){
        $this->authorize('update', $user);

        $user->password = $request->input('password');
        $user->update();

        if ($user->isClient()) return redirect()->route('clients.show', $user->client)
            ->with('success', ('Contraseña actualizada satisfactoriamente'));

        return redirect()->route('users.show', $user)
            ->with('success', ('Contraseña actualizada satisfactoriamente'));
    }
}
