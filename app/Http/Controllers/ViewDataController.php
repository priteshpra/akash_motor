<?php

namespace App\Http\Controllers;

use App\Models\ProductAddData;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ViewDataController extends Controller
{
    public function list(request $request)
    {
        $userID = $request->session()->get('userID');
        $userModel = new \App\Models\UserModel();
        $data = $userModel->allUsers();
        $current = $userModel->getUserbyID($userID);
        $products = \App\Models\Product::where('status', '1')->get();
        return view('dashboard.viewdata.index', compact('products', 'data', 'current'));
    }
}
