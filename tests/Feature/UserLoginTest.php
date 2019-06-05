<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

use App\Models\User;

use Auth;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('passport:install');
    }

    /** @test */
    public function itLoginsUsers()
    {
        $user = $this->createUser();

        $response = $this->json('POST', '/api/auth/login', [
            'name'      => 'John',
            'password'  => 'supersecret',
        ]);

        $response->assertStatus(200);

        $this->assertEquals($user->id, Auth::id());
    }

    /** @test */
    public function itDoesntLoginWithBadCredentials()
    {
        $user = $this->createUser();

        $response = $this->json('POST', '/api/auth/login', [
            'name'      => 'Johnny',
            'password'  => 'badpass',
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function itRequiresName()
    {
        $response = $this->json('POST', '/api/auth/login', [
            'name'      => '',
            'password'  => 'supersecret',
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function itRequiresPassword()
    {
        $response = $this->json('POST', '/api/auth/login', [
            'name'      => 'John',
            'password'  => '',
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function itReturnsUserModel()
    {
        $user = $this->createUser();

        $response = $this->json('POST', '/api/auth/login', [
            'name'      => 'John',
            'password'  => 'supersecret',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'user' => ['id' => Auth::id()]
            ]);
    }

    protected function createUser()
    {
        return User::create([
            'id'        => '5c45b390-c644-412d-b098-cbba64716712',
            'name'      => 'John',
            'email'     => 'john@example.com',
            'password'  => bcrypt('supersecret'),
        ]);
    }
}
