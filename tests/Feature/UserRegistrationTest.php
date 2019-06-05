<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('passport:install');
    }

    /** @test */
    public function itRegistersUsers()
    {
        $response = $this->requestRegisterUser();

        $response->assertStatus(201);
    }

    /** @test */
    public function itRequiresName()
    {
        $response = $this->requestRegisterUser(['name' => '']);

        $response->assertStatus(422);
    }

    /** @test */
    public function itRequiresUniqueName()
    {
        $this->requestRegisterUser(['name' => 'John', 'email' => 'john.doe@example.com']);

        $response = $this->requestRegisterUser(['name' => 'John', 'email' => 'john.wick@example.com']);

        $response->assertStatus(422);
    }

    /** @test */
    public function itRequiresEmail()
    {
        $response = $this->requestRegisterUser(['email' => '']);

        $response->assertStatus(422);
    }

    /** @test */
    public function itRequiresUniqueEmail()
    {
        $this->requestRegisterUser(['name' => 'John', 'email' => 'john.doe@example.com']);

        $response = $this->requestRegisterUser(['name' => 'Johnny', 'email' => 'john.doe@example.com']);

        $response->assertStatus(422);
    }

    /** @test */
    public function itRequiresPassword()
    {
        $response = $this->requestRegisterUser(['password' => '']);

        $response->assertStatus(422);
    }

    protected function requestRegisterUser($override = [])
    {
        return $this->json('POST', '/api/auth/register', array_merge([
            'id'        => '5c45b390-c644-412d-b098-cbba64716712',
            'name'      => 'User name',
            'email'     => 'user.email@example.com',
            'password'  => 'userpassword',
        ], $override));
    }
}
