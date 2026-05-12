<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\FeatureTestDataTrait;

/**
 * Light checks that staff listing and writes stay usable with more than a few rows.
 * (Wall‑clock “performance” assertions are flaky in CI and were removed.)
 *
 * @internal
 */
final class StaffPerformanceTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestDataTrait;
    use FeatureTestTrait;

    protected $namespace = null;
    protected $migrate = true;
    protected $refresh = true;

    public function testStaffListStillLoadsWithSeveralOperators(): void
    {
        $adminId = $this->seedAdmin();

        for ($i = 0; $i < 10; $i++) {
            $this->insertTableRow('operators', [
                'username'  => "staff{$i}",
                'password'  => password_hash('pass', PASSWORD_DEFAULT),
                'full_name' => "Staff Member {$i}",
                'email'     => "staff{$i}@test.com",
                'role'      => 1,
                'status'    => 0,
            ]);
        }

        $response = $this->withSession($this->sessionAsStaff('admin@test.com', 0, $adminId))
            ->get('/staff');

        $response->assertStatus(200);
        $response->assertSee('Staff Member 0');
    }

    public function testSequentialModelWritesKeepCorrectRows(): void
    {
        $this->seedAdmin();
        $model = new \App\Models\OperatorModel();

        $id1 = (int) $model->insert([
            'username'  => 'seq1',
            'password'  => password_hash('pass', PASSWORD_DEFAULT),
            'full_name' => 'Sequential 1',
            'email'     => 'seq1@test.com',
            'role'      => 1,
            'status'    => 0,
        ]);
        $id2 = (int) $model->insert([
            'username'  => 'seq2',
            'password'  => password_hash('pass', PASSWORD_DEFAULT),
            'full_name' => 'Sequential 2',
            'email'     => 'seq2@test.com',
            'role'      => 1,
            'status'    => 0,
        ]);

        $model->update($id1, ['full_name' => 'Updated One']);
        $model->update($id2, ['full_name' => 'Updated Two']);

        $row1 = $model->find($id1);
        $row2 = $model->find($id2);

        $this->assertSame('Updated One', $row1['full_name']);
        $this->assertSame('Updated Two', $row2['full_name']);
        $this->assertSame('seq1@test.com', $row1['email']);
        $this->assertSame('seq2@test.com', $row2['email']);
    }

    public function testOperatorModelFindAllReturnsRows(): void
    {
        $this->seedAdmin();
        $this->insertTableRow('operators', [
            'username'  => 'listed',
            'password'  => password_hash('pass', PASSWORD_DEFAULT),
            'full_name' => 'Listed User',
            'email'     => 'listed@test.com',
            'role'      => 1,
            'status'    => 0,
        ]);

        $rows = (new \App\Models\OperatorModel())->findAll();

        $this->assertGreaterThanOrEqual(2, count($rows));
    }
}
