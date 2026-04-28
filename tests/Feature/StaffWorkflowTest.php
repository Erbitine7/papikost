<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
final class StaffWorkflowTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $namespace = null;
    protected $migrate = true;
    protected $refresh = true;

    public function testCanLoginCreateComputerAndMember(): void
    {
        $this->hasInDatabase('operators', [
            'username'   => 'budi',
            'password'   => password_hash('budijuga', PASSWORD_DEFAULT),
            'full_name'  => 'Budi',
            'email'      => 'budi@example.com',
            'role'       => 0,
            'status'     => 0,
        ]);

        $loginResponse = $this->post('/staff-login', [
            'email'    => 'budi@example.com',
            'password' => 'budijuga',
        ]);

        $loginResponse->assertRedirectTo('/dashboard');
        $loginResponse->assertSessionHas('is_staff_logged_in', true);
        $loginResponse->assertSessionHas('staff_email', 'budi@example.com');

        $computerResponse = $this->withSession([
            'is_staff_logged_in' => true,
            'staff_email'        => 'budi@example.com',
        ])->post('/computer/store', [
            'spec'   => 'Test PC',
            'tariff' => '15000',
            'status' => '0',
        ]);

        $computerResponse->assertRedirectTo('/computer');
        $this->seeInDatabase('computers', [
            'spec'   => 'Test PC',
            'tariff' => 15000,
            'status' => 0,
        ]);

        $memberResponse = $this->withSession([
            'is_staff_logged_in' => true,
            'staff_email'        => 'budi@example.com',
        ])->post('/member/store', [
            'name'         => 'Joko',
            'phone_number' => '081234567890',
            'email'        => 'joko@example.com',
        ]);

        $memberResponse->assertRedirectTo('/member');
        $this->seeInDatabase('members', [
            'name'         => 'Joko',
            'phone_number' => '081234567890',
            'email'        => 'joko@example.com',
            'status'       => 0,
        ]);
    }
}
