<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\Restaurant;
use App\Models\RestaurantModel;

class RestaurantTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function test_Restaurant()
    {

        $data = [];
        $data['name'] = 'Restaurant Test';
        $data['category'] = 'Chinese';
        $data['image'] = 'not_given.jpg';
        $data['restaurant_owner'] = 1000;
        $id = RestaurantModel::insertRestaurant($data);
        $food = new Restaurant($id);

        if ($data['name'] == $food->getName()
        && $data['category'] == $food->getCategory()
        && $data['restaurant_owner'] == $food->getOwner()
        && $data['image'] == $food->getImage()) {
            RestaurantModel::deleteRestaurant($id);
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }
}
