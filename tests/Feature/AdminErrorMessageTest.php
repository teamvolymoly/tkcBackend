<?php

namespace Tests\Feature;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AdminErrorMessageTest extends TestCase
{
    public function test_admin_login_hides_connection_details_from_the_user(): void
    {
        Http::fake(function () {
            throw new ConnectionException('cURL error 7: Connection refused for internal API URL');
        });

        $response = $this->from(route('admin.login'))->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHas('error', 'Something went wrong. Please try again.');
        $response->assertSessionMissing('errors');
    }

    public function test_admin_login_hides_server_error_details_from_the_user(): void
    {
        Http::fake([
            '*' => Http::response([
                'message' => 'SQLSTATE connection failure in /var/www/app.php on line 42',
                'exception' => 'DatabaseException',
            ], 500),
        ]);

        $response = $this->from(route('admin.login'))->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHas('error', 'Something went wrong. Please try again.');
        $response->assertSessionMissing('errors');
    }
}
