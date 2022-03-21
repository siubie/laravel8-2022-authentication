<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginPageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_username_ada_di_login()
    {
        $this->seed();
        //buka halaman login
        $response = $this->get('/login');
        //pastikan halaman bisa dibuka
        $response->assertStatus(200);
        //pastikan ada input text dengan label Username
        $response->assertSeeText("Username");
    }

    public function test_registered_user_can_login()
    {
        $this->seed();
        //buat user baru pake factory
        $user = User::factory()->create()->first();
        //login as user tersebut
        $response = $this->actingAs($user)->get('/login');
        //pastikan redirect ke home
        $response->assertRedirect('/home');
        $response = $this->get('/home');
        $response->assertSeeText("Dashboard");
        $response->assertSeeText("You are logged in!");
        $response->assertSeeText($user->name);
        $response->assertSeeText($user->username);
        $response->assertSeeText($user->email);
        $response->assertSeeText("Created At");
    }

    public function test_admin_baru_user_can_login()
    {
        $this->seed();
        $response = $this->from('/login')->post('/login', [
            'username' => 'admin',
            'password' => 'password',
        ]);

        //pastikan redirect ke home
        $response->assertRedirect('/home');
        $response->$this->get('/home');
        $response->assertSeeText("Dashboard");
        $response->assertSeeText("You are logged in!");
        $response->assertSeeText("Administrator Baru");
        $response->assertSeeText("admin");
        $response->assertSeeText("admin.baru@admin.com");
        $response->assertSeeText("Created At");
    }

    public function test_invalid_login()
    {
        $this->seed();
        $response = $this->from('/login')->post('/login', [
            'username' => 'adminxxxx',
            'password' => 'passwordxx',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('username');
        $this->assertTrue(session()->hasOldInput('username'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
}
