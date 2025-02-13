<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserDevices;
use App\Models\UserModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CategoryController;
use App\Models\ProductAddData;

class ApiController extends Controller
{
    public $per_page_show;
    public $base_url;
    public $profile_path;
    public $doc_path;
    protected $curlApiService;
    protected $fcmNotificationService;
    public function __construct()
    {
        $this->per_page_show = 50;
        $this->base_url = url('/');
        $this->profile_path = '/public/profile_images/';
    }

    /**
     * Login User.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $result['status'] = false;
            $result['message'] = $validator->errors()->first();
            $result['data'] = (object) [];
            return response()->json($result, 200);
        }

        try {
            $email = $request->email;
            $user = User::where('email', $email)->first()->Status;

            $password = $request->password;
            $device_token = isset($request->device_token) ? $request->device_token : '';
            $device_type =
                isset($request->device_type) ? $request->device_type : 'Android';
            $api_version = isset($request->api_version) ? $request->api_version : '';
            $app_version = isset($request->app_version) ? $request->app_version : '';
            $os_version = isset($request->os_version) ? $request->os_version : '';
            $device_model_name = isset($request->device_model_name) ? $request->device_model_name : '';
            $app_language = isset($request->app_language) ? $request->app_language : '';
            $base_url = $this->base_url;
            DB::enableQueryLog();

            $chkUser = User::where('email', $email)->first();
            // dd(md5($password));
            if ($chkUser) {
                if (md5($password) != $chkUser->password) {
                    $result['status'] = false;
                    $result['message'] = "Invalid email or password";
                    $result['data'] = (object) [];
                    return response()->json($result, 200);
                }
            }

            if ($chkUser) {

                $token = $chkUser->createToken('authToken')->plainTextToken;
                $result['status'] = true;
                $result['message'] = "Login Succssfully!";
                $result['data'] = (object) [];

                $chkUser->user_id = $chkUser->id;
                $chkUser->token = $token;

                DB::table('user_devices')->where('user_id', $chkUser->id)->update([
                    'device_token' => '',
                    'status' => '0'
                ]);

                // add token devices login
                $arr = [
                    'status' => 1,
                    'device_token' => $device_token,
                    'login_token' => $token,
                    'device_type' => $device_type,
                    'api_version' => $api_version,
                    'app_version' => $app_version,
                    'os_version' => $os_version,
                    'device_model_name' => $device_model_name,
                    'app_language' => $app_language,
                    'user_id' => $chkUser->id,
                ];
                DB::table('user_devices')->insertGetId($arr);
                $userData = $chkUser->toArray();
                // dd($userData);
                return response()->json(['status' => true, 'message' => 'Login successfully.', 'data' => $userData]);
            } else {
                $result['status'] = false;
                $result['message'] = "Invalid email or password";
                $result['data'] = (object) [];
                return response()->json($result, 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Something went wrong. Please try after some time.', 'data' => []], 200);
        }
    }

    /**
     * Logout functionality
     */
    public function logout(Request $request)
    {

        auth()->logout();

        $token = $request->header('token');
        $user = User::where('id', $request->user_id)->where('status', '1')->first();

        $userDevice = UserDevices::where('user_id', $request->user_id)->where('login_token', $token)->where('status', '1')->first();
        if ($userDevice) {
            $userDevice->device_token = '';
            $userDevice->status = '0';
            $userDevice->updated_at = date("Y-m-d H:i:s");
            $userDevice->save();
        }

        DB::table('user_devices')
            ->join("users", "user_devices.user_id", "=", "users.id")
            ->where("user_devices.login_token", "=", $token)
            ->where("user_devices.user_id", "=", $request->user_id)
            ->update(["user_devices.status" => '0', "user_devices.updated_at" => date("Y-m-d H:i:s"), 'user_devices.device_token' => '']);

        $result['status'] = true;
        $result['message'] = "Logout Successfully";
        $result['data'] = (object) [];

        return response()->json($result, 200);
    }

    /**
     * get Products list data.
     */
    public function getProducts(Request $request)
    {
        $page_number = $request->page;
        $token = $request->header('token');
        $user_id = $request->user_id;
        $base_url = $this->base_url;
        $checkToken = $this->tokenVerify($token);
        try {
            // Decode the JSON response
            $userData = json_decode($checkToken->getContent(), true);
            if ($userData['status'] == false) {
                return $checkToken->getContent();
            }
            $client = Product::where('status', 1)->orderBy('id', 'desc')->get();

            return response()->json(['status' => true, 'message' => 'Get Product list successfully', 'data' => $client], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Something went wrong. Please try after some time.', 'data' => []], 200);
        }
    }

    /**
     * get Category list data.
     */
    public function getCategory(Request $request)
    {
        $page_number = $request->page;
        $token = $request->header('token');
        $user_id = $request->user_id;
        $product_id = $request->product_id;
        $base_url = $this->base_url;
        try {
            $checkToken = $this->tokenVerify($token);
            // Decode the JSON response
            $userData = json_decode($checkToken->getContent(), true);
            if ($userData['status'] == false) {
                return $checkToken->getContent();
            }
            $cas = Category::where('status', '1')->where('product_id', $product_id)->get();


            return response()->json(['status' => true, 'message' => 'Get category list successfully', 'data' => $cas], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Something went wrong. Please try after some time.', 'data' => []], 200);
        }
    }

    /**
     * get Sub Category list data.
     */
    public function getSubCategory(Request $request)
    {
        $user_id = $request->user_id;
        $product_id = $request->product_id;
        $category_id = $request->category_id;
        $page_number = $request->page;
        $token = $request->header('token');
        $base_url = $this->base_url;
        try {
            $checkToken = $this->tokenVerify($token);
            // Decode the JSON response
            $userData = json_decode($checkToken->getContent(), true);
            if ($userData['status'] == false) {
                return $checkToken->getContent();
            }
            // $employee = SubCategory::select('*')->where('product_id', $product_id)->where('category_id', $category_id)->where('status', 1)->get();
            $subcat = ProductAddData::leftJoin('sub_categories', 'sub_categories.id', '=', 'products_add_data.subcategory_id')
                ->where('products_add_data.category_id', $category_id)->where('products_add_data.product_id', $product_id)->where('products_add_data.status', '1')->distinct()->get();
            $groupedSubcat = $subcat->groupBy('subcategory_name');
            $response = $groupedSubcat->map(function ($items, $name) {
                // Use the first item for fixed fields like `flange_percentage`, `footval`, `typeOption`
                $firstItem = $items->first();
                // dd($firstItem);

                // Consolidate options
                $options = $items->map(function ($item) {
                    // dd($item);
                    return [
                        'id' => $item->id,
                        'date' => $item->date,
                        'label' => $item->subcategory_val
                    ];
                });

                return [
                    'id' => $firstItem->subcategory_id,
                    'cat_id' => $firstItem->category_id,
                    'lable' => $name,
                    'flange_percentage' => $firstItem->flange_percentage,
                    'size' => $firstItem->size,
                    'footval' => $firstItem->footval,
                    'typeOption' => $firstItem->typeOption,
                    'options' => $options->unique('label')->values()
                ];
            })->values();

            return response()->json(['status' => true, 'message' => 'Get Sub category list successfully', 'data' => $response], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Something went wrong. Please try after some time.', 'data' => []], 200);
        }
    }

    /**
     * get Sub Category list data.
     */
    public function getSubProductData(Request $request)
    {
        $user_id = $request->user_id;
        $created_at = $request->date;
        $product_id = $request->product_id;
        $category_id = $request->category_id;
        $page_number = $request->page;
        $token = $request->header('token');
        $base_url = $this->base_url;
        try {
            $checkToken = $this->tokenVerify($token);
            // Decode the JSON response
            $userData = json_decode($checkToken->getContent(), true);
            if ($userData['status'] == false) {
                return $checkToken->getContent();
            }
            $subcat = ProductAddData::leftJoin('sub_categories', 'sub_categories.id', '=', 'products_add_data.subcategory_id')
                ->where('products_add_data.date', $created_at)->where('products_add_data.product_id', $product_id)->where('products_add_data.category_id', $category_id)->where('products_add_data.status', '1')->distinct()->get();
            $groupedSubcat = $subcat->groupBy('subcategory_name');
            // Structure the response
            $response = $groupedSubcat->map(function ($items, $name) {
                // Use the first item for fixed fields like `flange_percentage`, `footval`, `typeOption`
                $firstItem = $items->first();

                // Consolidate options
                $options = $items->map(function ($item) {
                    return [
                        // 'value' => $item->date
                        'date' => $item->date,
                        'label' => $item->subcategory_val
                    ];
                });

                return [
                    'id' => $firstItem->subcategory_id,
                    'price' => $firstItem->footval,
                    'size' => $firstItem->size,
                    'typeOption' => $firstItem->typeOption,
                    'flange_percentage' => $firstItem->flange_percentage,
                    'options' => $options->unique('date')->values()
                ];
            })->values();

            $taxs = \App\Models\Tax::select('gst', 'id')->where('status', '1')->first();
            $additionalTax = \App\Models\Tax::select('tax', 'id')->where('status', '1')->whereNotNull('tax')->get();
            $configData = ['taxs' => $taxs, 'additionalTax' => $additionalTax];

            return response()->json(['status' => true, 'message' => 'Get data successfully', 'configData' => $configData, 'data' => $response], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Something went wrong. Please try after some time.', 'data' => []], 200);
        }
    }

    /**
     * get Sub Category list data.
     */
    public function getCoasting(Request $request)
    {
        $user_id = $request->user_id;
        $frame_val = $request->frame_val;
        $price = $request->price;
        $tax = $request->tax;
        $typeOption = $request->typeOption;
        $discount = $request->discount;
        $additionalTax = $request->additionalTax;
        $token = $request->header('token');
        $base_url = $this->base_url;
        try {
            $checkToken = $this->tokenVerify($token);
            // Decode the JSON response
            $userData = json_decode($checkToken->getContent(), true);
            if ($userData['status'] == false) {
                return $checkToken->getContent();
            }
            $calculateFlangeFootPrice = 0;
            if ($request->flange_percentage) {
                $calculateFlangeFootPrice = $price + ($price * $request->flange_percentage / 100);
            }
            if ($typeOption == 'Foot') {
                $priceVal = $price;
            } elseif ($typeOption == 'Flange') {
                $priceVal = $calculateFlangeFootPrice;
            } elseif ($typeOption == 'Both') {
                $priceVal = $calculateFlangeFootPrice;
            }
            // dd($priceVal);
            $discountPrice = ($priceVal * ($discount / 100));
            $AfterDiscount = ($priceVal - $discountPrice);
            $AdditionalTaxes = $AfterDiscount * ($additionalTax / 100);
            $taxAmount = $AfterDiscount + $AdditionalTaxes;
            $taxs = $taxAmount * ($tax / 100);
            $extraTaxAmount = $taxAmount + $taxs;
            $FinalPrice = round($extraTaxAmount);
            $FinalPriceWithoutTax = round($taxAmount);

            $taxOriginal = $tax;
            $discountPricefoot = ($price * ($discount / 100));
            $AfterDiscountFoot = ($price - $discountPricefoot);
            $AdditionalTaxFoot = $AfterDiscountFoot * ($additionalTax / 100);
            $taxAmountFoot = $AfterDiscountFoot + $AdditionalTaxFoot;
            $taxOriginalFoot = $taxAmountFoot * ($taxOriginal / 100);
            $extraTaxAmountFoot = $taxAmountFoot + $taxOriginalFoot;
            $FinalPriceFoot = round($extraTaxAmountFoot);
            $FinalPriceFootWithoutTax = round($taxAmountFoot);


            $data = ['FinalPrice' => $FinalPrice, 'FinalPriceWithoutTax' => $FinalPriceWithoutTax, 'FinalPriceWithoutTaxFoot' => $FinalPriceFoot, 'FinalPriceFootWithoutTax' => $FinalPriceFootWithoutTax];
            return response()->json(['status' => true, 'message' => 'Get Data successfully', 'data' => $data], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Something went wrong. Please try after some time.', 'data' => []], 200);
        }
    }


    public function tokenVerify($token)
    {
        $base_url = $this->base_url;
        $user = DB::table('user_devices')
            ->where('user_devices.login_token', '=', $token)
            ->where('user_devices.status', '=', 1)
            ->count();
        // dd($user);
        if ($user == '' || $user == null || $user == 0) {
            $result['status'] = false;
            $result['message'] = "Token given is invalid, Please login again.";
            $result['data'] = [];
            return response()->json($result, 200);
        } else {
            $result['status'] = true;
            return response()->json($result, 200);
        }
    }
}
