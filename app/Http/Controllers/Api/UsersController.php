<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index() {
        $queryName = request('query');
        return User::where('name', 'LIKE', $queryName . '%')->take(5)->get(['id', 'name']);
    }
}
