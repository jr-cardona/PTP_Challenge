<?php

namespace App\Http\Controllers;

use Config;
use App\User;
use Exception;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Auth\Access\AuthorizationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('index', new User());

        $users = User::with([
            'invoices:id,creator_id',
            'client:id,user_id',
            'products:id,creator_id',
            'users:id,creator_id',
            'roles.permissions',
            'permissions'
        ])
            ->select(['users.id', 'users.name', 'users.surname', 'users.email'])
            ->leftJoin('clients as c', 'c.user_id', '=', 'users.id')
            ->id($request->get('id'))
            ->email($request->get('email'))
            ->whereNull('c.id')
            ->orderBy('name');

        if(! empty($request->get('format'))){
            return (new UsersExport($users->get()))
                ->download('users-list.'.$request->get('format'));
        } else {
            $paginate = Config::get('constants.paginate');
            $count = $users->count();
            $users = $users->paginate($paginate);

            return response()->view('users.index', [
                'users' => $users,
                'request' => $request,
                'count' => $count,
                'paginate' => $paginate,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function create(User $user)
    {
        $this->authorize('create', $user);
        $roles = Role::pluck('name', 'id');
        $permissions = DB::table('role_has_permissions as rp')
            ->join('permissions as p', 'p.id', '=', 'rp.permission_id')
            ->groupBy('rp.permission_id')
            ->pluck('p.name', 'p.id');

        return response()->view('users.create', [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreUserRequest $request, User $user)
    {
        $this->authorize('create', $user);

        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->creator_id = auth()->user()->id;
        $user->save();

        if ($user->hasRole('Admin')) $user->syncRoles($request->roles);

        return redirect()->route('users.show', $user)->withSuccess(__('Usuario creado satisfactoriamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     * @throws AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        if (isset($user->client)){
            return response()->view('clients.show', [
                'client' => $user->client,
            ]);
        }
        return response()->view('users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('edit', $user);
        $roles = Role::pluck('name', 'id');
        $permissions = DB::table('role_has_permissions as rp')
            ->join('permissions as p', 'p.id', '=', 'rp.permission_id')
            ->groupBy('rp.permission_id')
            ->pluck('p.name', 'p.id');

        return response()->view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('edit', $user);

        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        if ($request->filled('password')){
            $user->password = bcrypt($request->input('password'));
        }
        $user->update();

        if ($user->hasRole('Admin')) $user->syncRoles($request->roles);

        return redirect()->route('users.show', $user)->withSuccess(__('Usuario actualizado satisfactoriamente'));
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
        $this->authorize('delete', $user);

        if (! $user->canBeDeleted()){
            return redirect()->back()->withError(__('No se puede eliminar, tiene registros asociado'));
        }
        $user->delete();
        return redirect()->route('users.index')->withSuccess(__('Usuario eliminado satisfactoriamente'));
    }
}
