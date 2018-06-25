<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class JwtAuthTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test successful login with JWT.
     */
    public function testSuccessfulLogin()
    {
        $user = factory(App\User::class)->create([
            'password' => bcrypt('colppy'),
            'email_verified' => '1',
        ]);

        $this->post('/api/auth/login', [
            'email'    => $user->email,
            'password' => 'colppy'
        ])
        ->seeApiSuccess()
        ->seeJsonKeyValueString('email', $user->email)
        ->seeJsonKey('token')
        ->dontSee('"password"');

    }

    /**
     * Test failed login with JWT.
     */
    public function testFailedLogin()
    {
        $user = factory(App\User::class)->create([
            'email_verified' => '1',
        ]);

        $this->post('/api/auth/login', [
            'email'    => $user->email,
            'password' => str_random(10),
        ])
        ->seeApiError(401)
        ->dontSee($user->email)
        ->dontSee('"token"');
    }

}
