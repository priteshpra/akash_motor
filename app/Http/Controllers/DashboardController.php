<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\UserModel;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userID = $request->session()->get('userID');
        $userModel = new \App\Models\UserModel();
        $data = $userModel->allUsers();
        $currentUserData = $userModel->getUserbyID($userID);
        $productCount = Product::where('status', 1)->count();
        $categoryCount = Category::where('status', 1)->count();
        $subCategoryCount = SubCategory::where('status', 1)->count();
        return view('dashboard.dashboard', ['data' => $data, 'current' => $currentUserData, 'productCount' => $productCount, 'categoryCount' => $categoryCount, 'subCategoryCount' => $subCategoryCount]);
    }

    public function deleteUSer($userID)
    {
        $userModel = new \App\Models\UserModel();
        $data = $userModel->deleteUser($userID);
        if ($data) {
            return redirect('/dashboard')->with('response', ['status' => 200, 'message' => "User deleted succesfully!"]);
        } else {
            return redirect('/dashboard')->with('response', ['status' => 400, 'message' => "Something went wrong!"]);
        }
    }
}
