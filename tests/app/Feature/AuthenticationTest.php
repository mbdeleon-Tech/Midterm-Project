<?php

namespace Tests\App\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class AuthenticationTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testPublicPagesRender(): void
    {
        $this->get('/')->assertOK()->assertSee('Complete store workflow');
        $this->get('/about')->assertOK()->assertSee('complete CodeIgniter point-of-sale system');
        $this->get('/login')->assertOK()->assertSee('Sign in to Northstar POS');
    }

    /** @dataProvider protectedRoutes */
    public function testManagementPagesRedirectLoggedOutVisitors(string $route): void
    {
        $this->get($route)->assertRedirectTo('/login');
    }

    public static function protectedRoutes(): array
    {
        return [
            ['/products'],
            ['/customers'],
            ['/users'],
            ['/sales'],
            ['/sales/new'],
        ];
    }

    public function testLoggedInUserCanReachDatabaseIndependentForm(): void
    {
        $this->withSession([
            'userId' => 1,
            'username' => 'admin.marc',
            'fullName' => 'Marco De Leon',
            'isLoggedIn' => true,
        ])->get('/products/new')->assertOK()->assertSee('New product');
    }

    public function testAuthenticationImplementationUsesSecurePrimitives(): void
    {
        $auth = file_get_contents(APPPATH . 'Controllers/Auth.php');
        $users = file_get_contents(APPPATH . 'Controllers/Users.php');
        $routes = file_get_contents(APPPATH . 'Config/Routes.php');

        $this->assertStringContainsString('password_verify(', $auth);
        $this->assertStringContainsString('session()->regenerate(true)', $auth);
        $this->assertStringContainsString('session()->destroy()', $auth);
        $this->assertStringContainsString('password_hash(', $users);
        $this->assertStringContainsString("['filter' => 'auth']", $routes);
    }
}
