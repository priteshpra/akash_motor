<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;

class AddformController extends Controller
{
    public function index(Request $request)
    {
        $userID = $request->session()->get('userID');
        $userModel = new \App\Models\UserModel();
        $data = $userModel->allUsers();
        $currentUserData = $userModel->getUserbyID($userID);
        return view('dashboard.add', ['data' => $data, 'current' => $currentUserData]);
    }
}
