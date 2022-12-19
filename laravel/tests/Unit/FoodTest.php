<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\FoodItem;
use App\Models\FoodModel;

class FoodTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function test_Food()
    {

        $data = [];
        $data['name'] = 'Food Test';
        $data['category'] = 'Chinese';
        $data['price'] = 500;
        $data['image'] = 'not_given.jpg';
        $data['restaurant'] = 1000;
        $id = FoodModel::insertFood($data);
        $food = new FoodItem($id);

        if ($data['name'] == $food->getName()
        && $data['category'] == $food->getCategory()
        && $data['price'] == $food->getPrice()
        && $data['image'] == $food->getImage()
        && $data['restaurant'] == $food->getRestaurantID()) {
            FoodModel::deleteFood($id);
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }
}
