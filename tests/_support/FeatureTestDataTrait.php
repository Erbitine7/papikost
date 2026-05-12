<?php

namespace Tests\Support;

/**
 * Helpers for feature tests: {@see \CodeIgniter\Test\DatabaseTestTrait::hasInDatabase}
 * returns bool, not the new row id — use {@see insertTableRow()} when you need the id.
 */
trait FeatureTestDataTrait
{
    protected function insertTableRow(string $table, array $row): int
    {
        $this->assertTrue($this->hasInDatabase($table, $row));

        return (int) $this->db->insertID();
    }

    /**
     * Session keys used by staff routes. Pass `$staffId` when a controller reads `staff_id`
     * (for example billing `operator_id`).
     */
    protected function sessionAsStaff(string $email, ?int $role = null, ?int $staffId = null): array
    {
        $session = [
            'is_staff_logged_in' => true,
            'staff_email'        => $email,
        ];

        if ($role !== null) {
            $session['staff_role'] = $role;
        }

        if ($staffId !== null) {
            $session['staff_id'] = $staffId;
        }

        return $session;
    }

    protected function seedAdmin(string $email = 'admin@test.com', string $password = 'adminpass'): int
    {
        return $this->insertTableRow('operators', [
            'username'  => 'admin',
            'password'  => password_hash($password, PASSWORD_DEFAULT),
            'full_name' => 'Admin User',
            'email'     => $email,
            'role'      => 0,
            'status'    => 0,
        ]);
    }

    protected function seedOperatorStaff(string $email = 'staff@test.com', string $password = 'password'): int
    {
        return $this->insertTableRow('operators', [
            'username'  => 'teststaff',
            'password'  => password_hash($password, PASSWORD_DEFAULT),
            'full_name' => 'Test Staff',
            'email'     => $email,
            'role'      => 0,
            'status'    => 0,
        ]);
    }

    /** Seeds the default admin and returns a session array including `staff_id`. */
    protected function loggedInAdminSession(string $email = 'admin@test.com', string $password = 'adminpass'): array
    {
        $id = $this->seedAdmin($email, $password);

        return $this->sessionAsStaff($email, 0, $id);
    }
}
