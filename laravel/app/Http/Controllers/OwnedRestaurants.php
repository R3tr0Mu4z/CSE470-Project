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




    public function post(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);

            $data = [];
            $data['name'] = $request['restaurant_name'];
            $data['category'] = $request['category'];
            $data['image'] = $name;
            $data['restaurant_owner'] = $this->restaurant_owner_id;
            $insert = RestaurantModel::insertRestaurant($data);
            if ($insert) {
                return Redirect::to('/owned-restaurants/');
            }
        }
    }
}

