<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\CustomerModel;

class Customer extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */

    private $id = null;
    private $name = null;
    private $email = null;
    private $phone = null;
    private $houseNo = null;
    private $street = null;
    private $city = null;
    
    public function __construct($id = null)
    {
        if (!empty($id)) {
            $customer = CustomerModel::getCustomer($id);
            if (!empty($customer)) {
                $this->id = $id;
                $this->name = $customer['name'];
                $this->email = $customer['email'];
                $this->phone = $customer['phone'];
                $this->houseNo = $customer['houseNo'];
                $this->street = $customer['street'];
                $this->city = $customer['city'];
            }

        }
        $this->middleware('auth:api', ['except' => ['login', 'register', 'deleteCustomer', 'editCustomer', 'updateCustomer']]);

        $this->middleware(function($req, $next){
            $approval = $req->session()->get('admin_approval');

            if ($approval == 1) {
                return $next($req);
            }

            $id = $req->session()->get('restaurant_manager_id');
            if (empty($id)) {
                return Redirect::to('/');
            }
            return $next($req);
        },  ['except' => ['login', 'me', 'logout', 'refresh', 'respondWithToken', 'guard', 'get_customer', 'register', 'updateAPI']]);
    }


    public function getID() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getHouseNo() {
        return $this->houseNo;
    }

    public function getCity() {
        return $this->city;
    }

    public function getStreet() {
        return $this->street;
    }

    public function getCustomerDetails() {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'houseNo' => $this->houseNo,
            'city' => $this->city,
            'street' => $this->street
        ];
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }


    public function get_customer() {
        $customer = Auth::user()->getId();
        return $customer;
    }

    public function register(Request $request) {
        $data = [];
        $data['name'] = $request['name'];
        $data['email'] = $request['email'];
        $data['phone'] = $request['phone'];
        $data['password'] =  $request['password'];
        $data['password'] = Hash::make($data['password']);
        $insert = CustomerModel::insertCustomer($data);
        if ($insert) {
            $credentials = $request->only('email', 'password');
            $token = $this->guard()->attempt($credentials);
            if ($token = $this->guard()->attempt($credentials)) {
                return $this->respondWithToken($token);
            } else {
                return response()->json(['error' => 'tokenization error.'], 401);
            }
        } else {
            
            return response()->json(['error' => 'Insertion error.'], 401);
        }

    }

    public function updateAPI(Request $request) {
        $data = [];
        $data['name'] = $request['name'];
        $data['email'] = $request['email'];
        $data['phone'] = $request['phone'];
        $data['houseNo'] = $request['houseNo'];
        $data['street'] = $request['street'];
        $data['city'] = $request['city'];
        $customer = $this->get_customer();

        $reset = false;
        if (!empty($request['password'])) {
            $reset = true;
            $data['password'] =  Hash::make($request['password']);
            $this->guard()->logout();
        }
        

        $update = CustomerModel::updateCustomer($customer, $data);

        if ($update) {
            return response()->json(['type' => 'success', 'message' => 'Profile Updated! Please log in again.', 'reset' => $reset], 200);
        }

    }

    public function deleteCustomer($id, Request $req) {
        $delete = CustomerModel::deleteCustomer($id);
        if ($delete) {
            return Redirect::to('/admin/customers/');
        }
    }


    public function editCustomer($id, Request $req) {
        $customer = new Self($id);
        return view('edit_customer', ['customer' => $customer]);
    }

    public function updateCustomer(Request $request) {
        $data = [];
        $data['name'] = $request['name'];
        $data['email'] = $request['email'];
        $data['phone'] = $request['phone'];
        $data['houseNo'] = $request['houseNo'];
        $data['street'] = $request['street'];
        $data['city'] = $request['city'];
        $update = CustomerModel::updateCustomer($request['id'], $data);

        if ($update) {
            return Redirect::to("/admin/customers/edit/{$request['id']}");
        }
    }


}