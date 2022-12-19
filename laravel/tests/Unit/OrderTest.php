<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\Order;
use App\Models\OrderModel;

class OrderTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function test_Order()
    {

        $foods = [4, 7, 0];
        $quantities = [4, 7, 0];
        $customer = 1000;
        $cost= 470470;
        $restaurant = 1000;
        $id = OrderModel::insertOrder($foods, $quantities, $customer, $cost, $restaurant);
        $order = new Order($id);

        if (implode(",", $foods) == $order->getFoodItemIDs()
        && implode(",", $quantities) == $order->getQuantityOfFoods()
        && $cost == $order->getCost()
        ) {
            OrderModel::deleteOrder($id);
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }
}
