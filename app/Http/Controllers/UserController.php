<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $users = $this->model->orderBy('created_at', 'desc')->paginate(10);
        return view('Pages.User.index', compact('users'));
    }
}
