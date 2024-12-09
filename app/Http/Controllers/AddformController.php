<?php

namespace App\Http\Controllers;

use App\Models\ProductAddData;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AddformController extends Controller
{
    public function index(Request $request)
    {
        $userID = $request->session()->get('userID');
        $userModel = new \App\Models\UserModel();
        $data = $userModel->allUsers();
        $current = $userModel->getUserbyID($userID);

        if (request()->ajax()) {
            $products = ProductAddData::leftJoin('categories', 'categories.id', '=', 'products_add_data.category_id')
                ->leftJoin('sub_categories', 'sub_categories.id', '=', 'products_add_data.subcategory_id')
                ->leftJoin('products', 'products.id', '=', 'products_add_data.product_id')
                ->where('products_add_data.status', '1')->get();
            return DataTables::of($products)
                ->addColumn('action', function ($product) {
                    return '
                <a href="' . route('addform.edit', $product->id) . '" class="btn btn-sm btn-primary">Edit</a>
                <a href="' . route('addform.delete', $product->id) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</a>
            ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard.categories.index', compact('products', 'data', 'current'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'subcategory_val' => 'required',
            'typeOption' => 'required',
        ]);

        // Get common fields (like GST)
        $category_id = $request->input('category_id');
        $product_id = $request->input('product_id');
        $flangePercentage = ($request->input('Footval')) ? '' : $request->input('flange');
        $Footval = $request->input('Footval');
        $Flangeval = $request->input('Flangeval');
        // Process each tax and flange value
        foreach ($request->input('subcategory_val') as $index => $subCatValues) {
            $subCatId = $request->input('subcategory_id')[$index] ?? null;
            DB::enableQueryLog();
            ProductAddData::create(
                // Matching conditions (update if these match)
                ['category_id' => $category_id, 'subcategory_val' => $subCatValues, 'subcategory_id' => $subCatId, 'product_id' => $product_id, 'flange_percentage' => $flangePercentage, 'flange_val' => $Flangeval, 'footval' => $Footval],
                // Fields to update or create
                // ['flange' => $flangeValue, 'footval' => $Footval]
            );
            // dd(DB::getQueryLog());
        }

        // Tax::create($request->except('_token'));
        return response()->json(['success' => 'Product added successfully']);
    }
}
