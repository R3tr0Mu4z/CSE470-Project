<?php

namespace App\Http\Controllers;
use App\Models\RestaurantModel;
use App\Models\FoodModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class Restaurant extends Controller
{
    private $restaurant_owner_id;
    private $restaurant_id;
    private $name;
    private $imageURL;
    private $category;
    private $owner;
    private $is_admin;

    public function __construct($id = null)
    {

        if (!empty($id)) {
            $result = RestaurantModel::getRestaurant($id);

            $this->restaurant_id = $result['id'];
            $this->name = $result['name'];
            $this->imageURL = $result['image'];
            $this->category = $result['category'];
            $this->owner = $result['restaurant_owner'];
        }


        $this->middleware(function($req, $next){

            $approval = $req->session()->get('admin_approval');

            if ($approval == 1) {
                $this->is_admin = true;
                return $next($req);
            }

            $restaurant_manager = $req->session()->get('restaurant_manager_id');
            if (empty($restaurant_manager)) {
                return Redirect::to('/');
            }

            $this->restaurant_owner_id = $restaurant_manager;

            return $next($req);
        }, ['except' => ['getForAPI']]);
    }


    public function showName() {
        echo $this->name;
    }

    public function showCategory() {
        echo $this->category;
    }

    public function showImage() {
        echo $this->imageURL;
    }

    public function showID() {
        echo $this->restaurant_id;
    }

    public function getID() {
        return $this->restaurant_id;
    }


    public function getName() {
        return $this->name;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getImage() {
        return $this->imageURL;
    }

    public function getOwner() {
        return $this->owner;
    }

    public function addFoodItem($id) {
        return view('add_food', ['restaurant' => $id]);
    }


    public function viewFoodItems($id, $edit=true) {

        $foods = FoodModel::getFoodsByRestaurant($id);

        $data = [];
        foreach($foods as $food) {
            // print_r($food);
            $food_obj = new FoodItem($food['id']);
            $d = [];
            $d['id'] = $food['id'];
            $d['name'] = $food_obj->getName();
            $d['category'] = $food_obj->getCategory();
            $d['price'] = $food_obj->getPrice();
            $d['image'] = $food_obj->getImage();
            $data[] = $d;
        }

        return view('parts.restaurant.view_food_items', ['foods' => $data, 'edit' => $edit]);
    }

    public function getFoodItems() {

        $foods = FoodModel::getFoodsByRestaurant($this->restaurant_id);

        $data = [];
        foreach($foods as $food) {
            $food_obj = new FoodItem($food['id']);
            $d = [];
            $d['id'] = $food['id'];
            $d['name'] = $food_obj->getName();
            $d['category'] = $food_obj->getCategory();
            $d['price'] = $food_obj->getPrice();
            $d['image'] = $food_obj->getImage();
            $data[] = $d;
        }

        return $data;
    }

    public function getForAPI($restraurant_id)
    {

        $restaurant = RestaurantModel::getRestaurant($restraurant_id);
        $foods = FoodModel::getFoodsByRestaurantAPI($restraurant_id, true);

        $result = [];
        $result['restaurant'] = $restaurant;
        $result['foods'] = $foods;

        return response()->json($result, 200);
    }


    

    public function deleteRestaurant($id) {
        Self::exitIfRestaurantDoesntExit($id);
        Self::exitIfNotPrivilleged($id, $this->restaurant_owner_id);
        $delete = RestaurantModel::deleteRestaurant($id, $this->restaurant_owner_id);
        if ($delete) {
            if ($this->is_admin) {
                return Redirect::to("/admin/restaurants");
            }
            return Redirect::to("/owned-restaurants/");
        }
    }



    public function editRestaurant($id) {
        Self::exitIfRestaurantDoesntExit($id);
        Self::exitIfNotPrivilleged($id, $this->restaurant_owner_id);
        $restaurant = RestaurantModel::getRestaurant($id);;
        $view = "edit_restaurant";
        if ($this->is_admin) {
            $view = "admin_edit_restaurant";
        }
        return view($view, ['restaurant' => $restaurant]);
    }


    public function updateRestaurant(Request $request)
    {
        if ($request->hasFile('image')) {

            $validator = Validator::make($request->all(), [
                'restaurant_name' => 'required',
                'category' => 'required',
                'restaurant_id' => 'required',

            ]);
     
            if ($validator->fails()) {
                echo "Error : Please make sure all the inputs are given.";
                exit;
            }
    
    
            $validated = $validator->validated();

            Self::exitIfRestaurantDoesntExit($validated['restaurant_id']);
            Self::exitIfNotPrivilleged($validated['restaurant_id'], $this->restaurant_owner_id);
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);

            $data = [];
            $data['name'] = $validated['restaurant_name'];
            $data['category'] = $validated['category'];
            $data['image'] = $name;
            $insert = RestaurantModel::updateRestaurant($data, $validated['restaurant_id']);

            if ($this->is_admin) {
                return $insert ? Redirect::to("/admin/restaurants/view/{$validated['restaurant_id']}") : exit;

            } else {
                return $insert ? Redirect::to("/owned-restaurants/view-restaurant/{$validated['restaurant_id']}") : exit;

            }

        }
    }


    public function createRestaurant(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);

            $validator = Validator::make($request->all(), [
                'restaurant_name' => 'required',
                'category' => 'required',

            ]);
     
            if ($validator->fails()) {
                echo "Error : Please make sure all the inputs are given.";
                exit;
            }
    
    
            $validated = $validator->validated();


            $data = [];
            $data['name'] = $validated['restaurant_name'];
            $data['category'] = $validated['category'];
            $data['image'] = $name;
            $data['restaurant_owner'] = $this->restaurant_owner_id;
            $insert = RestaurantModel::insertRestaurant($data);
            return $insert ? Redirect::to('/owned-restaurants/') : exit;
        }
    }

    public function exitIfRestaurantDoesntExit($id = null) {
        if (empty($id)) {
            $id = $this->restaurant_id;
        }
        $restaurant = RestaurantModel::getRestaurant($id);
        return empty($restaurant) ? print_r('Error : Restaurant does not exist').exit : null;
    }

    public function exitIfNotPrivilleged($restaurant_id, $manager = null) {
        if ($this->is_admin) {
            return true;
        }
        $restaurant = RestaurantModel::getRestaurant($restaurant_id);


        if ($restaurant->restaurant_owner != $manager) {
            print("Error : You do not have access to this restaurant");
            exit;
        }
    }

}

