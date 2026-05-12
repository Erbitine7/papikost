<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\FeatureTestDataTrait;

/**
 * @internal
 */
final class ComputerManagementTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestDataTrait;
    use FeatureTestTrait;

    protected $namespace = null;
    protected $migrate = true;
    protected $refresh = true;

    public function testStaffCanViewComputers(): void
    {
        $staffId = $this->seedOperatorStaff();
        $this->insertTableRow('computers', [
            'spec'   => 'Test PC 1',
            'tariff' => 10000,
            'status' => 0,
        ]);

        $response = $this->withSession($this->sessionAsStaff('staff@test.com', 0, $staffId))
            ->get('/computer');

        $response->assertStatus(200);
        $response->assertSee('Test PC 1');
    }

    public function testStaffCanAddComputer(): void
    {
        $staffId = $this->seedOperatorStaff();

        $response = $this->withSession($this->sessionAsStaff('staff@test.com', 0, $staffId))
            ->post('/computer/store', [
                'spec'   => 'New Test PC',
                'tariff' => '20000',
                'status' => '0',
            ]);

        $response->assertRedirectTo('/computer');
        $this->seeInDatabase('computers', [
            'spec'   => 'New Test PC',
            'tariff' => 20000,
            'status' => 0,
        ]);
    }

    public function testStaffCanEditComputer(): void
    {
        $staffId = $this->seedOperatorStaff();
        $computerId = $this->insertTableRow('computers', [
            'spec'   => 'Old PC',
            'tariff' => 10000,
            'status' => 0,
        ]);

        $response = $this->withSession($this->sessionAsStaff('staff@test.com', 0, $staffId))
            ->post('/computer/update', [
                'id'     => $computerId,
                'spec'   => 'Updated PC',
                'tariff' => '15000',
                'status' => '0',
            ]);

        $response->assertRedirectTo('/computer');
        $this->seeInDatabase('computers', [
            'id'     => $computerId,
            'spec'   => 'Updated PC',
            'tariff' => 15000,
        ]);
    }

    public function testStaffCanDeleteComputer(): void
    {
        $staffId = $this->seedOperatorStaff();
        $computerId = $this->insertTableRow('computers', [
            'spec'   => 'PC to Delete',
            'tariff' => 10000,
            'status' => 0,
        ]);

        $response = $this->withSession($this->sessionAsStaff('staff@test.com', 0, $staffId))
            ->post('/computer/delete', [
                'id' => $computerId,
            ]);

        $response->assertRedirectTo('/computer');
        $this->dontSeeInDatabase('computers', [
            'id' => $computerId,
        ]);
    }
}
