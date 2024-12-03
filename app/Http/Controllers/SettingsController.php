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
            'flange' => 'required'
        ]);

        Tax::create($request->except('_token'));
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
