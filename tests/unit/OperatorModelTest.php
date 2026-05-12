<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use App\Models\OperatorModel;

/**
 * UNIT TESTS - Test individual methods/functions in isolation
 * 
 * Purpose: Verify that individual model methods work correctly
 * without dependencies on other components
 * 
 * @internal
 */
final class OperatorModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected OperatorModel $operatorModel;
    protected $namespace = null;
    protected $migrate = true;
    protected $refresh = true;

    protected function setUp(): void
    {
        parent::setUp();
        $this->operatorModel = new OperatorModel();
    }

    /**
     * Test: Model can create a new operator
     * Expected: Operator is stored in database with correct data
     */
    public function testModelCanCreateNewOperator(): void
    {
        $data = [
            'username'  => 'testoperator',
            'password'  => password_hash('password123', PASSWORD_DEFAULT),
            'full_name' => 'Test Operator',
            'email'     => 'operator@test.com',
            'role'      => 1,
            'status'    => 0,
        ];

        $id = $this->operatorModel->insert($data);

        $this->assertIsInt($id);
        $this->assertGreaterThan(0, $id);
        $this->seeInDatabase('operators', [
            'id'        => $id,
            'username'  => 'testoperator',
            'full_name' => 'Test Operator',
            'email'     => 'operator@test.com',
        ]);
    }

    /**
     * Test: Model can retrieve operator by ID
     * Expected: Returns complete operator data
     */
    public function testModelCanFindOperatorById(): void
    {
        $operatorModel = new OperatorModel();
        
        $id = $operatorModel->insert([
            'username'  => 'findme',
            'password'  => password_hash('pass', PASSWORD_DEFAULT),
            'full_name' => 'Find Me',
            'email'     => 'findme@test.com',
            'role'      => 0,
            'status'    => 0,
        ]);

        $operator = $operatorModel->find($id);

        $this->assertIsArray($operator);
        $this->assertEquals($operator['id'], $id);
        $this->assertEquals($operator['username'], 'findme');
        $this->assertEquals($operator['full_name'], 'Find Me');
    }

    /**
     * Test: Model can retrieve operator by email
     * Expected: Returns operator matching that email
     */
    public function testModelCanFindOperatorByEmail(): void
    {
        $this->hasInDatabase('operators', [
            'username'  => 'emailtest',
            'password'  => password_hash('pass', PASSWORD_DEFAULT),
            'full_name' => 'Email Test',
            'email'     => 'unique@test.com',
            'role'      => 0,
            'status'    => 0,
        ]);

        $operator = $this->operatorModel
            ->where('email', 'unique@test.com')
            ->first();

        $this->assertIsArray($operator);
        $this->assertEquals($operator['email'], 'unique@test.com');
        $this->assertEquals($operator['username'], 'emailtest');
    }

    /**
     * Test: Model can update operator data
     * Expected: Database reflects the updated values
     */
    public function testModelCanUpdateOperator(): void
    {
        $operatorModel = new OperatorModel();
        
        $id = $operatorModel->insert([
            'username'  => 'toupdate',
            'password'  => password_hash('oldpass', PASSWORD_DEFAULT),
            'full_name' => 'Old Name',
            'email'     => 'old@test.com',
            'role'      => 1,
            'status'    => 0,
        ]);

        $updateData = [
            'full_name' => 'Updated Name',
            'email'     => 'updated@test.com',
            'role'      => 0,
        ];

        $operatorModel->update($id, $updateData);

        $this->seeInDatabase('operators', [
            'id'        => $id,
            'full_name' => 'Updated Name',
            'email'     => 'updated@test.com',
            'role'      => 0,
            'username'  => 'toupdate', // Should remain unchanged
        ]);
    }

    /**
     * Test: Model can delete operator
     * Expected: Operator is removed from database
     */
    public function testModelCanDeleteOperator(): void
    {
        $operatorModel = new OperatorModel();
        
        $id = $operatorModel->insert([
            'username'  => 'todelete',
            'password'  => password_hash('pass', PASSWORD_DEFAULT),
            'full_name' => 'To Delete',
            'email'     => 'delete@test.com',
            'role'      => 1,
            'status'    => 0,
        ]);

        $operatorModel->delete($id);

        $this->dontSeeInDatabase('operators', [
            'id' => $id,
        ]);
    }

    /**
     * Test: Model can count total operators
     * Expected: Returns correct number of operators
     */
    public function testModelCanCountAllOperators(): void
    {
        $this->hasInDatabase('operators', ['username' => 'op1', 'password' => 'pass', 'full_name' => 'Op 1', 'email' => 'op1@test.com', 'role' => 0, 'status' => 0]);
        $this->hasInDatabase('operators', ['username' => 'op2', 'password' => 'pass', 'full_name' => 'Op 2', 'email' => 'op2@test.com', 'role' => 1, 'status' => 0]);
        $this->hasInDatabase('operators', ['username' => 'op3', 'password' => 'pass', 'full_name' => 'Op 3', 'email' => 'op3@test.com', 'role' => 1, 'status' => 0]);

        $count = $this->operatorModel->countAllResults();

        $this->assertEquals($count, 3);
    }

    /**
     * Test: Model can filter operators by role
     * Expected: Returns only operators with specified role
     */
    public function testModelCanFilterOperatorsByRole(): void
    {
        $this->hasInDatabase('operators', ['username' => 'admin', 'password' => 'pass', 'full_name' => 'Admin', 'email' => 'admin@test.com', 'role' => 0, 'status' => 0]);
        $this->hasInDatabase('operators', ['username' => 'staff1', 'password' => 'pass', 'full_name' => 'Staff 1', 'email' => 'staff1@test.com', 'role' => 1, 'status' => 0]);
        $this->hasInDatabase('operators', ['username' => 'staff2', 'password' => 'pass', 'full_name' => 'Staff 2', 'email' => 'staff2@test.com', 'role' => 1, 'status' => 0]);

        $staffCount = $this->operatorModel
            ->where('role', 1)
            ->countAllResults();

        $this->assertEquals($staffCount, 2);
    }

    /**
     * Test: Model can filter operators by status
     * Expected: Returns only operators with specified status
     */
    public function testModelCanFilterOperatorsByStatus(): void
    {
        $this->hasInDatabase('operators', ['username' => 'active', 'password' => 'pass', 'full_name' => 'Active', 'email' => 'active@test.com', 'role' => 0, 'status' => 0]);
        $this->hasInDatabase('operators', ['username' => 'inactive', 'password' => 'pass', 'full_name' => 'Inactive', 'email' => 'inactive@test.com', 'role' => 1, 'status' => 1]);

        $activeCount = $this->operatorModel
            ->where('status', 0)
            ->countAllResults();

        $this->assertEquals($activeCount, 1);
    }

    /**
     * Test: Model uses protected fields properly
     * Expected: Only allowedFields can be set via insert/update
     */
    public function testModelProtectsFields(): void
    {
        // Try to insert data with extra fields not in allowedFields
        $data = [
            'username'      => 'fieldtest',
            'password'      => password_hash('pass', PASSWORD_DEFAULT),
            'full_name'     => 'Field Test',
            'email'         => 'field@test.com',
            'role'          => 0,
            'status'        => 0,
            'unauthorized'  => 'value',              // Should be ignored
        ];

        $id = $this->operatorModel->insert($data);

        $operator = $this->operatorModel->find($id);

        // Unauthorized fields should not be in database
        $this->assertArrayNotHasKey('unauthorized', $operator);
        
        // Allowed fields should be present
        $this->assertEquals($operator['username'], 'fieldtest');
        $this->assertEquals($operator['full_name'], 'Field Test');
    }

    /**
     * Test: Password hashing is handled correctly
     * Expected: Passwords are stored hashed and can be verified
     */
    public function testPasswordIsStoredSecurely(): void
    {
        $operatorModel = new OperatorModel();
        $plainPassword = 'mySecurePassword123!';
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

        $id = $operatorModel->insert([
            'username'  => 'passhash',
            'password'  => $hashedPassword,
            'full_name' => 'Pass Hash Test',
            'email'     => 'passhash@test.com',
            'role'      => 0,
            'status'    => 0,
        ]);

        $operator = $operatorModel->find($id);

        // Password should be hashed, not plain text
        $this->assertNotEquals($operator['password'], $plainPassword);
        
        // Hashed password should verify against plain password
        $this->assertTrue(password_verify($plainPassword, $operator['password']));
    }
}
