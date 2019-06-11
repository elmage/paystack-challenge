<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupplierTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSupplierListPage()
    {
        $user = factory(\App\User::class)->create();
        $response = $this->actingAs($user)->get('/suppliers');


        $response->assertStatus(200);
        $response->assertSee('dashboard');
    }
}
