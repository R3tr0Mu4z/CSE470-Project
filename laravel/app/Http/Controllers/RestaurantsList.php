<?php

namespace App\Http\Controllers;
use App\Models\RestaurantModel;
use App\Models\FoodModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RestaurantsList extends Controller
{
    private $restaurant_owner_id;
    public function __construct()
    {
        $this->middleware(function($req, $next){
            $id = $req->session()->get('administrative_manager_id');

            if (empty($id)) {
                return Redirect::to('/');
            }
            $approval = $req->session()->get('admin_approval');

            if ($approval == 0) {
                echo "Your administrative rights require approval.";
                echo "<br/>";
                echo "Please click here to <a href='/manager/logout'>log in</a> again to see if you are approved";
                exit;
            }
            $this->admin_id = $id;
            $this->admin_approval = 1;
            return $next($req);
        }, ['except' => ['search']]);
    }

    
    public function search(Request $request)
    {


        $search = "";
        if (!empty($request['search'])) {
            $search = $request['search'];
        }

        
        $result = RestaurantModel::searchRestaurant($search);

        return response()->json($result, 200);
    }

    public function listRestaurants() {
        $restaurants = RestaurantModel::getAllRestaurants();
        $restaurant_objects = [];
        foreach($restaurants as $restaurant) {
            $restaurant_objects[$restaurant['id']] = new Restaurant($restaurant['id']);
        }
        $this->restaurants = $restaurant_objects;

        return $this->restaurants;
    }

    public function viewRestaurant($id) {
        $restaurant = new Restaurant($id);
        $restaurant->exitIfRestaurantDoesntExit();
        return view('parts.admin.view_restaurant', ['restaurant' => $restaurant]);
    }   

}

