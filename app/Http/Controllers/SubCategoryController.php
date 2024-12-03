<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userID = $request->session()->get('userID');
        $userModel = new \App\Models\UserModel();
        $data = $userModel->allUsers();
        $current = $userModel->getUserbyID($userID);

        if (request()->ajax()) {
            $categories = SubCategory::select(['sub_categories.id', 'sub_categories.subcategory_name', 'sub_categories.category_id', 'sub_categories.product_id', 'products.product_name', 'categories.category_name', 'sub_categories.created_at'])->leftJoin('products', 'products.id', '=', 'sub_categories.product_id')->leftJoin('categories', 'categories.id', '=', 'sub_categories.category_id');
            return DataTables::of($categories)->make(true);
        }
        return view('dashboard.categories.index', compact('categories', 'data', 'current'));
    }

    public function geSubCategorys($category_id)
    {
        $subcat = SubCategory::where('category_id', $category_id)->pluck('subcategory_name', 'id');
        return response()->json($subcat);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'subcategory_name' => 'required|string|max:255',
            'category_id' => 'required',
            'product_id' => 'required'
        ]);

        SubCategory::create($request->except('_token'));
        return response()->json(['success' => 'Sub-Category added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subCategory)
    {
        //
    }
}
