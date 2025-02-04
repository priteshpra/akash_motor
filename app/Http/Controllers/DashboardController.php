<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Carbon\Carbon;


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
        // Get last 6 months' data
        $months = collect(range(0, 5))->map(function ($i) {
            return Carbon::now()->subMonths($i)->format('F Y');
        })->reverse()->values();

        $monthlyProducts = $months->map(function ($month) {
            return Product::whereMonth('created_at', Carbon::parse($month)->month)
                ->whereYear('created_at', Carbon::parse($month)->year)
                ->count();
        });

        $monthlyCategories = $months->map(function ($month) {
            return Category::whereMonth('created_at', Carbon::parse($month)->month)
                ->whereYear('created_at', Carbon::parse($month)->year)
                ->count();
        });

        $monthlySubCategories = $months->map(function ($month) {
            return SubCategory::whereMonth('created_at', Carbon::parse($month)->month)
                ->whereYear('created_at', Carbon::parse($month)->year)
                ->count();
        });


        return view('dashboard.dashboard', [
            'data' => $data,
            'current' => $currentUserData,
            'productCount' => $productCount,
            'categoryCount' => $categoryCount,
            'subCategoryCount' => $subCategoryCount,
            'months' => $months,
            'monthlyProducts' => $monthlyProducts,
            'monthlyCategories' => $monthlyCategories,
            'monthlySubCategories' => $monthlySubCategories
        ]);
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
