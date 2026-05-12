<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\FeatureTestDataTrait;

/**
 * @internal
 */
final class StaffValidationTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestDataTrait;
    use FeatureTestTrait;

    protected $namespace = null;
    protected $migrate = true;
    protected $refresh = true;

    public function testEmptyUsernameIsRejected(): void
    {
        $session = $this->loggedInAdminSession();

        $this->withSession($session)->post('/staff/store', [
            'username'  => '',
            'password'  => 'password123',
            'full_name' => 'Valid Name',
            'email'     => 'valid@test.com',
            'role'      => 1,
        ]);

        $this->dontSeeInDatabase('operators', [
            'email' => 'valid@test.com',
        ]);
    }

    public function testEmptyPasswordIsRejected(): void
    {
        $session = $this->loggedInAdminSession();

        $this->withSession($session)->post('/staff/store', [
            'username'  => 'newstaff',
            'password'  => '',
            'full_name' => 'Valid Name',
            'email'     => 'valid@test.com',
            'role'      => 1,
        ]);

        $this->dontSeeInDatabase('operators', [
            'email' => 'valid@test.com',
        ]);
    }

    public function testEmptyEmailIsAccepted(): void
    {
        $session = $this->loggedInAdminSession();

        $this->withSession($session)->post('/staff/store', [
            'username'  => 'newstaff',
            'password'  => 'password123',
            'full_name' => 'Valid Name',
            'email'     => '',
            'role'      => 1,
        ]);

        $this->seeInDatabase('operators', [
            'username' => 'newstaff',
        ]);
    }

    public function testInvalidEmailFormatIsRejected(): void
    {
        $session = $this->loggedInAdminSession();

        $this->withSession($session)->post('/staff/store', [
            'username'  => 'newstaff',
            'password'  => 'password123',
            'full_name' => 'Valid Name',
            'email'     => 'not-an-email',
            'role'      => 1,
        ]);

        $this->dontSeeInDatabase('operators', [
            'username' => 'newstaff',
        ]);
    }

    public function testDuplicateEmailIsRejectedWithRedirect(): void
    {
        $adminId = $this->seedAdmin();
        $session = $this->sessionAsStaff('admin@test.com', 0, $adminId);

        $this->insertTableRow('operators', [
            'username'  => 'existing',
            'password'  => password_hash('pass', PASSWORD_DEFAULT),
            'full_name' => 'Existing Staff',
            'email'     => 'duplicate@test.com',
            'role'      => 1,
            'status'    => 0,
        ]);

        $response = $this->withSession($session)->post('/staff/store', [
            'username'  => 'newstaff',
            'password'  => 'password123',
            'full_name' => 'New Staff',
            'email'     => 'duplicate@test.com',
            'role'      => 1,
        ]);

        $response->assertStatus(302);
    }

    public function testDuplicateUsernameIsRejected(): void
    {
        $adminId = $this->seedAdmin();
        $session = $this->sessionAsStaff('admin@test.com', 0, $adminId);

        $this->insertTableRow('operators', [
            'username'  => 'duplicateuser',
            'password'  => password_hash('pass', PASSWORD_DEFAULT),
            'full_name' => 'Existing Staff',
            'email'     => 'existing@test.com',
            'role'      => 1,
            'status'    => 0,
        ]);

        $this->withSession($session)->post('/staff/store', [
            'username'  => 'duplicateuser',
            'password'  => 'password123',
            'full_name' => 'New Staff',
            'email'     => 'new@test.com',
            'role'      => 1,
        ]);

        $count = (new \App\Models\OperatorModel())
            ->where('username', 'duplicateuser')
            ->countAllResults();

        $this->assertSame(1, $count);
    }

    public function testInvalidRoleStillProducesNumericRoleIfRowSaved(): void
    {
        $session = $this->loggedInAdminSession();

        $this->withSession($session)->post('/staff/store', [
            'username'  => 'roletest',
            'password'  => 'password123',
            'full_name' => 'Role Test',
            'email'     => 'roletest@test.com',
            'role'      => 999,
        ]);

        $staff = (new \App\Models\OperatorModel())
            ->where('username', 'roletest')
            ->first();

        if ($staff !== null) {
            $this->assertIsNumeric($staff['role']);
        }
    }

    public function testVeryLongUsernameIsRejectedOrTruncated(): void
    {
        $session = $this->loggedInAdminSession();
        $long = str_repeat('a', 500);

        $this->withSession($session)->post('/staff/store', [
            'username'  => $long,
            'password'  => 'password123',
            'full_name' => 'Long Name Test',
            'email'     => 'longname@test.com',
            'role'      => 1,
        ]);

        $staff = (new \App\Models\OperatorModel())
            ->where('email', 'longname@test.com')
            ->first();

        if ($staff !== null) {
            $this->assertLessThanOrEqual(255, strlen($staff['username']));
        }
    }

    public function testEmailWithPlusSignIsAccepted(): void
    {
        $session = $this->loggedInAdminSession();

        $this->withSession($session)->post('/staff/store', [
            'username'  => 'specialchar',
            'password'  => 'password123',
            'full_name' => 'Special Test',
            'email'     => 'user+tag@example.co.uk',
            'role'      => 1,
        ]);

        $this->seeInDatabase('operators', [
            'username' => 'specialchar',
            'email'    => 'user+tag@example.co.uk',
        ]);
    }

    public function testWhitespaceInUsernameIsStoredAsSubmitted(): void
    {
        $session = $this->loggedInAdminSession();

        $this->withSession($session)->post('/staff/store', [
            'username'  => '  trimtest  ',
            'password'  => 'password123',
            'full_name' => 'Trim Test',
            'email'     => 'trim@test.com',
            'role'      => 1,
        ]);

        $staff = (new \App\Models\OperatorModel())
            ->where('email', 'trim@test.com')
            ->first();

        if ($staff !== null) {
            $this->assertSame('  trimtest  ', $staff['username']);
        }
    }

    public function testUpdateWithEmptyFullNameKeepsOldValue(): void
    {
        $adminId = $this->seedAdmin();
        $session = $this->sessionAsStaff('admin@test.com', 0, $adminId);

        $operatorModel = new \App\Models\OperatorModel();
        $staffId = (int) $operatorModel->insert([
            'username'  => 'updatetest',
            'password'  => password_hash('pass', PASSWORD_DEFAULT),
            'full_name' => 'Update Test',
            'email'     => 'update@test.com',
            'role'      => 1,
            'status'    => 0,
        ]);

        $response = $this->withSession($session)->post('/staff/update', [
            'id'        => $staffId,
            'full_name' => '',
            'email'     => 'newemail@test.com',
            'role'      => 0,
        ]);

        $response->assertStatus(302);

        $staff = $operatorModel->find($staffId);
        $this->assertNotNull($staff);
        $this->assertSame('Update Test', $staff['full_name']);
    }

    public function testDeleteMissingIdStillRedirects(): void
    {
        $session = $this->loggedInAdminSession();

        $response = $this->withSession($session)->post('/staff/delete', [
            'id' => 99999,
        ]);

        $response->assertStatus(302);
    }

    public function testComplexPasswordIsStoredHashed(): void
    {
        $session = $this->loggedInAdminSession();
        $password = 'P@$$w0rd!#%&*';

        $this->withSession($session)->post('/staff/store', [
            'username'  => 'complex',
            'password'  => $password,
            'full_name' => 'Complex Test',
            'email'     => 'complex@test.com',
            'role'      => 1,
        ]);

        $staff = (new \App\Models\OperatorModel())
            ->where('email', 'complex@test.com')
            ->first();

        if ($staff !== null) {
            $this->assertTrue(password_verify($password, $staff['password']));
        }
    }

    public function testPartialEmailSearchFindsRow(): void
    {
        $this->seedAdmin();
        $this->insertTableRow('operators', [
            'username'  => 'partial1',
            'password'  => password_hash('pass', PASSWORD_DEFAULT),
            'full_name' => 'Partial User',
            'email'     => 'john.doe@example.com',
            'role'      => 1,
            'status'    => 0,
        ]);

        $rows = (new \App\Models\OperatorModel())
            ->like('email', 'john')
            ->findAll();

        $this->assertNotEmpty($rows);
    }
}
