<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\FeatureTestDataTrait;

/**
 * @internal
 */
final class StaffManagementTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestDataTrait;
    use FeatureTestTrait;

    protected $namespace = null;
    protected $migrate = true;
    protected $refresh = true;

    public function testAdminCanViewStaff(): void
    {
        $adminId = $this->seedAdmin();
        $this->insertTableRow('operators', [
            'username'  => 'staff1',
            'password'  => password_hash('pass', PASSWORD_DEFAULT),
            'full_name' => 'Staff One',
            'email'     => 'staff1@test.com',
            'role'      => 1,
            'status'    => 0,
        ]);

        $response = $this->withSession($this->sessionAsStaff('admin@test.com', 0, $adminId))
            ->get('/staff');

        $response->assertStatus(200);
        $response->assertSee('Staff One');
    }

    public function testAdminCanAddStaff(): void
    {
        $adminId = $this->seedAdmin();

        $response = $this->withSession($this->sessionAsStaff('admin@test.com', 0, $adminId))
            ->post('/staff/store', [
                'username'  => 'newstaff',
                'password'  => 'newpass123',
                'full_name' => 'New Staff',
                'email'     => 'newstaff@test.com',
                'role'      => 1,
            ]);

        $response->assertRedirectTo('/staff');
        $this->seeInDatabase('operators', [
            'username'  => 'newstaff',
            'full_name' => 'New Staff',
            'email'     => 'newstaff@test.com',
            'role'      => 1,
        ]);
    }

    public function testAdminCanEditStaff(): void
    {
        $adminId = $this->seedAdmin();
        $staffId = $this->insertTableRow('operators', [
            'username'  => 'editstaff',
            'password'  => password_hash('pass', PASSWORD_DEFAULT),
            'full_name' => 'Edit Staff',
            'email'     => 'edit@test.com',
            'role'      => 1,
            'status'    => 0,
        ]);

        $response = $this->withSession($this->sessionAsStaff('admin@test.com', 0, $adminId))
            ->post('/staff/update', [
                'id'        => $staffId,
                'full_name' => 'Updated Staff',
                'email'     => 'updated@test.com',
                'role'      => 1,
            ]);

        $response->assertRedirectTo('/staff');
        $this->seeInDatabase('operators', [
            'id'        => $staffId,
            'full_name' => 'Updated Staff',
            'email'     => 'updated@test.com',
        ]);
    }

    public function testAdminCanDeleteStaff(): void
    {
        $adminId = $this->seedAdmin();
        $staffId = $this->insertTableRow('operators', [
            'username'  => 'deletestaff',
            'password'  => password_hash('pass', PASSWORD_DEFAULT),
            'full_name' => 'Delete Staff',
            'email'     => 'delete@test.com',
            'role'      => 1,
            'status'    => 0,
        ]);

        $response = $this->withSession($this->sessionAsStaff('admin@test.com', 0, $adminId))
            ->post('/staff/delete', [
                'id' => $staffId,
            ]);

        $response->assertRedirectTo('/staff');
        $this->dontSeeInDatabase('operators', [
            'id' => $staffId,
        ]);
    }
}
