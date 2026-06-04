<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_can_be_rendered()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_admin_redirected_to_admin_dashboard()
    {
        $user = User::factory()->create(['user_role' => 'ADMIN']);

        $response = $this->actingAs($user)->get('/');

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_reviewer_redirected_to_reviewer_dashboard()
    {
        $user = User::factory()->create(['user_role' => 'REVIEWER']);

        $response = $this->actingAs($user)->get('/');

        $response->assertRedirect(route('reviewer.dashboard'));
    }

    public function test_author_redirected_to_author_dashboard()
    {
        $user = User::factory()->create(['user_role' => 'AUTHOR']);

        $response = $this->actingAs($user)->get('/');

        $response->assertRedirect(route('author.dashboard'));
    }

    public function test_register_creates_user()
    {
        $response = $this->post('/register', [
            'username' => 'testuser',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
            'contact' => '08123456789',
        ]);

        $response->assertRedirect(route('author.dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'user_role' => 'AUTHOR',
        ]);
    }

    public function test_login_authenticates_user()
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'user_role' => 'ADMIN',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_logout_redirects_to_login()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
