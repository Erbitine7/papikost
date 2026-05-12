<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
final class GuestWorkflowTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testGuestCanAccessHomePage(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('WAHHHH'); // Content from guesthome view
    }

    // Add more guest-specific tests if any
}