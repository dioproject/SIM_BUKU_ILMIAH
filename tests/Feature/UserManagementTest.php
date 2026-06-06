<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['user_role' => 'ADMIN']);
    }

    public function test_admin_can_view_users_list()
    {
        User::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get(route('admin.index.user'));

        $response->assertStatus(200);
    }

    public function test_admin_can_search_users()
    {
        User::factory()->create(['username' => 'budi_utama']);
        User::factory()->create(['username' => 'susi_anggara']);

        $response = $this->actingAs($this->admin)->get(route('admin.index.user', ['search' => 'budi']));

        $response->assertStatus(200);
        $response->assertSee('budi_utama');
        $response->assertDontSee('susi_anggara');
    }

    public function test_admin_can_view_create_user_page()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.create.user'));

        $response->assertStatus(200);
    }

    public function test_admin_can_create_user()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.store.user'), [
            'username' => 'newuser',
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'contact' => '081234567890',
            'phone_region' => '+62',
            'user_role' => 'AUTHOR',
        ]);

        $response->assertRedirect(route('admin.index.user'));
        $this->assertDatabaseHas('users', [
            'username' => 'newuser',
            'email' => 'newuser@example.com',
            'user_role' => 'AUTHOR',
            'phone_region' => '+62',
        ]);
    }

    public function test_admin_can_create_reviewer()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.store.user'), [
            'username' => 'reviewer1',
            'name' => 'Reviewer Satu',
            'email' => 'reviewer1@example.com',
            'password' => 'password123',
            'contact' => '081234567891',
            'phone_region' => '+62',
            'user_role' => 'REVIEWER',
        ]);

        $response->assertRedirect(route('admin.index.user'));
        $this->assertDatabaseHas('users', [
            'username' => 'reviewer1',
            'user_role' => 'REVIEWER',
        ]);
    }

    public function test_create_user_validation_fails_with_non_numeric_contact()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.store.user'), [
            'username' => 'newuser',
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'contact' => 'abcdefghijk',
            'phone_region' => '+62',
            'user_role' => 'AUTHOR',
        ]);

        $response->assertSessionHasErrors('contact');
        $this->assertDatabaseMissing('users', ['username' => 'newuser']);
    }

    public function test_create_user_validation_fails_with_duplicate_email()
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->actingAs($this->admin)->post(route('admin.store.user'), [
            'username' => 'newuser',
            'name' => 'New User',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'contact' => '081234567890',
            'phone_region' => '+62',
            'user_role' => 'AUTHOR',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_admin_can_edit_user()
    {
        $user = User::factory()->create(['user_role' => 'AUTHOR']);

        $response = $this->actingAs($this->admin)->get(route('admin.edit.user', $user->id));

        $response->assertStatus(200);
        $response->assertSee($user->username);
    }

    public function test_admin_can_update_user()
    {
        $user = User::factory()->create(['user_role' => 'AUTHOR']);

        $response = $this->actingAs($this->admin)->put(route('admin.update.user', $user->id), [
            'username' => 'updated_user',
            'name' => 'Updated Name',
            'password' => 'newpassword123',
            'contact' => '081234567892',
            'phone_region' => '+65',
            'user_role' => 'REVIEWER',
        ]);

        $response->assertRedirect(route('admin.index.user'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'username' => 'updated_user',
            'phone_region' => '+65',
            'user_role' => 'REVIEWER',
        ]);
    }

    public function test_admin_can_delete_user()
    {
        $user = User::factory()->create(['user_role' => 'AUTHOR']);

        $response = $this->actingAs($this->admin)->delete(route('admin.destroy.user', $user->id));

        $response->assertRedirect(route('admin.index.user'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_non_admin_cannot_access_user_management()
    {
        $author = User::factory()->create(['user_role' => 'AUTHOR']);

        $response = $this->actingAs($author)->get(route('admin.index.user'));

        $response->assertStatus(403);
    }
}
