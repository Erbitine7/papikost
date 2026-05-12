<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\FeatureTestDataTrait;

/**
 * @internal
 */
final class StaffSecurityTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestDataTrait;
    use FeatureTestTrait;

    protected $namespace = null;
    protected $migrate = true;
    protected $refresh = true;

    public function testGuestIsSentToLoginWhenOpeningStaffList(): void
    {
        $response = $this->get('/staff');

        $response->assertRedirectTo('/staff-login');
    }

    public function testGuestIsSentToLoginWhenOpeningAddStaffForm(): void
    {
        $response = $this->get('/staff/add');

        $response->assertRedirectTo('/staff-login');
    }

    public function testGuestCannotCreateStaffViaPost(): void
    {
        $response = $this->post('/staff/store', [
            'username'  => 'newstaff',
            'password'  => 'password',
            'full_name' => 'New Staff',
            'email'     => 'new@test.com',
            'role'      => 1,
        ]);

        $response->assertStatus(302);
        $this->dontSeeInDatabase('operators', [
            'email' => 'new@test.com',
        ]);
    }

    public function testValidAdminLoginRedirectsToDashboard(): void
    {
        $this->seedAdmin();

        $response = $this->post('/staff-login', [
            'email'    => 'admin@test.com',
            'password' => 'adminpass',
        ]);

        $response->assertRedirectTo('/dashboard');
    }

    public function testWrongEmailDoesNotRedirectToDashboard(): void
    {
        $this->seedAdmin();

        $response = $this->post('/staff-login', [
            'email'    => 'wrong@test.com',
            'password' => 'adminpass',
        ]);

        $response->assertStatus(302);
        $response->assertSessionMissing('is_staff_logged_in');
    }

    public function testWrongPasswordDoesNotRedirectToDashboard(): void
    {
        $this->seedAdmin();

        $response = $this->post('/staff-login', [
            'email'    => 'admin@test.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(302);
        $response->assertSessionMissing('is_staff_logged_in');
    }

    public function testEmptyEmailLoginReturnsRedirect(): void
    {
        $this->seedAdmin();

        $response = $this->post('/staff-login', [
            'email'    => '',
            'password' => 'adminpass',
        ]);

        $response->assertStatus(302);
    }

    public function testEmptyPasswordLoginReturnsRedirect(): void
    {
        $this->seedAdmin();

        $response = $this->post('/staff-login', [
            'email'    => 'admin@test.com',
            'password' => '',
        ]);

        $response->assertStatus(302);
    }

    public function testLogoutSendsUserToLoginPage(): void
    {
        $adminId = $this->seedAdmin();

        $this->post('/staff-login', [
            'email'    => 'admin@test.com',
            'password' => 'adminpass',
        ]);

        $response = $this->withSession($this->sessionAsStaff('admin@test.com', 0, $adminId))
            ->get('/staff-logout');

        $response->assertRedirectTo('/staff-login');
    }

    public function testOperatorSessionCannotDeleteStaff(): void
    {
        $this->seedAdmin();
        $regularId = $this->insertTableRow('operators', [
            'username'  => 'regular',
            'password'  => password_hash('pass', PASSWORD_DEFAULT),
            'full_name' => 'Regular Staff',
            'email'     => 'regular@test.com',
            'role'      => 1,
            'status'    => 0,
        ]);
        $otherId = $this->insertTableRow('operators', [
            'username'  => 'other',
            'password'  => password_hash('pass', PASSWORD_DEFAULT),
            'full_name' => 'Other Staff',
            'email'     => 'other@test.com',
            'role'      => 1,
            'status'    => 0,
        ]);

        $this->withSession($this->sessionAsStaff('regular@test.com', 1, $regularId))
            ->post('/staff/delete', [
                'id' => $otherId,
            ]);

        $this->seeInDatabase('operators', [
            'id'    => $otherId,
            'email' => 'other@test.com',
        ]);
    }

    public function testSqlInjectionStyleEmailDoesNotLogUserIn(): void
    {
        $this->seedAdmin();

        $response = $this->post('/staff-login', [
            'email'    => "' OR '1'='1",
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionMissing('is_staff_logged_in');
    }

    public function testMaliciousFullNameIsEscapedOnStaffPage(): void
    {
        $adminId = $this->seedAdmin();
        $this->insertTableRow('operators', [
            'username'  => 'xsstest',
            'password'  => password_hash('pass', PASSWORD_DEFAULT),
            'full_name' => '<script>alert("XSS")</script>',
            'email'     => 'xss@test.com',
            'role'      => 1,
            'status'    => 0,
        ]);

        $response = $this->withSession($this->sessionAsStaff('admin@test.com', 0, $adminId))
            ->get('/staff');

        $response->assertStatus(200);
        $body = $response->getBody();
        $this->assertStringContainsString('&lt;script', $body);
    }

    public function testPasswordIsCaseSensitive(): void
    {
        $this->insertTableRow('operators', [
            'username'  => 'casesensitive',
            'password'  => password_hash('MyPassword', PASSWORD_DEFAULT),
            'full_name' => 'Case Test',
            'email'     => 'case@test.com',
            'role'      => 0,
            'status'    => 0,
        ]);

        $response = $this->post('/staff-login', [
            'email'    => 'case@test.com',
            'password' => 'mypassword',
        ]);

        $response->assertStatus(302);
        $response->assertSessionMissing('is_staff_logged_in');
    }

    public function testLoggedInUserCanOpenDashboard(): void
    {
        $adminId = $this->seedAdmin();

        $session = $this->sessionAsStaff('admin@test.com', 0, $adminId);
        $session['staff_name'] = 'Admin User';

        $response = $this->withSession($session)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    public function testSameSessionWorksForTwoRequests(): void
    {
        $adminId = $this->seedAdmin();

        $session = $this->sessionAsStaff('admin@test.com', 0, $adminId);
        $session['staff_name'] = 'Admin User';

        $this->withSession($session)->get('/dashboard')->assertStatus(200);
        $this->withSession($session)->get('/staff')->assertStatus(200);
    }
}
