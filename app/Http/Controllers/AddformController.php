<?php

namespace App\Http\Controllers;

use App\Models\ProductAddData;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Carbon\Carbon;
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
                <a href="" onClick="getFormData(' . $product->id . ', ' . $product->product_id . ')" id="edit_form_' . $product->id . '" class="btn btn-sm btn-primary"  data-bs-toggle="modal"
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
        $Footval = $request->input('Footval');
        $Flangeval = $request->input('Flangeval');
        $size = $request->input('size');
        $typeOption = $request->input('typeOption', []);
        $typeOption = is_array($typeOption) ? implode(', ', $typeOption) : $typeOption;
        // $flangePercentage = '';
        // if ($typeOption == 'Flange') {
        //     $flangePercentage = $request->input('flange');
        // }
        $flangePercentage = strpos($typeOption, 'Flange') !== false ? $request->input('flange') : '';
        // Process each tax and flange value
        foreach ($request->input('subcategory_val') as $index => $subCatValues) {
            $subCatId = $request->input('subcategory_id')[$index] ?? null;
            DB::enableQueryLog();
            ProductAddData::create(
                // Matching conditions (update if these match)
                ['category_id' => $category_id, 'subcategory_val' => $subCatValues, 'subcategory_id' => $subCatId, 'product_id' => $product_id, 'flange_percentage' => $flangePercentage, 'flange_val' => $Flangeval, 'footval' => $Footval, 'size' => $size, 'typeOption' => $typeOption, 'date' => date('Y-m-d H:i:s')],
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
        // dd($request);
        $typeOption = $request->input('typeOption', []);
        $typeOption = is_array($typeOption) ? implode(', ', $typeOption) : $typeOption;
        $cms = ProductAddData::find($id);
        $cms->category_id = $request->category_id;
        // $cms->subcategory_id = $request->subcategory_id[0];
        $cms->subcategory_val = $request->subcategory_val[0];
        $cms->typeOption = $typeOption;
        $cms->footval = $request->Footval;
        $cms->size = $request->size;
        $cms->flange_percentage = $request->flange_edit;
        $cms->save();

        return response()->json(['success' => 'Product updated successfully']);
    }

    public function massDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!empty($ids)) {
            ProductAddData::whereIn('id', $ids)->update(['status' => 0]);
            return response()->json(['success' => 'Records deleted successfully.']);
        }
        return response()->json(['error' => 'No IDs provided.'], 400);
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
            ->where('products_add_data.category_id', $category_id)->where('products_add_data.product_id', $product_id)->where('products_add_data.status', '1')->distinct()->get();
        $groupedSubcat = $subcat->groupBy('subcategory_name');
        // Structure the response
        $response = $groupedSubcat->map(function ($items, $name) {
            // Use the first item for fixed fields like `flange_percentage`, `footval`, `typeOption`
            $firstItem = $items->first();

            // Consolidate options
            $options = $items->map(function ($item) {
                return [
                    'value' => $item->date,
                    'label' => $item->subcategory_val
                ];
            });

            return [
                'id' => $firstItem->subcategory_id,
                'cat_id' => $firstItem->category_id,
                'name' => $name,
                'flange_percentage' => $firstItem->flange_percentage,
                'size' => $firstItem->size,
                'footval' => $firstItem->footval,
                'typeOption' => $firstItem->typeOption,
                'options' => $options->unique('label')->values()
            ];
        })->values();
        $queryLog = DB::getQueryLog();
        // dd(end($queryLog));
        // dd($subcat);
        return response()->json($response);
    }

    public function geSubValCategory($created_at, $product_id, $cat_id)
    {
        // DB::enableQueryLog();
        $subcat = ProductAddData::leftJoin('sub_categories', 'sub_categories.id', '=', 'products_add_data.subcategory_id')
            ->where('products_add_data.date', $created_at)->where('products_add_data.product_id', $product_id)->where('products_add_data.category_id', $cat_id)->where('products_add_data.status', '1')->distinct()->get();
        $groupedSubcat = $subcat->groupBy('subcategory_name');
        // Structure the response
        $response = $groupedSubcat->map(function ($items, $name) {
            // Use the first item for fixed fields like `flange_percentage`, `footval`, `typeOption`
            $firstItem = $items->first();

            // Consolidate options
            $options = $items->map(function ($item) {
                return [
                    'value' => $item->date
                ];
            });

            return [
                'id' => $firstItem->subcategory_id,
                'price' => $firstItem->footval,
                'size' => $firstItem->size,
                'typeOption' => $firstItem->typeOption,
                'flange_percentage' => $firstItem->flange_percentage,
                'options' => $options->unique('value')->values()
            ];
        })->values();
        $queryLog = DB::getQueryLog();
        // dd(end($queryLog));
        // dd($subcat);
        return response()->json($response);
    }
}
