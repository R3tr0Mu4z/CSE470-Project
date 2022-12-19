<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantModel extends Model
{
    use HasFactory;

    protected $table = 'restaurants';


    
    public function getRestaurant($id)
    {

        $query = Self::query();

        
        $query = $query->select('*');
        $query = $query->where('id', '=', $id);

        $result = $query->first();

        return $result;
    }

    public function getRestaurantsByOwner($owner)
    {

        $query = Self::query();

        
        $query = $query->select('*');
        $query = $query->where('restaurant_owner', '=', $owner);

        $result = $query->get()->toArray();

        return $result;
    }

    public function insertRestaurant($restaurant) {
        $data = new Self();
        $data->name = $restaurant['name'];
        $data->category = $restaurant['category'];
        $data->image = $restaurant['image'];
        $data->restaurant_owner = $restaurant['restaurant_owner'];
        $insert = $data->save();
        if ($insert) {
            return $data->id;
        } else {
            return false;
        }
    }

    public function deleteRestaurant($id) {
        $query = Self::query();
        $delete = $query->select('id')
        ->where('id', '=', $id)
        ->delete();
        return $delete;
    }

    public function searchRestaurant($search)
    {

        $query = Self::query();
        $query = $query->select('id as restaurant_id', 'name', 'category', 'image');
        $query = $query->where('name', 'LIKE', '%'.$search.'%');

        $result = $query->get()->toArray();

        return $result;
    }

        
    public function getAllRestaurants()
    {

        $query = Self::query();

        
        $query = $query->select('*');

        $result = $query->get()->toArray();

        return $result;
    }

    public function updateRestaurant($data, $id) {
        $update = Self::where('id', $id)
        ->update($data);
        return $update;
    }


    
}