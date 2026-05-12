<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\FeatureTestDataTrait;

/**
 * @internal
 */
final class MemberManagementTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestDataTrait;
    use FeatureTestTrait;

    protected $namespace = null;
    protected $migrate = true;
    protected $refresh = true;

    public function testStaffCanViewMembers(): void
    {
        $staffId = $this->seedOperatorStaff();
        $this->insertTableRow('members', [
            'name'         => 'Test Member',
            'email'        => 'member@test.com',
            'phone_number' => '123456789',
            'status'       => 0,
        ]);

        $response = $this->withSession($this->sessionAsStaff('staff@test.com', 0, $staffId))
            ->get('/member');

        $response->assertStatus(200);
        $response->assertSee('Test Member');
    }

    public function testStaffCanAddMember(): void
    {
        $staffId = $this->seedOperatorStaff();

        $response = $this->withSession($this->sessionAsStaff('staff@test.com', 0, $staffId))
            ->post('/member/store', [
                'name'         => 'New Member',
                'email'        => 'newmember@test.com',
                'phone_number' => '987654321',
            ]);

        $response->assertRedirectTo('/member');
        $this->seeInDatabase('members', [
            'name'  => 'New Member',
            'email' => 'newmember@test.com',
        ]);
    }

    public function testStaffCanEditMember(): void
    {
        $staffId = $this->seedOperatorStaff();
        $memberId = $this->insertTableRow('members', [
            'name'         => 'Old Member',
            'email'        => 'old@test.com',
            'phone_number' => '111111111',
            'status'       => 0,
        ]);

        $response = $this->withSession($this->sessionAsStaff('staff@test.com', 0, $staffId))
            ->post('/member/update', [
                'id'           => $memberId,
                'name'         => 'Updated Member',
                'email'        => 'updated@test.com',
                'phone_number' => '222222222',
            ]);

        $response->assertRedirectTo('/member');
        $this->seeInDatabase('members', [
            'id'    => $memberId,
            'name'  => 'Updated Member',
            'email' => 'updated@test.com',
        ]);
    }

    public function testStaffCanDeleteMember(): void
    {
        $staffId = $this->seedOperatorStaff();
        $memberId = $this->insertTableRow('members', [
            'name'         => 'Member to Delete',
            'email'        => 'delete@test.com',
            'phone_number' => '333333333',
            'status'       => 0,
        ]);

        $response = $this->withSession($this->sessionAsStaff('staff@test.com', 0, $staffId))
            ->post('/member/delete', [
                'id' => $memberId,
            ]);

        $response->assertRedirectTo('/member');
        $this->dontSeeInDatabase('members', [
            'id' => $memberId,
        ]);
    }
}
