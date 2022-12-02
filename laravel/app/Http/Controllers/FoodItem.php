<?php

namespace App\Http\Controllers;
use App\Models\FoodModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FoodItem extends Controller
{
    private $food_item_id = null;
    private $name = null;
    private $category = null;
    private $price = null;
    private $imageURL = null;
    private $restaurant_id = null;
    private $is_admin = false;


    public function __construct($food_id = null)
    {

        if (!empty($food_id)) {
            $food = FoodModel::getFoodByID($food_id);

            if (!empty($food)) {
                $this->food_item_id = $food['id'];
                $this->name = $food['name'];
                $this->category = $food['category'];
                $this->price = $food['price'];
                $this->imageURL = $food['image'];
                $this->restaurant_id = $food['restaurant'];
            }

        }


        $this->middleware(function($req, $next){
            $approval = $req->session()->get('admin_approval');

            if ($approval == 1) {
                $this->is_admin = true;
                return $next($req);
            }

            $id = $req->session()->get('restaurant_manager_id');
            if (empty($id)) {
                return Redirect::to('/');
            }
            return $next($req);
        },  ['except' => ['getFoodForAPI']]);
    }


    
    public function getName() {
        return $this->name;
    }

    public function getCategory() {
        return $this->category;
    }
    
    public function getPrice() {
        return $this->price;
    }

    public function getImage() {
        return $this->imageURL;
    }

    public function getRestaurantID() {
        return $this->restaurant_id;
    }

    public function getID() {
        return $this->food_item_id;
    }

    public function deleteFood($id) {
        $restaurant = FoodModel::getRestaurantID($id);
        $delete = FoodModel::deleteFood($id);
        if ($delete) {
            if ($this->is_admin) {
                return Redirect::to("/admin/restaurants/view/{$restaurant}");
            }
            return Redirect::to("/owned-restaurants/view-restaurant/{$restaurant}");
        }
    }


    public function insertFood(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);

            $data = new FoodModel;
            $data->name = $request['name'];
            $data->category = $request['category'];
            $data->price = $request['price'];
            $data->image = $name;
            $data->restaurant = $request['restaurant'];
            $insert = $data->save();
            if ($insert) {
                return Redirect::to("/owned-restaurants/view-restaurant/{$data->restaurant}");
            }
        }
    }


    public function editFood($id) {
        $food = FoodModel::getFoodByID($id);;
        return view('edit_food', ['food' => $food]);
    }


    public function updateFood(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);

            $data = [];
            $data['name'] = $request['name'];
            $data['category'] = $request['category'];
            $data['price'] = $request['price'];
            $data['image'] = $name;
            $update = FoodModel::updateFood($request['food_id'], $data);
            if ($update) {
                return Redirect::to("/edit-food/{$request['food_id']}");
            }
        }
    }


    public function getFoods($id) {
        $foods = FoodModel::getFoodsByRestaurant($id);;
        return $foods;
    }

    public function getFoodForAPI($id) {
        $foods = FoodModel::getFoodByID($id);
        return $foods;
    }
}

