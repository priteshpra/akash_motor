<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
class DashboardController extends Controller
{
    public function index(Request $request){
       $userID = $request->session()->get('userID');
       $userModel = new \App\Models\UserModel();
        $data = $userModel->allUsers();
        $currentUserData = $userModel->getUserbyID($userID);
        return view('dashboard.dashboard', ['data' => $data, 'current' => $currentUserData]);
    }

    public function deleteUSer($userID){
        $userModel = new \App\Models\UserModel();
        $data = $userModel->deleteUser($userID);
        if ($data) {
            return redirect('/dashboard')->with('response', ['status' => 200, 'message' => "User deleted succesfully!"]);
        } else {
            return redirect('/dashboard')->with('response', ['status' => 400, 'message' => "Something went wrong!"]);
        }
    }
}
