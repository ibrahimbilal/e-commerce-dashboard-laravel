<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ManagesTrashedRecords;
use App\Models\User;
use App\Support\IndexListing;
use App\Support\StoredMediaCleanup;
use App\Support\UserForceDeleteGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use ManagesTrashedRecords;

    public function __construct()
    {
        $this->middleware('permission:view users', ['only' => ['index', 'show']]);
        $this->middleware('permission:add users', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit users', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete users', ['only' => ['destroy']]);
        $this->registerTrashedMiddleware('users');
    }

    public function index(Request $request)
    {
        $filterKeys = ['search', 'trashed', 'role'];
        $filters = IndexListing::activeFilters($request, $filterKeys);

        $counts = [
            'all' => User::query()->count(),
            'trashed' => User::query()->onlyTrashed()->count(),
        ];

        foreach (Role::query()->where('guard_name', 'web')->orderBy('name')->pluck('name') as $roleName) {
            $counts[$roleName] = User::query()->role($roleName)->count();
        }

        $query = User::with('roles');

        if ($request->query('trashed') === '1') {
            $query->onlyTrashed();
        }

        if ($role = $request->query('role')) {
            $query->role($role);
        }

        if ($search = $request->query('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('email', 'like', '%'.$search.'%')
                    ->orWhere('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%');
            });
        }

        $users = $query->latest('id')->get();

        return view('users.index', compact('users', 'counts', 'filters'));
    }

    public function create()
    {
        $roles = Role::query()->where('guard_name', 'web')->orderBy('name')->get();

        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:50', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'first_name' => ['nullable', 'string', 'max:50'],
            'last_name' => ['nullable', 'string', 'max:50'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'profile_picture' => ['nullable', 'string', 'max:191'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', Rule::exists('roles', 'name')->where('guard_name', 'web')],
        ]);

        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'mobile' => $data['mobile'] ?? null,
            'profile_picture' => $data['profile_picture'] ?? null,
        ]);

        $user->markEmailAsVerified();

        $user->syncRoles($data['roles'] ?? []);

        return redirect()->route('users.show', $user)->with('status', 'User created.');
    }

    public function show(User $user)
    {
        $user->load('roles');

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $user->load('roles');
        $roles = Role::query()->where('guard_name', 'web')->orderBy('name')->get();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:50', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'string', 'min:8'],
            'first_name' => ['nullable', 'string', 'max:50'],
            'last_name' => ['nullable', 'string', 'max:50'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'profile_picture' => ['nullable', 'string', 'max:191'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', Rule::exists('roles', 'name')->where('guard_name', 'web')],
        ]);

        $payload = [
            'email' => $data['email'],
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'mobile' => $data['mobile'] ?? null,
            'profile_picture' => $data['profile_picture'] ?? null,
        ];

        if (! empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        $user->update($payload);
        $user->syncRoles($data['roles'] ?? []);

        return redirect()->route('users.show', $user)->with('status', 'User updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('status', 'User deleted.');
    }

    public function restore(Request $request, int $id)
    {
        $user = $this->findOnlyTrashed(User::class, $id);
        $user->restore();

        return $this->trashedActionResponse($request, 'users.index', 'User restored.');
    }

    public function forceDelete(Request $request, int $id)
    {
        $user = $this->findOnlyTrashed(User::class, $id);

        if ($blocked = UserForceDeleteGuard::blockIfForbidden($request, $user, $request->user())) {
            return $blocked;
        }

        StoredMediaCleanup::deleteUserAvatar($user);
        $user->forceDelete();

        return $this->trashedActionResponse($request, 'users.index', 'User permanently deleted.');
    }
}
