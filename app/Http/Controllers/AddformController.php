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
            $products = ProductAddData::select('products_add_data.*', 'categories.category_name', 'sub_categories.subcategory_name', 'products.product_name')
                ->leftJoin('categories', 'categories.id', '=', 'products_add_data.category_id')
                ->leftJoin('sub_categories', 'sub_categories.id', '=', 'products_add_data.subcategory_id')
                ->leftJoin('products', 'products.id', '=', 'products_add_data.product_id')
                ->where('products_add_data.status', '1')->get();
            // ' . route('addform.edit', $product->id) . '
            return DataTables::of($products)
                ->addColumn('action', function ($product) {
                    return '
                <a href="" onClick="getFormData(' . $product->id . ')" id="edit_form_' . $product->id . '" class="btn btn-sm btn-primary"  data-bs-toggle="modal"
                                    data-bs-target="#editFormModal">Edit</a>

                  <form action="' . route('addform.delete', $product->id) . '" method="POST" style="display:inline;">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
            </form>';
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
        $flangePercentage = $request->input('flange');
        $Footval = $request->input('Footval');
        $Flangeval = $request->input('Flangeval');
        $size = $request->input('size');
        $typeOption = $request->input('typeOption', []);
        $typeOption = is_array($typeOption) ? implode(', ', $typeOption) : $typeOption;
        // Process each tax and flange value
        foreach ($request->input('subcategory_val') as $index => $subCatValues) {
            $subCatId = $request->input('subcategory_id')[$index] ?? null;
            DB::enableQueryLog();
            ProductAddData::create(
                // Matching conditions (update if these match)
                ['category_id' => $category_id, 'subcategory_val' => $subCatValues, 'subcategory_id' => $subCatId, 'product_id' => $product_id, 'flange_percentage' => $flangePercentage, 'flange_val' => $Flangeval, 'footval' => $Footval, 'size' => $size, 'typeOption' => $typeOption],
                // Fields to update or create
                // ['flange' => $flangeValue, 'footval' => $Footval]
            );
            // dd(DB::getQueryLog());
        }

        // Tax::create($request->except('_token'));
        return response()->json(['success' => 'Product added successfully']);
    }

    public function edit(Request $request, $id)
    {
        $products = ProductAddData::leftJoin('categories', 'categories.id', '=', 'products_add_data.category_id')
            ->leftJoin('sub_categories', 'sub_categories.id', '=', 'products_add_data.subcategory_id')
            ->leftJoin('products', 'products.id', '=', 'products_add_data.product_id')->where('products_add_data.id', $request->ID)->first();
        return response()->json(['success' => 'Product added successfully', 'data' => $products]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'subcategory_val' => 'required',
            'typeOption' => 'required',
        ]);
        $input = $request->all();

        $cms = ProductAddData::find($id);
        $cms->category_id = $request->category_id;
        $cms->subcategory_val = $request->subcategory_val;
        $cms->typeOption = $request->typeOption;
        $cms->save();
        // dd($request);



        // Get common fields (like GST)
        $category_id = $request->input('category_id');
        $product_id = $request->input('product_id');
        $flangePercentage = ($request->input('Footval')) ? '' : $request->input('flange');
        $Footval = $request->input('Footval');
        $Flangeval = $request->input('Flangeval');
        // Process each tax and flange value
        $productsData = ProductAddData::find($id);
        foreach ($request->input('subcategory_val') as $index => $subCatValues) {
            $subCatId = $request->input('subcategory_id')[$index] ?? null;
            DB::enableQueryLog();
            $productsData->category_id = $category_id;
            $productsData->subcategory_val = $subCatValues;
            $productsData->subcategory_id = $subCatId;
            $productsData->product_id = $product_id;
            $productsData->flange_percentage = $flangePercentage;
            $productsData->flange_val = $Flangeval;
            $productsData->footval = $Footval;
            $productsData->save();
        }

        // Tax::create($request->except('_token'));
        return response()->json(['success' => 'Product updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = ProductAddData::find($id);
        $banner->status = 0;
        $banner->save();
        return redirect()->back()->with('success', 'Products deleted Successfully!');
    }

    public function geSubCordinate($category_id, $product_id)
    {
        // DB::enableQueryLog();

        $subcat = ProductAddData::leftJoin('sub_categories', 'sub_categories.id', '=', 'products_add_data.subcategory_id')
            ->where('products_add_data.subcategory_id', $category_id)->pluck('products_add_data.subcategory_val', 'sub_categories.id');
        $queryLog = DB::getQueryLog();
        // dd(end($queryLog));
        return response()->json($subcat);
    }

    public function geSubCategory($category_id, $product_id)
    {
        // DB::enableQueryLog();

        $subcat = ProductAddData::leftJoin('sub_categories', 'sub_categories.id', '=', 'products_add_data.subcategory_id')
            ->where('products_add_data.category_id', $category_id)->where('products_add_data.status', '1')->distinct()->get();
        $groupedSubcat = $subcat->groupBy('subcategory_name');
        // Structure the response
        $response = $groupedSubcat->map(function ($items, $name) {
            // Use the first item for fixed fields like `flange_percentage`, `footval`, `typeOption`
            $firstItem = $items->first();

            // Consolidate options
            $options = $items->map(function ($item) {
                return [
                    'value' => $item->subcategory_val,
                    'label' => $item->subcategory_val
                ];
            });

            return [
                'id' => $firstItem->subcategory_id,
                'name' => $name,
                'flange_percentage' => $firstItem->flange_percentage,
                'footval' => $firstItem->footval,
                'typeOption' => $firstItem->typeOption,
                'options' => $options->unique('value')->values()
            ];
        })->values();
        $queryLog = DB::getQueryLog();
        // dd(end($queryLog));
        // dd($subcat);
        return response()->json($response);
    }
}
