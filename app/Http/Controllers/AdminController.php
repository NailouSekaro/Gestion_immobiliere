<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function index() {
    $users = User::all()->except(Auth::id());
    return view('admin.users.index', compact('users'));
}
}
