<?php

namespace App\Http\Controllers;
use App\Models\FoodModel;
use App\Models\RestaurantModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class FoodItem extends Controller
{
    private $food_item_id = null;
    private $name = null;
    private $category = null;
    private $price = null;
    private $imageURL = null;
    private $restaurant_id = null;
    private $is_admin = false;
    private $restaurant_owner_id = null;


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
            $this->restaurant_owner_id = $id;
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
        return $delete ? $this->is_admin ? Redirect::to("/admin/restaurants/view/{$restaurant}") : Redirect::to("/owned-restaurants/view-restaurant/{$restaurant}") : exit;
    }


    public function insertFood(Request $request)
    {
        if ($request->hasFile('image')) {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'category' => 'required',
                'price' => 'required',
                'image' => 'required',
                'restaurant' => 'required',
            ]);
     
            if ($validator->fails()) {
                echo "Error : Please make sure all the inputs are given.";
                exit;
            }
    
    
            $validated = $validator->validated();

            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);

            $data = [];
            $data['name'] = $validated['name'];
            $data['category'] = $validated['category'];
            $data['price'] = $validated['price'];
            $data['image'] = $name;
            $data['restaurant'] = $validated['restaurant'];
            $data = FoodModel::insertFood($data);
            return $data ? Redirect::to("/owned-restaurants/view-restaurant/{$validated['restaurant']}") : exit;
        }
    }


    public function editFood($id) {
        Self::exitIfFoodDoesntExit($id);
        Self::exitIfNotPrivilleged($id, $this->restaurant_owner_id);
        $food = FoodModel::getFoodByID($id);;
        return view('edit_food', ['food' => $food]);
    }


    public function updateFood(Request $request)
    {
        if ($request->hasFile('image')) {



            $validator = Validator::make($request->all(), [
                'food_id' => 'required',
                'name' => 'required',
                'category' => 'required',
                'price' => 'required',
                'image' => 'required',
            ]);
    
    
            
     
            if ($validator->fails()) {
                echo "Error : Please make sure all the inputs are given.";
                exit;
            }
    
    
            $validated = $validator->validated();

            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);

            Self::exitIfFoodDoesntExit($validated['food_id']);
            Self::exitIfNotPrivilleged($validated['food_id'], $this->restaurant_owner_id);

            
            $data = [];
            $data['name'] = $validated['name'];
            $data['category'] = $validated['category'];
            $data['price'] = $validated['price'];
            $data['image'] = $name;
            $update = FoodModel::updateFood($validated['food_id'], $data);
            return $update ? Redirect::to("/edit-food/{$validated['food_id']}") : exit;
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

    public function exitIfFoodDoesntExit($id) {
        $food = FoodModel::getFoodByID($id);
        return empty($food) ? print_r('Error : Food does not exist').exit : null;
    }

    public function exitIfNotPrivilleged($food_id, $manager = null) {
        if ($this->is_admin) {
            return true;
        }

        $restaurant_id = FoodModel::getRestaurantID($food_id);


        $restaurant = RestaurantModel::getRestaurant($restaurant_id);

        if ($restaurant->restaurant_owner != $manager) {
            print("Error : You do not have access to this food");
            exit;
        }
    }

}

