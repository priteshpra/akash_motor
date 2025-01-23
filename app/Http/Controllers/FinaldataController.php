<?php

namespace App\Http\Controllers;

use App\Models\ProductAddData;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\CategoryController;

class FinaldataController extends Controller
{
    public function add(request $request, $product_id)
    {
        // dd(['request' => $request->all(), 'productId' => $product_id]);
        $categoryController = new CategoryController();
        $userID = $request->session()->get('userID');
        $userModel = new \App\Models\UserModel();
        $data = $userModel->allUsers();
        $current = $userModel->getUserbyID($userID);
        $products = \App\Models\Product::where('status', '1')->where('id', $product_id)->get();
        $categoriesResponse = $categoryController->geCategorys($product_id);
        $categories = $categoriesResponse->getData(true);
        // Format data for select dropdown
        $options = '<option value="">Select Category</option>';
        foreach ($categories as $id => $name) {
            $options .= '<option value="' . $id . '">' . $name . '</option>';
        }
        // dd($options);
        $taxs = \App\Models\Tax::where('status', '1')->get();
        return view('dashboard.finaldata.index', compact('products', 'data', 'current', 'taxs', 'options'));
    }
}
