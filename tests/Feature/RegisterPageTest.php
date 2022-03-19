<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterPageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_username_ada_di_register()
    {
        //buka halaman register
        $response = $this->get('/register');
        //pastikan halaman bisa dibuka
        $response->assertStatus(200);
        //pastikan ada input text dengan label Username
        $response->assertSeeText("Username");
        $response->assertSeeText("E-Mail Address");
    }

    public function test_new_user_can_register_by_username()
    {
        $response = $this->from('/register')->post('/register', [
            'username' => 'ppa',
            'name' => 'prima',
            'email' => 'putraprima@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        //pastikan redirect ke home
        $response->assertRedirect('/home');
        $response = $this->get('/home');
        $response->assertSeeText("Dashboard");
        $response->assertSeeText("You are logged in!");
        $response->assertSeeText("prima");
        $response->assertSeeText("ppa");
        $response->assertSeeText("Created At");
    }
}
