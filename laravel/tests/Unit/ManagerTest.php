<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\Manager;
use App\Models\ManagerModel;

class ManagerTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function test_Manager()
    {

        $data = [];
        $data['name'] = "Unit Test";
        $data['email'] = "unit@test5.test";
        $data['phone'] = "123456789";
        $data['password'] = "test";
        $data['role'] = "restaurant_manager";

        $insert = ManagerModel::insertManager($data);

        $manager = new Manager($insert);

        if ($data['name'] == $manager->getName()
        && $data['email'] == $manager->getEmail()
        && $data['phone'] == $manager->getPhone()
        && $data['role'] == $manager->getRole()) {
            ManagerModel::deleteManager($insert);
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }
}
