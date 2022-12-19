<?php

namespace App\Http\Controllers;
use App\Models\RestaurantModel;
use App\Http\Controllers\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OwnedRestaurants extends Controller
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
        });
    }



    public function listRestaurants($owner)
    {

        $result = RestaurantModel::getRestaurantsByOwner($owner);

        $data = [];

        foreach($result as $restaurant) {
            $restaurant_object = new Restaurant($restaurant['id']);
            $data[] = $restaurant_object;
        }

        return $data;
    }

    public function viewRestaurant($id) {
        $restaurant = new Restaurant($id);
        return view('view_restaurant', ['restaurant' => $restaurant]);
    }



}

