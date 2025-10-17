<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repository\UserRepository;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    protected $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = $this->repo->getAll($search, 5);

        return view('Pages.User.index', compact('users', 'search'));
    }

    public function store(StoreUserRequest $request)
    {
        $this->repo->create($request->validated());
        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->repo->update($user, $request->validated());
        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $this->repo->delete($user);
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
