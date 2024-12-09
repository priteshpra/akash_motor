<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Tax;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
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
        $currentUserData = $userModel->getUserbyID($userID);
        $productCount = \App\Models\Product::count();
        $categoryCount = \App\Models\Category::count();
        $subcategoryCount = \App\Models\SubCategory::count();
        return view('dashboard.setting',  ['data' => $data, 'current' => $currentUserData, 'productCount' => $productCount, 'categoryCount' => $categoryCount, 'subcategoryCount' => $subcategoryCount]);
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
            'gst' => 'required',
            'tax' => 'required',
            'tax.*' => 'required|numeric|min:0',
            'flange' => 'required',
            'flange.*' => 'required|numeric|min:0',
        ]);

        // Get common fields (like GST)
        $gst = $request->input('gst');
        $taxValues = $request->input('tax');
        $flangeValues = $request->input('flange');

        $maxCount = max(count($taxValues), count($flangeValues));
        Tax::where('gst', $gst)->delete();
        // Iterate over the maximum length
        for ($index = 0; $index < $maxCount; $index++) {
            // Get the tax and flange values for the current index
            $taxValue = $taxValues[$index] ?? null; // If tax is missing, use null
            $flangeValue = $flangeValues[$index] ?? null; // If flange is missing, use null

            // Create or update record for tax and flange
            $record = Tax::updateOrCreate(
                // Matching conditions (update if these match)
                ['gst' => $gst, 'tax' => $taxValue],
                // Fields to update or create
                ['flange' => $flangeValue]
            );
        }



        // Tax::create($request->except('_token'));
        return response()->json(['success' => 'Taxes added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'password' => 'required',
        ]);

        try {
            $User = User::find($id);
            $User->password = Hash::make($request->password);
            $User->save();
            return response()->json(['success' => 'Password updated successfully']);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
