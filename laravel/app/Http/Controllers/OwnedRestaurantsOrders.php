<?php

namespace App\Http\Controllers;
use App\Models\RestaurantModel;
use App\Http\Controllers\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\OwnedRestaurants;
use App\Http\Controllers\FoodItem;
use App\Models\OrderModel;

class OwnedRestaurantsOrders extends Controller
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



    public function listOrders()
    {
        $owned_restaurants = OwnedRestaurants::listRestaurants($this->restaurant_owner_id);
        $orders = [];
        foreach($owned_restaurants as $restaurant) {
            $order_query_results = OrderModel::getRestaurantOrders($restaurant->getID());
            foreach($order_query_results as $result) {
                $data = [];
                $order = new Order($result['id']);
                $orders[] = $order;
            }
        }

        return view('view_orders', ['orders' => $orders]);
    }


}

