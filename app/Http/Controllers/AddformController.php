<?php

namespace App\Http\Controllers;

use App\Models\ProductAddData;
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
            'subcategory_name' => 'required',
            'typeOption' => 'required',
        ]);

        // Get common fields (like GST)
        $category_id = $request->input('category_id');
        $product_id = $request->input('product_id');
        $flangeValue = ($request->input('Footval')) ? '' : $request->input('flange');
        $Footval = $request->input('Footval');

        // Process each tax and flange value
        foreach ($request->input('subcategory_name') as $index => $subCatValue) {

            ProductAddData::create(
                // Matching conditions (update if these match)
                ['category_id' => $category_id, 'subcategory_id' => $subCatValue, 'product_id' => $product_id, 'flange' => $flangeValue, 'footval' => $Footval],
                // Fields to update or create
                // ['flange' => $flangeValue, 'footval' => $Footval]
            );
        }

        // Tax::create($request->except('_token'));
        return response()->json(['success' => 'Product added successfully']);
    }
}
