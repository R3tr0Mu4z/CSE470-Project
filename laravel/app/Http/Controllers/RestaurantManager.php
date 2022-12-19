<?php

namespace App\Http\Controllers;
use App\Models\ManagerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Manager;
use App\Http\Controllers\OwnedRestaurants;
use Illuminate\Support\Facades\Validator;

class RestaurantManager extends Controller
{

    private $restaurant_owner_id;
    
    public function __construct()
    {
        $this->middleware(function($req, $next){
            $id = $req->session()->get('restaurant_manager_id');
            if (empty($id)) {
                return Redirect::to('/');
            }
            $this->restaurant_owner_id = $id;
            return $next($req);
        }, ['except' => ['index', 'post', 'view_signIn']]);
    }

    public function index(Request $request)
    {
        $id = $request->session()->get('restaurant_manager_id');
        if (empty($id)) {
            return view('restaurant_manager_signup');
        } else {
            return Redirect::to('/owned-restaurants/');
        }
    }

    public function post(Request $request) {

        
        if ($request['type'] == 'sign_up') {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'password' => 'required',
            ]);

            $validated = $validator->validated();

            
     
            if ($validator->fails()) {
                echo "Error : Please make sure all the inputs are given.";
                exit;
            }



            $result = Manager::signUp($request, $validated, 'restaurant_manager');
            if ($result) {
                return Redirect::to('/owned-restaurants/');
            } else {
                echo "Error : Email already exists";
                exit;
            }
        }

        if ($request['type'] == 'sign_in') {

            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ]);

            $validated = $validator->validated();

            
     
            if ($validator->fails()) {
                echo "Error : Please make sure all the inputs are given.";
                exit;
            }

            $result = Manager::signIn($request, $validated);

            if ($result) {
                return Redirect::to('/owned-restaurants/');
            } else {
                echo "Error : Incorrect email or password";
                exit;
            }
        }
    }
    
    public function addRestaurant(Request $request)
    {
        return view('add_restaurant');
    }

    public function viewOwnedRestaurant(Request $request)
    {
        $result = OwnedRestaurants::listRestaurants($this->restaurant_owner_id);

        return view('owned_restaurants', ['restaurants' => $result]);
    }


    public function view_signIn()
    {
        return view('restaurant_manager_signin');
    }
    
}

