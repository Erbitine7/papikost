<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\FeatureTestDataTrait;

/**
 * @internal
 */
final class RentalManagementTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestDataTrait;
    use FeatureTestTrait;

    protected $namespace = null;
    protected $migrate = true;
    protected $refresh = true;

    protected function tearDown(): void
    {
        if ($this->db !== null) {
            $this->db->query('DELETE FROM payments');
            $this->db->query('DELETE FROM billing_sessions');
        }

        parent::tearDown();
    }

    public function testStaffCanViewRentals(): void
    {
        $operatorId = $this->seedOperatorStaff();
        $computerId = $this->insertTableRow('computers', [
            'spec'   => 'Rental PC',
            'tariff' => 10000,
            'status' => 0,
        ]);
        $memberId = $this->insertTableRow('members', [
            'name'         => 'Rental Member',
            'email'        => 'rental@test.com',
            'phone_number' => '0811111111',
            'status'       => 0,
        ]);

        $this->insertTableRow('billing_sessions', [
            'computer_id' => $computerId,
            'customer_id' => $memberId,
            'start_time'  => date('Y-m-d H:i:s'),
            'status'      => 0,
            'operator_id' => $operatorId,
        ]);

        $response = $this->withSession($this->sessionAsStaff('staff@test.com', 0, $operatorId))
            ->get('/rental');

        $response->assertStatus(200);
        $response->assertSee('Rental Member');
    }

    public function testStaffCanStartRental(): void
    {
        $operatorId = $this->seedOperatorStaff();
        $computerId = $this->insertTableRow('computers', [
            'spec'   => 'Available PC',
            'tariff' => 10000,
            'status' => 0,
        ]);
        $memberId = $this->insertTableRow('members', [
            'name'         => 'Test Member',
            'email'        => 'member@test.com',
            'phone_number' => '0822222222',
            'status'       => 0,
        ]);

        $response = $this->withSession($this->sessionAsStaff('staff@test.com', 0, $operatorId))
            ->post('/rental/store', [
                'pcno'      => $computerId,
                'member_id' => $memberId,
            ]);

        $response->assertRedirectTo('/rental');
        $this->seeInDatabase('billing_sessions', [
            'computer_id'  => $computerId,
            'customer_id'  => $memberId,
            'status'       => 0,
            'operator_id'  => $operatorId,
        ]);
        $this->seeInDatabase('computers', [
            'id'     => $computerId,
            'status' => 1,
        ]);
    }

    public function testStaffCanCompletePayment(): void
    {
        $operatorId = $this->seedOperatorStaff();
        $computerId = $this->insertTableRow('computers', [
            'spec'   => 'Payment PC',
            'tariff' => 10000,
            'status' => 1,
        ]);
        $memberId = $this->insertTableRow('members', [
            'name'         => 'Payment Member',
            'email'        => 'payment@test.com',
            'phone_number' => '0833333333',
            'status'       => 0,
        ]);

        $sessionId = $this->insertTableRow('billing_sessions', [
            'computer_id' => $computerId,
            'customer_id' => $memberId,
            'start_time'  => date('Y-m-d H:i:s', strtotime('-2 hours')),
            'end_time'    => date('Y-m-d H:i:s'),
            'status'      => 0,
            'operator_id' => $operatorId,
        ]);

        $response = $this->withSession($this->sessionAsStaff('staff@test.com', 0, $operatorId))
            ->post("/payment/complete/{$sessionId}", [
                'payment_method' => 'cash',
                'operator_id'    => $operatorId,
            ]);

        $response->assertRedirectTo('/rental');
        $this->seeInDatabase('billing_sessions', [
            'id'     => $sessionId,
            'status' => 1,
        ]);
        $this->seeInDatabase('payments', [
            'billing_session_id' => $sessionId,
            'payment_method'     => 'cash',
        ]);
        $this->seeInDatabase('computers', [
            'id'     => $computerId,
            'status' => 0,
        ]);
    }
}
