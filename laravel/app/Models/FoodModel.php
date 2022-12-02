<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodModel extends Model
{
    use HasFactory;

    protected $table = 'foods';

    public function getFoodsByRestaurantAPI($id, $api = false) {
        $query_food = Self::query();
        $query_food = $query_food->select('id as food_id', 'name', 'category', 'image', 'price', 'restaurant');
        $query_food = $query_food->where('restaurant', '=', $id);
        $foods = $query_food->get()->toArray();
        return $foods;
    }

    public function getFoodsByRestaurant($id, $api = false) {
        $query_food = Self::query();
        $query_food = $query_food->select("id");
        $query_food = $query_food->where('restaurant', '=', $id);
        $foods = $query_food->get()->toArray();
        return $foods;
    }

    public function getFoodByID($id) {
        $query_food = Self::query();
        $query_food = $query_food->select('*');
        $query_food = $query_food->where('id', '=', $id);
        $foods = $query_food->first();
        return $foods;
    }

    public function deleteFood($id) {
        $query = Self::query();
        $delete = $query->select('id')
        ->where('id', '=', $id)
        ->delete();
        return $delete;
    }

    public function getRestaurantID($id) {
        $query_food = Self::query();
        $query_food = $query_food->select('restaurant');
        $query_food = $query_food->where('id', '=', $id);
        return $query_food->first()['restaurant'];
    }

    public function updateFood($id, $data) {
        $update = Self::where('id', $id)
        ->update($data);
        return $update;
    }
}